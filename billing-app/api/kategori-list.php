<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json');

if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$search = trim($_GET['q'] ?? '');
$filter_aktif = $_GET['f'] ?? 'all';

$where = []; $params = [];
if ($search !== '') {
    $where[] = "(nama LIKE ? OR kode_prefix LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($filter_aktif === 'aktif') $where[] = "aktif = 1";
elseif ($filter_aktif === 'nonaktif') $where[] = "aktif = 0";
$wsql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$stmt = $pdo->prepare("
    SELECT c.*, (SELECT COUNT(*) FROM invoices i WHERE i.kategori_id = c.id) AS jml_tagihan
    FROM categories c
    $wsql
    ORDER BY c.nama ASC
");
$stmt->execute($params);
$rows = $stmt->fetchAll();

$stats = [
    'all'      => (int)$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
    'aktif'    => (int)$pdo->query("SELECT COUNT(*) FROM categories WHERE aktif=1")->fetchColumn(),
    'nonaktif' => (int)$pdo->query("SELECT COUNT(*) FROM categories WHERE aktif=0")->fetchColumn(),
];

echo json_encode([
    'success' => true,
    'rows'    => $rows,
    'stats'   => $stats,
    'total'   => count($rows),
]);