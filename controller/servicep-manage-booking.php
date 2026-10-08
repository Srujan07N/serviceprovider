<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['update_booking'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status']; 
    $rejection_reason = isset($_POST['rejection_reason']) ? $_POST['rejection_reason'] : '';

    if ($status == 'Rejected' && empty($rejection_reason)) {
        $_SESSION['error_message'] = "Rejection reason is mandatory"; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
        exit;
    }

    $admin->cud("UPDATE `bookings` SET `status`='$status', `rejection_reason`='$rejection_reason' WHERE `booking_id`='$booking_id'");

    $_SESSION['success_message'] = "Booking Status Updated Successfully"; header("Location: ../servicep/manage-bookings.php"); exit;
    exit;
}

if (isset($_POST['delete_booking'])) {
    $booking_id = $_POST['booking_id'];
    $admin->cud("DELETE FROM `payments` WHERE `booking_id`='$booking_id'");
    $admin->cud("DELETE FROM `bookings` WHERE `booking_id`='$booking_id'");
    $_SESSION['success_message'] = "Booking Record Physically Deleted"; header("Location: ../servicep/manage-bookings.php"); exit;
}
?>
