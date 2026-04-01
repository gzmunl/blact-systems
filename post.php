<?php require_once 'config.php';
$slug = $_GET['slug'] ?? '';
$post = getPost($slug);
if (!$post) { http_response_code(404); echo '<!DOCTYPE html><html><head><title>404</title></head><body style="background:#050507;color:#fff;font-family:sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;"><div style="text-align:center"><h1 style="font-size:4rem;margin:0;">404</h1><p>Yazı bulunamadı.</p><a href="index.html" style="color:#e2771d;">Ana Sayfa &rarr;</a></div></body></html>'; exit; }
$isNews = $post['type'] === 'news';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($post['title']) ?> - <?= SITE_NAME ?></title>
    <meta name="description" content="<?= e($post['excerpt']) ?>">
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800;900&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .sp-hero { position: relative; height: 55vh; min-height: 380px; display: flex; align-items: flex-end; background: #050507; }
        .sp-hero-img { position: absolute; inset: 0; background-size: cover; background-position: center; }
        .sp-hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, #050507 0%, rgba(5,5,7,0.5) 40%, rgba(5,5,7,0.2) 100%); }
        .sp-hero-content { position: relative; z-index: 2; max-width: 800px; margin: 0 auto; padding: 0 2.5rem 3.5rem; width: 100%; }
        .sp-cat { display: inline-block; background: rgba(226,119,29,0.15); color: #e2771d; padding: 0.3rem 0.9rem; border-radius: 6px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.2rem; }
        .sp-hero-content h1 { font-family: 'Rajdhani', sans-serif; font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 700; text-transform: uppercase; line-height: 1.1; color: #fff; margin-bottom: 1rem; }
        .sp-meta { display: flex; gap: 1.5rem; font-size: 0.8rem; color: rgba(255,255,255,0.5); }

        .sp-body { max-width: 750px; margin: 0 auto; padding: 3rem 2.5rem 5rem; line-height: 1.9; font-size: 1.05rem; color: #d0d0d0; background: #050507; }
        .sp-body h2 { font-family: 'Rajdhani', sans-serif; font-size: 1.5rem; font-weight: 700; color: #fff; margin: 2.5rem 0 1rem; text-transform: uppercase; }
        .sp-body h3 { font-size: 1.15rem; font-weight: 700; color: #eee; margin: 2rem 0 0.8rem; }
        .sp-body p { margin-bottom: 1.2rem; }
        .sp-body img { max-width: 100%; border-radius: 12px; margin: 1.5rem 0; }
        .sp-body blockquote { border-left: 3px solid #e2771d; padding-left: 1.5rem; margin: 1.5rem 0; font-style: italic; color: #999; }
        .sp-body strong { color: #fff; }
        .sp-body a { color: #e2771d; }

        .sp-back {
            display: inline-flex; align-items: center; gap: 0.5rem;
            max-width: 750px; margin: 0 auto; padding: 0 2.5rem;
            color: #e2771d; font-size: 0.85rem; font-weight: 600; width: 100%;
            background: #050507;
        }
        .sp-back:hover { color: #f0943e; }

        /* Hero image prompt: "Cinematic close-up of advanced engineering process with dramatic lighting, shallow depth of field, dark mood with orange accent, 1920x700" */

        @media (max-width: 768px) {
            .sp-hero { height: 40vh; min-height: 300px; }
            .sp-body { padding: 2rem 1.5rem 4rem; font-size: 1rem; }
            .sp-back { padding: 0 1.5rem; }
        }
    </style>
</head>
<body>
    <nav class="navbar" style="position:fixed;top:0;left:0;right:0;z-index:100;background:transparent;">
        <div class="nav-inner">
            <a href="index.html" class="logo"><em>Blact Systems</em></a>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.html#hakkimizda">Hakkımızda</a></li>
                <li class="nav-dropdown">
                    <a href="index.html#cozumlerimiz">Çözümlerimiz</a>
                    <div class="dropdown-menu">
                        <a href="cozum-eklemeli-imalat.html">Eklemeli İmalat</a>
                        <a href="cozum-kompozit.html">Kompozit Teknolojisi</a>
                        <a href="cozum-insansiz-araclar.html">İnsansız Hava &amp; Deniz Araçları</a>
                        <a href="cozum-surdurulebilirlik.html">Sürdürülebilirlik</a>
                    </div>
                </li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="haberler.php">Haberler</a></li>
                <li><a href="index.html#iletisim">İletişim</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle"><span></span><span></span><span></span></button>
        </div>
    </nav>

    <section class="sp-hero">
        <div class="sp-hero-img" style="background-image:url('<?= e($post['image'] ? UPLOAD_URL . $post['image'] : 'assets/images/' . ($isNews ? 'bg2.png' : 'bg1.png')) ?>')"></div>
        <div class="sp-hero-overlay"></div>
        <div class="sp-hero-content">
            <?php if ($post['category_name']): ?><span class="sp-cat"><?= e($post['category_name']) ?></span><?php endif; ?>
            <h1><?= e($post['title']) ?></h1>
            <div class="sp-meta">
                <span><?= formatDate($post['published_at'] ?? $post['created_at']) ?></span>
                <?php if ($post['read_time']): ?><span><?= $post['read_time'] ?> dk okuma</span><?php endif; ?>
                <?php if ($post['author_name']): ?><span><?= e($post['author_name']) ?></span><?php endif; ?>
            </div>
        </div>
    </section>

    <a href="<?= $isNews ? 'haberler.php' : 'blog.php' ?>" class="sp-back">← <?= $isNews ? 'Haberlere' : 'Blog\'a' ?> Dön</a>

    <article class="sp-body">
        <?= $post['content'] ?>
    </article>

    <script>
    document.getElementById('navToggle').addEventListener('click', function() {
        document.getElementById('navLinks').classList.toggle('open');
        this.classList.toggle('open');
    });
    </script>
</body>
</html>
