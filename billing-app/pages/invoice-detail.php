<?php
$title = 'Detail Tagihan';
$active = 'invoice';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { redirect('/?url=invoice'); }

// ============ ICON SVG ============
function dt_icon($name, $size = 20) {
    $icons = [
        'arrowL'   => '<line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>',
        'file'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
        'dollar'   => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
        'image'    => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>',
        'lock'     => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'link'     => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
        'copy'     => '<rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>',
        'eye'      => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'check'    => '<polyline points="20 6 9 17 4 12"/>',
        'checkCircle' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        'x'        => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'ban'      => '<circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>',
        'trash'    => '<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
        'clock'    => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'tag'      => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
        'phone'    => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'mail'     => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        'card'     => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        'message'  => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'activity' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
        'info'     => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
        'alert'    => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
        'hash'     => '<line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/>',
        'user'     => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; display:inline-block; vertical-align:middle;">'.$path.'</svg>';
}

function dt_wa_filled($size = 18) {
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413"/></svg>';
}

// ============ HANDLE POST ============
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = $_POST['post_action'] ?? '';

    if ($act === 'approve' && !empty($_POST['proof_id'])) {
        $pid = (int)$_POST['proof_id'];
        $pdo->beginTransaction();
        $pdo->prepare("UPDATE payment_proofs SET status='approved', verified_by=?, verified_at=NOW() WHERE id=?")
            ->execute([$_SESSION['admin_id'] ?? null, $pid]);
        $pdo->prepare("UPDATE invoices SET status='paid' WHERE id=?")->execute([$id]);
        $pdo->prepare("INSERT INTO status_logs (invoice_id,status_lama,status_baru,oleh_tipe,oleh_id,keterangan) VALUES (?,'waiting','paid','admin',?,'Bukti disetujui')")
            ->execute([$id, $_SESSION['admin_id'] ?? null]);
        $pdo->commit();
        flash('success', 'Bukti disetujui. Tagihan LUNAS.');
        redirect('/?url=invoice-detail&id=' . $id);
    }

    if ($act === 'reject' && !empty($_POST['proof_id'])) {
        $pid = (int)$_POST['proof_id'];
        $alasan = trim($_POST['alasan'] ?? '');
        if ($alasan === '') { flash('error', 'Alasan wajib diisi.'); redirect('/?url=invoice-detail&id=' . $id); }
        $pdo->beginTransaction();
        $pdo->prepare("UPDATE payment_proofs SET status='rejected', alasan_reject=?, verified_by=?, verified_at=NOW() WHERE id=?")
            ->execute([$alasan, $_SESSION['admin_id'] ?? null, $pid]);
        $pdo->prepare("UPDATE invoices SET status='unpaid' WHERE id=?")->execute([$id]);
        $pdo->prepare("INSERT INTO status_logs (invoice_id,status_lama,status_baru,oleh_tipe,oleh_id,keterangan) VALUES (?,'waiting','unpaid','admin',?,?)")
            ->execute([$id, $_SESSION['admin_id'] ?? null, 'Bukti ditolak: ' . $alasan]);
        $pdo->commit();
        flash('success', 'Bukti ditolak.');
        redirect('/?url=invoice-detail&id=' . $id);
    }

    if ($act === 'mark_paid') {
        $pdo->prepare("UPDATE invoices SET status='paid' WHERE id=?")->execute([$id]);
        $pdo->prepare("INSERT INTO status_logs (invoice_id,status_lama,status_baru,oleh_tipe,oleh_id,keterangan) VALUES (?,?,'paid','admin',?,'Ditandai lunas manual')")
            ->execute([$id, 'unpaid', $_SESSION['admin_id'] ?? null]);
        flash('success', 'Ditandai lunas.');
        redirect('/?url=invoice-detail&id=' . $id);
    }

    if ($act === 'cancel') {
        $pdo->prepare("UPDATE invoices SET status='cancelled' WHERE id=?")->execute([$id]);
        flash('success', 'Tagihan dibatalkan.');
        redirect('/?url=invoice-detail&id=' . $id);
    }

    if ($act === 'delete') {
        $pdo->prepare("DELETE FROM invoices WHERE id=?")->execute([$id]);
        flash('success', 'Tagihan dihapus.');
        redirect('/?url=invoice');
    }
}

