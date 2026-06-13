<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// ==========================================
// تنظیمات اتصال به دیتابیس
// ==========================================
$db_host = 'localhost';
$db_name = 'baba';
$db_user = 'root';
$db_pass = '';
$db_charset = 'utf8mb4';

// ==========================================
// داده‌های تست (در صورت نبود دیتابیس)
// ==========================================



$action = $_GET['action'] ?? 'categories';
$use_db = false;

// ==========================================
// تلاش برای اتصال به دیتابیس
// ==========================================
try {
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $use_db = true;
} catch (PDOException $e) {
    // استفاده از داده‌های تست
    $use_db = false;
}

// ==========================================
// عملیات دریافت دسته‌بندی‌ها
// ==========================================
if ($action === 'categories') {
    if ($use_db) {
        $stmt = $pdo->query("
            SELECT c.id, c.name, c.icon,
                   COUNT(p.id) as count
            FROM categories c
            LEFT JOIN poems p ON p.category_id = c.id
            GROUP BY c.id, c.name, c.icon
            ORDER BY c.sort_order ASC
        ");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
    } else {
        echo json_encode(['success' => true, 'data' => $test_categories, 'test_mode' => true]);
    }
}

// ==========================================
// عملیات دریافت اشعار بر اساس دسته (با صفحه‌بندی)
// ==========================================
elseif ($action === 'poems') {
    $category_id = (int)($_GET['category_id'] ?? 0);
    $page        = max(1, (int)($_GET['page']        ?? 1));
    $per_page    = max(1, min(50, (int)($_GET['per_page'] ?? 10)));
    $offset      = ($page - 1) * $per_page;

    if (!$category_id) {
        echo json_encode(['success' => false, 'message' => 'شناسه دسته‌بندی معتبر نیست']);
        exit;
    }

    if ($use_db) {
        // شمارش کل
        $cnt = $pdo->prepare("SELECT COUNT(*) FROM poems WHERE category_id = :cid");
        $cnt->execute(['cid' => $category_id]);
        $total = (int)$cnt->fetchColumn();

        // واکشی صفحه
        $stmt = $pdo->prepare("
            SELECT p.id, p.title, p.content, po.name as poet
            FROM poems p
            LEFT JOIN poets po ON po.id = p.poet_id
            WHERE p.category_id = :cid
            ORDER BY p.created_at DESC
            LIMIT :lim OFFSET :off
        ");
        $stmt->bindValue(':cid', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':lim', $per_page,    PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset,      PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode([
            'success'   => true,
            'data'      => $stmt->fetchAll(),
            'total'     => $total,
            'page'      => $page,
            'per_page'  => $per_page,
            'has_more'  => ($offset + $per_page) < $total,
        ]);
    } else {
        // داده‌های تست با pagination
        $all      = $test_poems[$category_id] ?? [];
        $total    = count($all);
        $slice    = array_slice($all, $offset, $per_page);
        echo json_encode([
            'success'   => true,
            'data'      => $slice,
            'total'     => $total,
            'page'      => $page,
            'per_page'  => $per_page,
            'has_more'  => ($offset + $per_page) < $total,
            'test_mode' => true,
        ]);
    }
}

else {
    echo json_encode(['success' => false, 'message' => 'عملیات نامعتبر']);
}