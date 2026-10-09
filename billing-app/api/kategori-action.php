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

// ---- TOGGLE AKTIF ----
if ($act === 'toggle') {
    $pdo->prepare("UPDATE categories SET aktif = 1 - aktif WHERE id = ?")->execute([$id]);
    $stmt = $pdo->prepare("SELECT aktif FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $new = $stmt->fetchColumn();
    echo json_encode([
        'success' => true,
        'aktif'   => (int)$new,
        'message' => $new ? 'Kategori diaktifkan.' : 'Kategori dinonaktifkan.',
    ]);
    exit;
}

// ---- HAPUS ----
if ($act === 'delete') {
    $cek = $pdo->prepare("SELECT COUNT(*) FROM invoices WHERE kategori_id = ?");
    $cek->execute([$id]);
    if ($cek->fetchColumn() > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Kategori masih dipakai di tagihan, gak bisa dihapus.',
        ]);
        exit;
    }

    $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Kategori berhasil dihapus.']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal']);