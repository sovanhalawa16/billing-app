<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json');

if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$bulan_ini_start = date('Y-m-01 00:00:00');
$bulan_ini_end   = date('Y-m-t 23:59:59');
$bulan_lalu_start = date('Y-m-01 00:00:00', strtotime('-1 month'));
$bulan_lalu_end   = date('Y-m-t 23:59:59', strtotime('-1 month'));

// ============ KPI BULAN INI ============
$totalIni = $pdo->prepare("SELECT COUNT(*) FROM invoices WHERE created_at BETWEEN ? AND ?");
$totalIni->execute([$bulan_ini_start, $bulan_ini_end]);
$total_ini = (int)$totalIni->fetchColumn();

$paidIni = $pdo->prepare("SELECT COUNT(*), COALESCE(SUM(total),0) FROM invoices WHERE status='paid' AND created_at BETWEEN ? AND ?");
$paidIni->execute([$bulan_ini_start, $bulan_ini_end]);
list($paid_count_ini, $revenue_ini) = $paidIni->fetch(PDO::FETCH_NUM);

$paidLalu = $pdo->prepare("SELECT COUNT(*), COALESCE(SUM(total),0) FROM invoices WHERE status='paid' AND created_at BETWEEN ? AND ?");
$paidLalu->execute([$bulan_lalu_start, $bulan_lalu_end]);
list($paid_count_lalu, $revenue_lalu) = $paidLalu->fetch(PDO::FETCH_NUM);

$pendingCount = (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='waiting'")->fetchColumn();

$unpaidCount = (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status IN ('unpaid','waiting')")->fetchColumn();

// Trend %
$trendRevenue = $revenue_lalu > 0 ? (($revenue_ini - $revenue_lalu) / $revenue_lalu) * 100 : ($revenue_ini > 0 ? 100 : 0);
$trendPaid = $paid_count_lalu > 0 ? (($paid_count_ini - $paid_count_lalu) / $paid_count_lalu) * 100 : ($paid_count_ini > 0 ? 100 : 0);

// ============ 7 HARI TERAKHIR ============
$hari7 = [];
$hari7_labels = [];
for ($i = 6; $i >= 0; $i--) {
    $tgl = date('Y-m-d', strtotime("-$i day"));
    $hari7_labels[] = date('d/m', strtotime($tgl));
    $s = $pdo->prepare("SELECT COUNT(*), COALESCE(SUM(total),0) FROM invoices WHERE DATE(created_at)=?");
    $s->execute([$tgl]);
    list($c, $sum) = $s->fetch(PDO::FETCH_NUM);
    $hari7[] = ['count' => (int)$c, 'sum' => (float)$sum];
}

// ============ STATUS BREAKDOWN ============
$statusRows = $pdo->query("SELECT status, COUNT(*) AS c FROM invoices GROUP BY status")->fetchAll();
$statusBreak = [];
foreach ($statusRows as $sr) $statusBreak[$sr['status']] = (int)$sr['c'];

// ============ TOP KATEGORI ============
$topKat = $pdo->query("
    SELECT c.nama, COUNT(i.id) AS jml, COALESCE(SUM(i.total),0) AS total
    FROM categories c
    LEFT JOIN invoices i ON i.kategori_id = c.id
    GROUP BY c.id
    ORDER BY jml DESC, total DESC
    LIMIT 5
")->fetchAll();

// ============ RECENT INVOICES ============
$recent = $pdo->query("
    SELECT i.*, c.nama AS kategori
    FROM invoices i LEFT JOIN categories c ON c.id = i.kategori_id
    ORDER BY i.created_at DESC LIMIT 6
")->fetchAll();

// ============ PENDING CONFIRMATIONS ============
$pendingList = $pdo->query("
    SELECT pp.id, pp.uploaded_at, i.invoice_number, i.nama_pembayar, i.total, i.id AS inv_id
    FROM payment_proofs pp
    JOIN invoices i ON i.id = pp.invoice_id
    WHERE pp.status='waiting'
    ORDER BY pp.uploaded_at DESC LIMIT 5
")->fetchAll();

// ============ HAMPIR EXPIRED ============
$expSoon = $pdo->query("
    SELECT id, invoice_number, nama_pembayar, total, expired_at
    FROM invoices
    WHERE status='unpaid' AND expired_at BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 3 DAY)
    ORDER BY expired_at ASC LIMIT 5
")->fetchAll();

// ============ AKTIVITAS ============
$activities = $pdo->query("
    SELECT al.aktivitas, al.detail, al.created_at, i.invoice_number
    FROM activity_logs al
    LEFT JOIN invoices i ON i.id = al.invoice_id
    ORDER BY al.created_at DESC LIMIT 8
")->fetchAll();

// ============ TARGET BULANAN ============
$target = (float)(setting('target_bulanan', 0));
$progress = $target > 0 ? min(100, ($revenue_ini / $target) * 100) : 0;

echo json_encode([
    'success' => true,
    'timestamp' => date('Y-m-d H:i:s'),
    'kpi' => [
        'total_ini' => $total_ini,
        'paid_count_ini' => (int)$paid_count_ini,
        'revenue_ini' => (float)$revenue_ini,
        'revenue_lalu' => (float)$revenue_lalu,
        'pending_count' => $pendingCount,
        'unpaid_count' => $unpaidCount,
        'trend_revenue' => round($trendRevenue, 1),
        'trend_paid' => round($trendPaid, 1),
    ],
    'hari7' => ['labels' => $hari7_labels, 'data' => $hari7],
    'status_break' => $statusBreak,
    'top_kat' => $topKat,
    'recent' => $recent,
    'pending_list' => $pendingList,
    'exp_soon' => $expSoon,
    'activities' => $activities,
    'target' => ['target' => $target, 'progress' => round($progress, 1), 'revenue' => (float)$revenue_ini],
]);