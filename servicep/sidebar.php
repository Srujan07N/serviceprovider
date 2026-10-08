<?php
$vendor_id = $_SESSION['vendor_id'];
$stmt = $admin->ret("SELECT * FROM `vendors` WHERE `vendor_id`='$vendor_id'");
$vendor_info = $stmt->fetch(PDO::FETCH_ASSOC);

$img = !empty($vendor_info['profile_image']) ? "../uploads/vendors/profiles/" . $vendor_info['profile_image'] : "https://ui-avatars.com/api/?name=".urlencode($vendor_info['business_name']);
?>
<aside class="sidebar">
    <div class="sidebar-logo">
        CREATIVE TIM
    </div>
    
    <div class="sidebar-user d-flex align-items-center">
        <img src="<?php echo $img; ?>" alt="Vendor" class="rounded-circle ms-1" width="40" height="40" style="object-fit:cover;">
        <div class="ms-3">
            <span class="d-block" style="font-size: 0.9rem; font-weight: 500; font-family: 'Montserrat', sans-serif;"><?php echo $vendor_info['business_name']; ?></span>
        </div>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="index.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-university"></i></div>
                <span>DASHBOARD</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="manage-subcategory.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-subcategory.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-layer-group"></i></div>
                <span>Sub Categories</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="manage-package.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-package.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-box-open"></i></div>
                <span>Manage Packages</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="manage-bookings.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-bookings.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-calendar-check"></i></div>
                <span>Manage Bookings</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="manage-payments.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-payments.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-money-bill-wave"></i></div>
                <span>Manage Payments</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="view-feedback.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'view-feedback.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-comment-dots"></i></div>
                <span>View Feedback</span>
            </a>
        </li>
        <li class="sidebar-item" style="margin-top: 50px;">
            <a href="../controller/servicep-logout.php" class="sidebar-link">
                <div class="icon-box"><i class="fas fa-sign-out-alt"></i></div>
                <span>LOGOUT</span>
            </a>
        </li>
    </ul>
</aside>
