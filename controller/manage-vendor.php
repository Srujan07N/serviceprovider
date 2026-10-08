<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['update_vendor_status'])) {
    $vendor_id = $_POST['vendor_id'];
    $status = $_POST['status'];
    $rejection_reason = isset($_POST['rejection_reason']) ? $_POST['rejection_reason'] : '';

    if ($status == 'Rejected' && empty($rejection_reason)) {
        $_SESSION['error_message'] = "Rejection reason is mandatory"; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
        exit;
    }

    $admin->cud("UPDATE `vendors` SET `status`='$status', `rejection_reason`='$rejection_reason' WHERE `vendor_id`='$vendor_id'");

    $_SESSION['success_message'] = "Vendor Status Updated Successfully"; header("Location: ../admin/manage-vendors.php"); exit;
    exit;
}
?>
