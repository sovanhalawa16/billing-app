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

// HAPUS
if ($act === 'delete' && $id) {
    $pdo->prepare("DELETE FROM wa_templates WHERE id = ?")->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Template berhasil dihapus.']);
    exit;
}

// TOGGLE AKTIF
if ($act === 'toggle' && $id) {
    $pdo->prepare("UPDATE wa_templates SET aktif = 1 - aktif WHERE id = ?")->execute([$id]);
    $stmt = $pdo->prepare("SELECT aktif FROM wa_templates WHERE id = ?");
    $stmt->execute([$id]);
    $new = $stmt->fetchColumn();
    echo json_encode([
        'success' => true,
        'aktif'   => (int)$new,
        'message' => $new ? 'Template diaktifkan.' : 'Template dinonaktifkan.',
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal']);