<?php
$title = 'Hasil Bulk Tagihan';
$active = 'invoice';

$list = $_SESSION['bulk_result'] ?? [];
unset($_SESSION['bulk_result']);

if (empty($list)) {
    flash('error', 'Tidak ada data hasil bulk.');
    redirect('/?url=invoice');
}

render_header($title, $active);
?>

<style>
    .br-wrap { max-width: 1200px; }

    .br-head {
        background:linear-gradient(160deg, #0f172a 0%, #1e293b 100%);
        border-radius:16px; padding:26px 30px; color:#fff;
        margin-bottom:20px; display:flex; align-items:center; gap:20px;
        flex-wrap:wrap;
    }
    .br-head .br-ic {
        width:56px; height:56px; border-radius:14px;
        background:linear-gradient(135deg,#dcfce7,#bbf7d0); color:#16a34a;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .br-head .br-txt { flex:1; min-width:0; }
    .br-head h2 { font-size:22px; font-weight:800; margin-bottom:4px; }
    .br-head p { font-size:13px; color:#94a3b8; }
    .br-head .br-stat {
        background:rgba(255,255,255,0.1); padding:10px 16px; border-radius:12px;
        text-align:center;
    }
    .br-head .br-stat .n { font-size:24px; font-weight:800; color:#a5b4fc; }
    .br-head .br-stat .l { font-size:10px; text-transform:uppercase; letter-spacing:.8px; color:#94a3b8; margin-top:2px; }

    .br-actions {
        display:flex; gap:10px; margin-bottom:16px; flex-wrap:wrap;
    }

    .br-table-wrap {
        background:#fff; border-radius:14px; border:1px solid #f1f5f9;
        overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04);
    }
    .br-table { width:100%; border-collapse:collapse; font-size:13px; }
    .br-table thead th {
        background:#f8fafc; text-align:left; padding:12px 16px;
        font-size:10.5px; text-transform:uppercase; letter-spacing:.6px;
        color:#64748b; font-weight:700; border-bottom:1px solid #e2e8f0;
        white-space:nowrap;
    }
    .br-table tbody td {
        padding:12px 16px; border-bottom:1px solid #f8fafc;
        vertical-align:middle;
    }
    .br-table tbody tr:last-child td { border-bottom:none; }
    .br-table tbody tr:hover { background:#fafbff; }

    .br-no {
        font-family:'Courier New', monospace; font-size:11px;
        color:#94a3b8; font-weight:700;
    }
    .br-nama { font-weight:600; color:#0f172a; }
    .br-wa {
        font-family:'Courier New', monospace; font-size:12px;
        color:#475569;
    }
    .br-inv {
        font-family:'Courier New', monospace; font-size:11px;
        color:#4f46e5; background:#eef2ff; padding:3px 8px;
        border-radius:5px; font-weight:700; letter-spacing:.3px;
        display:inline-block;
    }
    .br-btns { display:flex; gap:6px; flex-wrap:wrap; }
    .br-btn {
        display:inline-flex; align-items:center; gap:5px;
        padding:6px 10px; border-radius:8px; font-size:11.5px; font-weight:600;
        border:1.5px solid #e2e8f0; background:#fff; color:#475569;
        cursor:pointer; text-decoration:none; transition:.15s; font-family:inherit;
        white-space:nowrap;
    }
    .br-btn:hover { transform:translateY(-1px); }
    .br-btn.green { color:#16a34a; border-color:#bbf7d0; }
    .br-btn.green:hover { background:#f0fdf4; }
    .br-btn.blue { color:#4f46e5; border-color:#c7d2fe; }
    .br-btn.blue:hover { background:#eef2ff; }

    @media (max-width:768px) {
        .br-table thead { display:none; }
        .br-table tbody tr { display:block; padding:14px; border-bottom:1px solid #f1f5f9; }
        .br-table tbody td { display:flex; justify-content:space-between; padding:6px 0; border:none; }
        .br-table tbody td::before {
            content:attr(data-label); font-size:11px; color:#94a3b8;
            text-transform:uppercase; font-weight:700; letter-spacing:.5px;
        }
        .br-head { padding:20px; }
    }
</style>

<div class="br-wrap">

    <!-- HEADER -->
    <div class="br-head">
        <div class="br-ic">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="br-txt">
            <h2>Bulk Tagihan Berhasil Dibuat</h2>
            <p>Semua tagihan sudah dibuat. Tinggal kirim link ke masing-masing penerima.</p>
        </div>
        <div class="br-stat">
            <div class="n"><?= count($list) ?></div>
            <div class="l">Total Tagihan</div>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="br-actions">
        <a href="<?= url('invoice') ?>" class="btn btn-outline">
            ← Kembali ke Daftar
        </a>
        <button type="button" class="btn btn-outline" onclick="copyAllLinks()">
            📋 Copy Semua Link
        </button>
        <button type="button" class="btn" onclick="openAllWa()">
            💬 Buka Semua WA
        </button>
    </div>

    <div class="br-table-wrap">
        <table class="br-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Nama</th>
                    <th>Nomor WA</th>
                    <th>Invoice</th>
                    <th>Total</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $i => $r): ?>
                    <tr>
                        <td data-label="#">
                            <span class="br-no"><?= $i + 1 ?></span>
                        </td>
                        <td data-label="Nama">
                            <div class="br-nama"><?= e($r['nama']) ?></div>
                        </td>
                        <td data-label="Nomor WA">
                            <span class="br-wa"><?= e($r['wa']) ?></span>
                        </td>
                        <td data-label="Invoice">
                            <span class="br-inv"><?= e($r['invoice_number']) ?></span>
                        </td>
                        <td data-label="Total">
                            <strong><?= e($r['total']) ?></strong>
                        </td>
                        <td data-label="Aksi">
                            <div class="br-btns">
                                <button type="button" class="br-btn blue"
                                        onclick='copyOne(<?= json_encode($r['link']) ?>, this)'>
                                    📋 Copy Link
                                </button>
                                <a href="<?= e($r['wa_link']) ?>" target="_blank" class="br-btn green">
                                    💬 Kirim WA
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
const ALL_LINKS = <?= json_encode(array_column($list, 'link')) ?>;
const ALL_WA_LINKS = <?= json_encode(array_column($list, 'wa_link')) ?>;

function copyOne(text, btn) {
    const orig = btn.innerHTML;
    const done = () => {
        btn.innerHTML = '✅ Tersalin!';
        btn.style.background = '#dcfce7';
        btn.style.color = '#166534';
        setTimeout(() => {
            btn.innerHTML = orig;
            btn.style.background = '';
            btn.style.color = '';
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

function copyAllLinks() {
    const text = ALL_LINKS.join('\n');
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            alert('✅ ' + ALL_LINKS.length + ' link berhasil di-copy!');
        });
    } else {
        fallbackCopy(text, () => alert('✅ ' + ALL_LINKS.length + ' link berhasil di-copy!'));
    }
}

function openAllWa() {
    if (!confirm('Buka ' + ALL_WA_LINKS.length + ' tab WhatsApp?\n\n⚠️ Browser mungkin blokir popup. Izinkan popup dulu ya.')) return;

    let opened = 0;
    ALL_WA_LINKS.forEach((url, i) => {
        setTimeout(() => {
            const w = window.open(url, '_blank');
            if (w) opened++;
        }, i * 300);
    });

    setTimeout(() => {
        alert('✅ ' + opened + ' tab dibuka.\n\nKalau kurang, berarti browser blokir popup. Izinkan popup untuk situs ini ya.');
    }, ALL_WA_LINKS.length * 300 + 500);
}
</script>

<?php render_footer(); ?>