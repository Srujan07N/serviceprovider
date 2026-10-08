<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['add_subcategory'])) {
    $category_id = $_POST['category_id'];
    $sub_category_name = $_POST['sub_category_name'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $image = '';
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $target_dir = "../uploads/subcategories/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $image = time() . '_' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    $admin->cud("INSERT INTO `sub_categories` (`category_id`, `sub_category_name`, `description`, `image`, `status`) VALUES ('$category_id', '$sub_category_name', '$description', '$image', '$status')");

    $_SESSION['success_message'] = "Sub Category Added Successfully"; header("Location: ../servicep/manage-subcategory.php"); exit;
    exit;
}

if (isset($_POST['update_subcategory'])) {
    $sub_category_id = $_POST['sub_category_id'];
    $category_id = $_POST['category_id'];
    $sub_category_name = $_POST['sub_category_name'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $where_update = "`category_id`='$category_id', `sub_category_name`='$sub_category_name', `description`='$description', `status`='$status'";

    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $target_dir = "../uploads/subcategories/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $image = time() . '_' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
        $where_update .= ", `image`='$image'";
    }

    $admin->cud("UPDATE `sub_categories` SET $where_update WHERE `sub_category_id`='$sub_category_id'");

    $_SESSION['success_message'] = "Sub Category Updated Successfully"; header("Location: ../servicep/manage-subcategory.php"); exit;
    exit;
}

if (isset($_POST['delete_subcategory'])) {
    $sub_category_id = $_POST['sub_category_id'];
    $admin->cud("DELETE FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id'");
    $_SESSION['success_message'] = "Sub Category Deleted Successfully"; header("Location: ../servicep/manage-subcategory.php"); exit;
}
?>
