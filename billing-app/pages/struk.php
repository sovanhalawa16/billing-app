<?php
// ============ ROUTE ============
$route = $_GET['url'] ?? '';
$parts = explode('/', $route);
$token = $parts[1] ?? '';

if (!$token) { http_response_code(404); die('Link tidak valid.'); }

// ============ FETCH INVOICE ============
$stmt = $pdo->prepare("
    SELECT i.*, c.nama AS kategori, a.nama AS admin_nama
    FROM invoices i 
    LEFT JOIN categories c ON c.id = i.kategori_id
    LEFT JOIN admins a ON a.id = i.created_by
    WHERE i.token = ?
");
$stmt->execute([$token]);
$inv = $stmt->fetch();

if (!$inv) {
    http_response_code(404);
    die('Struk tidak ditemukan.');
}

if ($inv['status'] !== 'paid') {
    die('Struk hanya tersedia untuk tagihan yang sudah LUNAS.');
}

// ============ FETCH RELATIONS ============
$items = $pdo->prepare("SELECT * FROM invoice_items WHERE invoice_id=? ORDER BY urutan, id");
$items->execute([$inv['id']]);
$items = $items->fetchAll();

$adjs = $pdo->prepare("SELECT * FROM invoice_adjustments WHERE invoice_id=? ORDER BY urutan, id");
$adjs->execute([$inv['id']]);
$adjs = $adjs->fetchAll();

// Metode pembayaran yang dipakai
$paidMethodName = '';
$paidAt = null;
$proofsStmt = $pdo->prepare("
    SELECT pp.*, pm.nama AS metode_nama 
    FROM payment_proofs pp
    LEFT JOIN payment_methods pm ON pm.id = pp.payment_method_id
    WHERE pp.invoice_id=? AND pp.status='approved' 
    ORDER BY pp.verified_at ASC LIMIT 1
");
$proofsStmt->execute([$inv['id']]);
$paidProof = $proofsStmt->fetch();
if ($paidProof) {
    $paidMethodName = $paidProof['metode_nama'] ?: '';
    $paidAt = $paidProof['verified_at'] ?: $inv['updated_at'];
}
if (!$paidAt) $paidAt = $inv['updated_at'];

// Setting
$bisnisNama = setting('nama_bisnis', APP_NAME);
$alamat = setting('alamat', '');
$kontak = setting('kontak_admin', '');
$footer = setting('footer_text', 'Terima kasih telah melakukan pembayaran.');
$logo = setting('logo');

// Hitung PPN (kalau ada adjustment tipe pajak)
$ppnVal = 0;
$ppnPercent = 0;
foreach ($adjs as $ad) {
    if ($ad['tipe'] === 'pajak') {
        $ppnVal += (float)$ad['hasil'];
        if ($ad['mode'] === 'persen') $ppnPercent = (float)$ad['nilai'];
    }
}

// Format tanggal struk (kayak Indomaret: DD.MM.YY-HH:MM)
$tglStruk = date('d.m.y-H:i', strtotime($inv['created_at']));
$tglBayar = date('d.m.y-H:i', strtotime($paidAt));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk <?= htmlspecialchars($inv['invoice_number']) ?></title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Courier New', 'SF Mono', Monaco, Consolas, monospace;
    background: #e5e5e5;
    padding: 20px;
    min-height: 100vh;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    color: #000;
    font-size: 13px;
    line-height: 1.5;
}

.struk-wrap {
    background: #fff;
    width: 100%;
    max-width: 380px;
    padding: 24px 20px 30px;
    box-shadow: 0 4px 24px rgba(0,0,0,.1);
    border-radius: 4px;
}

/* Header bisnis */
.header-bisnis {
    text-align: center;
    margin-bottom: 6px;
    font-weight: 700;
    font-size: 13px;
    line-height: 1.4;
}
.header-bisnis .nama {
    font-size: 14px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .3px;
}
.header-bisnis .alamat {
    font-weight: 400;
    font-size: 11.5px;
    line-height: 1.5;
    margin-top: 3px;
}
.header-bisnis .kontak {
    font-weight: 400;
    font-size: 11.5px;
    margin-top: 2px;
}

/* Logo */
.logo-box {
    text-align: center;
    margin: 10px 0 6px;
}
.logo-box img {
    max-width: 100px;
    max-height: 60px;
    object-fit: contain;
}
.logo-box .inisial {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: #000;
    color: #fff;
    display: inline-flex;
    align-items: center; justify-content: center;
    font-weight: 800;
    font-size: 22px;
}

/* Divider */
.divider {
    border: none;
    border-top: 1px dashed #000;
    margin: 10px 0;
    height: 0;
}
.divider-double {
    border: none;
    border-top: 2px solid #000;
    margin: 12px 0;
    height: 0;
}

/* Info row */
.info-row {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    font-size: 12px;
    padding: 2px 0;
}
.info-row .lbl { color: #333; flex-shrink: 0; }
.info-row .val { text-align: right; font-weight: 600; word-break: break-word; }

/* Section title */
.section-title {
    text-align: center;
    font-weight: 800;
    font-size: 12.5px;
    letter-spacing: 1.5px;
    margin: 12px 0 8px;
    text-transform: uppercase;
}

/* Items table */
.items-head {
    display: flex;
    font-size: 10.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 5px 0;
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
    margin-bottom: 5px;
}
.items-head .col-1 { flex: 1; }
.items-head .col-2 { width: 32px; text-align: center; }
.items-head .col-3 { width: 70px; text-align: right; }
.items-head .col-4 { width: 70px; text-align: right; }

.item-line {
    display: flex;
    font-size: 12px;
    padding: 3px 0;
    align-items: flex-start;
}
.item-line .col-1 { flex: 1; padding-right: 4px; word-break: break-word; }
.item-line .col-2 { width: 32px; text-align: center; }
.item-line .col-3 { width: 70px; text-align: right; }
.item-line .col-4 { width: 70px; text-align: right; font-weight: 600; }

/* Summary rows */
.sum-line {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    padding: 2px 0;
    gap: 10px;
}
.sum-line .lbl { color: #333; }
.sum-line .val { font-weight: 600; }
.sum-line.diskon .val { color: #000; }

.total-block {
    display: flex;
    justify-content: space-between;
    font-size: 15px;
    font-weight: 800;
    padding: 8px 0;
    margin-top: 4px;
    border-top: 2px solid #000;
    border-bottom: 2px solid #000;
    letter-spacing: .5px;
}

/* Footer */
.footer-struk {
    text-align: center;
    font-size: 11.5px;
    margin-top: 14px;
    line-height: 1.6;
}
.footer-struk .thanks {
    font-weight: 700;
    font-size: 12.5px;
    margin-bottom: 6px;
}
.footer-struk .note {
    color: #444;
    font-size: 10.5px;
    margin-top: 6px;
}

.brand-power {
    text-align: center;
    font-size: 10px;
    color: #666;
    margin-top: 14px;
    letter-spacing: .5px;
}

/* Action buttons (tidak ke-print) */
.action-bar {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    z-index: 100;
    background: #fff;
    padding: 10px;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,.15);
}
.action-bar button,
.action-bar a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    border-radius: 10px;
    border: none;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: all .2s;
    white-space: nowrap;
}
.action-bar .btn-primary {
    background: #000;
    color: #fff;
}
.action-bar .btn-primary:hover { background: #1d1d1f; transform: translateY(-2px); }
.action-bar .btn-outline {
    background: #f5f5f7;
    color: #1d1d1f;
    border: 1.5px solid #e5e5e5;
}
.action-bar .btn-outline:hover { background: #e5e5e5; }

@media print {
    body {
        background: #fff;
        padding: 0;
        margin: 0;
        font-size: 12px;
    }
    .struk-wrap {
        box-shadow: none;
        border-radius: 0;
        max-width: 100%;
        padding: 0 8mm;
    }
    .action-bar { display: none !important; }
    .divider, .divider-double { border-color: #000 !important; }
    @page {
        size: auto;
        margin: 8mm;
    }
}
</style>
</head>
<body>

<div class="struk-wrap">

    <!-- HEADER BISNIS -->
    <div class="header-bisnis">
        <div class="nama"><?= htmlspecialchars(strtoupper($bisnisNama)) ?></div>
        <?php if ($alamat): ?>
            <div class="alamat"><?= nl2br(htmlspecialchars($alamat)) ?></div>
        <?php endif; ?>
        <?php if ($kontak): ?>
            <div class="kontak">Telp/WA: <?= htmlspecialchars($kontak) ?></div>
        <?php endif; ?>
    </div>

    <!-- LOGO -->
    <?php if ($logo && file_exists(UPLOAD_PATH . '/' . $logo)): ?>
        <div class="logo-box">
            <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($logo) ?>" alt="">
        </div>
    <?php else: ?>
        <div class="logo-box">
            <div class="inisial"><?= strtoupper(substr($bisnisNama, 0, 1)) ?></div>
        </div>
    <?php endif; ?>

    <hr class="divider-double">

    <!-- TITLE -->
    <div class="section-title">Struk Pembayaran Digital</div>

    <hr class="divider">

    <!-- INFO TRANSAKSI -->
    <div class="info-row">
        <span class="lbl">No. Invoice</span>
        <span class="val"><?= htmlspecialchars($inv['invoice_number']) ?></span>
    </div>
    <div class="info-row">
        <span class="lbl">Tanggal</span>
        <span class="val"><?= $tglStruk ?></span>
    </div>
    <?php if (!empty($inv['kategori'])): ?>
        <div class="info-row">
            <span class="lbl">Kategori</span>
            <span class="val"><?= htmlspecialchars($inv['kategori']) ?></span>
        </div>
    <?php endif; ?>
    <div class="info-row">
        <span class="lbl">Kasir</span>
        <span class="val"><?= htmlspecialchars($inv['admin_nama'] ?: 'Admin') ?></span>
    </div>

    <hr class="divider">

    <!-- PEMBAYAR -->
    <div class="info-row">
        <span class="lbl">Pembayar</span>
        <span class="val"><?= htmlspecialchars($inv['nama_pembayar']) ?></span>
    </div>
    <?php if (!empty($inv['nomor_wa'])): ?>
        <div class="info-row">
            <span class="lbl">No. WA</span>
            <span class="val"><?= htmlspecialchars($inv['nomor_wa']) ?></span>
        </div>
    <?php endif; ?>

    <hr class="divider">

    <!-- DESKRIPSI -->
    <div class="info-row">
        <span class="lbl">Ket.</span>
        <span class="val"><?= htmlspecialchars($inv['deskripsi']) ?></span>
    </div>

    <hr class="divider">

    <!-- ITEMS -->
    <div class="items-head">
        <div class="col-1">Item</div>
        <div class="col-2">Qty</div>
        <div class="col-3">Harga</div>
        <div class="col-4">Total</div>
    </div>

    <?php foreach ($items as $it): ?>
        <div class="item-line">
            <div class="col-1"><?= htmlspecialchars($it['nama_item']) ?></div>
            <div class="col-2"><?= (float)$it['qty'] ?></div>
            <div class="col-3"><?= number_format((float)$it['harga_satuan'], 0, ',', '.') ?></div>
            <div class="col-4"><?= number_format((float)$it['subtotal'], 0, ',', '.') ?></div>
        </div>
    <?php endforeach; ?>

    <hr class="divider">

    <!-- SUMMARY -->
    <div class="sum-line">
        <span class="lbl">Subtotal</span>
        <span class="val"><?= number_format((float)$inv['subtotal'], 0, ',', '.') ?></span>
    </div>

    <?php foreach ($adjs as $ad): if ($ad['tipe'] !== 'diskon') continue; ?>
        <div class="sum-line diskon">
            <span class="lbl"><?= htmlspecialchars($ad['label']) ?></span>
            <span class="val">-<?= number_format((float)$ad['hasil'], 0, ',', '.') ?></span>
        </div>
    <?php endforeach; ?>

    <?php foreach ($adjs as $ad): if (!in_array($ad['tipe'], ['biaya_admin'])) continue; ?>
        <div class="sum-line">
            <span class="lbl"><?= htmlspecialchars($ad['label']) ?></span>
            <span class="val">+<?= number_format((float)$ad['hasil'], 0, ',', '.') ?></span>
        </div>
    <?php endforeach; ?>

    <?php if ($ppnVal > 0): ?>
        <div class="sum-line">
            <span class="lbl">PPN<?= $ppnPercent > 0 ? ' ' . (int)$ppnPercent . '%' : '' ?></span>
            <span class="val">+<?= number_format($ppnVal, 0, ',', '.') ?></span>
        </div>
    <?php endif; ?>

    <?php if ($inv['kode_unik'] > 0): ?>
        <div class="sum-line">
            <span class="lbl">Kode Unik</span>
            <span class="val">+<?= number_format((float)$inv['kode_unik'], 0, ',', '.') ?></span>
        </div>
    <?php endif; ?>

    <!-- TOTAL -->
    <div class="total-block">
        <span>TOTAL</span>
        <span>Rp <?= number_format((float)$inv['total'], 0, ',', '.') ?></span>
    </div>

    <!-- STATUS & METODE -->
    <div class="info-row" style="margin-top:10px;">
        <span class="lbl">Status</span>
        <span class="val">✓ LUNAS</span>
    </div>
    <?php if ($paidMethodName): ?>
        <div class="info-row">
            <span class="lbl">Metode</span>
            <span class="val"><?= htmlspecialchars($paidMethodName) ?></span>
        </div>
    <?php endif; ?>
    <div class="info-row">
        <span class="lbl">Dibayar</span>
        <span class="val"><?= $tglBayar ?></span>
    </div>

    <hr class="divider">

    <!-- FOOTER -->
    <div class="footer-struk">
        <div class="thanks">~~ TERIMA KASIH ~~</div>
        <div><?= nl2br(htmlspecialchars($footer)) ?></div>
        <div class="note">
            Struk ini merupakan bukti sah<br>
            pembayaran yang tersimpan<br>
            secara digital.
        </div>
    </div>

    <hr class="divider">

    <div class="brand-power">
        Powered by <?= htmlspecialchars(APP_NAME) ?>
    </div>

</div>

<!-- ACTION BAR -->
<div class="action-bar">
    <a href="javascript:window.close()" class="btn-outline">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        Tutup
    </a>
    <button type="button" class="btn-primary" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Cetak / Simpan PDF
    </button>
</div>

<script>
// Auto print hint (opsional)
// window.onload = () => setTimeout(() => window.print(), 400);
</script>

</body>
</html>