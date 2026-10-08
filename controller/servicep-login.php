<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $admin->ret("SELECT * FROM `vendors` WHERE `email`='$email'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        if ($row['status'] == 'Approved') {
            $_SESSION['vendor_id'] = $row['vendor_id'];
            $_SESSION['business_name'] = $row['business_name'];

            $_SESSION['success_message'] = "Login Successful";
            header("Location: ../servicep/index.php");
            exit;
        } else {
            $status = $row['status'];
            $_SESSION['error_message'] = "Account status: $status. Please wait for approval or contact admin."; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Invalid Email or Password"; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
        exit;
    }
}
?>
