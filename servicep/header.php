<?php
// Function to get page title based on filename
$page_title = 'DASHBOARD';
$current_page = basename($_SERVER['PHP_SELF']);
switch($current_page) {
    case 'manage-subcategory.php': $page_title = 'MANAGE SUB CATEGORIES'; break;
    case 'manage-package.php': $page_title = 'MANAGE PACKAGES'; break;
    case 'manage-bookings.php': $page_title = 'MANAGE BOOKINGS'; break;
    case 'view-feedback.php': $page_title = 'VIEW FEEDBACK'; break;
}
?>
<nav class="top-navbar">
    <div class="navbar-brand">
        <i class="fas fa-chevron-left text-muted me-2" style="font-size:0.9rem; cursor:pointer;" onclick="history.back()"></i>
        Paper Dashboard PRO React <span class="text-muted mx-2">|</span> <?php echo $page_title; ?>
    </div>
</nav>
