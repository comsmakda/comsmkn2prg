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

    public function updateProfile(int $id, array $d): void
    {
        $this->execute(
            "UPDATE users
             SET nama_lengkap = ?, kelas = ?, no_hp = ?, foto = COALESCE(?, foto)
             WHERE id = ?",
            [$d['nama_lengkap'], $d['kelas'], $d['no_hp'], $d['foto'] ?? null, $id]
        );
    }

    public function changePassword(int $id, string $hash): void
    {
        $this->execute(
            "UPDATE users SET password_hash = ? WHERE id = ?",
            [$hash, $id]
        );
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

    public function softDelete(int $id): void
    {
        $this->execute("UPDATE users SET status = 'nonaktif' WHERE id = ?", [$id]);
    }
}
