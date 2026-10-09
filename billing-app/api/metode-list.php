<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$search = trim($_GET['q'] ?? '');
$filter_jenis = $_GET['f'] ?? 'all';

$where = []; $params = [];
if ($search !== '') {
    $where[] = "(nama LIKE ? OR provider LIKE ? OR nomor LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if (in_array($filter_jenis, ['qris','bank','ewallet','custom'])) {
    $where[] = "jenis = ?";
    $params[] = $filter_jenis;
} elseif ($filter_jenis === 'aktif') {
    $where[] = "aktif = 1";
} elseif ($filter_jenis === 'nonaktif') {
    $where[] = "aktif = 0";
}
$wsql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$stmt = $pdo->prepare("SELECT * FROM payment_methods $wsql ORDER BY urutan ASC, id ASC");
$stmt->execute($params);
$rows = $stmt->fetchAll();

// Siapkan logo URL
foreach ($rows as &$r) {
    $r['logo_url'] = ($r['logo'] && file_exists(UPLOAD_PATH . '/' . $r['logo']))
        ? UPLOAD_URL . '/' . $r['logo'] : null;
    $r['qris_url'] = ($r['gambar_qris'] && file_exists(UPLOAD_PATH . '/' . $r['gambar_qris']))
        ? UPLOAD_URL . '/' . $r['gambar_qris'] : null;
}
unset($r);

$stats = [
    'all'      => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods")->fetchColumn(),
    'qris'     => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE jenis='qris'")->fetchColumn(),
    'bank'     => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE jenis='bank'")->fetchColumn(),
    'ewallet'  => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE jenis='ewallet'")->fetchColumn(),
    'custom'   => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE jenis='custom'")->fetchColumn(),
    'aktif'    => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE aktif=1")->fetchColumn(),
    'nonaktif' => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE aktif=0")->fetchColumn(),
];

echo json_encode([
    'success' => true,
    'rows'    => $rows,
    'stats'   => $stats,
    'total'   => count($rows),
]);