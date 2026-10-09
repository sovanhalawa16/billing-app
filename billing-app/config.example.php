<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

// ====== KONFIGURASI ======
define('BASE_URL', 'https://domainkamu.com');
define('APP_NAME', 'Tagihanku');
define('APP_PATH', __DIR__);
define('UPLOAD_PATH', APP_PATH . '/uploads');
define('UPLOAD_URL', BASE_URL . '/uploads');
define('TIMEZONE', 'Asia/Jakarta');

// ====== DATABASE ======
$DB_HOST = 'localhost';
$DB_NAME = 'nama_database';
$DB_USER = 'user_database';
$DB_PASS = 'password_database';

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER, $DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    $pdo->exec("SET time_zone = '+07:00'");
} catch (PDOException $e) {
    die('DB Error: ' . $e->getMessage());
}

// Lanjutkan helper & function seperti di config.php asli
// TAPI JANGAN isi password asli
