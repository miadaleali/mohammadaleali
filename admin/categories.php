<?php
require_once 'config.php';
check_auth();
$db = get_db_connection();

$type = $_GET['type'] ?? 'poem'; // poem or painting
$table = ($type === 'poem') ? 'categories' : 'painting_categories';

$msg = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'saved') $msg = '<div class="alert alert-success shadow-sm">تغییرات با موفقیت ذخیره شد.</div>';
    if ($_GET['msg'] == 'deleted') $msg = '<div class="alert alert-warning shadow-sm">دسته مورد نظر حذف شد.</div>';
}

// عملیات حذف
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: categories.php?type=$type&msg=deleted");
    exit;
}

// عملیات افزودن / ویرایش
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
    $id = $_POST['id'] ?? null;
    $icon = $_POST['current_icon'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'cat_' . time() . '.' . $ext;
        $target = '../assets/img/' . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $icon = 'assets/img/' . $filename;
        }
    }

    if ($id) {
        $stmt = $db->prepare("UPDATE $table SET name = ?, parent_id = ?, icon = ? WHERE id = ?");
        $stmt->execute([$name, $parent_id, $icon, $id]);
    } else {
        $stmt = $db->prepare("INSERT INTO $table (name, parent_id, icon) VALUES (?, ?, ?)");
        $stmt->execute([$name, $parent_id, $icon]);
    }
    header("Location: categories.php?type=$type&msg=saved");
    exit;
}

// واکشی لیست دسته‌ها با نام دسته مادر
try {
    $categories = $db->query("
        SELECT c1.*, c2.name as parent_name 
        FROM $table c1 
        LEFT JOIN $table c2 ON c1.parent_id = c2.id 
        ORDER BY COALESCE(c1.parent_id, c1.id), c1.parent_id IS NOT NULL, c1.id
    ")->fetchAll();
} catch (PDOException $e) {
    // اگر ستون parent_id پیدا نشد
    if ($e->getCode() == '42S22') {
        die("<div style='padding:20px; border:2px solid red; font-family:Tahoma; direction:rtl;'>
            <h3 style='color:red;'>خطا: ساختار دیتابیس قدیمی است!</h3>
            <p>لطفاً برای اضافه شدن قابلیت 'زیردسته'، فایل روبرو را در مرورگر اجرا کنید: 
            <a href='../update_db_v2.php' style='font-weight:bold;'>اجرای آپدیت دیتابیس</a></p>
            <p>پس از اجرا، این صفحه را رفرش کنید.</p>
        </div>");
    }
    throw $e;
}

// لیست دسته‌های مادر (فقط سطح ۱) برای نمایش در منوی انتخاب
$parent_categories = $db->query("SELECT id, name FROM $table WHERE parent_id IS NULL ORDER BY name ASC")->fetchAll();

$edit_cat = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    $edit_cat = $stmt->fetch();
}

require_once 'layout_header.php';
?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">مدیریت دسته‌بندی‌ها</h1>
    <div class="btn-group shadow-sm">
        <a href="?type=poem" class="btn btn-<?php echo $type == 'poem' ? 'dark' : 'outline-dark'; ?>">دسته‌های شعر</a>
        <a href="?type=painting" class="btn btn-<?php echo $type == 'painting' ? 'dark' : 'outline-dark'; ?>">دسته‌های نقاشی</a>
    </div>
</div>

<?php echo $msg; ?>

<div class="row g-4">
    <!-- فرم افزودن/ویرایش -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 p-4 mb-4 position-sticky" style="top: 100px;">
            <h5 class="mb-4 text-primary">
                <i class="bi <?php echo $edit_cat ? 'bi-pencil-square' : 'bi-plus-circle-fill'; ?> me-2"></i>
                <?php echo $edit_cat ? 'ویرایش دسته' : 'افزودن دسته جدید'; ?>
            </h5>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $edit_cat['id'] ?? ''; ?>">
                <input type="hidden" name="current_icon" value="<?php echo $edit_cat['icon'] ?? ''; ?>">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">نام دسته</label>
                    <input type="text" name="name" class="form-control form-control-lg" value="<?php echo $edit_cat['name'] ?? ''; ?>" required placeholder="مثلاً: غزلیات">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">دسته مادر (سطح ۱)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- بدون دسته مادر (خودش اصلی باشد) --</option>
                        <?php foreach($parent_categories as $pcat): ?>
                            <?php if(isset($edit_cat['id']) && $edit_cat['id'] == $pcat['id']) continue; // جلوگیری از انتخاب خود به عنوان مادر ?>
                            <option value="<?php echo $pcat['id']; ?>" <?php echo (isset($edit_cat['parent_id']) && $edit_cat['parent_id'] == $pcat['id']) ? 'selected' : ''; ?>>
                                <?php echo $pcat['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">اگر این دسته، زیرمجموعه دسته دیگری است، آن را انتخاب کنید.</small>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">تصویر / آیکون</label>
                    <?php if (isset($edit_cat['icon']) && strpos($edit_cat['icon'], 'assets') !== false): ?>
                        <div class="mb-2">
                            <img src="../<?php echo $edit_cat['icon']; ?>" width="80" class="rounded border shadow-sm">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control">
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check2-all me-2"></i>ذخیره دسته
                    </button>
                    <?php if ($edit_cat): ?>
                        <a href="categories.php?type=<?php echo $type; ?>" class="btn btn-light">انصراف</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- لیست دسته‌ها -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="80" class="text-center">تصویر</th>
                            <th>نام دسته‌بندی</th>
                            <th>دسته مادر</th>
                            <th width="150" class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $cat): ?>
                        <tr class="<?php echo $cat['parent_id'] ? 'bg-light bg-opacity-50' : 'fw-bold'; ?>">
                            <td class="text-center">
                                <?php if (strpos($cat['icon'], 'assets') !== false): ?>
                                    <img src="../<?php echo $cat['icon']; ?>" width="40" height="40" class="rounded-circle object-fit-cover border">
                                <?php else: ?>
                                    <span class="fs-4"><?php echo $cat['icon']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($cat['parent_id']): ?>
                                    <span class="text-muted me-2">—</span>
                                <?php endif; ?>
                                <?php echo $cat['name']; ?>
                            </td>
                            <td>
                                <?php if($cat['parent_name']): ?>
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2"><?php echo $cat['parent_name']; ?></span>
                                <?php else: ?>
                                    <span class="text-muted small">دسته اصلی</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="?type=<?php echo $type; ?>&edit=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-primary" title="ویرایش"><i class="bi bi-pencil"></i></a>
                                    <a href="?type=<?php echo $type; ?>&delete=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-danger" title="حذف" onclick="return confirm('آیا از حذف این دسته مطمئن هستید؟')"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                هیچ دسته‌ای در این بخش یافت نشد.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layout_footer.php'; ?>