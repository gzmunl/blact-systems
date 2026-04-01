<?php
require_once __DIR__ . '/../config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];
        header('Location: index.php');
        exit;
    }
    $error = 'Geçersiz kullanıcı adı veya şifre.';
}
if (isLoggedIn()) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş - <?= SITE_NAME ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0a0a0f; color: #fff; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-box { background: #12121a; border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 3rem; width: 100%; max-width: 400px; }
        .login-box h1 { font-size: 1.5rem; margin-bottom: 0.5rem; }
        .login-box p { color: #888; font-size: 0.85rem; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-size: 0.75rem; color: #aaa; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.4rem; }
        .form-group input { width: 100%; padding: 0.8rem 1rem; background: #1a1a25; border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; color: #fff; font-size: 0.95rem; outline: none; transition: border-color 0.3s; }
        .form-group input:focus { border-color: #e2771d; }
        .btn { width: 100%; padding: 0.85rem; background: #e2771d; color: #fff; border: none; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: background 0.3s; }
        .btn:hover { background: #c9661a; }
        .error { background: rgba(220,38,38,0.1); color: #f87171; padding: 0.7rem 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1rem; }
        .logo { color: #e2771d; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
<div class="login-box">
    <div class="logo">BLACT SYSTEMS</div>
    <h1>Admin Panel</h1>
    <p>Yönetim paneline giriş yapın.</p>
    <?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>Kullanıcı Adı</label>
            <input type="text" name="username" required autofocus>
        </div>
        <div class="form-group">
            <label>Şifre</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Giriş Yap</button>
    </form>
</div>
</body>
</html>
