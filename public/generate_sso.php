<?php
// ============================================================
// TARUH FILE INI DI WEB UTAMA: /generate_sso.php
// Dipanggil saat user klik tombol "Surat Digital"
// ============================================================

// Sesuaikan path config web utama Anda
require_once __DIR__ . '/../config/database.php'; // config web utama (yang sudah ada)
// Pastikan DB_* constants ada, atau gunakan koneksi existing Anda

// Pastikan user sudah login di web utama
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];

// Buat token SSO
$token   = bin2hex(random_bytes(64)); // 128 karakter hex
$expired = date('Y-m-d H:i:s', strtotime('+5 minutes'));
$ip      = $_SERVER['REMOTE_ADDR'] ?? null;

// Simpan ke tabel surat_auth_tokens (di database yang sama)
$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
    DB_USER, DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Hapus token lama milik user ini yang belum dipakai
$pdo->prepare("DELETE FROM surat_auth_tokens WHERE user_id = ? AND used = 0")->execute([$userId]);

// Insert token baru
$pdo->prepare("INSERT INTO surat_auth_tokens (user_id, token, ip_address, expired_at) VALUES (?,?,?,?)")
    ->execute([$userId, $token, $ip, $expired]);

// ============================================================
// Sanitasi $destination — hanya izinkan path relatif
// Mencegah: open redirect & bug URL double-domain
// ============================================================
$destination = $_GET['to'] ?? '/';

// Buang semua karakter kecuali huruf, angka, /, -, _, .
$destination = preg_replace('#[^a-zA-Z0-9/_\-.]#', '', $destination);

// Pastikan selalu diawali / dan bukan // (protocol-relative URL)
if (empty($destination) || $destination[0] !== '/') {
    $destination = '/';
}
if (strpos($destination, '//') === 0) {
    $destination = '/';
}

// Redirect ke surat-app dengan token
header('Location: https://surat.comsmkn2pinrang.my.id' . $destination . '?sso_token=' . $token);
exit;