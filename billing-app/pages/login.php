<?php
// Kalau sudah login, lempar ke dashboard
if (!empty($_SESSION['admin_id'])) {
    redirect('/dashboard');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf'] ?? '')) {
        $error = 'Token tidak valid.';
    } else {
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';

        if ($u === '' || $p === '') {
            $error = 'Username dan password wajib diisi.';
        } else {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? OR email = ? LIMIT 1");
            $stmt->execute([$u, $u]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($p, $admin['password'])) {
                if ($admin['status'] !== 'aktif') {
                    $error = 'Akun tidak aktif.';
                } else {
                    $_SESSION['admin_id'] = $admin['id'];
                    $pdo->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?")
                        ->execute([$admin['id']]);
                    redirect('/dashboard');
                }
            } else {
                $error = 'Username atau password salah.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - <?= APP_NAME ?></title>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;
    }
    .card { background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); width: 100%; max-width: 400px; padding: 40px 30px; }
    .card h1 { font-size: 26px; color: #1a1a2e; margin-bottom: 6px; text-align: center; }
    .card h1 span { color: #667eea; }
    .sub { color: #888; font-size: 14px; text-align: center; margin-bottom: 28px; }
    .field { margin-bottom: 18px; }
    .field label { display: block; font-size: 13px; color: #444; margin-bottom: 6px; font-weight: 500; }
    .field input { width: 100%; padding: 12px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; transition: .2s; }
    .field input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.15); }
    .btn { width: 100%; padding: 13px; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; transition: .2s; margin-top: 6px; }
    .btn:hover { opacity: .92; transform: translateY(-1px); }
    .error { background: #fee2e2; color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px; border-left: 3px solid #b91c1c; }
    .footer { text-align: center; font-size: 12px; color: #999; margin-top: 24px; }
</style>
</head>
<body>
<div class="card">
    <h1><span>Tagihan</span>ku</h1>
    <p class="sub">Masuk ke panel admin</p>

    <?php if ($error): ?>
        <div class="error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf" value="<?= csrf() ?>">
        <div class="field">
            <label>Username / Email</label>
            <input type="text" name="username" required autofocus>
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button class="btn" type="submit">Masuk</button>
    </form>

    <div class="footer">&copy; <?= date('Y') ?> <?= APP_NAME ?></div>
</div>
</body>
</html>