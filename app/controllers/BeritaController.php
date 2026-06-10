<?php
// app/controllers/BeritaController.php

require_once APP_PATH . '/models/BeritaModel.php';

class BeritaController extends Controller
{
    private BeritaModel $bm;

    public function __construct()
    {
        $this->bm = new BeritaModel();
    }

    /* ── GET /berita ── */
    public function index(): void
    {
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $katSlug = $_GET['kategori'] ?? '';
        $limit   = 9;

        $kategoriList = $this->bm->getKategori();
        $katId        = null;
        $katAktif     = null;
        foreach ($kategoriList as $k) {
            if ($k['slug'] === $katSlug) {
                $katId    = (int)$k['id'];
                $katAktif = $k;
                break;
            }
        }

        $total    = $this->bm->countPublished($katId);
        $pages    = max(1, (int)ceil($total / $limit));
        $page     = min($page, $pages);
        $items    = $this->bm->getPublished($page, $limit, $katId);
        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();

        $this->view('pages/berita', compact('items', 'kategoriList', 'katAktif', 'page', 'pages', 'total', 'settings', 'flash'), 'main');
    }

    /* ── GET /berita/{slug} ── */
    public function show(string $slug): void
    {
        $berita = $this->bm->findBySlug($slug);
        if (!$berita) {
            http_response_code(404);
            $settings = (new SettingModel())->getAll();
            $this->view('errors/404', compact('settings'), 'main');
            return;
        }

        $this->bm->incrementView($berita['id']);

        $ip         = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $isLiked    = $this->bm->isLiked($berita['id'], $ip);
        $totalLikes = $this->bm->getLikesCount($berita['id']);
        $komentar   = $this->bm->getApprovedKomentar($berita['id']);
        $related    = $this->bm->getRelated($berita['id'], $berita['kategori_id'] ? (int)$berita['kategori_id'] : null);
        $settings   = (new SettingModel())->getAll();
        $flash      = $this->getFlash();

        $this->view('pages/berita_detail', compact('berita', 'komentar', 'related', 'isLiked', 'totalLikes', 'settings', 'flash'), 'main');
    }

    /* ── POST /berita/{slug}/komentar ── */
    public function postKomentar(string $slug): void
    {
        $berita = $this->bm->findBySlug($slug);
        if (!$berita) {
            $this->redirect('/berita');
        }

        $nama  = htmlspecialchars(trim($_POST['nama'] ?? ''), ENT_QUOTES);
        $email = trim($_POST['email'] ?? '');
        $komen = htmlspecialchars(trim($_POST['komentar'] ?? ''), ENT_QUOTES);

        if (!$nama || !$email || !$komen || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('error', 'Harap isi semua field dengan benar.');
        } else {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
            $this->bm->addKomentar($berita['id'], $nama, $email, $komen, $ip);
            $this->flash('success', 'Komentar berhasil dikirim dan menunggu persetujuan admin.');
        }

        $this->redirect('/berita/' . $slug . '#komentar');
    }

    /* ── POST /berita/{id}/like  (AJAX JSON) ── */
    public function like(string $id): void
    {
        header('Content-Type: application/json');
        $ip     = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $result = $this->bm->toggleLike((int)$id, $ip);
        echo json_encode($result);
        exit;
    }
}