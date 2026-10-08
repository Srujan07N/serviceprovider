<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $admin->ret("SELECT * FROM `admin` WHERE `email`='$email'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_name'] = $row['name'];


header("Location: ../admin/index.php");
exit();

        exit;
    } else {
        $_SESSION['error_message'] = "Invalid Email or Password"; header("Location: ../admin/login.php"); exit;
        exit;
    }
}
?>
