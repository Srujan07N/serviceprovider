<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['register'])) {
    $business_name = $_POST['business_name'];
    $owner_name = $_POST['owner_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $business_address = $_POST['business_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $gst_number = $_POST['gst_number'];
    $pan_number = $_POST['pan_number'];
    $bank_account_details = $_POST['bank_account_details'];
    $upi_id = $_POST['upi_id'];
    $service_area = $_POST['service_area'];
    $experience_years = $_POST['experience_years'];

    if (!isset($_POST['terms_agreement'])) {
        $_SESSION['error_message'] = "You must accept the terms"; header("Location: " . $_SERVER['HTTP_REFERER']); exit;
        exit;
    }

    $stmt = $admin->ret("SELECT * FROM `vendors` WHERE `email`='$email'");
    if ($stmt->rowCount() > 0) {
        $_SESSION['error_message'] = "Email already exists"; header("Location: ../servicep/register.php"); exit;
        exit;
    }

    $license_upload = '';
    if (isset($_FILES['license_upload']['name']) && $_FILES['license_upload']['name'] != '') {
        $target_dir = "../uploads/vendors/licenses/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $license_upload = time() . '_' . basename($_FILES["license_upload"]["name"]);
        move_uploaded_file($_FILES["license_upload"]["tmp_name"], $target_dir . $license_upload);
    }

    $profile_image = '';
    if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
        $target_dir = "../uploads/vendors/profiles/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $profile_image = time() . '_' . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_dir . $profile_image);
    }

    $admin->cud("INSERT INTO `vendors` (`business_name`, `owner_name`, `email`, `phone_number`, `password`, `business_address`, `city`, `state`, `pincode`, `gst_number`, `pan_number`, `license_upload`, `profile_image`, `bank_account_details`, `upi_id`, `service_area`, `experience_years`) VALUES ('$business_name', '$owner_name', '$email', '$phone_number', '$password', '$business_address', '$city', '$state', '$pincode', '$gst_number', '$pan_number', '$license_upload', '$profile_image', '$bank_account_details', '$upi_id', '$service_area', '$experience_years')", "");

    $_SESSION['success_message'] = "Registration Successful! Wait for Admin Approval."; header("Location: ../servicep/login.php"); exit;
    exit;
}
?>
