<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'admin/config.php';
$db = get_db_connection();

if (!$db) {
    echo json_encode(['success' => false, 'message' => 'Database connection error']);
    exit;
}

$action = $_GET['action'] ?? '';

// ثبت نظر جدید
if ($action === 'send') {
    $author = $_POST['author'] ?? 'ناشناس';
    $comment = $_POST['comment'] ?? '';
    $type = $_POST['type'] ?? ''; // poem or painting
    $content_id = (int)($_POST['content_id'] ?? 0);

    if (empty($comment) || empty($type) || !$content_id) {
        echo json_encode(['success' => false, 'message' => 'اطلاعات ناقص است']);
        exit;
    }

    try {
        $stmt = $db->prepare("INSERT INTO comments (author, comment, content_type, content_id, status) VALUES (?, ?, ?, ?, 'pending')");
        $success = $stmt->execute([$author, $comment, $type, $content_id]);
        echo json_encode(['success' => $success, 'message' => $success ? 'نظر شما ثبت شد و پس از تایید نمایش داده می‌شود.' : 'خطا در ثبت نظر']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطا در دیتابیس: ' . $e->getMessage()]);
    }
}

// دریافت نظرات یک اثر
elseif ($action === 'list') {
    $type = $_GET['type'] ?? '';
    $content_id = (int)($_GET['content_id'] ?? 0);

    if (empty($type) || !$content_id) {
        echo json_encode(['success' => false, 'data' => []]);
        exit;
    }

    $stmt = $db->prepare("SELECT author, comment, reply, created_at FROM comments WHERE content_type = ? AND content_id = ? AND status = 'approved' ORDER BY id ASC");
    $stmt->execute([$type, $content_id]);
    $comments = $stmt->fetchAll();

    echo json_encode(['success' => true, 'data' => $comments]);
}
?>