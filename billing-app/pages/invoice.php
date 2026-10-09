<?php
$title = 'Daftar Tagihan';
$active = 'invoice';

// ============ ICON SVG ============
function iv_icon($name, $size = 20) {
    $icons = [
        'file'    => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
        'plus'    => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
        'search'  => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'x'       => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'eye'     => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'link'    => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
        'wa'      => '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>',
        'check'   => '<polyline points="20 6 9 17 4 12"/>',
        'checkCircle' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        'ban'     => '<circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>',
        'trash'   => '<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
        'clock'   => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'hourglass' => '<path d="M6 2h12M6 22h12M6 2v6l6 4-6 4v6M18 2v6l-6 4 6 4v6"/>',
        'tag'     => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
        'phone'   => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'inbox'   => '<polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>',
        'list'    => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
        'dollar'  => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
        'alert'   => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; display:inline-block; vertical-align:middle;">'.$path.'</svg>';
}

// Initial stats
$stats_awal = [
    'all'     => (int)$pdo->query("SELECT COUNT(*) FROM invoices")->fetchColumn(),
    'unpaid'  => (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status='unpaid'")->fetchColumn(),
    'waiting' => (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status='waiting'")->fetchColumn(),
    'paid'    => (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status='paid'")->fetchColumn(),
    'expired' => (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE status='expired'")->fetchColumn(),
];

$kategoris = $pdo->query("SELECT id, nama FROM categories ORDER BY nama")->fetchAll();

render_header($title, $active);
?>

<style>
    .iv-wrap { max-width: 1200px; }

    .iv-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; gap:14px; flex-wrap:wrap; }
    .iv-head h2 { font-size:20px; font-weight:800; color:#0f172a; }
    .iv-head p { color:#64748b; font-size:13px; margin-top:4px; }

    /* ============ STAT CARDS ============ */
    .iv-stats {
        display:grid; grid-template-columns:repeat(5, 1fr);
        gap:10px; margin-bottom:20px;
    }
    .iv-stat {
        background:#fff; border-radius:12px; padding:14px 16px;
        border:1px solid #f1f5f9; cursor:pointer; transition:.15s;
        display:flex; align-items:center; gap:12px;
    }
    .iv-stat:hover { border-color:#e0e7ff; box-shadow:0 4px 12px rgba(99,102,241,0.06); }
    .iv-stat.active { border-color:#6366f1; background:#eef2ff; }
    .iv-stat .st-ic {
        width:38px; height:38px; border-radius:10px;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0;
    }
    .iv-stat[data-f="all"] .st-ic { background:#f1f5f9; color:#475569; }
    .iv-stat[data-f="unpaid"] .st-ic { background:#fef3c7; color:#d97706; }
    .iv-stat[data-f="waiting"] .st-ic { background:#dbeafe; color:#2563eb; }
    .iv-stat[data-f="paid"] .st-ic { background:#dcfce7; color:#16a34a; }
    .iv-stat[data-f="expired"] .st-ic { background:#f1f5f9; color:#64748b; }
    .iv-stat.active[data-f="all"] .st-ic { background:#fff; color:#6366f1; }
    .iv-stat.active[data-f="unpaid"] .st-ic { background:#fff; color:#d97706; }
    .iv-stat.active[data-f="waiting"] .st-ic { background:#fff; color:#2563eb; }
    .iv-stat.active[data-f="paid"] .st-ic { background:#fff; color:#16a34a; }
    .iv-stat.active[data-f="expired"] .st-ic { background:#fff; color:#64748b; }

    .iv-stat .st-body { flex:1; min-width:0; }
    .iv-stat .st-lbl { font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; font-weight:600; }
    .iv-stat .st-num { font-size:20px; font-weight:800; color:#0f172a; line-height:1.2; margin-top:2px; }
    .iv-stat.active .st-num { color:#4338ca; }

    /* ============ FILTER BAR ============ */
    .iv-filter { display:flex; gap:10px; margin-bottom:16px; flex-wrap:wrap; }
    .iv-search { flex:1; min-width:220px; position:relative; }
    .iv-search input {
        width:100%; padding:11px 16px 11px 42px; border:1.5px solid #e2e8f0;
        border-radius:10px; font-size:14px; background:#fff; font-family:inherit;
    }
    .iv-search input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }
    .iv-search .ic { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; display:flex; align-items:center; }
    .iv-search .clear {
        position:absolute; right:10px; top:50%; transform:translateY(-50%);
        background:#f1f5f9; border:none; width:24px; height:24px; border-radius:50%;
        cursor:pointer; color:#64748b; display:none; align-items:center; justify-content:center;
    }
    .iv-search .clear.show { display:flex; }
    .iv-search .clear:hover { background:#e2e8f0; }

    .iv-filter select {
        padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px;
        font-size:14px; background:#fff; cursor:pointer; font-family:inherit;
        min-width:160px;
    }
    .iv-filter select:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }

    /* ============ LIST ============ */
    .iv-list { display:flex; flex-direction:column; gap:10px; min-height:120px; transition:opacity .2s; }
    .iv-list.loading { opacity:.5; pointer-events:none; }

    .iv-item {
        background:#fff; border-radius:14px; padding:18px 20px;
        border:1px solid #f1f5f9; transition:.15s;
        animation: ivFade .25s ease;
    }
    @keyframes ivFade { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:none; } }
    .iv-item:hover { border-color:#e0e7ff; box-shadow:0 6px 20px rgba(99,102,241,0.06); }

    .iv-row-1 { display:flex; justify-content:space-between; align-items:flex-start; gap:14px; margin-bottom:12px; }
    .iv-left { flex:1; min-width:0; }

    .iv-badge-row { display:flex; align-items:center; gap:8px; margin-bottom:8px; flex-wrap:wrap; }
    .iv-num {
        font-family:'Courier New', monospace; font-size:11px; color:#475569;
        background:#f1f5f9; padding:4px 9px; border-radius:6px;
        font-weight:700; letter-spacing:.3px;
    }
    .iv-pill {
        display:inline-flex; align-items:center; gap:5px;
        padding:4px 10px; border-radius:20px;
        font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.4px;
    }
    .iv-pill.unpaid { background:#fef3c7; color:#92400e; }
    .iv-pill.waiting { background:#dbeafe; color:#1e40af; }
    .iv-pill.paid { background:#dcfce7; color:#166534; }
    .iv-pill.rejected { background:#fee2e2; color:#991b1b; }
    .iv-pill.expired, .iv-pill.cancelled { background:#f1f5f9; color:#64748b; }
    .iv-pill.draft { background:#e2e8f0; color:#475569; }
    .iv-pill .dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

    .iv-nama { font-size:16px; font-weight:700; color:#0f172a; }
    .iv-desc { font-size:13px; color:#64748b; margin-top:4px; line-height:1.5; }

    .iv-amt {
        text-align:right; flex-shrink:0;
    }
    .iv-amt .lbl { font-size:10px; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; font-weight:700; }
    .iv-amt .num { font-size:20px; font-weight:800; color:#0f172a; margin-top:3px; font-variant-numeric:tabular-nums; }

    .iv-meta { display:flex; gap:16px; flex-wrap:wrap; font-size:12px; color:#94a3b8; margin-bottom:14px; }
    .iv-meta .m { display:inline-flex; align-items:center; gap:5px; }

    .iv-btns { display:flex; gap:6px; flex-wrap:wrap; }
    .iv-btn {
        display:inline-flex; align-items:center; gap:6px;
        padding:8px 14px; border-radius:9px; font-size:12.5px; font-weight:600;
        border:1.5px solid #e2e8f0; background:#fff; color:#475569;
        cursor:pointer; text-decoration:none; transition:.15s; font-family:inherit;
        white-space:nowrap;
    }
    .iv-btn:hover { border-color:#cbd5e1; background:#f8fafc; transform:translateY(-1px); }
    .iv-btn.primary { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border-color:transparent; }
    .iv-btn.primary:hover { opacity:.92; box-shadow:0 4px 12px rgba(99,102,241,0.25); }
    .iv-btn.green { color:#16a34a; border-color:#bbf7d0; }
    .iv-btn.green:hover { background:#f0fdf4; border-color:#86efac; }
    .iv-btn.amber { color:#d97706; border-color:#fde68a; }
    .iv-btn.amber:hover { background:#fffbeb; border-color:#fcd34d; }
    .iv-btn.red { color:#dc2626; border-color:#fecaca; }
    .iv-btn.red:hover { background:#fef2f2; border-color:#fca5a5; }
    .iv-btn.blue { color:#2563eb; border-color:#bfdbfe; }
    .iv-btn.blue:hover { background:#eff6ff; border-color:#93c5fd; }
    .iv-btn.icon-only { padding:8px 10px; }

    /* Empty */
    .iv-empty { text-align:center; padding:70px 20px; background:#fff; border-radius:14px; border:1px solid #f1f5f9; }
    .iv-empty .em-ic {
        width:80px; height:80px; border-radius:50%;
        background:linear-gradient(135deg,#eef2ff,#e0e7ff); color:#6366f1;
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 18px;
    }
    .iv-empty h3 { font-size:17px; font-weight:700; color:#0f172a; margin-bottom:6px; }
    .iv-empty p { color:#94a3b8; font-size:13px; margin-bottom:20px; max-width:320px; margin-left:auto; margin-right:auto; line-height:1.5; }

    /* Pagination */
    .iv-pagin { display:flex; justify-content:center; gap:6px; margin-top:20px; flex-wrap:wrap; }
    .iv-pagin button {
        min-width:38px; padding:8px 13px; background:#fff;
        border:1.5px solid #e2e8f0; border-radius:9px;
        font-size:13px; font-weight:600; color:#475569; cursor:pointer;
        font-family:inherit; transition:.15s;
    }
    .iv-pagin button:hover:not(:disabled):not(.cur) { border-color:#6366f1; color:#6366f1; }
    .iv-pagin button.cur { background:#6366f1; color:#fff; border-color:#6366f1; }
    .iv-pagin button:disabled { opacity:.4; cursor:not-allowed; }

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

    /* Responsive */
    @media (max-width:1024px) {
        .iv-stats { grid-template-columns:repeat(3, 1fr); }
    }
    @media (max-width:768px) {
        .iv-stats { grid-template-columns:1fr 1fr; }
        .iv-stat { padding:12px; }
        .iv-stat .st-ic { width:34px; height:34px; }
        .iv-stat .st-num { font-size:17px; }

        .iv-item { padding:16px; }
        .iv-row-1 { flex-direction:column; gap:10px; }
        .iv-amt { text-align:left; }
        .iv-amt .num { font-size:18px; }
        .iv-btns { gap:6px; }
        .iv-btns .lbl { display:none; }
        .iv-btn { padding:8px 11px; }
        .iv-btn.icon-only { padding:8px 9px; }

        .toast-wrap { top:10px; right:10px; left:10px; }
    }
    @media (max-width:480px) {
        .iv-stats { grid-template-columns:1fr; }
    }
</style>

<div class="toast-wrap" id="toastWrap"></div>

<div class="iv-wrap">

    <div class="iv-head">
        <div>
            <h2>Daftar Tagihan</h2>
            <p>Total <strong id="totalRows"><?= number_format($stats_awal['all']) ?></strong> tagihan</p>
        </div>
        <a href="<?= url('invoice-create') ?>" class="btn">
            <?= iv_icon('plus', 16) ?> Buat Tagihan
        </a>
    </div>

    <!-- ============ STAT CARDS ============ -->
    <div class="iv-stats" id="statsTabs">
        <div class="iv-stat active" data-f="all">
            <div class="st-ic"><?= iv_icon('list', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Semua</div>
                <div class="st-num" id="cnt-all"><?= $stats_awal['all'] ?></div>
            </div>
        </div>
        <div class="iv-stat" data-f="unpaid">
            <div class="st-ic"><?= iv_icon('clock', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Belum Bayar</div>
                <div class="st-num" id="cnt-unpaid"><?= $stats_awal['unpaid'] ?></div>
            </div>
        </div>
        <div class="iv-stat" data-f="waiting">
            <div class="st-ic"><?= iv_icon('hourglass', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Menunggu</div>
                <div class="st-num" id="cnt-waiting"><?= $stats_awal['waiting'] ?></div>
            </div>
        </div>
        <div class="iv-stat" data-f="paid">
            <div class="st-ic"><?= iv_icon('checkCircle', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Lunas</div>
                <div class="st-num" id="cnt-paid"><?= $stats_awal['paid'] ?></div>
            </div>
        </div>
        <div class="iv-stat" data-f="expired">
            <div class="st-ic"><?= iv_icon('alert', 18) ?></div>
            <div class="st-body">
                <div class="st-lbl">Expired</div>
                <div class="st-num" id="cnt-expired"><?= $stats_awal['expired'] ?></div>
            </div>
        </div>
    </div>

    <!-- ============ FILTER ============ -->
    <div class="iv-filter">
        <div class="iv-search">
            <span class="ic"><?= iv_icon('search', 18) ?></span>
            <input type="text" id="searchInput" placeholder="Cari nama / no invoice / no WA..." autocomplete="off">
            <button type="button" class="clear" id="clearSearch"><?= iv_icon('x', 12) ?></button>
        </div>
        <select id="filterKategori">
            <option value="0">Semua Kategori</option>
            <?php foreach ($kategoris as $k): ?>
                <option value="<?= $k['id'] ?>"><?= e($k['nama']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- ============ LIST ============ -->
    <div class="iv-list" id="ivList">
        <div style="text-align:center; padding:40px; color:#94a3b8; font-size:13px;">Memuat data...</div>
    </div>

    <!-- ============ PAGINATION ============ -->
    <div class="iv-pagin" id="ivPagin"></div>

</div>

<script>
// ============ ICONS (untuk JS) ============
const IV_ICONS = {
    eye:   '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
    link:  '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>',
    wa:    '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
    check: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
    ban:   '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>',
    trash: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>',
    tag:   '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',
    phone: '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
    clock: '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
    inbox: '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>',
};

let state = { q: '', f: 'all', kat: 0, p: 1, loading: false };
let searchTimer = null;

const API_LIST   = '<?= BASE_URL ?>/?url=api/invoice-list';
const API_ACTION = '<?= BASE_URL ?>/?url=api/invoice-action';
const URL_DETAIL = '<?= url('invoice-detail&id=') ?>';

// ============ TOAST ============
function showToast(msg, type = 'success') {
    const wrap = document.getElementById('toastWrap');
    if (!wrap) return;
    const el = document.createElement('div');
    el.className = 'toast ' + type;
    const iconSvg = type === 'success' ? IV_ICONS.check : IV_ICONS.ban;
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

// ============ WA LABEL BY STATUS ============
function waLabelFor(status) {
    return {
        unpaid:    'Kirim Tagihan',
        waiting:   'Kirim Tagihan',
        paid:      'Kirim Konfirmasi',
        rejected:  'Kirim Penolakan',
        expired:   'Kirim Reminder',
        cancelled: 'Kirim Info',
        draft:     'Kirim Tagihan',
    }[status] || 'Kirim WA';
}

// Warna tombol WA by status
function waBtnClass(status) {
    if (status === 'paid') return 'iv-btn blue';
    if (status === 'rejected') return 'iv-btn red';
    if (status === 'expired') return 'iv-btn amber';
    return 'iv-btn green';
}

// ============ FETCH ============
async function fetchList() {
    if (state.loading) return;
    state.loading = true;
    const list = document.getElementById('ivList');
    if (list) list.classList.add('loading');

    try {
        const url = API_LIST
            + '&q=' + encodeURIComponent(state.q)
            + '&status=' + state.f
            + '&kat=' + state.kat
            + '&p=' + state.p
            + '&t=' + Date.now();
        const res = await fetch(url);
        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Gagal');

        renderList(data.rows);
        updateStats(data.stats);
        renderPagination(data.page, data.total_pages);
        document.getElementById('totalRows').textContent = data.total_rows.toLocaleString('id-ID');
    } catch (e) {
        console.error(e);
        showToast('Gagal memuat data', 'error');
    } finally {
        state.loading = false;
        if (list) list.classList.remove('loading');
    }
}

// ============ RENDER LIST ============
function renderList(rows) {
    const list = document.getElementById('ivList');
    if (!list) return;

    if (!rows.length) {
        const isFiltered = state.q || state.f !== 'all' || state.kat > 0;
        list.innerHTML = `
            <div class="iv-empty">
                <div class="em-ic">${IV_ICONS.inbox}</div>
                <h3>${isFiltered ? 'Tidak ditemukan' : 'Belum ada tagihan'}</h3>
                <p>${isFiltered ? 'Coba ubah filter atau reset pencarian untuk melihat semua tagihan.' : 'Buat tagihan pertama lo sekarang dan mulai terima pembayaran.'}</p>
                ${!isFiltered ? '<a href="<?= url('invoice-create') ?>" class="btn">+ Buat Tagihan</a>' : ''}
            </div>
        `;
        return;
    }

    let html = '';
    rows.forEach(r => {
        const st = r.display_status;
        const canCancel = ['unpaid','waiting','rejected'].includes(r.status);
        const canMarkPaid = r.status === 'unpaid';
        const stLabel = {
            unpaid:'Belum Bayar', waiting:'Menunggu', paid:'Lunas',
            rejected:'Ditolak', expired:'Expired', cancelled:'Dibatalkan', draft:'Draft'
        }[st] || st;

        const waLabel = waLabelFor(r.status);
        const waClass = waBtnClass(r.status);

        html += `
            <div class="iv-item" data-id="${r.id}">
                <div class="iv-row-1">
                    <div class="iv-left">
                        <div class="iv-badge-row">
                            <span class="iv-num">${escHtml(r.invoice_number)}</span>
                            <span class="iv-pill ${st}"><span class="dot"></span>${stLabel}</span>
                        </div>
                        <div class="iv-nama">${escHtml(r.nama_pembayar)}</div>
                        <div class="iv-desc">${escHtml(r.deskripsi_short)}</div>
                    </div>
                    <div class="iv-amt">
                        <div class="lbl">Total</div>
                        <div class="num">${escHtml(r.total_fmt)}</div>
                    </div>
                </div>

                <div class="iv-meta">
                    ${r.kategori ? `<span class="m">${IV_ICONS.tag} ${escHtml(r.kategori)}</span>` : ''}
                    <span class="m">${IV_ICONS.phone} ${escHtml(r.nomor_wa)}</span>
                    <span class="m">${IV_ICONS.clock} ${escHtml(r.expired_fmt)}</span>
                </div>

                <div class="iv-btns">
                    <a href="${URL_DETAIL}${r.id}" class="iv-btn primary">
                        ${IV_ICONS.eye} <span class="lbl">Detail</span>
                    </a>

                    <button type="button" class="iv-btn"
                            onclick='copyLink(${JSON.stringify(r.link_pay)}, this)'>
                        ${IV_ICONS.link} <span class="lbl">Copy Link</span>
                    </button>

                    <a href="${escHtml(r.wa_link)}" target="_blank" class="${waClass}"
                       title="Pakai template: ${escHtml(r.wa_tipe || 'tagihan_baru')}">
                        ${IV_ICONS.wa} <span class="lbl">${escHtml(waLabel)}</span>
                    </a>

                    ${canMarkPaid ? `
                        <button type="button" class="iv-btn green"
                                onclick='markPaid(${r.id}, ${JSON.stringify(r.invoice_number)})'>
                            ${IV_ICONS.check} <span class="lbl">Lunas</span>
                        </button>
                    ` : ''}

                    ${canCancel ? `
                        <button type="button" class="iv-btn amber"
                                onclick='cancelInv(${r.id}, ${JSON.stringify(r.invoice_number)})'>
                            ${IV_ICONS.ban} <span class="lbl">Batal</span>
                        </button>
                    ` : ''}

                    <button type="button" class="iv-btn red icon-only" title="Hapus"
                            onclick='deleteInv(${r.id}, ${JSON.stringify(r.invoice_number)})'>
                        ${IV_ICONS.trash}
                    </button>
                </div>
            </div>
        `;
    });
    list.innerHTML = html;
}

// ============ UPDATE STATS ============
function updateStats(stats) {
    const el = (id) => document.getElementById(id);
    ['all','unpaid','waiting','paid','expired'].forEach(k => {
        if (el('cnt-' + k)) el('cnt-' + k).textContent = stats[k] || 0;
    });
}

// ============ PAGINATION ============
function renderPagination(cur, total) {
    const wrap = document.getElementById('ivPagin');
    if (!wrap) return;
    if (total <= 1) { wrap.innerHTML = ''; return; }

    let h = '';
    h += `<button ${cur === 1 ? 'disabled' : ''} onclick="gotoPage(${cur - 1})">‹ Prev</button>`;

    const start = Math.max(1, cur - 2);
    const end = Math.min(total, cur + 2);
    if (start > 1) h += `<button onclick="gotoPage(1)">1</button>`;
    if (start > 2) h += `<button disabled>...</button>`;
    for (let i = start; i <= end; i++) {
        h += `<button class="${i === cur ? 'cur' : ''}" onclick="gotoPage(${i})">${i}</button>`;
    }
    if (end < total - 1) h += `<button disabled>...</button>`;
    if (end < total) h += `<button onclick="gotoPage(${total})">${total}</button>`;

    h += `<button ${cur === total ? 'disabled' : ''} onclick="gotoPage(${cur + 1})">Next ›</button>`;
    wrap.innerHTML = h;
}

function gotoPage(p) {
    state.p = p;
    fetchList();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ============ COPY ============
function copyLink(text, btn) {
    const orig = btn.innerHTML;
    const done = () => {
        btn.innerHTML = IV_ICONS.check + ' <span class="lbl">Tersalin!</span>';
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

// ============ ACTIONS ============
async function doAction(action, id, confirmMsg, successMsg) {
    if (confirmMsg && !confirm(confirmMsg)) return;
    try {
        const fd = new FormData();
        fd.append('action', action);
        fd.append('id', id);
        const res = await fetch(API_ACTION, { method: 'POST', body: fd });
        const data = await res.json();
        if (!data.success) throw new Error(data.message);
        showToast(data.message || successMsg, 'success');
        fetchList();
    } catch (e) {
        showToast(e.message || 'Gagal', 'error');
    }
}

function cancelInv(id, num) {
    doAction('cancel', id,
        'Batalkan tagihan ' + num + '?\n\nStatus jadi DIBATALKAN & gak bisa dibayar lagi.',
        'Tagihan dibatalkan.');
}
function markPaid(id, num) {
    doAction('mark_paid', id,
        'Tandai ' + num + ' sebagai LUNAS?',
        'Tagihan ditandai lunas.');
}
function deleteInv(id, num) {
    doAction('delete', id,
        'Hapus tagihan ' + num + '?\n\nData akan hilang PERMANEN.',
        'Tagihan dihapus.');
}

// ============ SEARCH ============
const searchInput = document.getElementById('searchInput');
const clearBtn = document.getElementById('clearSearch');

if (searchInput) {
    searchInput.addEventListener('input', function() {
        const val = this.value.trim();
        state.q = val;
        state.p = 1;
        clearBtn.classList.toggle('show', val.length > 0);
        clearTimeout(searchTimer);
        searchTimer = setTimeout(fetchList, 300);
    });

    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        state.q = '';
        state.p = 1;
        clearBtn.classList.remove('show');
        fetchList();
    });
}

// ============ FILTER TABS ============
document.querySelectorAll('#statsTabs .iv-stat').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('#statsTabs .iv-stat').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        state.f = this.dataset.f;
        state.p = 1;
        fetchList();
    });
});

// ============ FILTER KATEGORI ============
document.getElementById('filterKategori').addEventListener('change', function() {
    state.kat = parseInt(this.value) || 0;
    state.p = 1;
    fetchList();
});

// ============ INIT ============
if (document.getElementById('ivList')) {
    fetchList();
}
</script>

<?php render_footer(); ?>