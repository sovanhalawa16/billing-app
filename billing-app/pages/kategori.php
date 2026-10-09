<?php
$title = 'Kategori Tagihan';
$active = 'kategori';

// ============ ICON HELPERS (local, self-contained) ============
function kt_icon($name, $size = 20) {
    $icons = [
        'tag'    => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
        'plus'   => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
        'edit'   => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>',
        'trash'  => '<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
        'check'  => '<polyline points="20 6 9 17 4 12"/>',
        'x'      => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'file'   => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
        'list'   => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
        'folder' => '<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; display:inline-block; vertical-align:middle;">'.$path.'</svg>';
}

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

// ============ HANDLE POST (SAVE only) ============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['post_action'] ?? '') === 'save') {
    $eid    = (int)($_POST['id'] ?? 0);
    $nama   = trim($_POST['nama'] ?? '');
    $prefix = strtoupper(trim($_POST['kode_prefix'] ?? ''));
    $desk   = trim($_POST['deskripsi'] ?? '');
    $aktif  = isset($_POST['aktif']) ? 1 : 0;

    $errors = [];
    if ($nama === '') $errors[] = 'Nama wajib diisi.';
    if ($prefix === '') $errors[] = 'Prefix wajib diisi.';
    if (strlen($prefix) > 10) $errors[] = 'Prefix maksimal 10 karakter.';

    if (!$errors) {
        $sql = "SELECT COUNT(*) FROM categories WHERE kode_prefix = ?";
        $p = [$prefix];
        if ($eid) { $sql .= " AND id != ?"; $p[] = $eid; }
        $cek = $pdo->prepare($sql);
        $cek->execute($p);
        if ($cek->fetchColumn() > 0) $errors[] = 'Prefix sudah dipakai kategori lain.';
    }

    if ($errors) {
        flash('error', implode(' ', $errors));
        $_SESSION['old_form'] = $_POST;
        redirect('/?url=kategori&action=' . ($eid ? "edit&id=$eid" : 'create'));
    }

    if ($eid) {
        $pdo->prepare("UPDATE categories SET nama=?, kode_prefix=?, deskripsi=?, aktif=? WHERE id=?")
            ->execute([$nama, $prefix, $desk, $aktif, $eid]);
        flash('success', 'Kategori berhasil diupdate.');
    } else {
        $pdo->prepare("INSERT INTO categories (nama, kode_prefix, deskripsi, aktif) VALUES (?,?,?,?)")
            ->execute([$nama, $prefix, $desk, $aktif]);
        flash('success', 'Kategori berhasil ditambahkan.');
    }
    redirect('/?url=kategori');
}

// ============ EDIT DATA ============
$edit = null;
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $edit = $stmt->fetch();
    if (!$edit) {
        flash('error', 'Kategori tidak ditemukan.');
        redirect('/?url=kategori');
    }
}

$old = $_SESSION['old_form'] ?? [];
unset($_SESSION['old_form']);

$stats_awal = [
    'all'      => (int)$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
    'aktif'    => (int)$pdo->query("SELECT COUNT(*) FROM categories WHERE aktif=1")->fetchColumn(),
    'nonaktif' => (int)$pdo->query("SELECT COUNT(*) FROM categories WHERE aktif=0")->fetchColumn(),
];

render_header($title, $active);
?>

