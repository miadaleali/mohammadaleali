<?php
require_once 'config.php';
check_auth();
$db = get_db_connection();

// تمام منطق‌های PHP باید قبل از لود شدن layout_header اجرا شوند
$msg = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'approved') $msg = '<div class="alert alert-success">نظر با موفقیت تایید شد.</div>';
    if ($_GET['msg'] == 'replied') $msg = '<div class="alert alert-success">پاسخ شما با موفقیت ثبت شد.</div>';
    if ($_GET['msg'] == 'deleted') $msg = '<div class="alert alert-warning">نظر مورد نظر حذف شد.</div>';
}

// عملیات تایید نظر
if (isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    $stmt = $db->prepare("UPDATE comments SET status = 'approved' WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: comments.php?msg=approved");
    exit;
}

// عملیات ثبت پاسخ ادمین
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_text'])) {
    $id = (int)$_POST['comment_id'];
    $reply = $_POST['reply_text'];
    $stmt = $db->prepare("UPDATE comments SET reply = ?, status = 'approved' WHERE id = ?");
    $stmt->execute([$reply, $id]);
    header("Location: comments.php?msg=replied");
    exit;
}

// عملیات حذف نظر
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: comments.php?msg=deleted");
    exit;
}

// واکشی تمام نظرات (جدیدترین‌ها اول)
$comments = $db->query("SELECT * FROM comments ORDER BY id DESC")->fetchAll();

// حالا که تمام پردازش‌ها تمام شد، ظاهر صفحه را لود می‌کنیم
require_once 'layout_header.php';
?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">مدیریت نظرات</h1>
</div>

<?php echo $msg; ?>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="150">نام کاربر</th>
                    <th>متن نظر</th>
                    <th width="120">مربوط به</th>
                    <th width="120" class="text-center">وضعیت</th>
                    <th width="150" class="text-center">عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($comments as $c): ?>
                <tr>
                    <td class="fw-bold"><?php echo htmlspecialchars($c['author']); ?></td>
                    <td style="max-width: 400px;">
                        <div class="mb-1"><?php echo nl2br(htmlspecialchars($c['comment'])); ?></div>
                        <?php if(!empty($c['reply'])): ?>
                            <div class="p-2 mt-2 bg-light border-start border-4 border-primary rounded" style="font-size: 0.85rem;">
                                <i class="bi bi-reply-fill text-primary"></i> <strong>پاسخ شما:</strong><br>
                                <?php echo nl2br(htmlspecialchars($c['reply'])); ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            <?php echo $c['content_type'] == 'poem' ? 'شعر' : 'نقاشی'; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <?php if ($c['status'] == 'pending'): ?>
                            <span class="badge bg-danger">منتظر تایید</span>
                        <?php else: ?>
                            <span class="badge bg-success">تایید شده</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $c['id']; ?>" title="پاسخ">
                                <i class="bi bi-reply"></i>
                            </button>
                            <?php if ($c['status'] == 'pending'): ?>
                                <a href="?approve=<?php echo $c['id']; ?>" class="btn btn-sm btn-success" title="تایید نظر"><i class="bi bi-check-lg"></i></a>
                            <?php endif; ?>
                            <a href="?delete=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-danger" title="حذف نظر" onclick="return confirm('آیا از حذف این نظر مطمئن هستید؟')"><i class="bi bi-trash"></i></a>
                        </div>

                        <!-- Modal پاسخ -->
                        <div class="modal fade" id="replyModal<?php echo $c['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST">
                                        <div class="modal-header d-flex justify-content-between">
                                            <h5 class="modal-title">پاسخ به نظر <?php echo htmlspecialchars($c['author']); ?></h5>
                                            <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start" dir="rtl">
                                            <p class="mb-2"><strong>نظر کاربر:</strong></p>
                                            <p class="p-2 bg-light rounded shadow-sm"><?php echo nl2br(htmlspecialchars($c['comment'])); ?></p>
                                            <input type="hidden" name="comment_id" value="<?php echo $c['id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label">پاسخ شما:</label>
                                                <textarea name="reply_text" class="form-control" rows="4" required><?php echo htmlspecialchars($c['reply'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                            <button type="submit" class="btn btn-primary">ثبت پاسخ و تایید</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($comments)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">هیچ نظری یافت نشد.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'layout_footer.php'; ?>