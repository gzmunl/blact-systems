<?php require_once __DIR__ . '/../config.php'; requireLogin(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> - <?= SITE_NAME ?> Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #0a0a0f; color: #e0e0e0; }
        a { color: #e2771d; text-decoration: none; }
        a:hover { color: #f0943e; }

        .admin-nav { background: #12121a; border-bottom: 1px solid rgba(255,255,255,0.06); padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; height: 60px; position: sticky; top: 0; z-index: 100; }
        .admin-nav .logo { font-weight: 900; font-size: 0.85rem; color: #e2771d; letter-spacing: 1px; text-transform: uppercase; }
        .admin-nav .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .admin-nav .nav-links a { color: #888; font-size: 0.85rem; font-weight: 500; transition: color 0.2s; }
        .admin-nav .nav-links a:hover, .admin-nav .nav-links a.active { color: #fff; }
        .admin-nav .user { color: #666; font-size: 0.8rem; }

        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .page-header h1 { font-size: 1.6rem; font-weight: 700; }

        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.2rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; }
        .btn-primary { background: #e2771d; color: #fff; }
        .btn-primary:hover { background: #c9661a; color: #fff; }
        .btn-danger { background: rgba(220,38,38,0.15); color: #f87171; }
        .btn-danger:hover { background: rgba(220,38,38,0.3); }
        .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.78rem; }
        .btn-outline { background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #ccc; }
        .btn-outline:hover { border-color: #e2771d; color: #e2771d; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #666; padding: 0.8rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.06); }
        td { padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 0.9rem; }
        tr:hover td { background: rgba(255,255,255,0.02); }
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-published { background: rgba(34,197,94,0.15); color: #4ade80; }
        .badge-draft { background: rgba(234,179,8,0.15); color: #facc15; }
        .badge-blog { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .badge-news { background: rgba(168,85,247,0.15); color: #c084fc; }

        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-size: 0.75rem; color: #aaa; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.4rem; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.8rem 1rem; background: #1a1a25; border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; color: #fff; font-size: 0.95rem; outline: none; transition: border-color 0.3s; font-family: inherit; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #e2771d; }
        .form-group textarea { min-height: 300px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .form-actions { display: flex; gap: 1rem; margin-top: 2rem; }

        .card { background: #12121a; border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 1.5rem; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: #12121a; border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 1.5rem; }
        .stat-card .number { font-size: 2rem; font-weight: 800; color: #fff; }
        .stat-card .label { font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-top: 0.3rem; }

        .alert { padding: 0.8rem 1.2rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.5rem; }
        .alert-success { background: rgba(34,197,94,0.1); color: #4ade80; }
        .alert-error { background: rgba(220,38,38,0.1); color: #f87171; }

        .thumb { width: 60px; height: 40px; object-fit: cover; border-radius: 6px; }
        .actions { display: flex; gap: 0.5rem; }

        @media (max-width: 768px) {
            .stats { grid-template-columns: 1fr 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; gap: 1rem; align-items: flex-start; }
            .container { padding: 1rem; }
        }
    </style>
</head>
<body>
<nav class="admin-nav">
    <a href="index.php" class="logo">Blact Admin</a>
    <div class="nav-links">
        <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Dashboard</a>
        <a href="posts.php?type=blog" class="<?= ($_GET['type'] ?? '') === 'blog' ? 'active' : '' ?>">Blog</a>
        <a href="posts.php?type=news" class="<?= ($_GET['type'] ?? '') === 'news' ? 'active' : '' ?>">Haberler</a>
        <a href="categories.php" class="<?= basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : '' ?>">Kategoriler</a>
        <span class="user"><?= e($_SESSION['admin_name']) ?></span>
        <a href="logout.php">Çıkış</a>
    </div>
</nav>
<div class="container">
