<?php
// app/controllers/HomeController.php

class HomeController extends Controller
{
    public function index(): void
    {
        $settings   = (new SettingModel())->getAll();
        $beritaList = $this->_getLatestBerita(3);
        $flash      = $this->getFlash();

        $this->view('pages/home', compact('settings', 'flash', 'beritaList'), 'main');
    }

    /**
     * Ambil beberapa berita terbaru yang sudah published untuk ditampilkan
     * di homepage. Dibuat defensif (try/catch + method_exists) supaya
     * homepage tidak error kalau BeritaModel belum punya method khusus ini.
     */
    private function _getLatestBerita(int $limit = 3): array
    {
        if (!class_exists('BeritaModel')) {
            return [];
        }

        try {
            $bm = new BeritaModel();

            // Pakai method khusus kalau sudah ditambahkan di BeritaModel
            if (method_exists($bm, 'getLatestPublished')) {
                return $bm->getLatestPublished($limit);
            }

            // Fallback: pakai getAll() yang sudah ada, lalu filter status published
            if (method_exists($bm, 'getAll')) {
                $raw = $bm->getAll(1, $limit * 3, '');
                $raw = is_array($raw) ? $raw : [];
                $published = array_values(array_filter($raw, function ($b) {
                    return ($b['status'] ?? '') === 'published';
                }));
                return array_slice($published, 0, $limit);
            }
        } catch (\Throwable $e) {
            error_log('Gagal mengambil berita untuk homepage: ' . $e->getMessage());
        }

        return [];
    }
}