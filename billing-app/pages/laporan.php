<?php
$title = 'Laporan';
$active = 'laporan';

// ============ ICON SVG ============
function lp_icon($name, $size = 20) {
    $icons = [
        'chart'      => '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>',
        'calendar'   => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'filter'     => '<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>',
        'download'   => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>',
        'file'       => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
        'dollar'     => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
        'trend'      => '<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>',
        'tag'        => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
        'inbox'      => '<polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>',
        'eye'        => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'percent'    => '<line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
        'hash'       => '<line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/>',
        'card'       => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        'x'          => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'refresh'    => '<polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; display:inline-block; vertical-align:middle;">'.$path.'</svg>';
}

// Default filter
$dari   = $_GET['dari']   ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');
$status = $_GET['status'] ?? 'paid';
$kat    = (int)($_GET['kat'] ?? 0);

$kategoris = $pdo->query("SELECT id, nama FROM categories ORDER BY nama")->fetchAll();

// Export CSV (kalau ada ?export=csv)
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
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

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="laporan_' . $dari . '_sd_' . $sampai . '.csv"');
    $out = fopen('php://output', 'w');
    fputs($out, "\xEF\xBB\xBF");
    fputcsv($out, ['No Invoice','Tanggal','Pembayar','No WA','Kategori','Deskripsi','Subtotal','Diskon','Biaya','Pajak','Kode Unik','Total','Status']);
    foreach ($rows as $r) {
        fputcsv($out, [
            $r['invoice_number'],
            $r['created_at'],
            $r['nama_pembayar'],
            $r['nomor_wa'],
            $r['kategori'] ?? '-',
            $r['deskripsi'],
            $r['subtotal'],
            $r['total_diskon'],
            $r['total_biaya_admin'],
            $r['total_pajak'],
            $r['kode_unik'],
            $r['total'],
            $r['status']
        ]);
    }
    fclose($out);
    exit;
}

render_header($title, $active);
?>

