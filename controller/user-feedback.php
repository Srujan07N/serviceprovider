<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['submit_feedback'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "Please login"; header("Location: ../login.php"); exit;
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $booking_id = $_POST['booking_id'];
    
    $stmt = $admin->ret("SELECT `vendor_id`, `package_id` FROM `bookings` WHERE `booking_id`='$booking_id'");
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    $vendor_id = $booking['vendor_id'];
    $package_id = $booking['package_id'];

    $rating = $_POST['rating'];
    $review_title = $_POST['review_title'];
    $review_comment = $_POST['review_comment'];
    $is_anonymous = isset($_POST['anonymous']) ? 1 : 0;

    $images = '';
    if (isset($_FILES['images']['name']) && $_FILES['images']['name'][0] != '') {
        $target_dir = "../uploads/feedbacks/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $img_array = [];
        $total_files = count($_FILES['images']['name']);
        for($key = 0; $key < $total_files; $key++) {
            if ($_FILES['images']['name'][$key] != '') {
                $image_path = time() . '_' . basename($_FILES["images"]["name"][$key]);
                move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_dir . $image_path);
                $img_array[] = $image_path;
            }
        }
        $images = implode(',', $img_array);
    }

    $admin->cud("INSERT INTO `feedbacks` (`booking_id`, `user_id`, `vendor_id`, `package_id`, `rating`, `review_title`, `review_comment`, `images`, `is_anonymous`) VALUES ('$booking_id', '$user_id', '$vendor_id', '$package_id', '$rating', '$review_title', '$review_comment', '$images', '$is_anonymous')");

    $_SESSION['success_message'] = "Feedback submitted successfully!"; header("Location: ../my-bookings.php"); exit;
    exit;
}
?>
