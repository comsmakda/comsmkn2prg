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

    private function _getLatestBerita(int $limit = 3): array
    {
        if (!class_exists('BeritaModel')) {
            return [];
        }

        try {
            $bm = new BeritaModel();

            if (method_exists($bm, 'getLatestPublished')) {
                return $bm->getLatestPublished($limit);
            }

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
    //  Satu bagan tunggal: pembina → pengurus → seluruh anggota.
    //  Tidak ada lagi filter/pencarian di halaman ini.
    // ================================================================
    public function anggota(): void
    {
        $um = new UserModel();

        $struktur     = $um->getStrukturOrganisasi();
        $list         = $um->getAnggotaPublik();
        $jabatanLabel = UserModel::JABATAN_LIST;
        $pembina      = $this->_getPembinaAktif();

        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();

        $this->view(
            'pages/anggota',
            compact('struktur', 'list', 'jabatanLabel', 'pembina', 'settings', 'flash'),
            'main'
        );
    }

    /**
     * Ambil Pembina yang sedang menjabat saat ini dari RiwayatPengurusModel.
     * Prioritas: entri tipe 'pembina' dengan tahun_sampai KOSONG (masih menjabat).
     * Fallback: entri pertama tipe 'pembina' dari getAll().
     */
    private function _getPembinaAktif(): ?array
    {
        if (!class_exists('RiwayatPengurusModel')) {
            return null;
        }

        try {
            $riwayat = (new RiwayatPengurusModel())->getAll();
            $riwayat = is_array($riwayat) ? $riwayat : [];

            foreach ($riwayat as $r) {
                if (($r['tipe'] ?? '') === 'pembina' && empty($r['tahun_sampai'])) {
                    return $r;
                }
            }

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