<?php 
require_once 'layout_header.php'; 
$db = get_db_connection();

function getCount($db, $table) {
    if (!$db) return 0;
    try {
        return $db->query("SELECT COUNT(*) FROM $table")->fetchColumn();
    } catch (Exception $e) { return 0; }
}

$poemsCount = getCount($db, 'poems');
$paintingsCount = getCount($db, 'paintings');
$commentsCount = getCount($db, 'comments');
$categoriesCount = getCount($db, 'categories') + getCount($db, 'painting_categories');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">داشبورد مدیریت</h1>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card card-stats p-3" style="border-left-color: #0d6efd;">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-pen"></i>
                </div>
                <div class="ms-3 text-end w-100">
                    <p class="text-muted mb-0">کل اشعار</p>
                    <h3 class="mb-0"><?php echo $poemsCount; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-stats p-3" style="border-left-color: #dbab38;">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-palette"></i>
                </div>
                <div class="ms-3 text-end w-100">
                    <p class="text-muted mb-0">کل نقاشی‌ها</p>
                    <h3 class="mb-0"><?php echo $paintingsCount; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-stats p-3" style="border-left-color: #198754;">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div class="ms-3 text-end w-100">
                    <p class="text-muted mb-0">نظرات</p>
                    <h3 class="mb-0"><?php echo $commentsCount; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-stats p-3" style="border-left-color: #0dcaf0;">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-grid"></i>
                </div>
                <div class="ms-3 text-end w-100">
                    <p class="text-muted mb-0">کل دسته‌ها</p>
                    <h3 class="mb-0"><?php echo $categoriesCount; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 text-center">
            <h5 class="mb-3">دسترسی سریع</h5>
            <div class="d-flex justify-content-center gap-3">
                <a href="categories.php" class="btn btn-outline-dark"><i class="bi bi-plus-circle me-1"></i> دسته جدید</a>
                <a href="poems.php" class="btn btn-outline-dark"><i class="bi bi-plus-circle me-1"></i> شعر جدید</a>
                <a href="paintings.php" class="btn btn-outline-dark"><i class="bi bi-plus-circle me-1"></i> نقاشی جدید</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layout_footer.php'; ?>