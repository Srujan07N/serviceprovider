<?php
// Session is started via config.php
require_once 'config.php';
$admin = new Admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiceHub | Connect with Experts</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Bootstrap Glass UI Alerts -->
    <?php include 'alerts.php'; ?>
    <div class="bg-pattern"></div>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fa-solid fa-layer-group"></i> ServiceProvider            </a>
            <button class="navbar-toggler btn-outline-light text-white border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'about.php') echo 'active'; ?>" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'category.php') echo 'active'; ?>" href="category.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'view-feedback.php') echo 'active'; ?>" href="view-feedback.php">Feedback</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="my-bookings.php" class="btn-login">Dashboard</a>
                        <a class="btn-primary-custom" href="controller/user-logout.php">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-login">Login</a>
                        <a class="btn-primary-custom" href="register.php">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
