<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['approve_payment'])) {
    $booking_id = $_POST['booking_id'];
    $payment_id = $_POST['payment_id'];
    $action = $_POST['action']; // Approve or Reject

    if ($action == 'Approve') {
        $admin->cud("UPDATE `payments` SET `payment_status`='Accepted' WHERE `payment_id`='$payment_id'", "");
        
        $b_stmt = $admin->ret("SELECT `payment_status` FROM `bookings` WHERE `booking_id`='$booking_id'");
        $b_row = $b_stmt->fetch(PDO::FETCH_ASSOC);
        
        // Flow Logic: If it's the second payment phase (Pending Balance or existing Advance Paid), mark it as Fully Paid
        if ($b_row['payment_status'] == 'Advance Paid' || $b_row['payment_status'] == 'Fully Paid' || $b_row['payment_status'] == 'Pending Balance') {
            $new_p_status = 'Fully Paid';
            $new_b_status = 'Advance Paid'; // Vendor must still manually perform Step 8
            $success_msg = "Final Balance Payment Accepted. Proceed to Bookings to Mark as Completed.";
        } else {
            $new_p_status = 'Advance Paid';
            $new_b_status = 'Advance Paid'; 
            $success_msg = "Advance Payment Accepted. Status updated to Advance Paid.";
        }

        $admin->cud("UPDATE `bookings` SET `status`='$new_b_status', `payment_status`='$new_p_status' WHERE `booking_id`='$booking_id'", "");
        $_SESSION['success_message'] = $success_msg; header("Location: ../servicep/manage-payments.php"); exit;
    } else {
        $admin->cud("UPDATE `payments` SET `payment_status`='Rejected' WHERE `payment_id`='$payment_id'", "");
        // If payment rejected, move back to Payment Pending so they can pay again
        $admin->cud("UPDATE `bookings` SET `status`='Payment Pending', `payment_status`='Rejected' WHERE `booking_id`='$booking_id'", "");
        $_SESSION['success_message'] = "Payment Rejected"; header("Location: ../servicep/manage-payments.php"); exit;
    }
    exit;
}

if (isset($_POST['delete_payment'])) {
    $payment_id = $_POST['payment_id'];
    $admin->cud("DELETE FROM `payments` WHERE `payment_id`='$payment_id'");
    $_SESSION['success_message'] = "Payment Transaction Record Deleted"; header("Location: ../servicep/manage-payments.php"); exit;
}
?>
