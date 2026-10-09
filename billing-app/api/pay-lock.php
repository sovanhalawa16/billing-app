<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

// ============ CHECK LOCK (GET) ============
if ($method === 'GET') {
    $token = $_GET['token'] ?? '';
    if (!$token) {
        echo json_encode(['success' => false, 'message' => 'Token kosong']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, locked_method_id, locked_until FROM invoices WHERE token = ?");
    $stmt->execute([$token]);
    $inv = $stmt->fetch();

    if (!$inv) {
        echo json_encode(['success' => false, 'message' => 'Invoice tidak ditemukan']);
        exit;
    }

    $lockedId = $inv['locked_method_id'];
    $lockedUntil = $inv['locked_until'];

    // Cek expired lock
    $sisaDetik = 0;
    if ($lockedUntil && strtotime($lockedUntil) > time()) {
        $sisaDetik = strtotime($lockedUntil) - time();
    } else {
        // Auto-clear lock kalau udah expired
        if ($lockedId) {
            $pdo->prepare("UPDATE invoices SET locked_method_id = NULL, locked_until = NULL WHERE id = ?")->execute([$inv['id']]);
        }
        $lockedId = null;
        $lockedUntil = null;
    }

    echo json_encode([
        'success' => true,
        'locked_method_id' => $lockedId ? (int)$lockedId : null,
        'locked_until' => $lockedUntil,
        'sisa_detik' => $sisaDetik,
    ]);
    exit;
}

// ============ SET LOCK (POST) ============
if ($method === 'POST') {
    $token = $_POST['token'] ?? '';
    $method_id = (int)($_POST['method_id'] ?? 0);

    if (!$token || !$method_id) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
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

    // Cek kalau udah ada lock aktif & belum expired
    if ($inv['locked_method_id'] && $inv['locked_until'] && strtotime($inv['locked_until']) > time()) {
        if ((int)$inv['locked_method_id'] !== $method_id) {
            echo json_encode([
                'success' => false,
                'message' => 'Sudah ada metode aktif yang dikunci. Tunggu sampai selesai.',
                'locked_method_id' => (int)$inv['locked_method_id'],
            ]);
            exit;
        }
        // Kalau sama, tinggal return OK (idempotent)
    }

    // Validasi metode ada di invoice ini
    $cek = $pdo->prepare("SELECT COUNT(*) FROM invoice_methods WHERE invoice_id = ? AND payment_method_id = ?");
    $cek->execute([$inv['id'], $method_id]);
    if ($cek->fetchColumn() == 0) {
        echo json_encode(['success' => false, 'message' => 'Metode tidak tersedia']);
        exit;
    }

    // Set lock 5 menit
    $lockUntil = date('Y-m-d H:i:s', time() + (5 * 60));
    $pdo->prepare("UPDATE invoices SET locked_method_id = ?, locked_until = ? WHERE id = ?")
        ->execute([$method_id, $lockUntil, $inv['id']]);

    $pdo->prepare("INSERT INTO activity_logs (invoice_id, aktivitas, detail, ip_address) VALUES (?, 'method_locked', ?, ?)")
        ->execute([$inv['id'], 'Method ID ' . $method_id . ' locked 5 menit', $_SERVER['REMOTE_ADDR'] ?? null]);

    echo json_encode([
        'success' => true,
        'message' => 'Metode dikunci 5 menit',
        'locked_method_id' => $method_id,
        'locked_until' => $lockUntil,
        'sisa_detik' => 300,
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Method tidak didukung']);