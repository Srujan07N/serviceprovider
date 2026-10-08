<?php
require '../config.php';
$admin = new Admin();

if(isset($_GET['category_id'])){
    $cat_id = (int)$_GET['category_id'];
    $stmt = $admin->ret("SELECT * FROM `sub_categories` WHERE `category_id`='$cat_id' AND `status`='Active'");
    
    // Always provide the default placeholder
    echo '<option value="">Select Sub Category</option>';
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo '<option value="'.htmlspecialchars($row['sub_category_id']).'">'.htmlspecialchars($row['sub_category_name']).'</option>';
    }
}
?>
