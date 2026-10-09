<?php
$title = 'Buat Tagihan';
$active = 'invoice-create';

// ============ ICON SVG ============
function ic_icon($name, $size = 20) {
    $icons = [
        'user'     => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'phone'    => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'mail'     => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        'file'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'tag'      => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
        'package'  => '<line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
        'plus'     => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
        'trash'    => '<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
        'check'    => '<polyline points="20 6 9 17 4 12"/>',
        'percent'  => '<line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
        'hash'     => '<line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/>',
        'card'     => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        'bank'     => '<path d="M3 21h18"/><path d="M5 21V10l7-5 7 5v11"/><path d="M9 21v-6h6v6"/>',
        'wallet'   => '<path d="M20 12V8H6a2 2 0 0 1 0-4h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/>',
        'qris'     => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="3" height="3"/><line x1="21" y1="14" x2="21" y2="17"/><line x1="14" y1="21" x2="17" y2="21"/>',
        'note'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
        'lock'     => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'alert'    => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
        'arrowL'   => '<line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>',
        'arrowR'   => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'message'  => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'layers'   => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
        'users'    => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    ];
    $path = $icons[$name] ?? '';
    if (!$path) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; display:inline-block; vertical-align:middle;">'.$path.'</svg>';
}

function ic_wa_filled($size = 20) {
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413"/></svg>';
}

// ============ HANDLE POST ============
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode'] ?? 'single';

    // ---- Parse penerima ----
    $penerima = [];

    if ($mode === 'bulk') {
        $bulk_list = trim($_POST['bulk_list'] ?? '');
        $lines = array_filter(explode("\n", $bulk_list), fn($l) => trim($l) !== '');

        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, '|') !== false) $parts = explode('|', $line);
            elseif (strpos($line, "\t") !== false) $parts = explode("\t", $line);
            elseif (strpos($line, ',') !== false) $parts = explode(',', $line);
            else $parts = [$line];

            $parts = array_map('trim', $parts);
            $nama = $parts[0] ?? '';
            $wa   = preg_replace('/\D/', '', $parts[1] ?? '');
            $em   = $parts[2] ?? '';

            if ($nama && $wa) {
                $penerima[] = ['nama' => $nama, 'wa' => $wa, 'email' => $em];
            }
        }
    } else {
        $nama_pembayar = trim($_POST['nama_pembayar'] ?? '');
        $nomor_wa      = trim($_POST['nomor_wa'] ?? '');
        $email         = trim($_POST['email'] ?? '');

        if ($nama_pembayar && $nomor_wa) {
            $penerima[] = ['nama' => $nama_pembayar, 'wa' => $nomor_wa, 'email' => $email];
        }
    }

    // ---- Field umum ----
    $kategori_id   = (int)($_POST['kategori_id'] ?? 0) ?: null;
    $deskripsi     = trim($_POST['deskripsi'] ?? '');
    $expired_at    = trim($_POST['expired_at'] ?? '');
    $catatan_user  = trim($_POST['catatan_user'] ?? '');
    $internal_note = trim($_POST['internal_note'] ?? '');
    $pakai_kode_unik = isset($_POST['pakai_kode_unik']) ? 1 : 0;
    $kode_unik_val   = (float)($_POST['kode_unik'] ?? 0);
    $metode_ids      = array_filter(array_map('intval', $_POST['metode_ids'] ?? []));
    $kirim_wa        = isset($_POST['kirim_wa']) ? 1 : 0;
    $template_id     = (int)($_POST['template_id'] ?? 0);

    $items = [];
    foreach (($_POST['items'] ?? []) as $it) {
        if (!is_array($it)) continue;
        $nm = trim($it['nama_item'] ?? '');
        $q  = (float)($it['qty'] ?? 0);
        $h  = (float)($it['harga_satuan'] ?? 0);
        if ($nm !== '' && $h > 0) {
            $items[] = ['nama_item' => $nm, 'qty' => $q ?: 1, 'harga_satuan' => $h];
        }
    }

    $adjustments = [];
    foreach (($_POST['adjustments'] ?? []) as $ad) {
        if (!is_array($ad)) continue;
        $tipe  = $ad['tipe'] ?? '';
        $label = trim($ad['label'] ?? '');
        $mode_a = $ad['mode'] ?? 'nominal';
        $nilai = (float)($ad['nilai'] ?? 0);
        if (in_array($tipe, ['diskon','biaya_admin','pajak']) && $nilai > 0) {
            $adjustments[] = [
                'tipe' => $tipe,
                'label' => $label ?: ucfirst(str_replace('_', ' ', $tipe)),
                'mode' => $mode_a,
                'nilai' => $nilai,
            ];
        }
    }

    // ---- Validasi ----
    $errors = [];
    if (empty($penerima)) $errors[] = ($mode === 'bulk') ? 'Daftar penerima kosong atau format salah.' : 'Nama & Nomor WA wajib diisi.';
    if ($deskripsi === '') $errors[] = 'Deskripsi wajib diisi.';
    if ($expired_at === '') $errors[] = 'Tanggal expired wajib diisi.';
    if (empty($items)) $errors[] = 'Minimal 1 item biaya dengan harga.';
    if (empty($metode_ids)) $errors[] = 'Pilih minimal 1 metode pembayaran.';

    if ($errors) {
        flash('error', implode(' ', $errors));
        $_SESSION['old_form'] = $_POST;
        redirect('/?url=invoice-create');
    }

    // ---- Hitung ----
    $subtotal = 0;
    foreach ($items as $it) $subtotal += $it['qty'] * $it['harga_satuan'];

    $total_diskon = 0; $total_biaya = 0; $total_pajak = 0;

    foreach ($adjustments as &$ad) {
        if ($ad['tipe'] === 'diskon') {
            $ad['hasil'] = $ad['mode'] === 'persen' ? $subtotal * $ad['nilai'] / 100 : $ad['nilai'];
            $total_diskon += $ad['hasil'];
        }
    }
    unset($ad);
    $dpp = max(0, $subtotal - $total_diskon);

    foreach ($adjustments as &$ad) {
        if ($ad['tipe'] === 'biaya_admin') {
            $ad['hasil'] = $ad['mode'] === 'persen' ? $subtotal * $ad['nilai'] / 100 : $ad['nilai'];
            $total_biaya += $ad['hasil'];
        } elseif ($ad['tipe'] === 'pajak') {
            $ad['hasil'] = $ad['mode'] === 'persen' ? $dpp * $ad['nilai'] / 100 : $ad['nilai'];
            $total_pajak += $ad['hasil'];
        }
    }
    unset($ad);

    if ($pakai_kode_unik) {
        $kode_unik_val = $kode_unik_val > 0 ? $kode_unik_val : random_int(1, 999);
    } else {
        $kode_unik_val = 0;
    }

    $grand_total = $subtotal - $total_diskon + $total_biaya + $total_pajak + $kode_unik_val;
    if ($grand_total < 0) $grand_total = 0;

    $prefix = 'INV';
    if ($kategori_id) {
        $p = $pdo->prepare("SELECT kode_prefix FROM categories WHERE id=?");
        $p->execute([$kategori_id]);
        $pfx = $p->fetchColumn();
        if ($pfx) $prefix = $pfx;
    }

    // Ambil template WA
    if ($template_id) {
        $stmt = $pdo->prepare("SELECT isi FROM wa_templates WHERE id = ? AND aktif = 1");
        $stmt->execute([$template_id]);
        $tpl = $stmt->fetchColumn();
    } else {
        $tpl = false;
    }
    if (!$tpl) {
        $tpl = $pdo->query("SELECT isi FROM wa_templates WHERE tipe='tagihan_baru' AND aktif=1 ORDER BY id LIMIT 1")->fetchColumn();
    }
    if (!$tpl) $tpl = "Halo {nama_pembayar}, tagihan {invoice_number} sebesar {nominal}. Bayar di: {link}";

    // ---- Loop Simpan ----
    $invoice_list = [];
    $first_wa_link = null;

    try {
        $pdo->beginTransaction();

        foreach ($penerima as $p) {
            // Generate invoice number
            $tgl = date('Ymd');
            $cek = $pdo->prepare("SELECT COUNT(*) FROM invoices WHERE invoice_number LIKE ?");
            $cek->execute(["$prefix-$tgl-%"]);
            $urut = str_pad($cek->fetchColumn() + 1, 4, '0', STR_PAD_LEFT);
            $invoice_number = "$prefix-$tgl-$urut";
            $token = bin2hex(random_bytes(16));

            // Kode unik per invoice (kalau aktif)
            $ku_this = $pakai_kode_unik ? random_int(1, 999) : 0;
            $total_this = $subtotal - $total_diskon + $total_biaya + $total_pajak + $ku_this;
            if ($total_this < 0) $total_this = 0;

            $pdo->prepare("INSERT INTO invoices 
                (invoice_number, token, kategori_id, nama_pembayar, nomor_wa, email, deskripsi,
                 subtotal, total_diskon, total_biaya_admin, total_pajak, kode_unik, total,
                 pakai_kode_unik, catatan_user, internal_note, expired_at, status, created_by)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'unpaid',?)")
                ->execute([
                    $invoice_number, $token, $kategori_id, $p['nama'], $p['wa'], $p['email'], $deskripsi,
                    $subtotal, $total_diskon, $total_biaya, $total_pajak, $ku_this, $total_this,
                    $pakai_kode_unik, $catatan_user, $internal_note,
                    date('Y-m-d H:i:s', strtotime($expired_at)),
                    $_SESSION['admin_id'] ?? null
                ]);

            $new_id = $pdo->lastInsertId();

            // Items
            $ins = $pdo->prepare("INSERT INTO invoice_items (invoice_id, nama_item, qty, harga_satuan, subtotal, urutan) VALUES (?,?,?,?,?,?)");
            foreach ($items as $i => $it) {
                $ins->execute([$new_id, $it['nama_item'], $it['qty'], $it['harga_satuan'], $it['qty'] * $it['harga_satuan'], $i]);
            }

            // Adjustments
            if ($adjustments) {
                $ins = $pdo->prepare("INSERT INTO invoice_adjustments (invoice_id, tipe, label, mode, nilai, hasil, urutan) VALUES (?,?,?,?,?,?,?)");
                foreach ($adjustments as $i => $ad) {
                    $ins->execute([$new_id, $ad['tipe'], $ad['label'], $ad['mode'], $ad['nilai'], $ad['hasil'], $i]);
                }
            }

            // Methods
            if ($metode_ids) {
                $ins = $pdo->prepare("INSERT INTO invoice_methods (invoice_id, payment_method_id) VALUES (?,?)");
                foreach ($metode_ids as $mid) {
                    $ins->execute([$new_id, $mid]);
                }
            }

            // Log
            $ket = ($mode === 'bulk') ? 'Tagihan dibuat (bulk)' : 'Tagihan dibuat';
            $pdo->prepare("INSERT INTO status_logs (invoice_id, status_lama, status_baru, oleh_tipe, oleh_id, keterangan) VALUES (?, NULL, 'unpaid', 'admin', ?, ?)")
                ->execute([$new_id, $_SESSION['admin_id'] ?? null, $ket]);

            // Simpan info untuk result page
            $link = BASE_URL . '/?url=pay/' . $token;
            $wa_text = strtr($tpl, [
                '{nama_pembayar}'  => $p['nama'],
                '{invoice_number}' => $invoice_number,
                '{deskripsi}'      => $deskripsi,
                '{nominal}'        => rupiah($total_this),
                '{expired}'        => tglIndo(date('Y-m-d H:i:s', strtotime($expired_at))),
                '{nama_bisnis}'    => setting('nama_bisnis', APP_NAME),
                '{kontak_admin}'   => setting('kontak_admin', ''),
                '{link}'           => $link,
                '{alasan}'         => '',
            ]);
            $wa_num = preg_replace('/[^0-9]/', '', $p['wa']);
            if (substr($wa_num, 0, 1) === '0') $wa_num = '62' . substr($wa_num, 1);
            elseif (substr($wa_num, 0, 2) !== '62') $wa_num = '62' . $wa_num;
            $wa_link = 'https://wa.me/' . $wa_num . '?text=' . urlencode($wa_text);

            $invoice_list[] = [
                'id' => $new_id,
                'nama' => $p['nama'],
                'wa' => $p['wa'],
                'invoice_number' => $invoice_number,
                'total' => rupiah($total_this),
                'link' => $link,
                'wa_link' => $wa_link,
            ];

            if ($kirim_wa && !$first_wa_link) {
                $first_wa_link = $wa_link;
            }
        }

        $pdo->commit();

        // ---- Redirect ----
        if (count($invoice_list) === 1) {
            flash('success', "Tagihan {$invoice_list[0]['invoice_number']} berhasil dibuat.");
            if ($kirim_wa && $first_wa_link) {
                $_SESSION['redirect_wa'] = $first_wa_link;
            }
            redirect('/?url=invoice');
        } else {
            $_SESSION['bulk_result'] = $invoice_list;
            flash('success', count($invoice_list) . " tagihan berhasil dibuat!");
            redirect('/?url=invoice-bulk-result');
        }

    } catch (Exception $e) {
        $pdo->rollBack();
        flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        redirect('/?url=invoice-create');
    }
}

