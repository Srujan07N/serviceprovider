<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password_raw = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : '';
    
    if (!isset($_POST['terms_agreement'])) {
        $_SESSION['error_message'] = "You must accept the Terms & Conditions"; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
        exit;
    }

    if ($password_raw !== $confirm_password) {
        $_SESSION['error_message'] = "Passwords do not match"; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
        exit;
    }

    $stmt = $admin->ret("SELECT * FROM `users` WHERE `email`='$email'");
    if ($stmt->rowCount() > 0) {
        $_SESSION['error_message'] = "Email already exists"; header("Location: ../register.php"); exit;
        exit;
    }

    $password = password_hash($password_raw, PASSWORD_BCRYPT);

    $admin->cud("INSERT INTO `users` (`full_name`, `email`, `phone_number`, `password`, `address`, `city`, `state`, `pincode`) VALUES ('$full_name', '$email', '$phone_number', '$password', '$address', '$city', '$state', '$pincode')", "");

    $_SESSION['success_message'] = "Registration Successful"; header("Location: ../login.php"); exit;
    exit;
}
?>
