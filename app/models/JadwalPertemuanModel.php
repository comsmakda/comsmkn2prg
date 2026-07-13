<?php

class JadwalPertemuanModel
{
    private PDO $db;

    private const HARI_MAP = [
        1 => 'senin', 2 => 'selasa', 3 => 'rabu', 4 => 'kamis',
        5 => 'jumat', 6 => 'sabtu', 7 => 'minggu',
    ];

    public const HARI_URUT = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // =====================================================================
    // JADWAL (per hari dalam seminggu)
    // =====================================================================

    public function getAllJadwal(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM jadwal_pertemuan
             ORDER BY FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu','minggu')"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** @return array<string, array> Map hari => baris jadwal (hanya yang aktif) */
    public function getJadwalAktif(): array
    {
        $stmt = $this->db->query("SELECT * FROM jadwal_pertemuan WHERE aktif = 1");
        $map = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $map[$r['hari']] = $r;
        }
        return $map;
    }

    public function upsertJadwal(string $hari, string $jamMulai, string $jamSelesai, bool $aktif, ?string $keterangan): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO jadwal_pertemuan (hari, jam_mulai, jam_selesai, aktif, keterangan)
             VALUES (:hari, :jm, :js, :aktif, :ket)
             ON DUPLICATE KEY UPDATE
                jam_mulai = VALUES(jam_mulai),
                jam_selesai = VALUES(jam_selesai),
                aktif = VALUES(aktif),
                keterangan = VALUES(keterangan)"
        );
        $stmt->execute([
            'hari' => $hari,
            'jm'   => $jamMulai,
            'js'   => $jamSelesai,
            'aktif'=> $aktif ? 1 : 0,
            'ket'  => $keterangan,
        ]);
    }

    // =====================================================================
    // LIBUR MANUAL (override tanggal tertentu)
    // =====================================================================

    public function getAllLibur(): array
    {
        $stmt = $this->db->query("SELECT * FROM hari_libur_pertemuan ORDER BY tanggal DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahLibur(string $tanggal, ?string $keterangan): bool
    {
        $stmt = $this->db->prepare(
            "INSERT IGNORE INTO hari_libur_pertemuan (tanggal, keterangan) VALUES (?, ?)"
        );
        $stmt->execute([$tanggal, $keterangan]);
        return $stmt->rowCount() > 0;
    }

    public function hapusLibur(int $id): void
    {
        $this->db->prepare("DELETE FROM hari_libur_pertemuan WHERE id = ?")->execute([$id]);
    }

    public function getLiburDalamRentang(string $mulai, string $akhir): array
    {
        $stmt = $this->db->prepare(
            "SELECT tanggal FROM hari_libur_pertemuan WHERE tanggal BETWEEN ? AND ?"
        );
        $stmt->execute([$mulai, $akhir]);
        return array_map(fn($t) => (string)$t, $stmt->fetchAll(PDO::FETCH_COLUMN));
    }

    // =====================================================================
    // CEK STATUS TANGGAL
    // =====================================================================

    /**
     * True kalau tanggal tsb adalah hari pertemuan terjadwal (aktif) DAN
     * tidak sedang ditandai libur manual.
     */
    public function isHariPertemuan(string $tanggal): bool
    {
        $dow  = (int) date('N', strtotime($tanggal)); // 1=senin ... 7=minggu
        $hari = self::HARI_MAP[$dow] ?? null;
        if (!$hari) return false;

        $stmt = $this->db->prepare("SELECT aktif FROM jadwal_pertemuan WHERE hari = ? LIMIT 1");
        $stmt->execute([$hari]);
        if (!$stmt->fetchColumn()) return false;

        $stmt2 = $this->db->prepare("SELECT COUNT(*) FROM hari_libur_pertemuan WHERE tanggal = ?");
        $stmt2->execute([$tanggal]);
        return ((int) $stmt2->fetchColumn()) === 0;
    }

    public static function namaHariIndo(string $tanggal): string
    {
        $dow = (int) date('N', strtotime($tanggal));
        return ucfirst(self::HARI_MAP[$dow] ?? '-');
    }
}