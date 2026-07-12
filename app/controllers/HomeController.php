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

    // ================================================================
    //  DAFTAR ANGGOTA (PUBLIK)
    // ================================================================
    /**
     * Halaman publik yang menampilkan seluruh anggota aktif (nama, kelas,
     * foto), plus kartu Pembina & Ketua yang sedang menjabat (diambil dari
     * RiwayatPengurusModel). Bisa difilter lewat query string ?kelas=&search=.
     */
    public function anggota(): void
    {
        $um = new UserModel();

        $filter = [
            'kelas'  => $_GET['kelas']  ?? '',
            'search' => $_GET['search'] ?? '',
        ];

        $list      = $um->getAnggotaPublik($filter);
        $kelasList = $um->getKelasList();

        [$ketua, $pembina] = $this->_getPengurusAktif();

        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();

        $this->view(
            'pages/anggota',
            compact('list', 'kelasList', 'filter', 'ketua', 'pembina', 'settings', 'flash'),
            'main'
        );
    }

    /**
     * Ambil Ketua & Pembina yang sedang menjabat saat ini dari
     * RiwayatPengurusModel. Dibuat defensif (try/catch + class_exists)
     * supaya halaman anggota tidak error kalau model/tabel belum siap.
     *
     * Prioritas: entri dengan tahun_sampai KOSONG (masih menjabat).
     * Fallback: entri pertama per tipe dari getAll() (asumsi sudah
     * diurutkan dari yang terbaru).
     *
     * @return array{0: array|null, 1: array|null} [$ketua, $pembina]
     */
    private function _getPengurusAktif(): array
    {
        $ketua   = null;
        $pembina = null;

        if (!class_exists('RiwayatPengurusModel')) {
            return [$ketua, $pembina];
        }

        try {
            $riwayat = (new RiwayatPengurusModel())->getAll();
            $riwayat = is_array($riwayat) ? $riwayat : [];

            // Prioritas: yang tahun_sampai-nya kosong (masih menjabat)
            foreach ($riwayat as $r) {
                $tipe = $r['tipe'] ?? '';
                if ($tipe === 'ketua' && $ketua === null && empty($r['tahun_sampai'])) {
                    $ketua = $r;
                }
                if ($tipe === 'pembina' && $pembina === null && empty($r['tahun_sampai'])) {
                    $pembina = $r;
                }
            }

            // Fallback: ambil entri pertama per tipe kalau tidak ada yang "aktif"
            if (!$ketua) {
                foreach ($riwayat as $r) {
                    if (($r['tipe'] ?? '') === 'ketua') { $ketua = $r; break; }
                }
            }
            if (!$pembina) {
                foreach ($riwayat as $r) {
                    if (($r['tipe'] ?? '') === 'pembina') { $pembina = $r; break; }
                }
            }
        } catch (\Throwable $e) {
            error_log('Gagal mengambil data pengurus untuk halaman anggota: ' . $e->getMessage());
        }

        return [$ketua, $pembina];
    }
}