<?php
require_once 'config.php';
check_auth();
$db = get_db_connection();

$msg = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'saved') $msg = '<div class="alert alert-success">شعر با موفقیت ذخیره شد.</div>';
    if ($_GET['msg'] == 'deleted') $msg = '<div class="alert alert-warning">شعر مورد نظر حذف شد.</div>';
}

// عملیات حذف
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM poems WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: poems.php?msg=deleted");
    exit;
}

// عملیات افزودن / ویرایش
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = (int)$_POST['category_id'];
    $poet = $_POST['poet'];
    $id = $_POST['id'] ?? null;

    if ($id) {
        $stmt = $db->prepare("UPDATE poems SET title = ?, content = ?, category_id = ?, poet = ? WHERE id = ?");
        $stmt->execute([$title, $content, $category_id, $poet, $id]);
    } else {
        $stmt = $db->prepare("INSERT INTO poems (title, content, category_id, poet) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $category_id, $poet]);
    }
    header("Location: poems.php?msg=saved");
    exit;
}

// واکشی لیست دسته‌ها با سلسله‌مراتب برای فرم
$categories = $db->query("
    SELECT c1.id, c1.name, c2.name as parent_name 
    FROM categories c1 
    LEFT JOIN categories c2 ON c1.parent_id = c2.id 
    ORDER BY COALESCE(c1.parent_id, c1.id), c1.parent_id IS NOT NULL, c1.name
")->fetchAll();

// واکشی اشعار با نام دسته و نام دسته مادر
$poems = $db->query("
    SELECT p.*, c.name as cat_name, pc.name as parent_cat_name 
    FROM poems p 
    LEFT JOIN categories c ON p.category_id = c.id 
    LEFT JOIN categories pc ON c.parent_id = pc.id
    ORDER BY p.id DESC
")->fetchAll();

$edit_poem = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM poems WHERE id = ?");
    $stmt->execute([$id]);
    $edit_poem = $stmt->fetch();
}

require_once 'layout_header.php';
?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">مدیریت اشعار</h1>
    <?php if (!$edit_poem): ?>
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#poemForm">
        <i class="bi bi-plus-lg me-1"></i> افزودن شعر جدید
    </button>
    <?php endif; ?>
</div>

<?php echo $msg; ?>

<!-- فرم افزودن/ویرایش -->
<div class="collapse <?php echo $edit_poem ? 'show' : ''; ?> mb-4" id="poemForm">
    <div class="card shadow-sm border-0 p-4">
        <h5 class="mb-4 text-primary"><?php echo $edit_poem ? 'ویرایش شعر' : 'افزودن شعر جدید'; ?></h5>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $edit_poem['id'] ?? ''; ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">عنوان شعر</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $edit_poem['title'] ?? ''; ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">دسته‌بندی</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">انتخاب کنید...</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo (isset($edit_poem['category_id']) && $edit_poem['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo $cat['parent_name'] ? ($cat['parent_name'] . ' > ' . $cat['name']) : $cat['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">نام شاعر</label>
                    <input type="text" name="poet" class="form-control" value="<?php echo $edit_poem['poet'] ?? ''; ?>" required>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label fw-bold">متن شعر</label>
                    <textarea name="content" class="form-control" rows="8" required><?php echo $edit_poem['content'] ?? ''; ?></textarea>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">ذخیره شعر</button>
                <a href="poems.php" class="btn btn-light">انصراف</a>
            </div>
        </form>
    </div>
</div>

<!-- لیست اشعار -->
<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>عنوان</th>
                    <th>شاعر</th>
                    <th>دسته</th>
                    <th width="150" class="text-center">عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($poems as $p): ?>
                <tr>
                    <td class="fw-bold"><?php echo $p['title']; ?></td>
                    <td><?php echo $p['poet']; ?></td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                            <?php echo $p['parent_cat_name'] ? ($p['parent_cat_name'] . ' ❯ ') : ''; ?>
                            <?php echo $p['cat_name'] ?? 'بدون دسته'; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="?edit=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <a href="?delete=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('آیا از حذف این شعر مطمئن هستید؟')"><i class="bi bi-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($poems)): ?>
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                        هیچ شعری یافت نشد.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'layout_footer.php'; ?>