// ============ AMBIL DATA ============
$old = $_SESSION['old_form'] ?? [];
unset($_SESSION['old_form']);

$kategoris = $pdo->query("SELECT * FROM categories WHERE aktif=1 ORDER BY nama")->fetchAll();
$metodes   = $pdo->query("SELECT * FROM payment_methods WHERE aktif=1 ORDER BY urutan, id")->fetchAll();

$wa_templates = $pdo->query("SELECT * FROM wa_templates 
    WHERE aktif=1 AND tipe='tagihan_baru' 
    ORDER BY nama")->fetchAll();

if (empty($old['expired_at'])) {
    $jam_default = (int)setting('durasi_expired_default', 24);
    $old['expired_at'] = date('Y-m-d\TH:i', strtotime("+{$jam_default} hours"));
}

$old_items = $old['items'] ?? [['nama_item'=>'','qty'=>1,'harga_satuan'=>'']];
if (!is_array($old_items)) $old_items = [['nama_item'=>'','qty'=>1,'harga_satuan'=>'']];

$old_adj = $old['adjustments'] ?? [];
if (!is_array($old_adj)) $old_adj = [];

$selected_template_id = (int)($old['template_id'] ?? 0);
if (!$selected_template_id && $wa_templates) {
    $selected_template_id = (int)$wa_templates[0]['id'];
}

// Mode awal dari session (kalau error restore)
$initial_mode = $old['mode'] ?? 'single';

render_header($title, $active);
?>

<style>
    .ic-wrap { max-width: 1280px; }

    /* ============ STEP INDICATOR ============ */
    .steps {
        display:flex; align-items:center; justify-content:center;
        gap:8px; margin-bottom:24px; padding:0 10px;
    }
    .step-item {
        display:flex; align-items:center; gap:10px;
        padding:10px 16px; border-radius:12px;
        background:#fff; border:1.5px solid #f1f5f9;
        cursor:pointer; transition:.2s; user-select:none;
        flex:1; max-width:280px;
    }
    .step-item:hover { border-color:#c7d2fe; }
    .step-item.active { border-color:#6366f1; background:#eef2ff; box-shadow:0 4px 12px rgba(99,102,241,0.1); }
    .step-item.done { border-color:#bbf7d0; background:#f0fdf4; }
    .step-num {
        width:32px; height:32px; border-radius:50%;
        background:#f1f5f9; color:#94a3b8;
        display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:14px; flex-shrink:0;
        transition:.2s;
    }
    .step-item.active .step-num { background:#6366f1; color:#fff; }
    .step-item.done .step-num { background:#10b981; color:#fff; }
    .step-body { flex:1; min-width:0; }
    .step-body .lbl { font-size:13px; font-weight:700; color:#0f172a; }
    .step-body .sub { font-size:11px; color:#94a3b8; margin-top:1px; }
    .step-item.active .step-body .lbl { color:#4338ca; }

    .step-line {
        height:2px; background:#e2e8f0; flex:0 0 20px;
        border-radius:1px;
    }
    .step-line.done { background:#10b981; }

    /* ============ MAIN GRID ============ */
    .ic-grid { display:grid; grid-template-columns:2fr 1fr; gap:20px; align-items:start; }
    .ic-col { display:flex; flex-direction:column; gap:14px; }

    /* ============ STEP PANEL ============ */
    .step-panel { display:none; }
    .step-panel.active { display:block; animation: stepFade .3s ease; }
    @keyframes stepFade { from { opacity:0; transform:translateX(10px); } to { opacity:1; transform:none; } }

    .ic-card {
        background:#fff; border-radius:14px; padding:22px;
        box-shadow:0 1px 3px rgba(0,0,0,0.04); border:1px solid #f1f5f9;
    }
    .ic-hd { display:flex; align-items:center; gap:12px; margin-bottom:18px; padding-bottom:14px; border-bottom:1px solid #f1f5f9; }
    .ic-hd .hd-ic {
        width:38px; height:38px; border-radius:10px;
        background:linear-gradient(135deg,#eef2ff,#e0e7ff); color:#6366f1;
        display:flex; align-items:center; justify-content:center;
    }
    .ic-hd h3 { font-size:15px; font-weight:700; color:#0f172a; }
    .ic-hd p { font-size:12px; color:#94a3b8; margin-top:2px; }

    /* Field */
    .ic-field { margin-bottom:14px; }
    .ic-field:last-child { margin-bottom:0; }
    .ic-field label { display:block; font-size:12px; font-weight:600; color:#334155; margin-bottom:6px; }
    .ic-field label .req { color:#ef4444; }
    .ic-field input, .ic-field select, .ic-field textarea {
        width:100%; padding:11px 14px; border:1.5px solid #e2e8f0;
        border-radius:9px; font-size:14px; font-family:inherit; background:#fff;
        transition:.15s;
    }
    .ic-field input:focus, .ic-field select:focus, .ic-field textarea:focus {
        outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12);
    }
    .ic-field small { display:block; color:#94a3b8; font-size:11px; margin-top:5px; }
    .ic-field small code {
        background:#f1f5f9; padding:1px 5px; border-radius:3px;
        font-family:monospace; color:#4f46e5;
    }

    /* Row */
    .ic-row { display:grid; gap:14px; }
    .ic-row-2 { grid-template-columns:1fr 1fr; }

    /* ============ MODE TOGGLE ============ */
    .mode-toggle {
        display:flex; gap:6px; margin-bottom:18px;
        padding:4px; background:#f1f5f9; border-radius:11px;
        width:fit-content;
    }
    .mode-btn {
        display:inline-flex; align-items:center; gap:6px;
        padding:9px 18px; border:none; border-radius:8px;
        background:transparent; color:#64748b;
        font-size:13px; font-weight:600; cursor:pointer;
        transition:.15s; font-family:inherit;
    }
    .mode-btn:hover { color:#334155; }
    .mode-btn.active {
        background:#fff; color:#6366f1;
        box-shadow:0 1px 3px rgba(0,0,0,0.08);
    }

    /* ============ BULK ============ */
    #bulkPanel { display:none; }
    .bulk-preview {
        margin-top:12px; padding:12px 14px;
        background:#f0fdf4; border:1.5px solid #bbf7d0;
        border-radius:10px; font-size:13px;
        display:none;
    }
    .bulk-preview.show { display:block; }
    .bulk-preview .bp-count {
        font-size:16px; font-weight:800; color:#166534;
    }
    .bulk-preview .bp-list {
        margin-top:8px; padding-top:8px;
        border-top:1px solid #bbf7d0;
        max-height:120px; overflow-y:auto;
        font-size:12px; color:#15803d;
        font-family:'Courier New', monospace;
        line-height:1.7;
    }
    .bulk-preview.error {
        background:#fef2f2; border-color:#fecaca;
        color:#991b1b;
    }
    .bulk-preview.error .bp-count { color:#dc2626; }

    /* Items */
    .it-head {
        display:grid; grid-template-columns:2fr 70px 140px 32px;
        gap:10px; padding:0 4px 10px;
        font-size:10px; color:#94a3b8; text-transform:uppercase;
        letter-spacing:.6px; font-weight:700;
    }
    .it-row {
        display:grid; grid-template-columns:2fr 70px 140px 32px;
        gap:10px; margin-bottom:10px; align-items:center;
        animation: itFade .2s ease;
    }
    @keyframes itFade { from { opacity:0; transform:translateY(-4px); } to { opacity:1; transform:none; } }
    .it-row input {
        padding:10px 12px; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:13.5px; width:100%; font-family:inherit;
    }
    .it-row input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
    .it-row .qty { text-align:center; }
    .it-row .hrg { text-align:right; }

    .it-rm {
        width:34px; height:34px; border-radius:8px; border:1.5px solid #fecaca;
        background:#fff; color:#ef4444; cursor:pointer;
        display:flex; align-items:center; justify-content:center;
        transition:.15s; padding:0;
    }
    .it-rm:hover { background:#fef2f2; }

    .add-btn {
        display:inline-flex; align-items:center; gap:6px;
        padding:9px 14px; background:#fff; color:#4f46e5;
        border:1.5px dashed #c7d2fe; border-radius:9px;
        font-size:13px; font-weight:600; cursor:pointer;
        transition:.15s; margin-top:4px; font-family:inherit;
    }
    .add-btn:hover { background:#eef2ff; border-color:#818cf8; }

    /* Adjustments */
    .adj-head {
        display:grid; grid-template-columns:130px 1fr 70px 110px 32px;
        gap:10px; padding:0 4px 10px;
        font-size:10px; color:#94a3b8; text-transform:uppercase;
        letter-spacing:.6px; font-weight:700;
    }
    .adj-row {
        display:grid; grid-template-columns:130px 1fr 70px 110px 32px;
        gap:10px; margin-bottom:10px; align-items:center;
        animation: itFade .2s ease;
    }
    .adj-row select, .adj-row input {
        padding:10px 12px; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:13.5px; font-family:inherit; background:#fff; width:100%;
    }
    .adj-row select:focus, .adj-row input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }

    /* Kode unik */
    .ku-toggle {
        display:flex; align-items:center; gap:10px;
        padding:12px 14px; background:#f8fafc;
        border:1.5px solid #e2e8f0; border-radius:10px; cursor:pointer;
    }
    .ku-toggle input { width:18px; height:18px; accent-color:#6366f1; }
    .ku-toggle span { font-size:13.5px; color:#334155; font-weight:500; }

    .ku-input-wrap { display:flex; gap:8px; }
    .ku-input-wrap input {
        flex:1; padding:10px 13px; border:1.5px solid #e2e8f0;
        border-radius:9px; font-size:14px; font-family:inherit;
    }
    .ku-input-wrap input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
    .ku-dice {
        padding:0 16px; background:#f8fafc; color:#6366f1;
        border:1.5px solid #e2e8f0; border-radius:9px;
        cursor:pointer; display:flex; align-items:center; justify-content:center;
        transition:.15s; font-family:inherit;
    }
    .ku-dice:hover { background:#eef2ff; border-color:#c7d2fe; }

    /* Metode grid */
    .mt-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:10px; }
    .mt-pick {
        display:flex; align-items:center; gap:10px;
        padding:12px 13px; border:1.5px solid #e2e8f0; border-radius:10px;
        cursor:pointer; transition:.15s; user-select:none; position:relative;
    }
    .mt-pick:hover { border-color:#c7d2fe; background:#fafbff; }
    .mt-pick.checked { border-color:#6366f1; background:#eef2ff; }
    .mt-pick input { position:absolute; opacity:0; pointer-events:none; }
    .mt-pick .pick-ic {
        width:36px; height:36px; border-radius:9px;
        background:#f1f5f9; color:#64748b;
        display:flex; align-items:center; justify-content:center;
        overflow:hidden; flex-shrink:0;
    }
    .mt-pick.checked .pick-ic { background:#fff; color:#6366f1; }
    .mt-pick .pick-ic img { width:100%; height:100%; object-fit:contain; padding:4px; }
    .mt-pick .pick-nm { font-size:13px; font-weight:600; color:#334155; line-height:1.3; }
    .mt-pick.checked .pick-nm { color:#4338ca; }
    .mt-pick .pick-type { font-size:10px; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; font-weight:600; margin-top:1px; }

    /* ============ TEMPLATE PICKER ============ */
    .tpl-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
    .tpl-pick {
        border:1.5px solid #e2e8f0; border-radius:11px;
        padding:12px 14px; cursor:pointer; transition:.15s;
        user-select:none; position:relative;
        background:#fff;
    }
    .tpl-pick:hover { border-color:#c7d2fe; background:#fafbff; }
    .tpl-pick.checked { border-color:#25d366; background:#f0fdf4; box-shadow:0 0 0 3px rgba(37,211,102,0.1); }
    .tpl-pick input { position:absolute; opacity:0; pointer-events:none; }

    .tpl-pick-hd {
        display:flex; align-items:center; gap:8px; margin-bottom:8px;
    }
    .tpl-pick-hd .tpl-ic {
        width:30px; height:30px; border-radius:8px;
        background:linear-gradient(135deg,#dcfce7,#bbf7d0); color:#16a34a;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .tpl-pick.checked .tpl-ic { background:linear-gradient(135deg,#25d366,#128c7e); color:#fff; }
    .tpl-pick-hd .tpl-nm {
        font-size:13px; font-weight:700; color:#0f172a; line-height:1.3;
        flex:1; min-width:0;
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    }
    .tpl-pick-hd .tpl-check {
        width:20px; height:20px; border-radius:50%;
        border:2px solid #cbd5e1; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        transition:.15s;
    }
    .tpl-pick.checked .tpl-check {
        background:#25d366; border-color:#25d366;
    }
    .tpl-pick.checked .tpl-check::after {
        content:''; width:6px; height:10px;
        border:solid white; border-width:0 2px 2px 0;
        transform:rotate(45deg); margin-top:-2px;
    }

    .tpl-pick-prev {
        font-size:11.5px; color:#64748b; line-height:1.5;
        max-height:44px; overflow:hidden;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
        white-space:pre-wrap;
    }

    .tpl-pick-tipe {
        display:inline-block; padding:2px 7px; border-radius:5px;
        font-size:9.5px; font-weight:700; text-transform:uppercase;
        letter-spacing:.4px; margin-top:8px;
    }
    .tpl-pick-tipe.tagihan_baru { background:#dbeafe; color:#1e40af; }
    .tpl-pick-tipe.reminder { background:#fef3c7; color:#92400e; }
    .tpl-pick-tipe.approved { background:#dcfce7; color:#166534; }
    .tpl-pick-tipe.rejected { background:#fee2e2; color:#991b1b; }
    .tpl-pick-tipe.custom { background:#f1f5f9; color:#475569; }

    .tpl-empty {
        text-align:center; padding:24px; background:#f8fafc;
        border-radius:10px; border:1.5px dashed #cbd5e1;
        font-size:13px; color:#94a3b8;
    }
    .tpl-empty a { color:#6366f1; font-weight:600; }

    /* Summary (kanan) */
    .ic-summary { position:sticky; top:20px; display:flex; flex-direction:column; gap:14px; }

    .sum-card {
        background:linear-gradient(160deg, #0f172a 0%, #1e293b 100%);
        border-radius:16px; padding:22px; color:#fff;
        box-shadow:0 10px 30px rgba(15,23,42,0.18);
    }
    .sum-card h3 { font-size:11px; text-transform:uppercase; letter-spacing:1.2px; opacity:.55; margin-bottom:16px; font-weight:700; }
    .sum-line { display:flex; justify-content:space-between; font-size:13px; padding:6px 0; color:#cbd5e1; gap:8px; }
    .sum-line.diskon { color:#fca5a5; }
    .sum-line.tambah { color:#86efac; }
    .sum-line .v { font-variant-numeric:tabular-nums; font-weight:600; }
    .sum-total {
        display:flex; justify-content:space-between; align-items:center;
        padding:14px 0 0; margin-top:12px;
        border-top:1px solid rgba(255,255,255,0.15);
        font-size:14px; font-weight:700;
    }
    .sum-total .amt { color:#a5b4fc; font-size:22px; font-variant-numeric:tabular-nums; font-weight:800; }

    /* Bulk indicator di summary */
    .bulk-indicator {
        background:linear-gradient(135deg,#dcfce7,#bbf7d0);
        border-radius:10px; padding:12px 14px;
        display:none; align-items:center; gap:10px;
        font-size:13px; font-weight:600; color:#166534;
        margin-top:12px;
    }
    .bulk-indicator.show { display:flex; }
    .bulk-indicator .bi-count {
        font-size:20px; font-weight:800;
        margin-left:auto;
    }

    /* WA card */
    .wa-card { background:#fff; border-radius:14px; padding:16px; box-shadow:0 1px 3px rgba(0,0,0,0.04); border:1px solid #f1f5f9; }
    .wa-hd { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
    .wa-hd .wa-logo {
        width:34px; height:34px; border-radius:9px;
        background:linear-gradient(135deg,#25d366,#128c7e); color:#fff;
        display:flex; align-items:center; justify-content:center;
    }
    .wa-hd h4 { font-size:13px; font-weight:700; color:#0f172a; }
    .wa-hd p { font-size:11px; color:#94a3b8; margin-top:1px; }
    .wa-hd .tpl-info {
        margin-left:auto; font-size:10px; font-weight:700;
        background:#dcfce7; color:#166534;
        padding:3px 8px; border-radius:10px;
        max-width:120px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
    }

    .wa-box { background:#e5ddd5; border-radius:11px; padding:12px; }
    .wa-bubble {
        background:#dcf8c6; border-radius:9px;
        padding:11px 13px; font-size:12px; line-height:1.55;
        color:#111; white-space:pre-wrap; word-break:break-word;
        max-height:280px; overflow-y:auto; position:relative;
    }
    .wa-bubble::-webkit-scrollbar { width:4px; }
    .wa-bubble::-webkit-scrollbar-thumb { background:rgba(0,0,0,0.15); border-radius:2px; }

    .wa-send {
        display:flex; align-items:center; gap:10px;
        padding:12px 14px; background:#f0fdf4;
        border:1.5px solid #bbf7d0; border-radius:10px;
        cursor:pointer; margin-top:12px;
    }
    .wa-send input { width:18px; height:18px; accent-color:#25d366; }
    .wa-send .txt .t1 { font-size:13px; font-weight:600; color:#166534; }
    .wa-send .txt .t2 { font-size:11px; color:#4ade80; margin-top:1px; }
    .wa-send .ic-wa { color:#25d366; margin-left:auto; }

    /* Nav buttons */
    .nav-btns {
        display:flex; gap:10px; margin-top:16px; padding:14px 18px;
        background:#fff; border-radius:14px;
        box-shadow:0 4px 14px rgba(0,0,0,0.06); border:1px solid #f1f5f9;
        position:sticky; bottom:10px; z-index:5;
        align-items:center;
    }
    .nav-btns .btn-prev {
        padding:13px 22px; background:#fff; color:#475569;
        border:1.5px solid #e2e8f0; border-radius:10px;
        cursor:pointer; font-size:14px; font-weight:600;
        display:inline-flex; align-items:center; gap:6px;
        font-family:inherit; transition:.15s;
    }
    .nav-btns .btn-prev:hover { border-color:#c7d2fe; color:#6366f1; }
    .nav-btns .btn-next {
        flex:1; padding:13px 22px;
        background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff;
        border:none; border-radius:10px;
        cursor:pointer; font-size:14px; font-weight:600;
        display:inline-flex; align-items:center; justify-content:center; gap:6px;
        font-family:inherit; transition:.15s;
        box-shadow:0 4px 12px rgba(99,102,241,0.25);
    }
    .nav-btns .btn-next:hover { opacity:.92; transform:translateY(-1px); }
    .nav-btns .btn-submit { background:linear-gradient(135deg,#10b981,#22c55e); box-shadow:0 4px 12px rgba(16,185,129,0.25); }
    .nav-btns .step-info { font-size:12px; color:#94a3b8; font-weight:600; margin-right:auto; padding-right:10px; }

    /* Alert */
    .ic-alert {
        display:flex; align-items:flex-start; gap:10px;
        padding:12px 14px; border-radius:10px; font-size:13px;
        border-left:4px solid #ef4444; background:#fef2f2; color:#991b1b;
        margin-bottom:14px;
    }

    /* Responsive */
    @media (max-width:1024px) {
        .ic-grid { grid-template-columns:1fr; }
        .ic-summary { position:static; }
    }
    @media (max-width:640px) {
        .steps { flex-wrap:wrap; gap:6px; }
        .step-item { padding:8px 12px; min-width:0; }
        .step-body .sub { display:none; }
        .step-line { display:none; }
        .ic-card { padding:16px; }
        .ic-row-2 { grid-template-columns:1fr; }
        .it-head, .adj-head { display:none; }
        .it-row { grid-template-columns:1fr 60px 110px 30px; gap:6px; }
        .adj-row { grid-template-columns:1fr 1fr; gap:6px; margin-bottom:12px; padding:10px; background:#f8fafc; border-radius:9px; }
        .adj-row .adj-rm { grid-column:2; justify-self:end; }
        .mt-grid { grid-template-columns:1fr 1fr; }
        .tpl-grid { grid-template-columns:1fr; }
        .nav-btns { flex-wrap:wrap; padding:12px; }
        .nav-btns .step-info { display:none; }
        .nav-btns .btn-prev { order:2; flex:1; justify-content:center; }
        .nav-btns .btn-next { order:1; flex:1 1 100%; }
        .mode-toggle { width:100%; }
        .mode-btn { flex:1; justify-content:center; }
    }
</style>

<div class="ic-wrap">

    <?php if ($err = flash('error')): ?>
        <div class="ic-alert">
            <?= ic_icon('alert', 18) ?>
            <div><?= e($err) ?></div>
        </div>
    <?php endif; ?>

    <form method="POST" id="formInvoice">

    <!-- Hidden input untuk mode -->
    <input type="hidden" name="mode" id="modeInput" value="<?= e($initial_mode) ?>">

    <!-- ============ STEP INDICATOR ============ -->
    <div class="steps" id="stepNav">
        <div class="step-item active" data-step="1" onclick="gotoStep(1)">
            <div class="step-num">1</div>
            <div class="step-body">
                <div class="lbl">Pembayar</div>
                <div class="sub">Data & tagihan</div>
            </div>
        </div>
        <div class="step-line" data-line="1"></div>
        <div class="step-item" data-step="2" onclick="gotoStep(2)">
            <div class="step-num">2</div>
            <div class="step-body">
                <div class="lbl">Biaya</div>
                <div class="sub">Item & penyesuaian</div>
            </div>
        </div>
        <div class="step-line" data-line="2"></div>
        <div class="step-item" data-step="3" onclick="gotoStep(3)">
            <div class="step-num">3</div>
            <div class="step-body">
                <div class="lbl">Pembayaran</div>
                <div class="sub">Metode & template</div>
            </div>
        </div>
    </div>

    <div class="ic-grid">

        <!-- ============ KIRI: FORM ============ -->
        <div class="ic-col">

            <!-- ========== STEP 1 ========== -->
            <div class="step-panel active" data-panel="1">

                <!-- MODE TOGGLE -->
                <div class="mode-toggle">
                    <button type="button" class="mode-btn active" id="modeSingle" onclick="setMode('single')">
                        <?= ic_icon('user', 16) ?> Single
                    </button>
                    <button type="button" class="mode-btn" id="modeBulk" onclick="setMode('bulk')">
                        <?= ic_icon('users', 16) ?> Bulk (Massal)
                    </button>
                </div>

                <div class="ic-card">
                    <div class="ic-hd">
                        <div class="hd-ic"><?= ic_icon('user', 20) ?></div>
                        <div>
                            <h3 id="penerimaTitle">Data Pembayar</h3>
                            <p id="penerimaSub">Siapa yang mau ditagih?</p>
                        </div>
                    </div>

                    <!-- SINGLE MODE -->
                    <div id="singlePanel">
                        <div class="ic-row ic-row-2">
                            <div class="ic-field" style="margin-bottom:0;">
                                <label>Nama Pembayar <span class="req">*</span></label>
                                <input type="text" name="nama_pembayar" id="inpNama" maxlength="150"
                                       value="<?= e($old['nama_pembayar'] ?? '') ?>"
                                       placeholder="misal: Budi Santoso"
                                       oninput="validateStep1(); updateWaPreview()">
                            </div>
                            <div class="ic-field" style="margin-bottom:0;">
                                <label>Nomor WA <span class="req">*</span></label>
                                <input type="text" name="nomor_wa" id="inpWa" maxlength="20"
                                       value="<?= e($old['nomor_wa'] ?? '') ?>"
                                       placeholder="08123456789"
                                       oninput="validateStep1(); updateWaPreview()">
                            </div>
                        </div>

                        <div class="ic-field" style="margin-top:14px;">
                            <label>Email (opsional)</label>
                            <input type="email" name="email" maxlength="150"
                                   value="<?= e($old['email'] ?? '') ?>"
                                   placeholder="budi@email.com">
                        </div>
                    </div>

                    <!-- BULK MODE -->
                    <div id="bulkPanel">
                        <div class="ic-field">
                            <label>Daftar Penerima <span class="req">*</span></label>
                            <textarea name="bulk_list" id="bulkList" rows="10"
                                      placeholder="Format: Nama|NomorWA|Email(opsional)
Satu penerima per baris. Bisa paste langsung dari Excel.

Contoh:
Budi Santoso|08123456789
Ani Wijaya|08123456790|ani@mail.com
Citra Dewi|08123456791"
                                      oninput="previewBulk(); validateStep1(); updateWaPreview()"><?= e($old['bulk_list'] ?? '') ?></textarea>
                            <small>Delimiter: <code>|</code> atau <code>,</code> atau <code>TAB</code> (paste dari Excel) — Email opsional.</small>
                        </div>

                        <div id="bulkPreview" class="bulk-preview"></div>
                    </div>
                </div>

                <div class="ic-card" style="margin-top:14px;">
                    <div class="ic-hd">
                        <div class="hd-ic"><?= ic_icon('file', 20) ?></div>
                        <div>
                            <h3>Detail Tagihan</h3>
                            <p>Tentang tagihannya apa (sama untuk semua)</p>
                        </div>
                    </div>

                    <div class="ic-row ic-row-2">
                        <div class="ic-field" style="margin-bottom:0;">
                            <label>Kategori</label>
                            <select name="kategori_id" id="inpKategori">
                                <option value="">— Tanpa Kategori —</option>
                                <?php foreach ($kategoris as $k): ?>
                                    <option value="<?= $k['id'] ?>" <?= ($old['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                                        <?= e($k['nama']) ?> (<?= e($k['kode_prefix']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="ic-field" style="margin-bottom:0;">
                            <label>Jatuh Tempo <span class="req">*</span></label>
                            <input type="datetime-local" name="expired_at" id="inpExpired" required
                                   value="<?= e($old['expired_at'] ?? '') ?>"
                                   oninput="validateStep1()">
                        </div>
                    </div>

                    <div class="ic-field" style="margin-top:14px;">
                        <label>Deskripsi Tagihan <span class="req">*</span></label>
                        <textarea name="deskripsi" id="inpDeskripsi" required rows="3"
                                  placeholder="misal: Iuran kelas psikologi bulan Oktober 2026"
                                  oninput="validateStep1()"><?= e($old['deskripsi'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- ========== STEP 2 ========== -->
            <div class="step-panel" data-panel="2">
                <div class="ic-card">
                    <div class="ic-hd">
                        <div class="hd-ic"><?= ic_icon('package', 20) ?></div>
                        <div>
                            <h3>Item Biaya</h3>
                            <p>Rincian komponen biaya tagihan (sama untuk semua)</p>
                        </div>
                    </div>

                    <div class="it-head">
                        <div>Nama Item</div>
                        <div style="text-align:center;">Qty</div>
                        <div style="text-align:right;">Harga Satuan</div>
                        <div></div>
                    </div>

                    <div id="itemsWrap">
                        <?php foreach ($old_items as $i => $it): ?>
                        <div class="it-row">
                            <input type="text" name="items[<?= $i ?>][nama_item]" placeholder="misal: Biaya Kelas"
                                   value="<?= e($it['nama_item'] ?? '') ?>" oninput="calc(); validateStep2()">
                            <input type="number" name="items[<?= $i ?>][qty]" class="qty" placeholder="1" min="0" step="any"
                                   value="<?= e($it['qty'] ?? 1) ?>" oninput="calc(); validateStep2()">
                            <input type="number" name="items[<?= $i ?>][harga_satuan]" class="hrg" placeholder="0" min="0" step="any"
                                   value="<?= e($it['harga_satuan'] ?? '') ?>" oninput="calc(); validateStep2()">
                            <button type="button" class="it-rm" onclick="removeItem(this)" title="Hapus">
                                <?= ic_icon('trash', 14) ?>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="add-btn" onclick="addItem()">
                        <?= ic_icon('plus', 14) ?> Tambah Item
                    </button>
                </div>

                <div class="ic-card" style="margin-top:14px;">
                    <div class="ic-hd">
                        <div class="hd-ic"><?= ic_icon('percent', 20) ?></div>
                        <div>
                            <h3>Penyesuaian (opsional)</h3>
                            <p>Diskon, biaya admin, atau pajak</p>
                        </div>
                    </div>

                    <div class="adj-head">
                        <div>Tipe</div>
                        <div>Label</div>
                        <div>Mode</div>
                        <div style="text-align:right;">Nilai</div>
                        <div></div>
                    </div>

                    <div id="adjWrap">
                        <?php foreach ($old_adj as $i => $ad): ?>
                        <div class="adj-row">
                            <select name="adjustments[<?= $i ?>][tipe]" onchange="calc()">
                                <option value="diskon" <?= ($ad['tipe']??'')==='diskon'?'selected':'' ?>>Diskon</option>
                                <option value="biaya_admin" <?= ($ad['tipe']??'')==='biaya_admin'?'selected':'' ?>>Biaya Admin</option>
                                <option value="pajak" <?= ($ad['tipe']??'')==='pajak'?'selected':'' ?>>Pajak / PPN</option>
                            </select>
                            <input type="text" name="adjustments[<?= $i ?>][label]" placeholder="Label (opsional)"
                                   value="<?= e($ad['label'] ?? '') ?>">
                            <select name="adjustments[<?= $i ?>][mode]" onchange="calc()">
                                <option value="nominal" <?= ($ad['mode']??'')==='nominal'?'selected':'' ?>>Rp</option>
                                <option value="persen" <?= ($ad['mode']??'')==='persen'?'selected':'' ?>>%</option>
                            </select>
                            <input type="number" name="adjustments[<?= $i ?>][nilai]" placeholder="0" min="0" step="any"
                                   value="<?= e($ad['nilai'] ?? '') ?>" oninput="calc()">
                            <button type="button" class="it-rm adj-rm" onclick="removeAdj(this)" title="Hapus">
                                <?= ic_icon('trash', 14) ?>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="add-btn" onclick="addAdj()">
                        <?= ic_icon('plus', 14) ?> Tambah Penyesuaian
                    </button>
                </div>

                <div class="ic-card" style="margin-top:14px;">
                    <div class="ic-hd">
                        <div class="hd-ic"><?= ic_icon('hash', 20) ?></div>
                        <div>
                            <h3>Kode Unik</h3>
                            <p>Nomor unik buat cocokin transfer</p>
                        </div>
                    </div>

                    <label class="ku-toggle">
                        <input type="checkbox" name="pakai_kode_unik" id="pakaiKu"
                               <?= !empty($old['pakai_kode_unik']) ? 'checked' : '' ?>
                               onchange="toggleKu(); calc()">
                        <span>Aktifkan kode unik</span>
                    </label>

                    <div id="kuBox" style="display:<?= !empty($old['pakai_kode_unik']) ? 'block' : 'none' ?>; margin-top:12px;">
                        <div class="ku-input-wrap">
                            <input type="number" name="kode_unik" id="kuInput"
                                   min="0" max="999" value="<?= e($old['kode_unik'] ?? random_int(1, 999)) ?>"
                                   placeholder="Contoh: 34" oninput="calc()">
                            <button type="button" class="ku-dice" onclick="randomKu()" title="Acak">
                                <?= ic_icon('hash', 16) ?>
                            </button>
                        </div>
                        <small style="display:block; color:#94a3b8; font-size:11px; margin-top:6px;">
                            ⚠ Kalau <strong>Bulk Mode</strong>, tiap invoice dapet kode unik random beda otomatis.
                        </small>
                    </div>
                </div>
            </div>

            <!-- ========== STEP 3 ========== -->
            <div class="step-panel" data-panel="3">
                <div class="ic-card">
                    <div class="ic-hd">
                        <div class="hd-ic"><?= ic_icon('card', 20) ?></div>
                        <div>
                            <h3>Metode Pembayaran</h3>
                            <p>Pilih metode yang ditampilkan ke pembayar</p>
                        </div>
                    </div>

                    <?php if (empty($metodes)): ?>
                        <p style="color:#94a3b8; font-size:13px; text-align:center; padding:20px;">
                            Belum ada metode aktif.
                            <a href="<?= url('metode&action=create') ?>" style="color:#6366f1; font-weight:600;">Tambah dulu →</a>
                        </p>
                    <?php else: ?>
                        <div class="mt-grid" id="metodeWrap">
                            <?php foreach ($metodes as $m): ?>
                                <?php
                                $jenisIcon = ['qris'=>'qris','bank'=>'bank','ewallet'=>'wallet','custom'=>'card'][$m['jenis']] ?? 'card';
                                $isChecked = empty($old) || in_array($m['id'], $old['metode_ids'] ?? [1]);
                                ?>
                                <label class="mt-pick <?= $isChecked ? 'checked' : '' ?>">
                                    <input type="checkbox" name="metode_ids[]" value="<?= $m['id'] ?>"
                                           <?= $isChecked ? 'checked' : '' ?>
                                           onchange="this.parentElement.classList.toggle('checked', this.checked); validateStep3()">
                                    <div class="pick-ic">
                                        <?php if ($m['logo'] && file_exists(UPLOAD_PATH . '/' . $m['logo'])): ?>
                                            <img src="<?= UPLOAD_URL . '/' . e($m['logo']) ?>" alt="">
                                        <?php else: ?>
                                            <?= ic_icon($jenisIcon, 18) ?>
                                        <?php endif; ?>
                                    </div>
                                    <div style="flex:1; min-width:0;">
                                        <div class="pick-nm"><?= e($m['nama']) ?></div>
                                        <div class="pick-type"><?= e($m['provider'] ?: strtoupper($m['jenis'])) ?></div>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- TEMPLATE WA PICKER -->
                <div class="ic-card" style="margin-top:14px;">
                    <div class="ic-hd">
                        <div class="hd-ic" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0); color:#16a34a;">
                            <?= ic_icon('message', 20) ?>
                        </div>
                        <div>
                            <h3>Template WhatsApp</h3>
                            <p>Pilih template pesan yang akan dikirim</p>
                        </div>
                    </div>

                    <?php if (empty($wa_templates)): ?>
                        <div class="tpl-empty">
                            Belum ada template WA aktif.
                            <a href="<?= url('wa-template&action=create') ?>">Buat template dulu →</a>
                        </div>
                    <?php else: ?>
                        <div class="tpl-grid" id="tplGrid">
                            <?php foreach ($wa_templates as $t): ?>
                                <?php
                                $isSel = (int)$t['id'] === $selected_template_id;
                                $tipeLabel = [
                                    'tagihan_baru'=>'Tagihan Baru','reminder'=>'Reminder',
                                    'approved'=>'Approved','rejected'=>'Rejected','custom'=>'Custom'
                                ][$t['tipe']] ?? $t['tipe'];
                                ?>
                                <label class="tpl-pick <?= $isSel ? 'checked' : '' ?>"
                                       data-tpl-id="<?= (int)$t['id'] ?>"
                                       onclick="selectTemplate(<?= (int)$t['id'] ?>, this)">
                                    <input type="radio" name="template_id" value="<?= (int)$t['id'] ?>"
                                           <?= $isSel ? 'checked' : '' ?>>
                                    <div class="tpl-pick-hd">
                                        <div class="tpl-ic"><?= ic_wa_filled(15) ?></div>
                                        <div class="tpl-nm"><?= e($t['nama']) ?></div>
                                        <div class="tpl-check"></div>
                                    </div>
                                    <div class="tpl-pick-prev"><?= e(mb_substr($t['isi'], 0, 120)) ?><?= mb_strlen($t['isi']) > 120 ? '...' : '' ?></div>
                                    <span class="tpl-pick-tipe <?= e($t['tipe']) ?>"><?= e($tipeLabel) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="ic-card" style="margin-top:14px;">
                    <div class="ic-hd">
                        <div class="hd-ic"><?= ic_icon('note', 20) ?></div>
                        <div>
                            <h3>Catatan (opsional)</h3>
                            <p>Catatan tambahan untuk tagihan ini</p>
                        </div>
                    </div>

                    <div class="ic-row ic-row-2">
                        <div class="ic-field" style="margin-bottom:0;">
                            <label>Catatan untuk Pembayar</label>
                            <textarea name="catatan_user" rows="3"
                                      placeholder="Kelihatan user di halaman bayar"><?= e($old['catatan_user'] ?? '') ?></textarea>
                        </div>
                        <div class="ic-field" style="margin-bottom:0;">
                            <label>Catatan Internal <?= ic_icon('lock', 11) ?></label>
                            <textarea name="internal_note" rows="3"
                                      placeholder="Cuma kelihatan admin"><?= e($old['internal_note'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ============ KANAN: SUMMARY ============ -->
        <div class="ic-summary">

            <div class="sum-card">
                <h3>Ringkasan</h3>

                <div class="sum-line">
                    <span>Subtotal</span>
                    <span class="v" id="sSubtotal">Rp 0</span>
                </div>

                <div id="sAdjList"></div>

                <div class="sum-total">
                    <span>Total</span>
                    <span class="amt" id="sTotal">Rp 0</span>
                </div>

                <div class="bulk-indicator" id="bulkIndicator">
                    <?= ic_icon('users', 18) ?>
                    <span>× <strong>Bulk</strong></span>
                    <span class="bi-count" id="biCount">0</span>
                </div>
            </div>

            <div class="wa-card">
                <div class="wa-hd">
                    <div class="wa-logo"><?= ic_wa_filled(18) ?></div>
                    <div>
                        <h4>Preview WhatsApp</h4>
                        <p>Pesan yang akan dikirim</p>
                    </div>
                    <span class="tpl-info" id="tplInfo" title="">—</span>
                </div>

                <div class="wa-box">
                    <div class="wa-bubble" id="waPrev">Halo Budi, berikut tagihan...</div>
                </div>

                <label class="wa-send">
                    <input type="checkbox" name="kirim_wa" value="1" checked>
                    <div class="txt">
                        <div class="t1">Kirim WA setelah simpan</div>
                        <div class="t2" id="waSendSub">Tab WhatsApp otomatis kebuka</div>
                    </div>
                    <span class="ic-wa"><?= ic_wa_filled(18) ?></span>
                </label>
            </div>

        </div>

    </div>

    <!-- ============ NAV BUTTONS ============ -->
    <div class="nav-btns">
        <span class="step-info" id="stepInfo">Langkah 1 dari 3</span>
        <button type="button" class="btn-prev" id="btnPrev" onclick="prevStep()" style="display:none;">
            <?= ic_icon('arrowL', 16) ?> Kembali
        </button>
        <button type="button" class="btn-next" id="btnNext" onclick="nextStep()">
            Selanjutnya <?= ic_icon('arrowR', 16) ?>
        </button>
        <button type="submit" class="btn-next btn-submit" id="btnSubmit" style="display:none;">
            <?= ic_icon('check', 18) ?> Simpan Tagihan
        </button>
        <a href="<?= url('invoice') ?>" class="btn-prev" id="btnCancel">Batal</a>
    </div>

    </form>

</div>

<script>
// ============ STATE ============
let currentStep = 1;
const TOTAL_STEPS = 3;
let itemIdx = <?= count($old_items) ?>;
let adjIdx = <?= count($old_adj) ?>;
let currentMode = '<?= e($initial_mode) ?>';

// ============ TEMPLATE DATA ============
const TEMPLATES = <?= json_encode(array_map(function($t){
    return ['id' => (int)$t['id'], 'nama' => $t['nama'], 'isi' => $t['isi'], 'tipe' => $t['tipe']];
}, $wa_templates)) ?>;

let selectedTemplateId = <?= (int)$selected_template_id ?>;

// ============ MODE ============
function setMode(mode) {
    currentMode = mode;
    document.getElementById('modeInput').value = mode;
    document.getElementById('modeSingle').classList.toggle('active', mode === 'single');
    document.getElementById('modeBulk').classList.toggle('active', mode === 'bulk');

    document.getElementById('singlePanel').style.display = mode === 'single' ? 'block' : 'none';
    document.getElementById('bulkPanel').style.display = mode === 'bulk' ? 'block' : 'none';

    document.getElementById('penerimaTitle').textContent = mode === 'single' ? 'Data Pembayar' : 'Data Penerima (Bulk)';
    document.getElementById('penerimaSub').textContent = mode === 'single' ? 'Siapa yang mau ditagih?' : 'Daftar penerima tagihan massal';

    // Required toggle
    const inpNama = document.getElementById('inpNama');
    const inpWa = document.getElementById('inpWa');
    const bulkList = document.getElementById('bulkList');

    if (mode === 'single') {
        inpNama.required = true;
        inpWa.required = true;
        bulkList.required = false;
    } else {
        inpNama.required = false;
        inpWa.required = false;
        bulkList.required = true;
    }

    updateBulkIndicator();
    updateWaPreview();
}

// ============ BULK PARSE ============
function parseBulkList(text) {
    const lines = text.split('\n').map(l => l.trim()).filter(l => l !== '');
    const result = [];
    const errors = [];

    lines.forEach((line, idx) => {
        let parts;
        if (line.includes('|')) parts = line.split('|');
        else if (line.includes('\t')) parts = line.split('\t');
        else if (line.includes(',')) parts = line.split(',');
        else parts = [line];

        parts = parts.map(p => p.trim());

        const nama = parts[0] || '';
        const wa   = (parts[1] || '').replace(/\D/g, '');
        const em   = parts[2] || '';

        if (!nama || !wa) {
            errors.push(`Baris ${idx + 1}`);
            return;
        }
        result.push({ nama, wa, email: em });
    });

    return { result, errors };
}

function previewBulk() {
    const text = document.getElementById('bulkList').value;
    const box = document.getElementById('bulkPreview');
    if (!text.trim()) {
        box.classList.remove('show');
        updateBulkIndicator();
        return;
    }

    const { result, errors } = parseBulkList(text);

    if (!result.length) {
        box.className = 'bulk-preview show error';
        box.innerHTML = `<strong>Format tidak valid</strong><br>Pastikan tiap baris minimal: Nama|NomorWA`;
        updateBulkIndicator();
        return;
    }

    box.className = 'bulk-preview show';
    box.innerHTML = `
        <div>✓ <span class="bp-count">${result.length}</span> penerima terdeteksi</div>
        ${errors.length ? `<div style="color:#d97706; font-size:12px; margin-top:6px;">⚠ ${errors.length} baris dilewati (format salah)</div>` : ''}
        <div class="bp-list">
            ${result.slice(0, 10).map(r => `• ${r.nama} — ${r.wa}`).join('<br>')}
            ${result.length > 10 ? `<br>... dan ${result.length - 10} lainnya` : ''}
        </div>
    `;
    updateBulkIndicator();
}

function updateBulkIndicator() {
    const el = document.getElementById('bulkIndicator');
    const cnt = document.getElementById('biCount');
    const sendSub = document.getElementById('waSendSub');

    if (currentMode === 'bulk') {
        const { result } = parseBulkList(document.getElementById('bulkList').value);
        el.classList.add('show');
        cnt.textContent = result.length;
        sendSub.textContent = result.length > 1
            ? `${result.length} tab WhatsApp kebuka (aktifkan popup)`
            : 'Tab WhatsApp otomatis kebuka';
    } else {
        el.classList.remove('show');
        sendSub.textContent = 'Tab WhatsApp otomatis kebuka';
    }
}

// ============ TEMPLATE PICKER ============
function selectTemplate(id, el) {
    selectedTemplateId = id;
    document.querySelectorAll('#tplGrid .tpl-pick').forEach(p => p.classList.remove('checked'));
    if (el) el.classList.add('checked');

    const radio = el.querySelector('input[type=radio]');
    if (radio) radio.checked = true;

    updateTplInfo();
    updateWaPreview();
}

function updateTplInfo() {
    const tpl = TEMPLATES.find(t => t.id === selectedTemplateId);
    const info = document.getElementById('tplInfo');
    if (tpl) {
        info.textContent = tpl.nama;
        info.title = tpl.nama;
    } else {
        info.textContent = '—';
    }
}

// ============ NAVIGATION ============
function gotoStep(step) {
    if (step < 1 || step > TOTAL_STEPS) return;
    if (step > currentStep) {
        if (currentStep === 1 && !validateStep1(true)) return;
        if (currentStep === 2 && !validateStep2(true)) return;
    }
    currentStep = step;
    renderStep();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep() {
    if (currentStep === 1 && !validateStep1(true)) return;
    if (currentStep === 2 && !validateStep2(true)) return;
    if (currentStep < TOTAL_STEPS) {
        currentStep++;
        renderStep();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        renderStep();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function renderStep() {
    document.querySelectorAll('.step-panel').forEach(p => {
        p.classList.toggle('active', parseInt(p.dataset.panel) === currentStep);
    });

    document.querySelectorAll('#stepNav .step-item').forEach(s => {
        const num = parseInt(s.dataset.step);
        s.classList.toggle('active', num === currentStep);
        s.classList.toggle('done', num < currentStep);

        const numEl = s.querySelector('.step-num');
        if (num < currentStep) {
            numEl.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
        } else {
            numEl.textContent = num;
        }
    });

    document.querySelectorAll('#stepNav .step-line').forEach(l => {
        const ln = parseInt(l.dataset.line);
        l.classList.toggle('done', currentStep > ln);
    });

    document.getElementById('btnPrev').style.display = currentStep > 1 ? 'inline-flex' : 'none';
    document.getElementById('btnNext').style.display = currentStep < TOTAL_STEPS ? 'inline-flex' : 'none';
    document.getElementById('btnSubmit').style.display = currentStep === TOTAL_STEPS ? 'inline-flex' : 'none';
    document.getElementById('stepInfo').textContent = 'Langkah ' + currentStep + ' dari ' + TOTAL_STEPS;
}

// ============ VALIDASI ============
function validateStep1(showAlert) {
    const exp  = document.getElementById('inpExpired').value;
    const desk = document.getElementById('inpDeskripsi').value.trim();

    let msg = '';
    if (!exp) msg = 'Tanggal jatuh tempo wajib diisi.';
    else if (!desk) msg = 'Deskripsi tagihan wajib diisi.';

    if (!msg) {
        if (currentMode === 'single') {
            const nama = document.getElementById('inpNama').value.trim();
            const wa   = document.getElementById('inpWa').value.trim();
            if (!nama) msg = 'Nama pembayar wajib diisi.';
            else if (!wa) msg = 'Nomor WA wajib diisi.';
        } else {
            const text = document.getElementById('bulkList').value;
            const { result } = parseBulkList(text);
            if (!result.length) msg = 'Daftar penerima kosong atau format salah.';
        }
    }

    if (msg) {
        if (showAlert) showToast(msg, 'error');
        return false;
    }
    return true;
}

function validateStep2(showAlert) {
    let hasItem = false;
    document.querySelectorAll('#itemsWrap .it-row').forEach(row => {
        const nm = row.querySelector('input[type=text]').value.trim();
        const hrg = parseFloat(row.querySelector('.hrg').value) || 0;
        if (nm && hrg > 0) hasItem = true;
    });
    if (!hasItem) {
        if (showAlert) showToast('Minimal 1 item biaya dengan nama & harga.', 'error');
        return false;
    }
    return true;
}

function validateStep3(showAlert) {
    const checked = document.querySelectorAll('#metodeWrap input[type=checkbox]:checked');
    if (checked.length === 0) {
        if (showAlert) showToast('Pilih minimal 1 metode pembayaran.', 'error');
        return false;
    }
    return true;
}

// ============ TEMPLATE ROW ============
function itemHtml(idx) {
    return `<div class="it-row">
        <input type="text" name="items[${idx}][nama_item]" placeholder="Nama item" oninput="calc(); validateStep2()">
        <input type="number" name="items[${idx}][qty]" class="qty" placeholder="1" min="0" step="any" value="1" oninput="calc(); validateStep2()">
        <input type="number" name="items[${idx}][harga_satuan]" class="hrg" placeholder="0" min="0" step="any" oninput="calc(); validateStep2()">
        <button type="button" class="it-rm" onclick="removeItem(this)" title="Hapus">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
        </button>
    </div>`;
}

function adjHtml(idx) {
    return `<div class="adj-row">
        <select name="adjustments[${idx}][tipe]" onchange="calc()">
            <option value="diskon">Diskon</option>
            <option value="biaya_admin">Biaya Admin</option>
            <option value="pajak">Pajak / PPN</option>
        </select>
        <input type="text" name="adjustments[${idx}][label]" placeholder="Label (opsional)">
        <select name="adjustments[${idx}][mode]" onchange="calc()">
            <option value="nominal">Rp</option>
            <option value="persen">%</option>
        </select>
        <input type="number" name="adjustments[${idx}][nilai]" placeholder="0" min="0" step="any" oninput="calc()">
        <button type="button" class="it-rm adj-rm" onclick="removeAdj(this)" title="Hapus">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
        </button>
    </div>`;
}

function addItem() {
    document.getElementById('itemsWrap').insertAdjacentHTML('beforeend', itemHtml(itemIdx));
    itemIdx++;
    calc();
}

function addAdj() {
    document.getElementById('adjWrap').insertAdjacentHTML('beforeend', adjHtml(adjIdx));
    adjIdx++;
    calc();
}

function removeItem(btn) {
    const rows = document.querySelectorAll('#itemsWrap .it-row');
    if (rows.length <= 1) { showToast('Minimal 1 item.', 'error'); return; }
    btn.closest('.it-row').remove();
    calc();
}

function removeAdj(btn) {
    btn.closest('.adj-row').remove();
    calc();
}

function toggleKu() {
    document.getElementById('kuBox').style.display = document.getElementById('pakaiKu').checked ? 'block' : 'none';
    calc();
}

function randomKu() {
    document.getElementById('kuInput').value = Math.floor(Math.random() * 999) + 1;
    calc();
}

// ============ FORMAT ============
function fmtRp(n) {
    n = Math.round(n);
    return 'Rp ' + n.toLocaleString('id-ID');
}

// ============ KALKULASI ============
function calc() {
    let subtotal = 0;
    document.querySelectorAll('#itemsWrap .it-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const hrg = parseFloat(row.querySelector('.hrg').value) || 0;
        subtotal += qty * hrg;
    });

    let diskon = 0, biaya = 0, pajak = 0;
    const adjLines = [];

    document.querySelectorAll('#adjWrap .adj-row').forEach(row => {
        const tipe = row.querySelector('[name*="[tipe]"]').value;
        const label = row.querySelector('[name*="[label]"]').value || {
            diskon:'Diskon', biaya_admin:'Biaya Admin', pajak:'PPN'
        }[tipe];
        const mode = row.querySelector('[name*="[mode]"]').value;
        const nilai = parseFloat(row.querySelector('[name*="[nilai]"]').value) || 0;
        if (nilai <= 0 || tipe !== 'diskon') return;
        const hasil = mode === 'persen' ? subtotal * nilai / 100 : nilai;
        diskon += hasil;
        adjLines.push({ cls:'diskon', label, hasil: -hasil });
    });

    const dpp = Math.max(0, subtotal - diskon);

    document.querySelectorAll('#adjWrap .adj-row').forEach(row => {
        const tipe = row.querySelector('[name*="[tipe]"]').value;
        const label = row.querySelector('[name*="[label]"]').value || {
            diskon:'Diskon', biaya_admin:'Biaya Admin', pajak:'PPN'
        }[tipe];
        const mode = row.querySelector('[name*="[mode]"]').value;
        const nilai = parseFloat(row.querySelector('[name*="[nilai]"]').value) || 0;
        if (nilai <= 0 || tipe === 'diskon') return;
        if (tipe === 'biaya_admin') {
            const hasil = mode === 'persen' ? subtotal * nilai / 100 : nilai;
            biaya += hasil;
            adjLines.push({ cls:'tambah', label, hasil });
        } else if (tipe === 'pajak') {
            const hasil = mode === 'persen' ? dpp * nilai / 100 : nilai;
            pajak += hasil;
            adjLines.push({ cls:'tambah', label, hasil });
        }
    });

    let ku = 0;
    if (document.getElementById('pakaiKu').checked) {
        ku = parseFloat(document.getElementById('kuInput').value) || 0;
    }

    const total = subtotal - diskon + biaya + pajak + ku;

    document.getElementById('sSubtotal').textContent = fmtRp(subtotal);
    let h = '';
    adjLines.forEach(a => {
        const sign = a.hasil < 0 ? '−' : '+';
        h += `<div class="sum-line ${a.cls}"><span>${a.label}</span><span class="v">${sign} ${fmtRp(Math.abs(a.hasil))}</span></div>`;
    });
    if (ku > 0) {
        h += `<div class="sum-line tambah"><span>Kode Unik</span><span class="v">+ ${fmtRp(ku)}</span></div>`;
    }
    document.getElementById('sAdjList').innerHTML = h;
    document.getElementById('sTotal').textContent = fmtRp(total);

    updateWaPreview();
}

// ============ WA PREVIEW ============
function updateWaPreview() {
    let nama = '{nama_pembayar}';
    if (currentMode === 'single') {
        nama = document.getElementById('inpNama').value || '{nama_pembayar}';
    } else {
        const { result } = parseBulkList(document.getElementById('bulkList').value);
        if (result.length) {
            nama = result[0].nama + (result.length > 1 ? ` (+${result.length - 1} lainnya)` : '');
        }
    }

    const desk = document.getElementById('inpDeskripsi').value || '{deskripsi}';
    const exp = document.getElementById('inpExpired').value;

    let expStr = '{expired}';
    if (exp) {
        const d = new Date(exp);
        const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        expStr = d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear() + ' ' +
                 String(d.getHours()).padStart(2,'0') + ':' + String(d.getMinutes()).padStart(2,'0');
    }

    // Hitung total
    let subtotal = 0;
    document.querySelectorAll('#itemsWrap .it-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const hrg = parseFloat(row.querySelector('.hrg').value) || 0;
        subtotal += qty * hrg;
    });
    let diskon = 0, biaya = 0, pajak = 0;
    document.querySelectorAll('#adjWrap .adj-row').forEach(row => {
        const tipe = row.querySelector('[name*="[tipe]"]').value;
        const mode = row.querySelector('[name*="[mode]"]').value;
        const nilai = parseFloat(row.querySelector('[name*="[nilai]"]').value) || 0;
        if (nilai <= 0) return;
        if (tipe === 'diskon') diskon += mode === 'persen' ? subtotal * nilai / 100 : nilai;
        else if (tipe === 'biaya_admin') biaya += mode === 'persen' ? subtotal * nilai / 100 : nilai;
        else if (tipe === 'pajak') pajak += mode === 'persen' ? Math.max(0, subtotal - diskon) * nilai / 100 : nilai;
    });
    let ku = 0;
    if (document.getElementById('pakaiKu').checked) {
        ku = parseFloat(document.getElementById('kuInput').value) || 0;
    }
    const total = subtotal - diskon + biaya + pajak + ku;

    const tpl = TEMPLATES.find(t => t.id === selectedTemplateId);
    const templateIsi = tpl ? tpl.isi : `Halo {nama_pembayar}, tagihan {invoice_number} sebesar {nominal}. Bayar: {link}`;

    const txt = templateIsi
        .replace(/\{nama_pembayar\}/g, nama)
        .replace(/\{invoice_number\}/g, '{invoice_number}')
        .replace(/\{deskripsi\}/g, desk)
        .replace(/\{nominal\}/g, fmtRp(total))
        .replace(/\{expired\}/g, expStr)
        .replace(/\{nama_bisnis\}/g, '<?= e(setting('nama_bisnis', APP_NAME)) ?>')
        .replace(/\{kontak_admin\}/g, '<?= e(setting('kontak_admin', '')) ?>')
        .replace(/\{link\}/g, '{link}')
        .replace(/\{alasan\}/g, '{alasan}');

    document.getElementById('waPrev').innerHTML = renderWaMarkup(txt);
}

function renderWaMarkup(text) {
    let html = text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');

    html = html.replace(/(?<!\*)\*([^\*\n]+?)\*(?!\*)/g, '<b>$1</b>');
    html = html.replace(/(?<!_)_([^_\n]+?)_(?!_)/g, '<i>$1</i>');
    html = html.replace(/~([^~\n]+?)~/g, '<s>$1</s>');
    html = html.replace(/```([^`]+?)```/g, '<code style="font-family:monospace; background:rgba(0,0,0,0.06); padding:1px 5px; border-radius:4px;">$1</code>');

    return html.replace(/\n/g, '<br>');
}

// ============ TOAST ============
function showToast(msg, type = 'success') {
    const el = document.createElement('div');
    el.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;background:#0f172a;color:#fff;padding:12px 18px;border-radius:10px;font-size:13px;font-weight:500;box-shadow:0 6px 20px rgba(0,0,0,0.15);border-left:4px solid '+(type==='error'?'#ef4444':'#10b981')+';animation:slideIn .25s ease;max-width:320px;';
    el.textContent = msg;
    document.body.appendChild(el);
    setTimeout(() => { el.style.opacity = '0'; el.style.transition = 'opacity .3s'; setTimeout(() => el.remove(), 300); }, 2400);
}

// ============ FORM SUBMIT ============
document.getElementById('formInvoice').addEventListener('submit', function(e) {
    if (!validateStep1(false)) {
        e.preventDefault(); currentStep = 1; renderStep();
        showToast('Lengkapi data pembayar dulu.', 'error');
        return;
    }
    if (!validateStep2(false)) {
        e.preventDefault(); currentStep = 2; renderStep();
        showToast('Isi minimal 1 item biaya.', 'error');
        return;
    }
    if (!validateStep3(false)) {
        e.preventDefault(); currentStep = 3; renderStep();
        showToast('Pilih minimal 1 metode pembayaran.', 'error');
        return;
    }

    // Konfirmasi kalau bulk
    if (currentMode === 'bulk') {
        const { result } = parseBulkList(document.getElementById('bulkList').value);
        if (result.length > 5) {
            if (!confirm(`Buat ${result.length} tagihan sekaligus?\n\nSemua akan dibuat dengan data SAMA kecuali nama & WA.`)) {
                e.preventDefault();
                return;
            }
        }
    }
});

// ============ EVENT LISTENER ============
document.querySelectorAll('#formInvoice input, #formInvoice select, #formInvoice textarea').forEach(el => {
    el.addEventListener('input', calc);
    el.addEventListener('change', calc);
});

// ============ INIT ============
setMode(currentMode);
renderStep();
updateTplInfo();
calc();
if (currentMode === 'bulk') previewBulk();

// ============ AUTO REDIRECT WA ============
<?php if (!empty($_SESSION['redirect_wa'])): ?>
    window.open('<?= $_SESSION['redirect_wa'] ?>', '_blank');
    <?php unset($_SESSION['redirect_wa']); ?>
<?php endif; ?>
</script>

<?php render_footer(); ?>