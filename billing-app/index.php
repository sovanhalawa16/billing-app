<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/layout.php';

// ============ AMBIL ROUTE ============
$route = $_GET['url'] ?? '';
$route = trim($route, '/');

// ============ LANDING PAGE (ROOT) ============
if ($route === '' || $route === 'home') {
    require __DIR__ . '/pages/landing.php';
    exit;
}

// ============ API (JSON) ============
if (strpos($route, 'api/') === 0) {
    $file = __DIR__ . '/' . $route . '.php';
    if (file_exists($file)) {
        require $file;
        exit;
    }
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'API endpoint tidak ditemukan']);
    exit;
}

// ============ PUBLIC ============
if ($route === 'login') {
    require __DIR__ . '/pages/login.php';
    exit;
}
if ($route === 'logout') {
    require __DIR__ . '/pages/logout.php';
    exit;
}
if (strpos($route, 'pay/') === 0) {
    require __DIR__ . '/pages/pay.php';
    exit;
}
if (strpos($route, 'struk/') === 0) {
    require __DIR__ . '/pages/struk.php';
    exit;
}

// ============ ADMIN (butuh login) ============
require_login();

$allowed = [
    'dashboard', 'kategori', 'metode',
    'invoice', 'invoice-create', 'invoice-detail', 'invoice-bulk-result',
    'konfirmasi', 'laporan', 'wa-template',
    'setting', 'qris'
];

if (in_array($route, $allowed)) {
    require __DIR__ . "/pages/$route.php";
    exit;
}

// 404
http_response_code(404);
echo '<h1 style="font-family:sans-serif;text-align:center;margin-top:80px;">404 - Halaman tidak ditemukan</h1>';