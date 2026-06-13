<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// ==========================================
// تنظیمات اتصال به دیتابیس
// ==========================================
$db_host    = 'localhost';
$db_name    = 'baba';
$db_user    = 'root';
$db_pass    = '';
$db_charset = 'utf8mb4';

// ==========================================
// داده‌های تست (در صورت نبود دیتابیس)
// ==========================================

// تصاویر placeholder با picsum برای تست
function placeholder(int $seed, int $w = 400, int $h = 300): string {
    return "https://picsum.photos/seed/{$seed}/{$w}/{$h}";
}
function placeholderFull(int $seed): string {
    return "https://picsum.photos/seed/{$seed}/1200/900";
}

$test_categories = [
    ['id'=>1,'name'=>'پرتره',       'icon'=>'👤','count'=>4],
    ['id'=>2,'name'=>'منظره',       'icon'=>'🌄','count'=>5],
    ['id'=>3,'name'=>'انتزاعی',     'icon'=>'🌀','count'=>3],
    ['id'=>4,'name'=>'طبیعت بیجان', 'icon'=>'🌸','count'=>3],
    ['id'=>5,'name'=>'شهری',        'icon'=>'🏙️','count'=>2],
    ['id'=>6,'name'=>'مذهبی',       'icon'=>'☪️', 'count'=>2],
];

$test_paintings = [
    1 => [
        ['id'=>1,  'title'=>'نگاه آرام',    'description'=>'پرتره زنی در سکوت',   'year'=>2021,'technique'=>'رنگ روغن', 'thumb'=>placeholder(10),'fullsize'=>placeholderFull(10)],
        ['id'=>2,  'title'=>'چشمان باران',  'description'=>'بازتاب احساس در نگاه','year'=>2022,'technique'=>'آبرنگ',    'thumb'=>placeholder(20),'fullsize'=>placeholderFull(20)],
        ['id'=>3,  'title'=>'پیرمرد',       'description'=>'چهره‌ای پر از خاطره', 'year'=>2020,'technique'=>'پاستل',    'thumb'=>placeholder(30),'fullsize'=>placeholderFull(30)],
        ['id'=>4,  'title'=>'دختر کوچک',    'description'=>'معصومیت کودکی',        'year'=>2023,'technique'=>'رنگ روغن', 'thumb'=>placeholder(40),'fullsize'=>placeholderFull(40)],
    ],
    2 => [
        ['id'=>5,  'title'=>'سپیده‌دم',     'description'=>'طلوع آفتاب در کوهستان','year'=>2021,'technique'=>'آبرنگ',    'thumb'=>placeholder(50),'fullsize'=>placeholderFull(50)],
        ['id'=>6,  'title'=>'جنگل بارانی',  'description'=>'سکوت جنگل پس از باران','year'=>2022,'technique'=>'رنگ روغن', 'thumb'=>placeholder(60),'fullsize'=>placeholderFull(60)],
        ['id'=>7,  'title'=>'دریا در طوفان','description'=>'قدرت طبیعت',            'year'=>2020,'technique'=>'آکریلیک',  'thumb'=>placeholder(70),'fullsize'=>placeholderFull(70)],
        ['id'=>8,  'title'=>'غروب طلایی',   'description'=>'آخرین نور روز',         'year'=>2023,'technique'=>'پاستل',    'thumb'=>placeholder(80),'fullsize'=>placeholderFull(80)],
        ['id'=>9,  'title'=>'برف و سکوت',   'description'=>'زمستان بی‌صدا',         'year'=>2021,'technique'=>'آبرنگ',    'thumb'=>placeholder(90),'fullsize'=>placeholderFull(90)],
    ],
    3 => [
        ['id'=>10, 'title'=>'هستی',          'description'=>'جستجو در ناشناخته',    'year'=>2022,'technique'=>'آکریلیک',  'thumb'=>placeholder(11),'fullsize'=>placeholderFull(11)],
        ['id'=>11, 'title'=>'تناقض',         'description'=>'رنگ در برابر رنگ',     'year'=>2021,'technique'=>'رنگ روغن', 'thumb'=>placeholder(21),'fullsize'=>placeholderFull(21)],
        ['id'=>12, 'title'=>'تکانه',         'description'=>'حرکت بی‌پایان',        'year'=>2023,'technique'=>'آکریلیک',  'thumb'=>placeholder(31),'fullsize'=>placeholderFull(31)],
    ],
    4 => [
        ['id'=>13, 'title'=>'گلدان سفید',    'description'=>'آرامش در سادگی',       'year'=>2020,'technique'=>'رنگ روغن', 'thumb'=>placeholder(41),'fullsize'=>placeholderFull(41)],
        ['id'=>14, 'title'=>'میوه‌های پاییز','description'=>'رنگ‌های گرم فصل',      'year'=>2021,'technique'=>'آبرنگ',    'thumb'=>placeholder(51),'fullsize'=>placeholderFull(51)],
        ['id'=>15, 'title'=>'کتاب‌های قدیمی','description'=>'حافظه در کاغذ',        'year'=>2022,'technique'=>'پاستل',    'thumb'=>placeholder(61),'fullsize'=>placeholderFull(61)],
    ],
    5 => [
        ['id'=>16, 'title'=>'بازار قدیمی',   'description'=>'هیاهوی زندگی',         'year'=>2021,'technique'=>'آکریلیک',  'thumb'=>placeholder(71),'fullsize'=>placeholderFull(71)],
        ['id'=>17, 'title'=>'کوچه باران‌خورده','description'=>'بازتاب نور در آسفالت','year'=>2022,'technique'=>'رنگ روغن', 'thumb'=>placeholder(81),'fullsize'=>placeholderFull(81)],
    ],
    6 => [
        ['id'=>18, 'title'=>'نور و ایمان',   'description'=>'تابش روحانی',          'year'=>2020,'technique'=>'رنگ روغن', 'thumb'=>placeholder(91),'fullsize'=>placeholderFull(91)],
        ['id'=>19, 'title'=>'سجده',          'description'=>'خلوص در نیایش',        'year'=>2021,'technique'=>'آبرنگ',    'thumb'=>placeholder(12),'fullsize'=>placeholderFull(12)],
    ],
];

