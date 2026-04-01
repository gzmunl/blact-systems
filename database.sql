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
    read_time INT DEFAULT 5,
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

-- Kategoriler
INSERT INTO categories (name, slug, type) VALUES
('Eklemeli İmalat', 'eklemeli-imalat', 'blog'),
('Kompozit', 'kompozit', 'blog'),
('İnsansız Araçlar', 'insansiz-araclar', 'blog'),
('Sürdürülebilirlik', 'surdurulebilirlik', 'blog'),
('Eklemeli İmalat', 'eklemeli-imalat-news', 'news'),
('İnsansız Araçlar', 'insansiz-araclar-news', 'news'),
('Sürdürülebilirlik', 'surdurulebilirlik-news', 'news'),
('Kompozit', 'kompozit-news', 'news');

-- Örnek Blog Yazıları
INSERT INTO posts (title, slug, excerpt, content, image, category_id, type, status, read_time, author_id, published_at) VALUES
('SLM ve WAAM: Metal Eklemeli İmalatın İki Farklı Yaklaşımı',
 'slm-ve-waam-metal-eklemeli-imalatn-iki-farkli-yaklasimi',
 'Selective Laser Melting ve Wire Arc Additive Manufacturing teknolojilerinin karşılaştırmalı analizi ve endüstriyel uygulamalarına derinlemesine bakış.',
 '<p>Metal eklemeli imalat, geleneksel üretim yöntemlerinin sınırlarını aşarak endüstriye yeni olanaklar sunuyor. Bu yazıda, iki öncü teknoloji olan <strong>SLM (Selective Laser Melting)</strong> ve <strong>WAAM (Wire Arc Additive Manufacturing)</strong> yöntemlerini detaylı olarak inceliyoruz.</p><h2>SLM Teknolojisi</h2><p>SLM, yüksek güçlü lazer kullanarak metal tozunu katman katman eritir ve birleştirir. Havacılık ve medikal implant gibi yüksek hassasiyet gerektiren alanlarda tercih edilir.</p><h2>WAAM Teknolojisi</h2><p>WAAM, tel beslemeli ark kaynak prensibini kullanarak büyük ölçekli metal parçalar üretir. Gemi inşaatı ve enerji sektöründe maliyet etkin çözümler sunar.</p><h2>Karşılaştırma</h2><p>SLM mikron seviyesinde hassasiyet sağlarken, WAAM daha büyük parçaları daha hızlı üretir. Seçim, uygulamanın gerektirdiği toleranslara ve parça boyutuna bağlıdır.</p>',
 'blog-ei.png', 1, 'blog', 'published', 8, 1, '2026-03-18 10:00:00'),

('Karbon Fiber Üretiminde Yeni Nesil Yaklaşımlar',
 'karbon-fiber-uretiminde-yeni-nesil-yaklasimlar',
 'İleri kompozit malzeme teknolojileriyle hafif, dayanıklı ve yüksek performanslı yapısal çözümler geliştiriyoruz.',
 '<p>Karbon fiber kompozitler, havacılık, otomotiv ve savunma sanayilerinde devrim yaratmaya devam ediyor. Yeni nesil üretim teknikleri sayesinde maliyetler düşerken performans artıyor.</p><h2>Otomatik Fiber Yerleştirme (AFP)</h2><p>AFP teknolojisi, karbon fiber bantlarını hassas bir şekilde kalıp üzerine yerleştirerek homojen ve güçlü yapılar oluşturur.</p><h2>Reçine Transfer Kalıplama (RTM)</h2><p>RTM, kapalı kalıp içinde reçine enjeksiyonu ile yüksek kaliteli kompozit parçalar üretmeyi mümkün kılar.</p>',
 'blog-kt.png', 2, 'blog', 'published', 7, 1, '2026-03-12 10:00:00'),

('Otonom Deniz Araçlarının Endüstriyel Uygulamaları',
 'otonom-deniz-araclarinin-endustriyel-uygulamalari',
 'İnsansız deniz araçları, okyanus araştırmalarından lojistiğe kadar geniş bir yelpazede endüstriyel çözümler sunuyor.',
 '<p>İnsansız deniz araçları (USV), denizcilik sektöründe yeni bir çağ açıyor. Okyanus araştırmaları, kıyı güvenliği, sualtı inceleme ve lojistik operasyonlarında kullanılmaya başlanan bu sistemler, maliyetleri düşürürken verimliliği artırıyor.</p><h2>Endüstriyel Kullanım Alanları</h2><p>Offshore enerji tesisleri, balıkçılık izleme, çevresel gözlem ve arama-kurtarma operasyonları başlıca uygulama alanlarıdır.</p>',
 'blog-iha.png', 3, 'blog', 'published', 6, 1, '2026-03-05 10:00:00'),

