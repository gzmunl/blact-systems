<?php
$pageTitle = 'Kategoriler';
require 'header.php';
$db = getDB();

// Ekleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    $type = $_POST['type'] ?? 'blog';
    $slug = slugify($name);
    $stmt = $db->prepare("INSERT INTO categories (name, slug, type) VALUES (?, ?, ?)");
    $stmt->execute([$name, $slug, $type]);
    header('Location: categories.php?msg=added');
    exit;
}

// Silme
if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: categories.php?msg=deleted');
    exit;
}

$categories = $db->query("SELECT * FROM categories ORDER BY type, name")->fetchAll();
?>

<div class="page-header">
    <h1>Kategoriler</h1>
</div>

<?php if (isset($_GET['msg'])): ?><div class="alert alert-success">İşlem başarılı.</div><?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
<div class="card">
    <h2 style="font-size:1.1rem;margin-bottom:1rem;">Yeni Kategori</h2>
    <form method="POST">
        <div class="form-group"><label>Ad</label><input type="text" name="name" required></div>
        <div class="form-group">
            <label>Tür</label>
            <select name="type"><option value="blog">Blog</option><option value="news">Haber</option></select>
        </div>
        <button type="submit" class="btn btn-primary">Ekle</button>
    </form>
</div>

<div class="card">
    <h2 style="font-size:1.1rem;margin-bottom:1rem;">Mevcut Kategoriler</h2>
    <table>
        <thead><tr><th>Ad</th><th>Tür</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($categories as $cat): ?>
        <tr>
            <td><?= e($cat['name']) ?></td>
            <td><span class="badge badge-<?= $cat['type'] ?>"><?= $cat['type'] === 'blog' ? 'Blog' : 'Haber' ?></span></td>
            <td><a href="categories.php?delete=<?= $cat['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>

</div></body></html>