<style>
    .kt-wrap { max-width: 1100px; }

    .kt-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:18px; gap:14px; flex-wrap:wrap; }
    .kt-head h2 { font-size:20px; font-weight:800; color:#0f172a; }
    .kt-head p { color:#64748b; font-size:13px; margin-top:4px; }

    /* Stats tabs */
    .kt-stats { display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap; }
    .kt-stat {
        display:flex; align-items:center; gap:8px;
        padding:9px 14px; background:#fff; border-radius:10px;
        font-size:13px; font-weight:600; color:#64748b; cursor:pointer;
        border:1.5px solid #f1f5f9; transition:.15s;
    }
    .kt-stat:hover { border-color:#c7d2fe; color:#4f46e5; }
    .kt-stat.active { background:#0f172a; color:#fff; border-color:#0f172a; }
    .kt-stat .ic { display:inline-flex; align-items:center; }
    .kt-stat .cnt {
        background:#f1f5f9; color:#475569;
        padding:2px 8px; border-radius:10px; font-size:11px; font-weight:700;
    }
    .kt-stat.active .cnt { background:rgba(255,255,255,0.2); color:#fff; }

    /* Search bar */
    .kt-search { display:flex; gap:8px; margin-bottom:16px; position:relative; }
    .kt-search input {
        flex:1; padding:11px 16px 11px 42px; border:1.5px solid #e2e8f0;
        border-radius:10px; font-size:14px; background:#fff;
    }
    .kt-search input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }
    .kt-search .ic {
        position:absolute; left:14px; top:50%; transform:translateY(-50%);
        color:#94a3b8; pointer-events:none; display:flex; align-items:center;
    }
    .kt-search .clear {
        position:absolute; right:10px; top:50%; transform:translateY(-50%);
        background:#f1f5f9; border:none; width:24px; height:24px; border-radius:50%;
        cursor:pointer; color:#64748b; display:none; align-items:center; justify-content:center;
    }
    .kt-search .clear.show { display:flex; }
    .kt-search .clear:hover { background:#e2e8f0; color:#334155; }

    /* Card list */
    .kt-list { display:flex; flex-direction:column; gap:10px; min-height:120px; transition:opacity .2s; }
    .kt-list.loading { opacity:.4; pointer-events:none; }

    .kt-item {
        background:#fff; border-radius:12px; padding:16px 18px;
        box-shadow:0 1px 3px rgba(0,0,0,0.04); border:1px solid #f1f5f9;
        display:flex; align-items:center; gap:16px; transition:.15s;
        animation: ktFade .25s ease;
    }
    @keyframes ktFade { from { opacity:0; transform:translateY(4px);} to { opacity:1; transform:none; } }
    .kt-item:hover { border-color:#e0e7ff; box-shadow:0 4px 14px rgba(99,102,241,0.06); }
    .kt-item.inactive { opacity:.65; }

    .kt-icon {
        width:48px; height:48px; border-radius:11px;
        background:linear-gradient(135deg,#eef2ff,#e0e7ff); color:#6366f1;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .kt-item.inactive .kt-icon { background:#f1f5f9; color:#94a3b8; }

    .kt-body { flex:1; min-width:0; }
    .kt-nama { font-size:15px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:4px; }
    .kt-prefix {
        background:#eef2ff; color:#4f46e5; padding:3px 9px;
        border-radius:5px; font-family:'Courier New', monospace;
        font-size:11px; font-weight:700; letter-spacing:.5px;
    }
    .kt-badge-off {
        background:#f1f5f9; color:#94a3b8; padding:3px 9px;
        border-radius:5px; font-size:10px; font-weight:700; text-transform:uppercase;
    }
    .kt-desc { color:#64748b; font-size:13px; line-height:1.5; }
    .kt-meta { display:flex; align-items:center; gap:12px; margin-top:6px; font-size:12px; color:#94a3b8; }
    .kt-meta .m-item { display:inline-flex; align-items:center; gap:4px; }

    /* Action buttons */
    .kt-btns { display:flex; gap:6px; flex-shrink:0; }
    .kt-btn {
        width:36px; height:36px; border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        border:1.5px solid #e2e8f0; background:#fff; cursor:pointer;
        transition:.15s; padding:0; text-decoration:none; color:#64748b;
    }
    .kt-btn:hover { transform:translateY(-1px); }
    .kt-btn.toggle-on { color:#10b981; border-color:#bbf7d0; background:#f0fdf4; }
    .kt-btn.toggle-on:hover { background:#dcfce7; }
    .kt-btn.toggle-off { color:#94a3b8; }
    .kt-btn.toggle-off:hover { color:#10b981; border-color:#bbf7d0; }
    .kt-btn.edit { color:#6366f1; border-color:#e0e7ff; }
    .kt-btn.edit:hover { background:#eef2ff; }
    .kt-btn.del { color:#ef4444; border-color:#fecaca; }
    .kt-btn.del:hover { background:#fef2f2; }

    /* Empty */
    .kt-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:12px; border:1px solid #f1f5f9; }
    .kt-empty .ic {
        width:72px; height:72px; border-radius:50%;
        background:#eef2ff; color:#6366f1;
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 16px;
    }
    .kt-empty h3 { font-size:16px; font-weight:700; color:#0f172a; margin-bottom:6px; }
    .kt-empty p { color:#94a3b8; font-size:13px; margin-bottom:18px; }

    /* Form card */
    .kt-form-card {
        background:#fff; border-radius:14px; padding:26px;
        box-shadow:0 1px 3px rgba(0,0,0,0.04); border:1px solid #f1f5f9;
        max-width:640px;
    }
    .kt-form-hd { display:flex; align-items:center; gap:12px; margin-bottom:22px; padding-bottom:16px; border-bottom:1px solid #f1f5f9; }
    .kt-form-hd .ic {
        width:42px; height:42px; border-radius:11px;
        background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff;
        display:flex; align-items:center; justify-content:center;
    }
    .kt-form-hd h2 { font-size:16px; font-weight:700; color:#0f172a; }
    .kt-form-hd p { font-size:12px; color:#94a3b8; margin-top:2px; }

    .kt-field { margin-bottom:18px; }
    .kt-field label { display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px; }
    .kt-field .req { color:#ef4444; }
    .kt-field input[type=text], .kt-field textarea {
        width:100%; padding:11px 14px; border:1.5px solid #e2e8f0;
        border-radius:10px; font-size:14px; font-family:inherit; background:#fff;
    }
    .kt-field input:focus, .kt-field textarea:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }
    .kt-field .prefix-input { text-transform:uppercase; font-family:'Courier New', monospace; font-weight:700; letter-spacing:1.5px; font-size:15px; }
    .kt-field small { display:block; color:#94a3b8; font-size:12px; margin-top:6px; }

    .kt-toggle {
        display:flex; align-items:center; gap:10px;
        padding:12px 14px; background:#f8fafc;
        border:1.5px solid #e2e8f0; border-radius:10px; cursor:pointer;
    }
    .kt-toggle input { width:18px; height:18px; accent-color:#6366f1; }
    .kt-toggle span { font-size:14px; color:#334155; font-weight:500; }

    .kt-form-actions { display:flex; gap:10px; margin-top:24px; padding-top:20px; border-top:1px solid #f1f5f9; }

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

    @media (max-width:640px) {
        .kt-item { padding:14px; gap:12px; flex-wrap:wrap; }
        .kt-icon { width:42px; height:42px; }
        .kt-btns { margin-left:auto; }
        .kt-btn { width:34px; height:34px; }
        .kt-form-card { padding:18px; }
        .toast-wrap { top:10px; right:10px; left:10px; }
    }
</style>

<div class="toast-wrap" id="toastWrap"></div>

<div class="kt-wrap">

<?php if ($action === 'create' || ($action === 'edit' && $edit)): ?>

    <!-- ============ FORM ============ -->
    <?php $r = $old ?: ($edit ?: ['id'=>0,'nama'=>'','kode_prefix'=>'','deskripsi'=>'','aktif'=>1]); ?>

    <div class="kt-form-card">
        <div class="kt-form-hd">
            <div class="ic"><?= $edit ? kt_icon('edit', 20) : kt_icon('plus', 22) ?></div>
            <div>
                <h2><?= $edit ? 'Edit Kategori' : 'Tambah Kategori' ?></h2>
                <p><?= $edit ? 'Ubah detail kategori' : 'Buat kategori baru untuk tagihan' ?></p>
            </div>
        </div>

        <form method="POST">
            <input type="hidden" name="post_action" value="save">
            <input type="hidden" name="id" value="<?= (int)($r['id'] ?? 0) ?>">

            <div class="kt-field">
                <label>Nama Kategori <span class="req">*</span></label>
                <input type="text" name="nama" required maxlength="100"
                       value="<?= e($r['nama'] ?? '') ?>"
                       placeholder="misal: Iuran Bulanan">
            </div>

            <div class="kt-field">
                <label>Kode Prefix <span class="req">*</span></label>
                <input type="text" name="kode_prefix" class="prefix-input" required maxlength="10"
                       value="<?= e($r['kode_prefix'] ?? '') ?>"
                       placeholder="IUR">
                <small>Awalan nomor invoice. Contoh: <strong>IUR-20261007-0001</strong></small>
            </div>

            <div class="kt-field">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          placeholder="Keterangan kategori (opsional)"><?= e($r['deskripsi'] ?? '') ?></textarea>
            </div>

            <div class="kt-field">
                <label class="kt-toggle">
                    <input type="checkbox" name="aktif" value="1" <?= ($r['aktif'] ?? 1) ? 'checked' : '' ?>>
                    <span>Aktifkan kategori ini</span>
                </label>
            </div>

            <div class="kt-form-actions">
                <button type="submit" class="btn">
                    <?= kt_icon('check', 16) ?> Simpan
                </button>
                <a href="<?= url('kategori') ?>" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>

<?php else: ?>

    <!-- ============ LIST (REALTIME) ============ -->
    <div class="kt-head">
        <div>
            <h2>Daftar Kategori</h2>
            <p>Kelola kategori untuk pengelompokan tagihan</p>
        </div>
        <a href="<?= url('kategori&action=create') ?>" class="btn">
            <?= kt_icon('plus', 16) ?> Tambah Kategori
        </a>
    </div>

    <!-- Stats tabs -->
    <div class="kt-stats" id="statsTabs">
        <div class="kt-stat active" data-f="all">
            <span class="ic"><?= kt_icon('list', 14) ?></span> Semua
            <span class="cnt" id="cnt-all"><?= $stats_awal['all'] ?></span>
        </div>
        <div class="kt-stat" data-f="aktif">
            <span class="ic"><?= kt_icon('check', 14) ?></span> Aktif
            <span class="cnt" id="cnt-aktif"><?= $stats_awal['aktif'] ?></span>
        </div>
        <div class="kt-stat" data-f="nonaktif">
            <span class="ic"><?= kt_icon('x', 14) ?></span> Nonaktif
            <span class="cnt" id="cnt-nonaktif"><?= $stats_awal['nonaktif'] ?></span>
        </div>
    </div>

    <!-- Search -->
    <div class="kt-search">
        <span class="ic"><?= kt_icon('search', 18) ?></span>
        <input type="text" id="searchInput" placeholder="Cari nama kategori atau prefix..." autocomplete="off">
        <button type="button" class="clear" id="clearSearch" title="Hapus"><?= kt_icon('x', 12) ?></button>
    </div>

    <!-- List container -->
    <div class="kt-list" id="ktList">
        <div style="text-align:center; padding:40px; color:#94a3b8; font-size:13px;">
            Memuat data...
        </div>
    </div>

<?php endif; ?>

</div>

<script>
// Icon SVG strings (buat render di JS)
const ICONS = {
    tag:    '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',
    check:  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
    x:      '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
    edit:   '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
    trash:  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>',
    file:   '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>',
    folder: '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>',
    eyeOn:  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
    eyeOff: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>',
};

let state = { q: '', f: 'all', loading: false };
let searchTimer = null;

const API_LIST   = '<?= BASE_URL ?>/?url=api/kategori-list';
const API_ACTION = '<?= BASE_URL ?>/?url=api/kategori-action';

// ============ TOAST ============
function showToast(msg, type = 'success') {
    const wrap = document.getElementById('toastWrap');
    if (!wrap) return;
    const el = document.createElement('div');
    el.className = 'toast ' + type;
    const iconSvg = type === 'success' ? ICONS.check : type === 'error' ? ICONS.x : ICONS.file;
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
    const list = document.getElementById('ktList');
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
    const list = document.getElementById('ktList');
    if (!list) return;

    if (!rows.length) {
        const isFiltered = state.q || state.f !== 'all';
        list.innerHTML = `
            <div class="kt-empty">
                <div class="ic">${ICONS.folder}</div>
                <h3>${isFiltered ? 'Tidak ditemukan' : 'Belum ada kategori'}</h3>
                <p>${isFiltered ? 'Coba kata kunci lain atau reset filter.' : 'Mulai dengan bikin kategori pertama lo.'}</p>
                ${!isFiltered ? '<a href="<?= url('kategori&action=create') ?>" class="btn">+ Buat Kategori Pertama</a>' : ''}
            </div>
        `;
        return;
    }

    let html = '';
    rows.forEach(r => {
        const isActive = r.aktif == 1;
        const toggleIcon = isActive ? ICONS.eyeOn : ICONS.eyeOff;
        html += `
            <div class="kt-item ${isActive ? '' : 'inactive'}" data-id="${r.id}">
                <div class="kt-icon">${ICONS.tag}</div>

                <div class="kt-body">
                    <div class="kt-nama">
                        ${escHtml(r.nama)}
                        <span class="kt-prefix">${escHtml(r.kode_prefix)}</span>
                        ${!isActive ? '<span class="kt-badge-off">Nonaktif</span>' : ''}
                    </div>
                    <div class="kt-desc">${escHtml(r.deskripsi || 'Tanpa deskripsi')}</div>
                    <div class="kt-meta">
                        <span class="m-item">${ICONS.file} ${r.jml_tagihan} tagihan</span>
                    </div>
                </div>

                <div class="kt-btns">
                    <button type="button" class="kt-btn toggle-btn ${isActive ? 'toggle-on' : 'toggle-off'}"
                            title="${isActive ? 'Nonaktifkan' : 'Aktifkan'}"
                            onclick="toggleAktif(${r.id}, this)">
                        ${toggleIcon}
                    </button>
                    <a href="<?= url('kategori&action=edit&id=') ?>${r.id}" class="kt-btn edit" title="Edit">
                        ${ICONS.edit}
                    </a>
                    <button type="button" class="kt-btn del" title="Hapus"
                            onclick='hapusKategori(${r.id}, ${JSON.stringify(r.nama)})'>
                        ${ICONS.trash}
                    </button>
                </div>
            </div>
        `;
    });
    list.innerHTML = html;
}

function updateStats(stats) {
    const el = (id) => document.getElementById(id);
    if (el('cnt-all'))      el('cnt-all').textContent = stats.all;
    if (el('cnt-aktif'))    el('cnt-aktif').textContent = stats.aktif;
    if (el('cnt-nonaktif')) el('cnt-nonaktif').textContent = stats.nonaktif;
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
async function hapusKategori(id, nama) {
    if (!confirm('Hapus kategori "' + nama + '"?\n\nKalau masih dipakai di tagihan, gak bisa dihapus.')) return;
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
document.querySelectorAll('#statsTabs .kt-stat').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('#statsTabs .kt-stat').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        state.f = this.dataset.f;
        fetchList();
    });
});

// ============ INIT ============
if (document.getElementById('ktList')) {
    fetchList();
}

setInterval(() => {
    if (document.getElementById('ktList') && !state.loading && !state.q) {
        fetchList();
    }
}, 60000);
</script>

<?php render_footer(); ?>