"""
Sync Agent - Jembatan antara Web App (PHP) dan Mesin Fingerprint GEISA X107
============================================================================
Deploy sebagai container terpisah di Coolify, satu Docker network dengan
app PHP comsmkn2pinrang, sehingga tidak perlu expose port ke publik.

Protokol ke mesin: TCP port 4370, pakai library pyzk (protokol ZKTeco).
X107 adalah OEM device yang umumnya kompatibel dengan protokol ini.
Kalau connect gagal, berarti perlu SDK resmi dari vendor (solution.co.id).

ENV yang dibutuhkan (lihat .env.example):
  DEVICE_IP        - IP mesin X107 di LAN sekolah
  DEVICE_PORT       - default 4370
  PHP_APP_CALLBACK_URL - endpoint PHP untuk terima hasil pull log
  PHP_APP_API_KEY  - shared secret untuk autentikasi internal (mirip SSO surat app)
"""

import os
import logging
from datetime import datetime
from typing import Optional

from fastapi import FastAPI, HTTPException, Header
from pydantic import BaseModel
from zk import ZK, const
import httpx
from apscheduler.schedulers.background import BackgroundScheduler

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger("fp-sync-agent")

DEVICE_IP = os.getenv("DEVICE_IP", "192.168.1.201")
DEVICE_PORT = int(os.getenv("DEVICE_PORT", "4370"))
PHP_APP_CALLBACK_URL = os.getenv("PHP_APP_CALLBACK_URL", "")
PHP_APP_API_KEY = os.getenv("PHP_APP_API_KEY", "")
PULL_LOG_INTERVAL_MINUTES = int(os.getenv("PULL_LOG_INTERVAL_MINUTES", "15"))

app = FastAPI(title="FP Sync Agent - GEISA X107")


def get_connection():
    """Buka koneksi ke mesin. Selalu pakai context manager / disconnect manual."""
    zk = ZK(DEVICE_IP, port=DEVICE_PORT, timeout=10, password=0, force_udp=False, ommit_ping=False)
    try:
        conn = zk.connect()
        return conn
    except Exception as e:
        logger.error(f"Gagal konek ke mesin {DEVICE_IP}:{DEVICE_PORT} - {e}")
        raise HTTPException(status_code=502, detail=f"Tidak bisa konek ke mesin: {e}")


def check_auth(x_api_key: Optional[str]):
    if not PHP_APP_API_KEY:
        return  # auth belum diaktifkan, dev mode
    if x_api_key != PHP_APP_API_KEY:
        raise HTTPException(status_code=401, detail="API key tidak valid")


# --------------------------------------------------------------------------
# Model request/response
# --------------------------------------------------------------------------
class PushUserRequest(BaseModel):
    nia: str          # dipakai sebagai user_id di mesin
    nama_lengkap: str
    privilege: int = 0  # 0 = user biasa, 14 = admin mesin


class DeleteUserRequest(BaseModel):
    nia: str


# --------------------------------------------------------------------------
# Endpoints
# --------------------------------------------------------------------------

@app.get("/health")
def health():
    """Cek status koneksi ke mesin, dipakai untuk indikator di halaman admin."""
    try:
        conn = get_connection()
        info = {
            "connected": True,
            "device_ip": DEVICE_IP,
            "firmware_version": conn.get_firmware_version(),
            "serial_number": conn.get_serialnumber(),
            "user_count": len(conn.get_users()),
        }
        conn.disconnect()
        return info
    except HTTPException:
        return {"connected": False, "device_ip": DEVICE_IP}


