<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// ==========================================
// تنظیمات اتصال به دیتابیس
// ==========================================
$db_host = '127.0.0.1:8889';
$db_name = 'baba';
$db_user = 'root';
$db_pass = 'root';
$db_charset = 'utf8mb4';

// ==========================================
// داده‌های تست (در صورت نبود دیتابیس)
// ==========================================
$test_categories = [
    ['id' => 1, 'name' => 'غزلیات حافظ', 'icon' => '🍷', 'count' => 3],
    ['id' => 2, 'name' => 'رباعیات خیام', 'icon' => '⏳', 'count' => 2],
    ['id' => 3, 'name' => 'اشعار مولانا', 'icon' => '💃', 'count' => 2],
    ['id' => 4, 'name' => 'شاهنامه فردوسی', 'icon' => '⚔️', 'count' => 1],
    ['id' => 5, 'name' => 'اشعار معاصر', 'icon' => '🖋️', 'count' => 2],
];

$test_poems = [
    1 => [
        ['id' => 1, 'title' => 'الا یا ایها الساقی', 'content' => "الا یا ایها الساقی ادر کاسا و ناولها\nکه عشق آسان نمود اول ولی افتاد مشکل‌ها\nبه بوی نافه‌ای کاخر صبا زان طره بگشاید\nز تاب جعد مشکینش چه خون افتاد در دل‌ها", 'poet' => 'حافظ'],
        ['id' => 2, 'title' => 'اگر آن ترک شیرازی', 'content' => "اگر آن ترک شیرازی به دست آرد دل ما را\nبه خال هندویش بخشم سمرقند و بخارا را\nبده ساقی می باقی که در جنت نخواهی یافت\nکنار آب رکن آباد و گلگشت مصلا را", 'poet' => 'حافظ'],
        ['id' => 3, 'title' => 'مژده وصل', 'content' => "مژده وصل تو کو کز سر جان برخیزم\nطایر قدسم و از دام جهان برخیزم\nبه ولای تو که گر بنده خویشم خوانی\nاز سر خواجگی کون و مکان برخیزم", 'poet' => 'حافظ'],
    ],
    2 => [
        ['id' => 4, 'title' => 'اسرار ازل', 'content' => "اسرار ازل را نه تو دانی و نه من\nوین حرف معما نه تو خوانی و نه من\nهست از پس پرده گفتگوی من و تو\nچون پرده برافتد نه تو مانی و نه من", 'poet' => 'خیام'],
        ['id' => 5, 'title' => 'این کوزه', 'content' => "این کوزه که چون من عاشقی بوده است\nدر بند سر زلف نگاری بوده است\nاین دسته که بر گردن او می‌بینی\nدستی است که بر گردن یاری بوده است", 'poet' => 'خیام'],
    ],
    3 => [
        ['id' => 6, 'title' => 'نی‌نامه', 'content' => "بشنو این نی چون شکایت می‌کند\nاز جدایی‌ها حکایت می‌کند\nکز نیستان تا مرا ببریده‌اند\nدر نفیرم مرد و زن نالیده‌اند", 'poet' => 'مولانا'],
        ['id' => 7, 'title' => 'رقص چنین', 'content' => "رقص آنجا کن که خود را بشکنی\nپنبه را از ریش شهوت برکنی\nرقص و جولان بر سر میدان کنند\nرقص اندر خون خود مردان کنند", 'poet' => 'مولانا'],
    ],
    4 => [
        ['id' => 8, 'title' => 'گفتار اندر ستایش خرد', 'content' => "خرد بهتر از هر چه ایزد بداد\nستایش خرد را به از راه داد\nخرد رهنمای و خرد دلگشای\nخرد دست گیرد به هر دو سرای", 'poet' => 'فردوسی'],
    ],
    5 => [
        ['id' => 9, 'title' => 'در گلستانه', 'content' => "دشت‌هایی چه فراخ\nکوه‌هایی چه بلند\nدر گلستانه چه بوی علفی می‌آمد\nمن در این آبادی پی چیزی می‌گشتم", 'poet' => 'سهراب سپهری'],
        ['id' => 10, 'title' => 'زمستان', 'content' => "سلامت را نمی‌خواهند پاسخ گفت\nسرها در گریبان است\nکسی سر بر نیارد کرد پاسخ گفتن و دیدار یاران را\nنگه جز پیش پا را دید، نتواند", 'poet' => 'مهدی اخوان ثالث'],
    ]
];

$action = $_GET['action'] ?? 'categories';
// تلاش برای اتصال به دیتابیس
try {
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $use_db = true;
} catch (PDOException $e) {
    $use_db = false;
}

// ==========================================
// عملیات دریافت دسته‌بندی‌ها
// ==========================================
if ($action === 'categories') {
    if ($use_db) {
        $stmt = $pdo->query("
            SELECT c.id, c.name, c.icon, c.parent_id,
                   COUNT(p.id) as count
            FROM categories c
            LEFT JOIN poems p ON p.category_id = c.id
            GROUP BY c.id, c.name, c.icon, c.parent_id
            ORDER BY COALESCE(c.parent_id, c.id), c.parent_id IS NOT NULL, c.sort_order ASC
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
        // پیدا کردن تمام زیرمجموعه‌ها (اگر وجود داشته باشند)
        $cat_ids = [$category_id];
        $sub_stmt = $pdo->prepare("SELECT id FROM categories WHERE parent_id = ?");
        $sub_stmt->execute([$category_id]);
        $subs = $sub_stmt->fetchAll(PDO::FETCH_COLUMN);
        if ($subs) {
            $cat_ids = array_merge($cat_ids, $subs);
        }
        
        $placeholders = implode(',', array_fill(0, count($cat_ids), '?'));

        // شمارش کل
        $cnt = $pdo->prepare("SELECT COUNT(*) FROM poems WHERE category_id IN ($placeholders)");
        $cnt->execute($cat_ids);
        $total = (int)$cnt->fetchColumn();

        // واکشی صفحه
        $stmt = $pdo->prepare("
            SELECT p.id, p.title, p.content, po.name as poet
            FROM poems p
            LEFT JOIN poets po ON po.id = p.poet_id
            WHERE p.category_id IN ($placeholders)
            ORDER BY p.created_at DESC
            LIMIT ? OFFSET ?
        ");
        
        $params = array_merge($cat_ids, [$per_page, $offset]);
        // PDO با LIMIT/OFFSET در آرایه execute مشکل دارد، پس bindValue استفاده می‌کنیم
        foreach($cat_ids as $k => $id) {
            $stmt->bindValue($k + 1, $id, PDO::PARAM_INT);
        }
        $stmt->bindValue(count($cat_ids) + 1, $per_page, PDO::PARAM_INT);
        $stmt->bindValue(count($cat_ids) + 2, $offset, PDO::PARAM_INT);
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