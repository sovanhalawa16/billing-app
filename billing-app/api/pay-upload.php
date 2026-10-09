<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

$token = $_POST['token'] ?? '';
if (!$token) {
    echo json_encode(['success' => false, 'message' => 'Token kosong']);
    exit;
}

if (!csrf_check($_POST['csrf'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'Token CSRF tidak valid']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM invoices WHERE token = ?");
$stmt->execute([$token]);
$inv = $stmt->fetch();

if (!$inv) {
    echo json_encode(['success' => false, 'message' => 'Invoice tidak ditemukan']);
    exit;
}

if (!in_array($inv['status'], ['unpaid','rejected','expired'])) {
    echo json_encode(['success' => false, 'message' => 'Tagihan tidak bisa diupload bukti']);
    exit;
}

if (empty($_FILES['bukti']['name'])) {
    echo json_encode(['success' => false, 'message' => 'Bukti wajib diupload']);
    exit;
}

$allowed = ['image/jpeg','image/png','image/jpg','image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['bukti']['tmp_name']);
finfo_close($finfo);

if (!in_array($mime, $allowed)) {
    echo json_encode(['success' => false, 'message' => 'Format harus JPG, PNG, atau WEBP']);
    exit;
}
if ($_FILES['bukti']['size'] > 3 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'Ukuran maksimal 3 MB']);
    exit;
}

$ext = strtolower(pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION));
$fn = 'b_' . $inv['id'] . '_' . date('YmdHis') . '_' . bin2hex(random_bytes(3)) . '.' . $ext;
$dir = UPLOAD_PATH . '/bukti';
if (!is_dir($dir)) mkdir($dir, 0755, true);

if (!move_uploaded_file($_FILES['bukti']['tmp_name'], $dir . '/' . $fn)) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan file']);
    exit;
}

// ⭐ FIX: Priority metode_id dari POST, fallback ke locked_method_id invoice
$metode_id = (int)($_POST['metode_id'] ?? 0);
if (!$metode_id && !empty($inv['locked_method_id'])) {
    $metode_id = (int)$inv['locked_method_id'];
}

$catatan = trim($_POST['catatan'] ?? '');

$pdo->prepare("INSERT INTO payment_proofs (invoice_id, payment_method_id, gambar, catatan_user, status, konfirmasi_via, ip_address) VALUES (?,?,?,?, 'waiting', 'sistem', ?)")
    ->execute([$inv['id'], $metode_id ?: null, 'bukti/' . $fn, $catatan, $_SERVER['REMOTE_ADDR'] ?? null]);

$pdo->prepare("UPDATE invoices SET status='waiting' WHERE id=?")->execute([$inv['id']]);
$pdo->prepare("INSERT INTO status_logs (invoice_id, status_lama, status_baru, oleh_tipe, keterangan) VALUES (?, ?, 'waiting', 'user', 'User upload bukti via sistem')")
    ->execute([$inv['id'], $inv['status']]);
$pdo->prepare("INSERT INTO activity_logs (invoice_id, aktivitas, detail, ip_address) VALUES (?, 'bukti_upload', 'Upload via sistem', ?)")
    ->execute([$inv['id'], $_SERVER['REMOTE_ADDR'] ?? null]);

echo json_encode([
    'success' => true,
    'message' => 'Bukti berhasil diupload! Menunggu konfirmasi admin.',
    'status' => 'waiting',
]);