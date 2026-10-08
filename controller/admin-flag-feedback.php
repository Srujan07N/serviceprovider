<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['flag_feedback'])) {
    $feedback_id = $_POST['feedback_id'];

    $admin->cud("UPDATE `feedbacks` SET `is_flagged`=1 WHERE `feedback_id`='$feedback_id'");

    $_SESSION['success_message'] = "Feedback Flagged Successfully"; header("Location: ../admin/view-feedback.php"); exit;
    exit;
}
?>
