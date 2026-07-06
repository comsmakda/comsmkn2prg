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

    /* ── helper: identifier unik per browser (session-based) ── */
    private function getVisitorId(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (empty($_SESSION['visitor_id'])) {
            $_SESSION['visitor_id'] = bin2hex(random_bytes(16));
        }
        return $_SESSION['visitor_id'];
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

        $visitorId  = $this->getVisitorId();
        $isLiked    = $this->bm->isLiked($berita['id'], $visitorId);
        $totalLikes = $this->bm->getLikesCount($berita['id']);
        $komentar   = $this->bm->getApprovedKomentar($berita['id']);
        $related    = $this->bm->getRelated($berita['id'], $berita['kategori_id'] ? (int)$berita['kategori_id'] : null);
        $settings   = (new SettingModel())->getAll();
        $flash      = $this->getFlash();

        /* ── Open Graph / Twitter Card untuk preview link (WA, FB, dll) ── */
        $ogTitle = $berita['judul'];
        $ogDesc  = $berita['ringkasan']
            ? $berita['ringkasan']
            : trim(mb_substr(strip_tags($berita['konten']), 0, 160)) . '…';

        // Pastikan absolut. Ganti UPLOAD_URL/BASE_URL di config kalau belum full https://...
        $ogImage = $berita['thumbnail']
            ? rtrim(UPLOAD_URL, '/') . '/' . $berita['thumbnail']
            : rtrim(BASE_URL, '/') . '/assets/img/og-default.jpg';

        $ogUrl = rtrim(BASE_URL, '/') . '/berita/' . $berita['slug'];

        $extra_head = '
    <meta property="og:type" content="article">
    <meta property="og:title" content="' . htmlspecialchars($ogTitle, ENT_QUOTES) . '">
    <meta property="og:description" content="' . htmlspecialchars($ogDesc, ENT_QUOTES) . '">
    <meta property="og:image" content="' . htmlspecialchars($ogImage, ENT_QUOTES) . '">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="' . htmlspecialchars($ogUrl, ENT_QUOTES) . '">
    <meta property="og:site_name" content="' . htmlspecialchars($settings['org_name']['value'] ?? APP_NAME, ENT_QUOTES) . '">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="' . htmlspecialchars($ogTitle, ENT_QUOTES) . '">
    <meta name="twitter:description" content="' . htmlspecialchars($ogDesc, ENT_QUOTES) . '">
    <meta name="twitter:image" content="' . htmlspecialchars($ogImage, ENT_QUOTES) . '">
';

        $this->view('pages/berita_detail', compact(
            'berita', 'komentar', 'related', 'isLiked', 'totalLikes',
            'settings', 'flash', 'extra_head'
        ), 'main');
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
        $visitorId = $this->getVisitorId();
        $result    = $this->bm->toggleLike((int)$id, $visitorId);
        echo json_encode($result);
        exit;
    }
}