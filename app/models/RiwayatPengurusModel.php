<?php
// app/models/RiwayatPengurusModel.php

class RiwayatPengurusModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /* ── Ambil semua berdasar tipe, diurutkan urutan ASC, tahun_dari DESC ── */
    public function getByTipe(string $tipe): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM riwayat_pengurus
             WHERE tipe = ?
             ORDER BY urutan ASC, tahun_dari DESC, id DESC"
        );
        $stmt->execute([$tipe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── Ambil semua (untuk halaman admin) ── */
    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM riwayat_pengurus
             ORDER BY tipe ASC, urutan ASC, tahun_dari DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── Find by ID ── */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM riwayat_pengurus WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /* ── Buat baru ── */
    public function create(array $d): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO riwayat_pengurus
               (tipe, nama, jabatan, periode, tahun_dari, tahun_sampai, foto, catatan, urutan)
             VALUES
               (:tipe, :nama, :jabatan, :periode, :tahun_dari, :tahun_sampai, :foto, :catatan, :urutan)"
        );
        $stmt->execute([
            ':tipe'         => $d['tipe']         ?? 'ketua',
            ':nama'         => $d['nama']          ?? '',
            ':jabatan'      => $d['jabatan']       ?? 'Ketua Umum',
            ':periode'      => $d['periode']       ?? '',
            ':tahun_dari'   => $d['tahun_dari']    ?: null,
            ':tahun_sampai' => $d['tahun_sampai']  ?: null,
            ':foto'         => $d['foto']          ?? null,
            ':catatan'      => $d['catatan']       ?? '',
            ':urutan'       => (int)($d['urutan']  ?? 0),
        ]);
        return (int)$this->db->lastInsertId();
    }

    /* ── Update ── */
    public function update(int $id, array $d): void
    {
        $stmt = $this->db->prepare(
            "UPDATE riwayat_pengurus SET
               tipe         = :tipe,
               nama         = :nama,
               jabatan      = :jabatan,
               periode      = :periode,
               tahun_dari   = :tahun_dari,
               tahun_sampai = :tahun_sampai,
               foto         = :foto,
               catatan      = :catatan,
               urutan       = :urutan
             WHERE id = :id"
        );
        $stmt->execute([
            ':tipe'         => $d['tipe']         ?? 'ketua',
            ':nama'         => $d['nama']          ?? '',
            ':jabatan'      => $d['jabatan']       ?? 'Ketua Umum',
            ':periode'      => $d['periode']       ?? '',
            ':tahun_dari'   => $d['tahun_dari']    ?: null,
            ':tahun_sampai' => $d['tahun_sampai']  ?: null,
            ':foto'         => $d['foto']          ?? null,
            ':catatan'      => $d['catatan']       ?? '',
            ':urutan'       => (int)($d['urutan']  ?? 0),
            ':id'           => $id,
        ]);
    }

    /* ── Hapus ── */
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM riwayat_pengurus WHERE id = ?");
        $stmt->execute([$id]);
    }
}