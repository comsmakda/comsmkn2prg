<?php
// app/models/BeritaModel.php

class BeritaModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /* ── slug unik ── */
    public function makeSlug(string $judul, int $excludeId = 0): string {
        $base = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $judul), '-'));
        $slug = $base;
        $i    = 1;
        while (true) {
            $q = $this->db->prepare('SELECT id FROM berita WHERE slug = ? AND id != ?');
            $q->execute([$slug, $excludeId]);
            if (!$q->fetch()) break;
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    /* ── CRUD ── */
    public function create(array $d): int {
        $q = $this->db->prepare('
            INSERT INTO berita (kategori_id,judul,slug,ringkasan,konten,thumbnail,penulis_id,status,published_at)
            VALUES (:kat,:judul,:slug,:ring,:konten,:thumb,:pid,:status,:pub)
        ');
        $q->execute([
            ':kat'    => $d['kategori_id'] ?: null,
            ':judul'  => $d['judul'],
            ':slug'   => $this->makeSlug($d['judul']),
            ':ring'   => $d['ringkasan'] ?? null,
            ':konten' => $d['konten'],
            ':thumb'  => $d['thumbnail'] ?? null,
            ':pid'    => $d['penulis_id'] ?? null,
            ':status' => $d['status'] ?? 'draft',
            ':pub'    => ($d['status'] === 'published') ? date('Y-m-d H:i:s') : null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $d): void {
        $pub = null;
        if ($d['status'] === 'published') {
            $cur = $this->db->prepare('SELECT published_at FROM berita WHERE id=?');
            $cur->execute([$id]);
            $row = $cur->fetch(PDO::FETCH_ASSOC);
            $pub = $row['published_at'] ?? date('Y-m-d H:i:s');
        }
        $q = $this->db->prepare('
            UPDATE berita SET kategori_id=:kat,judul=:judul,slug=:slug,ringkasan=:ring,
            konten=:konten,thumbnail=:thumb,status=:status,published_at=:pub WHERE id=:id
        ');
        $q->execute([
            ':kat'    => $d['kategori_id'] ?: null,
            ':judul'  => $d['judul'],
            ':slug'   => $this->makeSlug($d['judul'], $id),
            ':ring'   => $d['ringkasan'] ?? null,
            ':konten' => $d['konten'],
            ':thumb'  => $d['thumbnail'] ?? null,
            ':status' => $d['status'] ?? 'draft',
            ':pub'    => $pub,
            ':id'     => $id,
        ]);
    }

    public function delete(int $id): void {
        $this->db->prepare('DELETE FROM berita WHERE id=?')->execute([$id]);
    }

    public function findById(int $id): ?array {
        $q = $this->db->prepare('
            SELECT b.*, bk.nama AS kategori_nama, bk.warna AS kategori_warna,
                   bk.slug AS kategori_slug, u.nama_lengkap AS penulis_nama
            FROM berita b
            LEFT JOIN berita_kategori bk ON b.kategori_id = bk.id
            LEFT JOIN users u ON b.penulis_id = u.id
            WHERE b.id = ?
        ');
        $q->execute([$id]);
        return $q->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findBySlug(string $slug): ?array {
        $q = $this->db->prepare('
            SELECT b.*, bk.nama AS kategori_nama, bk.warna AS kategori_warna,
                   bk.slug AS kategori_slug, u.nama_lengkap AS penulis_nama
            FROM berita b
            LEFT JOIN berita_kategori bk ON b.kategori_id = bk.id
            LEFT JOIN users u ON b.penulis_id = u.id
            WHERE b.slug = ? AND b.status = "published"
        ');
        $q->execute([$slug]);
        return $q->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function incrementView(int $id): void {
        $this->db->prepare('UPDATE berita SET views = views + 1 WHERE id = ?')->execute([$id]);
    }

    /* ── list publik ── */
    public function getPublished(int $page = 1, int $limit = 9, ?int $kategoriId = null): array {
        $offset = ($page - 1) * $limit;
        $where  = 'b.status = "published"';
        $params = [];
        if ($kategoriId) { $where .= ' AND b.kategori_id = ?'; $params[] = $kategoriId; }
        $params[] = $limit;
        $params[] = $offset;
        $q = $this->db->prepare("
            SELECT b.id, b.judul, b.slug, b.ringkasan, b.thumbnail, b.views, b.published_at,
                   bk.nama AS kategori_nama, bk.warna AS kategori_warna, bk.slug AS kategori_slug,
                   u.nama_lengkap AS penulis_nama,
                   (SELECT COUNT(*) FROM berita_likes  WHERE berita_id=b.id) AS total_likes,
                   (SELECT COUNT(*) FROM berita_komentar WHERE berita_id=b.id AND status='approved') AS total_komentar
            FROM berita b
            LEFT JOIN berita_kategori bk ON b.kategori_id = bk.id
            LEFT JOIN users u ON b.penulis_id = u.id
            WHERE $where
            ORDER BY b.published_at DESC
            LIMIT ? OFFSET ?
        ");
        $q->execute($params);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPublished(?int $kategoriId = null): int {
        $where  = 'status = "published"';
        $params = [];
        if ($kategoriId) { $where .= ' AND kategori_id = ?'; $params[] = $kategoriId; }
        $q = $this->db->prepare("SELECT COUNT(*) FROM berita WHERE $where");
        $q->execute($params);
        return (int)$q->fetchColumn();
    }

    /* ── list admin ── */
    public function getAll(int $page = 1, int $limit = 15, string $search = ''): array {
        $offset = ($page - 1) * $limit;
        $where  = '1=1';
        $params = [];
        if ($search) { $where .= ' AND (b.judul LIKE ? OR b.ringkasan LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
        $params[] = $limit;
        $params[] = $offset;
        $q = $this->db->prepare("
            SELECT b.id, b.judul, b.slug, b.status, b.views, b.published_at, b.thumbnail, b.created_at,
                   bk.nama AS kategori_nama, u.nama_lengkap AS penulis_nama,
                   (SELECT COUNT(*) FROM berita_komentar WHERE berita_id=b.id AND status='pending') AS komentar_pending
            FROM berita b
            LEFT JOIN berita_kategori bk ON b.kategori_id = bk.id
            LEFT JOIN users u ON b.penulis_id = u.id
            WHERE $where ORDER BY b.created_at DESC LIMIT ? OFFSET ?
        ");
        $q->execute($params);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(string $search = ''): int {
        $where  = '1=1';
        $params = [];
        if ($search) { $where .= ' AND (judul LIKE ? OR ringkasan LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
        $q = $this->db->prepare("SELECT COUNT(*) FROM berita WHERE $where");
        $q->execute($params);
        return (int)$q->fetchColumn();
    }

    public function getRelated(int $id, ?int $kategoriId, int $limit = 3): array {
        $q = $this->db->prepare("
            SELECT b.id,b.judul,b.slug,b.thumbnail,b.published_at,bk.nama AS kategori_nama,bk.warna AS kategori_warna
            FROM berita b LEFT JOIN berita_kategori bk ON b.kategori_id=bk.id
            WHERE b.id != ? AND b.status='published'
              AND (b.kategori_id = ? OR ? IS NULL)
            ORDER BY b.published_at DESC LIMIT ?
        ");
        $q->execute([$id, $kategoriId, $kategoriId, $limit]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── kategori ── */
    public function getKategori(): array {
        return $this->db->query('SELECT * FROM berita_kategori ORDER BY urutan')->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── komentar ── */
    public function addKomentar(int $beritaId, string $nama, string $email, string $komentar, string $ip): int {
        $q = $this->db->prepare('INSERT INTO berita_komentar (berita_id,nama,email,komentar,ip_address) VALUES (?,?,?,?,?)');
        $q->execute([$beritaId, $nama, $email, $komentar, $ip]);
        return (int)$this->db->lastInsertId();
    }

    public function getApprovedKomentar(int $beritaId): array {
        $q = $this->db->prepare('SELECT * FROM berita_komentar WHERE berita_id=? AND status="approved" ORDER BY created_at ASC');
        $q->execute([$beritaId]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllKomentar(int $page = 1, int $limit = 20): array {
        $offset = ($page - 1) * $limit;
        $q = $this->db->prepare("
            SELECT k.*, b.judul AS berita_judul, b.slug AS berita_slug
            FROM berita_komentar k JOIN berita b ON k.berita_id=b.id
            ORDER BY k.created_at DESC LIMIT ? OFFSET ?
        ");
        $q->execute([$limit, $offset]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countKomentar(string $status = ''): int {
        $where  = '1=1';
        $params = [];
        if ($status) { $where .= ' AND status=?'; $params[] = $status; }
        $q = $this->db->prepare("SELECT COUNT(*) FROM berita_komentar WHERE $where");
        $q->execute($params);
        return (int)$q->fetchColumn();
    }

    public function updateKomentarStatus(int $id, string $status): void {
        $this->db->prepare('UPDATE berita_komentar SET status=? WHERE id=?')->execute([$status, $id]);
    }

    public function deleteKomentar(int $id): void {
        $this->db->prepare('DELETE FROM berita_komentar WHERE id=?')->execute([$id]);
    }

    /* ── likes (identifier = session ID unik per browser, bukan cuma IP) ── */
    public function toggleLike(int $beritaId, string $identifier): array {
        $q = $this->db->prepare('SELECT id FROM berita_likes WHERE berita_id=? AND ip_address=?');
        $q->execute([$beritaId, $identifier]);
        if ($q->fetch()) {
            $this->db->prepare('DELETE FROM berita_likes WHERE berita_id=? AND ip_address=?')->execute([$beritaId, $identifier]);
            $liked = false;
        } else {
            $this->db->prepare('INSERT INTO berita_likes (berita_id,ip_address) VALUES (?,?)')->execute([$beritaId, $identifier]);
            $liked = true;
        }
        $q2 = $this->db->prepare('SELECT COUNT(*) FROM berita_likes WHERE berita_id=?');
        $q2->execute([$beritaId]);
        return ['liked' => $liked, 'total' => (int)$q2->fetchColumn()];
    }

    public function isLiked(int $beritaId, string $identifier): bool {
        $q = $this->db->prepare('SELECT id FROM berita_likes WHERE berita_id=? AND ip_address=?');
        $q->execute([$beritaId, $identifier]);
        return (bool)$q->fetch();
    }

    public function getLikesCount(int $beritaId): int {
        $q = $this->db->prepare('SELECT COUNT(*) FROM berita_likes WHERE berita_id=?');
        $q->execute([$beritaId]);
        return (int)$q->fetchColumn();
    }
}