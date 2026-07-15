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
    //  DAFTAR ANGGOTA / STRUKTUR ORGANISASI (PUBLIK)
    // ================================================================
    /**
     * Halaman publik yang menampilkan struktur organisasi berjenjang
     * (ditarik dari kolom `jabatan`, admin utama/super admin dikecualikan)
     * plus kartu Pembina yang sedang menjabat (dari RiwayatPengurusModel,
     * karena Pembina bukan bagian dari JABATAN_LIST anggota/pengurus),
     * dan grid anggota biasa di bagian bawah.
     * Bisa difilter lewat query string ?kelas=&search=.
     */
    public function anggota(): void
    {
        $um = new UserModel();

        $filter = [
            'kelas'  => $_GET['kelas']  ?? '',
            'search' => $_GET['search'] ?? '',
        ];

        $struktur     = $um->getStrukturOrganisasi();
        $list         = $um->getAnggotaPublik($filter);
        $kelasList    = $um->getKelasList();
        $jabatanLabel = UserModel::JABATAN_LIST;
        $pembina      = $this->_getPembinaAktif();

        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();

        $this->view(
            'pages/anggota',
            compact('struktur', 'list', 'kelasList', 'filter', 'jabatanLabel', 'pembina', 'settings', 'flash'),
            'main'
        );
    }

    /**
     * Ambil Pembina yang sedang menjabat saat ini dari RiwayatPengurusModel.
     * Dibuat defensif (try/catch + class_exists) supaya halaman anggota
     * tidak error kalau model/tabel belum siap.
     *
     * Prioritas: entri tipe 'pembina' dengan tahun_sampai KOSONG (masih menjabat).
     * Fallback: entri pertama tipe 'pembina' dari getAll() (asumsi sudah
     * diurutkan dari yang terbaru).
     *
     * @return array|null
     */
    private function _getPembinaAktif(): ?array
    {
        if (!class_exists('RiwayatPengurusModel')) {
            return null;
        }

        try {
            $riwayat = (new RiwayatPengurusModel())->getAll();
            $riwayat = is_array($riwayat) ? $riwayat : [];

            // Prioritas: yang tahun_sampai-nya kosong (masih menjabat)
            foreach ($riwayat as $r) {
                if (($r['tipe'] ?? '') === 'pembina' && empty($r['tahun_sampai'])) {
                    return $r;
                }
            }

            // Fallback: ambil entri pertama tipe pembina
            foreach ($riwayat as $r) {
                if (($r['tipe'] ?? '') === 'pembina') {
                    return $r;
                }
            }
        } catch (\Throwable $e) {
            error_log('Gagal mengambil data pembina untuk halaman anggota: ' . $e->getMessage());
        }

        return null;
    }
}