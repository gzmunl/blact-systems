<?php require_once 'config.php';
$posts = getPosts('blog', 50);
$categories = getCategories('blog');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - <?= SITE_NAME ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800;900&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .blog-page { min-height: 100vh; background: #fff; padding: 6rem 0 4rem; }
        .blog-page .container { max-width: 1200px; margin: 0 auto; padding: 0 2.5rem; }
        .blog-page-header { margin-bottom: 3rem; }
        .blog-page-header .section-label { color: var(--accent); }
        .blog-page-header h1 { font-family: 'Rajdhani', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; color: #111; text-transform: uppercase; }
        .blog-page-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.8rem; }
        .blog-card { position: relative; border-radius: 12px; overflow: hidden; min-height: 300px; display: flex; align-items: flex-end; text-decoration: none; color: #fff; transition: transform 0.3s; }
        .blog-card:hover { transform: translateY(-4px); }
        .blog-card-img { position: absolute; inset: 0; background-size: cover; background-position: center; }
        .blog-card-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 60%, transparent 100%); }
        .blog-card-content { position: relative; padding: 1.5rem; width: 100%; }
        .blog-card-cat { display: inline-block; background: rgba(226,119,29,0.9); color: #fff; padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
        .blog-card-content h3 { font-family: 'Rajdhani', sans-serif; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.3rem; }
        .blog-card-date { font-size: 0.7rem; color: rgba(255,255,255,0.6); }
        .blog-empty { text-align: center; padding: 4rem; color: #888; font-size: 1.1rem; }
        @media (max-width: 1024px) { .blog-page-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .blog-page-grid { grid-template-columns: 1fr; } .blog-page { padding: 5rem 0 3rem; } }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" style="background:#fff;border-bottom:1px solid #eee;">
        <div class="nav-inner">
            <a href="index.php" class="logo" style="color:#111;"><em>Blact Systems</em></a>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php#hakkimizda" style="color:#111;">Hakkımızda</a></li>
                <li><a href="index.php#cozumlerimiz" style="color:#111;">Çözümlerimiz</a></li>
                <li><a href="blog.php" style="color:#e2771d;">Blog</a></li>
                <li><a href="haberler.php" style="color:#111;">Haberler</a></li>
                <li><a href="index.php#iletisim" style="color:#111;">İletişim</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle"><span></span><span></span><span></span></button>
        </div>
    </nav>

    <div class="blog-page">
        <div class="container">
            <div class="blog-page-header">
                <div class="section-label">BLOG</div>
                <h1>Güncel Yazılar</h1>
            </div>
            <?php if (empty($posts)): ?>
                <div class="blog-empty">Henüz blog yazısı yayınlanmamış.</div>
            <?php else: ?>
            <div class="blog-page-grid">
                <?php foreach ($posts as $post): ?>
                <a href="post.php?slug=<?= e($post['slug']) ?>" class="blog-card">
                    <div class="blog-card-img" style="background-image:url('<?= e($post['image'] ? UPLOAD_URL . $post['image'] : 'assets/images/bg1.png') ?>')"></div>
                    <div class="blog-card-overlay"></div>
                    <div class="blog-card-content">
                        <?php if ($post['category_name']): ?><span class="blog-card-cat"><?= e($post['category_name']) ?></span><?php endif; ?>
                        <h3><?= e($post['title']) ?></h3>
                        <span class="blog-card-date"><?= formatDate($post['published_at'] ?? $post['created_at']) ?></span>
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
