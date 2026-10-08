<?php
// Function to get page title based on filename
$page_title = 'Dashboard';
$current_page = basename($_SERVER['PHP_SELF']);
switch($current_page) {
    case 'manage-category.php': $page_title = 'Manage Categories'; break;
    case 'manage-vendors.php': $page_title = 'Manage Vendors'; break;
    case 'manage-users.php': $page_title = 'Manage Users'; break;
    case 'manage-payments.php': $page_title = 'Manage Payments'; break;
    case 'view-feedback.php': $page_title = 'Feedbacks'; break;
}
?>
<nav class="top-navbar">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><?php echo $page_title; ?></li>
            </ol>
        </nav>
        <h6 class="font-weight-bolder mb-0 page-title"><?php echo $page_title; ?></h6>
    </div>
    
    <div class="d-flex align-items-center">
        <ul class="navbar-nav justify-content-end d-flex flex-row gap-3">
            <li class="nav-item d-flex align-items-center">
                <a href="../controller/admin-logout.php" class="nav-link text-body font-weight-bold px-0">
                    <i class="fa fa-user me-sm-1"></i>
                    <span class="d-sm-inline d-none">Admin</span>
                </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>
