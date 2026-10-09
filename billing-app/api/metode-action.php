<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method tidak valid']);
    exit;
}

$act = $_POST['action'] ?? '';
$id  = (int)($_POST['id'] ?? 0);
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit;
}

// TOGGLE
if ($act === 'toggle') {
    $pdo->prepare("UPDATE payment_methods SET aktif = 1 - aktif WHERE id = ?")->execute([$id]);
    $stmt = $pdo->prepare("SELECT aktif FROM payment_methods WHERE id = ?");
    $stmt->execute([$id]);
    $new = $stmt->fetchColumn();
    echo json_encode([
        'success' => true,
        'aktif'   => (int)$new,
        'message' => $new ? 'Metode diaktifkan.' : 'Metode dinonaktifkan.',
    ]);
    exit;
}

// HAPUS
if ($act === 'delete') {
    $stmt = $pdo->prepare("SELECT logo, gambar_qris FROM payment_methods WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row) {
        if ($row['logo'] && file_exists(UPLOAD_PATH . '/' . $row['logo'])) @unlink(UPLOAD_PATH . '/' . $row['logo']);
        if ($row['gambar_qris'] && file_exists(UPLOAD_PATH . '/' . $row['gambar_qris'])) @unlink(UPLOAD_PATH . '/' . $row['gambar_qris']);
        $pdo->prepare("DELETE FROM payment_methods WHERE id = ?")->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Metode berhasil dihapus.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Metode tidak ditemukan.']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal']);