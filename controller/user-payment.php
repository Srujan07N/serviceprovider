<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['submit_payment'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "Please login"; header("Location: ../login.php"); exit;
        exit;
    }

    $booking_id = $_POST['booking_id'];
    $user_id = $_SESSION['user_id'];
    $vendor_id = $_POST['vendor_id'];
    $amount = $_POST['amount'];
    
    $payment_method = $_POST['payment_method']; 
    $transaction_id = $_POST['transaction_id'];

    $payment_id = $admin->Rcud("INSERT INTO `payments` (`booking_id`, `user_id`, `vendor_id`, `card_holder_name`, `payment_method`, `transaction_id`, `amount`, `payment_status`, `billing_address`, `gst_number`) VALUES ('$booking_id', '$user_id', '$vendor_id', 'UPI Manual', '$payment_method', '$transaction_id', '$amount', 'Pending', '', '')");

    // Transition logic: If already Advance Paid, move to Pending Balance
    $admin->cud("UPDATE `bookings` SET `payment_status`=(CASE WHEN `payment_status`='Advance Paid' THEN 'Pending Balance' ELSE 'Pending' END) WHERE `booking_id`='$booking_id'");

    $_SESSION['success_message'] = "Payment logged successfully! Waiting for Vendor verification."; header("Location: ../my-bookings.php"); exit;
    exit;
}
?>
