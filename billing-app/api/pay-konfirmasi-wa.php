<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

$token = $_POST['token'] ?? '';
if (!$token) {
    echo json_encode(['success' => false, 'message' => 'Token kosong']);
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
    echo json_encode(['success' => false, 'message' => 'Status tidak valid']);
    exit;
}

// ⭐ FIX: Priority metode_id dari POST, fallback ke locked_method_id invoice
$metode_id = (int)($_POST['metode_id'] ?? 0);
if (!$metode_id && !empty($inv['locked_method_id'])) {
    $metode_id = (int)$inv['locked_method_id'];
}

try {
    $pdo->beginTransaction();

    // Insert record ke payment_proofs dengan metode_id
    $pdo->prepare("INSERT INTO payment_proofs 
        (invoice_id, payment_method_id, gambar, catatan_user, status, konfirmasi_via, ip_address) 
        VALUES (?, ?, '', ?, 'waiting', 'wa', ?)")
        ->execute([
            $inv['id'],
            $metode_id ?: null,
            'User konfirmasi via WhatsApp — cek WA untuk lihat bukti',
            $_SERVER['REMOTE_ADDR'] ?? null
        ]);

    // Update status invoice jadi waiting
    $pdo->prepare("UPDATE invoices SET status='waiting' WHERE id=?")
        ->execute([$inv['id']]);

    // Log status
    $pdo->prepare("INSERT INTO status_logs (invoice_id, status_lama, status_baru, oleh_tipe, keterangan) VALUES (?, ?, 'waiting', 'user', 'User konfirmasi via WhatsApp')")
        ->execute([$inv['id'], $inv['status']]);

    // Log activity
    $pdo->prepare("INSERT INTO activity_logs (invoice_id, aktivitas, detail, ip_address) VALUES (?, 'konfirmasi_wa', 'User konfirmasi via WA', ?)")
        ->execute([$inv['id'], $_SERVER['REMOTE_ADDR'] ?? null]);

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Status diupdate. Admin akan cek WhatsApp kamu.',
        'status' => 'waiting',
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
}