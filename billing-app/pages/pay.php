<?php
// ============ ROUTE ============
$route = $_GET['url'] ?? '';
$parts = explode('/', $route);
$token = $parts[1] ?? '';
if (!$token) { http_response_code(404); die('Link tidak valid.'); }

// ============ ICON SVG ============
function py_icon($name, $size = 20, $stroke = 2) {
    $icons = [
        'clock'      => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'check'      => '<polyline points="20 6 9 17 4 12"/>',
        'checkCircle'=> '<circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/>',
        'x'          => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'xCircle'    => '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>',
        'alert'      => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
        'info'       => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
        'copy'       => '<rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>',
        'upload'     => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>',
        'image'      => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>',
        'creditCard' => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        'bank'       => '<path d="M3 21h18"/><path d="M5 21V10l7-5 7 5v11"/><path d="M9 21v-6h6v6"/>',
        'wallet'     => '<path d="M20 12V8H6a2 2 0 0 1 0-4h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/>',
        'qris'       => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="3" height="3"/><line x1="21" y1="14" x2="21" y2="17"/><line x1="14" y1="21" x2="17" y2="21"/>',
        'lock'       => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'arrowR'     => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'arrowL'     => '<line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>',
        'arrowDown'  => '<line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>',
        'chevD'      => '<polyline points="6 9 12 15 18 9"/>',
        'hourglass'  => '<path d="M6 2h12M6 22h12M6 2v4a6 6 0 0 0 6 6 6 6 0 0 0 6-6V2M6 22v-4a6 6 0 0 1 6-6 6 6 0 0 1 6 6v4"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="'.$stroke.'" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$path.'</svg>';
}

function py_wa_filled($size = 20) {
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413"/></svg>';
}

// ============ FETCH ============
$stmt = $pdo->prepare("SELECT i.*, c.nama AS kategori FROM invoices i LEFT JOIN categories c ON c.id = i.kategori_id WHERE i.token = ?");
$stmt->execute([$token]);
$inv = $stmt->fetch();
if (!$inv) { http_response_code(404); die('Tagihan tidak ditemukan.'); }

if (strtotime($inv['expired_at']) < time() && $inv['status'] === 'unpaid') {
    $pdo->prepare("UPDATE invoices SET status='expired' WHERE id=?")->execute([$inv['id']]);
    $inv['status'] = 'expired';
}

$pdo->prepare("UPDATE invoices SET dibuka_kali = dibuka_kali + 1, terakhir_dibuka = NOW() WHERE id=?")->execute([$inv['id']]);
$pdo->prepare("INSERT INTO activity_logs (invoice_id, aktivitas, ip_address) VALUES (?, 'link_dibuka', ?)")
    ->execute([$inv['id'], $_SERVER['REMOTE_ADDR'] ?? null]);

$items = $pdo->prepare("SELECT * FROM invoice_items WHERE invoice_id=? ORDER BY urutan, id");
$items->execute([$inv['id']]);
$items = $items->fetchAll();

$adjs = $pdo->prepare("SELECT * FROM invoice_adjustments WHERE invoice_id=? ORDER BY urutan, id");
$adjs->execute([$inv['id']]);
$adjs = $adjs->fetchAll();

$methods = $pdo->prepare("SELECT pm.* FROM payment_methods pm JOIN invoice_methods im ON im.payment_method_id = pm.id WHERE im.invoice_id = ? AND pm.aktif = 1 ORDER BY pm.urutan, pm.id");
$methods->execute([$inv['id']]);
$methods = $methods->fetchAll();

$proofs = $pdo->prepare("SELECT * FROM payment_proofs WHERE invoice_id=? ORDER BY uploaded_at DESC");
$proofs->execute([$inv['id']]);
$proofs = $proofs->fetchAll();

$lockedMethodId = null;
$lockSisaDetik = 0;
if (!empty($inv['locked_method_id']) && !empty($inv['locked_until']) && strtotime($inv['locked_until']) > time()) {
    $lockedMethodId = (int)$inv['locked_method_id'];
    $lockSisaDetik = strtotime($inv['locked_until']) - time();
}
if (!empty($inv['locked_method_id']) && !empty($inv['locked_until']) && strtotime($inv['locked_until']) <= time()) {
    $pdo->prepare("UPDATE invoices SET locked_method_id=NULL, locked_until=NULL WHERE id=?")->execute([$inv['id']]);
    $inv['locked_method_id'] = null;
}

$lastProof = $proofs[0] ?? null;
$hasRejectedProof = ($lastProof && $lastProof['status'] === 'rejected');
$latestRejectReason = '';
if ($hasRejectedProof && !empty($lastProof['alasan_reject'])) {
    $latestRejectReason = $lastProof['alasan_reject'];
}

if ($hasRejectedProof && $inv['status'] === 'unpaid' && $lockedMethodId) {
    $pdo->prepare("UPDATE invoices SET locked_method_id=NULL, locked_until=NULL WHERE id=?")->execute([$inv['id']]);
    $lockedMethodId = null;
    $lockSisaDetik = 0;
}

$statusMeta = [
    'unpaid'    => ['Belum Bayar', '#d97706', '#fef3c7'],
    'waiting'   => ['Menunggu Konfirmasi', '#2563eb', '#dbeafe'],
    'paid'      => ['Lunas', '#16a34a', '#dcfce7'],
    'rejected'  => ['Bukti Ditolak', '#dc2626', '#fee2e2'],
    'expired'   => ['Kadaluarsa', '#64748b', '#f1f5f9'],
    'cancelled' => ['Dibatalkan', '#64748b', '#f1f5f9'],
];
if ($hasRejectedProof && $inv['status'] === 'unpaid') {
    list($stLbl, $stColor, $stBg) = ['Perlu Upload Ulang', '#dc2626', '#fee2e2'];
} else {
    list($stLbl, $stColor, $stBg) = $statusMeta[$inv['status']] ?? ['Unknown', '#888', '#f1f5f9'];
}

$canPay = in_array($inv['status'], ['unpaid','rejected']);
$isWaiting = $inv['status'] === 'waiting';
$isPaid = $inv['status'] === 'paid';
$isExpired = $inv['status'] === 'expired';
$isCancelled = $inv['status'] === 'cancelled';
$showRejectedPanel = ($hasRejectedProof && $inv['status'] === 'unpaid');
$hasActiveLock = ($lockedMethodId && $lockSisaDetik > 0);
$showPendingOnly = ($hasActiveLock && $canPay && !$showRejectedPanel);

$bisnisNama = setting('nama_bisnis', APP_NAME);
$logo = setting('logo');
$footer = setting('footer_text', 'Terima kasih telah melakukan pembayaran.');

$waNumber = preg_replace('/[^0-9]/', '', setting('kontak_admin', ''));
if (substr($waNumber, 0, 1) === '0') $waNumber = '62' . substr($waNumber, 1);

$adminPenerbit = 'System';
if (!empty($inv['created_by'])) {
    $stmtAdm = $pdo->prepare("SELECT nama FROM admins WHERE id = ?");
    $stmtAdm->execute([$inv['created_by']]);
    $adminPenerbit = $stmtAdm->fetchColumn() ?: 'System';
}

$alamatBisnis = setting('alamat', '');
if (empty($alamatBisnis)) {
    $alamatBisnis = 'Jalan Taduan No. 6, Sidorejo, Medan Tembung, Sumatera Utara';
}

$sisaDetik = max(0, strtotime($inv['expired_at']) - time());
$jam = floor($sisaDetik / 3600);
$menit = floor(($sisaDetik % 3600) / 60);

$lockedMethodData = null;
if ($lockedMethodId) {
    foreach ($methods as $m) {
        if ((int)$m['id'] === (int)$lockedMethodId) { $lockedMethodData = $m; break; }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="theme-color" content="#ffffff">
<title><?= e($inv['invoice_number']) ?> — <?= e($bisnisNama) ?></title>
<style>
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }
html { -webkit-text-size-adjust: 100%; }
body {
    font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, sans-serif;
    background: #f5f5f7; color: #1d1d1f;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    line-height: 1.5; overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}
button, input, textarea, select { font-family: inherit; }
img { max-width: 100%; display: block; }

.py-print-btn { display: inline-flex; align-items: center; gap: 9px; padding: 13px 24px; margin-top: 20px; background: #1d1d1f; color: #fff; border: none; border-radius: 13px; font-size: 13.5px; font-weight: 700; cursor: pointer; transition: transform .2s cubic-bezier(.22,1,.36,1), box-shadow .2s; font-family: inherit; box-shadow: 0 6px 18px rgba(0,0,0,.15); }
.py-print-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,.25); }

.py-verify { position: fixed; inset: 0; z-index: 5000; background: #fff; display: flex; align-items: center; justify-content: center; padding: 40px 30px; text-align: center; transition: opacity .4s ease, visibility .4s ease; }
.py-verify.hide { opacity: 0; visibility: hidden; pointer-events: none; }
.vy-inner { display: flex; flex-direction: column; align-items: center; animation: vyFadeIn .5s cubic-bezier(.22,1,.36,1); }
@keyframes vyFadeIn { from { opacity: 0; transform: scale(.95); } to { opacity: 1; transform: scale(1); } }
.vy-spinner { width: 52px; height: 52px; position: relative; margin-bottom: 22px; }
.vy-spinner::before { content: ''; position: absolute; inset: 0; border-radius: 50%; border: 3px solid #f0f0f0; }
.vy-spinner::after { content: ''; position: absolute; inset: 0; border-radius: 50%; border: 3px solid transparent; border-top-color: #1d1d1f; border-right-color: #1d1d1f; animation: vySpin 1s cubic-bezier(.5,0,.5,1) infinite; }
@keyframes vySpin { to { transform: rotate(360deg); } }
.vy-title { font-size: 16px; font-weight: 600; color: #1d1d1f; letter-spacing: -0.3px; margin-bottom: 5px; min-height: 22px; }
.vy-sub { font-size: 13px; color: #86868b; min-height: 18px; }
.vy-bar { position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #f0f0f0; overflow: hidden; }
.vy-bar span { display: block; height: 100%; width: 0%; background: linear-gradient(90deg, #0071e3, #1d1d1f); transition: width .4s cubic-bezier(.22,1,.36,1); }

.py-wrap { max-width: 520px; width: 100%; margin: 0 auto; padding: 20px 16px 0; flex: 1; display: flex; flex-direction: column; }

/* ============ HEADER ============ */
.py-head {
    position: relative;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
    padding: 16px 18px;
    border-radius: 22px;
    background: linear-gradient(135deg, #fafbff 0%, #f5f7ff 45%, #eef2ff 100%);
    border: 1px solid rgba(226,232,240,.85);
    box-shadow:
        0 10px 30px -10px rgba(99,102,241,.18),
        0 2px 6px rgba(15,23,42,.03),
        inset 0 1px 0 rgba(255,255,255,.9);
    overflow: hidden;
    isolation: isolate;
    animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both;
}
.py-head::after {
    content: '';
    position: absolute;
    bottom: 0; left: 12%; right: 12%;
    height: 1.5px;
    background: linear-gradient(90deg, transparent, rgba(99,102,241,.55), transparent);
    z-index: 2;
    pointer-events: none;
}
.py-head-glow { position: absolute; inset: 0; border-radius: inherit; overflow: hidden; z-index: 0; pointer-events: none; }
.py-head-glow::before,
.py-head-glow::after { content: ''; position: absolute; width: 180px; height: 180px; border-radius: 50%; filter: blur(34px); will-change: transform; }
.py-head-glow::before { top: -90px; right: -50px; background: radial-gradient(circle, rgba(99,102,241,.30), transparent 70%); animation: headGlowA 7s ease-in-out infinite; }
.py-head-glow::after { bottom: -100px; left: -40px; background: radial-gradient(circle, rgba(139,92,246,.22), transparent 70%); animation: headGlowB 9s ease-in-out infinite; }
@keyframes headGlowA { 0%,100% { transform: translate(0,0) scale(1); } 50% { transform: translate(-14px, 16px) scale(1.15); } }
@keyframes headGlowB { 0%,100% { transform: translate(0,0) scale(1); } 50% { transform: translate(16px, -12px) scale(1.12); } }

.py-logo { position: relative; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: visible; z-index: 1; }
.py-logo-glow { position: absolute; inset: -6px; border-radius: 50%; background: conic-gradient(from 0deg, #6366f1, #8b5cf6, #ec4899, #6366f1); filter: blur(10px); opacity: .28; z-index: -1; animation: logoSpin 8s linear infinite; }
@keyframes logoSpin { to { transform: rotate(360deg); } }
.py-logo img { width: 100%; height: 100%; object-fit: contain; position: relative; z-index: 1; }
.py-logo .py-logo-txt { font-size: 30px; font-weight: 800; color: #6366f1; letter-spacing: -1.2px; position: relative; z-index: 1; }
.py-logo .py-logo-txt span { color: #1d1d1f; }

.py-head-txt { flex: 1; min-width: 0; position: relative; z-index: 1; }
.py-head-txt h1 { font-size: 17.5px; font-weight: 800; color: #0f172a; letter-spacing: -.3px; line-height: 1.2; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.py-head-txt p { font-size: 12px; color: #64748b; margin-top: 5px; font-weight: 600; display: flex; align-items: center; min-height: 16px; white-space: nowrap; overflow: hidden; }
.py-head-txt p .py-live-dot { flex-shrink: 0; }
.py-typed { color: #475569; }
.py-cursor { display: inline-block; width: 2px; height: 12px; background: #6366f1; margin-left: 2px; border-radius: 1px; vertical-align: -1px; animation: blinkCursor 1s step-end infinite; }
@keyframes blinkCursor { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
.py-live-dot { display: inline-block; width: 7px; height: 7px; border-radius: 50%; background: #22c55e; margin-right: 7px; box-shadow: 0 0 0 0 rgba(34,197,94,.55); animation: livePulse 2s ease-out infinite; }
@keyframes livePulse { 0% { box-shadow: 0 0 0 0 rgba(34,197,94,.55); } 70% { box-shadow: 0 0 0 8px rgba(34,197,94,0); } 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); } }

.py-head-shield { position: relative; z-index: 1; width: 36px; height: 36px; border-radius: 12px; background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(22,163,74,.25); animation: shieldPulse 2.6s ease-in-out infinite; }
@keyframes shieldPulse { 0%,100% { transform: scale(1); box-shadow: 0 4px 12px rgba(22,163,74,.25); } 50% { transform: scale(1.07); box-shadow: 0 8px 18px rgba(22,163,74,.4); } }

/* ============ BILL — SPLIT ROW (NO CARD) ============ */
.py-bill { margin: 20px 0 24px; animation: fadeUp .5s .1s cubic-bezier(.22,1,.36,1) both; }

/* Topbar: status pill + invoice info */
.pb-topbar { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
.pb-topbar .pt-status { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .8px; display: inline-flex; align-items: center; gap: 6px; padding: 5px 11px; border-radius: 20px; flex-shrink: 0; margin-top: 2px; }
.pb-topbar .pt-status .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.pt-inv-wrap { text-align: right; min-width: 0; }
.pt-inv-wrap .pt-inv { font-family: 'SF Mono', Monaco, 'Courier New', monospace; font-size: 12px; font-weight: 700; color: #475569; letter-spacing: .3px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.pt-inv-wrap .pt-pub { font-size: 10px; color: #94a3b8; margin-top: 3px; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.pt-inv-wrap .pt-pub strong { color: #64748b; font-weight: 700; }

/* Divider lines */
.pb-line { height: 2px; background: #0f172a; margin: 14px 0 22px; border-radius: 1px; }
.pb-line.thin { height: 0; background: transparent; border-top: 1px solid #e2e8f0; margin: 20px 0; }

/* Info blocks */
.pb-block { margin-bottom: 20px; }
.pb-block:last-child { margin-bottom: 0; }
.pb-block .pb-lbl { font-size: 10.5px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 6px; display: block; }
.pb-block .pb-val { font-size: 15px; font-weight: 700; color: #0f172a; line-height: 1.45; word-break: break-word; }

/* Timer block */
.pb-block.pb-timer-block .pb-val { font-family: 'SF Mono', Monaco, 'Courier New', monospace; font-size: 24px; font-weight: 800; letter-spacing: 1.5px; font-variant-numeric: tabular-nums; color: #0f172a; line-height: 1; margin-bottom: 6px; transition: color .3s; }
.pb-block.pb-timer-block .pb-sub { font-size: 12px; color: #94a3b8; font-weight: 600; }
.pb-block.pb-timer-block.warn .pb-val { color: #ea580c; }
.pb-block.pb-timer-block.warn .pb-sub { color: #c2410c; }
.pb-block.pb-timer-block.danger .pb-val { color: #dc2626; animation: dangerPulse 1s ease-in-out infinite; }
.pb-block.pb-timer-block.danger .pb-sub { color: #b91c1c; }
@keyframes dangerPulse { 0%, 100% { opacity: 1; } 50% { opacity: .55; } }

/* Total */
.pb-total { margin-top: 4px; }
.pb-total .pb-total-lbl { font-size: 10.5px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 8px; display: block; }
.pb-total .pb-total-val { font-size: 32px; font-weight: 800; color: #0f172a; letter-spacing: -.8px; font-variant-numeric: tabular-nums; line-height: 1; }

/* Pay button */
.pb-pay-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    border: none;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 800;
    letter-spacing: .2px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin-top: 22px;
    box-shadow: 0 10px 24px rgba(99,102,241,.32);
    transition: transform .2s cubic-bezier(.22,1,.36,1), box-shadow .2s;
    font-family: inherit;
}
.pb-pay-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(99,102,241,.42); }
.pb-pay-btn:active { transform: translateY(0) scale(.98); }
.pb-pay-btn svg { flex-shrink: 0; }

/* Note */
.pb-note { display: flex; gap: 10px; font-size: 12.5px; color: #78350f; line-height: 1.55; margin-top: 16px; padding: 12px 14px; background: #fffbeb; border-radius: 10px; }
.pb-note svg { flex-shrink: 0; margin-top: 2px; color: #d97706; }

/* Toggle rincian */
.py-toggle { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 12px 0; background: transparent; border: none; cursor: pointer; font-size: 13px; font-weight: 700; color: #6366f1; transition: color .2s; font-family: inherit; }
.py-toggle:hover { color: #4338ca; }
.py-toggle svg { transition: transform .3s cubic-bezier(.22,1,.36,1); }
.py-toggle.open svg { transform: rotate(180deg); }
.py-detail { max-height: 0; overflow: hidden; transition: max-height .35s cubic-bezier(.22,1,.36,1); }
.py-detail.open { max-height: 1000px; }
.py-detail-inner { padding-bottom: 6px; }

.py-row { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; padding: 6px 0; font-size: 12.5px; }
.py-row .rl { color: #64748b; font-weight: 500; flex-shrink: 0; }
.py-row .rv { color: #0f172a; font-weight: 700; text-align: right; word-break: break-word; }
.py-divider { height: 1px; background: #f1f5f9; margin: 8px 0; }

/* Reject box */
.py-reject-box { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-radius: 18px; padding: 18px; margin-bottom: 16px; display: flex; gap: 14px; align-items: flex-start; border: 1px solid rgba(220,38,38,.12); animation: fadeUp .5s .05s cubic-bezier(.22,1,.36,1) both; }
.py-reject-box .rb-icon { width: 44px; height: 44px; border-radius: 12px; background: #fff; color: #dc2626; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(220,38,38,.15); }
.py-reject-box .rb-body { flex: 1; min-width: 0; }
.py-reject-box .rb-title { font-size: 14px; font-weight: 800; color: #991b1b; margin-bottom: 6px; }
.py-reject-box .rb-reason { font-size: 13px; color: #b91c1c; line-height: 1.55; background: rgba(255,255,255,.5); padding: 10px 12px; border-radius: 10px; font-style: italic; }
.py-reject-box .rb-hint { font-size: 12px; color: #991b1b; margin-top: 10px; opacity: .85; display: flex; align-items: center; gap: 5px; }

.py-pending-card { background: #fff; border-radius: 20px; padding: 30px 24px; text-align: center; box-shadow: 0 8px 32px rgba(15,23,42,.06); animation: fadeUp .5s .08s cubic-bezier(.22,1,.36,1) both; margin-bottom: 16px; border: 1px solid #f1f5f9; }
.py-pending-card .pc-icon { width: 76px; height: 76px; border-radius: 50%; background: linear-gradient(135deg,#eef2ff,#e0e7ff); color: #6366f1; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; }
.py-pending-card h3 { font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 8px; letter-spacing: -.3px; }
.py-pending-card p { font-size: 13.5px; color: #64748b; line-height: 1.6; margin: 0 auto 20px; max-width: 320px; }
.py-pending-card .pc-total { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: #f8fafc; border-radius: 12px; font-size: 12px; color: #64748b; margin-bottom: 22px; font-weight: 600; }
.py-pending-card .pc-total strong { font-size: 16px; color: #0f172a; font-variant-numeric: tabular-nums; letter-spacing: -.3px; }
.py-pending-card .pc-btn { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border: none; border-radius: 13px; font-size: 14px; font-weight: 700; cursor: pointer; box-shadow: 0 8px 22px rgba(99,102,241,.32); transition: transform .2s cubic-bezier(.22,1,.36,1), box-shadow .2s; font-family: inherit; }
.py-pending-card .pc-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(99,102,241,.4); }
.py-pending-card .pc-hint { font-size: 11.5px; color: #94a3b8; margin-top: 14px; display: flex; align-items: center; justify-content: center; gap: 5px; }

.py-sec { margin: 20px 4px 12px; }
.py-sec.reveal { animation: revealDown .5s cubic-bezier(.22,1,.36,1); }
@keyframes revealDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
.py-sec-hd { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
.py-sec-hd .ic { width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg,#eef2ff,#e0e7ff); color: #6366f1; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.py-sec-hd h2 { font-size: 15px; font-weight: 800; color: #0f172a; letter-spacing: -.2px; }
.py-sec-hd p { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }

.py-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.py-method { background: #fff; border: 2px solid transparent; border-radius: 18px; padding: 18px 12px; cursor: pointer; transition: transform .2s cubic-bezier(.22,1,.36,1), box-shadow .2s, border-color .2s; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 2px 10px rgba(15,23,42,.04); font-family: inherit; aspect-ratio: 1; position: relative; overflow: hidden; }
.py-method:hover:not(.locked):not(.disabled) { transform: translateY(-3px); border-color: #c7d2fe; box-shadow: 0 12px 28px rgba(99,102,241,.15); }
.py-method:active:not(.locked):not(.disabled) { transform: translateY(0) scale(.97); }
.py-method .pm-icon {
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background: #fff;
    border-radius: 14px;
    padding: 9px;
    box-shadow: inset 0 0 0 1px rgba(15,23,42,.06), 0 1px 3px rgba(15,23,42,.05);
}
.py-method .pm-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}
.py-method .pm-icon svg { color: #6366f1; width: 36px; height: 36px; }
.py-method .pm-nm { font-size: 12.5px; font-weight: 700; color: #0f172a; text-align: center; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; }
.py-method .pm-type { font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; font-weight: 600; text-align: center; }
.py-method.locked { border-color: #6366f1; background: #eef2ff; cursor: default; box-shadow: 0 8px 24px rgba(99,102,241,.2); }
.py-method.locked .pm-icon svg { color: #4338ca; }
.py-method .pm-lock-badge { position: absolute; top: 8px; right: 8px; background: #16a34a; color: #fff; padding: 3px 8px; border-radius: 10px; font-size: 9.5px; font-weight: 800; letter-spacing: .5px; font-variant-numeric: tabular-nums; display: flex; align-items: center; gap: 4px; box-shadow: 0 4px 10px rgba(22,163,74,.35); }
.py-method.disabled { opacity: .4; cursor: not-allowed; filter: grayscale(.6); }
.py-method .pm-lock-overlay { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(241,245,249,.7); color: #64748b; }

.py-status-card { background: #fff; border-radius: 20px; padding: 32px 22px; text-align: center; box-shadow: 0 8px 32px rgba(15,23,42,.06); animation: fadeUp .4s cubic-bezier(.22,1,.36,1) both; margin-bottom: 16px; }
.py-status-card .sc-icon { width: 84px; height: 84px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; }
.py-status-card .sc-icon svg { width: 40px !important; height: 40px !important; }
.py-status-card h3 { font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 8px; letter-spacing: -.3px; }
.py-status-card p { font-size: 13.5px; color: #64748b; line-height: 1.6; max-width: 320px; margin: 0 auto; }

.py-dots { display: inline-flex; gap: 4px; margin-left: 6px; vertical-align: middle; }
.py-dots span { width: 5px; height: 5px; border-radius: 50%; background: currentColor; animation: dotBounce 1.4s ease-in-out infinite; }
.py-dots span:nth-child(2) { animation-delay: .15s; }
.py-dots span:nth-child(3) { animation-delay: .3s; }
@keyframes dotBounce { 0%,80%,100% { transform: scale(.6); opacity: .4; } 40% { transform: scale(1); opacity: 1; } }

.py-upload { max-height: 0; overflow: hidden; transition: max-height .4s cubic-bezier(.22,1,.36,1); margin-bottom: 0; }
.py-upload.open { max-height: 1500px; margin-bottom: 16px; }
.py-upload-inner { background: #fff; border-radius: 20px; padding: 22px 20px; box-shadow: 0 8px 32px rgba(15,23,42,.06); }
.py-upload-hd { display: flex; gap: 12px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #f1f5f9; }
.py-upload-hd .ic { width: 38px; height: 38px; border-radius: 11px; background: linear-gradient(135deg,#dcfce7,#bbf7d0); color: #16a34a; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.py-upload-hd h3 { font-size: 14px; font-weight: 800; color: #0f172a; }
.py-upload-hd p { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }

.py-field { margin-bottom: 14px; }
.py-field label { display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 7px; }
.py-field label .req { color: #ef4444; }
.py-upload-box { border: 2px dashed #cbd5e1; border-radius: 14px; padding: 24px 16px; text-align: center; background: #f8fafc; cursor: pointer; transition: border-color .2s, background .2s; display: block; position: relative; overflow: hidden; }
.py-upload-box:hover { border-color: #6366f1; background: #eef2ff; }
.py-upload-box.has-img { padding: 0; border-style: solid; border-color: #e2e8f0; background: #fff; height: 200px; }
.py-upload-box .ub-ic { width: 52px; height: 52px; border-radius: 50%; background: #fff; color: #6366f1; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; box-shadow: 0 4px 12px rgba(15,23,42,.06); }
.py-upload-box p { font-size: 13px; font-weight: 600; color: #475569; }
.py-upload-box small { font-size: 11.5px; color: #94a3b8; margin-top: 3px; display: block; }
.py-upload-box input[type=file] { display: none; }
.py-upload-preview { width: 100%; height: 100%; object-fit: cover; display: none; }
.py-upload-box.has-img .ub-content { display: none; }
.py-upload-box.has-img .py-upload-preview { display: block; }
.py-upload-rm { position: absolute; top: 10px; right: 10px; width: 34px; height: 34px; border-radius: 50%; background: rgba(15,23,42,.75); color: #fff; border: none; cursor: pointer; display: none; align-items: center; justify-content: center; z-index: 2; }
.py-upload-box.has-img .py-upload-rm { display: flex; }
.py-textarea { width: 100%; padding: 12px 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; font-family: inherit; resize: vertical; min-height: 76px; transition: border-color .2s, box-shadow .2s; background: #fff; color: #0f172a; }
.py-textarea:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99,102,241,.1); }

.py-btn-primary { width: 100%; padding: 14px; background: linear-gradient(135deg,#6366f1,#8b5cf6); color: #fff; border: none; border-radius: 13px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: transform .2s cubic-bezier(.22,1,.36,1), box-shadow .2s; box-shadow: 0 8px 20px rgba(99,102,241,.3); font-family: inherit; }
.py-btn-primary:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(99,102,241,.4); }
.py-btn-primary:disabled { opacity: .7; cursor: not-allowed; }
.py-btn-spin { width: 16px; height: 16px; border: 2.5px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; display: none; }
.py-btn-primary.loading .py-btn-spin { display: block; }
.py-btn-primary.loading .btn-txt { display: none; }
@keyframes spin { to { transform: rotate(360deg); } }

.py-modal { position: fixed; inset: 0; z-index: 1000; background: rgba(15,23,42,.65); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); display: none; align-items: center; justify-content: center; padding: 20px; opacity: 0; transition: opacity .25s; }
.py-modal.show { display: flex; opacity: 1; }
.py-modal-content { background: #fff; border-radius: 26px; max-width: 380px; width: 100%; max-height: 90vh; overflow-y: auto; position: relative; animation: modalIn .35s cubic-bezier(.34,1.56,.64,1); box-shadow: 0 24px 60px rgba(15,23,42,.3); }
@keyframes modalIn { from { transform: scale(.85) translateY(30px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }

.py-modal-loader { padding: 40px 22px; display: flex; flex-direction: column; align-items: center; gap: 14px; }
.py-modal-loader .ld-spinner { width: 44px; height: 44px; position: relative; margin-bottom: 10px; }
.py-modal-loader .ld-spinner::before { content: ''; position: absolute; inset: 0; border-radius: 50%; border: 3px solid #eef2ff; }
.py-modal-loader .ld-spinner::after { content: ''; position: absolute; inset: 0; border-radius: 50%; border: 3px solid transparent; border-top-color: #6366f1; border-right-color: #8b5cf6; animation: ldSpin .8s cubic-bezier(.5,0,.5,1) infinite; }
@keyframes ldSpin { to { transform: rotate(360deg); } }
.py-modal-loader .ld-text { font-size: 13px; font-weight: 700; color: #0f172a; letter-spacing: -.2px; text-align: center; }
.py-modal-loader .ld-sub { font-size: 11.5px; color: #94a3b8; text-align: center; margin-top: -8px; }
.py-modal-loader .ld-skel { width: 100%; display: flex; flex-direction: column; gap: 10px; margin-top: 8px; }
.py-modal-loader .ld-bar { height: 14px; border-radius: 8px; background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%); background-size: 200% 100%; animation: ldShimmer 1.4s ease-in-out infinite; }
.py-modal-loader .ld-bar.w-100 { width: 100%; }
.py-modal-loader .ld-bar.w-80 { width: 80%; }
.py-modal-loader .ld-bar.w-60 { width: 60%; }
.py-modal-loader .ld-bar.h-32 { height: 32px; border-radius: 10px; }
.py-modal-loader .ld-bar.h-100 { height: 100px; border-radius: 14px; }
@keyframes ldShimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

.py-iph { padding: 32px 24px 20px; text-align: center; }
.py-iph-icon { width: 84px; height: 84px; border-radius: 50%; background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; animation: iphIconPop .4s cubic-bezier(.34,1.56,.64,1); }
@keyframes iphIconPop { from { transform: scale(0); } to { transform: scale(1); } }
.py-iph-icon svg { animation: iphIconPulse 2s ease-in-out infinite; }
@keyframes iphIconPulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.08); } }
.py-iph h3 { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px; letter-spacing: -.4px; }
.py-iph p.sub { font-size: 13px; color: #64748b; line-height: 1.55; margin-bottom: 20px; }
.py-iph-info { background: #f8fafc; border-radius: 14px; padding: 14px; margin-bottom: 18px; text-align: left; }
.py-iph-info .pi-row { display: flex; justify-content: space-between; align-items: center; gap: 10px; padding: 6px 0; font-size: 12.5px; }
.py-iph-info .pi-row .pi-l { color: #94a3b8; font-weight: 500; }
.py-iph-info .pi-row .pi-v { color: #0f172a; font-weight: 700; font-family: 'SF Mono', Monaco, monospace; font-size: 12px; text-align: right; word-break: break-all; }
.py-iph-info .pi-row .pi-v.big { font-family: inherit; font-size: 13px; }
.py-iph-warn { background: #fef3c7; border-radius: 12px; padding: 12px 14px; margin-bottom: 20px; display: flex; gap: 10px; text-align: left; font-size: 12.5px; color: #78350f; line-height: 1.55; border: 1px solid #fde68a; }
.py-iph-warn svg { flex-shrink: 0; margin-top: 2px; color: #d97706; }
.py-iph-actions { display: flex; gap: 10px; }
.py-iph-btn { flex: 1; padding: 14px; border-radius: 14px; font-size: 14px; font-weight: 700; cursor: pointer; transition: transform .15s, box-shadow .15s; font-family: inherit; display: flex; align-items: center; justify-content: center; gap: 6px; }
.py-iph-btn.cancel { background: #f1f5f9; color: #475569; border: none; }
.py-iph-btn.cancel:hover { background: #e2e8f0; }
.py-iph-btn.confirm { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border: none; box-shadow: 0 6px 16px rgba(99,102,241,.3); }
.py-iph-btn.confirm:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(99,102,241,.45); }

.py-modal.detail .py-iph { padding: 26px 22px 22px; text-align: left; }
.py-mh { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; padding-right: 40px; }
.py-mh .mh-ic {
    width: 50px;
    height: 50px;
    border-radius: 13px;
    background: #fff;
    color: #6366f1;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    padding: 8px;
    box-shadow: inset 0 0 0 1px rgba(15,23,42,.06), 0 1px 3px rgba(15,23,42,.04);
}
.py-mh .mh-ic img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}
.py-mh h3 { font-size: 16px; font-weight: 800; color: #0f172a; }
.py-mh p { font-size: 11px; color: #94a3b8; margin-top: 2px; text-transform: uppercase; letter-spacing: .5px; font-weight: 700; }
.py-modal-close { position: absolute; top: 14px; right: 14px; width: 34px; height: 34px; border-radius: 50%; background: #f1f5f9; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #64748b; z-index: 10; transition: background .2s, transform .2s; }
.py-modal-close:hover { background: #e2e8f0; color: #0f172a; transform: rotate(90deg); }
.py-qr { background: #f8fafc; border-radius: 14px; padding: 16px; text-align: center; margin-bottom: 14px; }
.py-qr img { max-width: 240px; width: 100%; border-radius: 10px; margin: 0 auto; background: #fff; padding: 12px; cursor: zoom-in; }
.py-rek { background: #f8fafc; border-radius: 12px; padding: 14px 16px; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
.py-rek .rk-body { flex: 1; min-width: 0; }
.py-rek .rk-lbl { font-size: 10.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: .7px; font-weight: 700; margin-bottom: 4px; }
.py-rek .rk-val { font-family: 'SF Mono', Monaco, monospace; font-size: 15.5px; font-weight: 800; color: #0f172a; word-break: break-all; line-height: 1.3; }
.py-rek .rk-val.owner { font-family: inherit; font-size: 14px; font-weight: 700; }
.py-copy { width: 38px; height: 38px; border-radius: 10px; background: #fff; border: 1.5px solid #e2e8f0; color: #6366f1; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background .15s, border-color .15s; }
.py-copy:hover { background: #eef2ff; border-color: #c7d2fe; }
.py-copy.copied { background: #dcfce7; border-color: #bbf7d0; color: #16a34a; }
.py-instr { background: #fffbeb; border-radius: 12px; padding: 12px 14px; font-size: 12.5px; color: #78350f; line-height: 1.55; display: flex; gap: 10px; align-items: flex-start; margin-bottom: 14px; }
.py-instr svg { flex-shrink: 0; margin-top: 2px; color: #d97706; }
/* ============ E-WALLET OPEN BUTTON ============ */
.py-ewallet-wrap { margin-top: 12px; }
.py-ewallet-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 14px 16px;
    border: none;
    border-radius: 14px;
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: .2px;
    cursor: pointer;
    transition: transform .2s cubic-bezier(.22,1,.36,1), box-shadow .2s;
    font-family: inherit;
    text-align: left;
    box-shadow: 0 8px 22px rgba(0,0,0,.14);
    position: relative;
    overflow: hidden;
}
.py-ewallet-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,.2); }
.py-ewallet-btn:active { transform: translateY(0) scale(.98); }
.py-ewallet-btn .ew-logo {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: -.4px;
    color: #fff;
    overflow: hidden;
    background: #fff;
    padding: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,.12);
}
.py-ewallet-btn .ew-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}
.py-ewallet-btn .ew-body { flex: 1; min-width: 0; }
.py-ewallet-btn .ew-title { display: block; font-size: 14.5px; font-weight: 800; line-height: 1.2; }
.py-ewallet-btn .ew-sub { display: block; font-size: 10.5px; font-weight: 600; opacity: .9; margin-top: 3px; }
.py-ewallet-btn .ew-arrow { flex-shrink: 0; opacity: .9; }

.ew-hint {
    display: flex;
    gap: 8px;
    align-items: flex-start;
    font-size: 11.5px;
    color: #94a3b8;
    line-height: 1.5;
    margin-top: 10px;
    padding: 0 2px;
}
.ew-hint svg { flex-shrink: 0; margin-top: 2px; color: #cbd5e1; }
.py-modal-actions { display: flex; gap: 10px; margin-top: 18px; }
.py-btn-outline { flex: 1; padding: 12px; background: #fff; color: #475569; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; font-weight: 700; cursor: pointer; transition: border-color .15s, color .15s, background .15s; display: flex; align-items: center; justify-content: center; gap: 6px; font-family: inherit; }
.py-btn-outline:hover { border-color: #c7d2fe; color: #6366f1; background: #eef2ff; }
.py-btn-green { flex: 1; padding: 12px; background: linear-gradient(135deg,#16a34a,#22c55e); color: #fff; border: none; border-radius: 12px; font-size: 13.5px; font-weight: 700; cursor: pointer; transition: transform .15s, box-shadow .15s; box-shadow: 0 6px 16px rgba(22,163,74,.25); display: flex; align-items: center; justify-content: center; gap: 6px; font-family: inherit; }
.py-btn-green:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(22,163,74,.35); }

.py-konf-title { text-align: center; margin-bottom: 22px; }
.py-konf-title h3 { font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 6px; letter-spacing: -.3px; }
.py-konf-title p { font-size: 13px; color: #64748b; line-height: 1.5; }
.py-option { display: flex; gap: 14px; padding: 16px; border-radius: 14px; background: #fff; border: 2px solid #e2e8f0; cursor: pointer; transition: transform .2s, border-color .2s, box-shadow .2s; margin-bottom: 10px; text-align: left; font-family: inherit; width: 100%; }
.py-option:hover { border-color: #c7d2fe; background: #fafbff; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(99,102,241,.1); }
.py-option.primary { border-color: #6366f1; background: #eef2ff; }
.py-option .op-ic { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.py-option .op-ic.upload { background: linear-gradient(135deg,#eef2ff,#e0e7ff); color: #6366f1; }
.py-option .op-ic.wa { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; }
.py-option .op-body { flex: 1; min-width: 0; }
.py-option .op-title { font-size: 14px; font-weight: 800; color: #0f172a; margin-bottom: 3px; display: flex; align-items: center; gap: 6px; }
.py-option .op-badge { font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; padding: 3px 7px; border-radius: 5px; background: #6366f1; color: #fff; }
.py-option .op-desc { font-size: 12px; color: #64748b; line-height: 1.5; }
.py-option .op-arrow { color: #cbd5e1; flex-shrink: 0; display: flex; align-items: center; }
.py-option:hover .op-arrow { color: #6366f1; }
.py-back { display: flex; align-items: center; justify-content: center; gap: 6px; width: 100%; padding: 11px; background: transparent; border: none; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; transition: color .15s; font-family: inherit; margin-top: 8px; }
.py-back:hover { color: #0f172a; }

.py-footer { text-align: center; padding: 32px 20px 24px; font-size: 12px; color: #94a3b8; line-height: 1.7; margin-top: auto; }
.py-footer .ft-brand { font-size: 14px; font-weight: 800; color: #475569; letter-spacing: -.2px; margin-bottom: 6px; }
.py-footer .ft-brand span { color: #6366f1; }
.py-footer .ft-credit { font-size: 12px; color: #64748b; margin-bottom: 4px; }
.py-footer .ft-credit strong { font-weight: 700; color: #334155; }
.py-footer .ft-copy { font-size: 11.5px; color: #94a3b8; margin-bottom: 12px; }
.py-footer .ft-links { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 6px; font-size: 11.5px; padding-top: 12px; border-top: 1px dashed #e2e8f0; }
.py-footer .ft-links a { color: #64748b; text-decoration: none; font-weight: 600; transition: color .15s; padding: 4px 8px; border-radius: 6px; }
.py-footer .ft-links a:hover { color: #4f46e5; background: #eef2ff; }
.py-footer .ft-links .sep { color: #cbd5e1; font-weight: 400; }

.py-toast-wrap { position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; display: flex; flex-direction: column; gap: 8px; pointer-events: none; width: calc(100% - 40px); max-width: 400px; }
.py-toast { background: #0f172a; color: #fff; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; box-shadow: 0 12px 32px rgba(0,0,0,.25); display: flex; align-items: center; gap: 10px; animation: toastIn .35s cubic-bezier(.34,1.56,.64,1); pointer-events: auto; }
.py-toast.success { background: linear-gradient(135deg,#16a34a,#22c55e); }
.py-toast.error { background: linear-gradient(135deg,#dc2626,#ef4444); }
.py-toast.info { background: linear-gradient(135deg,#2563eb,#3b82f6); }
.py-toast.warn { background: linear-gradient(135deg,#d97706,#f59e0b); }
@keyframes toastIn { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

.py-imgviewer { position: fixed; inset: 0; z-index: 2000; background: rgba(0,0,0,.95); display: none; align-items: center; justify-content: center; padding: 20px; cursor: zoom-out; opacity: 0; transition: opacity .25s; }
.py-imgviewer.show { display: flex; opacity: 1; }
.py-imgviewer img { max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 12px; }

@keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 380px) {
    .py-wrap { padding: 16px 12px 0; }
    .pb-total .pb-total-val { font-size: 26px; }
    .pb-block.pb-timer-block .pb-val { font-size: 20px; letter-spacing: 1px; }
    .py-pending-card { padding: 24px 18px; }
    .py-pending-card .pc-icon { width: 64px; height: 64px; }
    .py-head { padding: 13px 14px; gap: 11px; }
    .py-logo { width: 64px; height: 64px; }
    .py-logo .py-logo-txt { font-size: 24px; }
    .py-head-txt h1 { font-size: 15.5px; }
    .py-head-txt p { font-size: 11px; }
    .py-head-shield { width: 32px; height: 32px; }
}
</style>
</head>
<body>

<div class="py-verify" id="verifyScreen">
    <div class="vy-inner">
        <div class="vy-spinner"></div>
        <div class="vy-title" id="vyTitle">Memverifikasi</div>
        <div class="vy-sub" id="vySub">Menghubungkan ke server</div>
    </div>
    <div class="vy-bar"><span id="vyProgress"></span></div>
</div>

<div class="py-toast-wrap" id="toastWrap"></div>

<div class="py-wrap">

    <header class="py-head">
        <div class="py-head-glow" aria-hidden="true"></div>
        <div class="py-logo">
            <div class="py-logo-glow" aria-hidden="true"></div>
            <?php if ($logo && file_exists(UPLOAD_PATH . '/' . $logo)): ?>
                <img src="<?= UPLOAD_URL . '/' . e($logo) ?>" alt="" loading="eager">
            <?php else: ?>
                <div class="py-logo-txt">Billing <span>App</span></div>
            <?php endif; ?>
        </div>
        <div class="py-head-txt">
            <h1><?= e($bisnisNama) ?></h1>
            <p><span class="py-live-dot"></span><span class="py-typed" id="typedText"></span><span class="py-cursor"></span></p>
        </div>
        <div class="py-head-shield" title="Koneksi Terenkripsi &amp; Aman">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <polyline points="9 12 11 14 15 10"/>
            </svg>
        </div>
    </header>

    <?php if ($isPaid): ?>
        <div class="py-status-card">
            <div class="sc-icon" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0); color:#16a34a;">
                <?= py_icon('checkCircle', 40, 2.2) ?>
            </div>
            <h3>Pembayaran Berhasil</h3>
            <p>Terima kasih! Pembayaran kamu sudah kami konfirmasi.</p>
            <button type="button" class="py-print-btn" onclick="openStruk()">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak Struk Digital
            </button>
        </div>
    <?php elseif ($isWaiting): ?>
        <div class="py-status-card">
            <div class="sc-icon" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe); color:#2563eb;">
                <?= py_icon('hourglass', 40, 2) ?>
            </div>
            <h3>Menunggu Konfirmasi Admin <span class="py-dots" style="color:#2563eb;"><span></span><span></span><span></span></span></h3>
            <p>Bukti kamu sedang direview admin. Mohon tetap di halaman ini, status akan otomatis update.</p>
        </div>
    <?php elseif ($isCancelled): ?>
        <div class="py-status-card">
            <div class="sc-icon" style="background:#f1f5f9; color:#64748b;"><?= py_icon('xCircle', 40, 2) ?></div>
            <h3>Tagihan Dibatalkan</h3>
            <p>Hubungi admin kalau ada pertanyaan.</p>
        </div>
    <?php elseif ($isExpired): ?>
        <div class="py-status-card">
            <div class="sc-icon" style="background:#f1f5f9; color:#64748b;"><?= py_icon('alert', 40, 2) ?></div>
            <h3>Tagihan Kadaluarsa</h3>
            <p>Tagihan ini sudah melewati batas waktu. Hubungi admin untuk info lebih lanjut.</p>
        </div>
    <?php elseif ($canPay): ?>

        <?php
        $deadlineClass = '';
        if ($sisaDetik > 0) {
            if ($jam < 1) $deadlineClass = 'danger';
            elseif ($jam < 3) $deadlineClass = 'warn';
        }
        ?>

        <?php if ($showRejectedPanel): ?>
            <div class="py-reject-box">
                <div class="rb-icon"><?= py_icon('xCircle', 22) ?></div>
                <div class="rb-body">
                    <div class="rb-title">Bukti Pembayaran Ditolak</div>
                    <div class="rb-reason"><?= e($latestRejectReason ?: 'Bukti tidak valid.') ?></div>
                    <div class="rb-hint"><?= py_icon('info', 12) ?> Silakan pilih metode pembayaran ulang</div>
                </div>
            </div>
        <?php endif; ?>

        <div class="py-bill" id="billCard" <?= $showPendingOnly ? 'style="display:none"' : '' ?>>

            <!-- TOPBAR -->
            <div class="pb-topbar">
                <div class="pt-status" style="background:<?= $stBg ?>; color:<?= $stColor ?>;">
                    <span class="dot"></span><?= e($stLbl) ?>
                </div>
                <div class="pt-inv-wrap">
                    <div class="pt-inv"><?= e($inv['invoice_number']) ?></div>
                    <div class="pt-pub">Diterbitkan oleh <strong><?= e($adminPenerbit) ?></strong></div>
                </div>
            </div>

            <!-- THICK DIVIDER -->
            <div class="pb-line"></div>

            <!-- TIMER -->
            <?php if ($sisaDetik > 0): ?>
                <div class="pb-block pb-timer-block <?= $deadlineClass ?>" id="deadlineBox">
                    <span class="pb-lbl">Bayar dalam</span>
                    <div class="pb-val" id="timerVal">--:--:--</div>
                    <div class="pb-sub"><?= tglIndo($inv['expired_at']) ?> WIB</div>
                </div>
            <?php endif; ?>

            <!-- INFO -->
            <div class="pb-block">
                <span class="pb-lbl">Pembayar</span>
                <div class="pb-val"><?= e($inv['nama_pembayar']) ?></div>
            </div>

            <div class="pb-block">
                <span class="pb-lbl">Tagihan</span>
                <div class="pb-val"><?= e($inv['deskripsi']) ?></div>
            </div>

            <?php if (!empty($inv['catatan_user'])): ?>
                <div class="pb-note">
                    <?= py_icon('info', 14) ?>
                    <div><?= nl2br(e($inv['catatan_user'])) ?></div>
                </div>
            <?php endif; ?>

            <!-- THIN DIVIDER -->
            <div class="pb-line thin"></div>

            <!-- TOTAL -->
<div class="pb-total">
    <span class="pb-total-lbl">Total Bayar</span>
    <div class="pb-total-val"><?= rupiah($inv['total']) ?></div>
</div>

<!-- TOGGLE RINCIAN (dipindah ke sini, bawah total) -->
<?php if (count($items) > 1 || !empty($adjs) || $inv['kode_unik'] > 0): ?>
    <div class="pb-line thin"></div>
    <button type="button" class="py-toggle" id="toggleDetail" onclick="toggleDetail()">
        <span id="toggleText">Lihat rincian biaya</span><?= py_icon('chevD', 14, 2.5) ?>
    </button>
    <div class="py-detail" id="detailSection">
        <div class="py-detail-inner">
            <?php foreach ($items as $it): ?>
                <div class="py-row">
                    <span class="rl"><?= e($it['nama_item']) ?> <span style="color:#cbd5e1;">× <?= (float)$it['qty'] ?></span></span>
                    <span class="rv"><?= rupiah($it['subtotal']) ?></span>
                </div>
            <?php endforeach; ?>
            <div class="py-divider"></div>
            <div class="py-row"><span class="rl">Subtotal</span><span class="rv"><?= rupiah($inv['subtotal']) ?></span></div>
            <?php foreach ($adjs as $ad): if ($ad['tipe'] !== 'diskon') continue; ?>
                <div class="py-row"><span class="rl"><?= e($ad['label']) ?></span><span class="rv" style="color:#dc2626;">− <?= rupiah($ad['hasil']) ?></span></div>
            <?php endforeach; ?>
            <?php foreach ($adjs as $ad): if (!in_array($ad['tipe'], ['biaya_admin','pajak'])) continue; ?>
                <div class="py-row"><span class="rl"><?= e($ad['label']) ?></span><span class="rv" style="color:#16a34a;">+ <?= rupiah($ad['hasil']) ?></span></div>
            <?php endforeach; ?>
            <?php if ($inv['kode_unik'] > 0): ?>
                <div class="py-row"><span class="rl">Kode Unik</span><span class="rv" style="color:#16a34a;">+ <?= rupiah($inv['kode_unik']) ?></span></div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- PAY BUTTON (sekarang di paling bawah) -->
<?php if (!$showPendingOnly): ?>
    <button type="button" class="pb-pay-btn" id="payNowBtn" onclick="showPaymentMethods()">
        <?= py_icon('creditCard', 18, 2.5) ?> Bayar Sekarang
    </button>
<?php endif; ?>

        </div>

        <!-- METODE PEMBAYARAN (HIDDEN BY DEFAULT) -->
        <div class="py-sec" id="methodsSection" style="display:none">
            <div class="py-sec-hd">
                <div class="ic"><?= py_icon('creditCard', 18) ?></div>
                <div><h2>Pilih Metode Pembayaran</h2><p id="methodHint">Klik salah satu untuk melanjutkan</p></div>
            </div>

            <?php if (empty($methods)): ?>
                <p style="color:#94a3b8; font-size:13px; text-align:center; padding:20px;">Belum ada metode tersedia.</p>
            <?php else: ?>
                <div class="py-methods" id="methodsGrid">
                    <?php foreach ($methods as $m): ?>
                        <?php
                        $jenisIcon = ['qris'=>'qris','bank'=>'bank','ewallet'=>'wallet','custom'=>'creditCard'][$m['jenis']] ?? 'creditCard';
                        $jenisLabel = ['qris'=>'QRIS','bank'=>'Transfer Bank','ewallet'=>'E-Wallet','custom'=>'Lainnya'][$m['jenis']] ?? 'Lainnya';
                        $hasLogo = $m['logo'] && file_exists(UPLOAD_PATH . '/' . $m['logo']);
                        $isLocked = $lockedMethodId === (int)$m['id'];
                        $isDisabled = $lockedMethodId && !$isLocked;
                        ?>
                        <button type="button"
                                class="py-method <?= $isLocked ? 'locked' : '' ?> <?= $isDisabled ? 'disabled' : '' ?>"
                                data-mid="<?= (int)$m['id'] ?>"
                                data-mnama="<?= e($m['nama']) ?>"
                                data-mjenis="<?= e($m['jenis']) ?>"
                                data-mprovider="<?= e($m['provider']) ?>"
                                data-mnomor="<?= e($m['nomor']) ?>"
                                data-mpemilik="<?= e($m['nama_pemilik']) ?>"
                                data-minstruksi="<?= e($m['instruksi']) ?>"
                                data-mqris="<?= $m['gambar_qris'] && file_exists(UPLOAD_PATH . '/' . $m['gambar_qris']) ? UPLOAD_URL . '/' . $m['gambar_qris'] : '' ?>"
                                data-mlogo="<?= $hasLogo ? UPLOAD_URL . '/' . $m['logo'] : '' ?>"
                                <?= $isDisabled ? 'disabled' : '' ?>
                                onclick="handleMethodClick(this)">
                            <?php if ($isLocked): ?>
                                <span class="pm-lock-badge" id="lockBadge-<?= $m['id'] ?>"><?= py_icon('lock', 10, 2.5) ?><span id="lockTime-<?= $m['id'] ?>"><?= gmdate('i:s', $lockSisaDetik) ?></span></span>
                            <?php endif; ?>
                            <div class="pm-icon">
                                <?php if ($hasLogo): ?>
                                    <img src="<?= UPLOAD_URL . '/' . e($m['logo']) ?>" alt="" loading="lazy">
                                <?php else: ?>
                                    <?= py_icon($jenisIcon, 38, 1.8) ?>
                                <?php endif; ?>
                            </div>
                            <div class="pm-nm"><?= e($m['nama']) ?></div>
                            <div class="pm-type"><?= e($m['provider'] ?: $jenisLabel) ?></div>
                            <?php if ($isDisabled): ?>
                                <div class="pm-lock-overlay"><?= py_icon('lock', 22, 2) ?></div>
                            <?php endif; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="py-pending-card" id="pendingCard" <?= !$showPendingOnly ? 'style="display:none"' : '' ?>>
            <div class="pc-icon"><?= py_icon('upload', 34, 2) ?></div>
            <h3>Belum Kirim Bukti Pembayaran</h3>
            <p>Kamu sudah memilih metode pembayaran, tapi belum mengirim bukti transfer.</p>
            <div class="pc-total">Total: <strong><?= rupiah($inv['total']) ?></strong></div>
            <br>
            <button type="button" class="pc-btn" onclick="reopenDetail()"><?= py_icon('upload', 17, 2.5) ?> Konfirmasi Sekarang</button>
            <div class="pc-hint"><?= py_icon('info', 12, 2.5) ?> Klik tombol di atas untuk lihat detail & kirim bukti</div>
        </div>

        <div class="py-upload" id="uploadSection">
            <div class="py-upload-inner">
                <div class="py-upload-hd">
                    <div class="ic"><?= py_icon('upload', 18) ?></div>
                    <div><h3>Upload Bukti Transfer</h3><p>Pilih gambar, lalu kirim</p></div>
                </div>
                <form id="uploadForm" onsubmit="submitUpload(event)">
                    <input type="hidden" name="csrf" value="<?= csrf() ?>">
                    <input type="hidden" name="token" value="<?= e($token) ?>">
                    <input type="hidden" name="metode_id" id="selectedMetodeId" value="">
                    <div class="py-field">
                        <label>Bukti Transfer <span class="req">*</span></label>
                        <label class="py-upload-box" for="buktiInput" id="uploadBox">
                            <div class="ub-content">
                                <div class="ub-ic"><?= py_icon('image', 24) ?></div>
                                <p>Klik untuk pilih gambar</p>
                                <small>JPG, PNG, WEBP — Maks 3 MB</small>
                            </div>
                            <img id="uploadPreview" class="py-upload-preview" alt="">
                            <button type="button" class="py-upload-rm" onclick="removeUpload(event)"><?= py_icon('x', 15, 2.5) ?></button>
                            <input type="file" id="buktiInput" name="bukti" accept="image/*" onchange="previewFile(event)">
                        </label>
                    </div>
                    <div class="py-field">
                        <label>Catatan (opsional)</label>
                        <textarea name="catatan" class="py-textarea" rows="3" placeholder="misal: transfer dari rekening istri"></textarea>
                    </div>
                    <button type="submit" class="py-btn-primary" id="submitBtn">
                        <span class="py-btn-spin"></span>
                        <span class="btn-txt" style="display:flex;align-items:center;gap:8px;"><?= py_icon('check', 16, 2.5) ?> Kirim Konfirmasi</span>
                    </button>
                </form>
            </div>
        </div>

        <?php if ($lockedMethodData): ?>
            <div id="lockedMethodData" style="display:none"
                 data-mid="<?= (int)$lockedMethodData['id'] ?>"
                 data-mnama="<?= e($lockedMethodData['nama']) ?>"
                 data-mjenis="<?= e($lockedMethodData['jenis']) ?>"
                 data-mprovider="<?= e($lockedMethodData['provider']) ?>"
                 data-mnomor="<?= e($lockedMethodData['nomor']) ?>"
                 data-mpemilik="<?= e($lockedMethodData['nama_pemilik']) ?>"
                 data-minstruksi="<?= e($lockedMethodData['instruksi']) ?>"
                 data-mqris="<?= $lockedMethodData['gambar_qris'] && file_exists(UPLOAD_PATH . '/' . $lockedMethodData['gambar_qris']) ? UPLOAD_URL . '/' . $lockedMethodData['gambar_qris'] : '' ?>"
                 data-mlogo="<?= $lockedMethodData['logo'] && file_exists(UPLOAD_PATH . '/' . $lockedMethodData['logo']) ? UPLOAD_URL . '/' . $lockedMethodData['logo'] : '' ?>"></div>
        <?php endif; ?>

    <?php endif; ?>

    <footer class="py-footer">
        <div class="ft-brand">Billing <span>App</span></div>
        <div class="ft-credit">Dibuat oleh <strong>Sovantri Putra Paskah Halawa</strong></div>
        <div class="ft-copy">&copy; <?= date('Y') ?> Billing App. All rights reserved.</div>
        <div class="ft-links">
            <a href="#" onclick="return false;">Terms of Service</a>
            <span class="sep">·</span>
            <a href="#" onclick="return false;">Privacy Policy</a>
            <span class="sep">·</span>
            <a href="#" onclick="return false;">Kebijakan Refund</a>
            <span class="sep">·</span>
            <a href="#" onclick="return false;">Bantuan</a>
        </div>
    </footer>

</div>

<!-- MODAL CONFIRM -->
<div class="py-modal" id="confirmModal">
    <div class="py-modal-content">
        <div class="py-iph">
            <div class="py-iph-icon"><?= py_icon('alert', 40, 2) ?></div>
            <h3>Konfirmasi Metode</h3>
            <p class="sub">Pastikan kamu memilih metode yang tepat ya</p>
            <div class="py-iph-info">
                <div class="pi-row"><span class="pi-l">ID Transaksi</span><span class="pi-v"><?= e($inv['invoice_number']) ?></span></div>
                <div class="pi-row"><span class="pi-l">Total</span><span class="pi-v big"><?= rupiah($inv['total']) ?></span></div>
                <div class="pi-row"><span class="pi-l">Metode</span><span class="pi-v big" id="cfMethod">—</span></div>
                <div class="pi-row"><span class="pi-l">Bayar sebelum</span><span class="pi-v big" style="color:#dc2626;"><?= tglIndo($inv['expired_at']) ?></span></div>
            </div>
            <div class="py-iph-warn"><?= py_icon('lock', 16, 2.5) ?><div>Metode ini <strong>tidak bisa diganti</strong> selama <strong>5 menit</strong>. Pastikan sudah yakin ya.</div></div>
            <div class="py-iph-actions">
                <button type="button" class="py-iph-btn cancel" onclick="closeConfirm()">Batal</button>
                <button type="button" class="py-iph-btn confirm" onclick="confirmMethod()"><?= py_icon('check', 16, 2.5) ?> Ya, Pilih</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL -->
<div class="py-modal detail" id="detailModal">
    <div class="py-modal-content">
        <button type="button" class="py-modal-close" onclick="closeDetail()"><?= py_icon('x', 16, 2.5) ?></button>

        <div class="py-modal-loader" id="modalLoader">
            <div class="ld-spinner"></div>
            <div class="ld-text" id="ldText">Memuat...</div>
            <div class="ld-sub" id="ldSub">Menyiapkan detail pembayaran</div>
            <div class="ld-skel">
                <div class="ld-bar w-60"></div>
                <div class="ld-bar h-32 w-100"></div>
                <div class="ld-bar w-80"></div>
                <div class="ld-bar w-100"></div>
            </div>
        </div>

        <div class="py-iph" id="modalBody" style="display:none">
            <div class="py-mh">
                <div class="mh-ic" id="mhIcon"><?= py_icon('creditCard', 22) ?></div>
                <div><h3 id="mhTitle">Metode</h3><p id="mhSub">Detail</p></div>
            </div>
            <div id="mhContent"></div>
            <div class="py-modal-actions">
                <button type="button" class="py-btn-outline" onclick="closeDetail()">Tutup</button>
                <button type="button" class="py-btn-green" onclick="showKonfirmasiView()"><?= py_icon('check', 15, 2.5) ?> Saya Sudah Bayar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2 OPSI -->
<div class="py-modal" id="opsiModal">
    <div class="py-modal-content">
        <button type="button" class="py-modal-close" onclick="closeOpsi()"><?= py_icon('x', 16, 2.5) ?></button>
        <div class="py-iph">
            <div class="py-konf-title">
                <h3>Bagaimana mau konfirmasi?</h3>
                <p>Pilih salah satu cara di bawah</p>
            </div>
            <button type="button" class="py-option primary" onclick="chooseUpload()">
                <div class="op-ic upload"><?= py_icon('upload', 22) ?></div>
                <div class="op-body">
                    <div class="op-title">Upload ke Sistem <span class="op-badge">Rekomendasi</span></div>
                    <div class="op-desc">Upload bukti transfer, admin akan review</div>
                </div>
                <div class="op-arrow"><?= py_icon('arrowR', 16, 2.5) ?></div>
            </button>
            <button type="button" class="py-option" onclick="chooseWA()">
                <div class="op-ic wa"><?= py_wa_filled(22) ?></div>
                <div class="op-body">
                    <div class="op-title">Chat WhatsApp</div>
                    <div class="op-desc">Kirim bukti langsung ke admin via WhatsApp</div>
                </div>
                <div class="op-arrow"><?= py_icon('arrowR', 16, 2.5) ?></div>
            </button>
            <button type="button" class="py-back" onclick="closeOpsi()"><?= py_icon('arrowL', 14, 2.5) ?> Tutup</button>
        </div>
    </div>
</div>

<div class="py-imgviewer" id="imgViewer" onclick="this.classList.remove('show')">
    <img id="imgViewerSrc" src="" alt="">
</div>

<script>
'use strict';

/* ========== TYPING TEXT EFFECT ========== */
(function typingEffect() {
    const el = document.getElementById('typedText');
    if (!el) return;

    const phrases = [
        'Pembayaran Aman & Terenkripsi',
        'Verifikasi Otomatis Real-time',
        'Powered by Billing App'
    ];

    let phraseIdx = 0;
    let charIdx = 0;
    let deleting = false;

    const TYPE_SPEED   = 55;
    const DELETE_SPEED = 30;
    const HOLD_FULL    = 1800;
    const HOLD_EMPTY   = 350;

    function tick() {
        const text = phrases[phraseIdx];

        if (!deleting) {
            charIdx++;
            el.textContent = text.slice(0, charIdx);
            if (charIdx === text.length) {
                deleting = true;
                return setTimeout(tick, HOLD_FULL);
            }
            return setTimeout(tick, TYPE_SPEED);
        } else {
            charIdx--;
            el.textContent = text.slice(0, charIdx);
            if (charIdx === 0) {
                deleting = false;
                phraseIdx = (phraseIdx + 1) % phrases.length;
                return setTimeout(tick, HOLD_EMPTY);
            }
            return setTimeout(tick, DELETE_SPEED);
        }
    }

    setTimeout(tick, 800);
})();
/* ======================================== */

/* ========== FIX AUTO SCROLL ========== */
if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
(function forceTop() {
    const goTop = () => {
        window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
    };
    goTop();
    document.addEventListener('DOMContentLoaded', goTop);
    window.addEventListener('load', goTop);
    window.addEventListener('pageshow', goTop);
    setTimeout(goTop, 50);
    setTimeout(goTop, 250);
    setTimeout(goTop, 800);
})();
/* ==================================== */

const TOKEN = '<?= e($token) ?>';
const BASE = '<?= BASE_URL ?>';
const WA_ADMIN = '<?= $waNumber ?>';
const INVOICE_NUM = '<?= e($inv['invoice_number']) ?>';
const TOTAL_RP = '<?= rupiah($inv['total']) ?>';
const NAMA_PEMBAYAR = '<?= e($inv['nama_pembayar']) ?>';

let selectedMethod = null;
let pendingMethod = null;
let lockCountdownInterval = null;
let countdownInterval = null;

(function initLockedMethod() {
    const el = document.getElementById('lockedMethodData');
    if (el) {
        selectedMethod = {
            id: el.dataset.mid, nama: el.dataset.mnama, jenis: el.dataset.mjenis,
            provider: el.dataset.mprovider, nomor: el.dataset.mnomor, pemilik: el.dataset.mpemilik,
            instruksi: el.dataset.minstruksi, qris: el.dataset.mqris, logo: el.dataset.mlogo
        };
    }
})();

function openStruk() { window.open(BASE + '/?url=struk/' + TOKEN, '_blank', 'noopener'); }

function showToast(msg, type) {
    type = type || 'success';
    const wrap = document.getElementById('toastWrap');
    const el = document.createElement('div');
    el.className = 'py-toast ' + type;
    const icons = {
        success: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>',
        error: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        info: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
        warn: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
    };
    el.innerHTML = (icons[type] || icons.info) + ' <span>' + msg + '</span>';
    wrap.appendChild(el);
    setTimeout(() => {
        el.style.opacity = '0';
        el.style.transition = 'opacity .3s';
        setTimeout(() => el.remove(), 300);
    }, 2800);
}

(function() {
    const verifiedKey = 'pay_verified_' + TOKEN;
    const screen = document.getElementById('verifyScreen');
    if (!screen) return;
    if (sessionStorage.getItem(verifiedKey)) { screen.classList.add('hide'); return; }
    const title = document.getElementById('vyTitle');
    const sub = document.getElementById('vySub');
    const progress = document.getElementById('vyProgress');
    const conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    let stepDelay = 350;
    if (conn) {
        const type = conn.effectiveType || '4g';
        if (type === 'slow-2g') stepDelay = 1000;
        else if (type === '2g') stepDelay = 750;
        else if (type === '3g') stepDelay = 500;
    }
    const steps = [
        ['Memverifikasi', 'Memeriksa tautan'],
        ['Memvalidasi', 'Verifikasi ID transaksi'],
        ['Menyiapkan', 'Memuat halaman']
    ];
    let i = 0;
    function next() {
        if (i >= steps.length) {
            progress.style.width = '100%';
            setTimeout(() => {
                screen.classList.add('hide');
                sessionStorage.setItem(verifiedKey, '1');
                window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
            }, 300);
            return;
        }
        title.textContent = steps[i][0]; sub.textContent = steps[i][1];
        progress.style.width = ((i + 1) / steps.length * 100) + '%';
        i++; setTimeout(next, stepDelay);
    }
    setTimeout(next, 150);
})();

<?php if ($sisaDetik > 0 && $canPay): ?>
(function() {
    let sisa = <?= $sisaDetik ?>;
    const el = document.getElementById('timerVal');
    const box = document.getElementById('deadlineBox');
    if (!el) return;
    function fmt(s) {
        const j = Math.floor(s / 3600);
        const m = Math.floor((s % 3600) / 60);
        const d = s % 60;
        return String(j).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(d).padStart(2,'0');
    }
    el.textContent = fmt(sisa);
    function tick() {
        if (sisa <= 0) { location.reload(); return; }
        sisa--;
        el.textContent = fmt(sisa);
        const j = sisa / 3600;
        if (j < 1) { box.classList.remove('warn'); box.classList.add('danger'); }
        else if (j < 3) { box.classList.remove('danger'); box.classList.add('warn'); }
    }
    countdownInterval = setInterval(tick, 1000);
})();
<?php endif; ?>

/* ========== REVEAL METODE PEMBAYARAN ========== */
function showPaymentMethods() {
    const sec = document.getElementById('methodsSection');
    const btn = document.getElementById('payNowBtn');
    if (!sec) return;

    sec.style.display = 'block';
    sec.classList.remove('reveal');
    void sec.offsetWidth; // force reflow
    sec.classList.add('reveal');

    if (btn) btn.style.display = 'none';

    if (navigator.vibrate) navigator.vibrate(8);

    setTimeout(() => {
        sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 120);
}
/* ======================================== */

function toggleDetail() {
    const detail = document.getElementById('detailSection');
    const toggle = document.getElementById('toggleDetail');
    const txt = document.getElementById('toggleText');
    if (!detail) return;
    const isOpen = detail.classList.toggle('open');
    toggle.classList.toggle('open', isOpen);
    txt.textContent = isOpen ? 'Sembunyikan rincian' : 'Lihat rincian biaya';
}

function startLockCountdown(lockedId, sisaDetik) {
    if (lockCountdownInterval) clearInterval(lockCountdownInterval);
    let sisa = sisaDetik;
    const timeEl = document.getElementById('lockTime-' + lockedId);
    function tick() {
        if (sisa <= 0) { clearInterval(lockCountdownInterval); location.reload(); return; }
        sisa--;
        if (timeEl) {
            const m = Math.floor(sisa / 60);
            const s = sisa % 60;
            timeEl.textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
        }
    }
    tick();
    lockCountdownInterval = setInterval(tick, 1000);
}

<?php if ($lockedMethodId && $lockSisaDetik > 0): ?>
startLockCountdown(<?= $lockedMethodId ?>, <?= $lockSisaDetik ?>);
<?php endif; ?>

function hidePaymentUI() {
    const bill = document.getElementById('billCard');
    const methods = document.getElementById('methodsSection');
    const pending = document.getElementById('pendingCard');
    const payBtn = document.getElementById('payNowBtn');
    if (bill) bill.style.display = 'none';
    if (methods) methods.style.display = 'none';
    if (payBtn) payBtn.style.display = 'none';
    if (pending) pending.style.display = 'block';
}

function handleMethodClick(btn) {
    if (btn.classList.contains('disabled')) { showToast('Metode lain sedang dikunci', 'warn'); return; }
    if (btn.classList.contains('locked')) { openDetail(btn); return; }
    if (document.querySelector('.py-method.locked')) { showToast('Sudah ada metode aktif. Tunggu dulu.', 'warn'); return; }
    pendingMethod = btn;
    document.getElementById('cfMethod').textContent = btn.dataset.mnama;
    if (navigator.vibrate) navigator.vibrate(8);
    document.getElementById('confirmModal').classList.add('show');
}

function closeConfirm() {
    document.getElementById('confirmModal').classList.remove('show');
    pendingMethod = null;
}

async function confirmMethod() {
    if (!pendingMethod) return;
    const methodId = pendingMethod.dataset.mid;
    const btn = document.querySelector('#confirmModal .py-iph-btn.confirm');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = 'Memproses...';
    try {
        const fd = new FormData();
        fd.append('token', TOKEN);
        fd.append('method_id', methodId);
        const res = await fetch(BASE + '/?url=api/pay-lock', { method: 'POST', body: fd });
        const data = await res.json();
        if (!data.success) {
            showToast(data.message || 'Gagal', 'error');
            btn.disabled = false; btn.innerHTML = orig; return;
        }
        selectedMethod = {
            id: pendingMethod.dataset.mid, nama: pendingMethod.dataset.mnama, jenis: pendingMethod.dataset.mjenis,
            provider: pendingMethod.dataset.mprovider, nomor: pendingMethod.dataset.mnomor, pemilik: pendingMethod.dataset.mpemilik,
            instruksi: pendingMethod.dataset.minstruksi, qris: pendingMethod.dataset.mqris, logo: pendingMethod.dataset.mlogo
        };
        const selId = document.getElementById('selectedMetodeId');
        if (selId) selId.value = methodId;
        applyLockToUI(parseInt(methodId), data.sisa_detik);
        closeConfirm();
        if (navigator.vibrate) navigator.vibrate([8, 40, 8]);
        showToast('Metode dipilih', 'success');
        setTimeout(() => {
            document.getElementById('detailModal').classList.add('show');
            buildDetailContentWithLoading(selectedMethod);
        }, 300);
    } catch (e) {
        showToast('Koneksi error', 'error');
        btn.disabled = false; btn.innerHTML = orig;
    }
}

function applyLockToUI(lockedId, sisaDetik) {
    document.querySelectorAll('.py-method').forEach(card => {
        const id = parseInt(card.dataset.mid);
        const oldBadge = card.querySelector('.pm-lock-badge');
        if (oldBadge) oldBadge.remove();
        const oldOverlay = card.querySelector('.pm-lock-overlay');
        if (oldOverlay) oldOverlay.remove();
        card.classList.remove('locked', 'disabled');
        card.disabled = false;
        if (id === lockedId) {
            card.classList.add('locked');
            const badge = document.createElement('span');
            badge.className = 'pm-lock-badge';
            badge.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> <span id="lockTime-' + id + '"></span>';
            card.appendChild(badge);
        } else {
            card.classList.add('disabled');
            card.disabled = true;
            const ov = document.createElement('div');
            ov.className = 'pm-lock-overlay';
            ov.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>';
            card.appendChild(ov);
        }
    });
    const hint = document.getElementById('methodHint');
    if (hint) hint.textContent = 'Metode aktif terkunci 5 menit';
    startLockCountdown(lockedId, sisaDetik);
}

function getLoadingText(jenis) {
    const map = {
        qris:    ['Memuat QRIS...', 'Generate kode QRIS merchant'],
        bank:    ['Menyiapkan rekening...', 'Mengambil data bank tujuan'],
        ewallet: ['Menyiapkan e-wallet...', 'Mengambil data e-wallet tujuan'],
        custom:  ['Memuat instruksi...', 'Menyiapkan info pembayaran']
    };
    return map[jenis] || map.custom;
}

function buildDetailContentWithLoading(d) {
    const loader = document.getElementById('modalLoader');
    const body = document.getElementById('modalBody');
    const [txt, sub] = getLoadingText(d.jenis);
    const elTxt = document.getElementById('ldText');
    const elSub = document.getElementById('ldSub');
    if (elTxt) elTxt.textContent = txt;
    if (elSub) elSub.textContent = sub;
    if (loader) loader.style.display = 'flex';
    if (body) body.style.display = 'none';
    buildDetailContent(d);
    const delay = 800 + Math.random() * 300;
    setTimeout(() => {
        if (loader) loader.style.display = 'none';
        if (body) {
            body.style.display = 'block';
            body.style.animation = 'fadeUp .3s cubic-bezier(.22,1,.36,1)';
        }
    }, delay);
}

function openDetail(btn) {
    const d = btn.dataset;
    selectedMethod = {
        id: d.mid, nama: d.mnama, jenis: d.mjenis,
        provider: d.mprovider, nomor: d.mnomor, pemilik: d.mpemilik,
        instruksi: d.minstruksi, qris: d.mqris, logo: d.mlogo
    };
    const selId = document.getElementById('selectedMetodeId');
    if (selId) selId.value = d.mid;
    document.getElementById('detailModal').classList.add('show');
    buildDetailContentWithLoading(selectedMethod);
}

function reopenDetail() {
    if (!selectedMethod) { showToast('Data metode tidak ditemukan', 'error'); return; }
    const selId = document.getElementById('selectedMetodeId');
    if (selId) selId.value = selectedMethod.id;
    document.getElementById('detailModal').classList.add('show');
    buildDetailContentWithLoading(selectedMethod);
}

/* ========== DETEKSI E-WALLET ========== */
function detectEwallet(provider) {
    if (!provider) return null;
    const p = String(provider).toLowerCase().trim();
    if (p.includes('dana'))      return { name: 'DANA',      short: 'DANA', scheme: 'dana',      androidPkg: 'id.dana',          store: 'https://play.google.com/store/apps/details?id=id.dana',          iosStore: 'https://apps.apple.com/id/app/dana-dompet-digital-indonesia/id1437123005', color: '#118EEA' };
    if (p.includes('ovo'))       return { name: 'OVO',       short: 'OVO',  scheme: 'ovo',       androidPkg: 'ovo.id',           store: 'https://play.google.com/store/apps/details?id=ovo.id',           iosStore: 'https://apps.apple.com/id/app/ovo-super-app/id1444733951',       color: '#4C3494' };
    if (p.includes('gopay') || p.includes('gojek') || p.includes('go-pay'))
                                 return { name: 'GoPay',     short: 'GoPay', scheme: 'gojek',    androidPkg: 'com.gojek.app',    store: 'https://play.google.com/store/apps/details?id=com.gojek.app',    iosStore: 'https://apps.apple.com/id/app/gojek/id1058617129',               color: '#00AA13' };
    if (p.includes('shopee') || p.includes('shopeepay'))
                                 return { name: 'ShopeePay', short: 'SPay',  scheme: 'shopeepay', androidPkg: 'com.shopeepay.id', store: 'https://play.google.com/store/apps/details?id=com.shopeepay.id', iosStore: 'https://apps.apple.com/id/app/shopeepay/id1168804635',           color: '#EE4D2D' };
    return null;
}

/* ========== PLATFORM DETECT ========== */
function getPlatform() {
    const ua = navigator.userAgent || '';
    if (/android/i.test(ua)) return 'android';
    if (/iphone|ipad|ipod/i.test(ua)) return 'ios';
    return 'other';
}

/* ========== COPY + BUKA E-WALLET (FIXED) ========== */
function openEwallet(scheme, androidPkg, storeUrl, iosStoreUrl, nomor, appName) {
    // 1. Copy nomor
    if (nomor) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(nomor).catch(() => {});
        } else {
            const t = document.createElement('textarea');
            t.value = nomor; t.style.position = 'fixed'; t.style.opacity = '0';
            document.body.appendChild(t); t.select();
            try { document.execCommand('copy'); } catch(e){}
            document.body.removeChild(t);
        }
    }

    showToast('Nomor dicopy · Membuka ' + appName + '...', 'info');
    if (navigator.vibrate) navigator.vibrate(8);

    const platform = getPlatform();

    // Deteksi kalau app berhasil kebuka (page jadi hidden)
    let appOpened = false;
    const onVis = () => { if (document.hidden) appOpened = true; };
    document.addEventListener('visibilitychange', onVis);

    // ============ ANDROID → INTENT MINIMAL ============
    if (platform === 'android') {
        const intentUrl = 'intent://#Intent;package=' + androidPkg + ';scheme=' + scheme + ';end';
        window.location.href = intentUrl;

        setTimeout(() => {
            document.removeEventListener('visibilitychange', onVis);
            if (!appOpened && !document.hidden) {
                if (confirm(appName + ' sepertinya tidak terbuka.\n\nMau buka Play Store untuk cek instalasi?')) {
                    window.location.href = storeUrl;
                }
            }
        }, 2200);
        return;
    }

    // ============ iOS → CUSTOM SCHEME ============
    if (platform === 'ios') {
        window.location.href = scheme + '://';

        setTimeout(() => {
            document.removeEventListener('visibilitychange', onVis);
            if (!appOpened && !document.hidden) {
                if (confirm(appName + ' belum terinstall.\n\nBuka App Store?')) {
                    window.location.href = iosStoreUrl;
                }
            }
        }, 2000);
        return;
    }

    // ============ OTHER ============
    if (confirm('Buka ' + appName + '?')) {
        window.location.href = scheme + '://';
    }
}
/* ========================================= */

function buildDetailContent(d) {
    const iconMap = { qris:'qris', bank:'bank', ewallet:'wallet', custom:'creditCard' };
    const ic = document.getElementById('mhIcon');
    if (d.logo) ic.innerHTML = '<img src="' + d.logo + '" alt="">';
    else ic.innerHTML = iconSvg(iconMap[d.jenis] || 'creditCard', 22);
    document.getElementById('mhTitle').textContent = d.nama;
    document.getElementById('mhSub').textContent = (d.provider || d.jenis).toUpperCase();

    let html = '';

    // QRIS
    if (d.jenis === 'qris' && d.qris) {
        html += '<div class="py-qr"><img src="' + d.qris + '" onclick="viewImage(\'' + d.qris + '\')" alt="QRIS" loading="lazy"></div>';
    }
    // Rekening / Nomor
    else if (d.nomor) {
        html += '<div class="py-rek"><div class="rk-body"><div class="rk-lbl">' + (d.jenis === 'bank' ? 'Nomor Rekening' : 'Nomor') + '</div><div class="rk-val" id="rekVal">' + escHtml(d.nomor) + '</div></div><button type="button" class="py-copy" onclick="copyRek(this)">' + iconSvg('copy', 15) + '</button></div>';
        if (d.pemilik) {
            html += '<div class="py-rek"><div class="rk-body"><div class="rk-lbl">Atas Nama</div><div class="rk-val owner">' + escHtml(d.pemilik) + '</div></div></div>';
        }
    }

    // E-WALLET OPEN BUTTON
const ew = detectEwallet(d.provider || d.nama);
if (ew && d.nomor) {
    // Logo: pakai logo upload kalau ada
    const logoHtml = d.logo
        ? '<img src="' + d.logo + '" alt="" style="width:78%;height:78%;object-fit:contain;">'
        : ew.short;
    const logoStyle = d.logo
    ? ''   // putih sudah default dari CSS
    : 'background:rgba(255,255,255,.22);padding:0;';

    html += '<div class="py-ewallet-wrap">';
    html += '<button type="button" class="py-ewallet-btn" style="background:linear-gradient(135deg,' + ew.color + ',' + ew.color + 'dd);" onclick="openEwallet(\'' + ew.scheme + '\',\'' + ew.androidPkg + '\',\'' + ew.store + '\',\'' + ew.iosStore + '\',\'' + escHtml(d.nomor) + '\',\'' + ew.name + '\')">';
    html +=   '<span class="ew-logo" style="' + logoStyle + '">' + logoHtml + '</span>';
    html +=   '<span class="ew-body">';
    html +=     '<span class="ew-title">Salin & Buka ' + ew.name + '</span>';
    html +=     '<span class="ew-sub">Nomor otomatis dicopy, lalu buka aplikasi</span>';
    html +=   '</span>';
    html +=   '<span class="ew-arrow">' + iconSvg('arrowR', 18) + '</span>';
    html += '</button>';
    html += '<div class="ew-hint">' + iconSvg('info', 13) + '<span>Setelah aplikasi terbuka, paste nomor di menu Transfer. Nominal tetap kamu input manual ya.</span></div>';
    html += '</div>';
}

    // Instruksi
    if (d.instruksi) {
        html += '<div class="py-instr">' + iconSvg('info', 15) + '<div>' + escHtml(d.instruksi).replace(/\n/g, '<br>') + '</div></div>';
    }
    if (!html) {
        html = '<div class="py-instr">' + iconSvg('info', 15) + ' <div>Hubungi admin untuk info lebih lanjut.</div></div>';
    }

    document.getElementById('mhContent').innerHTML = html;
}

function closeDetail() {
    document.getElementById('detailModal').classList.remove('show');
    if (document.getElementById('pendingCard')) hidePaymentUI();
}

function showKonfirmasiView() {
    document.getElementById('detailModal').classList.remove('show');
    document.getElementById('opsiModal').classList.add('show');
    if (document.getElementById('pendingCard')) hidePaymentUI();
}

function closeOpsi() { document.getElementById('opsiModal').classList.remove('show'); }

function chooseUpload() {
    closeOpsi();
    hidePaymentUI();
    const sec = document.getElementById('uploadSection');
    if (sec) {
        sec.classList.add('open');
        setTimeout(() => sec.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
        showToast('Silakan upload bukti transfer', 'info');
    }
}

async function chooseWA() {
    const fd = new FormData();
    fd.append('token', TOKEN);
    if (selectedMethod && selectedMethod.id) fd.append('metode_id', selectedMethod.id);
    try {
        const res = await fetch(BASE + '/?url=api/pay-konfirmasi-wa', { method: 'POST', body: fd });
        const data = await res.json();
        if (data.success) {
            const waMsg = 'Halo Admin,\n\nSaya sudah melakukan pembayaran:\n\n📄 Invoice: ' + INVOICE_NUM + '\n💰 Nominal: ' + TOTAL_RP + '\n👤 Nama: ' + NAMA_PEMBAYAR + '\n\nBerikut bukti transfer saya: (attach gambar)\n\nTerima kasih 🙏';
            if (WA_ADMIN) {
                window.open('https://wa.me/' + WA_ADMIN + '?text=' + encodeURIComponent(waMsg), '_blank');
            }
            closeOpsi();
            showToast('Status diupdate. Kirim bukti via WhatsApp!', 'success');
            setTimeout(() => location.reload(), 1200);
        } else {
            showToast(data.message || 'Gagal', 'error');
        }
    } catch (e) {
        showToast('Koneksi error', 'error');
    }
}

function copyRek(btn) {
    const el = document.getElementById('rekVal');
    if (!el) return;
    const txt = el.textContent.trim();
    const done = () => {
        const orig = btn.innerHTML;
        btn.classList.add('copied');
        btn.innerHTML = iconSvg('check', 15);
        setTimeout(() => { btn.classList.remove('copied'); btn.innerHTML = orig; }, 1400);
    };
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(txt).then(done).catch(() => {});
    } else {
        const t = document.createElement('textarea');
        t.value = txt; t.style.position = 'fixed'; t.style.opacity = '0';
        document.body.appendChild(t); t.select();
        try { document.execCommand('copy'); done(); } catch(e){}
        document.body.removeChild(t);
    }
}

function previewFile(e) {
    const f = e.target.files[0];
    if (!f) return;
    if (f.size > 3 * 1024 * 1024) { showToast('Maksimal 3 MB', 'error'); e.target.value = ''; return; }
    const r = new FileReader();
    r.onload = ev => {
        document.getElementById('uploadPreview').src = ev.target.result;
        document.getElementById('uploadBox').classList.add('has-img');
    };
    r.readAsDataURL(f);
}

function removeUpload(e) {
    e.preventDefault(); e.stopPropagation();
    document.getElementById('buktiInput').value = '';
    document.getElementById('uploadBox').classList.remove('has-img');
}

async function submitUpload(e) {
    e.preventDefault();
    const file = document.getElementById('buktiInput').files[0];
    if (!file) { showToast('Bukti transfer wajib diupload', 'error'); return; }
    const btn = document.getElementById('submitBtn');
    btn.classList.add('loading'); btn.disabled = true;
    const fd = new FormData(document.getElementById('uploadForm'));
    try {
        const res = await fetch(BASE + '/?url=api/pay-upload', { method: 'POST', body: fd });
        const data = await res.json();
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(data.message || 'Gagal upload', 'error');
            btn.classList.remove('loading'); btn.disabled = false;
        }
    } catch (err) {
        showToast('Koneksi error', 'error');
        btn.classList.remove('loading'); btn.disabled = false;
    }
}

function viewImage(src) {
    document.getElementById('imgViewerSrc').src = src;
    document.getElementById('imgViewer').classList.add('show');
}

function iconSvg(name, size) {
    const paths = {
        qris: '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="3" height="3"/><line x1="21" y1="14" x2="21" y2="17"/><line x1="14" y1="21" x2="17" y2="21"/>',
        bank: '<path d="M3 21h18"/><path d="M5 21V10l7-5 7 5v11"/><path d="M9 21v-6h6v6"/>',
        wallet: '<path d="M20 12V8H6a2 2 0 0 1 0-4h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/>',
        creditCard: '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        copy: '<rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>',
        check: '<polyline points="20 6 9 17 4 12"/>',
        info: '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
        arrowR: '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
    };
    const p = paths[name] || paths.creditCard;
    return '<svg xmlns="http://www.w3.org/2000/svg" width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + p + '</svg>';
}

function escHtml(s) {
    if (s == null) return '';
    return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeConfirm(); closeDetail(); closeOpsi();
        document.getElementById('imgViewer').classList.remove('show');
    }
});

<?php if ($isWaiting): ?>
(function() {
    let lastStatus = 'waiting';
    let intervalId = null;
    async function check() {
        if (document.hidden) return;
        try {
            const res = await fetch(BASE + '/?url=api/pay-status&token=' + TOKEN + '&t=' + Date.now());
            const data = await res.json();
            if (data.success && data.status !== lastStatus) {
                lastStatus = data.status;
                if (data.status === 'paid') {
                    showToast('🎉 Pembayaran dikonfirmasi!', 'success');
                    setTimeout(() => location.reload(), 1200);
                } else if (data.status === 'unpaid') {
                    showToast('Bukti ditolak. Cek alasan.', 'error');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    setTimeout(() => location.reload(), 700);
                }
            }
        } catch(e) {}
    }
    function start() { if (!intervalId) intervalId = setInterval(check, 3000); }
    function stop() { if (intervalId) { clearInterval(intervalId); intervalId = null; } }
    start(); check();
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stop();
        else { start(); check(); }
    });
})();
<?php endif; ?>

window.addEventListener('beforeunload', () => {
    if (lockCountdownInterval) clearInterval(lockCountdownInterval);
    if (countdownInterval) clearInterval(countdownInterval);
});
</script>

</body>
</html>