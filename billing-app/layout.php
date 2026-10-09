<?php

// Helper URL (biar gak perlu di config.php)
if (!function_exists('url')) {
    function url($path = '') {
        return BASE_URL . '/?url=' . ltrim($path, '/');
    }
}

// Ikon SVG inline
if (!function_exists('svg_icon')) {
    function svg_icon($name, $size = 20) {
        $icons = [
            'dashboard' => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>',
            'tag'       => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
            'card'      => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
            'file'      => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
            'plus'      => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>',
            'check'     => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
            'chart'     => '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>',
            'message'   => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
            'lock'      => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
            'settings'  => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
            'logout'    => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>',
            'menu'      => '<line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>',
            'x'         => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        ];
        $path = $icons[$name] ?? $icons['dashboard'];
        return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">'.$path.'</svg>';
    }
}

function render_header($title = 'Dashboard', $active = '') {
    $admin = $GLOBALS['admin'] ?? ['nama' => 'Admin', 'role' => 'operator'];
    $initial = strtoupper(substr($admin['nama'], 0, 1));

    // Grup menu
    $menus = [
        'Utama' => [
            ['key'=>'dashboard', 'label'=>'Dashboard', 'icon'=>'dashboard'],
        ],
        'Master' => [
            ['key'=>'kategori', 'label'=>'Kategori', 'icon'=>'tag'],
            ['key'=>'metode', 'label'=>'Metode Bayar', 'icon'=>'card'],
        ],
        'Tagihan' => [
            ['key'=>'invoice', 'label'=>'Daftar Tagihan', 'icon'=>'file'],
            ['key'=>'invoice-create', 'label'=>'Buat Tagihan', 'icon'=>'plus'],
            ['key'=>'konfirmasi', 'label'=>'Konfirmasi', 'icon'=>'check'],
        ],
        'Lainnya' => [
            ['key'=>'laporan', 'label'=>'Laporan', 'icon'=>'chart'],
            ['key'=>'wa-template', 'label'=>'Template WA', 'icon'=>'message'],
            ['key'=>'qris', 'label'=>'QRIS Gateway', 'icon'=>'lock', 'locked'=>true],
        ],
    ];
    if (is_super_admin()) {
        $menus['Admin'] = [
            ['key'=>'setting', 'label'=>'Setting', 'icon'=>'settings'],
        ];
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?= e($title) ?> - <?= APP_NAME ?></title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fb; color: #1a1a2e; }

/* ============ SIDEBAR (DESKTOP) ============ */
.sidebar { position: fixed; top:0; left:0; width: 250px; height: 100vh; background: #0f172a; color: #fff; overflow-y: auto; transition: transform .25s ease; z-index: 100; }
.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }
.sidebar .brand { padding: 22px 24px 20px; font-size: 20px; font-weight: 800; border-bottom: 1px solid rgba(255,255,255,0.06); display: flex; align-items: center; gap: 10px; }
.sidebar .brand .logo { width: 34px; height: 34px; border-radius: 9px; background: linear-gradient(135deg,#667eea,#764ba2); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800; }
.sidebar .brand span { color: #667eea; }
.sidebar nav { padding: 12px 0 30px; }
.sidebar .section { padding: 16px 24px 6px; font-size: 10px; text-transform: uppercase; color: #475569; letter-spacing: 1.2px; font-weight: 700; }
.sidebar nav a { display: flex; align-items: center; gap: 12px; padding: 11px 22px; color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 500; transition: .15s; border-left: 3px solid transparent; }
.sidebar nav a:hover { background: rgba(255,255,255,0.04); color: #e2e8f0; }
.sidebar nav a.active { background: linear-gradient(90deg, rgba(102,126,234,0.18), rgba(102,126,234,0.02)); color: #fff; border-left-color: #667eea; }
.sidebar nav a.active svg { color: #818cf8; }
.sidebar nav a.locked { opacity: 0.45; }
.sidebar .logout-link { margin-top: 12px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 12px; }
.sidebar .logout-link a { color: #f87171 !important; }
.sidebar .logout-link a:hover { background: rgba(239,68,68,0.1); }

/* ============ SIDEBAR OVERLAY (MOBILE) ============ */
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99; opacity: 0; transition: opacity .25s; }
.sidebar-overlay.show { display: block; opacity: 1; }

/* ============ MAIN ============ */
.main { margin-left: 250px; padding: 24px 32px 40px; min-height: 100vh; }
.topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; padding-bottom: 18px; border-bottom: 1px solid #e2e8f0; }
.topbar h1 { font-size: 22px; color: #1a1a2e; font-weight: 700; }
.topbar .user { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #555; }
.topbar .avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px; }
.topbar .user .nm { font-weight: 600; color: #1a1a2e; }
.topbar .user a { color: #dc2626; text-decoration: none; font-size: 12px; display: block; margin-top: 2px; }

/* ============ MOBILE HEADER & BOTTOM NAV ============ */
.mobile-header { display: none; position: fixed; top: 0; left: 0; right: 0; height: 60px; background: #0f172a; color: #fff; z-index: 90; padding: 0 18px; align-items: center; justify-content: space-between; box-shadow: 0 2px 12px rgba(0,0,0,0.15); }
.mobile-header .brand { font-size: 17px; font-weight: 800; display: flex; align-items: center; gap: 8px; }
.mobile-header .brand .logo { width: 30px; height: 30px; border-radius: 8px; background: linear-gradient(135deg,#667eea,#764ba2); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 800; }
.mobile-header .brand span { color: #667eea; }
.mobile-header .avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg,#667eea,#764ba2); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; }

.mobile-bottomnav { display: none; position: fixed; bottom: 0; left: 0; right: 0; height: 68px; background: #fff; border-top: 1px solid #e2e8f0; z-index: 90; box-shadow: 0 -2px 14px rgba(0,0,0,0.06); padding-bottom: env(safe-area-inset-bottom); }
.mobile-bottomnav .nav-item { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px; text-decoration: none; color: #94a3b8; font-size: 10px; font-weight: 500; position: relative; padding: 8px 4px; }
.mobile-bottomnav .nav-item.active { color: #667eea; }
.mobile-bottomnav .nav-item.center { flex: 0 0 auto; padding: 0 12px; }
.mobile-bottomnav .nav-item.center .fab { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg,#667eea,#764ba2); color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 16px rgba(102,126,234,0.45); margin-top: -18px; }
.mobile-bottomnav .nav-item.center span { color: #667eea; font-weight: 600; margin-top: 2px; }

/* ============ COMMON ============ */
.alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; }
.alert-success { background: #dcfce7; color: #166534; border-left: 4px solid #16a34a; }
.alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; }
.card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; text-decoration: none; transition: .15s; font-family: inherit; }
.btn:hover { opacity: .9; transform: translateY(-1px); }
.btn-outline { background: #fff; color: #444; border: 1.5px solid #e2e8f0; }
.btn-outline:hover { border-color: #667eea; color: #667eea; }
.btn-danger { background: #dc2626; }
.btn-sm { padding: 6px 12px; font-size: 13px; }
.badge { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; }
table { width: 100%; border-collapse: collapse; font-size: 14px; }
th { text-align: left; padding: 10px; border-bottom: 1.5px solid #e2e8f0; font-size: 12px; text-transform: uppercase; color: #666; letter-spacing: 0.5px; }
td { padding: 10px; border-bottom: 1px solid #f1f5f9; }
input, select, textarea { width: 100%; padding: 10px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 14px; font-family: inherit; }
input:focus, select:focus, textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.15); }
label { display: block; font-size: 13px; color: #444; margin-bottom: 6px; font-weight: 500; }

/* ============ RESPONSIVE ============ */
@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); width: 260px; box-shadow: 4px 0 20px rgba(0,0,0,0.2); }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0; padding: 76px 16px 96px; }
    .topbar { display: none; }
    .mobile-header { display: flex; }
    .mobile-bottomnav { display: flex; }
    .card { padding: 16px; border-radius: 10px; }
    .alert { font-size: 13px; padding: 10px 14px; }
    .btn { padding: 9px 14px; font-size: 13px; }
    .btn-sm { padding: 5px 10px; font-size: 12px; }
    table { font-size: 13px; }
    th, td { padding: 8px 6px; }
}
</style>
</head>
<body>

<!-- ============ MOBILE HEADER ============ -->
<div class="mobile-header">
    <div class="brand">
        <div class="logo">T</div>
        <div><span>Tagihan</span>ku</div>
    </div>
    <div class="avatar"><?= $initial ?></div>
</div>

<!-- ============ SIDEBAR ============ -->
<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="logo">T</div>
        <div><span>Tagihan</span>ku</div>
    </div>
    <nav>
        <?php foreach ($menus as $groupLabel => $items): ?>
            <div class="section"><?= e($groupLabel) ?></div>
            <?php foreach ($items as $item): ?>
                <a href="<?= url($item['key']) ?>"
                   class="<?= $active === $item['key'] ? 'active' : '' ?> <?= !empty($item['locked']) ? 'locked' : '' ?>">
                    <?= svg_icon($item['icon'], 18) ?>
                    <span><?= e($item['label']) ?></span>
                </a>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <div class="logout-link">
            <a href="<?= url('logout') ?>">
                <?= svg_icon('logout', 18) ?>
                <span>Logout</span>
            </a>
        </div>
    </nav>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ============ MAIN ============ -->
<div class="main">
    <div class="topbar">
        <h1><?= e($title) ?></h1>
        <div class="user">
            <div class="avatar"><?= $initial ?></div>
            <div>
                <div class="nm"><?= e($admin['nama']) ?></div>
                <a href="<?= url('logout') ?>">Logout</a>
            </div>
        </div>
    </div>

    <?php if ($s = flash('success')): ?>
        <div class="alert alert-success"><?= e($s) ?></div>
    <?php endif; ?>
    <?php if ($err = flash('error')): ?>
        <div class="alert alert-error"><?= e($err) ?></div>
    <?php endif; ?>

<!-- ============ MOBILE BOTTOM NAV ============ -->
<nav class="mobile-bottomnav">
    <a href="<?= url('dashboard') ?>" class="nav-item <?= $active === 'dashboard' ? 'active' : '' ?>">
        <?= svg_icon('dashboard', 22) ?>
        <span>Dashboard</span>
    </a>
    <a href="<?= url('invoice') ?>" class="nav-item <?= $active === 'invoice' ? 'active' : '' ?>">
        <?= svg_icon('file', 22) ?>
        <span>Tagihan</span>
    </a>
    <a href="<?= url('invoice-create') ?>" class="nav-item center <?= $active === 'invoice-create' ? 'active' : '' ?>">
        <div class="fab"><?= svg_icon('plus', 26) ?></div>
        <span>Buat</span>
    </a>
    <a href="<?= url('konfirmasi') ?>" class="nav-item <?= $active === 'konfirmasi' ? 'active' : '' ?>">
        <?= svg_icon('check', 22) ?>
        <span>Konfirmasi</span>
    </a>
    <a href="javascript:void(0)" onclick="openSidebar()" class="nav-item">
        <?= svg_icon('menu', 22) ?>
        <span>Menu</span>
    </a>
</nav>

<script>
function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebarOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
    document.body.style.overflow = '';
}
// Tutup sidebar kalau link di-klik (mobile)
document.querySelectorAll('.sidebar nav a').forEach(function(a) {
    a.addEventListener('click', function() {
        if (window.innerWidth <= 768) closeSidebar();
    });
});
</script>

<?php
}

function render_footer() {
?>
</div><!-- /.main -->
</body>
</html>
<?php
}