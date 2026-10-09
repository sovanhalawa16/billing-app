<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$filter_status = $_GET['status'] ?? 'all';
$filter_kat    = (int)($_GET['kat'] ?? 0);
$search        = trim($_GET['q'] ?? '');
$page          = max(1, (int)($_GET['p'] ?? 1));
$per_page      = 20;
$offset        = ($page - 1) * $per_page;

$where = []; $params = [];

// Auto-expire tagihan yang udah lewat
$pdo->exec("UPDATE invoices SET status='expired' WHERE status='unpaid' AND expired_at < NOW()");

if (in_array($filter_status, ['unpaid','waiting','paid','rejected','expired','cancelled','draft'])) {
    $where[] = "i.status = ?";
    $params[] = $filter_status;
}
if ($filter_kat) {
    $where[] = "i.kategori_id = ?";
    $params[] = $filter_kat;
}
if ($search !== '') {
    $where[] = "(i.nama_pembayar LIKE ? OR i.invoice_number LIKE ? OR i.nomor_wa LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
$wsql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Count
$stmt = $pdo->prepare("SELECT COUNT(*) FROM invoices i $wsql");
$stmt->execute($params);
$total_rows = (int)$stmt->fetchColumn();
$total_pages = max(1, ceil($total_rows / $per_page));

// Data
$stmt = $pdo->prepare("
    SELECT i.*, c.nama AS kategori, c.kode_prefix
    FROM invoices i
    LEFT JOIN categories c ON c.id = i.kategori_id
    $wsql
    ORDER BY i.created_at DESC
    LIMIT $per_page OFFSET $offset
");
$stmt->execute($params);
$rows = $stmt->fetchAll();

// ============ TEMPLATE WA PER TIPE ============
$tpl_map = [];
$tpl_rows = $pdo->query("SELECT tipe, isi FROM wa_templates WHERE aktif=1 ORDER BY tipe, id")->fetchAll();
foreach ($tpl_rows as $t) {
    if (!isset($tpl_map[$t['tipe']])) {
        $tpl_map[$t['tipe']] = $t['isi'];
    }
}
$default_tpl = $tpl_map['tagihan_baru'] ?? "Halo {nama_pembayar}, tagihan {invoice_number} sebesar {nominal}. Bayar di: {link}";

// Mapping status invoice → tipe template WA
$status_tpl_map = [
    'unpaid'    => 'tagihan_baru',
    'waiting'   => 'tagihan_baru',
    'paid'      => 'approved',
    'rejected'  => 'rejected',
    'expired'   => 'reminder',
    'cancelled' => 'tagihan_baru',
    'draft'     => 'tagihan_baru',
];

// Label tombol WA by status
$wa_labels = [
    'unpaid'    => 'Kirim Tagihan',
    'waiting'   => 'Kirim Tagihan',
    'paid'      => 'Kirim Konfirmasi',
    'rejected'  => 'Kirim Penolakan',
    'expired'   => 'Kirim Reminder',
    'cancelled' => 'Kirim Info',
    'draft'     => 'Kirim Tagihan',
];

$nama_bisnis = setting('nama_bisnis', APP_NAME);
$kontak_admin = setting('kontak_admin', '');

// Format data buat JSON
foreach ($rows as &$r) {
    $r['total_fmt'] = rupiah($r['total']);
    $r['tanggal_fmt'] = tglIndo($r['created_at']);
    $r['expired_fmt'] = tglIndo($r['expired_at']);
    $r['link_pay'] = BASE_URL . '/?url=pay/' . $r['token'];
    $r['deskripsi_short'] = mb_strlen($r['deskripsi']) > 70
        ? mb_substr($r['deskripsi'], 0, 70) . '...'
        : $r['deskripsi'];

    // Template by status
    $target_tipe = $status_tpl_map[$r['status']] ?? 'tagihan_baru';
    $tpl = $tpl_map[$target_tipe] ?? $default_tpl;

    $wa_text = strtr($tpl, [
        '{nama_pembayar}'  => $r['nama_pembayar'],
        '{invoice_number}' => $r['invoice_number'],
        '{deskripsi}'      => $r['deskripsi'],
        '{nominal}'        => $r['total_fmt'],
        '{expired}'        => $r['expired_fmt'],
        '{nama_bisnis}'    => $nama_bisnis,
        '{kontak_admin}'   => $kontak_admin,
        '{link}'           => $r['link_pay'],
        '{alasan}'         => '',
    ]);

    $wa_num = preg_replace('/[^0-9]/', '', $r['nomor_wa']);
    if (substr($wa_num, 0, 1) === '0') $wa_num = '62' . substr($wa_num, 1);
    elseif (substr($wa_num, 0, 2) !== '62') $wa_num = '62' . $wa_num;

    $r['wa_link'] = 'https://wa.me/' . $wa_num . '?text=' . urlencode($wa_text);
    $r['wa_label'] = $wa_labels[$r['status']] ?? 'Kirim WA';
    $r['wa_tipe'] = $target_tipe;

    // Auto-detect expired
    $is_expired_display = (strtotime($r['expired_at']) < time() && $r['status'] === 'unpaid');
    $r['display_status'] = $is_expired_display ? 'expired' : $r['status'];
}
unset($r);

// Stats
$stats = [
    'all'      => (int)$pdo->query("SELECT COUNT(*) FROM invoices")->fetchColumn(),
    'unpaid'   => (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status='unpaid'")->fetchColumn(),
    'waiting'  => (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status='waiting'")->fetchColumn(),
    'paid'     => (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status='paid'")->fetchColumn(),
    'expired'  => (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status='expired'")->fetchColumn(),
];

// Kategori untuk dropdown filter
$kategoris = $pdo->query("SELECT id, nama FROM categories ORDER BY nama")->fetchAll();

echo json_encode([
    'success'     => true,
    'rows'        => $rows,
    'stats'       => $stats,
    'kategoris'   => $kategoris,
    'page'        => $page,
    'total_pages' => $total_pages,
    'total_rows'  => $total_rows,
]);