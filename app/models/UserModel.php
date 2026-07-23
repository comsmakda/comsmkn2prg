<?php
// app/models/UserModel.php

class UserModel extends Model
{
    protected string $table = 'users';

    /**
     * Daftar jabatan struktural organisasi (terpisah dari `role` yang
     * hanya membedakan anggota/admin). Key disimpan di kolom `jabatan`,
     * value adalah label tampilan.
     */
    public const JABATAN_LIST = [
        'anggota'                   => 'Anggota',
        'ketua_umum'                => 'Ketua Umum',
        'wakil_ketua'               => 'Wakil Ketua',
        'bendahara'                 => 'Bendahara',
        'wakil_bendahara'           => 'Wakil Bendahara',
        'sekretaris'                => 'Sekretaris',
        'wakil_sekretaris'          => 'Wakil Sekretaris',
        'koordinator_humas'         => 'Koordinator Humas',
        'koordinator_perlengkapan'  => 'Koordinator Perlengkapan',
        'koordinator_pdd'           => 'Koordinator PDD',
        'ketua_bidang_it_software'  => 'Ketua Bidang IT Software',
        'ketua_bidang_it_network'   => 'Ketua Bidang IT Network',
        'ketua_bidang_multimedia'   => 'Ketua Bidang Multimedia & Desain Grafis',
        'ketua_bidang_iot_robotic'  => 'Ketua Bidang IoT & Robotic',
    ];

    public static function getJabatanList(): array
    {
        return self::JABATAN_LIST;
    }

    public static function jabatanLabel(?string $key): string
    {
        return self::JABATAN_LIST[$key] ?? 'Anggota';
    }

    /**
     * Ambil semua pengurus (jabatan != 'anggota') yang statusnya aktif,
     * dikelompokkan per key jabatan.
     *
     * Aturan filter:
     * - is_super_admin = 0  → admin utama TIDAK PERNAH tampil di struktur publik.
     * - nia IS NOT NULL     → HANYA akun yang sudah punya NIA (sudah lewat proses
     *   aktivasi anggota) yang ditampilkan. Akun tanpa NIA dianggap akun teknis
     *   (admin/operator yang dibuat manual tanpa proses aktivasi), jadi disembunyikan
     *   dari struktur publik — berlaku untuk role apapun, bukan cuma role admin.
     *
     * @return array<string, array> key = jabatan, value = list user pada jabatan itu
     */
    public function getStrukturOrganisasi(): array
    {
        $jabatanAktif = array_keys(self::JABATAN_LIST);
        $jabatanAktif = array_values(array_filter($jabatanAktif, fn($k) => $k !== 'anggota'));

        if (empty($jabatanAktif)) return [];

        $in   = implode(',', array_fill(0, count($jabatanAktif), '?'));
        $rows = $this->fetchAll(
            "SELECT nama_lengkap, foto, jabatan, kelas
             FROM users
             WHERE status = 'aktif'
               AND is_super_admin = 0
               AND nia IS NOT NULL
               AND jabatan IN ($in)
             ORDER BY nama_lengkap ASC",
            $jabatanAktif
        );

        $grouped = array_fill_keys($jabatanAktif, []);
        foreach ($rows as $r) {
            $grouped[$r['jabatan']][] = $r;
        }
        return $grouped;
    }

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

    /**
     * Cari user berdasarkan NISN — dipakai untuk cek duplikasi saat
     * pendaftaran PAB (mencegah satu NISN terdaftar dua kali sebagai anggota).
     */
    public function findByNisn(string $nisn): array|false
    {
        return $this->fetch(
            "SELECT * FROM users WHERE nisn = ? LIMIT 1",
            [$nisn]
        );
    }

    public function find(int $id): array|false
    {
        return $this->fetch(
            "SELECT id, nia, nisn, nama_lengkap, email, no_hp, foto, role, jabatan, status, is_super_admin,
                    password_hash, kelas, sumber, tahun_daftar, created_at
             FROM users WHERE id = ? LIMIT 1",
            [$id]
        );
    }

