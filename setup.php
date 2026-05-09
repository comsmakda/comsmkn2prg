#!/usr/bin/env php
<?php
/**
 * setup.php — Jalankan sekali: php setup.php
 * Menghasilkan hash password admin yang benar untuk dimasukkan ke database.
 */

require __DIR__ . '/config/app.php';
require __DIR__ . '/config/database.php';
require __DIR__ . '/core/Database.php';

$password = 'Admin@COM2024';
$hash     = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

echo "=== COM SMKN 2 Pinrang — Setup ===\n\n";
echo "Password : $password\n";
echo "Hash     : $hash\n\n";

try {
    $db = Database::getInstance();

    // Update admin hash
    $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE email = ? AND role = 'admin'");
    $stmt->execute([$hash, 'admin@com.smkn2pinrang.sch.id']);

    if ($stmt->rowCount() > 0) {
        echo "✅ Password admin berhasil diperbarui di database.\n";
    } else {
        // Insert jika belum ada
        $stmt2 = $db->prepare(
            "INSERT INTO users (nama_lengkap, email, password_hash, role, status, sumber)
             VALUES ('Administrator', 'admin@com.smkn2pinrang.sch.id', ?, 'admin', 'aktif', 'manual')"
        );
        $stmt2->execute([$hash]);
        echo "✅ Admin baru dibuat di database.\n";
    }
    echo "\nLogin: admin@com.smkn2pinrang.sch.id / Admin@COM2024\n";
} catch (Exception $e) {
    echo "❌ Gagal: " . $e->getMessage() . "\n";
    echo "Jalankan query SQL ini secara manual:\n";
    echo "UPDATE users SET password_hash = '$hash' WHERE email = 'admin@com.smkn2pinrang.sch.id';\n";
}