@app.post("/users")
def push_user(payload: PushUserRequest, x_api_key: Optional[str] = Header(None)):
    """
    Push satu anggota ke mesin. Dipanggil PHP saat:
    - Anggota baru disetujui (dari PAB atau tambah manual)
    - Data anggota diedit (nama berubah, dll)

    user_id di mesin = nia anggota. Fingerprint TIDAK didaftarkan lewat sini
    (harus tap langsung di mesin fisik) - endpoint ini cuma daftarkan
    identitas + slot, supaya saat anggota tempel jari di mesin, sistem sudah
    kenal nama & ID-nya.
    """
    check_auth(x_api_key)
    conn = get_connection()
    try:
        conn.disable_device()
        # uid dibiarkan auto oleh mesin, user_id (string) yang jadi acuan utama = nia
        conn.set_user(
            uid=0,
            name=payload.nama_lengkap[:24],  # banyak device fingerprint batasi 24 char
            privilege=payload.privilege,
            password="",
            group_id="",
            user_id=payload.nia,
        )
        conn.enable_device()
        return {"success": True, "nia": payload.nia, "message": "User berhasil didaftarkan ke mesin"}
    except Exception as e:
        conn.enable_device()
        logger.error(f"Gagal push user {payload.nia}: {e}")
        raise HTTPException(status_code=500, detail=str(e))
    finally:
        conn.disconnect()


@app.delete("/users/{nia}")
def delete_user(nia: str, x_api_key: Optional[str] = Header(None)):
    """Hapus anggota dari mesin, misal saat status jadi nonaktif/keluar."""
    check_auth(x_api_key)
    conn = get_connection()
    try:
        conn.disable_device()
        users = conn.get_users()
        target = next((u for u in users if u.user_id == nia), None)
        if not target:
            raise HTTPException(status_code=404, detail="User tidak ditemukan di mesin")
        conn.delete_user(uid=target.uid)
        conn.enable_device()
        return {"success": True, "nia": nia, "message": "User dihapus dari mesin"}
    except HTTPException:
        conn.enable_device()
        raise
    except Exception as e:
        conn.enable_device()
        logger.error(f"Gagal hapus user {nia}: {e}")
        raise HTTPException(status_code=500, detail=str(e))
    finally:
        conn.disconnect()


@app.get("/logs")
def pull_logs(x_api_key: Optional[str] = Header(None)):
    """
    Tarik semua log transaksi (scan) dari mesin.
    Dipanggil manual dari halaman admin, ATAU otomatis lewat scheduler di bawah.
    Tidak menghapus log di mesin (aman dipanggil berulang, PHP yang filter duplikat
    lewat UNIQUE KEY di fp_scan_logs).
    """
    check_auth(x_api_key)
    conn = get_connection()
    try:
        conn.disable_device()
        attendances = conn.get_attendance()
        serial = conn.get_serialnumber()
        logs = [
            {
                "nia": str(a.user_id),
                "waktu_scan": a.timestamp.strftime("%Y-%m-%d %H:%M:%S"),
                "tipe_scan": a.status,
                "device_sn": serial,
            }
            for a in attendances
        ]
        conn.enable_device()
        return {"success": True, "count": len(logs), "logs": logs}
    except Exception as e:
        conn.enable_device()
        logger.error(f"Gagal tarik log: {e}")
        raise HTTPException(status_code=500, detail=str(e))
    finally:
        conn.disconnect()


# --------------------------------------------------------------------------
# Scheduler otomatis - tarik log tiap N menit, kirim ke PHP app
# --------------------------------------------------------------------------
def scheduled_pull_and_push():
    if not PHP_APP_CALLBACK_URL:
        logger.warning("PHP_APP_CALLBACK_URL belum diset, skip auto-sync")
        return
    try:
        result = pull_logs(x_api_key=PHP_APP_API_KEY)
        if result["count"] == 0:
            return
        resp = httpx.post(
            PHP_APP_CALLBACK_URL,
            json={"logs": result["logs"]},
            headers={"X-Api-Key": PHP_APP_API_KEY},
            timeout=30,
        )
        logger.info(f"Auto-sync: {result['count']} log dikirim ke PHP, response {resp.status_code}")
    except Exception as e:
        logger.error(f"Auto-sync gagal: {e}")


scheduler = BackgroundScheduler()
scheduler.add_job(scheduled_pull_and_push, "interval", minutes=PULL_LOG_INTERVAL_MINUTES)


@app.on_event("startup")
def start_scheduler():
    scheduler.start()
    logger.info(f"Scheduler aktif, tarik log tiap {PULL_LOG_INTERVAL_MINUTES} menit")


@app.on_event("shutdown")
def stop_scheduler():
    scheduler.shutdown()
