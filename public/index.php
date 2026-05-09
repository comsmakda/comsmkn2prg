<?php
// public/index.php — Front Controller

declare(strict_types=1);

// ── Bootstrap ────────────────────────────────────────────────
define('ROOT', dirname(__DIR__));

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

// Profil Admin
$router->get('/admin/profil',               [AdminController::class, 'profil']);
$router->post('/admin/profil/simpan',       [AdminController::class, 'profilSimpan']);
$router->post('/admin/profil/logout-all',   [AdminController::class, 'profilLogoutAll']);

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
