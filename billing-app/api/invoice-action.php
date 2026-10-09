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

// Ambil info invoice
$stmt = $pdo->prepare("SELECT * FROM invoices WHERE id = ?");
$stmt->execute([$id]);
$inv = $stmt->fetch();

if (!$inv) {
    echo json_encode(['success' => false, 'message' => 'Tagihan tidak ditemukan']);
    exit;
}

// ---- CANCEL ----
if ($act === 'cancel') {
    if (!in_array($inv['status'], ['unpaid','waiting','rejected'])) {
        echo json_encode(['success' => false, 'message' => 'Tagihan tidak bisa dibatalkan pada status ini.']);
        exit;
    }
    $pdo->prepare("UPDATE invoices SET status='cancelled' WHERE id=?")->execute([$id]);
    $pdo->prepare("INSERT INTO status_logs (invoice_id, status_lama, status_baru, oleh_tipe, oleh_id, keterangan) VALUES (?, ?, 'cancelled', 'admin', ?, 'Dibatalkan oleh admin')")
        ->execute([$id, $inv['status'], $_SESSION['admin_id'] ?? null]);
    echo json_encode(['success' => true, 'message' => 'Tagihan dibatalkan.']);
    exit;
}

// ---- HAPUS ----
if ($act === 'delete') {
    $pdo->prepare("DELETE FROM invoices WHERE id=?")->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Tagihan dihapus.']);
    exit;
}

// ---- MARK PAID ----
if ($act === 'mark_paid') {
    if ($inv['status'] === 'paid') {
        echo json_encode(['success' => false, 'message' => 'Tagihan sudah lunas.']);
        exit;
    }
    $pdo->prepare("UPDATE invoices SET status='paid' WHERE id=?")->execute([$id]);
    $pdo->prepare("INSERT INTO status_logs (invoice_id, status_lama, status_baru, oleh_tipe, oleh_id, keterangan) VALUES (?, ?, 'paid', 'admin', ?, 'Ditandai lunas manual oleh admin')")
        ->execute([$id, $inv['status'], $_SESSION['admin_id'] ?? null]);
    echo json_encode(['success' => true, 'message' => 'Tagihan ditandai lunas.']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal']);