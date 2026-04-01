<?php require_once 'config.php';
$slug = $_GET['slug'] ?? '';
$post = getPost($slug);
if (!$post) { http_response_code(404); echo '404 - Yazı bulunamadı.'; exit; }
$isNews = $post['type'] === 'news';
$bgColor = $isNews ? '#050507' : '#fff';
$textColor = $isNews ? '#fff' : '#111';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($post['title']) ?> - <?= SITE_NAME ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800;900&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .post-page { min-height: 100vh; background: <?= $bgColor ?>; color: <?= $textColor ?>; }
        .post-hero { position: relative; height: 50vh; min-height: 350px; display: flex; align-items: flex-end; }
        .post-hero-img { position: absolute; inset: 0; background-size: cover; background-position: center; }
        .post-hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, <?= $bgColor ?> 0%, rgba(0,0,0,0.3) 50%, transparent 100%); }
        .post-hero-content { position: relative; max-width: 900px; margin: 0 auto; padding: 0 2.5rem 3rem; width: 100%; }
        .post-hero-cat { display: inline-block; background: rgba(226,119,29,0.9); color: #fff; padding: 0.3rem 0.8rem; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; }
        .post-hero-content h1 { font-family: 'Rajdhani', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 700; text-transform: uppercase; line-height: 1.1; color: #fff; }
        .post-meta { display: flex; gap: 1.5rem; margin-top: 1rem; font-size: 0.8rem; color: rgba(255,255,255,0.6); }
        .post-body { max-width: 800px; margin: 0 auto; padding: 3rem 2.5rem 5rem; line-height: 1.9; font-size: 1.05rem; }
        .post-body h2 { font-family: 'Rajdhani', sans-serif; font-size: 1.6rem; font-weight: 700; margin: 2.5rem 0 1rem; text-transform: uppercase; }
        .post-body h3 { font-size: 1.2rem; font-weight: 700; margin: 2rem 0 0.8rem; }
        .post-body p { margin-bottom: 1.2rem; }
        .post-body img { max-width: 100%; border-radius: 12px; margin: 1.5rem 0; }
        .post-body blockquote { border-left: 3px solid #e2771d; padding-left: 1.5rem; margin: 1.5rem 0; font-style: italic; color: <?= $isNews ? '#aaa' : '#555' ?>; }
        .post-back { display: inline-flex; align-items: center; gap: 0.5rem; margin: 2rem 2.5rem; color: #e2771d; font-size: 0.85rem; font-weight: 600; }
        .post-back:hover { color: #f0943e; }
        @media (max-width: 768px) { .post-hero { height: 40vh; min-height: 280px; } .post-body { padding: 2rem 1.5rem 4rem; } }
    </style>
</head>
<body>
    <nav class="navbar" style="background:transparent;position:absolute;top:0;left:0;right:0;z-index:10;">
        <div class="nav-inner">
            <a href="index.php" class="logo"><em>Blact Systems</em></a>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php#hakkimizda">Hakkımızda</a></li>
                <li><a href="index.php#cozumlerimiz">Çözümlerimiz</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="haberler.php">Haberler</a></li>
                <li><a href="index.php#iletisim">İletişim</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle"><span></span><span></span><span></span></button>
        </div>
    </nav>

    <div class="post-page">
        <div class="post-hero">
            <div class="post-hero-img" style="background-image:url('<?= e($post['image'] ? UPLOAD_URL . $post['image'] : ($isNews ? 'assets/images/bg2.png' : 'assets/images/bg1.png')) ?>')"></div>
            <div class="post-hero-overlay"></div>
            <div class="post-hero-content">
                <?php if ($post['category_name']): ?><span class="post-hero-cat"><?= e($post['category_name']) ?></span><?php endif; ?>
                <h1><?= e($post['title']) ?></h1>
                <div class="post-meta">
                    <span><?= formatDate($post['published_at'] ?? $post['created_at']) ?></span>
                    <?php if ($post['author_name']): ?><span><?= e($post['author_name']) ?></span><?php endif; ?>
                </div>
            </div>
        </div>

        <a href="<?= $isNews ? 'haberler.php' : 'blog.php' ?>" class="post-back">← <?= $isNews ? 'Haberlere' : 'Blog\'a' ?> Dön</a>

        <div class="post-body">
            <?= $post['content'] ?>
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
