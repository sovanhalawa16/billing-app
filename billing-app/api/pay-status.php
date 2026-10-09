<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

$token = $_GET['token'] ?? '';
if (!$token) {
    echo json_encode(['success' => false, 'message' => 'Token kosong']);
    exit;
}

$stmt = $pdo->prepare("SELECT id, status, updated_at FROM invoices WHERE token = ?");
$stmt->execute([$token]);
$row = $stmt->fetch();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Invoice tidak ditemukan']);
    exit;
}

// Ambil alasan reject kalau ada
$rejectReason = '';
if ($row['status'] === 'unpaid') {
    $s = $pdo->prepare("SELECT alasan_reject FROM payment_proofs WHERE invoice_id=? AND status='rejected' ORDER BY verified_at DESC LIMIT 1");
    $s->execute([$row['id']]);
    $rejectReason = $s->fetchColumn() ?: '';
}

echo json_encode([
    'success' => true,
    'status' => $row['status'],
    'updated_at' => $row['updated_at'],
    'reject_reason' => $rejectReason,
]);