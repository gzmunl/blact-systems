<?php require_once 'config.php';
$posts = getPosts('blog', 50);
$categories = getCategories('blog');
$featured = !empty($posts) ? $posts[0] : null;
$rest = array_slice($posts, 1);
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
        /* --- Blog Page --- */
        .bp-hero {
            background: #050507; padding: 8rem 0 4rem; position: relative; overflow: hidden;
        }
        .bp-hero::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 30% 50%, rgba(226,119,29,0.06) 0%, transparent 60%);
        }
        .bp-hero .container { position: relative; z-index: 2; max-width: 1200px; margin: 0 auto; padding: 0 2.5rem; }
        .bp-hero .section-label { color: var(--accent); font-size: 0.7rem; letter-spacing: 3px; text-transform: uppercase; font-weight: 700; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 1rem; }
        .bp-hero .section-label::before { content: ''; width: 40px; height: 2px; background: var(--accent); }
        .bp-hero h1 { font-family: 'Rajdhani', sans-serif; font-size: clamp(2.2rem, 5vw, 3.5rem); font-weight: 700; color: #fff; text-transform: uppercase; line-height: 1.05; margin-bottom: 1rem; }
        .bp-hero p { color: #888; max-width: 500px; line-height: 1.7; font-size: 0.95rem; }

        /* Featured */
        .bp-featured { margin-top: -2rem; position: relative; z-index: 3; }
        .bp-featured .container { max-width: 1200px; margin: 0 auto; padding: 0 2.5rem; }
        .bp-feat-card {
            display: grid; grid-template-columns: 1.3fr 1fr; min-height: 400px;
            border-radius: 16px; overflow: hidden; background: #12121a;
            text-decoration: none; color: #fff; transition: transform 0.3s;
        }
        .bp-feat-card:hover { transform: translateY(-4px); color: #fff; }
        .bp-feat-img { background-size: cover; background-position: center; position: relative; }
        .bp-feat-body { padding: 3rem; display: flex; flex-direction: column; justify-content: center; }
        .bp-feat-cat { display: inline-block; background: rgba(226,119,29,0.15); color: #e2771d; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; width: fit-content; }
        .bp-feat-body h2 { font-family: 'Rajdhani', sans-serif; font-size: 1.6rem; font-weight: 700; text-transform: uppercase; line-height: 1.15; margin-bottom: 1rem; }
        .bp-feat-body p { color: #999; font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.5rem; }
        .bp-feat-meta { display: flex; gap: 1.5rem; font-size: 0.75rem; color: #666; }

        /* Cards Grid */
        .bp-grid-section { background: #fff; padding: 4rem 0 5rem; }
        .bp-grid-section .container { max-width: 1200px; margin: 0 auto; padding: 0 2.5rem; }
        .bp-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
        .bp-card {
            background: #fff; border-radius: 14px; overflow: hidden;
            border: 1px solid #eee; text-decoration: none; color: #111;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .bp-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); color: #111; }
        .bp-card-img { height: 200px; background-size: cover; background-position: center; position: relative; }
        .bp-card-cat {
            position: absolute; top: 1rem; left: 1rem;
            background: rgba(226,119,29,0.9); color: #fff;
            padding: 0.2rem 0.7rem; border-radius: 4px;
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
        }
        .bp-card-body { padding: 1.5rem; }
        .bp-card-body h3 { font-family: 'Rajdhani', sans-serif; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; line-height: 1.2; margin-bottom: 0.6rem; }
        .bp-card-body p { color: #666; font-size: 0.85rem; line-height: 1.6; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .bp-card-meta { display: flex; justify-content: space-between; font-size: 0.72rem; color: #aaa; }

        .bp-empty { text-align: center; padding: 4rem; color: #888; font-size: 1.1rem; }

        /* Hero image prompt: "Dark abstract engineering background with subtle orange geometric lines and metal textures, 1920x600" */

        @media (max-width: 1024px) {
            .bp-grid { grid-template-columns: repeat(2, 1fr); }
            .bp-feat-card { grid-template-columns: 1fr; }
            .bp-feat-img { min-height: 250px; }
        }
        @media (max-width: 768px) {
            .bp-hero { padding: 6rem 0 3rem; }
            .bp-grid { grid-template-columns: 1fr; }
            .bp-feat-body { padding: 2rem; }
            .bp-feat-body h2 { font-size: 1.3rem; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" style="position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(5,5,7,0.95);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,0.06);">
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
                <li><a href="blog.php" style="color:#e2771d;">Blog</a></li>
                <li><a href="haberler.php">Haberler</a></li>
                <li><a href="index.html#iletisim">İletişim</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle"><span></span><span></span><span></span></button>
        </div>
    </nav>

    <!-- Hero -->
    <section class="bp-hero">
        <div class="container">
            <div class="section-label">Blog</div>
            <h1>Güncel Yazılar</h1>
            <p>Mühendislik dünyasından en son gelişmeler, teknik analizler ve derinlemesine incelemeler.</p>
        </div>
    </section>

    <!-- Featured Post -->
    <?php if ($featured): ?>
    <section class="bp-featured">
        <div class="container">
            <a href="post.php?slug=<?= e($featured['slug']) ?>" class="bp-feat-card">
                <div class="bp-feat-img" style="background-image:url('<?= e($featured['image'] ? UPLOAD_URL . $featured['image'] : 'assets/images/blog-ei.png') ?>')"></div>
                <div class="bp-feat-body">
                    <span class="bp-feat-cat"><?= e($featured['category_name'] ?? 'Blog') ?></span>
                    <h2><?= e($featured['title']) ?></h2>
                    <p><?= e($featured['excerpt']) ?></p>
                    <div class="bp-feat-meta">
                        <span><?= formatDate($featured['published_at'] ?? $featured['created_at']) ?></span>
                        <span><?= $featured['read_time'] ?? 5 ?> dk okuma</span>
                    </div>
                </div>
            </a>
        </div>
    </section>
    <?php endif; ?>

    <!-- Blog Grid -->
    <section class="bp-grid-section">
        <div class="container">
            <?php if (empty($rest) && !$featured): ?>
                <div class="bp-empty">Henüz blog yazısı yayınlanmamış.</div>
            <?php else: ?>
            <div class="bp-grid">
                <?php foreach ($rest as $post): ?>
                <a href="post.php?slug=<?= e($post['slug']) ?>" class="bp-card">
                    <div class="bp-card-img" style="background-image:url('<?= e($post['image'] ? UPLOAD_URL . $post['image'] : 'assets/images/bg1.png') ?>')">
                        <?php if ($post['category_name']): ?><span class="bp-card-cat"><?= e($post['category_name']) ?></span><?php endif; ?>
                    </div>
                    <div class="bp-card-body">
                        <h3><?= e($post['title']) ?></h3>
                        <p><?= e($post['excerpt']) ?></p>
                        <div class="bp-card-meta">
                            <span><?= formatDate($post['published_at'] ?? $post['created_at']) ?></span>
                            <span><?= $post['read_time'] ?? 5 ?> dk okuma</span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <script>
    document.getElementById('navToggle').addEventListener('click', function() {
        document.getElementById('navLinks').classList.toggle('open');
        this.classList.toggle('open');
    });
    </script>
</body>
</html>
