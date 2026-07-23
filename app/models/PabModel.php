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

    public function getAll(): array
    {
        return $this->fetchAll(
            "SELECT p.*, u.nia FROM pab_registrations p
             LEFT JOIN users u ON u.id = p.user_id
             ORDER BY p.created_at DESC"
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

        // ── Jaring pengaman: pastikan NISN belum dipakai user lain ──
        // Bisa terjadi kalau, sejak siswa ini daftar PAB, NISN yang sama
        // sempat masuk ke tabel users lewat jalur lain (misal siswa lain
        // mengisi NISN yang sama via edit profil, atau ada dua pendaftaran
        // PAB dengan NISN sama yang lolos race condition saat submit).
        // Tanpa cek ini, insert di bawah akan gagal dengan PDOException
        // mentah (unique key uniq_users_nisn) yang tidak tertangani.
        if (!empty($reg['nisn']) && $userModel->existsByNisn($reg['nisn'])) {
            throw new RuntimeException(
                'NISN ' . $reg['nisn'] . ' sudah dipakai akun lain. Tidak bisa diapprove — periksa data terlebih dahulu.'
            );
        }

        $userId = $userModel->createAnggota([
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