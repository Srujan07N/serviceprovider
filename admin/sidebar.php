<aside class="sidebar">
    <div class="sidebar-logo">
        <i class="fas fa-layer-group text-dark"></i>
        <span>Creative Admin</span>
    </div>
    
    <div class="sidebar-user d-flex align-items-center mb-4 px-2" style="background: #f8f9fa; border-radius: 8px; padding: 10px;">
        <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin" class="rounded-circle" width="40" height="40">
        <div class="ms-3">
            <h6 class="mb-0" style="font-size: 0.875rem; font-weight: 600;">Admin Panel</h6>
        </div>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="index.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-chart-line"></i></div>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item mt-3">
            <h6 class="ps-3 ms-2 text-uppercase text-xs font-weight-bolder opacity-6" style="font-size:0.75rem; color:#67748e;">Pages</h6>
        </li>
        <li class="sidebar-item">
            <a href="manage-category.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-category.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-tags"></i></div>
                <span>Manage Category</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="manage-vendors.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-vendors.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-store"></i></div>
                <span>Manage Vendors</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="manage-users.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-users.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-users"></i></div>
                <span>Manage Users</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="manage-payments.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage-payments.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-credit-card"></i></div>
                <span>Payments & Bookings</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="view-feedback.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'view-feedback.php' ? 'active' : ''; ?>">
                <div class="icon-box"><i class="fas fa-star"></i></div>
                <span>View Feedback</span>
            </a>
        </li>
        <li class="sidebar-item mt-3">
            <h6 class="ps-3 ms-2 text-uppercase text-xs font-weight-bolder opacity-6" style="font-size:0.75rem; color:#67748e;">Account</h6>
        </li>
        <li class="sidebar-item">
            <a href="../controller/admin-logout.php" class="sidebar-link text-danger">
                <div class="icon-box"><i class="fas fa-sign-out-alt"></i></div>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>
