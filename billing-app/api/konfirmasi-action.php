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
$proof_id = (int)($_POST['proof_id'] ?? 0);

if (!$proof_id) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM payment_proofs WHERE id = ?");
$stmt->execute([$proof_id]);
$proof = $stmt->fetch();

if (!$proof) {
    echo json_encode(['success' => false, 'message' => 'Bukti tidak ditemukan']);
    exit;
}
if ($proof['status'] !== 'waiting') {
    echo json_encode(['success' => false, 'message' => 'Bukti sudah diproses sebelumnya']);
    exit;
}

$inv = $pdo->prepare("SELECT * FROM invoices WHERE id = ?");
$inv->execute([$proof['invoice_id']]);
$invoice = $inv->fetch();

if (!$invoice) {
    echo json_encode(['success' => false, 'message' => 'Invoice tidak ditemukan']);
    exit;
}

// ============ APPROVE ============
if ($act === 'approve') {
    $pdo->beginTransaction();
    try {
        $pdo->prepare("UPDATE payment_proofs SET status='approved', verified_by=?, verified_at=NOW() WHERE id=?")
            ->execute([$_SESSION['admin_id'] ?? null, $proof_id]);

        $pdo->prepare("UPDATE invoices SET status='paid' WHERE id=?")
            ->execute([$proof['invoice_id']]);

        $pdo->prepare("INSERT INTO status_logs (invoice_id, status_lama, status_baru, oleh_tipe, oleh_id, keterangan) VALUES (?, ?, 'paid', 'admin', ?, 'Bukti bayar disetujui')")
            ->execute([$proof['invoice_id'], $invoice['status'], $_SESSION['admin_id'] ?? null]);

        $pdo->prepare("INSERT INTO activity_logs (invoice_id, aktivitas, detail) VALUES (?, 'approved', 'Bukti bayar disetujui admin')")
            ->execute([$proof['invoice_id']]);

        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => "Bukti {$invoice['invoice_number']} disetujui. Tagihan LUNAS.",
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
    }
    exit;
}

// ============ REJECT ============
if ($act === 'reject') {
    $alasan = trim($_POST['alasan'] ?? '');
    if ($alasan === '') {
        echo json_encode(['success' => false, 'message' => 'Alasan reject wajib diisi']);
        exit;
    }

    $pdo->beginTransaction();
    try {
        $pdo->prepare("UPDATE payment_proofs SET status='rejected', alasan_reject=?, verified_by=?, verified_at=NOW() WHERE id=?")
            ->execute([$alasan, $_SESSION['admin_id'] ?? null, $proof_id]);

        // Kalau via WA, status invoice tetap unpaid (biar user bisa upload ulang via sistem)
        $pdo->prepare("UPDATE invoices SET status='unpaid' WHERE id=?")
            ->execute([$proof['invoice_id']]);

        $ket = ($proof['konfirmasi_via'] ?? 'sistem') === 'wa'
            ? 'Bukti via WA ditolak: ' . $alasan
            : 'Bukti ditolak: ' . $alasan;

        $pdo->prepare("INSERT INTO status_logs (invoice_id, status_lama, status_baru, oleh_tipe, oleh_id, keterangan) VALUES (?, ?, 'unpaid', 'admin', ?, ?)")
            ->execute([$proof['invoice_id'], $invoice['status'], $_SESSION['admin_id'] ?? null, $ket]);

        $pdo->prepare("INSERT INTO activity_logs (invoice_id, aktivitas, detail) VALUES (?, 'rejected', ?)")
            ->execute([$proof['invoice_id'], $ket]);

        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => "Bukti {$invoice['invoice_number']} ditolak.",
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
    }
    exit;
}

// ============ HAPUS PROOF ============
if ($act === 'delete') {
    try {
        // Hapus file fisik
        if (!empty($proof['gambar']) && file_exists(UPLOAD_PATH . '/' . $proof['gambar'])) {
            @unlink(UPLOAD_PATH . '/' . $proof['gambar']);
        }

        $pdo->prepare("DELETE FROM payment_proofs WHERE id = ?")->execute([$proof_id]);

        echo json_encode(['success' => true, 'message' => 'Bukti dihapus.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal']);