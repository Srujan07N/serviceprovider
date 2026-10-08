<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['update_user_status'])) {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    $admin->cud("UPDATE `users` SET `status`='$status' WHERE `user_id`='$user_id'");

    $_SESSION['success_message'] = "User Status Updated Successfully"; header("Location: ../admin/manage-users.php"); exit;
    exit;
}
?>
