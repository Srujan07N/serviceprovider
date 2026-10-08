<?php
require_once '../config.php';
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Service Provider</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-gray-100">
    <div class="auth-wrapper">
        <div class="position-absolute top-0 start-0 w-100" style="height: 40vh; background: linear-gradient(135deg, #344767 0%, #1a233a 100%);"></div>
        <div class="container d-flex justify-content-center">
            <div class="card auth-card p-4">
                <div class="text-center mb-4">
                    <h3 class="font-weight-bolder text-dark mb-1">Admin Login</h3>
                    <p class="text-muted text-sm">Enter your email and password to sign in</p>
                </div>
                <form action="../controller/admin-login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required placeholder="admin@gmail.com">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required placeholder="••••••••">
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="login" class="btn btn-primary-custom w-100 mb-2">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
