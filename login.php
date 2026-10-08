<?php
require_once 'config.php';
if(isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | ServiceHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { max-width: 450px; width: 100%; border-color: var(--accent-orange) !important; box-shadow: 0 0 30px var(--glow-orange); }
    </style>
</head>
<body>
    <!-- Bootstrap Glass UI Alerts -->
    <?php include 'includes/alerts.php'; ?>
    <div class="bg-pattern"></div>
    <div class="container auth-wrapper">
        <div class="glass-card auth-card text-center p-5">
            <a href="index.php" class="text-decoration-none d-inline-block mb-4">
                <i class="fa-solid fa-layer-group text-warning fs-1"></i>
            </a>
            <h3 class="text-white font-weight-bold mb-4">Welcome Back</h3>
            
            <form action="controller/user-login.php" method="POST" class="text-start">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="name@domain.com">
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <button type="submit" name="login" class="btn btn-primary-custom w-100 py-3 mb-4">Secure Sign In</button>
            </form>
            
            <p class="text-muted text-sm mb-0">Don't have an account? <a href="register.php" style="color:var(--accent-orange)" class="text-decoration-none">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