$action = $_GET['action'] ?? 'categories';
$use_db = false;

// ==========================================
// اتصال دیتابیس
// ==========================================
try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=$db_charset",
        $db_user, $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
    $use_db = true;
} catch (PDOException $e) {
    $use_db = false;
}

// ==========================================
// action=categories
// ==========================================
if ($action === 'categories') {
    if ($use_db) {
        $stmt = $pdo->query("
            SELECT c.id, c.name, c.icon, COUNT(p.id) as count
            FROM painting_categories c
            LEFT JOIN paintings p ON p.category_id = c.id
            GROUP BY c.id ORDER BY c.sort_order
        ");
        echo json_encode(['success'=>true,'data'=>$stmt->fetchAll()]);
    } else {
        echo json_encode(['success'=>true,'data'=>$test_categories,'test_mode'=>true]);
    }
}

// ==========================================
// action=paintings  (با صفحه‌بندی)
// ==========================================
elseif ($action === 'paintings') {
    $cat_id   = (int)($_GET['category_id'] ?? 0);
    $page     = max(1, (int)($_GET['page']     ?? 1));
    $per_page = max(1, min(50, (int)($_GET['per_page'] ?? 12)));
    $offset   = ($page - 1) * $per_page;

    if (!$cat_id) {
        echo json_encode(['success'=>false,'message'=>'شناسه دسته معتبر نیست']);
        exit;
    }

    if ($use_db) {
        $cnt = $pdo->prepare("SELECT COUNT(*) FROM paintings WHERE category_id=:c");
        $cnt->execute(['c'=>$cat_id]);
        $total = (int)$cnt->fetchColumn();

        $stmt = $pdo->prepare("
            SELECT id, title, description, year, technique, thumb, fullsize
            FROM paintings WHERE category_id=:c
            ORDER BY sort_order, id
            LIMIT :lim OFFSET :off
        ");
        $stmt->bindValue(':c',   $cat_id,   PDO::PARAM_INT);
        $stmt->bindValue(':lim', $per_page, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset,   PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode([
            'success'  => true,
            'data'     => $stmt->fetchAll(),
            'total'    => $total,
            'page'     => $page,
            'per_page' => $per_page,
            'has_more' => ($offset + $per_page) < $total,
        ]);
    } else {
        $all   = $test_paintings[$cat_id] ?? [];
        $total = count($all);
        echo json_encode([
            'success'   => true,
            'data'      => array_slice($all, $offset, $per_page),
            'total'     => $total,
            'page'      => $page,
            'per_page'  => $per_page,
            'has_more'  => ($offset + $per_page) < $total,
            'test_mode' => true,
        ]);
    }
}

else {
    echo json_encode(['success'=>false,'message'=>'عملیات نامعتبر']);
}