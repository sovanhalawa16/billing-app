<?php
$title = 'Setting';
$active = 'setting';

if (!is_super_admin()) {
    flash('error', 'Hanya Super Admin yang bisa akses Setting.');
    redirect('/?url=dashboard');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['nama_bisnis','kontak_admin','alamat','footer_text','durasi_expired_default','format_invoice_number','kode_unik_digit'];

    foreach ($fields as $f) {
        if (isset($_POST[$f])) {
            $val = trim($_POST[$f]);
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings WHERE `key`=?");
            $stmt->execute([$f]);
            if ($stmt->fetchColumn()) {
                $pdo->prepare("UPDATE settings SET value=? WHERE `key`=?")->execute([$val, $f]);
            } else {
                $pdo->prepare("INSERT INTO settings (`key`, value) VALUES (?,?)")->execute([$f, $val]);
            }
        }
    }

    // Upload logo
    if (!empty($_FILES['logo']['name'])) {
        $allowed = ['image/jpeg','image/png','image/webp','image/svg+xml'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['logo']['tmp_name']);
        finfo_close($finfo);
        if (in_array($mime, $allowed) && $_FILES['logo']['size'] <= 2*1024*1024) {
            $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
            $fn = 'logo_' . date('YmdHis') . '.' . $ext;
            $dir = UPLOAD_PATH . '/logo';
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $dir . '/' . $fn)) {
                // Hapus lama
                $old = setting('logo');
                if ($old && file_exists(UPLOAD_PATH . '/' . $old)) @unlink(UPLOAD_PATH . '/' . $old);
                $pdo->prepare("UPDATE settings SET value=? WHERE `key`='logo'")->execute(['logo/' . $fn]);
            }
        } else {
            flash('error', 'Logo harus JPG/PNG/WEBP/SVG max 2MB.');
        }
    }

    // Ganti password
    $pw_baru = $_POST['pw_baru'] ?? '';
    if ($pw_baru !== '') {
        $pw_lama = $_POST['pw_lama'] ?? '';
        $admin = $GLOBALS['admin'];
        if (!password_verify($pw_lama, $admin['password'])) {
            flash('error', 'Password lama salah.');
            redirect('/?url=setting');
        }
        if (strlen($pw_baru) < 6) {
            flash('error', 'Password baru minimal 6 karakter.');
            redirect('/?url=setting');
        }
        $pdo->prepare("UPDATE admins SET password=? WHERE id=?")->execute([password_hash($pw_baru, PASSWORD_BCRYPT), $admin['id']]);
        flash('success', 'Semua setting & password berhasil disimpan.');
        redirect('/?url=setting');
    }

    flash('success', 'Setting berhasil disimpan.');
    redirect('/?url=setting');
}

render_header($title, $active);
?>

<style>
    .st-card { background:#fff; border-radius:12px; padding:22px; box-shadow:0 1px 3px rgba(0,0,0,0.04); max-width:720px; margin-bottom:16px; }
    .st-card h3 { font-size:15px; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
    .st-field { margin-bottom:16px; }
    .st-field label { display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px; }
    .st-field input, .st-field textarea { width:100%; padding:10px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px; font-family:inherit; }
    .st-field input:focus, .st-field textarea:focus { outline:none; border-color:#667eea; box-shadow:0 0 0 3px rgba(102,126,234,0.1); }
    .st-field small { color:#94a3b8; font-size:11px; display:block; margin-top:4px; }
    .st-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .st-logo-prev { display:flex; align-items:center; gap:12px; padding:10px; background:#f8fafc; border-radius:8px; margin-top:8px; }
    .st-logo-prev img { width:60px; height:60px; object-fit:contain; background:#fff; border-radius:6px; padding:4px; }
    @media (max-width:600px) { .st-row { grid-template-columns:1fr; } }
</style>

<form method="POST" enctype="multipart/form-data">

    <div class="st-card">
        <h3>🏢 Profil Bisnis</h3>
        <div class="st-field">
            <label>Nama Bisnis</label>
            <input type="text" name="nama_bisnis" value="<?= e(setting('nama_bisnis', APP_NAME)) ?>">
        </div>
        <div class="st-field">
            <label>Logo</label>
            <input type="file" name="logo" accept="image/*">
            <?php if ($logo = setting('logo')): ?>
                <div class="st-logo-prev">
                    <img src="<?= UPLOAD_URL . '/' . e($logo) ?>" alt="logo">
                    <span style="font-size:12px; color:#64748b;">Logo saat ini — upload baru untuk ganti</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="st-row">
            <div class="st-field">
                <label>Kontak Admin</label>
                <input type="text" name="kontak_admin" value="<?= e(setting('kontak_admin')) ?>" placeholder="08xxx / email">
            </div>
            <div class="st-field">
                <label>Durasi Expired Default (jam)</label>
                <input type="number" name="durasi_expired_default" min="1" value="<?= e(setting('durasi_expired_default', '24')) ?>">
            </div>
        </div>
        <div class="st-field">
            <label>Alamat</label>
            <textarea name="alamat" rows="2"><?= e(setting('alamat')) ?></textarea>
        </div>
        <div class="st-field">
            <label>Footer Text</label>
            <textarea name="footer_text" rows="2"><?= e(setting('footer_text')) ?></textarea>
        </div>
    </div>

    <div class="st-card">
        <h3>🧾 Format Tagihan</h3>
        <div class="st-row">
            <div class="st-field">
                <label>Format Invoice Number</label>
                <input type="text" name="format_invoice_number" value="<?= e(setting('format_invoice_number', 'INV-{YYYYMMDD}-{0001}')) ?>">
                <small>Chip: {YYYYMMDD}, {0001}</small>
            </div>
            <div class="st-field">
                <label>Digit Kode Unik</label>
                <input type="number" name="kode_unik_digit" min="1" max="5" value="<?= e(setting('kode_unik_digit', '3')) ?>">
            </div>
        </div>
    </div>

    <div class="st-card">
        <h3>🔒 Ganti Password</h3>
        <div class="st-row">
            <div class="st-field">
                <label>Password Lama</label>
                <input type="password" name="pw_lama" autocomplete="current-password">
            </div>
            <div class="st-field">
                <label>Password Baru</label>
                <input type="password" name="pw_baru" autocomplete="new-password">
                <small>Minimal 6 karakter. Kosongin kalau tidak ganti.</small>
            </div>
        </div>
    </div>

    <div style="display:flex; gap:10px; max-width:720px;">
        <button type="submit" class="btn">💾 Simpan Semua</button>
        <a href="<?= url('dashboard') ?>" class="btn btn-outline">Batal</a>
    </div>

</form>

<?php render_footer(); ?>