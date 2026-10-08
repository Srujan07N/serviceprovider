<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['book_package'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "Please login to book a package"; header("Location: ../login.php"); exit;
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $vendor_id = $_POST['vendor_id'];
    $package_id = $_POST['package_id'];
    
    $event_type = $_POST['event_type'];
    $event_date = $_POST['event_date'];
    
    if (strtotime($event_date) < strtotime(date('Y-m-d'))) {
        $_SESSION['error_message'] = "You cannot select a past date."; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
        exit;
    }
    
    $check_stmt = $admin->ret("SELECT * FROM `bookings` WHERE `event_date`='$event_date' AND `vendor_id`='$vendor_id' AND `status` NOT IN ('Rejected', 'Cancelled')");
    if($check_stmt->rowCount() > 0) {
        $_SESSION['error_message'] = "This date is already booked. Please choose another date."; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
        exit;
    }

    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $number_of_guests = $_POST['number_of_guests'];
    $venue_address = $_POST['event_address'];
    $special_requirements = $_POST['special_requirements'];
    


    $reference_image = '';
    if (isset($_FILES['reference_image']['name']) && $_FILES['reference_image']['name'] != '') {
        $target_dir = "../uploads/bookings/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $reference_image = time() . '_' . basename($_FILES["reference_image"]["name"]);
        move_uploaded_file($_FILES["reference_image"]["tmp_name"], $target_dir . $reference_image);
    }

    $total_price = $_POST['total_price']; 

    $booking_id = $admin->Rcud("INSERT INTO `bookings` (`user_id`, `vendor_id`, `package_id`, `event_type`, `event_date`, `start_time`, `end_time`, `number_of_guests`, `venue_address`, `special_requirements`, `reference_image`, `total_price`) VALUES ('$user_id', '$vendor_id', '$package_id', '$event_type', '$event_date', '$start_time', '$end_time', '$number_of_guests', '$venue_address', '$special_requirements', '$reference_image', '$total_price')");

    $_SESSION['success_message'] = "Booking initiated! Waiting for vendor approval."; header("Location: ../my-bookings.php"); exit;
    exit;
}
?>
