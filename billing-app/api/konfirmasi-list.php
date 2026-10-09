<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$filter = $_GET['f'] ?? 'waiting';
$search = trim($_GET['q'] ?? '');

$where = []; $params = [];
if (in_array($filter, ['waiting','approved','rejected'])) {
    $where[] = "pp.status = ?";
    $params[] = $filter;
}
if ($search !== '') {
    $where[] = "(i.invoice_number LIKE ? OR i.nama_pembayar LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// ⭐ FIX: Fallback metode dari locked_method_id kalau payment_method_id NULL
$stmt = $pdo->prepare("
    SELECT pp.*, 
           i.invoice_number, i.nama_pembayar, i.nomor_wa, i.total, i.id AS invoice_id,
           i.locked_method_id,
           COALESCE(pp.payment_method_id, i.locked_method_id) AS effective_method_id
    FROM payment_proofs pp
    JOIN invoices i ON i.id = pp.invoice_id
    $where_sql
    ORDER BY pp.uploaded_at DESC
    LIMIT 100
");
$stmt->execute($params);
$rows = $stmt->fetchAll();

// Ambil semua nama metode yang dibutuhkan (batch query biar efisien)
$methodIds = [];
foreach ($rows as $r) {
    if (!empty($r['effective_method_id'])) {
        $methodIds[] = (int)$r['effective_method_id'];
    }
}
$methodIds = array_unique($methodIds);

$methodMap = [];
if (!empty($methodIds)) {
    $placeholders = implode(',', array_fill(0, count($methodIds), '?'));
    $stmtM = $pdo->prepare("SELECT id, nama, jenis FROM payment_methods WHERE id IN ($placeholders)");
    $stmtM->execute($methodIds);
    foreach ($stmtM->fetchAll() as $m) {
        $methodMap[(int)$m['id']] = $m;
    }
}

// Format data
foreach ($rows as &$r) {
    $mid = (int)($r['effective_method_id'] ?? 0);
    $r['metode_nama'] = $methodMap[$mid]['nama'] ?? null;
    $r['metode_jenis'] = $methodMap[$mid]['jenis'] ?? null;

    $r['total_fmt'] = rupiah($r['total']);
    $r['uploaded_fmt'] = tglIndo($r['uploaded_at']);
    $r['gambar_url'] = !empty($r['gambar']) && file_exists(UPLOAD_PATH . '/' . $r['gambar'])
        ? UPLOAD_URL . '/' . $r['gambar'] : null;
    $r['pill_label'] = ['waiting'=>'Menunggu','approved'=>'Disetujui','rejected'=>'Ditolak'][$r['status']] ?? $r['status'];

    // Flag konfirmasi via WA
    $r['via_wa'] = (($r['konfirmasi_via'] ?? 'sistem') === 'wa');
}
unset($r);

$stats = [
    'waiting'  => (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='waiting'")->fetchColumn(),
    'approved' => (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='approved'")->fetchColumn(),
    'rejected' => (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='rejected'")->fetchColumn(),
    'all'      => (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs")->fetchColumn(),
];

echo json_encode([
    'success' => true,
    'rows'    => $rows,
    'stats'   => $stats,
    'total'   => count($rows),
]);