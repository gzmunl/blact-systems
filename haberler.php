<?php require_once 'config.php';
$posts = getPosts('news', 50);
$categories = getCategories('news');
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
        .np-hero {
            background: #050507; padding: 8rem 0 4rem; position: relative; overflow: hidden;
        }
        .np-hero::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(226,119,29,0.05) 0%, transparent 60%);
        }
        .np-hero .container { position: relative; z-index: 2; max-width: 1200px; margin: 0 auto; padding: 0 2.5rem; }
        .np-hero .section-label { color: var(--accent); font-size: 0.7rem; letter-spacing: 3px; text-transform: uppercase; font-weight: 700; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 1rem; }
        .np-hero .section-label::before { content: ''; width: 40px; height: 2px; background: var(--accent); }
        .np-hero h1 { font-family: 'Rajdhani', sans-serif; font-size: clamp(2.2rem, 5vw, 3.5rem); font-weight: 700; color: #fff; text-transform: uppercase; line-height: 1.05; margin-bottom: 1rem; }
        .np-hero p { color: #888; max-width: 500px; line-height: 1.7; font-size: 0.95rem; }

        /* Filters */
        .np-filters { display: flex; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 2.5rem; padding-top: 2rem; }
        .np-filter { padding: 0.5rem 1.2rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: transparent; color: #888; font-size: 0.78rem; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .np-filter:hover, .np-filter.active { background: #e2771d; color: #fff; border-color: #e2771d; }

        /* News Grid */
        .np-section { background: #0a0a0f; padding: 0 0 5rem; }
        .np-section .container { max-width: 1200px; margin: 0 auto; padding: 0 2.5rem; }
        .np-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }

        .np-card {
            display: grid; grid-template-columns: 0.4fr 1fr; min-height: 180px;
            background: #12121a; border: 1px solid rgba(255,255,255,0.04); border-radius: 14px;
            overflow: hidden; text-decoration: none; color: #fff; transition: all 0.3s;
        }
        .np-card:hover { transform: translateY(-4px); border-color: rgba(226,119,29,0.2); color: #fff; }
        .np-card-img { background-size: cover; background-position: center; position: relative; }
        .np-card-icon {
            position: absolute; top: 1rem; left: 1rem;
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(226,119,29,0.15); color: #e2771d;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; font-weight: 700;
        }
        .np-card-body { padding: 1.5rem; display: flex; flex-direction: column; justify-content: center; }
        .np-card-cat { font-size: 0.65rem; font-weight: 700; color: #e2771d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
        .np-card-body h3 { font-family: 'Rajdhani', sans-serif; font-size: 1.05rem; font-weight: 700; text-transform: uppercase; line-height: 1.2; margin-bottom: 0.5rem; }
        .np-card-body p { color: #888; font-size: 0.82rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0.8rem; }
        .np-card-date { font-size: 0.7rem; color: #555; }
        .np-empty { text-align: center; padding: 4rem; color: #555; font-size: 1.1rem; }

        /* Hero image prompt: "Dark futuristic newsroom with holographic displays showing engineering news, subtle orange accent lighting, 1920x600" */

        @media (max-width: 1024px) { .np-grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .np-hero { padding: 6rem 0 3rem; }
            .np-card { grid-template-columns: 1fr; }
            .np-card-img { min-height: 180px; }
        }
    </style>
</head>
<body>
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
                <li><a href="blog.php">Blog</a></li>
                <li><a href="haberler.php" style="color:#e2771d;">Haberler</a></li>
                <li><a href="index.html#iletisim">İletişim</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle"><span></span><span></span><span></span></button>
        </div>
    </nav>

    <section class="np-hero">
        <div class="container">
            <div class="section-label">Haberler</div>
            <h1>Sektörden Haberler</h1>
            <p>Mühendislik ve ileri teknoloji dünyasından son gelişmeler.</p>
        </div>
    </section>

    <section class="np-section">
        <div class="container">
            <!-- Filters -->
            <div class="np-filters">
                <button class="np-filter active" data-filter="all">Tümü</button>
                <?php foreach ($categories as $cat): ?>
                <button class="np-filter" data-filter="<?= e($cat['slug']) ?>"><?= e($cat['name']) ?></button>
                <?php endforeach; ?>
            </div>

            <?php if (empty($posts)): ?>
                <div class="np-empty">Henüz haber yayınlanmamış.</div>
            <?php else: ?>
            <div class="np-grid">
                <?php $icons = ['⬡','△','◈','◯','⬢','▽','◇','●']; $i = 0; ?>
                <?php foreach ($posts as $post): ?>
                <a href="post.php?slug=<?= e($post['slug']) ?>" class="np-card" data-category="<?= e($post['category_slug'] ?? '') ?>">
                    <div class="np-card-img" style="background-image:url('<?= e($post['image'] ? UPLOAD_URL . $post['image'] : 'assets/images/bg2.png') ?>')">
                        <div class="np-card-icon"><?= $icons[$i % count($icons)] ?></div>
                    </div>
                    <div class="np-card-body">
                        <span class="np-card-cat"><?= e($post['category_name'] ?? 'Haber') ?></span>
                        <h3><?= e($post['title']) ?></h3>
                        <p><?= e($post['excerpt']) ?></p>
                        <span class="np-card-date"><?= formatDate($post['published_at'] ?? $post['created_at']) ?></span>
                    </div>
                </a>
                <?php $i++; endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <script>
    document.getElementById('navToggle').addEventListener('click', function() {
        document.getElementById('navLinks').classList.toggle('open');
        this.classList.toggle('open');
    });
    // Category filter
    document.querySelectorAll('.np-filter').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.np-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            var filter = this.dataset.filter;
            document.querySelectorAll('.np-card').forEach(function(card) {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    </script>
</body>
</html>
