<?php
// app/models/GaleriModel.php

class GaleriModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function makeSlug(string $judul, int $excludeId = 0): string {
        $base = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $judul), '-'));
        $slug = $base;
        $i    = 1;
        while (true) {
            $q = $this->db->prepare('SELECT id FROM galeri_album WHERE slug = ? AND id != ?');
            $q->execute([$slug, $excludeId]);
            if (!$q->fetch()) break;
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    /* ── ALBUM ── */
    public function createAlbum(array $d): int {
        $q = $this->db->prepare('INSERT INTO galeri_album (judul,slug,deskripsi,cover,status,urutan,created_by) VALUES (?,?,?,?,?,?,?)');
        $q->execute([
            $d['judul'],
            $this->makeSlug($d['judul']),
            $d['deskripsi'] ?? null,
            $d['cover'] ?? null,
            $d['status'] ?? 'published',
            $d['urutan'] ?? 0,
            $d['created_by'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function updateAlbum(int $id, array $d): void {
        $q = $this->db->prepare('UPDATE galeri_album SET judul=?,slug=?,deskripsi=?,cover=?,status=?,urutan=? WHERE id=?');
        $q->execute([
            $d['judul'],
            $this->makeSlug($d['judul'], $id),
            $d['deskripsi'] ?? null,
            $d['cover'] ?? null,
            $d['status'] ?? 'published',
            $d['urutan'] ?? 0,
            $id,
        ]);
    }

    public function deleteAlbum(int $id): void {
        $this->db->prepare('DELETE FROM galeri_album WHERE id=?')->execute([$id]);
    }

    public function findAlbumById(int $id): ?array {
        $q = $this->db->prepare('SELECT * FROM galeri_album WHERE id=?');
        $q->execute([$id]);
        return $q->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findAlbumBySlug(string $slug): ?array {
        $q = $this->db->prepare('SELECT * FROM galeri_album WHERE slug=? AND status="published"');
        $q->execute([$slug]);
        return $q->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getPublishedAlbums(int $page = 1, int $limit = 12): array {
        $offset = ($page - 1) * $limit;
        $q = $this->db->prepare("
            SELECT a.*, (SELECT COUNT(*) FROM galeri_foto WHERE album_id=a.id) AS jumlah_foto,
                   (SELECT file FROM galeri_foto WHERE album_id=a.id ORDER BY urutan,id LIMIT 1) AS first_foto
            FROM galeri_album a
            WHERE a.status='published'
            ORDER BY a.urutan ASC, a.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $q->execute([$limit, $offset]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPublishedAlbums(): int {
        return (int)$this->db->query('SELECT COUNT(*) FROM galeri_album WHERE status="published"')->fetchColumn();
    }

    public function getAllAlbums(int $page = 1, int $limit = 15): array {
        $offset = ($page - 1) * $limit;
        $q = $this->db->prepare("
            SELECT a.*, (SELECT COUNT(*) FROM galeri_foto WHERE album_id=a.id) AS jumlah_foto
            FROM galeri_album a ORDER BY a.created_at DESC LIMIT ? OFFSET ?
        ");
        $q->execute([$limit, $offset]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllAlbums(): int {
        return (int)$this->db->query('SELECT COUNT(*) FROM galeri_album')->fetchColumn();
    }

    /* ── FOTO ── */
    public function addFoto(int $albumId, string $file, ?string $judul = null, int $urutan = 0): int {
        $q = $this->db->prepare('INSERT INTO galeri_foto (album_id,judul,file,urutan) VALUES (?,?,?,?)');
        $q->execute([$albumId, $judul, $file, $urutan]);
        $al = $this->findAlbumById($albumId);
        if ($al && empty($al['cover'])) {
            $this->db->prepare('UPDATE galeri_album SET cover=? WHERE id=?')->execute([$file, $albumId]);
        }
        return (int)$this->db->lastInsertId();
    }

    public function deleteFoto(int $id): ?string {
        $q = $this->db->prepare('SELECT file FROM galeri_foto WHERE id=?');
        $q->execute([$id]);
        $row = $q->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        $this->db->prepare('DELETE FROM galeri_foto WHERE id=?')->execute([$id]);
        return $row['file'];
    }

    public function getFotoByAlbum(int $albumId): array {
        $q = $this->db->prepare('SELECT * FROM galeri_foto WHERE album_id=? ORDER BY urutan ASC, id ASC');
        $q->execute([$albumId]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFotoById(int $id): ?array {
        $q = $this->db->prepare('SELECT * FROM galeri_foto WHERE id=?');
        $q->execute([$id]);
        return $q->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}