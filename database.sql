-- Blact Systems CMS Database Schema
CREATE DATABASE IF NOT EXISTS blact_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blact_cms;

-- Kullanıcılar (admin login)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Kategoriler
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    type ENUM('blog', 'news') NOT NULL DEFAULT 'blog'
);

-- Yazılar (blog + haber)
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT,
    content LONGTEXT,
    image VARCHAR(255),
    category_id INT,
    type ENUM('blog', 'news') NOT NULL DEFAULT 'blog',
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    author_id INT,
    published_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Varsayılan admin kullanıcı (şifre: admin123 - MUTLAKA DEĞİŞTİR!)
INSERT INTO users (username, password, name) VALUES
('admin', '$2y$10$8K1p/a0dR1xqM8k.5Kbx3OZGnGvMGCrN7QbVHPJOGHPxOyDpC4H6i', 'Admin');

-- Varsayılan kategoriler
INSERT INTO categories (name, slug, type) VALUES
('Eklemeli İmalat', 'eklemeli-imalat', 'blog'),
('Kompozit', 'kompozit', 'blog'),
('İnsansız Araçlar', 'insansiz-araclar', 'blog'),
('Sürdürülebilirlik', 'surdurulebilirlik', 'blog'),
('Sektör', 'sektor', 'news'),
('Teknoloji', 'teknoloji', 'news'),
('Şirket', 'sirket', 'news');
