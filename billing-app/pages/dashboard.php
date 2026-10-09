<?php
$title = 'Dashboard';
$active = 'dashboard';

// Ambil data awal (server-side render)
$bulan_ini_start = date('Y-m-01 00:00:00');
$bulan_ini_end   = date('Y-m-t 23:59:59');

$total_ini = (int)$pdo->query("SELECT COUNT(*) FROM invoices WHERE created_at BETWEEN '$bulan_ini_start' AND '$bulan_ini_end'")->fetchColumn();
$paidIni = $pdo->query("SELECT COUNT(*), COALESCE(SUM(total),0) FROM invoices WHERE status='paid' AND created_at BETWEEN '$bulan_ini_start' AND '$bulan_ini_end'")->fetch(PDO::FETCH_NUM);
$revenue_ini = (float)$paidIni[1];
$paid_count_ini = (int)$paidIni[0];
$pending_count = (int)$pdo->query("SELECT COUNT(*) FROM payment_proofs WHERE status='waiting'")->fetchColumn();

$admin = $GLOBALS['admin'];
$jam = (int)date('H');
if ($jam < 11) $greet = 'Selamat pagi';
elseif ($jam < 15) $greet = 'Selamat siang';
elseif ($jam < 19) $greet = 'Selamat sore';
else $greet = 'Selamat malam';

render_header($title, $active);
?>

<style>
/* ============ DASHBOARD STYLES ============ */
.db-wrap { max-width: 1400px; }

