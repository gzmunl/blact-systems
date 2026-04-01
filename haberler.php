<?php require_once 'config.php';
$posts = getPosts('news', 50);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haberler - <?= SITE_NAME ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800;900&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .news-page { min-height: 100vh; background: #050507; padding: 6rem 0 4rem; }
        .news-page .container { max-width: 1200px; margin: 0 auto; padding: 0 2.5rem; }
        .news-page-header { margin-bottom: 3rem; }
        .news-page-header .section-label { color: var(--accent); }
        .news-page-header h1 { font-family: 'Rajdhani', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; color: #fff; text-transform: uppercase; }
        .news-page-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }
        .ncard { position: relative; overflow: hidden; min-height: 300px; display: flex; align-items: flex-end; border-radius: 12px; text-decoration: none; color: #fff; transition: transform 0.3s; }
        .ncard:hover { transform: translateY(-4px); }
        .ncard-img { position: absolute; inset: 0; background-size: cover; background-position: center; }
        .ncard-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.3) 50%, transparent 100%); }
        .ncard-content { position: relative; padding: 1.5rem; width: 100%; }
        .ncard-cat { display: inline-block; background: rgba(226,119,29,0.9); color: #fff; padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
        .ncard-content h3 { font-family: 'Rajdhani', sans-serif; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.3rem; }
        .ncard-date { font-size: 0.7rem; color: rgba(255,255,255,0.6); }
        .news-empty { text-align: center; padding: 4rem; color: #666; font-size: 1.1rem; }
        @media (max-width: 1024px) { .news-page-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .news-page-grid { grid-template-columns: 1fr; } .news-page { padding: 5rem 0 3rem; } }
    </style>
</head>
<body>
    <nav class="navbar" style="background:#050507;border-bottom:1px solid rgba(255,255,255,0.06);">
        <div class="nav-inner">
            <a href="index.php" class="logo"><em>Blact Systems</em></a>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php#hakkimizda">Hakkımızda</a></li>
                <li><a href="index.php#cozumlerimiz">Çözümlerimiz</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="haberler.php" style="color:#e2771d;">Haberler</a></li>
                <li><a href="index.php#iletisim">İletişim</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle"><span></span><span></span><span></span></button>
        </div>
    </nav>

    <div class="news-page">
        <div class="container">
            <div class="news-page-header">
                <div class="section-label">HABERLER</div>
                <h1>Sektörden Haberler</h1>
            </div>
            <?php if (empty($posts)): ?>
                <div class="news-empty">Henüz haber yayınlanmamış.</div>
            <?php else: ?>
            <div class="news-page-grid">
                <?php foreach ($posts as $post): ?>
                <a href="post.php?slug=<?= e($post['slug']) ?>" class="ncard">
                    <div class="ncard-img" style="background-image:url('<?= e($post['image'] ? UPLOAD_URL . $post['image'] : 'assets/images/bg2.png') ?>')"></div>
                    <div class="ncard-overlay"></div>
                    <div class="ncard-content">
                        <?php if ($post['category_name']): ?><span class="ncard-cat"><?= e($post['category_name']) ?></span><?php endif; ?>
                        <h3><?= e($post['title']) ?></h3>
                        <span class="ncard-date"><?= formatDate($post['published_at'] ?? $post['created_at']) ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.getElementById('navToggle').addEventListener('click', function() {
        document.getElementById('navLinks').classList.toggle('open');
        this.classList.toggle('open');
    });
    </script>
</body>
</html>
