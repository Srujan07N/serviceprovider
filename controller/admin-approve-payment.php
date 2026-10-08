<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['approve_payment'])) {
    $booking_id = $_POST['booking_id'];
    $payment_id = $_POST['payment_id'];
    $action = $_POST['action']; // Approve or Reject

    if ($action == 'Approve') {
        $admin->cud("UPDATE `payments` SET `payment_status`='Accepted' WHERE `payment_id`='$payment_id'");
        
        $b_stmt = $admin->ret("SELECT `payment_status` FROM `bookings` WHERE `booking_id`='$booking_id'");
        $b_row = $b_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($b_row['payment_status'] == 'Advance Paid' || $b_row['payment_status'] == 'Fully Paid') {
            $new_p_status = 'Fully Paid';
            $success_msg = "Final Balance Payment Accepted";
        } else {
            $new_p_status = 'Advance Paid';
            $success_msg = "Advance Payment Accepted and Booking Confirmed";
        }

        $admin->cud("UPDATE `bookings` SET `status`='Confirmed', `payment_status`='$new_p_status' WHERE `booking_id`='$booking_id'", "");
        $_SESSION['success_message'] = $success_msg; header("Location: ../admin/manage-payments.php"); exit;
    } else {
        $admin->cud("UPDATE `payments` SET `payment_status`='Rejected' WHERE `payment_id`='$payment_id'");
        $admin->cud("UPDATE `bookings` SET `status`='Payment Pending', `payment_status`='Rejected' WHERE `booking_id`='$booking_id'");
        $_SESSION['success_message'] = "Payment Rejected"; header("Location: ../admin/manage-payments.php"); exit;
    }
    exit;
}
?>
