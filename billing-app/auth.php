<?php
require_once __DIR__ . '/config.php';

function require_login() {
    global $pdo;
    if (empty($_SESSION['admin_id'])) {
        redirect('/login');
    }
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ? AND status = 'aktif'");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();
    if (!$admin) {
        session_destroy();
        redirect('/login');
    }
    $GLOBALS['admin'] = $admin;
}

function is_super_admin() {
    return ($GLOBALS['admin']['role'] ?? '') === 'super_admin';
}