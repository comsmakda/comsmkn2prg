<?php
// app/models/PabModel.php

class PabModel extends Model
{
    protected string $table = 'pab_registrations';

    public function create(array $d): int
    {
        $this->execute(
            "INSERT INTO pab_registrations
               (nama_lengkap, kelas, no_hp, password_hash, foto)
             VALUES (?, ?, ?, ?, ?)",
            [
                $d['nama_lengkap'],
                $d['kelas'],
                $d['no_hp'],
                $d['password_hash'],
                $d['foto'] ?? null,
            ]
        );
        return (int)$this->lastId();
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
        $userId    = $userModel->createAnggota([
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
