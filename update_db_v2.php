<?php
require_once 'admin/config.php';
$db = get_db_connection();

try {
    // اضافه کردن ستون parent_id به جدول دسته‌بندی اشعار
    $db->exec("ALTER TABLE categories ADD COLUMN parent_id INT DEFAULT NULL AFTER id");
    
    // اضافه کردن ستون parent_id به جدول دسته‌بندی نقاشی‌ها
    $db->exec("ALTER TABLE painting_categories ADD COLUMN parent_id INT DEFAULT NULL AFTER id");

    echo "<h2 style='color: green; font-family: Tahoma;'>ساختار دیتابیس با موفقیت به‌روز شد!</h2>";
    echo "<p>ستون 'دسته مادر' به جداول اضافه شد.</p>";
    echo "<a href='admin/categories.php'>بازگشت به مدیریت دسته‌ها</a>";

} catch (PDOException $e) {
    echo "<h2 style='color: orange; font-family: Tahoma;'>احتمالاً ستون‌ها قبلاً اضافه شده‌اند یا خطایی رخ داده است:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>