/* Greeting */
.db-greet { display:flex; justify-content:space-between; align-items:flex-start; gap:14px; margin-bottom:20px; flex-wrap:wrap; }
.db-greet h2 { font-size:22px; font-weight:800; color:#0f172a; margin-bottom:4px; }
.db-greet .sub { font-size:13px; color:#64748b; }
.db-greet .clock { text-align:right; }
.db-greet .clock .t { font-size:26px; font-weight:800; color:#6366f1; font-variant-numeric:tabular-nums; }
.db-greet .clock .d { font-size:12px; color:#94a3b8; margin-top:2px; }

/* Alert bar */
.db-alert { display:flex; align-items:center; gap:12px; padding:14px 18px; border-radius:12px; margin-bottom:16px; background:linear-gradient(135deg,#fef3c7,#fde68a); border-left:4px solid #f59e0b; font-size:14px; color:#78350f; }
.db-alert.danger { background:linear-gradient(135deg,#fee2e2,#fecaca); border-left-color:#ef4444; color:#7f1d1d; }
.db-alert .ic { font-size:20px; }
.db-alert .txt { flex:1; font-weight:500; }
.db-alert .txt strong { font-weight:700; }
.db-alert a { color:inherit; font-weight:700; text-decoration:underline; padding:6px 12px; background:rgba(255,255,255,0.4); border-radius:8px; text-decoration:none; font-size:13px; }
.db-alert a:hover { background:rgba(255,255,255,0.7); }

/* Quick actions */
.db-quick { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:10px; margin-bottom:20px; }
.db-qa {
    display:flex; align-items:center; gap:12px; padding:14px 16px;
    background:#fff; border-radius:12px; text-decoration:none;
    border:1.5px solid #f1f5f9; transition:.15s; position:relative; overflow:hidden;
}
.db-qa:hover { border-color:#c7d2fe; transform:translateY(-2px); box-shadow:0 6px 18px rgba(99,102,241,0.1); }
.db-qa .ic { width:40px; height:40px; border-radius:10px; background:linear-gradient(135deg,#eef2ff,#e0e7ff); color:#6366f1; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.db-qa .lbl { font-size:13px; font-weight:600; color:#1e293b; }
.db-qa .sub { font-size:11px; color:#94a3b8; margin-top:2px; }
.db-qa .bubble { position:absolute; top:8px; right:8px; background:#ef4444; color:#fff; font-size:10px; font-weight:700; padding:2px 7px; border-radius:10px; }

/* KPI Grid */
.db-kpi { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px; margin-bottom:20px; }
.db-kcard {
    background:#fff; border-radius:14px; padding:18px 20px;
    box-shadow:0 1px 3px rgba(0,0,0,0.04); border:1px solid #f1f5f9;
    position:relative; overflow:hidden;
}
.db-kcard::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#6366f1,#8b5cf6); opacity:0; transition:.3s; }
.db-kcard:hover::before { opacity:1; }
.db-kcard .kc-hd { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
.db-kcard .kc-ic { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; }
.db-kcard .kc-ic.i-indigo { background:#eef2ff; color:#6366f1; }
.db-kcard .kc-ic.i-green { background:#dcfce7; color:#10b981; }
.db-kcard .kc-ic.i-amber { background:#fef3c7; color:#f59e0b; }
.db-kcard .kc-ic.i-blue { background:#dbeafe; color:#3b82f6; }
.db-kcard .kc-trend { font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px; }
.db-kcard .kc-trend.up { background:#dcfce7; color:#166534; }
.db-kcard .kc-trend.down { background:#fee2e2; color:#991b1b; }
.db-kcard .kc-trend.neutral { background:#f1f5f9; color:#64748b; }
.db-kcard .kc-lbl { font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; font-weight:600; }
.db-kcard .kc-val { font-size:24px; font-weight:800; color:#0f172a; margin-top:4px; line-height:1.2; }
.db-kcard .kc-sub { font-size:12px; color:#64748b; margin-top:4px; }
.db-kcard .kc-spark { margin-top:8px; height:26px; }

/* Grid layout */
.db-row { display:grid; grid-template-columns:1.6fr 1fr; gap:16px; margin-bottom:16px; }
.db-row2 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:16px; }

.db-card { background:#fff; border-radius:14px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.04); border:1px solid #f1f5f9; }
.db-card-hd { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
.db-card-hd h3 { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.db-card-hd .more { font-size:12px; color:#6366f1; text-decoration:none; font-weight:600; }
.db-card-hd .more:hover { text-decoration:underline; }

/* Bar chart */
.chart-bar-wrap { position:relative; height:220px; }
.chart-bar-wrap canvas { width:100%; height:100%; }

/* Donut */
.donut-wrap { display:flex; align-items:center; gap:20px; flex-wrap:wrap; }
.donut-svg { position:relative; width:140px; height:140px; flex-shrink:0; }
.donut-svg svg { transform:rotate(-90deg); }
.donut-center { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.donut-center .n { font-size:22px; font-weight:800; color:#0f172a; line-height:1; }
.donut-center .l { font-size:10px; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-top:2px; }
.donut-legend { flex:1; display:flex; flex-direction:column; gap:8px; min-width:140px; }
.donut-leg { display:flex; align-items:center; gap:8px; font-size:12px; }
.donut-leg .dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }
.donut-leg .lbl { flex:1; color:#64748b; }
.donut-leg .val { font-weight:700; color:#1e293b; }

/* Recent list */
.db-list { display:flex; flex-direction:column; gap:0; }
.db-list-item { display:flex; align-items:center; gap:12px; padding:11px 0; border-bottom:1px solid #f1f5f9; text-decoration:none; }
.db-list-item:last-child { border-bottom:none; }
.db-list-item:hover { background:#fafbff; margin:0 -10px; padding-left:10px; padding-right:10px; border-radius:8px; }
.db-list-item .num { font-family:'Courier New', monospace; font-size:11px; color:#94a3b8; }
.db-list-item .nm { font-size:13px; font-weight:600; color:#1e293b; margin-top:2px; }
.db-list-item .amt { font-size:13px; font-weight:700; color:#1e293b; text-align:right; }
.db-list-item .st { font-size:10px; font-weight:700; text-transform:uppercase; padding:2px 6px; border-radius:5px; margin-top:2px; display:inline-block; }
.db-list-empty { text-align:center; padding:30px 10px; color:#cbd5e1; font-size:13px; }

/* Alert mini list */
.db-mini-list { display:flex; flex-direction:column; gap:8px; }
.db-mini-item { display:flex; align-items:center; gap:10px; padding:10px 12px; background:#f8fafc; border-radius:10px; border-left:3px solid #f59e0b; }
.db-mini-item.danger { border-left-color:#ef4444; background:#fef2f2; }
.db-mini-item.info { border-left-color:#3b82f6; background:#eff6ff; }
.db-mini-item .body { flex:1; min-width:0; }
.db-mini-item .t1 { font-size:12px; font-weight:600; color:#1e293b; }
.db-mini-item .t2 { font-size:11px; color:#94a3b8; margin-top:1px; }
.db-mini-item .btn-mini { padding:5px 10px; background:#6366f1; color:#fff; border:none; border-radius:6px; font-size:11px; font-weight:600; text-decoration:none; cursor:pointer; }

/* Top kategori */
.kat-list { display:flex; flex-direction:column; gap:10px; }
.kat-item { display:flex; align-items:center; gap:10px; }
.kat-item .bar { flex:1; height:8px; background:#f1f5f9; border-radius:4px; overflow:hidden; }
.kat-item .bar span { display:block; height:100%; background:linear-gradient(90deg,#6366f1,#8b5cf6); border-radius:4px; transition:width .8s ease; }
.kat-item .nm { font-size:12px; color:#475569; font-weight:500; min-width:80px; }
.kat-item .cnt { font-size:12px; font-weight:700; color:#1e293b; min-width:36px; text-align:right; }

/* Progress target */
.progress-wrap { padding:4px 0; }
.progress-info { display:flex; justify-content:space-between; margin-bottom:10px; font-size:13px; }
.progress-info .lbl { color:#64748b; }
.progress-info .val { font-weight:700; color:#1e293b; }
.progress-bar { height:12px; background:#f1f5f9; border-radius:6px; overflow:hidden; position:relative; }
.progress-bar span { display:block; height:100%; background:linear-gradient(90deg,#6366f1,#8b5cf6); border-radius:6px; transition:width 1s ease; }
.progress-bar .pct { position:absolute; right:8px; top:50%; transform:translateY(-50%); font-size:9px; font-weight:700; color:#fff; }

/* Activity feed */
.activity-list { display:flex; flex-direction:column; gap:2px; max-height:340px; overflow-y:auto; }
.act-item { display:flex; gap:10px; padding:10px 0; border-bottom:1px solid #f8fafc; }
.act-item:last-child { border-bottom:none; }
.act-dot { width:8px; height:8px; border-radius:50%; background:#6366f1; flex-shrink:0; margin-top:6px; }
.act-dot.green { background:#10b981; }
.act-dot.red { background:#ef4444; }
.act-dot.amber { background:#f59e0b; }
.act-body { flex:1; min-width:0; }
.act-body .t1 { font-size:12px; color:#1e293b; font-weight:500; }
.act-body .t2 { font-size:11px; color:#94a3b8; margin-top:2px; }

/* Loading */
.db-loading { position:fixed; top:14px; right:14px; background:#0f172a; color:#fff; padding:8px 14px; border-radius:20px; font-size:12px; z-index:999; display:none; align-items:center; gap:8px; box-shadow:0 6px 20px rgba(0,0,0,0.2); }
.db-loading.show { display:flex; }
.db-loading .spin { width:12px; height:12px; border:2px solid rgba(255,255,255,0.3); border-top-color:#fff; border-radius:50%; animation:spin .7s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }
.refresh-dot { width:6px; height:6px; border-radius:50%; background:#10b981; animation:pulse 2s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

/* Responsive */
@media (max-width:1024px) {
    .db-row { grid-template-columns:1fr; }
    .db-row2 { grid-template-columns:1fr 1fr; }
}
@media (max-width:640px) {
    .db-row2 { grid-template-columns:1fr; }
    .db-greet h2 { font-size:18px; }
    .db-greet .clock .t { font-size:20px; }
    .db-kcard .kc-val { font-size:20px; }
    .db-quick { grid-template-columns:1fr 1fr; }
    .donut-wrap { flex-direction:column; }
}
</style>

<div class="db-wrap">

    <!-- Loading indicator -->
    <div class="db-loading" id="loading"><div class="spin"></div> Memperbarui...</div>

    <!-- Greeting -->
    <div class="db-greet">
        <div>
            <h2><?= $greet ?>, <?= e($admin['nama']) ?> 👋</h2>
            <div class="sub">
                Berikut ringkasan <strong><?= setting('nama_bisnis', APP_NAME) ?></strong> — <?= date('l, d F Y') ?>
                <span class="refresh-dot" style="display:inline-block; margin-left:6px;" title="Live update aktif"></span>
            </div>
        </div>
        <div class="clock">
            <div class="t" id="liveClock">--:--:--</div>
            <div class="d">Waktu Server</div>
        </div>
    </div>

    <!-- Alert bar -->
    <div id="alertWrap"></div>

    <!-- Quick actions -->
    <div class="db-quick">
        <a href="<?= url('invoice-create') ?>" class="db-qa">
            <div class="ic"><?= svg_icon('plus', 20) ?></div>
            <div><div class="lbl">Buat Tagihan</div><div class="sub">Tagihan baru</div></div>
        </a>
        <a href="<?= url('konfirmasi') ?>" class="db-qa">
            <div class="ic" style="background:#dcfce7; color:#10b981;"><?= svg_icon('check', 20) ?></div>
            <div><div class="lbl">Konfirmasi</div><div class="sub">Review bukti</div></div>
            <?php if ($pending_count > 0): ?><span class="bubble"><?= $pending_count ?></span><?php endif; ?>
        </a>
        <a href="<?= url('laporan') ?>" class="db-qa">
            <div class="ic" style="background:#dbeafe; color:#3b82f6;"><?= svg_icon('chart', 20) ?></div>
            <div><div class="lbl">Laporan</div><div class="sub">Lihat & export</div></div>
        </a>
        <a href="<?= url('invoice') ?>" class="db-qa">
            <div class="ic" style="background:#fef3c7; color:#f59e0b;"><?= svg_icon('file', 20) ?></div>
            <div><div class="lbl">Tagihan</div><div class="sub">Semua tagihan</div></div>
        </a>
    </div>

    <!-- KPI Cards -->
    <div class="db-kpi">
        <div class="db-kcard">
            <div class="kc-hd">
                <div class="kc-ic i-indigo"><?= svg_icon('file', 20) ?></div>
                <div class="kc-trend neutral" id="trendTotal">Bulan ini</div>
            </div>
            <div class="kc-lbl">Total Tagihan</div>
            <div class="kc-val" data-counter="<?= $total_ini ?>">0</div>
            <div class="kc-sub">Bulan <?= date('F Y') ?></div>
        </div>

        <div class="db-kcard">
            <div class="kc-hd">
                <div class="kc-ic i-green"><?= svg_icon('check', 20) ?></div>
                <div class="kc-trend up" id="trendPaid">—</div>
            </div>
            <div class="kc-lbl">Lunas Bulan Ini</div>
            <div class="kc-val" data-counter="<?= $paid_count_ini ?>">0</div>
            <div class="kc-sub" id="subPaid">—</div>
        </div>

        <div class="db-kcard">
            <div class="kc-hd">
                <div class="kc-ic i-amber"><?= svg_icon('clock', 20) ?></div>
                <div class="kc-trend neutral">Perlu aksi</div>
            </div>
            <div class="kc-lbl">Pending Konfirmasi</div>
            <div class="kc-val" data-counter="<?= $pending_count ?>">0</div>
            <div class="kc-sub" id="subPending">Bukti menunggu review</div>
        </div>

        <div class="db-kcard">
            <div class="kc-hd">
                <div class="kc-ic i-blue"><?= svg_icon('chart', 20) ?></div>
                <div class="kc-trend up" id="trendRevenue">—</div>
            </div>
            <div class="kc-lbl">Revenue Bulan Ini</div>
            <div class="kc-val" data-counter="<?= (int)$revenue_ini ?>" data-prefix="Rp ">Rp 0</div>
            <div class="kc-sub" id="subRevenue">vs bulan lalu</div>
        </div>
    </div>

    <!-- Chart row -->
    <div class="db-row">

        <!-- Bar chart -->
        <div class="db-card">
            <div class="db-card-hd">
                <h3><?= svg_icon('chart', 16) ?> Transaksi 7 Hari Terakhir</h3>
                <span style="font-size:11px; color:#94a3b8;">Total nilai (Rp)</span>
            </div>
            <div class="chart-bar-wrap">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Donut -->
        <div class="db-card">
            <div class="db-card-hd">
                <h3><?= svg_icon('dashboard', 16) ?> Status Tagihan</h3>
            </div>
            <div class="donut-wrap">
                <div class="donut-svg">
                    <svg width="140" height="140" viewBox="0 0 140 140">
                        <circle cx="70" cy="70" r="55" fill="none" stroke="#f1f5f9" stroke-width="20"/>
                        <circle id="donutUnpaid" cx="70" cy="70" r="55" fill="none" stroke="#f59e0b" stroke-width="20" stroke-dasharray="0 1000"/>
                        <circle id="donutWaiting" cx="70" cy="70" r="55" fill="none" stroke="#3b82f6" stroke-width="20" stroke-dasharray="0 1000"/>
                        <circle id="donutPaid" cx="70" cy="70" r="55" fill="none" stroke="#10b981" stroke-width="20" stroke-dasharray="0 1000"/>
                        <circle id="donutRejected" cx="70" cy="70" r="55" fill="none" stroke="#ef4444" stroke-width="20" stroke-dasharray="0 1000"/>
                    </svg>
                    <div class="donut-center">
                        <div class="n" id="donutTotal">0</div>
                        <div class="l">Total</div>
                    </div>
                </div>
                <div class="donut-legend" id="donutLegend"></div>
            </div>
        </div>
    </div>

    <!-- Row 2: Pending + Exp Soon + Target -->
    <div class="db-row2">

        <div class="db-card">
            <div class="db-card-hd">
                <h3><?= svg_icon('check', 16) ?> Perlu Dikonfirmasi</h3>
                <a href="<?= url('konfirmasi') ?>" class="more">Semua →</a>
            </div>
            <div class="db-mini-list" id="pendingList">
                <div class="db-list-empty">Memuat...</div>
            </div>
        </div>

        <div class="db-card">
            <div class="db-card-hd">
                <h3><?= svg_icon('clock', 16) ?> Hampir Expired</h3>
                <a href="<?= url('invoice&status=unpaid') ?>" class="more">Semua →</a>
            </div>
            <div class="db-mini-list" id="expList">
                <div class="db-list-empty">Memuat...</div>
            </div>
        </div>

        <div class="db-card">
            <div class="db-card-hd">
                <h3><?= svg_icon('chart', 16) ?> Target Bulanan</h3>
            </div>
            <div class="progress-wrap" id="progressWrap">
                <div class="progress-info">
                    <span class="lbl">Tercapai</span>
                    <span class="val" id="progVal">Rp 0 / Rp 0</span>
                </div>
                <div class="progress-bar">
                    <span id="progBar" style="width:0%"></span>
                </div>
                <div style="font-size:11px; color:#94a3b8; margin-top:10px; text-align:center;" id="progNote">
                    Set target di <a href="<?= url('setting') ?>" style="color:#6366f1;">Setting</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Recent + Top Kategori -->
    <div class="db-row">
        <div class="db-card">
            <div class="db-card-hd">
                <h3><?= svg_icon('file', 16) ?> Tagihan Terbaru</h3>
                <a href="<?= url('invoice') ?>" class="more">Semua →</a>
            </div>
            <div class="db-list" id="recentList">
                <div class="db-list-empty">Memuat...</div>
            </div>
        </div>

        <div class="db-card">
            <div class="db-card-hd">
                <h3><?= svg_icon('tag', 16) ?> Top Kategori</h3>
            </div>
            <div class="kat-list" id="katList">
                <div class="db-list-empty">Memuat...</div>
            </div>
        </div>
    </div>

    <!-- Row 4: Activity Feed -->
    <div class="db-card">
        <div class="db-card-hd">
            <h3><?= svg_icon('message', 16) ?> Aktivitas Terbaru</h3>
            <span style="font-size:11px; color:#10b981; font-weight:600;"><span class="refresh-dot"></span> Live</span>
        </div>
        <div class="activity-list" id="activityList">
            <div class="db-list-empty">Memuat...</div>
        </div>
    </div>

</div>

<script>
// ============ LIVE CLOCK ============
function tickClock() {
    const d = new Date();
    const hh = String(d.getHours()).padStart(2,'0');
    const mm = String(d.getMinutes()).padStart(2,'0');
    const ss = String(d.getSeconds()).padStart(2,'0');
    document.getElementById('liveClock').textContent = hh + ':' + mm + ':' + ss;
}
setInterval(tickClock, 1000);
tickClock();

// ============ ANIMATED COUNTER ============
function animateCounter(el, target, duration) {
    if (duration === undefined) duration = 1200;
    const prefix = el.dataset.prefix || '';
    const startTime = performance.now();
    function step(now) {
        const t = Math.min((now - startTime) / duration, 1);
        const eased = 1 - Math.pow(1 - t, 3);
        const val = Math.floor(target * eased);
        el.textContent = prefix + val.toLocaleString('id-ID');
        if (t < 1) requestAnimationFrame(step);
        else el.textContent = prefix + target.toLocaleString('id-ID');
    }
    requestAnimationFrame(step);
}

document.querySelectorAll('[data-counter]').forEach(el => {
    const target = parseFloat(el.dataset.counter) || 0;
    animateCounter(el, target);
});

// ============ BAR CHART (Canvas) ============
function drawBarChart(canvas, labels, values) {
    const dpr = window.devicePixelRatio || 1;
    const rect = canvas.getBoundingClientRect();
    canvas.width = rect.width * dpr;
    canvas.height = rect.height * dpr;
    const ctx = canvas.getContext('2d');
    ctx.scale(dpr, dpr);

    const W = rect.width, H = rect.height;
    const padL = 8, padR = 8, padT = 24, padB = 32;
    const cW = W - padL - padR;
    const cH = H - padT - padB;

    ctx.clearRect(0, 0, W, H);

    if (!values.length) return;

    const maxVal = Math.max(...values, 1);
    const barW = cW / values.length * 0.55;
    const gap = cW / values.length;

    // Grid lines
    ctx.strokeStyle = '#f1f5f9';
    ctx.lineWidth = 1;
    for (let i = 0; i <= 4; i++) {
        const y = padT + (cH / 4) * i;
        ctx.beginPath();
        ctx.moveTo(padL, y);
        ctx.lineTo(W - padR, y);
        ctx.stroke();
    }

    // Bars with animation
    let progress = 0;
    function draw() {
        ctx.clearRect(0, 0, W, H);

        // Grid
        ctx.strokeStyle = '#f1f5f9';
        for (let i = 0; i <= 4; i++) {
            const y = padT + (cH / 4) * i;
            ctx.beginPath();
            ctx.moveTo(padL, y);
            ctx.lineTo(W - padR, y);
            ctx.stroke();
        }

        values.forEach((v, i) => {
            const x = padL + gap * i + (gap - barW) / 2;
            const barH = (v / maxVal) * cH * progress;
            const y = padT + cH - barH;

            // Gradient bar
            const grad = ctx.createLinearGradient(0, y, 0, padT + cH);
            grad.addColorStop(0, '#8b5cf6');
            grad.addColorStop(1, '#6366f1');

            // Rounded top
            const radius = Math.min(6, barW / 2);
            ctx.beginPath();
            ctx.moveTo(x, padT + cH);
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.lineTo(x + barW - radius, y);
            ctx.quadraticCurveTo(x + barW, y, x + barW, y + radius);
            ctx.lineTo(x + barW, padT + cH);
            ctx.closePath();
            ctx.fillStyle = grad;
            ctx.fill();

            // Value di atas bar
            if (progress > 0.7) {
                ctx.fillStyle = '#475569';
                ctx.font = '600 10px -apple-system, sans-serif';
                ctx.textAlign = 'center';
                const valLabel = v >= 1000000 ? (v/1000000).toFixed(1) + 'jt' : (v >= 1000 ? (v/1000).toFixed(0) + 'rb' : v);
                ctx.fillText(valLabel, x + barW / 2, y - 6);
            }

            // Label bawah
            ctx.fillStyle = '#94a3b8';
            ctx.font = '500 10px -apple-system, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(labels[i], x + barW / 2, H - 12);
        });

        if (progress < 1) {
            progress += 0.05;
            requestAnimationFrame(draw);
        }
    }
    draw();
}

// ============ DONUT ============
function drawDonut(breakdown) {
    const total = Object.values(breakdown).reduce((a, b) => a + b, 0);
    document.getElementById('donutTotal').textContent = total;

    const colors = { unpaid:'#f59e0b', waiting:'#3b82f6', paid:'#10b981', rejected:'#ef4444', expired:'#64748b', cancelled:'#94a3b8', draft:'#cbd5e1' };
    const labels = { unpaid:'Belum Bayar', waiting:'Menunggu', paid:'Lunas', rejected:'Ditolak', expired:'Expired', cancelled:'Batal', draft:'Draft' };

    const circumference = 2 * Math.PI * 55; // r=55
    let offset = 0;

    const keys = ['unpaid','waiting','paid','rejected'];
    const ids = { unpaid:'donutUnpaid', waiting:'donutWaiting', paid:'donutPaid', rejected:'donutRejected' };

    keys.forEach(k => {
        const el = document.getElementById(ids[k]);
        const val = breakdown[k] || 0;
        const pct = total > 0 ? val / total : 0;
        const len = pct * circumference;
        el.setAttribute('stroke-dasharray', `${len} ${circumference - len}`);
        el.setAttribute('stroke-dashoffset', -offset);
        offset += len;
    });

    // Legend
    let legendHtml = '';
    keys.forEach(k => {
        const val = breakdown[k] || 0;
        if (val === 0) return;
        const pct = total > 0 ? ((val / total) * 100).toFixed(0) : 0;
        legendHtml += `<div class="donut-leg">
            <div class="dot" style="background:${colors[k]}"></div>
            <div class="lbl">${labels[k]}</div>
            <div class="val">${val} <span style="color:#94a3b8; font-weight:500;">(${pct}%)</span></div>
        </div>`;
    });
    document.getElementById('donutLegend').innerHTML = legendHtml || '<div style="color:#94a3b8; font-size:12px;">Belum ada data</div>';
}

// ============ FORMAT HELPERS ============
function fmtRp(n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }
function fmtRpShort(n) {
    n = Math.round(n);
    if (n >= 1000000000) return 'Rp ' + (n/1000000000).toFixed(1) + 'M';
    if (n >= 1000000) return 'Rp ' + (n/1000000).toFixed(1) + 'jt';
    if (n >= 1000) return 'Rp ' + (n/1000).toFixed(0) + 'rb';
    return 'Rp ' + n.toLocaleString('id-ID');
}
function timeAgo(dateStr) {
    const d = new Date(dateStr);
    const s = Math.floor((Date.now() - d.getTime()) / 1000);
    if (s < 60) return 'baru saja';
    if (s < 3600) return Math.floor(s/60) + ' menit lalu';
    if (s < 86400) return Math.floor(s/3600) + ' jam lalu';
    if (s < 604800) return Math.floor(s/86400) + ' hari lalu';
    return d.toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
}

// ============ AUTO-REFRESH ============
const statusColors = { unpaid:'#f59e0b', waiting:'#3b82f6', paid:'#10b981', rejected:'#ef4444', expired:'#64748b', cancelled:'#94a3b8', draft:'#94a3b8' };

function renderPending(list) {
    if (!list.length) {
        document.getElementById('pendingList').innerHTML = '<div class="db-list-empty">✅ Tidak ada yang perlu dikonfirmasi</div>';
        return;
    }
    let h = '';
    list.forEach(p => {
        h += `<div class="db-mini-item info">
            <div class="body">
                <div class="t1">${escHtml(p.nama_pembayar)}</div>
                <div class="t2">${escHtml(p.invoice_number)} • ${fmtRp(p.total)} • ${timeAgo(p.uploaded_at)}</div>
            </div>
            <a href="<?= url('invoice-detail&id=') ?>${p.inv_id}" class="btn-mini">Review</a>
        </div>`;
    });
    document.getElementById('pendingList').innerHTML = h;
}

function renderExpSoon(list) {
    if (!list.length) {
        document.getElementById('expList').innerHTML = '<div class="db-list-empty">✅ Tidak ada yang hampir expired</div>';
        return;
    }
    let h = '';
    list.forEach(e => {
        const d = new Date(e.expired_at);
        const diff = Math.floor((d.getTime() - Date.now()) / 1000 / 3600);
        const isDanger = diff < 24;
        let timeLeft = diff < 1 ? '<1 jam' : diff < 24 ? diff + ' jam' : Math.floor(diff/24) + ' hari';
        h += `<div class="db-mini-item ${isDanger?'danger':''}">
            <div class="body">
                <div class="t1">${escHtml(e.nama_pembayar)}</div>
                <div class="t2">${escHtml(e.invoice_number)} • ${fmtRp(e.total)} • ${timeLeft} lagi</div>
            </div>
            <a href="<?= url('invoice-detail&id=') ?>${e.id}" class="btn-mini">Lihat</a>
        </div>`;
    });
    document.getElementById('expList').innerHTML = h;
}

function renderRecent(list) {
    if (!list.length) {
        document.getElementById('recentList').innerHTML = '<div class="db-list-empty">Belum ada tagihan</div>';
        return;
    }
    let h = '';
    list.forEach(r => {
        const c = statusColors[r.status] || '#94a3b8';
        h += `<a href="<?= url('invoice-detail&id=') ?>${r.id}" class="db-list-item">
            <div style="flex:1; min-width:0;">
                <div class="num">${escHtml(r.invoice_number)}</div>
                <div class="nm">${escHtml(r.nama_pembayar)}</div>
            </div>
            <div style="text-align:right;">
                <div class="amt">${fmtRp(r.total)}</div>
                <span class="st" style="background:${c}22; color:${c};">${r.status}</span>
            </div>
        </a>`;
    });
    document.getElementById('recentList').innerHTML = h;
}

function renderTopKat(list) {
    if (!list.length) {
        document.getElementById('katList').innerHTML = '<div class="db-list-empty">Belum ada data</div>';
        return;
    }
    const max = Math.max(...list.map(k => +k.jml), 1);
    let h = '';
    list.forEach(k => {
        const pct = (+k.jml / max) * 100;
        h += `<div class="kat-item">
            <div class="nm">${escHtml(k.nama)}</div>
            <div class="bar"><span style="width:${pct}%"></span></div>
            <div class="cnt">${k.jml}</div>
        </div>`;
    });
    document.getElementById('katList').innerHTML = h;
}

function renderActivities(list) {
    if (!list.length) {
        document.getElementById('activityList').innerHTML = '<div class="db-list-empty">Belum ada aktivitas</div>';
        return;
    }
    const colorMap = { approved:'green', rejected:'red', bukti_upload:'amber', link_dibuka:'', created:'green' };
    let h = '';
    list.forEach(a => {
        const cls = colorMap[a.aktivitas] || '';
        const actName = { link_dibuka:'🔗 Link dibuka', bukti_upload:'📤 Bukti diupload', approved:'✅ Disetujui', rejected:'❌ Ditolak', created:'📝 Tagihan dibuat' }[a.aktivitas] || a.aktivitas;
        h += `<div class="act-item">
            <div class="act-dot ${cls}"></div>
            <div class="act-body">
                <div class="t1">${actName}${a.invoice_number ? ' <span style="color:#94a3b8; font-family:monospace; font-size:11px;">' + escHtml(a.invoice_number) + '</span>' : ''}</div>
                <div class="t2">${timeAgo(a.created_at)}${a.detail ? ' • ' + escHtml(a.detail) : ''}</div>
            </div>
        </div>`;
    });
    document.getElementById('activityList').innerHTML = h;
}

function renderAlerts(kpi, expList) {
    let h = '';
    if (kpi.pending_count > 0) {
        h += `<div class="db-alert">
            <div class="ic">🔔</div>
            <div class="txt">Ada <strong>${kpi.pending_count} bukti bayar</strong> menunggu konfirmasi lo.</div>
            <a href="<?= url('konfirmasi') ?>">Review Sekarang</a>
        </div>`;
    }
    if (expList.length > 0) {
        h += `<div class="db-alert danger">
            <div class="ic">⏰</div>
            <div class="txt"><strong>${expList.length} tagihan</strong> akan expired dalam 3 hari ke depan.</div>
            <a href="<?= url('invoice&status=unpaid') ?>">Lihat</a>
        </div>`;
    }
    document.getElementById('alertWrap').innerHTML = h;
}

function escHtml(s) {
    if (s === null || s === undefined) return '';
    return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

function updateTrends(kpi) {
    // Trend Paid
    const tp = document.getElementById('trendPaid');
    const t = kpi.trend_paid;
    tp.className = 'kc-trend ' + (t > 0 ? 'up' : t < 0 ? 'down' : 'neutral');
    tp.textContent = (t > 0 ? '↑ ' : t < 0 ? '↓ ' : '') + Math.abs(t) + '%';

    document.getElementById('subPaid').textContent = 'vs bulan lalu';

    // Trend Revenue
    const tr = document.getElementById('trendRevenue');
    const rt = kpi.trend_revenue;
    tr.className = 'kc-trend ' + (rt > 0 ? 'up' : rt < 0 ? 'down' : 'neutral');
    tr.textContent = (rt > 0 ? '↑ ' : rt < 0 ? '↓ ' : '') + Math.abs(rt) + '%';

    document.getElementById('subRevenue').textContent = 'vs ' + fmtRpShort(kpi.revenue_lalu);
}

function updateProgress(target) {
    const { target: t, progress, revenue } = target;
    if (t > 0) {
        document.getElementById('progVal').textContent = fmtRp(revenue) + ' / ' + fmtRp(t);
        document.getElementById('progBar').style.width = Math.min(100, progress) + '%';
        document.getElementById('progNote').innerHTML = progress >= 100 ? '🎉 Target tercapai!' : progress.toFixed(0) + '% dari target bulan ini';
    } else {
        document.getElementById('progVal').textContent = fmtRp(revenue);
        document.getElementById('progNote').innerHTML = 'Set target di <a href="<?= url('setting') ?>" style="color:#6366f1;">Setting</a>';
    }
}

// ============ MAIN REFRESH ============
let lastUpdate = null;

async function refreshStats() {
    const loading = document.getElementById('loading');
    loading.classList.add('show');
    try {
        const res = await fetch('<?= BASE_URL ?>/?url=api/dashboard-stats&t=' + Date.now());
        const data = await res.json();
        if (!data.success) throw new Error('API error');

        // KPI counters
        document.querySelector('[data-counter]').dataset.counter = data.kpi.total_ini;
        // re-animate
        const kpiVals = document.querySelectorAll('[data-counter]');
        kpiVals[0].dataset.counter = data.kpi.total_ini;
        kpiVals[1].dataset.counter = data.kpi.paid_count_ini;
        kpiVals[2].dataset.counter = data.kpi.pending_count;
        kpiVals[3].dataset.counter = Math.round(data.kpi.revenue_ini);
        kpiVals.forEach(el => animateCounter(el, parseFloat(el.dataset.counter), 800));

        // Update list & charts
        renderAlerts(data.kpi, data.exp_soon);
        drawBarChart(document.getElementById('barChart'), data.hari7.labels, data.hari7.data.map(x => x.sum));
        drawDonut(data.status_break);
        renderPending(data.pending_list);
        renderExpSoon(data.exp_soon);
        renderRecent(data.recent);
        renderTopKat(data.top_kat);
        renderActivities(data.activities);
        updateTrends(data.kpi);
        updateProgress(data.target);

        lastUpdate = new Date();
    } catch (e) {
        console.error('Refresh error:', e);
    } finally {
        loading.classList.remove('show');
    }
}

// ============ INITIAL LOAD ============
document.addEventListener('DOMContentLoaded', () => {
    refreshStats();
    // Auto-refresh tiap 30 detik
    setInterval(refreshStats, 30000);
});

// Redraw bar chart saat resize
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => refreshStats(), 400);
});
</script>

<?php render_footer(); ?>