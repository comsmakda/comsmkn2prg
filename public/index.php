<?php
// public/index.php — Front Controller

declare(strict_types=1);

// ── Bootstrap ────────────────────────────────────────────────
define('ROOT', dirname(__DIR__));
define('APP_PATH', ROOT . '/app');

require ROOT . '/config/app.php';
require ROOT . '/config/database.php';

// ── Autoload core & models ───────────────────────────────────
$autoloadDirs = [
    ROOT . '/core',
    ROOT . '/app/models',
    ROOT . '/app/controllers',
];
foreach ($autoloadDirs as $dir) {
    foreach (glob($dir . '/*.php') as $file) {
        require_once $file;
    }
}

// ── Router ───────────────────────────────────────────────────
$router = new Router();

// Public
$router->get('/',               [HomeController::class, 'index']);
$router->get('/login',          [AuthController::class, 'loginPage']);
$router->post('/login',         [AuthController::class, 'loginPost']);
$router->get('/logout',         [AuthController::class, 'logout']);

// PAB
$router->get('/pab',            [PabController::class, 'index']);
$router->post('/pab/register',  [PabController::class, 'register']);

// ── Public: Berita ────────────────────────────────────────────
$router->get('/berita',                         [BeritaController::class, 'index']);
$router->get('/berita/:slug',                   [BeritaController::class, 'show']);
$router->post('/berita/:slug/komentar',         [BeritaController::class, 'postKomentar']);
$router->post('/berita/:id/like',               [BeritaController::class, 'like']);

// ── Public: Galeri ────────────────────────────────────────────
$router->get('/galeri',                         [GaleriController::class, 'index']);
$router->get('/galeri/:slug',                   [GaleriController::class, 'show']);

// ── Admin routes ─────────────────────────────────────────────
$router->get('/admin/dashboard',                        [AdminController::class, 'dashboard']);

// Anggota CRUD
$router->get('/admin/anggota',                          [AdminController::class, 'anggota']);
$router->get('/admin/anggota/tambah',                   [AdminController::class, 'anggotaCreate']);
$router->post('/admin/anggota/tambah',                  [AdminController::class, 'anggotaStore']);
$router->post('/admin/anggota/:id/activate',            [AdminController::class, 'anggotaActivate']);
$router->get('/admin/anggota/:id/edit',                 [AdminController::class, 'anggotaEdit']);
$router->post('/admin/anggota/:id/update',              [AdminController::class, 'anggotaUpdate']);
$router->post('/admin/anggota/:id/delete',              [AdminController::class, 'anggotaDelete']);
$router->post('/admin/anggota/:id/reset-password',      [AdminController::class, 'anggotaResetPassword']);

// PAB verifikasi
$router->get('/admin/pab',                              [AdminController::class, 'pab']);
$router->post('/admin/pab/:id/approve',                 [AdminController::class, 'pabApprove']);
$router->post('/admin/pab/:id/reject',                  [AdminController::class, 'pabReject']);
$router->post('/admin/pab/toggle',                      [AdminController::class, 'pabToggle']);

// CMS
$router->get('/admin/settings',                         [AdminController::class, 'settings']);
$router->post('/admin/settings/save',                   [AdminController::class, 'settingsSave']);

// Absensi
$router->get('/admin/absensi',                          [AdminController::class, 'absensi']);
$router->post('/admin/absensi/create',                  [AdminController::class, 'absensiCreate']);
$router->get('/admin/absensi/:id/print',                [AdminController::class, 'absensiPrint']);
$router->post('/admin/absensi/:id/delete',              [AdminController::class, 'absensiDelete']);

// Fingerprint GEISA X107
$router->get('/admin/fingerprint',                      [AdminController::class, 'fingerprint']);
$router->post('/admin/fingerprint/:id/push',            [AdminController::class, 'fingerprintPush']);
$router->post('/admin/fingerprint/push-bulk',           [AdminController::class, 'fingerprintPushBulk']);
$router->post('/admin/fingerprint/:id/delete',          [AdminController::class, 'fingerprintDelete']);
$router->post('/admin/fingerprint/sync-logs',           [AdminController::class, 'fingerprintSyncLogs']);
$router->get('/admin/fingerprint/rekap',                [AdminController::class, 'fingerprintRekap']);
$router->get('/admin/fingerprint/rekap/print',          [AdminController::class, 'fingerprintRekapPrint']);
$router->get('/admin/fingerprint/rekap/export', [AdminController::class, 'fingerprintRekapExport']);

