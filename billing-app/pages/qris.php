<?php
$title = 'QRIS Gateway';
$active = 'qris';

$cfg = $pdo->query("SELECT * FROM qris_gateway_config ORDER BY id LIMIT 1")->fetch();
$enabled = $cfg && $cfg['enabled'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $enabled) {
    // Nanti kalau enabled
    flash('success', 'Konfigurasi disimpan.');
    redirect('/?url=qris');
}

render_header($title, $active);
?>

<style>
    .qr-locked {
        background:linear-gradient(160deg, #1a1a2e 0%, #2d2d4a 100%);
        border-radius:16px; padding:60px 30px; text-align:center;
        color:#fff; box-shadow:0 8px 24px rgba(26,26,46,0.15);
        max-width:600px; margin:40px auto;
    }
    .qr-locked .ic { font-size:80px; margin-bottom:16px; opacity:.6; }
    .qr-locked h2 { font-size:22px; margin-bottom:8px; }
    .qr-locked p { color:#94a3b8; font-size:14px; line-height:1.6; max-width:400px; margin:0 auto 20px; }
    .qr-badge { display:inline-block; padding:6px 14px; background:rgba(255,255,255,0.1); border-radius:20px; font-size:12px; font-weight:600; letter-spacing:0.5px; text-transform:uppercase; }
</style>

<div class="qr-locked">
    <div class="ic">🔒</div>
    <div class="qr-badge">Coming Soon</div>
    <h2 style="margin-top:12px;">QRIS Payment Gateway</h2>
    <p>
        Fitur QRIS Dinamis (auto-generate QR dari API provider) belum diaktifkan.
        Saat ini aplikasi pakai <strong>QRIS Statis</strong> (upload gambar manual di menu Metode Bayar).
    </p>
    <p style="font-size:12px; opacity:.6;">
        Modul ini sudah disiapkan di backend dan akan dibuka saat provider sudah terintegrasi.
    </p>
</div>

<?php render_footer(); ?>