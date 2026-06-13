<?php
session_start();

// تنظیمات دیتابیس (بر اساس فایل api.php شما)
define('DB_HOST', '127.0.0.1:8889');
define('DB_NAME', 'baba');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// مشخصات ورود ادمین
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123'); // پیشنهاد می‌شود بعد از اولین ورود تغییر دهید

function get_db_connection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        return null; // در محیط واقعی خطا را مدیریت کنید
    }
}

function is_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function check_auth() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
?>