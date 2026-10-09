<?php
$title = 'Template WA';
$active = 'wa-template';

// ============ ICON SVG ============
function wt_icon($name, $size = 20) {
    $icons = [
        'message'   => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'plus'      => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
        'edit'      => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>',
        'trash'     => '<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
        'check'     => '<polyline points="20 6 9 17 4 12"/>',
        'x'         => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'eyeOn'     => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'eyeOff'    => '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>',
        'arrowL'    => '<line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>',
        'bold'      => '<path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/>',
        'italic'    => '<line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/>',
        'strike'    => '<line x1="4" y1="12" x2="20" y2="12"/><path d="M17.5 6.5A5 5 0 0 0 12 4c-3 0-5 1.5-5 4 0 1 .3 1.8 1 2.5"/><path d="M6.5 17.5A5 5 0 0 0 12 20c3 0 5-1.5 5-4 0-1-.3-1.8-1-2.5"/>',
        'code'      => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
        'list'      => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
        'ordered'   => '<line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/>',
        'divider'   => '<line x1="3" y1="12" x2="21" y2="12"/>',
        'enter'     => '<polyline points="9 10 4 15 9 20"/><path d="M20 4v7a4 4 0 0 1-4 4H4"/>',
        'quote'     => '<path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/>',
        'emoji'     => '<circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>',
        'chip'      => '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/>',
        'type'      => '<polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/>',
        'undo'      => '<path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/>',
        'alignL'    => '<line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/>',
        'alignC'    => '<line x1="18" y1="10" x2="6" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="18" y1="18" x2="6" y2="18"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; display:inline-block; vertical-align:middle;">'.$path.'</svg>';
}

function wt_wa_filled($size = 20) {
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413"/></svg>';
}

// ============ HANDLE POST (SAVE) ============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['post_action'] ?? '') === 'save') {
    $eid   = (int)($_POST['id'] ?? 0);
    $nama  = trim($_POST['nama'] ?? '');
    $tipe  = $_POST['tipe'] ?? 'custom';
    $isi   = trim($_POST['isi'] ?? '');
    $aktif = isset($_POST['aktif']) ? 1 : 0;

    $errors = [];
    if ($nama === '') $errors[] = 'Nama template wajib diisi.';
    if ($isi === '')  $errors[] = 'Isi template wajib diisi.';

    if ($errors) {
        flash('error', implode(' ', $errors));
        $_SESSION['old_form'] = $_POST;
        redirect('/?url=wa-template&action=' . ($eid ? "edit&id=$eid" : 'create'));
    }

    if ($eid) {
        $pdo->prepare("UPDATE wa_templates SET nama=?, tipe=?, isi=?, aktif=? WHERE id=?")
            ->execute([$nama, $tipe, $isi, $aktif, $eid]);
        flash('success', 'Template berhasil diupdate.');
    } else {
        $pdo->prepare("INSERT INTO wa_templates (nama, tipe, isi, aktif) VALUES (?,?,?,?)")
            ->execute([$nama, $tipe, $isi, $aktif]);
        flash('success', 'Template berhasil ditambahkan.');
    }
    redirect('/?url=wa-template');
}

// ============ AMBIL DATA ============
$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

$edit = null;
if ($action === 'edit' && $id) {
    $s = $pdo->prepare("SELECT * FROM wa_templates WHERE id=?");
    $s->execute([$id]);
    $edit = $s->fetch();
    if (!$edit) {
        flash('error', 'Template tidak ditemukan.');
        redirect('/?url=wa-template');
    }
}

$old_form = $_SESSION['old_form'] ?? [];
unset($_SESSION['old_form']);

$rows = $pdo->query("SELECT * FROM wa_templates ORDER BY tipe, nama")->fetchAll();

// Chip available
$chips = [
    ['{nama_pembayar}',  'Nama pembayar'],
    ['{invoice_number}', 'No invoice'],
    ['{deskripsi}',      'Deskripsi tagihan'],
    ['{nominal}',        'Total tagihan'],
    ['{expired}',        'Tanggal jatuh tempo'],
    ['{nama_bisnis}',    'Nama bisnis'],
    ['{kontak_admin}',   'Kontak admin'],
    ['{link}',           'Link pembayaran'],
    ['{alasan}',         'Alasan reject'],
];

render_header($title, $active);
?>

