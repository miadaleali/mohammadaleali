<?php require_once 'config.php'; check_auth(); ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>پنل مدیریت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <style>
        body { font-family: Vazirmatn, Tahoma, sans-serif; background: #f8f9fa; min-height: 100vh; margin: 0; }
        
        /* Spacing for icons */
        .sidebar .nav-link i, 
        .btn i, 
        .card-stats .text-end i { 
            margin-left: 12px !important; 
            margin-right: 0 !important;
            display: inline-block;
            vertical-align: middle;
        }
        
        /* Reset margin for stat icons to keep them centered */
        .stat-icon i {
            margin: 0 !important;
        }

        /* Fix Button Group Rounded Corners for RTL */
        .btn-group > .btn:first-child:not(:last-child):not(.dropdown-toggle) {
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
        .btn-group > .btn:last-child:not(:first-child), .btn-group > .dropdown-toggle:not(:first-child) {
            border-top-left-radius: 8px !important;
            border-bottom-left-radius: 8px !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        .btn-group > .btn:not(:first-child):not(:last-child):not(.dropdown-toggle) {
            border-radius: 0 !important;
        }
        
        .btn { border-radius: 8px; }

        /* Sidebar styles */
        .sidebar { 
            min-height: 100vh; 
            background: #1a1105; 
            color: #fff; 
            position: sticky; 
            top: 0; 
            z-index: 1050;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link { 
            color: rgba(255,255,255,0.7); 
            margin-bottom: 5px; 
            border-radius: 8px; 
            padding: 12px 15px; 
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active { 
            background: #dbab38; 
            color: #1a1105; 
        }

        /* Mobile specific styles */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                right: -280px;
                width: 280px;
                height: 100%;
                box-shadow: -5px 0 15px rgba(0,0,0,0.2);
            }
            .sidebar.show {
                right: 0;
            }
            .main-content {
                padding-top: 80px !important;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }

        .main-content { padding: 30px; }
        .card-stats { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .card-stats:hover { transform: translateY(-5px); }
        .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        
        /* Mobile Header */
        .mobile-header {
            background: #1a1105;
            color: #dbab38;
            padding: 15px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            display: none;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        @media (max-width: 767.98px) {
            .mobile-header { display: flex; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<header class="mobile-header">
    <h5 class="m-0" style="color: #dbab38;">مدیریت بابا</h5>
    <button class="btn btn-link text-white p-0 fs-2" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
</header>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar p-3 shadow" id="sidebarMenu">
            <div class="text-center mb-4 py-3 border-bottom border-secondary d-none d-md-block">
                <h5 class="m-0" style="color: #dbab38;">پنل مدیریت</h5>
            </div>
            <!-- Close button for mobile -->
            <div class="d-flex justify-content-between align-items-center d-md-none mb-4 pb-3 border-bottom border-secondary">
                <h5 class="m-0" style="color: #dbab38;">منو</h5>
                <button class="btn btn-link text-white p-0 fs-3" id="sidebarClose">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php"><i class="bi bi-speedometer2 me-2"></i> داشبورد</a></li>
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>" href="categories.php"><i class="bi bi-grid me-2"></i> دسته‌بندی‌ها</a></li>
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'poems.php' ? 'active' : ''; ?>" href="poems.php"><i class="bi bi-pen me-2"></i> اشعار</a></li>
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'paintings.php' ? 'active' : ''; ?>" href="paintings.php"><i class="bi bi-palette me-2"></i> نقاشی‌ها</a></li>
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'comments.php' ? 'active' : ''; ?>" href="comments.php"><i class="bi bi-chat-dots me-2"></i> نظرات</a></li>
                <li class="nav-item mt-4"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> خروج</a></li>
            </ul>
        </div>
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">