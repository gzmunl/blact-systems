<?php
$pageTitle = 'Yazı Düzenle';
require 'header.php';
$db = getDB();

$post = null;
if (isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $post = $stmt->fetch();
}

$type = $post['type'] ?? ($_GET['type'] ?? 'blog');
$categories = getCategories($type);
$msg = '';

// Kaydetme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = slugify($title);
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = $_POST['content'] ?? '';
    $category_id = $_POST['category_id'] ?: null;
    $type = $_POST['type'] ?? 'blog';
    $status = $_POST['status'] ?? 'draft';
    $published_at = $status === 'published' ? ($_POST['published_at'] ?: date('Y-m-d H:i:s')) : null;

    // Resim upload
    $image = $post['image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp','gif'])) {
            if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);
            $filename = $slug . '-' . time() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR . $filename);
            $image = $filename;
        }
    }

    if ($post) {
        // Güncelleme
        $stmt = $db->prepare("UPDATE posts SET title=?, slug=?, excerpt=?, content=?, image=?, category_id=?, type=?, status=?, published_at=? WHERE id=?");
        $stmt->execute([$title, $slug, $excerpt, $content, $image, $category_id, $type, $status, $published_at, $post['id']]);
        $msg = 'Yazı güncellendi.';
        // Yeniden oku
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$post['id']]);
        $post = $stmt->fetch();
    } else {
        // Yeni yazı
        $stmt = $db->prepare("INSERT INTO posts (title, slug, excerpt, content, image, category_id, type, status, author_id, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $excerpt, $content, $image, $category_id, $type, $status, $_SESSION['admin_id'], $published_at]);
        $newId = $db->lastInsertId();
        header("Location: edit.php?id=$newId&msg=created");
        exit;
    }
}

if (isset($_GET['msg'])) $msg = 'Yazı oluşturuldu.';
$categories = getCategories($type);
?>

<div class="page-header">
    <h1><?= $post ? 'Yazı Düzenle' : 'Yeni Yazı' ?></h1>
    <a href="posts.php?type=<?= $type ?>" class="btn btn-outline">← Listeye Dön</a>
</div>

<?php if ($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data">
<div class="card">
    <div class="form-group">
        <label>Başlık</label>
        <input type="text" name="title" value="<?= e($post['title'] ?? '') ?>" required>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Tür</label>
            <select name="type" id="typeSelect" onchange="location.href='edit.php?type='+this.value">
                <option value="blog" <?= $type === 'blog' ? 'selected' : '' ?>>Blog</option>
                <option value="news" <?= $type === 'news' ? 'selected' : '' ?>>Haber</option>
            </select>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id">
                <option value="">-- Seçiniz --</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($post['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Özet</label>
        <input type="text" name="excerpt" value="<?= e($post['excerpt'] ?? '') ?>" placeholder="Kısa açıklama...">
    </div>

    <div class="form-group">
        <label>Kapak Görseli</label>
        <?php if (!empty($post['image'])): ?>
        <div style="margin-bottom:0.5rem"><img src="<?= e(UPLOAD_URL . $post['image']) ?>" style="max-height:120px;border-radius:8px;"></div>
        <?php endif; ?>
        <input type="file" name="image" accept="image/*" style="padding:0.5rem;">
    </div>

    <div class="form-group">
        <label>İçerik (HTML)</label>
        <textarea name="content"><?= e($post['content'] ?? '') ?></textarea>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Durum</label>
            <select name="status">
                <option value="draft" <?= ($post['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Taslak</option>
                <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>Yayında</option>
            </select>
        </div>
        <div class="form-group">
            <label>Yayın Tarihi</label>
            <input type="datetime-local" name="published_at" value="<?= $post['published_at'] ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : '' ?>">
        </div>
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary"><?= $post ? 'Güncelle' : 'Oluştur' ?></button>
    <a href="posts.php?type=<?= $type ?>" class="btn btn-outline">İptal</a>
</div>
</form>

</div></body></html>