<style>
    .wt-wrap { max-width: 1280px; }

    .wt-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; gap:14px; flex-wrap:wrap; }
    .wt-head h2 { font-size:20px; font-weight:800; color:#0f172a; }
    .wt-head p { color:#64748b; font-size:13px; margin-top:4px; }

    /* ============ FORM EDITOR ============ */
    .wt-editor-grid { display:grid; grid-template-columns:1fr 400px; gap:20px; align-items:start; }

    .wt-card {
        background:#fff; border-radius:14px; padding:20px;
        border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);
        margin-bottom:16px;
    }
    .wt-card:last-child { margin-bottom:0; }

    .wt-card-hd {
        display:flex; align-items:center; gap:12px;
        margin-bottom:18px; padding-bottom:14px;
        border-bottom:1px solid #f1f5f9;
    }
    .wt-card-hd .ic {
        width:38px; height:38px; border-radius:10px;
        background:linear-gradient(135deg,#eef2ff,#e0e7ff); color:#6366f1;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .wt-card-hd h3 { font-size:15px; font-weight:700; color:#0f172a; }
    .wt-card-hd p { font-size:12px; color:#94a3b8; margin-top:2px; }

    .wt-field { margin-bottom:16px; }
    .wt-field:last-child { margin-bottom:0; }
    .wt-field label {
        display:block; font-size:12px; font-weight:600;
        color:#334155; margin-bottom:6px;
    }
    .wt-field label .req { color:#ef4444; }
    .wt-field input[type=text], .wt-field select {
        width:100%; padding:11px 14px; border:1.5px solid #e2e8f0;
        border-radius:9px; font-size:14px; font-family:inherit; background:#fff;
    }
    .wt-field input:focus, .wt-field select:focus {
        outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12);
    }

    .wt-row { display:grid; grid-template-columns:2fr 1fr; gap:12px; }

    /* ============ TOOLBAR ============ */
    .wt-editor-wrap {
        border:1.5px solid #e2e8f0; border-radius:11px;
        overflow:hidden; background:#fff;
        transition:.15s;
    }
    .wt-editor-wrap:focus-within { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); }

    .wt-toolbar {
        display:flex; flex-wrap:wrap; gap:3px;
        padding:8px 10px; background:#f8fafc;
        border-bottom:1px solid #e2e8f0;
        align-items:center;
    }
    .tb-btn {
        width:34px; height:34px; border-radius:8px;
        border:none; background:transparent; color:#475569;
        cursor:pointer; display:flex; align-items:center; justify-content:center;
        transition:.15s; font-family:inherit;
        position:relative;
    }
    .tb-btn:hover { background:#e2e8f0; color:#0f172a; }
    .tb-btn:active { transform:scale(0.95); }
    .tb-btn.active { background:#eef2ff; color:#6366f1; }
    .tb-btn[data-tip]:hover::after {
        content:attr(data-tip);
        position:absolute; bottom:-32px; left:50%; transform:translateX(-50%);
        background:#0f172a; color:#fff; padding:5px 9px;
        border-radius:6px; font-size:11px; font-weight:500;
        white-space:nowrap; z-index:10; pointer-events:none;
        animation:fadeIn .15s ease;
    }
    @keyframes fadeIn { from { opacity:0; transform:translate(-50%, -4px); } to { opacity:1; transform:translate(-50%, 0); } }

    .tb-sep {
        width:1px; height:20px; background:#cbd5e1;
        margin:0 3px;
    }
    .tb-label {
        font-size:10.5px; color:#94a3b8; font-weight:700;
        text-transform:uppercase; letter-spacing:.5px;
        padding:0 6px;
    }

    /* Textarea */
    .wt-textarea {
        width:100%; min-height:400px; padding:16px 18px;
        border:none; font-size:14.5px; line-height:1.65;
        font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color:#0f172a; background:#fff; resize:vertical;
        outline:none; tab-size:2;
    }
    .wt-textarea::placeholder { color:#cbd5e1; }

    /* Editor footer */
    .wt-editor-footer {
        display:flex; justify-content:space-between; align-items:center;
        padding:10px 14px; background:#f8fafc;
        border-top:1px solid #e2e8f0; font-size:11.5px; color:#94a3b8;
    }
    .wt-editor-footer .left { display:flex; align-items:center; gap:12px; }
    .wt-editor-footer .stat { display:flex; align-items:center; gap:4px; }
    .wt-editor-footer .stat b { color:#475569; font-weight:700; }

    /* ============ CHIP BAR ============ */
    .wt-chips {
        background:#f8fafc; border:1.5px dashed #cbd5e1;
        border-radius:11px; padding:12px;
    }
    .wt-chips-hd {
        font-size:11px; color:#64748b; font-weight:700;
        text-transform:uppercase; letter-spacing:.6px;
        margin-bottom:8px; display:flex; align-items:center; gap:6px;
    }
    .wt-chip-grid { display:flex; flex-wrap:wrap; gap:5px; }
    .wt-chip {
        display:inline-flex; align-items:center; gap:5px;
        padding:5px 10px; background:#fff; color:#4f46e5;
        border:1px solid #c7d2fe; border-radius:6px;
        font-family:'Courier New', monospace; font-size:11px;
        cursor:pointer; transition:.15s; user-select:none; font-weight:600;
    }
    .wt-chip:hover {
        background:#eef2ff; border-color:#818cf8;
        transform:translateY(-1px);
    }
    .wt-chip:active { transform:scale(0.97); }

    /* ============ WA PREVIEW ============ */
    .wt-preview-card {
        background:#fff; border-radius:14px; padding:16px;
        border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);
        position:sticky; top:20px;
    }
    .wt-preview-hd {
        display:flex; align-items:center; gap:10px;
        margin-bottom:12px; padding-bottom:12px;
        border-bottom:1px solid #f1f5f9;
    }
    .wt-preview-hd .wa-logo {
        width:38px; height:38px; border-radius:10px;
        background:linear-gradient(135deg,#25d366,#128c7e);
        color:#fff; display:flex; align-items:center; justify-content:center;
        flex-shrink:0;
    }
    .wt-preview-hd h4 { font-size:13px; font-weight:700; color:#0f172a; }
    .wt-preview-hd p { font-size:11px; color:#94a3b8; margin-top:1px; }

    .wt-preview-box { background:#e5ddd5; border-radius:11px; padding:12px; min-height:200px; }
    .wt-bubble {
        background:#dcf8c6; border-radius:10px;
        padding:12px 14px; font-size:12.5px; line-height:1.55;
        color:#111; white-space:pre-wrap; word-break:break-word;
        max-height:520px; overflow-y:auto;
        position:relative; font-family:-apple-system, "Segoe UI", sans-serif;
    }
    .wt-bubble::-webkit-scrollbar { width:4px; }
    .wt-bubble::-webkit-scrollbar-thumb { background:rgba(0,0,0,0.15); border-radius:2px; }
    .wt-bubble b, .wt-bubble strong { font-weight:700; }
    .wt-bubble i, .wt-bubble em { font-style:italic; }
    .wt-bubble s, .wt-bubble strike { text-decoration:line-through; }
    .wt-bubble code {
        font-family:'Courier New', monospace;
        background:rgba(0,0,0,0.06);
        padding:1px 5px; border-radius:4px; font-size:12px;
    }

    /* ============ LIST VIEW ============ */
    .wt-list { display:flex; flex-direction:column; gap:10px; }
    .wt-list-item {
        background:#fff; border-radius:12px; padding:16px 18px;
        border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);
        display:flex; gap:14px; align-items:flex-start;
        transition:.15s;
    }
    .wt-list-item:hover { border-color:#e0e7ff; box-shadow:0 4px 14px rgba(99,102,241,0.06); }
    .wt-list-item.inactive { opacity:.6; }

    .wt-list-icon {
        width:44px; height:44px; border-radius:11px;
        background:linear-gradient(135deg,#dcfce7,#bbf7d0); color:#16a34a;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0;
    }
    .wt-list-item.inactive .wt-list-icon {
        background:#f1f5f9; color:#94a3b8;
    }

    .wt-list-body { flex:1; min-width:0; }
    .wt-list-title { display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:6px; }
    .wt-list-title .nm { font-size:14.5px; font-weight:700; color:#0f172a; }
    .wt-tipe-pill {
        padding:3px 9px; border-radius:5px;
        font-size:10px; font-weight:700;
        text-transform:uppercase; letter-spacing:.4px;
    }
    .wt-tipe-pill.tagihan_baru { background:#dbeafe; color:#1e40af; }
    .wt-tipe-pill.reminder { background:#fef3c7; color:#92400e; }
    .wt-tipe-pill.approved { background:#dcfce7; color:#166534; }
    .wt-tipe-pill.rejected { background:#fee2e2; color:#991b1b; }
    .wt-tipe-pill.custom { background:#f1f5f9; color:#475569; }

    .wt-list-preview {
        font-size:12.5px; color:#64748b; line-height:1.5;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
        overflow:hidden; white-space:pre-wrap;
    }

    .wt-list-btns { display:flex; gap:6px; flex-shrink:0; }
    .wt-icon-btn {
        width:36px; height:36px; border-radius:9px;
        border:1.5px solid #e2e8f0; background:#fff;
        color:#64748b; cursor:pointer;
        display:flex; align-items:center; justify-content:center;
        transition:.15s; padding:0;
    }
    .wt-icon-btn:hover { transform:translateY(-1px); }
    .wt-icon-btn.toggle-on { color:#16a34a; border-color:#bbf7d0; background:#f0fdf4; }
    .wt-icon-btn.toggle-off { color:#94a3b8; }
    .wt-icon-btn.edit { color:#6366f1; border-color:#e0e7ff; }
    .wt-icon-btn.edit:hover { background:#eef2ff; }
    .wt-icon-btn.del { color:#ef4444; border-color:#fecaca; }
    .wt-icon-btn.del:hover { background:#fef2f2; }

    /* Empty */
    .wt-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:14px; border:1px solid #f1f5f9; }
    .wt-empty .em-ic {
        width:72px; height:72px; border-radius:50%;
        background:linear-gradient(135deg,#dcfce7,#bbf7d0); color:#16a34a;
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 16px;
    }
    .wt-empty h3 { font-size:16px; font-weight:700; color:#0f172a; margin-bottom:6px; }
    .wt-empty p { color:#94a3b8; font-size:13px; margin-bottom:18px; }

    /* Actions */
    .wt-form-actions {
        display:flex; gap:10px; margin-top:20px;
        padding-top:16px; border-top:1px solid #f1f5f9;
    }
    .wt-form-actions .btn { flex:1; justify-content:center; }

    /* Toast */
    .toast-wrap { position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:10px; }
    .toast {
        background:#0f172a; color:#fff; padding:12px 18px; border-radius:10px;
        font-size:13px; font-weight:500; box-shadow:0 6px 20px rgba(0,0,0,0.15);
        display:flex; align-items:center; gap:10px; min-width:220px;
        animation:slideIn .25s ease; border-left:4px solid #10b981;
    }
    .toast.error { border-left-color:#ef4444; }
    @keyframes slideIn { from { transform: translateX(100%); opacity:0; } to { transform: none; opacity:1; } }
    .toast.hide { animation: slideOut .25s ease forwards; }
    @keyframes slideOut { to { transform: translateX(100%); opacity:0; } }

    /* Responsive */
    @media (max-width:1024px) {
        .wt-editor-grid { grid-template-columns:1fr; }
        .wt-preview-card { position:static; }
    }
    @media (max-width:640px) {
        .wt-row { grid-template-columns:1fr; }
        .wt-toolbar { padding:6px 8px; }
        .tb-btn { width:30px; height:30px; }
        .wt-textarea { min-height:280px; padding:12px 14px; font-size:14px; }
        .wt-list-item { padding:14px; flex-wrap:wrap; }
        .wt-list-btns { margin-left:auto; }
        .tb-label { display:none; }
    }
</style>

<div class="toast-wrap" id="toastWrap"></div>

<div class="wt-wrap">

<?php if ($action === 'create' || ($action === 'edit' && $edit)): ?>

    <!-- ============ EDITOR VIEW ============ -->
    <?php
    $r = $old_form ?: ($edit ?: [
        'id' => 0, 'nama' => '', 'tipe' => 'custom', 'isi' => '', 'aktif' => 1
    ]);
    ?>

    <div class="wt-head">
        <div>
            <h2><?= $edit ? 'Edit Template' : 'Tambah Template' ?></h2>
            <p>Gunakan toolbar untuk memformat teks — mendukung format WhatsApp</p>
        </div>
        <a href="<?= url('wa-template') ?>" class="btn btn-outline">
            <?= wt_icon('arrowL', 15) ?> Kembali
        </a>
    </div>

    <div class="wt-editor-grid">

        <!-- ============ KIRI: EDITOR ============ -->
        <div>

            <div class="wt-card">
                <div class="wt-card-hd">
                    <div class="ic"><?= wt_icon('message', 18) ?></div>
                    <div>
                        <h3>Informasi Template</h3>
                        <p>Nama & tipe template</p>
                    </div>
                </div>

                <div class="wt-row">
                    <div class="wt-field">
                        <label>Nama Template <span class="req">*</span></label>
                        <input type="text" id="inpNama" name="nama" form="formTemplate"
                               required maxlength="100"
                               value="<?= e($r['nama']) ?>"
                               placeholder="misal: Tagihan Baru">
                    </div>
                    <div class="wt-field">
                        <label>Tipe <span class="req">*</span></label>
                        <select id="inpTipe" name="tipe" form="formTemplate" required>
                            <?php foreach ([
                                'tagihan_baru'=>'Tagihan Baru',
                                'reminder'=>'Reminder',
                                'approved'=>'Approved',
                                'rejected'=>'Rejected',
                                'custom'=>'Custom'
                            ] as $k => $v): ?>
                                <option value="<?= $k ?>" <?= $r['tipe']===$k?'selected':'' ?>><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="wt-card">
                <div class="wt-card-hd">
                    <div class="ic"><?= wt_icon('type', 18) ?></div>
                    <div>
                        <h3>Isi Template</h3>
                        <p>Format teks pesan WhatsApp</p>
                    </div>
                </div>

                <div class="wt-editor-wrap">
                    <!-- TOOLBAR -->
                    <div class="wt-toolbar">
                        <button type="button" class="tb-btn" data-tip="Bold (*teks*)" onclick="fmtBold()">
                            <?= wt_icon('bold', 16) ?>
                        </button>
                        <button type="button" class="tb-btn" data-tip="Italic (_teks_)" onclick="fmtItalic()">
                            <?= wt_icon('italic', 16) ?>
                        </button>
                        <button type="button" class="tb-btn" data-tip="Strikethrough (~teks~)" onclick="fmtStrike()">
                            <?= wt_icon('strike', 16) ?>
                        </button>
                        <button type="button" class="tb-btn" data-tip="Monospace (```teks```)" onclick="fmtCode()">
                            <?= wt_icon('code', 16) ?>
                        </button>

                        <div class="tb-sep"></div>

                        <button type="button" class="tb-btn" data-tip="Bullet list (•)" onclick="fmtBullet()">
                            <?= wt_icon('list', 16) ?>
                        </button>
                        <button type="button" class="tb-btn" data-tip="Numbered list (1.)" onclick="fmtNumbered()">
                            <?= wt_icon('ordered', 16) ?>
                        </button>
                        <button type="button" class="tb-btn" data-tip="Divider" onclick="fmtDivider()">
                            <?= wt_icon('divider', 16) ?>
                        </button>
                        <button type="button" class="tb-btn" data-tip="Enter" onclick="fmtEnter()">
                            <?= wt_icon('enter', 16) ?>
                        </button>
                        <button type="button" class="tb-btn" data-tip="Quote" onclick="fmtQuote()">
                            <?= wt_icon('quote', 16) ?>
                        </button>

                        <div class="tb-sep"></div>

                        <button type="button" class="tb-btn" data-tip="Sisipkan Chip" onclick="openChipMenu()">
                            <?= wt_icon('chip', 16) ?>
                        </button>
                        <button type="button" class="tb-btn" data-tip="Emoji" onclick="openEmojiMenu()">
                            <?= wt_icon('emoji', 16) ?>
                        </button>

                        <div class="tb-sep"></div>

                        <button type="button" class="tb-btn" data-tip="Reset" onclick="resetEditor()">
                            <?= wt_icon('undo', 16) ?>
                        </button>

                        <span class="tb-label" style="margin-left:auto;">Text Editor</span>
                    </div>

                    <!-- TEXTAREA -->
                    <textarea id="editorText"
                              name="isi"
                              form="formTemplate"
                              class="wt-textarea"
                              placeholder="Tulis isi pesan template di sini...

Contoh:
Halo {nama_pembayar} 👋

Berikut tagihan dari *{nama_bisnis}*:

📄 No. Invoice: {invoice_number}
📝 {deskripsi}
💰 Total: *{nominal}*
⏰ Jatuh tempo: {expired}

Bayar di: {link}

Terima kasih 🙏"
                              oninput="onEditorInput()"><?= e($r['isi']) ?></textarea>

                    <!-- FOOTER -->
                    <div class="wt-editor-footer">
                        <div class="left">
                            <span class="stat"><?= wt_icon('type', 12) ?> <b id="statChars">0</b> karakter</span>
                            <span class="stat"><?= wt_icon('message', 12) ?> <b id="statLines">0</b> baris</span>
                        </div>
                        <span style="color:#cbd5e1;">Ctrl+B bold · Ctrl+I italic</span>
                    </div>
                </div>

                <div class="wt-field" style="margin-top:16px;">
                    <label class="wt-toggle" style="display:inline-flex; align-items:center; gap:10px; padding:11px 14px; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:9px; cursor:pointer; font-weight:500; color:#334155;">
                        <input type="checkbox" name="aktif" form="formTemplate" value="1" <?= $r['aktif']?'checked':'' ?> style="width:16px; height:16px; accent-color:#6366f1;">
                        Aktifkan template ini
                    </label>
                </div>
            </div>

            <!-- CHIP BAR -->
            <div class="wt-chips">
                <div class="wt-chips-hd">
                    <?= wt_icon('chip', 12) ?> Klik untuk menyisipkan variable
                </div>
                <div class="wt-chip-grid">
                    <?php foreach ($chips as $c): ?>
                        <span class="wt-chip" onclick="insertAtCursor('<?= $c[0] ?>')" title="<?= e($c[1]) ?>">
                            <?= e($c[0]) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <!-- ============ KANAN: PREVIEW ============ -->
        <div class="wt-preview-card">
            <div class="wt-preview-hd">
                <div class="wa-logo"><?= wt_wa_filled(20) ?></div>
                <div>
                    <h4>Live Preview</h4>
                    <p>Tampilan di WhatsApp</p>
                </div>
            </div>

            <div class="wt-preview-box">
                <div class="wt-bubble" id="waPreview">Preview pesan akan muncul di sini...</div>
            </div>

            <div style="margin-top:12px; padding:10px 12px; background:#f8fafc; border-radius:9px; font-size:11.5px; color:#64748b; line-height:1.6;">
                <strong style="color:#475569;">Format WhatsApp:</strong><br>
                <code style="background:#e2e8f0; padding:1px 5px; border-radius:3px;">*bold*</code>
                <code style="background:#e2e8f0; padding:1px 5px; border-radius:3px;">_italic_</code>
                <code style="background:#e2e8f0; padding:1px 5px; border-radius:3px;">~strike~</code>
                <code style="background:#e2e8f0; padding:1px 5px; border-radius:3px;">```mono```</code>
            </div>

            <!-- FORM HIDDEN -->
            <form id="formTemplate" method="POST" style="display:none;">
                <input type="hidden" name="post_action" value="save">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
            </form>

            <div class="wt-form-actions">
                <button type="button" class="btn" onclick="submitForm()">
                    <?= wt_icon('check', 16) ?> Simpan Template
                </button>
                <a href="<?= url('wa-template') ?>" class="btn btn-outline">Batal</a>
            </div>
        </div>

    </div>

<?php else: ?>

    <!-- ============ LIST VIEW ============ -->
    <div class="wt-head">
        <div>
            <h2>Template WhatsApp</h2>
            <p>Total <strong><?= count($rows) ?></strong> template</p>
        </div>
        <a href="<?= url('wa-template&action=create') ?>" class="btn">
            <?= wt_icon('plus', 16) ?> Tambah Template
        </a>
    </div>

    <?php if (empty($rows)): ?>
        <div class="wt-empty">
            <div class="em-ic"><?= wt_icon('message', 36) ?></div>
            <h3>Belum ada template</h3>
            <p>Buat template pertama untuk kirim tagihan via WhatsApp</p>
            <a href="<?= url('wa-template&action=create') ?>" class="btn">
                <?= wt_icon('plus', 16) ?> Buat Template Pertama
            </a>
        </div>
    <?php else: ?>

        <div class="wt-list">
            <?php foreach ($rows as $r): ?>
                <?php
                $isActive = $r['aktif'] == 1;
                $tipeLabel = [
                    'tagihan_baru'=>'Tagihan Baru','reminder'=>'Reminder',
                    'approved'=>'Approved','rejected'=>'Rejected','custom'=>'Custom'
                ][$r['tipe']] ?? $r['tipe'];
                ?>
                <div class="wt-list-item <?= $isActive ? '' : 'inactive' ?>">
                    <div class="wt-list-icon"><?= wt_icon('message', 20) ?></div>

                    <div class="wt-list-body">
                        <div class="wt-list-title">
                            <span class="nm"><?= e($r['nama']) ?></span>
                            <span class="wt-tipe-pill <?= e($r['tipe']) ?>"><?= e($tipeLabel) ?></span>
                            <?php if (!$isActive): ?>
                                <span class="wt-tipe-pill custom">Nonaktif</span>
                            <?php endif; ?>
                        </div>
                        <div class="wt-list-preview"><?= e(mb_substr($r['isi'], 0, 220)) ?><?= mb_strlen($r['isi']) > 220 ? '...' : '' ?></div>
                    </div>

                    <div class="wt-list-btns">
                        <button type="button" class="wt-icon-btn <?= $isActive ? 'toggle-on' : 'toggle-off' ?>"
                                title="<?= $isActive ? 'Nonaktifkan' : 'Aktifkan' ?>"
                                onclick="toggleAktif(<?= $r['id'] ?>, this)">
                            <?= wt_icon($isActive ? 'eyeOn' : 'eyeOff', 15) ?>
                        </button>
                        <a href="<?= url('wa-template&action=edit&id=' . $r['id']) ?>"
                           class="wt-icon-btn edit" title="Edit">
                            <?= wt_icon('edit', 15) ?>
                        </a>
                        <button type="button" class="wt-icon-btn del" title="Hapus"
                                onclick="hapusTemplate(<?= $r['id'] ?>, <?= json_encode($r['nama']) ?>)">
                            <?= wt_icon('trash', 15) ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

<?php endif; ?>

</div>

<!-- ============ CHIP MENU POPUP ============ -->
<div class="modal-overlay-custom" id="chipMenu" style="display:none; position:fixed; inset:0; z-index:400; background:rgba(15,23,42,0.5); align-items:center; justify-content:center; padding:20px;">
    <div style="background:#fff; border-radius:14px; padding:22px; max-width:400px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin-bottom:14px;">Sisipkan Variable</h3>
        <div style="display:flex; flex-wrap:wrap; gap:6px;">
            <?php foreach ($chips as $c): ?>
                <button type="button" class="wt-chip" onclick="insertAtCursor('<?= $c[0] ?>'); closeChipMenu();" style="cursor:pointer;">
                    <?= e($c[0]) ?>
                </button>
            <?php endforeach; ?>
        </div>
        <div style="display:flex; gap:8px; margin-top:16px;">
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="closeChipMenu()">Tutup</button>
        </div>
    </div>
</div>

<!-- ============ EMOJI MENU POPUP ============ -->
<div class="modal-overlay-custom" id="emojiMenu" style="display:none; position:fixed; inset:0; z-index:400; background:rgba(15,23,42,0.5); align-items:center; justify-content:center; padding:20px;">
    <div style="background:#fff; border-radius:14px; padding:22px; max-width:420px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin-bottom:14px;">Pilih Emoji</h3>
        <div id="emojiGrid" style="display:grid; grid-template-columns:repeat(8, 1fr); gap:6px; font-size:22px; text-align:center;">
        </div>
        <div style="display:flex; gap:8px; margin-top:16px;">
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="closeEmojiMenu()">Tutup</button>
        </div>
    </div>
</div>

<script>
// ============ TOAST ============
function showToast(msg, type = 'success') {
    const wrap = document.getElementById('toastWrap');
    if (!wrap) return;
    const el = document.createElement('div');
    el.className = 'toast ' + type;
    const ic = type === 'success'
        ? '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>'
        : '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
    el.innerHTML = ic + ' <span>' + msg + '</span>';
    wrap.appendChild(el);
    setTimeout(() => {
        el.classList.add('hide');
        setTimeout(() => el.remove(), 300);
    }, 2600);
}

// ============ EDITOR ============
const editor = document.getElementById('editorText');
const preview = document.getElementById('waPreview');

function getSelectionRange() {
    return {
        start: editor.selectionStart,
        end: editor.selectionEnd,
        text: editor.value.substring(editor.selectionStart, editor.selectionEnd)
    };
}

function wrapSelection(prefix, suffix, placeholder) {
    editor.focus();
    const sel = getSelectionRange();
    const text = sel.text || placeholder || '';
    const newText = prefix + text + suffix;

    const before = editor.value.substring(0, sel.start);
    const after = editor.value.substring(sel.end);

    editor.value = before + newText + after;

    // Position cursor setelah wrapped text
    const newPos = sel.start + prefix.length + text.length;
    editor.selectionStart = newPos;
    editor.selectionEnd = newPos;

    onEditorInput();
}

function insertAtCursor(text) {
    editor.focus();
    const sel = getSelectionRange();
    const before = editor.value.substring(0, sel.start);
    const after = editor.value.substring(sel.end);

    editor.value = before + text + after;

    const newPos = sel.start + text.length;
    editor.selectionStart = newPos;
    editor.selectionEnd = newPos;

    onEditorInput();
}

function fmtBold()     { wrapSelection('*', '*', 'teks tebal'); }
function fmtItalic()   { wrapSelection('_', '_', 'teks miring'); }
function fmtStrike()   { wrapSelection('~', '~', 'teks coret'); }
function fmtCode()     { wrapSelection('```', '```', 'monospace'); }

function fmtBullet() {
    const sel = getSelectionRange();
    const lines = (sel.text || 'item').split('\n').map(l => '• ' + l).join('\n');
    wrapSelection('', '', ''); // reset
    editor.focus();
    const r = getSelectionRange();
    const before = editor.value.substring(0, r.start);
    const after = editor.value.substring(r.end);
    editor.value = before + lines + after;
    editor.selectionStart = editor.selectionEnd = r.start + lines.length;
    onEditorInput();
}

function fmtNumbered() {
    const sel = getSelectionRange();
    const lines = (sel.text || 'item').split('\n').map((l, i) => (i + 1) + '. ' + l).join('\n');
    editor.focus();
    const r = getSelectionRange();
    const before = editor.value.substring(0, r.start);
    const after = editor.value.substring(r.end);
    editor.value = before + lines + after;
    editor.selectionStart = editor.selectionEnd = r.start + lines.length;
    onEditorInput();
}

function fmtDivider() {
    insertAtCursor('\n━━━━━━━━━━━━━━\n');
}

function fmtEnter() {
    insertAtCursor('\n');
}

function fmtQuote() {
    const sel = getSelectionRange();
    const text = sel.text || 'kutipan';
    const quoted = '> ' + text;
    editor.focus();
    const r = getSelectionRange();
    const before = editor.value.substring(0, r.start);
    const after = editor.value.substring(r.end);
    editor.value = before + quoted + after;
    editor.selectionStart = editor.selectionEnd = r.start + quoted.length;
    onEditorInput();
}

function resetEditor() {
    if (!confirm('Reset isi editor? Semua teks akan dihapus.')) return;
    editor.value = '';
    onEditorInput();
}

// ============ INPUT HANDLER ============
function onEditorInput() {
    const txt = editor.value;
    document.getElementById('statChars').textContent = txt.length.toLocaleString('id-ID');
    document.getElementById('statLines').textContent = txt.split('\n').length.toLocaleString('id-ID');
    renderPreview(txt);
}

// ============ PREVIEW RENDER ============
// Konversi markup WhatsApp ke HTML
function renderPreview(text) {
    if (!text.trim()) {
        preview.innerHTML = '<span style="color:#94a3b8; font-style:italic;">Preview pesan akan muncul di sini...</span>';
        return;
    }

    // Escape HTML dulu
    let html = text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');

    // Convert format WhatsApp
    // Bold: *text* (bukan **)
    html = html.replace(/(?<!\*)\*([^\*\n]+?)\*(?!\*)/g, '<b>$1</b>');
    // Italic: _text_
    html = html.replace(/(?<!_)_([^_\n]+?)_(?!_)/g, '<i>$1</i>');
    // Strike: ~text~
    html = html.replace(/~([^~\n]+?)~/g, '<s>$1</s>');
    // Monospace: ```text```
    html = html.replace(/```([^`]+?)```/g, '<code>$1</code>');

    preview.innerHTML = html;
}

// ============ SUBMIT FORM ============
function submitForm() {
    const nama = document.getElementById('inpNama').value.trim();
    const isi = editor.value.trim();

    if (!nama) { showToast('Nama template wajib diisi', 'error'); return; }
    if (!isi)  { showToast('Isi template wajib diisi', 'error'); return; }

    document.getElementById('formTemplate').submit();
}

// ============ LIST ACTIONS ============
async function toggleAktif(id, btn) {
    btn.disabled = true;
    try {
        const fd = new FormData();
        fd.append('action', 'toggle');
        fd.append('id', id);
        const res = await fetch('<?= BASE_URL ?>/?url=api/wa-template-action', { method: 'POST', body: fd });
        const data = await res.json();
        if (!data.success) throw new Error(data.message);
        showToast(data.message, 'success');
        setTimeout(() => location.reload(), 500);
    } catch (e) {
        showToast(e.message || 'Gagal', 'error');
        btn.disabled = false;
    }
}

async function hapusTemplate(id, nama) {
    if (!confirm('Hapus template "' + nama + '"?')) return;
    try {
        const fd = new FormData();
        fd.append('action', 'delete');
        fd.append('id', id);
        const res = await fetch('<?= BASE_URL ?>/?url=api/wa-template-action', { method: 'POST', body: fd });
        const data = await res.json();
        if (!data.success) throw new Error(data.message);
        showToast(data.message, 'success');
        setTimeout(() => location.reload(), 500);
    } catch (e) {
        showToast(e.message || 'Gagal', 'error');
    }
}

// ============ CHIP & EMOJI MENU ============
function openChipMenu()  { document.getElementById('chipMenu').style.display = 'flex'; }
function closeChipMenu() { document.getElementById('chipMenu').style.display = 'none'; }
function openEmojiMenu() {
    const emojis = [
        '😀','😊','😁','🥰','😎','🤗','😉','🙏',
        '👋','👍','👎','🙌','💪','🤝','✨','🔥',
        '✅','❌','⚠️','❗','❓','💡','📌','📎',
        '📄','📝','📋','📊','📈','📉','💰','💳',
        '💵','💴','💶','💷','🏦','🏧','💼','🧾',
        '⏰','⏳','📅','📆','🔔','🔕','🎯','🎁',
        '💬','📢','📣','📱','📞','💌','📧','📨',
        '⭐','🌟','💫','⚡','🌈','🎉','🎊','🥳',
        '❤️','🧡','💛','💚','💙','💜','🖤','🤍',
    ];
    const grid = document.getElementById('emojiGrid');
    grid.innerHTML = emojis.map(e => `<button type="button" onclick="insertAtCursor('${e}'); closeEmojiMenu();" style="background:none; border:none; font-size:22px; cursor:pointer; padding:4px; border-radius:6px; transition:.15s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">${e}</button>`).join('');
    document.getElementById('emojiMenu').style.display = 'flex';
}
function closeEmojiMenu() { document.getElementById('emojiMenu').style.display = 'none'; }

// ============ KEYBOARD SHORTCUTS ============
document.addEventListener('keydown', e => {
    if (!editor || document.activeElement !== editor) return;

    if (e.ctrlKey || e.metaKey) {
        if (e.key === 'b') { e.preventDefault(); fmtBold(); }
        else if (e.key === 'i') { e.preventDefault(); fmtItalic(); }
    }

    // Tab untuk indentasi
    if (e.key === 'Tab') {
        e.preventDefault();
        insertAtCursor('  ');
    }
});

// ============ INIT ============
if (editor) {
    onEditorInput();
    editor.focus();
}
</script>

<?php render_footer(); ?>