// Profil Admin
$router->get('/admin/profil',               [AdminController::class, 'profil']);
$router->post('/admin/profil/simpan',       [AdminController::class, 'profilSimpan']);
$router->post('/admin/profil/logout-all',   [AdminController::class, 'profilLogoutAll']);

// Riwayat Pengurus
$router->get('/admin/riwayat',                      [AdminController::class, 'riwayat']);
$router->post('/admin/riwayat/store',               [AdminController::class, 'riwayatStore']);
$router->get('/admin/riwayat/:id/edit',             [AdminController::class, 'riwayatEdit']);
$router->post('/admin/riwayat/:id/update',          [AdminController::class, 'riwayatUpdate']);
$router->post('/admin/riwayat/:id/delete',          [AdminController::class, 'riwayatDelete']);

// Berita
$router->get('/admin/berita',                           [AdminController::class, 'berita']);
$router->get('/admin/berita/create',                    [AdminController::class, 'beritaCreate']);
$router->post('/admin/berita/store',                    [AdminController::class, 'beritaStore']);
$router->get('/admin/berita/komentar',                  [AdminController::class, 'beritaKomentar']);
$router->post('/admin/berita/komentar/:id/approve',     [AdminController::class, 'beritaKomentarApprove']);
$router->post('/admin/berita/komentar/:id/reject',      [AdminController::class, 'beritaKomentarReject']);
$router->post('/admin/berita/komentar/:id/delete',      [AdminController::class, 'beritaKomentarDelete']);
$router->get('/admin/berita/:id/edit',                  [AdminController::class, 'beritaEdit']);
$router->post('/admin/berita/:id/update',               [AdminController::class, 'beritaUpdate']);
$router->post('/admin/berita/:id/delete',               [AdminController::class, 'beritaDelete']);

// Galeri
$router->get('/admin/galeri',                           [AdminController::class, 'galeri']);
$router->get('/admin/galeri/create',                    [AdminController::class, 'galeriCreate']);
$router->post('/admin/galeri/store',                    [AdminController::class, 'galeriStore']);
$router->post('/admin/galeri/foto/:id/delete',  [AdminController::class, 'galeriDeleteFoto']);
$router->get('/admin/galeri/:id/edit',                  [AdminController::class, 'galeriEdit']);
$router->post('/admin/galeri/:id/update',               [AdminController::class, 'galeriUpdate']);
$router->post('/admin/galeri/:id/delete',               [AdminController::class, 'galeriDelete']);
$router->get('/admin/galeri/:id/foto',                  [AdminController::class, 'galeriFoto']);
$router->post('/admin/galeri/:id/upload',        [AdminController::class, 'galeriUploadFoto']);

$router->get('/admin/anggota/export',              [AdminController::class, 'anggotaExport']);
$router->get('/admin/anggota/import',               [AdminController::class, 'anggotaImport']);
$router->post('/admin/anggota/import',              [AdminController::class, 'anggotaImportProcess']);
$router->get('/admin/anggota/import/template',      [AdminController::class, 'anggotaImportTemplate']);

// ── Member routes ─────────────────────────────────────────────
$router->get('/member/dashboard',                       [MemberController::class, 'dashboard']);
$router->get('/member/profile',                         [MemberController::class, 'profile']);
$router->post('/member/profile/update',                 [MemberController::class, 'profileUpdate']);
$router->post('/member/profile/change-password',        [MemberController::class, 'changePassword']);
$router->get('/member/surat-pernyataan',                [MemberController::class, 'suratPernyataan']);

// ── Dispatch ──────────────────────────────────────────────────
$uri    = $_SERVER['REQUEST_URI'];
$base   = '/com-smkn2-pinrang/public';
if (str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}
$uri = $uri ?: '/';

$router->dispatch($uri, $_SERVER['REQUEST_METHOD']);