    public function createAnggota(array $d): int
    {
        $jabatan = array_key_exists($d['jabatan'] ?? null, self::JABATAN_LIST)
            ? $d['jabatan']
            : 'anggota';

        $this->execute(
            "INSERT INTO users
               (nisn, nama_lengkap, kelas, no_hp, email, password_hash, foto, role, jabatan, status, sumber, tahun_daftar)
             VALUES (?, ?, ?, ?, ?, ?, ?, 'anggota', ?, 'pending', ?, ?)",
            [
                $d['nisn'] ?? null,
                $d['nama_lengkap'],
                $d['kelas'],
                $d['no_hp'],
                $d['email'] ?? null,
                $d['password_hash'],
                $d['foto'] ?? null,
                $jabatan,
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
     * Update profil — support anggota (nama, kelas, no_hp, foto, jabatan, nisn)
     * maupun admin (+ email).
     * Hanya key yang ada di $d yang di-update.
     * 'nisn' sengaja dimasukkan ke sini supaya admin bisa backfill NISN
     * anggota lama lewat form edit profil, tanpa perlu endpoint terpisah.
     */
    public function updateProfile(int $id, array $d): void
    {
        $allowed = ['nama_lengkap', 'kelas', 'no_hp', 'email', 'foto', 'jabatan', 'nisn'];
        $fields  = [];
        $params  = [];

        foreach ($allowed as $col) {
            if (array_key_exists($col, $d)) {
                if ($col === 'foto') {
                    // foto: kalau null gunakan nilai lama (COALESCE)
                    $fields[]  = "foto = COALESCE(?, foto)";
                    $params[]  = $d[$col];
                } elseif ($col === 'jabatan') {
                    // pastikan hanya value valid yang masuk
                    $fields[]  = "jabatan = ?";
                    $params[]  = array_key_exists($d['jabatan'], self::JABATAN_LIST) ? $d['jabatan'] : 'anggota';
                } elseif ($col === 'nisn') {
                    // simpan NULL kalau dikirim string kosong, bukan '' (biar tidak bentrok unique index)
                    $fields[]  = "nisn = ?";
                    $params[]  = ($d['nisn'] === '' || $d['nisn'] === null) ? null : $d['nisn'];
                } else {
                    $fields[]  = "{$col} = ?";
                    $params[]  = $d[$col];
                }
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

    /**
     * Anggota aktif untuk keperluan tabel admin/absensi/filter.
     * Pencarian ('search') mencakup nama, NIA, NISN, dan No HP —
     * supaya admin bisa cari anggota pakai NISN juga, bukan cuma nama/NIA.
     */
    public function getAnggotaAktif(array $filter = []): array
    {
        $where  = ["role = 'anggota'", "status = 'aktif'"];
        $params = [];

        if (!empty($filter['kelas'])) {
            $where[]  = "kelas = ?";
            $params[] = $filter['kelas'];
        }
        if (!empty($filter['jabatan'])) {
            $where[]  = "jabatan = ?";
            $params[] = $filter['jabatan'];
        }
        if (!empty($filter['search'])) {
            $where[]  = "(nama_lengkap LIKE ? OR nia LIKE ? OR nisn LIKE ? OR no_hp LIKE ?)";
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
        }

        $sql = "SELECT * FROM users WHERE " . implode(' AND ', $where) . " ORDER BY nia";
        return $this->fetchAll($sql, $params);
    }

    /**
     * Ambil SEMUA anggota aktif sesuai filter TANPA pagination — dipakai
     * untuk export (CSV/Excel), supaya export tidak cuma ngambil 1 halaman
     * tabel saja seperti yang ditampilkan di UI.
     *
     * Kolom 'sumber' sudah tidak ditampilkan/difilter lagi di UI anggota
     * (diganti NISN), jadi tidak lagi dimasukkan ke SELECT export.
     * Filter 'sumber' di bawah dibiarkan ada (tidak dihapus paksa) supaya
     * tetap kompatibel jika suatu saat dipanggil dari tempat lain, tapi
     * AdminController::anggotaExport() saat ini tidak mengirim filter itu lagi.
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
        if (!empty($filter['jabatan'])) {
            $where[]  = "jabatan = ?";
            $params[] = $filter['jabatan'];
        }
        if (!empty($filter['search'])) {
            $where[]  = "(nama_lengkap LIKE ? OR nia LIKE ? OR no_hp LIKE ? OR nisn LIKE ?)";
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
            $params[] = '%' . $filter['search'] . '%';
        }

        $sql = "SELECT nia, nisn, nama_lengkap, kelas, no_hp, email, jabatan, status, tahun_daftar
                FROM users WHERE " . implode(' AND ', $where) . " ORDER BY nama_lengkap ASC";

        return $this->fetchAll($sql, $params);
    }

    /**
     * Anggota BIASA untuk grid publik "Daftar Anggota" — sengaja difilter
     * jabatan = 'anggota' (bukan role) supaya pengurus yang sudah tampil
     * di struktur organisasi tidak dobel muncul. nia IS NOT NULL memastikan
     * akun admin/operator tanpa NIA tidak ikut tampil ke publik.
     */
    public function getAnggotaPublik(array $filter = []): array
    {
        $where  = ["status = 'aktif'", "jabatan = 'anggota'", "nia IS NOT NULL"];
        $params = [];

        if (!empty($filter['kelas'])) {
            $where[]  = "kelas = ?";
            $params[] = $filter['kelas'];
        }
        if (!empty($filter['search'])) {
            $where[]  = "nama_lengkap LIKE ?";
            $params[] = '%' . $filter['search'] . '%';
        }

        $sql = "SELECT nama_lengkap, kelas, foto, jabatan
                FROM users WHERE " . implode(' AND ', $where) . "
                ORDER BY kelas ASC, nama_lengkap ASC";

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

    /**
     * Cek apakah NISN sudah dipakai user lain — dipakai saat IMPORT anggota
     * manual maupun approve PAB, atau saat TAMBAH anggota baru,
     * supaya baris/entri duplikat otomatis dilewati/ditolak.
     */
    public function existsByNisn(string $nisn): bool
    {
        return (bool) $this->fetch(
            "SELECT id FROM users WHERE nisn = ? LIMIT 1",
            [$nisn]
        );
    }

    /**
     * Cek apakah NISN sudah dipakai user LAIN (bukan dirinya sendiri) —
     * dipakai saat UPDATE profil anggota (form edit) supaya anggota
     * tidak salah dianggap "duplikat dengan dirinya sendiri" ketika
     * NISN yang dikirim di form memang sudah menjadi miliknya dari awal.
     */
    public function existsByNisnExcept(string $nisn, int $exceptId): bool
    {
        return (bool) $this->fetch(
            "SELECT id FROM users WHERE nisn = ? AND id != ? LIMIT 1",
            [$nisn, $exceptId]
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

    // ================================================================
    //  KELOLA ADMIN (promosi/demosi, khusus dipanggil oleh admin utama)
    // ================================================================

    /**
     * Anggota aktif yang bisa dipromosikan jadi admin.
     */
    public function getEligibleForAdmin(): array
    {
        return $this->fetchAll(
            "SELECT id, nama_lengkap, email, kelas, nia
             FROM users
             WHERE role = 'anggota' AND status = 'aktif'
             ORDER BY nama_lengkap ASC"
        );
    }

    /**
     * Daftar admin. Secara default admin utama (is_super_admin = 1)
     * disembunyikan dari daftar ini.
     */
    public function getAdminList(bool $hideSuperAdmin = true): array
    {
        $sql = "SELECT id, nama_lengkap, email, nia, is_super_admin, created_at
                FROM users WHERE role = 'admin'";
        if ($hideSuperAdmin) {
            $sql .= " AND is_super_admin = 0";
        }
        $sql .= " ORDER BY nama_lengkap ASC";

        return $this->fetchAll($sql);
    }

    public function isSuperAdmin(int $id): bool
    {
        $row = $this->fetch(
            "SELECT is_super_admin FROM users WHERE id = ? LIMIT 1",
            [$id]
        );
        return $row ? (bool)$row['is_super_admin'] : false;
    }

    /**
     * Naikkan anggota (role='anggota') menjadi admin biasa (is_super_admin tetap 0).
     */
    public function promoteToAdmin(int $id): bool
    {
        return (bool) $this->execute(
            "UPDATE users SET role = 'admin' WHERE id = ? AND role = 'anggota'",
            [$id]
        );
    }

    /**
     * Turunkan admin biasa kembali jadi anggota.
     * is_super_admin = 0 di WHERE = pengaman, admin utama tidak bisa
     * ke-demote lewat method ini walau id-nya "salah" dipanggil.
     */
    public function demoteToAnggota(int $id): bool
    {
        return (bool) $this->execute(
            "UPDATE users SET role = 'anggota' WHERE id = ? AND role = 'admin' AND is_super_admin = 0",
            [$id]
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