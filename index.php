<?php
echo "<h1>🚀 YES! SERVER COOLIFY BERJALAN!</h1>";
echo "<p>Jika Anda melihat halaman ini, berarti Nginx dan PHP di Coolify berfungsi 100%.</p>";
echo "<p>Waktu Server: " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";
echo "<h3>Informasi Tambahan:</h3>";
echo "<ul>";
echo "<li>Versi PHP: " . phpversion() . "</li>";
echo "<li>Sistem Operasi Server: " . php_uname('s') . "</li>";
echo "</ul>";
?>