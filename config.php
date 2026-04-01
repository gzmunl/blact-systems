<?php
// Blact Systems CMS - Config
session_start();

// Veritabanı ayarları - SUNUCUNA GÖRE DEĞİŞTİR
define('DB_HOST', 'localhost');
define('DB_NAME', 'blact_cms');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site ayarları
define('SITE_URL', '/'); // Sunucuda: 'https://blactsystems.com/'
define('SITE_NAME', 'Blact Systems');
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', SITE_URL . 'uploads/');

// DB bağlantısı
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER, DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        } catch (PDOException $e) {
            die('DB bağlantı hatası: ' . $e->getMessage());
        }
    }
    return $pdo;
}

// Yardımcı fonksiyonlar
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function slugify($text) {
    $tr = ['ç'=>'c','ğ'=>'g','ı'=>'i','ö'=>'o','ş'=>'s','ü'=>'u','Ç'=>'c','Ğ'=>'g','İ'=>'i','Ö'=>'o','Ş'=>'s','Ü'=>'u'];
    $text = strtr($text, $tr);
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . 'admin/login.php');
        exit;
    }
}

function getPosts($type, $limit = 10, $offset = 0) {
    $db = getDB();
    $stmt = $db->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug
        FROM posts p LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.type = ? AND p.status = 'published'
        ORDER BY p.published_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$type, $limit, $offset]);
    return $stmt->fetchAll();
}

function getPost($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug, u.name as author_name
        FROM posts p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN users u ON p.author_id = u.id
        WHERE p.slug = ? AND p.status = 'published'");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

function getCategories($type) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM categories WHERE type = ? ORDER BY name");
    $stmt->execute([$type]);
    return $stmt->fetchAll();
}

function formatDate($date) {
    $months = ['Oca','Şub','Mar','Nis','May','Haz','Tem','Ağu','Eyl','Eki','Kas','Ara'];
    $ts = strtotime($date);
    return date('d', $ts) . ' ' . $months[date('n', $ts) - 1] . ' ' . date('Y', $ts);
}
