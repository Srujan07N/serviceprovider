<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['add_package'])) {
    $vendor_id = $_SESSION['vendor_id']; 
    $category_id = $_POST['category_id'];
    $sub_category_id = $_POST['sub_category_id'];
    $package_name = $_POST['package_name'];
    $price = $_POST['price'];
    $discount_price = empty($_POST['discount_price']) ? 'NULL' : $_POST['discount_price'];
    $description = $_POST['description'];
    $inclusions = $_POST['inclusions'];
    $exclusions = $_POST['exclusions'];
    $max_capacity = $_POST['max_capacity'];
    $service_duration = $_POST['service_duration'];
    $available_days = is_array($_POST['available_days']) ? implode(',', $_POST['available_days']) : $_POST['available_days'];
    $blackout_dates = $_POST['blackout_dates'];
    $cancellation_policy = $_POST['cancellation_policy'];
    $refund_policy = $_POST['refund_policy'];
    $status = $_POST['status'];

    $package_id = $admin->Rcud("INSERT INTO `packages` (`vendor_id`, `category_id`, `sub_category_id`, `package_name`, `price`, `discount_price`, `description`, `inclusions`, `exclusions`, `max_capacity`, `service_duration`, `available_days`, `blackout_dates`, `cancellation_policy`, `refund_policy`, `status`) VALUES ('$vendor_id', '$category_id', '$sub_category_id', '$package_name', '$price', $discount_price, '$description', '$inclusions', '$exclusions', '$max_capacity', '$service_duration', '$available_days', '$blackout_dates', '$cancellation_policy', '$refund_policy', '$status')");

    if (isset($_FILES['images']['name']) && $_FILES['images']['name'][0] != '') {
        $target_dir = "../uploads/packages/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $total_files = count($_FILES['images']['name']);
        for($key = 0; $key < $total_files; $key++) {
            if ($_FILES['images']['name'][$key] != '') {
                $image_path = time() . '_' . basename($_FILES["images"]["name"][$key]);
                move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_dir . $image_path);
                $admin->cud("INSERT INTO `package_images` (`package_id`, `image_path`) VALUES ('$package_id', '$image_path')");
            }
        }
    }

    $_SESSION['success_message'] = "Package Added Successfully"; header("Location: ../servicep/manage-package.php"); exit;
    exit;
}

if (isset($_POST['update_package'])) {
    $package_id = $_POST['package_id'];
    $category_id = $_POST['category_id'];
    $sub_category_id = $_POST['sub_category_id'];
    $package_name = $_POST['package_name'];
    $price = $_POST['price'];
    $discount_price = empty($_POST['discount_price']) ? 'NULL' : $_POST['discount_price'];
    $description = $_POST['description'];
    $inclusions = $_POST['inclusions'];
    $exclusions = $_POST['exclusions'];
    $max_capacity = $_POST['max_capacity'];
    $service_duration = $_POST['service_duration'];
    $available_days = is_array($_POST['available_days']) ? implode(',', $_POST['available_days']) : $_POST['available_days'];
    $blackout_dates = $_POST['blackout_dates'];
    $cancellation_policy = $_POST['cancellation_policy'];
    $refund_policy = $_POST['refund_policy'];
    $status = $_POST['status'];

    $admin->cud("UPDATE `packages` SET `category_id`='$category_id', `sub_category_id`='$sub_category_id', `package_name`='$package_name', `price`='$price', `discount_price`=$discount_price, `description`='$description', `inclusions`='$inclusions', `exclusions`='$exclusions', `max_capacity`='$max_capacity', `service_duration`='$service_duration', `available_days`='$available_days', `blackout_dates`='$blackout_dates', `cancellation_policy`='$cancellation_policy', `refund_policy`='$refund_policy', `status`='$status' WHERE `package_id`='$package_id'");

    if (isset($_FILES['images']['name']) && $_FILES['images']['name'][0] != '') {
        $target_dir = "../uploads/packages/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $total_files = count($_FILES['images']['name']);
        for($key = 0; $key < $total_files; $key++) {
            if ($_FILES['images']['name'][$key] != '') {
                $image_path = time() . '_' . basename($_FILES["images"]["name"][$key]);
                move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_dir . $image_path);
                $admin->cud("INSERT INTO `package_images` (`package_id`, `image_path`) VALUES ('$package_id', '$image_path')");
            }
        }
    }

    $_SESSION['success_message'] = "Package Updated Successfully"; header("Location: ../servicep/manage-package.php"); exit;
}

if (isset($_POST['delete_package'])) {
    $package_id = $_POST['package_id'];
    $admin->cud("DELETE FROM `packages` WHERE `package_id`='$package_id'");
    $_SESSION['success_message'] = "Package Deleted Successfully"; header("Location: ../servicep/manage-package.php"); exit;
}
?>
