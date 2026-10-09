<?php
$title = 'Metode Pembayaran';
$active = 'metode';

// ============ ICON SVG LOCAL ============
function mt_icon($name, $size = 20) {
    $icons = [
        'card'    => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        'plus'    => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
        'edit'    => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>',
        'trash'   => '<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
        'check'   => '<polyline points="20 6 9 17 4 12"/>',
        'x'       => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'search'  => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'eyeOn'   => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'eyeOff'  => '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>',
        'list'    => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
        'qris'    => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="3" height="3"/><line x1="21" y1="14" x2="21" y2="17"/><line x1="14" y1="21" x2="17" y2="21"/><line x1="21" y1="21" x2="21" y2="21"/>',
        'bank'    => '<path d="M3 21h18"/><path d="M5 21V10l7-5 7 5v11"/><path d="M9 21v-6h6v6"/>',
        'wallet'  => '<path d="M20 12V8H6a2 2 0 0 1 0-4h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/>',
        'folder'  => '<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>',
        'image'   => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; display:inline-block; vertical-align:middle;">'.$path.'</svg>';
}

// ============ UPLOAD HELPER ============
function upload_gambar($file, $subfolder) {
    if (empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) return [null, null];

    $allowed = ['image/jpeg','image/png','image/jpg','image/webp','image/svg+xml'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowed)) return [null, 'Format gambar harus JPG, PNG, WEBP, atau SVG.'];
    if ($file['size'] > 2 * 1024 * 1024) return [null, 'Ukuran gambar maksimal 2 MB.'];

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

    $dir = UPLOAD_PATH . '/' . $subfolder;
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) {
        return [null, 'Gagal menyimpan file.'];
    }
    return [$subfolder . '/' . $filename, null];
}

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

// ============ HANDLE POST (SAVE only) ============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['post_action'] ?? '') === 'save') {
    $eid       = (int)($_POST['id'] ?? 0);
    $nama      = trim($_POST['nama'] ?? '');
    $jenis     = $_POST['jenis'] ?? 'bank';
    $nomor     = trim($_POST['nomor'] ?? '');
    $pemilik   = trim($_POST['nama_pemilik'] ?? '');
    $provider  = trim($_POST['provider'] ?? '');
    $instruksi = trim($_POST['instruksi'] ?? '');
    $urutan    = (int)($_POST['urutan'] ?? 0);
    $aktif     = isset($_POST['aktif']) ? 1 : 0;

    $old = ['logo' => null, 'gambar_qris' => null];
    if ($eid) {
        $stmt = $pdo->prepare("SELECT logo, gambar_qris FROM payment_methods WHERE id = ?");
        $stmt->execute([$eid]);
        $old = $stmt->fetch() ?: $old;
    }

    $errors = [];
    if ($nama === '') $errors[] = 'Nama metode wajib diisi.';
    if (!in_array($jenis, ['qris','bank','ewallet','custom'])) $errors[] = 'Jenis tidak valid.';

    // Upload logo
    $logo = $old['logo'];
    if (!empty($_FILES['logo']['name'])) {
        list($newlogo, $err) = upload_gambar($_FILES['logo'], 'logo');
        if ($err) $errors[] = 'Logo: ' . $err;
        elseif ($newlogo) {
            if ($old['logo'] && file_exists(UPLOAD_PATH . '/' . $old['logo'])) @unlink(UPLOAD_PATH . '/' . $old['logo']);
            $logo = $newlogo;
        }
    }

    // Upload QRIS
    $gambar_qris = $old['gambar_qris'];
    if ($jenis === 'qris' && !empty($_FILES['gambar_qris']['name'])) {
        list($newqr, $err) = upload_gambar($_FILES['gambar_qris'], 'qris');
        if ($err) $errors[] = 'QRIS: ' . $err;
        elseif ($newqr) {
            if ($old['gambar_qris'] && file_exists(UPLOAD_PATH . '/' . $old['gambar_qris'])) @unlink(UPLOAD_PATH . '/' . $old['gambar_qris']);
            $gambar_qris = $newqr;
        }
    }

    if ($errors) {
        flash('error', implode(' ', $errors));
        $_SESSION['old_form'] = $_POST;
        redirect('/?url=metode&action=' . ($eid ? "edit&id=$eid" : 'create'));
    }

    if ($eid) {
        $pdo->prepare("UPDATE payment_methods SET nama=?, jenis=?, logo=?, nomor=?, nama_pemilik=?, provider=?, gambar_qris=?, instruksi=?, urutan=?, aktif=? WHERE id=?")
            ->execute([$nama, $jenis, $logo, $nomor, $pemilik, $provider, $gambar_qris, $instruksi, $urutan, $aktif, $eid]);
        flash('success', 'Metode berhasil diupdate.');
    } else {
        $pdo->prepare("INSERT INTO payment_methods (nama, jenis, logo, nomor, nama_pemilik, provider, gambar_qris, instruksi, urutan, aktif) VALUES (?,?,?,?,?,?,?,?,?,?)")
            ->execute([$nama, $jenis, $logo, $nomor, $pemilik, $provider, $gambar_qris, $instruksi, $urutan, $aktif]);
        flash('success', 'Metode berhasil ditambahkan.');
    }
    redirect('/?url=metode');
}

