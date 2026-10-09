<?php
$title = 'Konfirmasi Pembayaran';
$active = 'konfirmasi';

// ============ ICON SVG ============
function kf_icon($name, $size = 20) {
    $icons = [
        'checkCircle' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        'hourglass'   => '<path d="M6 2h12M6 22h12M6 2v6l6 4-6 4v6M18 2v6l-6 4 6 4v6"/>',
        'xCircle'     => '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>',
        'list'        => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
        'search'      => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'x'           => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'zoom'        => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>',
        'eye'         => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'check'       => '<polyline points="20 6 9 17 4 12"/>',
        'card'        => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        'phone'       => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'clock'       => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'note'        => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
        'alert'       => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
        'inbox'       => '<polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>',
        'image'       => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>',
        'wa'          => '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>',
        'trash'       => '<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; display:inline-block; vertical-align:middle;">'.$path.'</svg>';
}

// Stats awal
$stats = [
    'waiting'  => (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='waiting'")->fetchColumn(),
    'approved' => (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='approved'")->fetchColumn(),
    'rejected' => (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='rejected'")->fetchColumn(),
    'all'      => (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs")->fetchColumn(),
];

// Count yang via WA (buat info tambahan)
$via_wa_waiting = (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='waiting' AND konfirmasi_via='wa'")->fetchColumn();

$filter = $_GET['f'] ?? 'waiting';

render_header($title, $active);
?>

<style>
    .kf-wrap { max-width: 1200px; }

    .kf-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; gap:14px; flex-wrap:wrap; }
    .kf-head h2 { font-size:20px; font-weight:800; color:#0f172a; }
    .kf-head p { color:#64748b; font-size:13px; margin-top:4px; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .kf-head .wa-info {
        display:inline-flex; align-items:center; gap:5px;
        padding:3px 10px; border-radius:14px;
        background:#dcfce7; color:#166534;
        font-size:11.5px; font-weight:700;
    }

    /* Stat cards */
    .kf-stats { display:grid; grid-template-columns:repeat(4, 1fr); gap:10px; margin-bottom:20px; }
    .kf-stat {
        background:#fff; border-radius:12px; padding:14px 16px;
        border:1px solid #f1f5f9; cursor:pointer; transition:.15s;
        display:flex; align-items:center; gap:12px;
    }
    .kf-stat:hover { border-color:#e0e7ff; box-shadow:0 4px 12px rgba(99,102,241,0.06); }
    .kf-stat.active { border-color:#6366f1; background:#eef2ff; }
    .kf-stat .st-ic {
        width:38px; height:38px; border-radius:10px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .kf-stat[data-f="waiting"] .st-ic { background:#fef3c7; color:#d97706; }
    .kf-stat[data-f="approved"] .st-ic { background:#dcfce7; color:#16a34a; }
    .kf-stat[data-f="rejected"] .st-ic { background:#fee2e2; color:#dc2626; }
    .kf-stat[data-f="all"] .st-ic { background:#f1f5f9; color:#475569; }
    .kf-stat.active[data-f="waiting"] .st-ic { background:#fff; color:#d97706; }
    .kf-stat.active[data-f="approved"] .st-ic { background:#fff; color:#16a34a; }
    .kf-stat.active[data-f="rejected"] .st-ic { background:#fff; color:#dc2626; }
    .kf-stat.active[data-f="all"] .st-ic { background:#fff; color:#6366f1; }

    .kf-stat .st-body { flex:1; min-width:0; }
    .kf-stat .st-lbl { font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; font-weight:600; }
    .kf-stat .st-num { font-size:20px; font-weight:800; color:#0f172a; line-height:1.2; margin-top:2px; }
    .kf-stat.active .st-num { color:#4338ca; }

    /* Search */
    .kf-search { display:flex; gap:10px; margin-bottom:16px; }
    .kf-search .wrap { flex:1; position:relative; }
    .kf-search input {
        width:100%; padding:11px 16px 11px 42px; border:1.5px solid #e2e8f0;
        border-radius:10px; font-size:14px; background:#fff; font-family:inherit;
    }
    .kf-search input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }
    .kf-search .ic { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; display:flex; align-items:center; }
    .kf-search .clear {
        position:absolute; right:12px; top:50%; transform:translateY(-50%);
        background:#f1f5f9; border:none; width:24px; height:24px; border-radius:50%;
        cursor:pointer; color:#64748b; display:none; align-items:center; justify-content:center;
    }
    .kf-search .clear.show { display:flex; }
    .kf-search .clear:hover { background:#e2e8f0; }

    /* List */
    .kf-list { display:flex; flex-direction:column; gap:12px; min-height:120px; transition:opacity .2s; }
    .kf-list.loading { opacity:.5; pointer-events:none; }

    .kf-card {
        background:#fff; border-radius:14px; padding:18px 20px;
        border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);
        transition:.15s; animation: kfFade .25s ease;
    }
    @keyframes kfFade { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:none; } }
    .kf-card:hover { border-color:#e0e7ff; box-shadow:0 6px 20px rgba(99,102,241,0.06); }

    .kf-grid { display:grid; grid-template-columns:180px 1fr; gap:18px; }

    .kf-img {
        background:#f8fafc; border-radius:11px; overflow:hidden;
        aspect-ratio:1; display:flex; align-items:center; justify-content:center;
        border:1.5px solid #f1f5f9; cursor:zoom-in; position:relative;
        transition:.15s;
    }
    .kf-img:hover { border-color:#c7d2fe; }
    .kf-img img { width:100%; height:100%; object-fit:cover; }
    .kf-img .empty { color:#cbd5e1; }
    .kf-img .zoom-badge {
        position:absolute; bottom:8px; right:8px;
        background:rgba(15,23,42,0.75); color:#fff;
        padding:5px 9px; border-radius:7px;
        font-size:10px; font-weight:600; letter-spacing:.3px;
        display:flex; align-items:center; gap:4px;
        backdrop-filter:blur(4px);
    }

    /* WA type image (karena via WA mungkin gak ada gambar) */
    .kf-img.wa-type {
        cursor:default;
        background:linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    }
    .kf-img.wa-type:hover { border-color:#f1f5f9; }
    .kf-img.wa-type .wa-big {
        display:flex; flex-direction:column; align-items:center; gap:8px;
        color:#166534;
    }
    .kf-img.wa-type .wa-big span {
        font-size:11px; font-weight:700; text-transform:uppercase;
        letter-spacing:.5px; opacity:.8;
    }

    .kf-body { display:flex; flex-direction:column; gap:10px; min-width:0; }

    .kf-top { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .kf-num {
        font-family:'Courier New', monospace; font-size:11px; color:#475569;
        background:#f1f5f9; padding:4px 9px; border-radius:6px;
        font-weight:700; letter-spacing:.3px;
    }
    .kf-pill {
        display:inline-flex; align-items:center; gap:5px;
        padding:4px 10px; border-radius:20px;
        font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.4px;
    }
    .kf-pill.waiting { background:#fef3c7; color:#92400e; }
    .kf-pill.approved { background:#dcfce7; color:#166534; }
    .kf-pill.rejected { background:#fee2e2; color:#991b1b; }
    .kf-pill .dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

    /* Badge via WA */
    .kf-pill.via-wa {
        background:#dcfce7; color:#166534;
        border:1px solid #86efac;
    }
    .kf-pill.via-wa svg { color:#16a34a; }

    .kf-nama { font-size:15px; font-weight:700; color:#0f172a; }
    .kf-amt { font-size:22px; font-weight:800; color:#0f172a; font-variant-numeric:tabular-nums; }

    .kf-meta { display:flex; gap:16px; flex-wrap:wrap; font-size:12px; color:#94a3b8; }
    .kf-meta .m { display:inline-flex; align-items:center; gap:5px; }

    .kf-catatan {
        background:#f8fafc; padding:10px 12px; border-radius:9px;
        font-size:12.5px; color:#475569; line-height:1.55;
        display:flex; gap:8px; align-items:flex-start;
    }
    .kf-catatan svg { flex-shrink:0; margin-top:2px; color:#94a3b8; }
    .kf-catatan strong { font-size:10.5px; text-transform:uppercase; letter-spacing:.5px; color:#64748b; display:block; margin-bottom:3px; }

    .kf-alasan {
        background:#fef2f2; padding:10px 12px; border-radius:9px;
        font-size:12.5px; color:#991b1b; line-height:1.55;
        display:flex; gap:8px; align-items:flex-start;
    }
    .kf-alasan svg { flex-shrink:0; margin-top:2px; }

    /* Info box khusus WA */
    .kf-wa-info {
        background:linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        padding:11px 13px; border-radius:10px;
        font-size:12.5px; color:#166534; line-height:1.55;
        display:flex; gap:9px; align-items:flex-start;
        border:1px solid #bbf7d0;
    }
    .kf-wa-info svg { flex-shrink:0; margin-top:2px; color:#16a34a; }
    .kf-wa-info strong { font-weight:800; }

    .kf-actions { display:flex; gap:8px; flex-wrap:wrap; margin-top:4px; }
    .kf-btn {
        display:inline-flex; align-items:center; gap:6px;
        padding:9px 14px; border-radius:9px; font-size:12.5px; font-weight:600;
        border:1.5px solid #e2e8f0; background:#fff; color:#475569;
        cursor:pointer; text-decoration:none; transition:.15s; font-family:inherit;
        white-space:nowrap;
    }
    .kf-btn:hover { border-color:#cbd5e1; background:#f8fafc; transform:translateY(-1px); }
    .kf-btn:disabled { opacity:.5; cursor:not-allowed; transform:none; }
    .kf-btn.green { background:linear-gradient(135deg,#16a34a,#22c55e); color:#fff; border-color:transparent; }
    .kf-btn.green:hover { opacity:.92; box-shadow:0 4px 12px rgba(22,163,74,0.25); }
    .kf-btn.red { color:#dc2626; border-color:#fecaca; }
    .kf-btn.red:hover { background:#fef2f2; border-color:#fca5a5; }
    .kf-btn.primary { color:#4f46e5; border-color:#c7d2fe; }
    .kf-btn.primary:hover { background:#eef2ff; }
    .kf-btn.wa { color:#16a34a; border-color:#bbf7d0; background:#f0fdf4; }
    .kf-btn.wa:hover { background:#dcfce7; }

    /* Empty */
    .kf-empty { text-align:center; padding:70px 20px; background:#fff; border-radius:14px; border:1px solid #f1f5f9; }
    .kf-empty .em-ic {
        width:80px; height:80px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 18px;
    }
    .kf-empty .em-ic.green { background:linear-gradient(135deg,#dcfce7,#bbf7d0); color:#16a34a; }
    .kf-empty .em-ic.gray { background:linear-gradient(135deg,#f1f5f9,#e2e8f0); color:#64748b; }
    .kf-empty h3 { font-size:17px; font-weight:700; color:#0f172a; margin-bottom:6px; }
    .kf-empty p { color:#94a3b8; font-size:13px; max-width:340px; margin:0 auto; line-height:1.5; }

    /* Modal */
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

    .modal-hd { display:flex; align-items:center; gap:12px; margin-bottom:16px; }
    .modal-hd .ic {
        width:44px; height:44px; border-radius:12px;
        background:#fee2e2; color:#dc2626;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .modal-hd h3 { font-size:17px; font-weight:700; color:#0f172a; }
    .modal-hd p { font-size:12.5px; color:#94a3b8; margin-top:2px; }

    .modal-content label { display:block; font-size:12px; font-weight:600; color:#334155; margin-bottom:6px; }
    .modal-content textarea {
        width:100%; padding:11px 13px; border:1.5px solid #e2e8f0;
        border-radius:9px; font-size:13.5px; font-family:inherit;
        min-height:90px; resize:vertical;
    }
    .modal-content textarea:focus { outline:none; border-color:#dc2626; box-shadow:0 0 0 3px rgba(220,38,38,0.1); }

    .modal-btns { display:flex; gap:8px; margin-top:16px; }
    .modal-btns .btn { flex:1; justify-content:center; padding:11px; }

    /* Image viewer */
    .img-viewer {
        display:none; position:fixed; inset:0; z-index:300;
        background:rgba(0,0,0,0.92); align-items:center; justify-content:center;
        padding:20px; cursor:zoom-out;
    }
    .img-viewer.show { display:flex; }
    .img-viewer img { max-width:100%; max-height:100%; object-fit:contain; border-radius:8px; }

    /* Toast */
    .toast-wrap { position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:10px; }
    .toast {
        background:#0f172a; color:#fff; padding:12px 18px; border-radius:10px;
        font-size:13px; font-weight:500; box-shadow:0 6px 20px rgba(0,0,0,0.15);
        display:flex; align-items:center; gap:10px; min-width:220px;
        animation: slideIn .25s ease; border-left:4px solid #10b981;
    }
    .toast.error { border-left-color:#ef4444; }
    @keyframes slideIn { from { transform: translateX(100%); opacity:0; } to { transform: none; opacity:1; } }
    .toast.hide { animation: slideOut .25s ease forwards; }
    @keyframes slideOut { to { transform: translateX(100%); opacity:0; } }

    /* Loading */
    .kf-loading {
        position:fixed; top:14px; right:14px; background:#0f172a; color:#fff;
        padding:8px 14px; border-radius:20px; font-size:12px; z-index:999;
        display:none; align-items:center; gap:8px; box-shadow:0 6px 20px rgba(0,0,0,0.2);
    }
    .kf-loading.show { display:flex; }
    .kf-loading .spin {
        width:12px; height:12px; border:2px solid rgba(255,255,255,0.3);
        border-top-color:#fff; border-radius:50%; animation:spin .7s linear infinite;
    }
    @keyframes spin { to { transform:rotate(360deg); } }

    /* Responsive */
    @media (max-width:1024px) { .kf-stats { grid-template-columns:repeat(2, 1fr); } }
    @media (max-width:768px) {
        .kf-grid { grid-template-columns:1fr; }
        .kf-img { aspect-ratio:16/10; max-height:220px; }
        .kf-actions { gap:6px; }
        .kf-actions .kf-btn { flex:1; justify-content:center; }
        .toast-wrap { top:10px; right:10px; left:10px; }
    }
    @media (max-width:480px) {
        .kf-stats { grid-template-columns:1fr; }
        .kf-card { padding:14px; }
        .kf-amt { font-size:19px; }
    }
</style>

<div class="toast-wrap" id="toastWrap"></div>
<div class="kf-loading" id="kfLoading"><div class="spin"></div> Memperbarui...</div>

<div class="kf-wrap">

    <div class="kf-head">
        <div>
            <h2>Konfirmasi Pembayaran</h2>
            <p>
                Review bukti bayar dari pembayar
                <span style="color:#10b981;">●</span>
                <span style="font-size:11px;">live</span>
                <?php if ($via_wa_waiting > 0): ?>
                    <span class="wa-info">
                        <?= kf_icon('wa', 11) ?>
                        <?= $via_wa_waiting ?> via WA
                    </span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Stat cards -->
    <div class="kf-stats" id="statsTabs">
        <div class="kf-stat <?= $filter === 'waiting' ? 'active' : '' ?>" data-f="waiting">
            <div class="st-ic"><?= kf_icon('hourglass', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Menunggu</div>
                <div class="st-num" id="cnt-waiting"><?= $stats['waiting'] ?></div>
            </div>
        </div>
        <div class="kf-stat <?= $filter === 'approved' ? 'active' : '' ?>" data-f="approved">
            <div class="st-ic"><?= kf_icon('checkCircle', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Disetujui</div>
                <div class="st-num" id="cnt-approved"><?= $stats['approved'] ?></div>
            </div>
        </div>
        <div class="kf-stat <?= $filter === 'rejected' ? 'active' : '' ?>" data-f="rejected">
            <div class="st-ic"><?= kf_icon('xCircle', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Ditolak</div>
                <div class="st-num" id="cnt-rejected"><?= $stats['rejected'] ?></div>
            </div>
        </div>
        <div class="kf-stat <?= $filter === 'all' ? 'active' : '' ?>" data-f="all">
            <div class="st-ic"><?= kf_icon('list', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Semua</div>
                <div class="st-num" id="cnt-all"><?= $stats['all'] ?></div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="kf-search">
        <div class="wrap">
            <span class="ic"><?= kf_icon('search', 18) ?></span>
            <input type="text" id="searchInput" placeholder="Cari nama / no invoice..." autocomplete="off">
            <button type="button" class="clear" id="clearSearch"><?= kf_icon('x', 12) ?></button>
        </div>
    </div>

    <!-- List -->
    <div class="kf-list" id="kfList">
        <div style="text-align:center; padding:40px; color:#94a3b8; font-size:13px;">Memuat data...</div>
    </div>

</div>

<!-- Modal Reject -->
<div class="modal-overlay" id="rejectModal">
    <div class="modal-content">
        <div class="modal-hd">
            <div class="ic"><?= kf_icon('xCircle', 22) ?></div>
            <div>
                <h3>Tolak Bukti Bayar</h3>
                <p>Bukti untuk <strong id="rejInv"></strong> akan ditolak</p>
            </div>
        </div>

        <form id="rejForm" onsubmit="submitReject(event)">
            <label>Alasan Penolakan <span style="color:#dc2626;">*</span></label>
            <textarea id="rejAlasan" required placeholder="misal: nominal transfer tidak sesuai / bukti tidak jelas"></textarea>

            <div class="modal-btns">
                <button type="submit" class="btn btn-danger" id="rejSubmit">
                    <?= kf_icon('x', 15) ?> Tolak
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
const KF_ICONS = {
    eye:    '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
    check:  '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
    x:      '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
    zoom:   '<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>',
    card:   '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>',
    phone:  '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
    clock:  '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
    note:   '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>',
    alert:  '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
    image:  '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>',
    inbox:  '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>',
    checkCircle: '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
    wa: '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
    waBig: '<svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
};

let state = { q: '', f: '<?= e($filter) ?>', loading: false };
let searchTimer = null;
let currentRejectProofId = null;

const API_LIST   = '<?= BASE_URL ?>/?url=api/konfirmasi-list';
const API_ACTION = '<?= BASE_URL ?>/?url=api/konfirmasi-action';
const URL_DETAIL = '<?= url('invoice-detail&id=') ?>';

function showToast(msg, type = 'success') {
    const wrap = document.getElementById('toastWrap');
    if (!wrap) return;
    const el = document.createElement('div');
    el.className = 'toast ' + type;
    const iconSvg = type === 'success' ? KF_ICONS.check : KF_ICONS.x;
    el.innerHTML = iconSvg + ' <span>' + msg + '</span>';
    wrap.appendChild(el);
    setTimeout(() => {
        el.classList.add('hide');
        setTimeout(() => el.remove(), 300);
    }, 2600);
}

function escHtml(s) {
    if (s == null) return '';
    return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

async function fetchList(showLoading) {
    if (state.loading) return;
    state.loading = true;

    const list = document.getElementById('kfList');
    if (list) list.classList.add('loading');
    if (showLoading) document.getElementById('kfLoading').classList.add('show');

    try {
        const url = API_LIST + '&f=' + state.f + '&q=' + encodeURIComponent(state.q) + '&t=' + Date.now();
        const res = await fetch(url);
        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Gagal');

        renderList(data.rows);
        updateStats(data.stats);
    } catch (e) {
        console.error(e);
        showToast('Gagal memuat data', 'error');
    } finally {
        state.loading = false;
        if (list) list.classList.remove('loading');
        document.getElementById('kfLoading').classList.remove('show');
    }
}

function renderList(rows) {
    const list = document.getElementById('kfList');
    if (!list) return;

    if (!rows.length) {
        const isEmpty = state.q || state.f !== 'waiting';
        const isGreen = state.f === 'waiting' && !state.q;
        list.innerHTML = `
            <div class="kf-empty">
                <div class="em-ic ${isGreen ? 'green' : 'gray'}">
                    ${isGreen ? KF_ICONS.checkCircle : KF_ICONS.inbox}
                </div>
                <h3>${isGreen ? 'Tidak ada yang perlu dikonfirmasi' : 'Belum ada data'}</h3>
                <p>${isGreen ? 'Semua bukti bayar udah diproses. Kerja bagus!' : (isEmpty ? 'Coba ubah filter atau reset pencarian.' : 'Belum ada bukti bayar untuk filter ini.')}</p>
            </div>
        `;
        return;
    }

    let html = '';
    rows.forEach(r => {
        const isWaiting = r.status === 'waiting';
        const pillClass = r.status;
        const pillLabel = r.pill_label;
        const isViaWa = r.via_wa;

        // Gambar / placeholder
        let imgHtml = '';
        if (r.gambar_url) {
            imgHtml = `
                <div class="kf-img" onclick="viewImage('${r.gambar_url}')">
                    <img src="${r.gambar_url}" alt="Bukti" loading="lazy">
                    <span class="zoom-badge">${KF_ICONS.zoom} Zoom</span>
                </div>
            `;
        } else if (isViaWa) {
            imgHtml = `
                <div class="kf-img wa-type">
                    <div class="wa-big">
                        ${KF_ICONS.waBig}
                        <span>Via WhatsApp</span>
                    </div>
                </div>
            `;
        } else {
            imgHtml = `<div class="kf-img"><span class="empty">${KF_ICONS.image}</span></div>`;
        }

        // Badge via WA
        let waBadge = '';
        if (isViaWa) {
            waBadge = `<span class="kf-pill via-wa">${KF_ICONS.wa} via WA</span>`;
        }

        // Info box khusus WA
        let waInfoHtml = '';
        if (isViaWa) {
            waInfoHtml = `
                <div class="kf-wa-info">
                    ${KF_ICONS.wa}
                    <div>
                        <strong>Konfirmasi via WhatsApp</strong><br>
                        Cek WhatsApp <strong>${escHtml(r.nomor_wa)}</strong> untuk melihat bukti yang dikirim user.
                    </div>
                </div>
            `;
        }

        let catatanHtml = '';
        if (r.catatan_user) {
            catatanHtml = `
                <div class="kf-catatan">
                    ${KF_ICONS.note}
                    <div>
                        <strong>Catatan Pembayar</strong>
                        ${escHtml(r.catatan_user).replace(/\n/g, '<br>')}
                    </div>
                </div>
            `;
        }

        let alasanHtml = '';
        if (r.status === 'rejected' && r.alasan_reject) {
            alasanHtml = `
                <div class="kf-alasan">
                    ${KF_ICONS.alert}
                    <div><strong>Alasan Ditolak:</strong> ${escHtml(r.alasan_reject)}</div>
                </div>
            `;
        }

        // Actions
        let actionHtml = `
            <a href="${URL_DETAIL}${r.invoice_id}" class="kf-btn primary">
                ${KF_ICONS.eye} Lihat Tagihan
            </a>
        `;

        // Tombol chat WA kalau via WA
        if (isViaWa) {
            const waNum = String(r.nomor_wa || '').replace(/[^0-9]/g, '');
            let waNum2 = waNum;
            if (waNum2.startsWith('0')) waNum2 = '62' + waNum2.substring(1);
            else if (!waNum2.startsWith('62')) waNum2 = '62' + waNum2;
            actionHtml += `
                <a href="https://wa.me/${waNum2}?text=${encodeURIComponent('Halo, saya admin. Terkait tagihan ' + r.invoice_number)}" 
                   target="_blank" class="kf-btn wa">
                    ${KF_ICONS.wa} Chat User
                </a>
            `;
        }

        if (isWaiting) {
            actionHtml += `
                <button type="button" class="kf-btn green" onclick="doApprove(${r.id}, this)">
                    ${KF_ICONS.check} Setujui
                </button>
                <button type="button" class="kf-btn red" onclick='openReject(${r.id}, ${JSON.stringify(r.invoice_number)})'>
    ${KF_ICONS.x} Tolak
</button>
            `;
        }

        html += `
            <div class="kf-card" data-id="${r.id}">
                <div class="kf-grid">
                    <div>${imgHtml}</div>
                    <div class="kf-body">
                        <div class="kf-top">
                            <span class="kf-num">${escHtml(r.invoice_number)}</span>
                            <span class="kf-pill ${pillClass}"><span class="dot"></span>${escHtml(pillLabel)}</span>
                            ${waBadge}
                        </div>
                        <div>
                            <div class="kf-nama">${escHtml(r.nama_pembayar)}</div>
                            <div class="kf-amt">${escHtml(r.total_fmt)}</div>
                        </div>
                        <div class="kf-meta">
                            <span class="m">${KF_ICONS.card} ${escHtml(r.metode_nama || 'Tanpa metode')}</span>
                            <span class="m">${KF_ICONS.phone} ${escHtml(r.nomor_wa)}</span>
                            <span class="m">${KF_ICONS.clock} ${escHtml(r.uploaded_fmt)}</span>
                        </div>
                        ${waInfoHtml}
                        ${catatanHtml}
                        ${alasanHtml}
                        <div class="kf-actions">${actionHtml}</div>
                    </div>
                </div>
            </div>
        `;
    });
    list.innerHTML = html;
}

function updateStats(stats) {
    const el = (id) => document.getElementById(id);
    ['waiting','approved','rejected','all'].forEach(k => {
        if (el('cnt-' + k)) el('cnt-' + k).textContent = stats[k] || 0;
    });
}

async function doApprove(proofId, btn) {
    if (!confirm('Setujui bukti bayar ini?\n\nTagihan akan ditandai LUNAS.')) return;

    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span style="opacity:.6;">Memproses...</span>';

    try {
        const fd = new FormData();
        fd.append('action', 'approve');
        fd.append('proof_id', proofId);
        const res = await fetch(API_ACTION, { method: 'POST', body: fd });
        const data = await res.json();

        if (!data.success) throw new Error(data.message);
        showToast(data.message, 'success');
        fetchList();
    } catch (e) {
        showToast(e.message || 'Gagal', 'error');
        btn.disabled = false;
        btn.innerHTML = orig;
    }
}

function openReject(proofId, invNum) {
    currentRejectProofId = proofId;
    document.getElementById('rejInv').textContent = invNum;
    document.getElementById('rejAlasan').value = '';
    document.getElementById('rejectModal').classList.add('show');
    setTimeout(() => document.getElementById('rejAlasan').focus(), 100);
}

function closeReject() {
    document.getElementById('rejectModal').classList.remove('show');
    currentRejectProofId = null;
}

async function submitReject(e) {
    e.preventDefault();
    const alasan = document.getElementById('rejAlasan').value.trim();
    if (!alasan) { showToast('Alasan wajib diisi', 'error'); return; }

    const btn = document.getElementById('rejSubmit');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = 'Memproses...';

    try {
        const fd = new FormData();
        fd.append('action', 'reject');
        fd.append('proof_id', currentRejectProofId);
        fd.append('alasan', alasan);
        const res = await fetch(API_ACTION, { method: 'POST', body: fd });
        const data = await res.json();

        if (!data.success) throw new Error(data.message);
        showToast(data.message, 'success');
        closeReject();
        fetchList();
    } catch (err) {
        showToast(err.message || 'Gagal', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = orig;
    }
}

function viewImage(src) {
    document.getElementById('imgViewerSrc').src = src;
    document.getElementById('imgViewer').classList.add('show');
}

document.querySelectorAll('#statsTabs .kf-stat').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('#statsTabs .kf-stat').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        state.f = this.dataset.f;
        fetchList();
    });
});

const searchInput = document.getElementById('searchInput');
const clearBtn = document.getElementById('clearSearch');

searchInput.addEventListener('input', function() {
    const val = this.value.trim();
    state.q = val;
    clearBtn.classList.toggle('show', val.length > 0);
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => fetchList(), 300);
});

clearBtn.addEventListener('click', function() {
    searchInput.value = '';
    state.q = '';
    clearBtn.classList.remove('show');
    fetchList();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeReject();
        document.getElementById('imgViewer').classList.remove('show');
    }
});

fetchList();

setInterval(() => {
    if (!state.loading && !state.q) {
        fetchList();
    }
}, 30000);
</script>

<?php render_footer(); ?>