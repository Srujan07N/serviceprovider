<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $admin->ret("SELECT * FROM `users` WHERE `email`='$email'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        if ($row['status'] == 'Blocked') {
            $_SESSION['error_message'] = "Your account is blocked. Please contact admin."; header("Location: ../login.php"); exit;
            exit;
        }

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['full_name'] = $row['full_name'];
        $_SESSION['role'] = $row['role'];

        $_SESSION['success_message'] = "Login Successful";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Invalid Email or Password"; header("Location: ../login.php"); exit;
        exit;
    }
}
?>
