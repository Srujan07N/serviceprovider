<?php
require_once 'config.php';
if(isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | ServiceHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 0; }
        .auth-card { max-width: 600px; width: 100%; border-color: var(--accent-orange) !important; box-shadow: 0 0 30px var(--glow-orange); }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>
    <div class="container auth-wrapper">
        <div class="glass-card auth-card p-5">
            <div class="text-center mb-4">
                <a href="index.php" class="text-decoration-none d-inline-block mb-3">
                    <i class="fa-solid fa-layer-group text-warning fs-2"></i>
                </a>
                <h3 class="text-white font-weight-bold">Create Account</h3>
                <p class="text-muted text-sm">Join ServiceHub to book services and track real-time tasks.</p>
            </div>
            
            <form action="controller/user-register.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Full Legal Name</label>
                        <input type="text" name="full_name" class="form-control" required placeholder="John Doe">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required placeholder="john@example.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone_number" class="form-control" required placeholder="1234567890" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="Please enter exactly 10 digits">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="••••••••">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required placeholder="••••••••">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" required placeholder="123 Main St, City, Country"></textarea>
                    </div>
                    <div class="col-12 mb-4 form-check ms-3">
                        <input type="checkbox" name="terms_agreement" class="form-check-input" required id="terms" style="border-color:var(--accent-orange); cursor:pointer;">
                        <label class="form-check-label text-muted text-sm" for="terms" style="cursor:pointer;" >I agree to the <a href="#" style="color:var(--accent-orange)">Terms & Conditions</a></label>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary-custom w-100 py-3 mb-4">Register Now</button>
            </form>
            
            <p class="text-center text-muted text-sm mb-0">Already registered? <a href="login.php" style="color:var(--accent-orange)" class="text-decoration-none">Return to Login</a></p>
        </div>
    </div>
</body>
</html>
