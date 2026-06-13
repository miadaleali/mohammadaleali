<?php
require_once 'admin/config.php';
$db = get_db_connection();

if (!$db) {
    die("خطا در اتصال به دیتابیس.");
}

$sql = <<<SQL
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categories` (`id`, `parent_id`, `name`, `icon`, `sort_order`) VALUES
(1, NULL, 'شعر فارسی', 'assets/img/cat_1781387539.gif', 0),
(2, 1, 'دو بیتی ها', 'assets/img/cat_1781384781.pdf', 0),
(3, 1, 'غزلیات', 'assets/img/cat_1781385100.svg', 0),
(5, NULL, 'شعر عربی', 'assets/img/cat_1781387552.gif', 0);

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `reply` text,
  `content_type` enum('poem','painting') NOT NULL,
  `content_id` int NOT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `comments` (`id`, `author`, `comment`, `reply`, `content_type`, `content_id`, `status`, `created_at`) VALUES
(1, 'میعاد', 'عالی بود استاد بزرگ', 'خواهش میکنم دوست عزیز', 'poem', 9, 'approved', '2026-06-13 13:12:21');

DROP TABLE IF EXISTS `painting_categories`;
CREATE TABLE `painting_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `painting_categories` (`id`, `parent_id`, `name`, `icon`, `sort_order`) VALUES
(1, NULL, 'رنگ روغن', 'assets/img/cat_1781385788.jpg', 0),
(2, NULL, 'آب رنگ', 'assets/img/cat_1781385799.jpg', 0),
(3, 1, 'منظره', 'assets/img/cat_1781385810.jpg', 0);

DROP TABLE IF EXISTS `paintings`;
CREATE TABLE `paintings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `year` int DEFAULT NULL,
  `technique` varchar(100) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `fullsize` varchar(255) DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `paintings_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `painting_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `poets`;
CREATE TABLE `poets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `poems`;
CREATE TABLE `poems` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `poet_id` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `poet_id` (`poet_id`),
  CONSTRAINT `poems_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `poems_ibfk_2` FOREIGN KEY (`poet_id`) REFERENCES `poets` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

SET FOREIGN_KEY_CHECKS = 1;
SQL;

try {
    $db->exec($sql);
    echo "<h2 style='color: green; font-family: Tahoma;'>دیتابیس با موفقیت طبق خروجی SQL شما به‌روزرسانی شد.</h2>";
    echo "<p>تمام جداول پاکسازی و داده‌های جدید وارد شدند.</p>";
    echo "<p><a href='admin/index.php'>رفتن به پنل مدیریت</a></p>";
} catch (PDOException $e) {
    echo "<h2 style='color: red; font-family: Tahoma;'>خطا در اجرای SQL:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
