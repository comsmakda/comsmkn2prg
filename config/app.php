<?php
// config/app.php

define('APP_NAME',    'SMKN 2 PINRANG');
define('BASE_URL',    'https://comsmkn2pinrang.my.id/public'); // Sesuaikan
define('BASE_PATH',   dirname(__DIR__));
define('UPLOAD_PATH', BASE_PATH . '/public/uploads/photos');
define('UPLOAD_URL',  BASE_URL  . '/uploads/photos');
define('MAX_UPLOAD_SIZE', 2 * 1024 * 1024); // 2 MB
define('ALLOWED_EXT', ['jpg','jpeg','png','webp']);

define('ORG_CODE', '24'); // Kode organisasi untuk NIA
define('NIA_SEQ_DIGITS', 3);

session_start();
