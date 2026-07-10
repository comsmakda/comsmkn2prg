<?php
// app/models/UserModel.php

class UserModel extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): array|false
    {
        return $this->fetch(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$email]
        );
    }

    public function findByNia(string $nia): array|false
    {
        return $this->fetch(
            "SELECT * FROM users WHERE nia = ? LIMIT 1",
            [$nia]
        );
    }

    public function find(int $id): array|false
    {
        return $this->fetch(
            "SELECT id, nama_lengkap, email, no_hp, foto, role, status,
                    password_hash, nia, kelas, sumber, tahun_daftar, created_at
             FROM users WHERE id = ? LIMIT 1",
            [$id]
        );
    }

    public function createAnggota(array $d): int
    {
        $this->execute(
            "INSERT INTO users
               (nama_lengkap, kelas, no_hp, email, password_hash, foto, role, status, sumber, tahun_daftar)
             VALUES (?, ?, ?, ?, ?, ?, 'anggota', 'pending', ?, ?)",
            [
                $d['nama_lengkap'],
                $d['kelas'],
                $d['no_hp'],
                $d['email'] ?? null,
                $d['password_hash'],
                $d['foto'] ?? null,
                $d['sumber'],
                $d['tahun_daftar'],
            ]
        );
        return (int)$this->lastId();
    }

    /**
     * Verifikasi & generate NIA otomatis
     */
    public function aktivasi(int $id): string
    {
        $user = $this->find($id);
        if (!$user) throw new RuntimeException('User tidak ditemukan.');

        $tahun = (int)($user['tahun_daftar'] ?? date('Y'));
        $gen   = new NiaGenerator();
        $nia   = $gen->generate($tahun);

        $this->execute(
            "UPDATE users SET nia = ?, status = 'aktif' WHERE id = ?",
            [$nia, $id]
        );
        return $nia;
    }

    /**
     * Update profil — support anggota (nama, kelas, no_hp, foto)
     * maupun admin (+ email).
     * Hanya key yang ada di $d yang di-update.
     */
    public function updateProfile(int $id, array $d): void
    {
        $allowed = ['nama_lengkap', 'kelas', 'no_hp', 'email', 'foto'];
        $fields  = [];
        $params  = [];

        foreach ($allowed as $col) {
            if (array_key_exists($col, $d)) {
                // foto: kalau null gunakan nilai lama (COALESCE)
                if ($col === 'foto') {
                    $fields[]  = "foto = COALESCE(?, foto)";
                } else {
                    $fields[]  = "{$col} = ?";
                }
                $params[] = $d[$col];
            }
        }

        if (empty($fields)) return;

        $params[] = $id;
        $this->execute(
            "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?",
            $params
        );
    }

    /**
     * Ganti password hash (dipakai admin & member).
     */
    public function updatePassword(int $id, string $hash): void
    {
        $this->execute(
            "UPDATE users SET password_hash = ? WHERE id = ?",
            [$hash, $id]
        );
    }

    /**
     * Alias changePassword → updatePassword (agar MemberController tidak perlu diubah).
     */
    public function changePassword(int $id, string $hash): void
    {
        $this->updatePassword($id, $hash);
    }

    /**
     * Invalidate semua sesi aktif user di tabel user_sessions (jika ada).
     * Jika tabel tidak ada, tidak melakukan apa-apa —
     * controller yang bertanggung jawab session_destroy().
     */
    public function invalidateAllSessions(int $userId): void
    {
        $db = Database::getInstance();

        $tableExists = $db->query(
            "SELECT COUNT(*) FROM information_schema.tables
             WHERE table_schema = DATABASE()
               AND table_name = 'user_sessions'"
        )->fetchColumn();

        if ($tableExists) {
            $db->query(
                'DELETE FROM user_sessions WHERE user_id = ?',
                [$userId]
            );
        }
    }

    /** Anggota aktif untuk keperluan absensi/filter */
    public function getAnggotaAktif(array $filter = []): array
    {
        $where  = ["role = 'anggota'", "status = 'aktif'"];
        $params = [];

        if (!empty($filter['kelas'])) {
            $where[]  = "kelas = ?";
            $params[] = $filter['kelas'];
        }
        if (!empty($filter['search'])) {
            $where[]  = "(nama_lengkap LIKE ? OR nia LIKE ?)";
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
        }

        $sql = "SELECT * FROM users WHERE " . implode(' AND ', $where) . " ORDER BY nia";
        return $this->fetchAll($sql, $params);
    }

    /**
     * Ambil SEMUA anggota aktif sesuai filter TANPA pagination — dipakai
     * untuk export (CSV/Excel), supaya export tidak cuma ngambil 1 halaman
     * tabel saja seperti yang ditampilkan di UI. Sama pola-nya dengan
     * getAnggotaAktif(), tapi tambah filter 'sumber' (pab/manual) karena
     * itu juga ada di filter bar halaman anggota.
     */
    public function getAnggotaForExport(array $filter = []): array
    {
        $where  = ["role = 'anggota'", "status = 'aktif'"];
        $params = [];

        if (!empty($filter['kelas'])) {
            $where[]  = "kelas = ?";
            $params[] = $filter['kelas'];
        }
        if (!empty($filter['sumber'])) {
            $where[]  = "sumber = ?";
            $params[] = $filter['sumber'];
        }
        if (!empty($filter['search'])) {
            $where[]  = "(nama_lengkap LIKE ? OR nia LIKE ? OR no_hp LIKE ?)";
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
        }

        $sql = "SELECT nia, nama_lengkap, kelas, no_hp, email, sumber, status, tahun_daftar
                FROM users WHERE " . implode(' AND ', $where) . " ORDER BY nama_lengkap ASC";

        return $this->fetchAll($sql, $params);
    }

    /**
     * Cek apakah email sudah dipakai user lain — dipakai saat IMPORT anggota
     * supaya baris duplikat (email sudah terdaftar) otomatis dilewati.
     */
    public function existsByEmail(string $email): bool
    {
        return (bool) $this->fetch(
            "SELECT id FROM users WHERE email = ? LIMIT 1",
            [$email]
        );
    }

    /**
     * Cek apakah no HP sudah dipakai user lain — dipakai saat IMPORT anggota
     * supaya baris duplikat (No HP sudah terdaftar) otomatis dilewati.
     */
    public function existsByPhone(string $noHp): bool
    {
        return (bool) $this->fetch(
            "SELECT id FROM users WHERE no_hp = ? LIMIT 1",
            [$noHp]
        );
    }

    public function getKelasList(): array
    {
        return $this->fetchAll(
            "SELECT DISTINCT kelas FROM users WHERE role='anggota' AND kelas IS NOT NULL ORDER BY kelas"
        );
    }

    public function getPendingAnggota(): array
    {
        return $this->fetchAll(
            "SELECT * FROM users WHERE role='anggota' AND status='pending' AND sumber='manual' ORDER BY created_at DESC"
        );
    }

    /**
     * @deprecated Tidak lagi dipanggil dari AdminController — diganti hardDelete().
     * Dibiarkan ada untuk kompatibilitas jika masih dipakai di tempat lain.
     */
    public function softDelete(int $id): void
    {
        $this->execute("UPDATE users SET status = 'nonaktif' WHERE id = ?", [$id]);
    }

    /**
     * Hapus anggota secara permanen dari database beserta seluruh data terkait.
     * Tidak ada FK constraint di skema ini (dikonfirmasi lewat information_schema),
     * jadi pembersihan tabel terkait dilakukan manual sebelum menghapus row user.
     *
     * Tabel yang punya kolom user_id (dikonfirmasi via information_schema.COLUMNS):
     * attendance_records, fp_rekap_harian, fp_scan_logs, pab_registrations, user_sessions.
     *
     * Dibungkus transaksi PDO supaya atomik — kalau salah satu DELETE gagal,
     * semua di-rollback dan row user tidak ikut terhapus.
     */
    public function hardDelete(int $id): bool
    {
        $db = Database::getInstance();

        $relatedTables = [
            'attendance_records',
            'fp_rekap_harian',
            'fp_scan_logs',
            'pab_registrations',
            'user_sessions',
        ];

        try {
            $db->beginTransaction();

            foreach ($relatedTables as $table) {
                $stmt = $db->prepare("DELETE FROM {$table} WHERE user_id = ?");
                $stmt->execute([$id]);
            }

            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);

            $db->commit();
            return true;
        } catch (\Throwable $e) {
            $db->rollBack();
            error_log('UserModel::hardDelete gagal: ' . $e->getMessage());
            return false;
        }
    }
}