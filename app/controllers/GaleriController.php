<?php
// app/controllers/GaleriController.php

require_once APP_PATH . '/models/GaleriModel.php';

class GaleriController extends Controller
{
    private GaleriModel $gm;

    public function __construct()
    {
        $this->gm = new GaleriModel();
    }

    /* ── GET /galeri ── */
    public function index(): void
    {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 12;
        $total  = $this->gm->countPublishedAlbums();
        $pages  = max(1, (int)ceil($total / $limit));
        $page   = min($page, $pages);
        $albums = $this->gm->getPublishedAlbums($page, $limit);

        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();

        $this->view('pages/galeri', compact('albums', 'page', 'pages', 'total', 'settings', 'flash'), 'main');
    }

    /* ── GET /galeri/{slug} ── */
    public function show(string $slug): void
    {
        $album = $this->gm->findAlbumBySlug($slug);
        if (!$album) {
            http_response_code(404);
            $settings = (new SettingModel())->getAll();
            $this->view('errors/404', compact('settings'), 'main');
            return;
        }

        $fotos    = $this->gm->getFotoByAlbum($album['id']);
        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();

        $this->view('pages/galeri_album', compact('album', 'fotos', 'settings', 'flash'), 'main');
    }
}