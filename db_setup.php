<?php
require_once 'admin/config.php';
$db = get_db_connection();

if (!$db) {
    die("خطا در اتصال به دیتابیس.");
}

try {
    // ایجاد جداول (اگر وجود ندارند)
    $db->exec("CREATE TABLE IF NOT EXISTS categories (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, icon VARCHAR(255) DEFAULT NULL, sort_order INT DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    $db->exec("CREATE TABLE IF NOT EXISTS painting_categories (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, icon VARCHAR(255) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    $db->exec("CREATE TABLE IF NOT EXISTS poems (id INT AUTO_INCREMENT PRIMARY KEY, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, poet VARCHAR(100) DEFAULT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    $db->exec("CREATE TABLE IF NOT EXISTS paintings (id INT AUTO_INCREMENT PRIMARY KEY, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, thumb VARCHAR(255) DEFAULT NULL, fullsize VARCHAR(255) DEFAULT NULL, technique VARCHAR(100) DEFAULT NULL, year INT DEFAULT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    $db->exec("CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, author VARCHAR(100) NOT NULL, comment TEXT NOT NULL, reply TEXT DEFAULT NULL, content_type ENUM('poem', 'painting') NOT NULL, content_id INT NOT NULL, status ENUM('pending', 'approved') DEFAULT 'pending', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // وارد کردن داده‌های تست اگر جدول خالی باشد
    $count = $db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    if ($count == 0) {
        // دسته‌بندی‌ها
        $cats = [
            [1, 'غزلیات حافظ', '🍷'],
            [2, 'رباعیات خیام', '⏳'],
            [3, 'اشعار مولانا', '💃'],
            [4, 'شاهنامه فردوسی', '⚔️'],
            [5, 'اشعار معاصر', '🖋️']
        ];
        $stmtCat = $db->prepare("INSERT INTO categories (id, name, icon) VALUES (?, ?, ?)");
        foreach ($cats as $c) $stmtCat->execute($c);

        // اشعار
        $poems = [
            [1, 'الا یا ایها الساقی', "الا یا ایها الساقی ادر کاسا و ناولها\nکه عشق آسان نمود اول ولی افتاد مشکل‌ها", 'حافظ'],
            [1, 'اگر آن ترک شیرازی', "اگر آن ترک شیرازی به دست آرد دل ما را\nبه خال هندویش بخشم سمرقند و بخارا را", 'حافظ'],
            [2, 'اسرار ازل', "اسرار ازل را نه تو دانی و نه من\nوین حرف معما نه تو خوانی و نه من", 'خیام'],
            [3, 'نی‌نامه', "بشنو این نی چون شکایت می‌کند\nاز جدایی‌ها حکایت می‌کند", 'مولانا'],
            [4, 'ستایش خرد', "خرد بهتر از هر چه ایزد بداد\nستایش خرد را به از راه داد", 'فردوسی'],
            [5, 'زمستان', "سلامت را نمی‌خواهند پاسخ گفت\nسرها در گریبان است", 'مهدی اخوان ثالث']
        ];
        $stmtPoem = $db->prepare("INSERT INTO poems (category_id, title, content, poet) VALUES (?, ?, ?, ?)");
        foreach ($poems as $p) $stmtPoem->execute($p);

        // دسته‌بندی نقاشی
        $db->exec("INSERT INTO painting_categories (name, icon) VALUES ('نقاشی مدرن', '🎨'), ('خطاطی', '✒️')");
        
        echo "<h2 style='color: green; font-family: Tahoma;'>داده‌های تست با موفقیت به دیتابیس منتقل شدند!</h2>";
    } else {
        echo "<h2 style='color: orange; font-family: Tahoma;'>دیتابیس قبلاً دارای اطلاعات بوده است. موردی اضافه نشد.</h2>";
    }

    echo "<p><a href='admin/index.php'>رفتن به پنل مدیریت</a></p>";

} catch (PDOException $e) {
    die("خطا: " . $e->getMessage());
}
?>