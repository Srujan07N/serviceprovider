<?php
require_once '../config.php';
if(isset($_SESSION['vendor_id'])){ header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-btn { width: 100%; border-radius: 30px; padding: 10px; font-weight: 600; background-color: #51cbce; color: white; border: none; }
        .login-btn:hover { background-color: #40B1B4; }
    </style>
</head>
<body>
    <!-- Bootstrap Glass UI Alerts -->
    <?php include '../includes/alerts.php'; ?>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h3 class="text-center font-weight-light mb-4 text-dark" style="font-family: 'Montserrat', sans-serif;">Vendor Sign In</h3>
            <form action="../controller/servicep-login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required placeholder="vendor@gmail.com">
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" name="login" class="login-btn mb-3">Sign In</button>
                <div class="text-center">
                    <a href="register.php" class="text-muted text-decoration-none">Don't have an account? Register here.</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