('Mühendislikte Sürdürülebilirlik: Tasarımdan Üretime Yeşil Dönüşüm',
 'muhendislikte-surdurulebilirlik-yesil-donusum',
 'Çevreye duyarlı mühendislik yaklaşımlarıyla üretim süreçlerinde karbon ayak izini azaltmanın yollarını keşfediyoruz.',
 '<p>Sürdürülebilir mühendislik, tasarım aşamasından üretime kadar tüm süreçlerde çevresel etkiyi minimize etmeyi hedefler. Döngüsel ekonomi prensipleri, malzeme verimliliği ve enerji optimizasyonu bu dönüşümün temel taşlarıdır.</p><h2>Yaşam Döngüsü Analizi</h2><p>Ürünlerin çevresel etkisini hammadde çıkarımından bertarafa kadar değerlendiren LCA yöntemi, sürdürülebilir tasarım kararlarının temelidir.</p>',
 NULL, 4, 'blog', 'published', 7, 1, '2026-02-27 10:00:00');

-- Örnek Haberler
INSERT INTO posts (title, slug, excerpt, content, image, category_id, type, status, read_time, author_id, published_at) VALUES
('Türkiye''nin İlk Büyük Ölçekli Metal AM Tesisi İçin Çalışmalar Hızlandı',
 'turkiyenin-ilk-buyuk-olcekli-metal-am-tesisi',
 'Eklemeli imalat sektöründe yerli üretim kapasitesini artırmaya yönelik yeni yatırımlar gündemde.',
 '<p>Türkiye, metal eklemeli imalat alanında büyük bir adım atmaya hazırlanıyor. Sanayi ve Teknoloji Bakanlığı öncülüğünde başlatılan proje kapsamında, ülkenin ilk büyük ölçekli Metal AM tesisi kurulacak.</p><p>Tesisin 2027 yılı sonuna kadar faaliyete geçmesi planlanıyor. Havacılık, savunma ve otomotiv sektörlerinde yerli üretim kapasitesini önemli ölçüde artırması bekleniyor.</p>',
 'news-am.png', 5, 'news', 'published', 4, 1, '2026-03-20 10:00:00'),

('Avrupa''da İHA Regülasyonları Güncellendi: Yeni Sınıflandırma Sistemi',
 'avrupada-iha-regulasyonlari-guncellendi',
 'EASA''nın yeni düzenlemeleri insansız hava araçları sektörünü yeniden şekillendirecek.',
 '<p>Avrupa Havacılık Emniyeti Ajansı (EASA), insansız hava araçları için yeni bir sınıflandırma sistemi açıkladı. Yeni düzenleme ile İHA''lar ağırlık, uçuş yüksekliği ve kullanım amacına göre yeniden kategorize edilecek.</p><p>Bu değişiklikler, ticari İHA operasyonlarını kolaylaştırırken güvenlik standartlarını da yükseltmeyi hedefliyor.</p>',
 'news-iha.png', 6, 'news', 'published', 3, 1, '2026-03-15 10:00:00'),

('Sürdürülebilir Enerji Yatırımlarında Rekor Artış',
 'surdurulebilir-enerji-yatirimlarinda-rekor-artis',
 '2026 yılının ilk çeyreğinde yenilenebilir enerji projelerine yapılan küresel yatırımlar %23 arttı.',
 '<p>BloombergNEF verilerine göre, 2026 yılının ilk çeyreğinde yenilenebilir enerji yatırımları bir önceki yıla kıyasla %23 artarak 180 milyar dolara ulaştı.</p><p>Güneş enerjisi ve rüzgar enerjisi projeleri bu artışın başlıca sürücüleri olurken, yeşil hidrojen yatırımları da ivme kazandı.</p>',
 'news-energy.png', 7, 'news', 'published', 3, 1, '2026-03-10 10:00:00');
