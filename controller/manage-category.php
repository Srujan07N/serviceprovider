<?php
require '../config.php';
$admin = new Admin();

if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_name)));
    $description = $_POST['description'];
    $status = $_POST['status'];
    $display_order = $_POST['display_order'];

    $category_image = '';
    if (isset($_FILES['category_image']['name']) && $_FILES['category_image']['name'] != '') {
        $target_dir = "../uploads/categories/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $category_image = time() . '_' . basename($_FILES["category_image"]["name"]);
        move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_dir . $category_image);
    }

    $admin->cud("INSERT INTO `categories` (`category_name`, `category_slug`, `category_image`, `description`, `status`, `display_order`) VALUES ('$category_name', '$category_slug', '$category_image', '$description', '$status', '$display_order')");

    $_SESSION['success_message'] = "Category Added Successfully"; header("Location: ../admin/manage-category.php"); exit;
    exit;
}

if (isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_name)));
    $description = $_POST['description'];
    $status = $_POST['status'];
    $display_order = $_POST['display_order'];

    $where_update = "`category_name`='$category_name', `category_slug`='$category_slug', `description`='$description', `status`='$status', `display_order`='$display_order'";

    if (isset($_FILES['category_image']['name']) && $_FILES['category_image']['name'] != '') {
        $target_dir = "../uploads/categories/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $category_image = time() . '_' . basename($_FILES["category_image"]["name"]);
        move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_dir . $category_image);
        $where_update .= ", `category_image`='$category_image'";
    }

    $admin->cud("UPDATE `categories` SET $where_update WHERE `category_id`='$category_id'");

    $_SESSION['success_message'] = "Category Updated Successfully"; header("Location: ../admin/manage-category.php"); exit;
    exit;
}

if (isset($_POST['delete_category'])) {
    $category_id = $_POST['category_id'];
    $admin->cud("DELETE FROM `categories` WHERE `category_id`='$category_id'");
    $_SESSION['success_message'] = "Category Deleted Successfully"; header("Location: ../admin/manage-category.php"); exit;
}
?>
