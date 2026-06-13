<?php
require_once 'config.php';
check_auth();
$db = get_db_connection();

$msg = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'saved') $msg = '<div class="alert alert-success shadow-sm">نقاشی با موفقیت ذخیره شد.</div>';
    if ($_GET['msg'] == 'deleted') $msg = '<div class="alert alert-warning shadow-sm">نقاشی مورد نظر حذف شد.</div>';
}

// عملیات حذف
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM paintings WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: paintings.php?msg=deleted");
    exit;
}

// عملیات افزودن / ویرایش
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $technique = $_POST['technique'];
    $category_id = (int)$_POST['category_id'];
    $id = $_POST['id'] ?? null;
    $thumb = $_POST['current_thumb'] ?? '';
    $fullsize = $_POST['current_fullsize'] ?? '';

    function handleUpload($fileKey, $prefix) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === 0) {
            $ext = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
            $filename = $prefix . '_' . time() . '_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], '../assets/img/' . $filename)) {
                return 'assets/img/' . $filename;
            }
        }
        return null;
    }

    $newThumb = handleUpload('thumb', 'thumb');
    if ($newThumb) $thumb = $newThumb;

    $newFull = handleUpload('fullsize', 'full');
    if ($newFull) $fullsize = $newFull;

    if ($id) {
        $stmt = $db->prepare("UPDATE paintings SET title = ?, description = ?, year = ?, technique = ?, category_id = ?, thumb = ?, fullsize = ? WHERE id = ?");
        $stmt->execute([$title, $description, $year, $technique, $category_id, $thumb, $fullsize, $id]);
    } else {
        $stmt = $db->prepare("INSERT INTO paintings (title, description, year, technique, category_id, thumb, fullsize) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $year, $technique, $category_id, $thumb, $fullsize]);
    }
    header("Location: paintings.php?msg=saved");
    exit;
}

// واکشی لیست دسته‌ها با سلسله‌مراتب
$categories = $db->query("
    SELECT c1.id, c1.name, c2.name as parent_name 
    FROM painting_categories c1 
    LEFT JOIN painting_categories c2 ON c1.parent_id = c2.id 
    ORDER BY COALESCE(c1.parent_id, c1.id), c1.parent_id IS NOT NULL, c1.name
")->fetchAll();

// واکشی نقاشی‌ها با نام دسته و والد
$paintings = $db->query("
    SELECT p.*, c.name as cat_name, pc.name as parent_cat_name 
    FROM paintings p 
    LEFT JOIN painting_categories c ON p.category_id = c.id 
    LEFT JOIN painting_categories pc ON c.parent_id = pc.id
    ORDER BY p.id DESC
")->fetchAll();

$edit_p = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM paintings WHERE id = ?");
    $stmt->execute([$id]);
    $edit_p = $stmt->fetch();
}

require_once 'layout_header.php';
?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">مدیریت نقاشی‌ها</h1>
    <?php if (!$edit_p): ?>
    <button class="btn btn-warning shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#paintingForm">
        <i class="bi bi-plus-lg me-1"></i> افزودن نقاشی جدید
    </button>
    <?php endif; ?>
</div>

<?php echo $msg; ?>

<div class="collapse <?php echo $edit_p ? 'show' : ''; ?> mb-4" id="paintingForm">
    <div class="card shadow-sm border-0 p-4">
        <h5 class="mb-4 text-warning fw-bold"><?php echo $edit_p ? 'ویرایش اثر' : 'ثبت اثر جدید'; ?></h5>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $edit_p['id'] ?? ''; ?>">
            <input type="hidden" name="current_thumb" value="<?php echo $edit_p['thumb'] ?? ''; ?>">
            <input type="hidden" name="current_fullsize" value="<?php echo $edit_p['fullsize'] ?? ''; ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">عنوان اثر</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $edit_p['title'] ?? ''; ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">دسته بندی</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">انتخاب...</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo (isset($edit_p['category_id']) && $edit_p['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo $cat['parent_name'] ? ($cat['parent_name'] . ' > ' . $cat['name']) : $cat['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">سال خلق</label>
                    <input type="number" name="year" class="form-control" value="<?php echo $edit_p['year'] ?? ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">تکنیک</label>
                    <input type="text" name="technique" class="form-control" value="<?php echo $edit_p['technique'] ?? ''; ?>" placeholder="مثلا: رنگ روغن">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">تصویر اصلی</label>
                    <input type="file" name="fullsize" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">تصویر بندانگشتی (Thumb)</label>
                    <input type="file" name="thumb" class="form-control">
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label fw-bold">توضیحات کوتاه</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo $edit_p['description'] ?? ''; ?></textarea>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4 fw-bold">ذخیره اثر</button>
                <a href="paintings.php" class="btn btn-light">انصراف</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="100" class="text-center">پیش نمایش</th>
                    <th>عنوان اثر</th>
                    <th>تکنیک / سال</th>
                    <th>دسته</th>
                    <th width="150" class="text-center">عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($paintings as $p): ?>
                <tr>
                    <td class="text-center">
                        <?php if($p['thumb']): ?>
                            <img src="../<?php echo $p['thumb']; ?>" width="60" height="45" class="rounded object-fit-cover shadow-sm border">
                        <?php else: ?>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm border" style="width:60px; height:45px;"><i class="bi bi-image text-muted"></i></div>
                        <?php endif; ?>
                    </td>
                    <td class="fw-bold"><?php echo $p['title']; ?></td>
                    <td><small class="text-muted"><?php echo $p['technique'] ?: 'تکنیک نامشخص'; ?> <?php echo $p['year'] ? "($p[year])" : ''; ?></small></td>
                    <td>
                        <span class="badge bg-warning bg-opacity-10 text-dark px-3 py-2 border border-warning border-opacity-25">
                            <?php echo $p['parent_cat_name'] ? ($p['parent_cat_name'] . ' ❯ ') : ''; ?>
                            <?php echo $p['cat_name'] ?? 'بدون دسته'; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="?edit=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <a href="?delete=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('آیا از حذف این اثر مطمئن هستید؟')"><i class="bi bi-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($paintings)): ?>
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-palette fs-1 d-block mb-2"></i>
                        هیچ نقاشی‌ای ثبت نشده است.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'layout_footer.php'; ?>