// ============ AMBIL DATA ============
$stmt = $pdo->prepare("
    SELECT i.*, c.nama AS kategori, c.kode_prefix
    FROM invoices i LEFT JOIN categories c ON c.id = i.kategori_id
    WHERE i.id = ?
");
$stmt->execute([$id]);
$inv = $stmt->fetch();
if (!$inv) { flash('error', 'Tagihan tidak ditemukan.'); redirect('/?url=invoice'); }

$items = $pdo->prepare("SELECT * FROM invoice_items WHERE invoice_id=? ORDER BY urutan, id");
$items->execute([$id]);
$items = $items->fetchAll();

$adjs = $pdo->prepare("SELECT * FROM invoice_adjustments WHERE invoice_id=? ORDER BY urutan, id");
$adjs->execute([$id]);
$adjs = $adjs->fetchAll();

$proofs = $pdo->prepare("
    SELECT pp.*, pm.nama AS metode_nama
    FROM payment_proofs pp
    LEFT JOIN payment_methods pm ON pm.id = pp.payment_method_id
    WHERE pp.invoice_id=? ORDER BY pp.uploaded_at DESC
");
$proofs->execute([$id]);
$proofs = $proofs->fetchAll();

$logs = $pdo->prepare("SELECT * FROM status_logs WHERE invoice_id=? ORDER BY created_at ASC");
$logs->execute([$id]);
$logs = $logs->fetchAll();

$payLink = BASE_URL . '/?url=pay/' . $inv['token'];

// Ambil alasan reject terakhir (kalau ada)
$lastRejectReason = '';
foreach ($proofs as $p) {
    if ($p['status'] === 'rejected' && !empty($p['alasan_reject'])) {
        $lastRejectReason = $p['alasan_reject'];
        break;
    }
}

// ============ WA TEXT — TEMPLATE BY STATUS ============
$status_tpl_map = [
    'unpaid'    => 'tagihan_baru',
    'waiting'   => 'tagihan_baru',
    'paid'      => 'approved',
    'rejected'  => 'rejected',
    'expired'   => 'reminder',
    'cancelled' => 'tagihan_baru',
    'draft'     => 'tagihan_baru',
];

// Cek apakah bukti terakhir ditolak (override ke template rejected)
$lastProofRejected = false;
foreach ($proofs as $p) {
    if ($p['status'] === 'rejected') { $lastProofRejected = true; break; }
    if (in_array($p['status'], ['waiting','approved'])) { break; }
}

if ($lastProofRejected && $inv['status'] === 'unpaid') {
    $target_tipe = 'rejected';
} else {
    $target_tipe = $status_tpl_map[$inv['status']] ?? 'tagihan_baru';
}

// Ambil template sesuai tipe
$stmt = $pdo->prepare("SELECT isi FROM wa_templates WHERE tipe=? AND aktif=1 ORDER BY id LIMIT 1");
$stmt->execute([$target_tipe]);
$tpl = $stmt->fetchColumn();

// Fallback ke tagihan_baru
if (!$tpl) {
    $tpl = $pdo->query("SELECT isi FROM wa_templates WHERE tipe='tagihan_baru' AND aktif=1 ORDER BY id LIMIT 1")->fetchColumn();
}
if (!$tpl) $tpl = "Halo {nama_pembayar}, tagihan {invoice_number} sebesar {nominal}. Bayar: {link}";

$waText = strtr($tpl, [
    '{nama_pembayar}'  => $inv['nama_pembayar'],
    '{invoice_number}' => $inv['invoice_number'],
    '{deskripsi}'      => $inv['deskripsi'],
    '{nominal}'        => rupiah($inv['total']),
    '{expired}'        => tglIndo($inv['expired_at']),
    '{nama_bisnis}'    => setting('nama_bisnis', APP_NAME),
    '{kontak_admin}'   => setting('kontak_admin', ''),
    '{link}'           => $payLink,
    '{alasan}'         => $lastRejectReason ?: '—',
]);

$waNum = preg_replace('/[^0-9]/', '', $inv['nomor_wa']);
if (substr($waNum, 0, 1) === '0') $waNum = '62' . substr($waNum, 1);
elseif (substr($waNum, 0, 2) !== '62') $waNum = '62' . $waNum;

// Status
$statusMeta = [
    'unpaid'    => ['Belum Bayar', '#d97706', '#fef3c7'],
    'waiting'   => ['Menunggu Konfirmasi', '#2563eb', '#dbeafe'],
    'paid'      => ['Lunas', '#16a34a', '#dcfce7'],
    'rejected'  => ['Ditolak', '#dc2626', '#fee2e2'],
    'expired'   => ['Expired', '#64748b', '#f1f5f9'],
    'cancelled' => ['Dibatalkan', '#64748b', '#f1f5f9'],
    'draft'     => ['Draft', '#94a3b8', '#e2e8f0'],
];
list($stLbl, $stColor, $stBg) = $statusMeta[$inv['status']] ?? ['Unknown', '#888', '#f1f5f9'];

// Label tombol WA by status (override rejected kalau bukti terakhir ditolak)
$waBtnLabel = [
    'unpaid'    => 'Kirim Tagihan',
    'waiting'   => 'Kirim Tagihan',
    'paid'      => 'Kirim Konfirmasi',
    'rejected'  => 'Kirim Penolakan',
    'expired'   => 'Kirim Reminder',
    'cancelled' => 'Kirim Info',
    'draft'     => 'Kirim Tagihan',
][$inv['status']] ?? 'Kirim via WhatsApp';

if ($lastProofRejected && $inv['status'] === 'unpaid') {
    $waBtnLabel = 'Kirim Penolakan';
}

render_header($title, $active);
?>

<style>
    .dt-wrap { max-width: 1200px; }

    .dt-back {
        display:inline-flex; align-items:center; gap:6px;
        color:#6366f1; text-decoration:none; font-size:13px; font-weight:600;
        margin-bottom:14px; padding:6px 10px; border-radius:8px;
        transition:.15s;
    }
    .dt-back:hover { background:#eef2ff; }

    .dt-head {
        display:flex; justify-content:space-between; align-items:flex-start;
        margin-bottom:20px; gap:14px; flex-wrap:wrap;
    }
    .dt-head h2 {
        font-size:22px; font-weight:800; color:#0f172a;
        font-family:'Courier New', monospace; letter-spacing:-0.5px;
    }
    .dt-head p { font-size:13px; color:#64748b; margin-top:6px; display:flex; align-items:center; gap:6px; }
    .dt-head p .sep { color:#cbd5e1; }

    .dt-status {
        display:inline-flex; align-items:center; gap:7px;
        padding:9px 16px; border-radius:22px;
        font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.5px;
    }
    .dt-status .dot { width:7px; height:7px; border-radius:50%; background:currentColor; }

    /* Grid */
    .dt-grid { display:grid; grid-template-columns:1fr 380px; gap:18px; align-items:start; }

    .dt-card {
        background:#fff; border-radius:14px; padding:20px;
        border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);
        margin-bottom:16px;
    }
    .dt-card:last-child { margin-bottom:0; }

    .dt-card-hd {
        display:flex; align-items:center; gap:10px;
        margin-bottom:16px; padding-bottom:14px;
        border-bottom:1px solid #f1f5f9;
    }
    .dt-card-hd .ic {
        width:34px; height:34px; border-radius:9px;
        background:linear-gradient(135deg,#eef2ff,#e0e7ff); color:#6366f1;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .dt-card-hd h3 { font-size:14px; font-weight:700; color:#0f172a; }
    .dt-card-hd .count {
        margin-left:auto; font-size:12px; color:#94a3b8; font-weight:600;
        background:#f8fafc; padding:3px 9px; border-radius:12px;
    }

    .dt-desc {
        background:#f8fafc; padding:14px 16px; border-radius:10px;
        font-size:13.5px; color:#334155; line-height:1.65; margin-bottom:14px;
    }

    .dt-row {
        display:flex; justify-content:space-between; align-items:center;
        padding:10px 0; font-size:13px; border-bottom:1px solid #f8fafc;
        gap:14px;
    }
    .dt-row:last-child { border-bottom:none; }
    .dt-row .lbl { color:#94a3b8; display:flex; align-items:center; gap:6px; font-weight:500; }
    .dt-row .val { font-weight:600; color:#0f172a; text-align:right; }

    .item-line {
        display:flex; justify-content:space-between; align-items:flex-start;
        padding:12px 0; border-bottom:1px solid #f8fafc; font-size:13px; gap:14px;
    }
    .item-line:last-child { border-bottom:none; }
    .item-line .nm { font-weight:600; color:#0f172a; }
    .item-line .dtl { font-size:11.5px; color:#94a3b8; margin-top:3px; }
    .item-line .amt { font-weight:700; text-align:right; color:#0f172a; font-variant-numeric:tabular-nums; }

    .sum-block {
        background:linear-gradient(160deg, #0f172a 0%, #1e293b 100%);
        color:#fff; border-radius:12px; padding:18px; margin-top:16px;
    }
    .sum-block .line {
        display:flex; justify-content:space-between; padding:6px 0;
        font-size:13px; color:#cbd5e1; gap:8px;
    }
    .sum-block .line .v { font-variant-numeric:tabular-nums; font-weight:600; }
    .sum-block .line.diskon { color:#fca5a5; }
    .sum-block .line.tambah { color:#86efac; }
    .sum-block .total {
        display:flex; justify-content:space-between; align-items:center;
        padding-top:14px; margin-top:10px; border-top:1px solid rgba(255,255,255,0.15);
        font-size:14px; font-weight:700;
    }
    .sum-block .total .amt {
        color:#a5b4fc; font-size:22px; font-weight:800; font-variant-numeric:tabular-nums;
    }

    .proof-item {
        display:flex; gap:14px; padding:14px;
        background:#fafbff; border-radius:12px; margin-bottom:12px;
        border:1px solid #f1f5f9;
    }
    .proof-item:last-child { margin-bottom:0; }
    .proof-thumb {
        width:96px; height:96px; border-radius:10px; overflow:hidden;
        background:#e2e8f0; flex-shrink:0; cursor:zoom-in;
        border:1px solid #f1f5f9;
    }
    .proof-thumb img { width:100%; height:100%; object-fit:cover; }
    .proof-info { flex:1; min-width:0; }
    .proof-status {
        display:inline-flex; align-items:center; gap:6px;
        font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px;
        padding:4px 10px; border-radius:14px; margin-bottom:8px;
    }
    .proof-status .dot { width:6px; height:6px; border-radius:50%; background:currentColor; }
    .proof-meta { font-size:12px; color:#64748b; margin-top:3px; display:flex; align-items:center; gap:6px; }
    .proof-meta svg { color:#94a3b8; }

    .proof-btns { display:flex; gap:6px; margin-top:10px; flex-wrap:wrap; }
    .proof-btns .btn { padding:7px 12px; font-size:12px; }

    .proof-reject-note {
        background:#fee2e2; color:#991b1b; padding:8px 12px; border-radius:8px;
        font-size:12px; margin-top:8px; display:flex; align-items:flex-start; gap:6px;
    }

    .side-act { display:flex; flex-direction:column; gap:8px; }
    .side-act .btn { justify-content:center; width:100%; }

    .link-box {
        background:#f8fafc; border:1.5px dashed #cbd5e1; border-radius:10px;
        padding:12px; margin-bottom:14px;
    }
    .link-box .lb-txt {
        font-family:'Courier New', monospace; font-size:11px; color:#475569;
        word-break:break-all; margin-bottom:10px; line-height:1.5;
    }
    .link-box .lb-btn { display:flex; gap:8px; }
    .link-box .btn { flex:1; justify-content:center; font-size:12px; padding:8px 10px; }

    .wa-btn {
        background:linear-gradient(135deg,#25d366,#128c7e) !important;
        border:none !important;
    }
    .wa-btn:hover { opacity:.92; }

    .tpl-badge {
        display:inline-flex; align-items:center; gap:5px;
        font-size:10px; font-weight:700; text-transform:uppercase;
        letter-spacing:.5px; padding:3px 9px; border-radius:6px;
        background:#f0fdf4; color:#166534;
    }

    .timeline { position:relative; padding-left:26px; }
    .timeline::before {
        content:''; position:absolute; left:6px; top:8px; bottom:8px;
        width:2px; background:#f1f5f9; border-radius:1px;
    }
    .tl-item { position:relative; padding-bottom:18px; }
    .tl-item:last-child { padding-bottom:0; }
    .tl-dot {
        position:absolute; left:-26px; top:2px;
        width:14px; height:14px; border-radius:50%;
        background:#fff; border:3px solid #cbd5e1;
        box-sizing:border-box;
    }
    .tl-item.paid .tl-dot { border-color:#16a34a; }
    .tl-item.unpaid .tl-dot { border-color:#f59e0b; }
    .tl-item.waiting .tl-dot { border-color:#3b82f6; }
    .tl-item.rejected .tl-dot { border-color:#dc2626; }
    .tl-item.cancelled .tl-dot { border-color:#94a3b8; }
    .tl-title { font-size:13px; font-weight:600; color:#0f172a; }
    .tl-time { font-size:11px; color:#94a3b8; margin-top:2px; }
    .tl-desc { font-size:12px; color:#64748b; margin-top:4px; line-height:1.5; }

    .modal-overlay {
        display:none; position:fixed; inset:0; z-index:200;
        background:rgba(15,23,42,0.7); align-items:center; justify-content:center;
        padding:20px; backdrop-filter:blur(4px);
    }
    .modal-overlay.show { display:flex; animation: fadeIn .2s ease; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    .modal-content {
        background:#fff; border-radius:16px; padding:26px;
        max-width:460px; width:100%;
        box-shadow:0 20px 60px rgba(0,0,0,0.3);
        animation: popIn .25s ease;
    }
    @keyframes popIn { from { transform:scale(0.95); opacity:0; } to { transform:none; opacity:1; } }

    .modal-hd { display:flex; align-items:center; gap:12px; margin-bottom:14px; }
    .modal-hd .ic {
        width:42px; height:42px; border-radius:11px;
        background:#fee2e2; color:#dc2626;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .modal-hd h3 { font-size:17px; font-weight:700; color:#0f172a; }
    .modal-hd p { font-size:12px; color:#94a3b8; margin-top:2px; }

    .modal-content textarea {
        width:100%; padding:11px 13px; border:1.5px solid #e2e8f0;
        border-radius:9px; font-size:13.5px; font-family:inherit;
        margin-bottom:14px; min-height:80px;
    }
    .modal-content textarea:focus { outline:none; border-color:#dc2626; box-shadow:0 0 0 3px rgba(220,38,38,0.1); }
    .modal-btns { display:flex; gap:8px; }
    .modal-btns .btn { flex:1; justify-content:center; padding:11px; }

    .img-viewer {
        display:none; position:fixed; inset:0; z-index:300;
        background:rgba(0,0,0,0.92); align-items:center; justify-content:center;
        padding:20px; cursor:zoom-out;
    }
    .img-viewer.show { display:flex; }
    .img-viewer img { max-width:100%; max-height:100%; object-fit:contain; border-radius:8px; }

    .internal-note {
        background:#fef3c7; color:#78350f; padding:14px 16px;
        border-radius:10px; font-size:13px; line-height:1.6;
        display:flex; gap:10px; align-items:flex-start;
    }
    .internal-note svg { flex-shrink:0; margin-top:2px; color:#d97706; }

    @media (max-width:900px) {
        .dt-grid { grid-template-columns:1fr; }
        .proof-thumb { width:80px; height:80px; }
    }
    @media (max-width:640px) {
        .dt-head h2 { font-size:18px; }
        .dt-card { padding:16px; }
        .proof-item { flex-direction:column; }
        .proof-thumb { width:100%; height:180px; }
    }
</style>

<div class="dt-wrap">

    <a href="<?= url('invoice') ?>" class="dt-back">
        <?= dt_icon('arrowL', 15) ?> Kembali ke Daftar
    </a>

    <!-- ============ HEADER ============ -->
    <div class="dt-head">
        <div>
            <h2><?= e($inv['invoice_number']) ?></h2>
            <p>
                <span><?= dt_icon('user', 13) ?> <?= e($inv['nama_pembayar']) ?></span>
                <span class="sep">·</span>
                <span><?= dt_icon('phone', 13) ?> <?= e($inv['nomor_wa']) ?></span>
            </p>
        </div>
        <span class="dt-status" style="background:<?= $stBg ?>; color:<?= $stColor ?>;">
            <span class="dot"></span> <?= $stLbl ?>
        </span>
    </div>

    <div class="dt-grid">

        <!-- ============ KIRI ============ -->
        <div>

            <!-- DETAIL TAGIHAN -->
            <div class="dt-card">
                <div class="dt-card-hd">
                    <div class="ic"><?= dt_icon('file', 18) ?></div>
                    <h3>Detail Tagihan</h3>
                </div>

                <div class="dt-desc"><?= nl2br(e($inv['deskripsi'])) ?></div>

                <div class="dt-row">
                    <span class="lbl"><?= dt_icon('tag', 13) ?> Kategori</span>
                    <span class="val"><?= e($inv['kategori'] ?? '—') ?></span>
                </div>
                <div class="dt-row">
                    <span class="lbl"><?= dt_icon('calendar', 13) ?> Dibuat</span>
                    <span class="val"><?= tglIndo($inv['created_at']) ?></span>
                </div>
                <div class="dt-row">
                    <span class="lbl"><?= dt_icon('clock', 13) ?> Jatuh Tempo</span>
                    <span class="val"><?= tglIndo($inv['expired_at']) ?></span>
                </div>
                <?php if ($inv['email']): ?>
                <div class="dt-row">
                    <span class="lbl"><?= dt_icon('mail', 13) ?> Email</span>
                    <span class="val"><?= e($inv['email']) ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- RINCIAN BIAYA -->
            <div class="dt-card">
                <div class="dt-card-hd">
                    <div class="ic"><?= dt_icon('dollar', 18) ?></div>
                    <h3>Rincian Biaya</h3>
                </div>

                <?php foreach ($items as $it): ?>
                    <div class="item-line">
                        <div>
                            <div class="nm"><?= e($it['nama_item']) ?></div>
                            <div class="dtl"><?= rupiah($it['harga_satuan']) ?> × <?= (float)$it['qty'] ?></div>
                        </div>
                        <div class="amt"><?= rupiah($it['subtotal']) ?></div>
                    </div>
                <?php endforeach; ?>

                <div class="sum-block">
                    <div class="line">
                        <span>Subtotal</span>
                        <span class="v"><?= rupiah($inv['subtotal']) ?></span>
                    </div>

                    <?php foreach ($adjs as $ad): ?>
                        <?php if ($ad['tipe'] === 'diskon'): ?>
                            <div class="line diskon">
                                <span><?= e($ad['label']) ?></span>
                                <span class="v">− <?= rupiah($ad['hasil']) ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php foreach ($adjs as $ad): ?>
                        <?php if (in_array($ad['tipe'], ['biaya_admin','pajak'])): ?>
                            <div class="line tambah">
                                <span><?= e($ad['label']) ?></span>
                                <span class="v">+ <?= rupiah($ad['hasil']) ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($inv['kode_unik'] > 0): ?>
                        <div class="line tambah">
                            <span>Kode Unik</span>
                            <span class="v">+ <?= rupiah($inv['kode_unik']) ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="total">
                        <span>TOTAL</span>
                        <span class="amt"><?= rupiah($inv['total']) ?></span>
                    </div>
                </div>
            </div>

            <!-- BUKTI BAYAR -->
            <?php if (!empty($proofs)): ?>
            <div class="dt-card">
                <div class="dt-card-hd">
                    <div class="ic"><?= dt_icon('image', 18) ?></div>
                    <h3>Bukti Bayar</h3>
                    <span class="count"><?= count($proofs) ?> file</span>
                </div>

                <?php foreach ($proofs as $p): ?>
                    <?php
                    $pUrl = file_exists(UPLOAD_PATH . '/' . $p['gambar']) ? UPLOAD_URL . '/' . $p['gambar'] : null;
                    $pMeta = [
                        'waiting'  => ['Menunggu', '#d97706', '#fef3c7'],
                        'approved' => ['Disetujui', '#16a34a', '#dcfce7'],
                        'rejected' => ['Ditolak', '#dc2626', '#fee2e2'],
                    ][$p['status']] ?? ['Unknown', '#888', '#f1f5f9'];
                    ?>
                    <div class="proof-item">
                        <?php if ($pUrl): ?>
                            <div class="proof-thumb" onclick="viewImage('<?= $pUrl ?>')">
                                <img src="<?= $pUrl ?>" alt="bukti">
                            </div>
                        <?php endif; ?>
                        <div class="proof-info">
                            <span class="proof-status" style="background:<?= $pMeta[2] ?>; color:<?= $pMeta[1] ?>;">
                                <span class="dot"></span> <?= $pMeta[0] ?>
                            </span>

                            <div class="proof-meta">
                                <?= dt_icon('card', 13) ?> <?= e($p['metode_nama'] ?? 'Tanpa metode') ?>
                            </div>
                            <div class="proof-meta">
                                <?= dt_icon('clock', 13) ?> <?= tglIndo($p['uploaded_at']) ?>
                            </div>
                            <?php if ($p['catatan_user']): ?>
                                <div class="proof-meta">
                                    <?= dt_icon('message', 13) ?> <?= e($p['catatan_user']) ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($p['status'] === 'rejected' && $p['alasan_reject']): ?>
                                <div class="proof-reject-note">
                                    <?= dt_icon('alert', 14) ?>
                                    <span><?= e($p['alasan_reject']) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($p['status'] === 'waiting'): ?>
                                <div class="proof-btns">
                                    <form method="POST" onsubmit="return confirm('Setujui bukti ini?');" style="display:inline;">
                                        <input type="hidden" name="post_action" value="approve">
                                        <input type="hidden" name="proof_id" value="<?= $p['id'] ?>">
                                        <button class="btn" style="background:linear-gradient(135deg,#16a34a,#22c55e);">
                                            <?= dt_icon('check', 13) ?> Setujui
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-danger"
                                            onclick="openReject(<?= $p['id'] ?>, '<?= e($inv['invoice_number']) ?>')">
                                        <?= dt_icon('x', 13) ?> Tolak
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- CATATAN INTERNAL -->
            <?php if (!empty($inv['internal_note'])): ?>
            <div class="dt-card">
                <div class="dt-card-hd">
                    <div class="ic" style="background:#fef3c7; color:#d97706;"><?= dt_icon('lock', 18) ?></div>
                    <h3>Catatan Internal</h3>
                </div>
                <div class="internal-note">
                    <?= dt_icon('info', 16) ?>
                    <div><?= nl2br(e($inv['internal_note'])) ?></div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- ============ KANAN ============ -->
        <div>

            <!-- LINK PEMBAYARAN -->
            <div class="dt-card">
                <div class="dt-card-hd">
                    <div class="ic"><?= dt_icon('link', 18) ?></div>
                    <h3>Link Pembayaran</h3>
                </div>

                <div class="link-box">
                    <div class="lb-txt"><?= e($payLink) ?></div>
                    <div class="lb-btn">
                        <button type="button" class="btn btn-outline" onclick="copyLink('<?= e($payLink) ?>', this)">
                            <?= dt_icon('copy', 13) ?> Copy
                        </button>
                        <a href="<?= e($payLink) ?>" target="_blank" class="btn btn-outline">
                            <?= dt_icon('eye', 13) ?> Preview
                        </a>
                    </div>
                </div>

                <div class="side-act">
                    <div class="tpl-badge">
                        <?= dt_icon('message', 11) ?> Template: <?= e($target_tipe) ?>
                    </div>
                    <a href="https://wa.me/<?= $waNum ?>?text=<?= urlencode($waText) ?>"
                       target="_blank" class="btn wa-btn">
                        <?= dt_wa_filled(16) ?> <?= e($waBtnLabel) ?>
                    </a>
                </div>
            </div>

            <!-- AKSI -->
            <div class="dt-card">
                <div class="dt-card-hd">
                    <div class="ic"><?= dt_icon('activity', 18) ?></div>
                    <h3>Aksi</h3>
                </div>

                <div class="side-act">
                    <?php if ($inv['status'] === 'unpaid'): ?>
                        <form method="POST" onsubmit="return confirm('Tandai lunas?');">
                            <input type="hidden" name="post_action" value="mark_paid">
                            <button class="btn" style="background:linear-gradient(135deg,#16a34a,#22c55e);">
                                <?= dt_icon('checkCircle', 15) ?> Tandai Lunas
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if (in_array($inv['status'], ['unpaid','waiting','rejected'])): ?>
                        <form method="POST" onsubmit="return confirm('Batalkan tagihan ini?');">
                            <input type="hidden" name="post_action" value="cancel">
                            <button class="btn btn-outline" style="color:#d97706; border-color:#fde68a;">
                                <?= dt_icon('ban', 15) ?> Batalkan
                            </button>
                        </form>
                    <?php endif; ?>

                    <form method="POST" onsubmit="return confirm('Hapus tagihan permanen?');">
                        <input type="hidden" name="post_action" value="delete">
                        <button class="btn btn-danger">
                            <?= dt_icon('trash', 15) ?> Hapus Tagihan
                        </button>
                    </form>
                </div>
            </div>

            <!-- TIMELINE -->
            <?php if (!empty($logs)): ?>
            <div class="dt-card">
                <div class="dt-card-hd">
                    <div class="ic"><?= dt_icon('activity', 18) ?></div>
                    <h3>Timeline</h3>
                </div>

                <div class="timeline">
                    <?php foreach ($logs as $log): ?>
                        <div class="tl-item <?= e($log['status_baru']) ?>">
                            <div class="tl-dot"></div>
                            <div class="tl-title"><?= ucfirst($log['status_baru']) ?></div>
                            <div class="tl-time"><?= tglIndo($log['created_at']) ?></div>
                            <?php if ($log['keterangan']): ?>
                                <div class="tl-desc"><?= e($log['keterangan']) ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<!-- Modal Reject -->
<div class="modal-overlay" id="rejectModal">
    <div class="modal-content">
        <div class="modal-hd">
            <div class="ic"><?= dt_icon('x', 20) ?></div>
            <div>
                <h3>Tolak Bukti Bayar</h3>
                <p>Bukti untuk <strong id="rejInv"></strong> akan ditolak</p>
            </div>
        </div>

        <form method="POST" id="rejForm">
            <input type="hidden" name="post_action" value="reject">
            <input type="hidden" name="proof_id" id="rejPid">

            <label style="display:block; font-size:12px; font-weight:600; color:#334155; margin-bottom:6px;">
                Alasan Penolakan <span style="color:#dc2626;">*</span>
            </label>
            <textarea name="alasan" required placeholder="misal: nominal transfer tidak sesuai / bukti tidak jelas"></textarea>

            <div class="modal-btns">
                <button type="submit" class="btn btn-danger">
                    <?= dt_icon('x', 15) ?> Tolak
                </button>
                <button type="button" class="btn btn-outline" onclick="closeReject()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Image Viewer -->
<div class="img-viewer" id="imgViewer" onclick="this.classList.remove('show')">
    <img id="imgViewerSrc" src="">
</div>

<script>
function copyLink(text, btn) {
    const orig = btn.innerHTML;
    const done = () => {
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;"><polyline points="20 6 9 17 4 12"/></svg> Tersalin!';
        btn.style.background = '#dcfce7';
        btn.style.color = '#166534';
        btn.style.borderColor = '#bbf7d0';
        setTimeout(() => {
            btn.innerHTML = orig;
            btn.style.background = '';
            btn.style.color = '';
            btn.style.borderColor = '';
        }, 1500);
    };

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(done).catch(() => fallbackCopy(text, done));
    } else {
        fallbackCopy(text, done);
    }
}
function fallbackCopy(text, cb) {
    const t = document.createElement('textarea');
    t.value = text; t.style.position = 'fixed'; t.style.opacity = '0';
    document.body.appendChild(t); t.select();
    try { document.execCommand('copy'); cb(); } catch(e) { alert('Copy gagal'); }
    document.body.removeChild(t);
}

function openReject(pid, inv) {
    document.getElementById('rejPid').value = pid;
    document.getElementById('rejInv').textContent = inv;
    document.getElementById('rejectModal').classList.add('show');
    setTimeout(() => document.querySelector('#rejForm textarea').focus(), 100);
}
function closeReject() {
    document.getElementById('rejectModal').classList.remove('show');
    document.getElementById('rejForm').reset();
}
function viewImage(src) {
    document.getElementById('imgViewerSrc').src = src;
    document.getElementById('imgViewer').classList.add('show');
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeReject();
        document.getElementById('imgViewer').classList.remove('show');
    }
});
</script>

<?php render_footer(); ?>