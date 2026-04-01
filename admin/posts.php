<?php
$type = $_GET['type'] ?? 'blog';
if (!in_array($type, ['blog', 'news'])) $type = 'blog';
$pageTitle = $type === 'blog' ? 'Blog Yazıları' : 'Haberler';
require 'header.php';

// Silme
if (isset($_GET['delete'])) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: posts.php?type=$type&msg=deleted");
    exit;
}

$db = getDB();
$stmt = $db->prepare("SELECT p.*, c.name as category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id WHERE p.type = ? ORDER BY p.created_at DESC");
$stmt->execute([$type]);
$posts = $stmt->fetchAll();
?>

<div class="page-header">
    <h1><?= $pageTitle ?></h1>
    <a href="edit.php?type=<?= $type ?>" class="btn btn-primary">+ Yeni <?= $type === 'blog' ? 'Yazı' : 'Haber' ?></a>
</div>

<?php if (isset($_GET['msg'])): ?>
<div class="alert alert-success">İşlem başarılı.</div>
<?php endif; ?>

<div class="card">
<table>
    <thead><tr><th>Görsel</th><th>Başlık</th><th>Kategori</th><th>Durum</th><th>Tarih</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php if ($post['image']): ?><img src="<?= e(UPLOAD_URL . $post['image']) ?>" class="thumb"><?php else: ?><div class="thumb" style="background:#1a1a25;"></div><?php endif; ?></td>
        <td><strong><?= e($post['title']) ?></strong></td>
        <td style="font-size:0.8rem;color:#888"><?= e($post['category_name'] ?? '-') ?></td>
        <td><span class="badge badge-<?= $post['status'] ?>"><?= $post['status'] === 'published' ? 'Yayında' : 'Taslak' ?></span></td>
        <td style="font-size:0.8rem;color:#888"><?= formatDate($post['created_at']) ?></td>
        <td>
            <div class="actions">
                <a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-outline">Düzenle</a>
                <a href="posts.php?type=<?= $type ?>&delete=<?= $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($posts)): ?><tr><td colspan="6" style="text-align:center;color:#666;padding:2rem;">Henüz yazı yok.</td></tr><?php endif; ?>
    </tbody>
</table>
</div>

</div></body></html>