<style>
    .lp-wrap { max-width: 1280px; }

    .lp-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; gap:14px; flex-wrap:wrap; }
    .lp-head h2 { font-size:20px; font-weight:800; color:#0f172a; }
    .lp-head p { color:#64748b; font-size:13px; margin-top:4px; }

    /* Filter bar */
    .lp-filter {
        background:#fff; border-radius:14px; padding:16px 18px;
        border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);
        margin-bottom:18px;
        display:grid; grid-template-columns:repeat(5, 1fr) auto;
        gap:12px; align-items:end;
    }
    .lp-field label {
        display:block; font-size:11px; font-weight:700; color:#64748b;
        text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;
    }
    .lp-field input, .lp-field select {
        width:100%; padding:10px 12px; border:1.5px solid #e2e8f0;
        border-radius:9px; font-size:13.5px; background:#fff; font-family:inherit;
        transition:.15s;
    }
    .lp-field input:focus, .lp-field select:focus {
        outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12);
    }
    .lp-actions { display:flex; gap:8px; }
    .lp-actions .btn { padding:10px 16px; white-space:nowrap; }

    /* Stats cards */
    .lp-stats {
        display:grid; grid-template-columns:repeat(4, 1fr);
        gap:12px; margin-bottom:18px;
    }
    .lp-stat {
        background:#fff; border-radius:14px; padding:16px 18px;
        border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);
        display:flex; align-items:center; gap:14px;
    }
    .lp-stat .st-ic {
        width:44px; height:44px; border-radius:11px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .lp-stat.t-indigo .st-ic { background:#eef2ff; color:#6366f1; }
    .lp-stat.t-green  .st-ic { background:#dcfce7; color:#16a34a; }
    .lp-stat.t-amber  .st-ic { background:#fef3c7; color:#d97706; }
    .lp-stat.t-blue   .st-ic { background:#dbeafe; color:#2563eb; }

    .lp-stat .st-body { flex:1; min-width:0; }
    .lp-stat .st-lbl {
        font-size:11px; color:#94a3b8; text-transform:uppercase;
        letter-spacing:.5px; font-weight:700;
    }
    .lp-stat .st-num {
        font-size:20px; font-weight:800; color:#0f172a;
        margin-top:3px; line-height:1.2; font-variant-numeric:tabular-nums;
    }

    /* Table card */
    .lp-table-wrap {
        background:#fff; border-radius:14px;
        border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);
        overflow:hidden; min-height:200px; transition:opacity .2s;
    }
    .lp-table-wrap.loading { opacity:.5; pointer-events:none; }

    .lp-table { width:100%; border-collapse:collapse; font-size:13px; }
    .lp-table thead th {
        background:#f8fafc; text-align:left; padding:12px 16px;
        font-size:10.5px; text-transform:uppercase; letter-spacing:.6px;
        color:#64748b; font-weight:700; border-bottom:1px solid #e2e8f0;
        white-space:nowrap;
    }
    .lp-table tbody td {
        padding:13px 16px; border-bottom:1px solid #f8fafc;
        vertical-align:middle;
    }
    .lp-table tbody tr:last-child td { border-bottom:none; }
    .lp-table tbody tr:hover { background:#fafbff; }

    .lp-inv {
        font-family:'Courier New', monospace; font-size:11.5px;
        color:#4f46e5; text-decoration:none; font-weight:700;
        padding:3px 8px; background:#eef2ff; border-radius:5px;
        display:inline-block; letter-spacing:.3px;
    }
    .lp-inv:hover { background:#e0e7ff; }

    .lp-nama { font-weight:600; color:#0f172a; }
    .lp-tgl { font-size:12px; color:#64748b; }
    .lp-kat {
        display:inline-block; padding:3px 9px;
        background:#f1f5f9; color:#475569;
        border-radius:5px; font-size:11px; font-weight:600;
    }
    .lp-amt {
        text-align:right; font-weight:700; color:#0f172a;
        font-variant-numeric:tabular-nums; font-size:13.5px;
    }

    .lp-pill {
        display:inline-flex; align-items:center; gap:5px;
        padding:3px 9px; border-radius:20px;
        font-size:10.5px; font-weight:700;
        text-transform:uppercase; letter-spacing:.4px;
    }
    .lp-pill .dot { width:5px; height:5px; border-radius:50%; background:currentColor; }
    .lp-pill.paid { background:#dcfce7; color:#166534; }
    .lp-pill.unpaid { background:#fef3c7; color:#92400e; }
    .lp-pill.waiting { background:#dbeafe; color:#1e40af; }
    .lp-pill.rejected { background:#fee2e2; color:#991b1b; }
    .lp-pill.expired, .lp-pill.cancelled { background:#f1f5f9; color:#64748b; }

    /* Empty */
    .lp-empty {
        text-align:center; padding:60px 20px; color:#94a3b8;
    }
    .lp-empty .em-ic {
        width:72px; height:72px; border-radius:50%;
        background:#eef2ff; color:#6366f1;
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 16px;
    }
    .lp-empty h3 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
    .lp-empty p { font-size:13px; }

    /* Summary footer */
    .lp-summary {
        background:#0f172a; color:#fff; border-radius:14px;
        padding:18px 22px; margin-top:16px;
        display:grid; grid-template-columns:repeat(4, 1fr); gap:16px;
    }
    .lp-summary-item .lbl {
        font-size:10.5px; text-transform:uppercase; letter-spacing:.8px;
        color:#94a3b8; font-weight:700;
    }
    .lp-summary-item .val {
        font-size:15px; font-weight:700; margin-top:4px;
        font-variant-numeric:tabular-nums; color:#fff;
    }
    .lp-summary-item.diskon .val { color:#fca5a5; }
    .lp-summary-item.tambah .val { color:#86efac; }

    /* Loading */
    .lp-loading {
        position:fixed; top:14px; right:14px; background:#0f172a; color:#fff;
        padding:8px 14px; border-radius:20px; font-size:12px; z-index:999;
        display:none; align-items:center; gap:8px;
        box-shadow:0 6px 20px rgba(0,0,0,0.2);
    }
    .lp-loading.show { display:flex; }
    .lp-loading .spin {
        width:12px; height:12px; border:2px solid rgba(255,255,255,0.3);
        border-top-color:#fff; border-radius:50%; animation:spin .7s linear infinite;
    }
    @keyframes spin { to { transform:rotate(360deg); } }

    /* Responsive */
    @media (max-width:1024px) {
        .lp-filter { grid-template-columns:1fr 1fr; }
        .lp-stats { grid-template-columns:1fr 1fr; }
        .lp-summary { grid-template-columns:1fr 1fr; }
    }
    @media (max-width:640px) {
        .lp-filter { grid-template-columns:1fr; padding:14px; }
        .lp-actions { width:100%; }
        .lp-actions .btn { flex:1; justify-content:center; }
        .lp-stats { grid-template-columns:1fr; }
        .lp-summary { grid-template-columns:1fr; padding:16px; }
        .lp-table thead { display:none; }
        .lp-table tbody tr {
            display:block; padding:14px 16px;
            border-bottom:1px solid #f1f5f9;
        }
        .lp-table tbody td {
            display:flex; justify-content:space-between;
            padding:6px 0; border:none;
            font-size:13px;
        }
        .lp-table tbody td::before {
            content:attr(data-label);
            font-size:11px; color:#94a3b8;
            text-transform:uppercase; font-weight:700;
            letter-spacing:.5px;
        }
        .lp-table .lp-amt { text-align:right; }
    }
</style>

<div class="lp-loading" id="lpLoading"><div class="spin"></div> Memperbarui...</div>

<div class="lp-wrap">

    <div class="lp-head">
        <div>
            <h2>Laporan</h2>
            <p id="periodeText">Periode: <?= tglIndo($dari . ' 00:00:00') ?> — <?= tglIndo($sampai . ' 23:59:59') ?></p>
        </div>
    </div>

    <!-- Filter -->
    <div class="lp-filter">
        <div class="lp-field">
            <label>Dari Tanggal</label>
            <input type="date" id="fDari" value="<?= e($dari) ?>">
        </div>
        <div class="lp-field">
            <label>Sampai Tanggal</label>
            <input type="date" id="fSampai" value="<?= e($sampai) ?>">
        </div>
        <div class="lp-field">
            <label>Status</label>
            <select id="fStatus">
                <?php foreach (['paid'=>'Lunas','unpaid'=>'Belum Bayar','waiting'=>'Menunggu','expired'=>'Expired','cancelled'=>'Dibatalkan','rejected'=>'Ditolak','all'=>'Semua'] as $k=>$v): ?>
                    <option value="<?= $k ?>" <?= $status === $k ? 'selected' : '' ?>><?= $v ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="lp-field">
            <label>Kategori</label>
            <select id="fKat">
                <option value="0">Semua Kategori</option>
                <?php foreach ($kategoris as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= $kat === (int)$k['id'] ? 'selected' : '' ?>><?= e($k['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="lp-field">
            <label>&nbsp;</label>
            <button type="button" class="btn" style="width:100%; justify-content:center;" onclick="applyFilter()">
                <?= lp_icon('filter', 14) ?> Filter
            </button>
        </div>
        <div class="lp-field">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-outline" style="width:100%; justify-content:center;" onclick="exportCSV()">
                <?= lp_icon('download', 14) ?> Export
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="lp-stats">
        <div class="lp-stat t-indigo">
            <div class="st-ic"><?= lp_icon('file', 20) ?></div>
            <div class="st-body">
                <div class="st-lbl">Total Tagihan</div>
                <div class="st-num" id="statCount">0</div>
            </div>
        </div>
        <div class="lp-stat t-green">
            <div class="st-ic"><?= lp_icon('dollar', 20) ?></div>
            <div class="st-body">
                <div class="st-lbl">Total Nominal</div>
                <div class="st-num" id="statTotal">Rp 0</div>
            </div>
        </div>
        <div class="lp-stat t-amber">
            <div class="st-ic"><?= lp_icon('trend', 20) ?></div>
            <div class="st-body">
                <div class="st-lbl">Rata-rata</div>
                <div class="st-num" id="statAvg">Rp 0</div>
            </div>
        </div>
        <div class="lp-stat t-blue">
            <div class="st-ic"><?= lp_icon('percent', 20) ?></div>
            <div class="st-body">
                <div class="st-lbl">Total Diskon</div>
                <div class="st-num" id="statDiskon">Rp 0</div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="lp-table-wrap" id="lpTableWrap">
        <table class="lp-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Pembayar</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th style="text-align:right;">Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="lpTableBody">
                <tr><td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>

    <!-- Summary -->
    <div class="lp-summary" id="lpSummary">
        <div class="lp-summary-item">
            <div class="lbl">Diskon</div>
            <div class="val" id="sumDiskon">Rp 0</div>
        </div>
        <div class="lp-summary-item">
            <div class="lbl">Biaya Admin</div>
            <div class="val" id="sumBiaya">Rp 0</div>
        </div>
        <div class="lp-summary-item">
            <div class="lbl">Pajak</div>
            <div class="val" id="sumPajak">Rp 0</div>
        </div>
        <div class="lp-summary-item">
            <div class="lbl">Kode Unik</div>
            <div class="val" id="sumUnik">Rp 0</div>
        </div>
    </div>

</div>

<script>
const API = '<?= BASE_URL ?>/?url=api/laporan-list';
const URL_DETAIL = '<?= url('invoice-detail&id=') ?>';
let loading = false;

const ICONS = {
    eye:    '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
    inbox:  '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>',
};

function escHtml(s) {
    if (s == null) return '';
    return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

function getFilter() {
    return {
        dari:   document.getElementById('fDari').value,
        sampai: document.getElementById('fSampai').value,
        status: document.getElementById('fStatus').value,
        kat:    document.getElementById('fKat').value,
    };
}

async function fetchData() {
    if (loading) return;
    loading = true;

    document.getElementById('lpTableWrap').classList.add('loading');
    document.getElementById('lpLoading').classList.add('show');

    const f = getFilter();

    try {
        const url = API
            + '&dari=' + encodeURIComponent(f.dari)
            + '&sampai=' + encodeURIComponent(f.sampai)
            + '&status=' + encodeURIComponent(f.status)
            + '&kat=' + f.kat
            + '&t=' + Date.now();
        const res = await fetch(url);
        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Gagal');

        renderTable(data.rows);
        renderStats(data.stats);
        updatePeriode(f.dari, f.sampai);
        updateURL(f);
    } catch (e) {
        console.error(e);
        document.getElementById('lpTableBody').innerHTML = `
            <tr><td colspan="6" style="text-align:center; padding:40px; color:#dc2626;">
                Gagal memuat data: ${escHtml(e.message)}
            </td></tr>
        `;
    } finally {
        loading = false;
        document.getElementById('lpTableWrap').classList.remove('loading');
        document.getElementById('lpLoading').classList.remove('show');
    }
}

function renderTable(rows) {
    const tb = document.getElementById('lpTableBody');
    if (!rows.length) {
        tb.innerHTML = `
            <tr><td colspan="6" style="padding:0; border:none;">
                <div class="lp-empty">
                    <div class="em-ic">${ICONS.inbox}</div>
                    <h3>Tidak ada data</h3>
                    <p>Tidak ada tagihan untuk filter ini</p>
                </div>
            </td></tr>
        `;
        return;
    }

    let html = '';
    rows.forEach(r => {
        html += `
            <tr>
                <td data-label="Invoice">
                    <a href="${URL_DETAIL}${r.id}" class="lp-inv">${escHtml(r.invoice_number)}</a>
                </td>
                <td data-label="Pembayar">
                    <div class="lp-nama">${escHtml(r.nama_pembayar)}</div>
                </td>
                <td data-label="Kategori">
                    ${r.kategori ? `<span class="lp-kat">${escHtml(r.kategori)}</span>` : '<span style="color:#cbd5e1;">—</span>'}
                </td>
                <td data-label="Tanggal">
                    <div class="lp-tgl">${escHtml(r.tanggal_fmt)}</div>
                </td>
                <td data-label="Total" class="lp-amt">${escHtml(r.total_fmt)}</td>
                <td data-label="Status">
                    <span class="lp-pill ${r.status}"><span class="dot"></span>${r.status}</span>
                </td>
            </tr>
        `;
    });
    tb.innerHTML = html;
}

function renderStats(stats) {
    document.getElementById('statCount').textContent = stats.count.toLocaleString('id-ID');
    document.getElementById('statTotal').textContent = stats.total_fmt;
    document.getElementById('statAvg').textContent = stats.avg_fmt;
    document.getElementById('statDiskon').textContent = stats.diskon_fmt;

    document.getElementById('sumDiskon').textContent = stats.diskon_fmt;
    document.getElementById('sumBiaya').textContent = stats.biaya_fmt;
    document.getElementById('sumPajak').textContent = stats.pajak_fmt;
    document.getElementById('sumUnik').textContent = stats.unik_fmt;
}

function updatePeriode(dari, sampai) {
    const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const fmt = (d) => {
        const t = new Date(d);
        return t.getDate() + ' ' + bulan[t.getMonth()] + ' ' + t.getFullYear();
    };
    document.getElementById('periodeText').textContent = 'Periode: ' + fmt(dari) + ' — ' + fmt(sampai);
}

function updateURL(f) {
    const params = new URLSearchParams({
        url: 'laporan',
        dari: f.dari,
        sampai: f.sampai,
        status: f.status,
        kat: f.kat,
    });
    window.history.replaceState({}, '', '<?= BASE_URL ?>/?url=laporan&' + params.toString().replace('url=laporan&', ''));
}

function applyFilter() {
    fetchData();
}

function exportCSV() {
    const f = getFilter();
    const url = '<?= BASE_URL ?>/?url=laporan'
        + '&dari=' + encodeURIComponent(f.dari)
        + '&sampai=' + encodeURIComponent(f.sampai)
        + '&status=' + encodeURIComponent(f.status)
        + '&kat=' + f.kat
        + '&export=csv';
    window.location.href = url;
}

// Auto-apply on change
document.getElementById('fStatus').addEventListener('change', fetchData);
document.getElementById('fKat').addEventListener('change', fetchData);
document.getElementById('fDari').addEventListener('change', fetchData);
document.getElementById('fSampai').addEventListener('change', fetchData);

// Init
fetchData();
</script>

<?php render_footer(); ?>