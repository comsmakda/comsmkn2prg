<?php
// app/models/PabModel.php

class PabModel extends Model
{
    protected string $table = 'pab_registrations';

    public function create(array $d): int
    {
        $this->execute(
            "INSERT INTO pab_registrations
               (nisn, nama_lengkap, kelas, no_hp, password_hash, foto)
             VALUES (?, ?, ?, ?, ?, ?)",
            [
                $d['nisn'],
                $d['nama_lengkap'],
                $d['kelas'],
                $d['no_hp'],
                $d['password_hash'],
                $d['foto'] ?? null,
            ]
        );
        return (int)$this->lastId();
    }

    /**
     * Cari pendaftaran berdasarkan NISN (untuk cek duplikasi sebelum insert).
     */
    public function findByNisn(string $nisn): ?array
    {
        $rows = $this->fetchAll(
            "SELECT * FROM pab_registrations WHERE nisn = ? LIMIT 1",
            [$nisn]
        );
        return $rows[0] ?? null;
    }

    /**
     * Cek status pendaftaran PAB berdasarkan NISN — dipakai halaman publik
     * "cek status" yang tidak butuh login.
     *
     * PENTING: dicek DUA lapis, bukan cuma ke pab_registrations.
     *
     * 1) Tabel `users` dicek LEBIH DULU. Ini sumber kebenaran untuk anggota
     *    yang statusnya sudah aktif — termasuk kasus di mana baris
     *    pab_registrations terkait sudah tidak ada lagi (misalnya sudah
     *    dihapus admin dari daftar PAB setelah diproses, atau NISN
     *    di-backfill manual lewat edit profil anggota). Tanpa lapis ini,
     *    anggota yang NISN-nya sudah terdaftar & aktif bisa muncul
     *    "tidak ditemukan" walau sebenarnya sudah di-ACC — inilah bug yang
     *    dilaporkan sebelumnya.
     *
     * 2) Kalau tidak ketemu di `users`, baru dicek riwayat pendaftaran di
     *    pab_registrations (mencakup status pending/rejected/approved).
     *    ORDER BY created_at DESC + LIMIT 1 supaya kalau ada lebih dari
     *    satu baris riwayat, yang paling baru yang ditampilkan.
     */
    public function findByNisnWithNia(string $nisn): ?array
    {
        // 1) Cek ke tabel users (anggota aktif)
        $user = $this->fetch(
            "SELECT nama_lengkap, kelas, nia FROM users WHERE nisn = ? LIMIT 1",
            [$nisn]
        );

        if ($user) {
            return [
                'status'        => 'approved',
                'nama_lengkap'  => $user['nama_lengkap'],
                'kelas'         => $user['kelas'],
                'nia'           => $user['nia'],
                'catatan_admin' => null,
            ];
        }

        // 2) Fallback: cek riwayat pendaftaran PAB
        $rows = $this->fetchAll(
            "SELECT p.*, u.nia FROM pab_registrations p
             LEFT JOIN users u ON u.id = p.user_id
             WHERE p.nisn = ?
             ORDER BY p.created_at DESC
             LIMIT 1",
            [$nisn]
        );

        return $rows[0] ?? null;
    }

    /**
     * Dipakai saat siswa yang sebelumnya ditolak ('rejected') daftar ulang
     * dengan NISN yang sama — menimpa baris lama alih-alih insert baru,
     * supaya unique key nisn tidak bentrok.
     */
    public function resubmit(int $id, array $d): void
    {
        $this->execute(
            "UPDATE pab_registrations
             SET nisn=?, nama_lengkap=?, kelas=?, no_hp=?, password_hash=?, foto=?,
                 status='pending', catatan_admin=NULL, user_id=NULL,
                 updated_at=CURRENT_TIMESTAMP
             WHERE id=?",
            [
                $d['nisn'],
                $d['nama_lengkap'],
                $d['kelas'],
                $d['no_hp'],
                $d['password_hash'],
                $d['foto'] ?? null,
                $id,
            ]
        );
    }

    public function getPending(): array
    {
        return $this->fetchAll(
            "SELECT * FROM pab_registrations WHERE status = 'pending' ORDER BY created_at DESC"
        );
    }

    /**
     * Daftar semua pendaftar PAB, dengan dukungan filter opsional:
     *   - status : 'pending' | 'approved' | 'rejected'
     *   - kelas  : exact match kelas
     *   - search : cocok ke nama_lengkap ATAU nisn (LIKE)
     */
    public function getAll(array $filter = []): array
    {
        $sql    = "SELECT p.*, u.nia FROM pab_registrations p
                   LEFT JOIN users u ON u.id = p.user_id
                   WHERE 1=1";
        $params = [];

        $status = trim($filter['status'] ?? '');
        if ($status !== '' && in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $sql .= " AND p.status = ?";
            $params[] = $status;
        }

        $kelas = trim($filter['kelas'] ?? '');
        if ($kelas !== '') {
            $sql .= " AND p.kelas = ?";
            $params[] = $kelas;
        }

        $search = trim($filter['search'] ?? '');
        if ($search !== '') {
            $sql .= " AND (p.nama_lengkap LIKE ? OR p.nisn LIKE ?)";
            $like = '%' . $search . '%';
            $params[] = $like;
            $params[] = $like;
        }

        $sql .= " ORDER BY p.created_at DESC";

        return $this->fetchAll($sql, $params);
    }

    /**
     * Daftar kelas unik dari pendaftar PAB, dipakai untuk dropdown filter.
     */
    public function getKelasList(): array
    {
        $rows = $this->fetchAll(
            "SELECT DISTINCT kelas FROM pab_registrations WHERE kelas IS NOT NULL AND kelas <> '' ORDER BY kelas ASC"
        );
        return array_column($rows, 'kelas');
    }

    /**
     * Hapus baris pendaftaran PAB secara permanen.
     * Tidak menghapus akun users terkait (kalau sudah approved) — hanya
     * menghapus record pendaftarannya saja. Penghapusan file foto fisik
     * ditangani di controller agar model tetap bebas dari filesystem I/O.
     */
    public function delete(int $id): bool
    {
        return (bool)$this->execute(
            "DELETE FROM pab_registrations WHERE id = ?",
            [$id]
        );
    }

    /**
     * Approve: buat user aktif + generate NIA
     */
    public function approve(int $pabId): string
    {
        $reg = $this->find($pabId);
        if (!$reg) throw new RuntimeException('Data PAB tidak ditemukan.');
        if ($reg['status'] !== 'pending') throw new RuntimeException('Pendaftar sudah diproses.');

        $userModel = new UserModel();
        $userId    = $userModel->createAnggota([
            'nisn'          => $reg['nisn'],
            'nama_lengkap'  => $reg['nama_lengkap'],
            'kelas'         => $reg['kelas'],
            'no_hp'         => $reg['no_hp'],
            'password_hash' => $reg['password_hash'],
            'foto'          => $reg['foto'],
            'sumber'        => 'pab',
            'tahun_daftar'  => date('Y'),
        ]);

        // Langsung aktivasi (generate NIA)
        $nia = $userModel->aktivasi($userId);

        $this->execute(
            "UPDATE pab_registrations SET status='approved', user_id=? WHERE id=?",
            [$userId, $pabId]
        );

        return $nia;
    }

    public function reject(int $pabId, string $catatan = ''): void
    {
        $this->execute(
            "UPDATE pab_registrations SET status='rejected', catatan_admin=? WHERE id=?",
            [$catatan, $pabId]
        );
    }
}