// ============ EDIT DATA ============
$edit = null;
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM payment_methods WHERE id = ?");
    $stmt->execute([$id]);
    $edit = $stmt->fetch();
    if (!$edit) {
        flash('error', 'Metode tidak ditemukan.');
        redirect('/?url=metode');
    }
}

$old_form = $_SESSION['old_form'] ?? [];
unset($_SESSION['old_form']);

$stats_awal = [
    'all'      => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods")->fetchColumn(),
    'qris'     => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE jenis='qris'")->fetchColumn(),
    'bank'     => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE jenis='bank'")->fetchColumn(),
    'ewallet'  => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE jenis='ewallet'")->fetchColumn(),
    'custom'   => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE jenis='custom'")->fetchColumn(),
    'aktif'    => (int)$pdo->query("SELECT COUNT(*) FROM payment_methods WHERE aktif=1")->fetchColumn(),
];

render_header($title, $active);
?>

<style>
    .mt-wrap { max-width: 1100px; }

    .mt-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:18px; gap:14px; flex-wrap:wrap; }
    .mt-head h2 { font-size:20px; font-weight:800; color:#0f172a; }
    .mt-head p { color:#64748b; font-size:13px; margin-top:4px; }

    /* Stats tabs */
    .mt-stats { display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap; }
    .mt-stat {
        display:flex; align-items:center; gap:8px;
        padding:9px 14px; background:#fff; border-radius:10px;
        font-size:13px; font-weight:600; color:#64748b; cursor:pointer;
        border:1.5px solid #f1f5f9; transition:.15s;
    }
    .mt-stat:hover { border-color:#c7d2fe; color:#4f46e5; }
    .mt-stat.active { background:#0f172a; color:#fff; border-color:#0f172a; }
    .mt-stat .ic { display:inline-flex; align-items:center; }
    .mt-stat .cnt {
        background:#f1f5f9; color:#475569;
        padding:2px 8px; border-radius:10px; font-size:11px; font-weight:700;
    }
    .mt-stat.active .cnt { background:rgba(255,255,255,0.2); color:#fff; }

    /* Search */
    .mt-search { display:flex; gap:8px; margin-bottom:16px; position:relative; }
    .mt-search input {
        flex:1; padding:11px 16px 11px 42px; border:1.5px solid #e2e8f0;
        border-radius:10px; font-size:14px; background:#fff;
    }
    .mt-search input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }
    .mt-search .ic { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; display:flex; align-items:center; }
    .mt-search .clear {
        position:absolute; right:10px; top:50%; transform:translateY(-50%);
        background:#f1f5f9; border:none; width:24px; height:24px; border-radius:50%;
        cursor:pointer; color:#64748b; display:none; align-items:center; justify-content:center;
    }
    .mt-search .clear.show { display:flex; }
    .mt-search .clear:hover { background:#e2e8f0; }

    /* List */
    .mt-list { display:flex; flex-direction:column; gap:10px; min-height:120px; transition:opacity .2s; }
    .mt-list.loading { opacity:.4; pointer-events:none; }

    .mt-item {
        background:#fff; border-radius:12px; padding:16px 18px;
        box-shadow:0 1px 3px rgba(0,0,0,0.04); border:1px solid #f1f5f9;
        display:flex; align-items:center; gap:16px; transition:.15s;
        border-left:4px solid #e2e8f0;
        animation: mtFade .25s ease;
    }
    @keyframes mtFade { from { opacity:0; transform:translateY(4px);} to { opacity:1; transform:none; } }
    .mt-item:hover { border-color:#e0e7ff; box-shadow:0 4px 14px rgba(99,102,241,0.06); }
    .mt-item.active { border-left-color:#10b981; }
    .mt-item.inactive { border-left-color:#cbd5e1; opacity:.7; }

    .mt-icon {
        width:54px; height:54px; border-radius:11px;
        background:#f1f5f9; color:#64748b;
        display:flex; align-items:center; justify-content:center;
        overflow:hidden; flex-shrink:0;
    }
    .mt-icon img { width:100%; height:100%; object-fit:contain; padding:6px; }

    .mt-body { flex:1; min-width:0; }
    .mt-nama { font-weight:700; font-size:15px; margin-bottom:3px; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .mt-desc { color:#64748b; font-size:13px; word-break:break-word; line-height:1.5; }
    .mt-meta { font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; font-weight:600; margin-top:4px; }

    .type-pill { padding:3px 9px; border-radius:5px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; }
    .type-qris { background:#dbeafe; color:#1e40af; }
    .type-bank { background:#fef3c7; color:#92400e; }
    .type-ewallet { background:#e0e7ff; color:#3730a3; }
    .type-custom { background:#f1f5f9; color:#475569; }

    .mt-btns { display:flex; gap:6px; flex-shrink:0; }
    .mt-btn {
        width:36px; height:36px; border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        border:1.5px solid #e2e8f0; background:#fff; cursor:pointer;
        transition:.15s; padding:0; text-decoration:none; color:#64748b;
    }
    .mt-btn:hover { transform:translateY(-1px); }
    .mt-btn.toggle-on { color:#10b981; border-color:#bbf7d0; background:#f0fdf4; }
    .mt-btn.toggle-on:hover { background:#dcfce7; }
    .mt-btn.toggle-off { color:#94a3b8; }
    .mt-btn.toggle-off:hover { color:#10b981; border-color:#bbf7d0; }
    .mt-btn.edit { color:#6366f1; border-color:#e0e7ff; }
    .mt-btn.edit:hover { background:#eef2ff; }
    .mt-btn.del { color:#ef4444; border-color:#fecaca; }
    .mt-btn.del:hover { background:#fef2f2; }

    /* Empty */
    .mt-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:12px; border:1px solid #f1f5f9; }
    .mt-empty .ic {
        width:72px; height:72px; border-radius:50%;
        background:#eef2ff; color:#6366f1;
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 16px;
    }
    .mt-empty h3 { font-size:16px; font-weight:700; color:#0f172a; margin-bottom:6px; }
    .mt-empty p { color:#94a3b8; font-size:13px; margin-bottom:18px; }

    /* Form card */
    .mt-form-card {
        background:#fff; border-radius:14px; padding:26px;
        box-shadow:0 1px 3px rgba(0,0,0,0.04); border:1px solid #f1f5f9;
        max-width:720px;
    }
    .mt-form-hd { display:flex; align-items:center; gap:12px; margin-bottom:22px; padding-bottom:16px; border-bottom:1px solid #f1f5f9; }
    .mt-form-hd .ic {
        width:42px; height:42px; border-radius:11px;
        background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff;
        display:flex; align-items:center; justify-content:center;
    }
    .mt-form-hd h2 { font-size:16px; font-weight:700; color:#0f172a; }
    .mt-form-hd p { font-size:12px; color:#94a3b8; margin-top:2px; }

    .mt-field { margin-bottom:18px; }
    .mt-field label { display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px; }
    .mt-field .req { color:#ef4444; }
    .mt-field input[type=text], .mt-field input[type=number], .mt-field input[type=file],
    .mt-field select, .mt-field textarea {
        width:100%; padding:11px 14px; border:1.5px solid #e2e8f0;
        border-radius:10px; font-size:14px; font-family:inherit; background:#fff;
    }
    .mt-field input:focus, .mt-field select:focus, .mt-field textarea:focus {
        outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12);
    }
    .mt-field small { display:block; color:#94a3b8; font-size:12px; margin-top:6px; }
    .mt-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

    .mt-preview {
        margin-top:10px; padding:12px;
        background:#f8fafc; border-radius:10px;
        border:1.5px dashed #e2e8f0;
        display:flex; align-items:center; gap:12px;
    }
    .mt-preview img {
        width:64px; height:64px; object-fit:contain;
        border-radius:8px; background:#fff; padding:6px;
        border:1px solid #e2e8f0;
    }
    .mt-preview .txt { font-size:12px; color:#64748b; line-height:1.5; }

    .mt-toggle {
        display:flex; align-items:center; gap:10px;
        padding:12px 14px; background:#f8fafc;
        border:1.5px solid #e2e8f0; border-radius:10px; cursor:pointer;
    }
    .mt-toggle input { width:18px; height:18px; accent-color:#6366f1; }
    .mt-toggle span { font-size:14px; color:#334155; font-weight:500; }

    .mt-actions { display:flex; gap:10px; margin-top:24px; padding-top:20px; border-top:1px solid #f1f5f9; }

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

    @media (max-width:768px) {
        .mt-item { padding:14px; gap:12px; flex-wrap:wrap; }
        .mt-icon { width:48px; height:48px; }
        .mt-btns { margin-left:auto; }
        .mt-btn { width:34px; height:34px; }
        .mt-form-card { padding:18px; }
        .mt-row { grid-template-columns:1fr; }
        .toast-wrap { top:10px; right:10px; left:10px; }
    }
</style>

<div class="toast-wrap" id="toastWrap"></div>

<div class="mt-wrap">

<?php if ($action === 'create' || ($action === 'edit' && $edit)): ?>

    <!-- ============ FORM ============ -->
    <?php
    $r = $old_form ?: ($edit ?: [
        'id'=>0,'nama'=>'','jenis'=>'bank','logo'=>null,'nomor'=>'',
        'nama_pemilik'=>'','provider'=>'','gambar_qris'=>null,
        'instruksi'=>'','urutan'=>0,'aktif'=>1
    ]);
    ?>

    <div class="mt-form-card">
        <div class="mt-form-hd">
            <div class="ic"><?= $edit ? mt_icon('edit', 20) : mt_icon('card', 22) ?></div>
            <div>
                <h2><?= $edit ? 'Edit Metode' : 'Tambah Metode' ?></h2>
                <p><?= $edit ? 'Ubah detail metode pembayaran' : 'Metode statis yang ditampilkan ke pembayar' ?></p>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="post_action" value="save">
            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">

            <div class="mt-field">
                <label>Nama Metode <span class="req">*</span></label>
                <input type="text" name="nama" required maxlength="100"
                       placeholder="misal: BCA, DANA, QRIS All Payment"
                       value="<?= e($r['nama']) ?>">
            </div>

            <div class="mt-row">
                <div class="mt-field">
                    <label>Jenis <span class="req">*</span></label>
                    <select name="jenis" required onchange="toggleJenis(this.value)">
                        <option value="qris" <?= $r['jenis']==='qris'?'selected':'' ?>>QRIS (Statis)</option>
                        <option value="bank" <?= $r['jenis']==='bank'?'selected':'' ?>>Transfer Bank</option>
                        <option value="ewallet" <?= $r['jenis']==='ewallet'?'selected':'' ?>>E-Wallet</option>
                        <option value="custom" <?= $r['jenis']==='custom'?'selected':'' ?>>Custom / Lainnya</option>
                    </select>
                </div>

                <div class="mt-field">
                    <label>Urutan Tampil</label>
                    <input type="number" name="urutan" min="0" value="<?= (int)$r['urutan'] ?>">
                    <small>Makin kecil = makin atas</small>
                </div>
            </div>

            <div class="mt-field">
                <label>Logo / Icon</label>
                <input type="file" name="logo" accept="image/*">
                <?php if ($r['logo'] && file_exists(UPLOAD_PATH . '/' . $r['logo'])): ?>
                    <div class="mt-preview">
                        <img src="<?= UPLOAD_URL . '/' . e($r['logo']) ?>" alt="logo">
                        <div class="txt"><strong>Logo saat ini</strong><br>Upload baru untuk ganti</div>
                    </div>
                <?php else: ?>
                    <small>Format: JPG, PNG, WEBP, SVG. Max 2 MB</small>
                <?php endif; ?>
            </div>

            <div id="fieldQRIS" style="display:<?= $r['jenis']==='qris'?'block':'none' ?>">
                <div class="mt-field">
                    <label>Gambar QRIS</label>
                    <input type="file" name="gambar_qris" accept="image/*">
                    <?php if ($r['gambar_qris'] && file_exists(UPLOAD_PATH . '/' . $r['gambar_qris'])): ?>
                        <div class="mt-preview">
                            <img src="<?= UPLOAD_URL . '/' . e($r['gambar_qris']) ?>" alt="qris">
                            <div class="txt"><strong>QRIS saat ini</strong><br>Upload baru untuk ganti</div>
                        </div>
                    <?php else: ?>
                        <small>Upload screenshot QRIS dari merchant / bank</small>
                    <?php endif; ?>
                </div>
            </div>

            <div id="fieldNomor">
                <div class="mt-row">
                    <div class="mt-field">
                        <label>Nomor / Rekening</label>
                        <input type="text" name="nomor" maxlength="100"
                               placeholder="misal: 1234567890 atau 0812xxxx"
                               value="<?= e($r['nomor']) ?>">
                    </div>

                    <div class="mt-field">
                        <label>Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" maxlength="100"
                               placeholder="misal: Budi Santoso"
                               value="<?= e($r['nama_pemilik']) ?>">
                    </div>
                </div>

                <div class="mt-field">
                    <label>Provider / Bank</label>
                    <input type="text" name="provider" maxlength="100"
                           placeholder="misal: BCA, DANA, OVO"
                           value="<?= e($r['provider']) ?>">
                </div>
            </div>

            <div class="mt-field">
                <label>Instruksi Tambahan</label>
                <textarea name="instruksi" rows="3"
                          placeholder="misal: Transfer sesuai nominal tepat, tanpa dibulatkan"><?= e($r['instruksi']) ?></textarea>
                <small>Akan tampil di halaman pembayaran user</small>
            </div>

            <div class="mt-field">
                <label class="mt-toggle">
                    <input type="checkbox" name="aktif" value="1" <?= ($r['aktif'] ?? 1) ? 'checked' : '' ?>>
                    <span>Aktifkan metode ini</span>
                </label>
            </div>

            <div class="mt-actions">
                <button type="submit" class="btn"><?= mt_icon('check', 16) ?> Simpan</button>
                <a href="<?= url('metode') ?>" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>

    <script>
    function toggleJenis(val) {
        document.getElementById('fieldQRIS').style.display = (val === 'qris') ? 'block' : 'none';
    }
    </script>

<?php else: ?>

    <!-- ============ LIST (REALTIME) ============ -->
    <div class="mt-head">
        <div>
            <h2>Metode Pembayaran</h2>
            <p>Kelola metode pembayaran statis untuk tagihan</p>
        </div>
        <a href="<?= url('metode&action=create') ?>" class="btn">
            <?= mt_icon('plus', 16) ?> Tambah Metode
        </a>
    </div>

    <!-- Stats tabs -->
    <div class="mt-stats" id="statsTabs">
        <div class="mt-stat active" data-f="all">
            <span class="ic"><?= mt_icon('list', 14) ?></span> Semua
            <span class="cnt" id="cnt-all"><?= $stats_awal['all'] ?></span>
        </div>
        <div class="mt-stat" data-f="qris">
            <span class="ic"><?= mt_icon('qris', 14) ?></span> QRIS
            <span class="cnt" id="cnt-qris"><?= $stats_awal['qris'] ?></span>
        </div>
        <div class="mt-stat" data-f="bank">
            <span class="ic"><?= mt_icon('bank', 14) ?></span> Bank
            <span class="cnt" id="cnt-bank"><?= $stats_awal['bank'] ?></span>
        </div>
        <div class="mt-stat" data-f="ewallet">
            <span class="ic"><?= mt_icon('wallet', 14) ?></span> E-Wallet
            <span class="cnt" id="cnt-ewallet"><?= $stats_awal['ewallet'] ?></span>
        </div>
        <div class="mt-stat" data-f="custom">
            <span class="ic"><?= mt_icon('card', 14) ?></span> Custom
            <span class="cnt" id="cnt-custom"><?= $stats_awal['custom'] ?></span>
        </div>
    </div>

    <!-- Search -->
    <div class="mt-search">
        <span class="ic"><?= mt_icon('search', 18) ?></span>
        <input type="text" id="searchInput" placeholder="Cari nama, provider, atau nomor..." autocomplete="off">
        <button type="button" class="clear" id="clearSearch" title="Hapus"><?= mt_icon('x', 12) ?></button>
    </div>

    <!-- List container -->
    <div class="mt-list" id="mtList">
        <div style="text-align:center; padding:40px; color:#94a3b8; font-size:13px;">Memuat data...</div>
    </div>

<?php endif; ?>

</div>

<script>
// ============ ICONS (untuk JS render) ============
const MT_ICONS = {
    qris:   '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="3" height="3"/><line x1="21" y1="14" x2="21" y2="17"/><line x1="14" y1="21" x2="17" y2="21"/></svg>',
    bank:   '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V10l7-5 7 5v11"/><path d="M9 21v-6h6v6"/></svg>',
    wallet: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8H6a2 2 0 0 1 0-4h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/></svg>',
    custom: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>',
    check:  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
    x:      '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
    edit:   '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
    trash:  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>',
    eyeOn:  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
    eyeOff: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>',
    folder: '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>',
};

let state = { q: '', f: 'all', loading: false };
let searchTimer = null;

const API_LIST   = '<?= BASE_URL ?>/?url=api/metode-list';
const API_ACTION = '<?= BASE_URL ?>/?url=api/metode-action';

// ============ TOAST ============
function showToast(msg, type = 'success') {
    const wrap = document.getElementById('toastWrap');
    if (!wrap) return;
    const el = document.createElement('div');
    el.className = 'toast ' + type;
    const iconSvg = type === 'success' ? MT_ICONS.check : MT_ICONS.x;
    el.innerHTML = iconSvg + ' <span>' + msg + '</span>';
    wrap.appendChild(el);
    setTimeout(() => {
        el.classList.add('hide');
        setTimeout(() => el.remove(), 300);
    }, 2600);
}

// ============ FETCH LIST ============
async function fetchList() {
    if (state.loading) return;
    state.loading = true;
    const list = document.getElementById('mtList');
    if (list) list.classList.add('loading');

    try {
        const url = API_LIST + '&q=' + encodeURIComponent(state.q) + '&f=' + state.f + '&t=' + Date.now();
        const res = await fetch(url);
        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Gagal memuat');
        renderList(data.rows);
        updateStats(data.stats);
    } catch (e) {
        console.error(e);
        showToast('Gagal memuat data', 'error');
    } finally {
        state.loading = false;
        if (list) list.classList.remove('loading');
    }
}

function escHtml(s) {
    if (s == null) return '';
    return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

// ============ RENDER ============
function renderList(rows) {
    const list = document.getElementById('mtList');
    if (!list) return;

    if (!rows.length) {
        const isFiltered = state.q || state.f !== 'all';
        list.innerHTML = `
            <div class="mt-empty">
                <div class="ic">${MT_ICONS.folder}</div>
                <h3>${isFiltered ? 'Tidak ditemukan' : 'Belum ada metode'}</h3>
                <p>${isFiltered ? 'Coba kata kunci lain atau reset filter.' : 'Tambahkan minimal 1 metode supaya user bisa bayar.'}</p>
                ${!isFiltered ? '<a href="<?= url('metode&action=create') ?>" class="btn">+ Tambah Metode</a>' : ''}
            </div>
        `;
        return;
    }

    const jenisLabel = { qris:'QRIS', bank:'Bank', ewallet:'E-Wallet', custom:'Custom' };
    const jenisIcon = { qris:MT_ICONS.qris, bank:MT_ICONS.bank, ewallet:MT_ICONS.wallet, custom:MT_ICONS.custom };

    let html = '';
    rows.forEach(r => {
        const isActive = r.aktif == 1;
        const toggleIcon = isActive ? MT_ICONS.eyeOn : MT_ICONS.eyeOff;
        const jl = jenisLabel[r.jenis] || 'Lain';
        const ji = jenisIcon[r.jenis] || MT_ICONS.custom;

        let detail = '';
        if (r.jenis === 'qris' && r.qris_url) {
            detail = 'QRIS merchant tersedia';
        } else if (r.nomor) {
            detail = escHtml(r.nomor) + (r.nama_pemilik ? ' — a.n. ' + escHtml(r.nama_pemilik) : '');
        } else if (r.instruksi) {
            detail = escHtml(r.instruksi.substring(0, 80)) + (r.instruksi.length > 80 ? '...' : '');
        } else {
            detail = '<em style="color:#cbd5e1;">Belum ada detail</em>';
        }

        const iconHtml = r.logo_url
            ? `<img src="${r.logo_url}" alt="logo">`
            : ji;

        html += `
            <div class="mt-item ${isActive ? 'active' : 'inactive'}" data-id="${r.id}">
                <div class="mt-icon">${iconHtml}</div>

                <div class="mt-body">
                    <div class="mt-nama">
                        ${escHtml(r.nama)}
                        <span class="type-pill type-${r.jenis}">${jl}</span>
                    </div>
                    <div class="mt-desc">${detail}</div>
                    ${r.provider ? `<div class="mt-meta">${escHtml(r.provider)}</div>` : ''}
                </div>

                <div class="mt-btns">
                    <button type="button" class="mt-btn toggle-btn ${isActive ? 'toggle-on' : 'toggle-off'}"
                            title="${isActive ? 'Nonaktifkan' : 'Aktifkan'}"
                            onclick="toggleAktif(${r.id}, this)">
                        ${toggleIcon}
                    </button>
                    <a href="<?= url('metode&action=edit&id=') ?>${r.id}" class="mt-btn edit" title="Edit">
                        ${MT_ICONS.edit}
                    </a>
                    <button type="button" class="mt-btn del" title="Hapus"
                            onclick='hapusMetode(${r.id}, ${JSON.stringify(r.nama)})'>
                        ${MT_ICONS.trash}
                    </button>
                </div>
            </div>
        `;
    });
    list.innerHTML = html;
}

function updateStats(stats) {
    const el = (id) => document.getElementById(id);
    ['all','qris','bank','ewallet','custom'].forEach(k => {
        if (el('cnt-' + k)) el('cnt-' + k).textContent = stats[k] || 0;
    });
}

// ============ TOGGLE ============
async function toggleAktif(id, btn) {
    btn.disabled = true;
    try {
        const fd = new FormData();
        fd.append('action', 'toggle');
        fd.append('id', id);
        const res = await fetch(API_ACTION, { method: 'POST', body: fd });
        const data = await res.json();
        if (!data.success) throw new Error(data.message);
        showToast(data.message, 'success');
        fetchList();
    } catch (e) {
        showToast(e.message || 'Gagal toggle', 'error');
        btn.disabled = false;
    }
}

// ============ HAPUS ============
async function hapusMetode(id, nama) {
    if (!confirm('Hapus metode "' + nama + '"?\n\nFile logo & QRIS akan dihapus permanen.')) return;
    try {
        const fd = new FormData();
        fd.append('action', 'delete');
        fd.append('id', id);
        const res = await fetch(API_ACTION, { method: 'POST', body: fd });
        const data = await res.json();
        if (!data.success) throw new Error(data.message);
        showToast(data.message, 'success');
        fetchList();
    } catch (e) {
        showToast(e.message || 'Gagal hapus', 'error');
    }
}

// ============ SEARCH ============
const searchInput = document.getElementById('searchInput');
const clearBtn = document.getElementById('clearSearch');

if (searchInput) {
    searchInput.addEventListener('input', function() {
        const val = this.value.trim();
        state.q = val;
        clearBtn.classList.toggle('show', val.length > 0);
        clearTimeout(searchTimer);
        searchTimer = setTimeout(fetchList, 300);
    });

    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        state.q = '';
        clearBtn.classList.remove('show');
        fetchList();
        searchInput.focus();
    });
}

// ============ FILTER TABS ============
document.querySelectorAll('#statsTabs .mt-stat').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('#statsTabs .mt-stat').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        state.f = this.dataset.f;
        fetchList();
    });
});

// ============ INIT ============
if (document.getElementById('mtList')) {
    fetchList();
}

setInterval(() => {
    if (document.getElementById('mtList') && !state.loading && !state.q) {
        fetchList();
    }
}, 60000);
</script>

<?php render_footer(); ?>