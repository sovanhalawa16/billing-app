<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$dari   = $_GET['dari']   ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');
$status = $_GET['status'] ?? 'paid';
$kat    = (int)($_GET['kat'] ?? 0);

$where = ["DATE(i.created_at) BETWEEN ? AND ?"];
$params = [$dari, $sampai];

if (in_array($status, ['paid','unpaid','waiting','expired','cancelled','rejected'])) {
    $where[] = "i.status = ?";
    $params[] = $status;
}
if ($kat) {
    $where[] = "i.kategori_id = ?";
    $params[] = $kat;
}
$wsql = 'WHERE ' . implode(' AND ', $where);

$stmt = $pdo->prepare("
    SELECT i.*, c.nama AS kategori
    FROM invoices i
    LEFT JOIN categories c ON c.id = i.kategori_id
    $wsql ORDER BY i.created_at DESC
");
$stmt->execute($params);
$rows = $stmt->fetchAll();

$total_nom = 0;
$total_diskon = 0;
$total_biaya = 0;
$total_pajak = 0;
$total_unik = 0;

foreach ($rows as &$r) {
    $r['total_fmt'] = rupiah($r['total']);
    $r['tanggal_fmt'] = date('d/m/y', strtotime($r['created_at']));
    $r['tanggal_full'] = tglIndo($r['created_at']);
    $total_nom += (float)$r['total'];
    $total_diskon += (float)$r['total_diskon'];
    $total_biaya += (float)$r['total_biaya_admin'];
    $total_pajak += (float)$r['total_pajak'];
    $total_unik += (float)$r['kode_unik'];
}
unset($r);

$avg = count($rows) > 0 ? $total_nom / count($rows) : 0;

echo json_encode([
    'success' => true,
    'rows'    => $rows,
    'stats'   => [
        'count'       => count($rows),
        'total'       => $total_nom,
        'total_fmt'   => rupiah($total_nom),
        'avg'         => $avg,
        'avg_fmt'     => rupiah($avg),
        'diskon_fmt'  => rupiah($total_diskon),
        'biaya_fmt'   => rupiah($total_biaya),
        'pajak_fmt'   => rupiah($total_pajak),
        'unik_fmt'    => rupiah($total_unik),
    ],
]);