<?php $pageTitle = 'Dashboard'; require 'header.php';
$db = getDB();
$blogCount = $db->query("SELECT COUNT(*) FROM posts WHERE type='blog'")->fetchColumn();
$newsCount = $db->query("SELECT COUNT(*) FROM posts WHERE type='news'")->fetchColumn();
$publishedCount = $db->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn();
$draftCount = $db->query("SELECT COUNT(*) FROM posts WHERE status='draft'")->fetchColumn();
$recent = $db->query("SELECT p.*, c.name as category_name FROM posts p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 10")->fetchAll();
?>

<div class="page-header">
    <h1>Dashboard</h1>
    <a href="edit.php" class="btn btn-primary">+ Yeni Yazı</a>
</div>

<div class="stats">
    <div class="stat-card"><div class="number"><?= $blogCount ?></div><div class="label">Blog Yazısı</div></div>
    <div class="stat-card"><div class="number"><?= $newsCount ?></div><div class="label">Haber</div></div>
    <div class="stat-card"><div class="number"><?= $publishedCount ?></div><div class="label">Yayında</div></div>
    <div class="stat-card"><div class="number"><?= $draftCount ?></div><div class="label">Taslak</div></div>
</div>

<div class="card">
    <h2 style="font-size:1.1rem; margin-bottom:1rem;">Son Yazılar</h2>
    <table>
        <thead><tr><th>Başlık</th><th>Tür</th><th>Durum</th><th>Tarih</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($recent as $post): ?>
        <tr>
            <td><?= e($post['title']) ?></td>
            <td><span class="badge badge-<?= $post['type'] ?>"><?= $post['type'] === 'blog' ? 'Blog' : 'Haber' ?></span></td>
            <td><span class="badge badge-<?= $post['status'] ?>"><?= $post['status'] === 'published' ? 'Yayında' : 'Taslak' ?></span></td>
            <td style="font-size:0.8rem;color:#888"><?= formatDate($post['created_at']) ?></td>
            <td><div class="actions"><a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-outline">Düzenle</a></div></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($recent)): ?><tr><td colspan="5" style="text-align:center;color:#666;padding:2rem;">Henüz yazı yok.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

</div></body></html>
