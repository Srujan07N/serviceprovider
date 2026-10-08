<?php
$dir = __DIR__ . '/controller/';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$files = [

    'admin-logout.php' => <<<PHP
<?php
require '../config.php';
unset(\$_SESSION['admin_id']);
unset(\$_SESSION['admin_name']);
echo "<script>window.location.href='../admin/login.php';</script>";
exit;
?>
PHP,

    'manage-category.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['add_category'])) {
    \$category_name = \$_POST['category_name'];
    \$category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', \$category_name)));
    \$description = \$_POST['description'];
    \$status = \$_POST['status'];
    \$display_order = \$_POST['display_order'];
    \$meta_title = \$_POST['meta_title'];
    \$meta_description = \$_POST['meta_description'];

    \$category_image = '';
    if (isset(\$_FILES['category_image']['name']) && \$_FILES['category_image']['name'] != '') {
        \$target_dir = "../uploads/categories/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$category_image = time() . '_' . basename(\$_FILES["category_image"]["name"]);
        move_uploaded_file(\$_FILES["category_image"]["tmp_name"], \$target_dir . \$category_image);
    }

    \$admin->cud("INSERT INTO `categories` (`category_name`, `category_slug`, `category_image`, `description`, `status`, `display_order`, `meta_title`, `meta_description`) VALUES ('\$category_name', '\$category_slug', '\$category_image', '\$description', '\$status', '\$display_order', '\$meta_title', '\$meta_description')");

    echo "<script>alert('Category Added Successfully'); window.location.href='../admin/manage-category.php';</script>";
    exit;
}

if (isset(\$_POST['update_category'])) {
    \$category_id = \$_POST['category_id'];
    \$category_name = \$_POST['category_name'];
    \$category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', \$category_name)));
    \$description = \$_POST['description'];
    \$status = \$_POST['status'];
    \$display_order = \$_POST['display_order'];
    \$meta_title = \$_POST['meta_title'];
    \$meta_description = \$_POST['meta_description'];

    \$where_update = "`category_name`='\$category_name', `category_slug`='\$category_slug', `description`='\$description', `status`='\$status', `display_order`='\$display_order', `meta_title`='\$meta_title', `meta_description`='\$meta_description'";

    if (isset(\$_FILES['category_image']['name']) && \$_FILES['category_image']['name'] != '') {
        \$target_dir = "../uploads/categories/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$category_image = time() . '_' . basename(\$_FILES["category_image"]["name"]);
        move_uploaded_file(\$_FILES["category_image"]["tmp_name"], \$target_dir . \$category_image);
        \$where_update .= ", `category_image`='\$category_image'";
    }

    \$admin->cud("UPDATE `categories` SET \$where_update WHERE `category_id`='\$category_id'");

    echo "<script>alert('Category Updated Successfully'); window.location.href='../admin/manage-category.php';</script>";
    exit;
}
?>
PHP,

    'manage-vendor.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['update_vendor_status'])) {
    \$vendor_id = \$_POST['vendor_id'];
    \$status = \$_POST['status'];
    \$rejection_reason = isset(\$_POST['rejection_reason']) ? \$_POST['rejection_reason'] : '';

    if (\$status == 'Rejected' && empty(\$rejection_reason)) {
        echo "<script>alert('Rejection reason is mandatory'); window.history.back();</script>";
        exit;
    }

    \$admin->cud("UPDATE `vendors` SET `status`='\$status', `rejection_reason`='\$rejection_reason' WHERE `vendor_id`='\$vendor_id'");

    echo "<script>alert('Vendor Status Updated Successfully'); window.location.href='../admin/manage-vendors.php';</script>";
    exit;
}
?>
PHP,

    'admin-approve-payment.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['approve_payment'])) {
    \$booking_id = \$_POST['booking_id'];
    \$payment_id = \$_POST['payment_id'];
    \$action = \$_POST['action']; // Approve or Reject

    if (\$action == 'Approve') {
        \$admin->cud("UPDATE `payments` SET `payment_status`='Completed' WHERE `payment_id`='\$payment_id'");
        \$admin->cud("UPDATE `bookings` SET `status`='Confirmed', `payment_status`='Completed' WHERE `booking_id`='\$booking_id'");
        echo "<script>alert('Payment Approved and Booking Confirmed'); window.location.href='../admin/manage-payments.php';</script>";
    } else {
        \$admin->cud("UPDATE `payments` SET `payment_status`='Failed' WHERE `payment_id`='\$payment_id'");
        \$admin->cud("UPDATE `bookings` SET `status`='Payment Pending', `payment_status`='Failed' WHERE `booking_id`='\$booking_id'");
        echo "<script>alert('Payment Rejected'); window.location.href='../admin/manage-payments.php';</script>";
    }
    exit;
}
?>
PHP,

    'admin-manage-users.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['update_user_status'])) {
    \$user_id = \$_POST['user_id'];
    \$status = \$_POST['status'];

    \$admin->cud("UPDATE `users` SET `status`='\$status' WHERE `user_id`='\$user_id'");

    echo "<script>alert('User Status Updated Successfully'); window.location.href='../admin/manage-users.php';</script>";
    exit;
}
?>
PHP,

    'admin-flag-feedback.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['flag_feedback'])) {
    \$feedback_id = \$_POST['feedback_id'];

    \$admin->cud("UPDATE `feedbacks` SET `is_flagged`=1 WHERE `feedback_id`='\$feedback_id'");

    echo "<script>alert('Feedback Flagged Successfully'); window.location.href='../admin/view-feedback.php';</script>";
    exit;
}
?>
PHP,

    'servicep-register.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['register'])) {
    \$business_name = \$_POST['business_name'];
    \$owner_name = \$_POST['owner_name'];
    \$email = \$_POST['email'];
    \$phone_number = \$_POST['phone_number'];
    \$password = password_hash(\$_POST['password'], PASSWORD_BCRYPT);
    \$business_address = \$_POST['business_address'];
    \$city = \$_POST['city'];
    \$state = \$_POST['state'];
    \$pincode = \$_POST['pincode'];
    \$gst_number = \$_POST['gst_number'];
    \$pan_number = \$_POST['pan_number'];
    \$bank_account_details = \$_POST['bank_account_details'];
    \$upi_id = \$_POST['upi_id'];
    \$service_area = \$_POST['service_area'];
    \$experience_years = \$_POST['experience_years'];

    if (!isset(\$_POST['terms_agreement'])) {
        echo "<script>alert('You must accept the terms'); window.location.href='../servicep/register.php';</script>";
        exit;
    }

    \$stmt = \$admin->ret("SELECT * FROM `vendors` WHERE `email`='\$email'");
    if (\$stmt->rowCount() > 0) {
        echo "<script>alert('Email already exists'); window.location.href='../servicep/register.php';</script>";
        exit;
    }

    \$license_upload = '';
    if (isset(\$_FILES['license_upload']['name']) && \$_FILES['license_upload']['name'] != '') {
        \$target_dir = "../uploads/vendors/licenses/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$license_upload = time() . '_' . basename(\$_FILES["license_upload"]["name"]);
        move_uploaded_file(\$_FILES["license_upload"]["tmp_name"], \$target_dir . \$license_upload);
    }

    \$profile_image = '';
    if (isset(\$_FILES['profile_image']['name']) && \$_FILES['profile_image']['name'] != '') {
        \$target_dir = "../uploads/vendors/profiles/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$profile_image = time() . '_' . basename(\$_FILES["profile_image"]["name"]);
        move_uploaded_file(\$_FILES["profile_image"]["tmp_name"], \$target_dir . \$profile_image);
    }

    \$admin->cud("INSERT INTO `vendors` (`business_name`, `owner_name`, `email`, `phone_number`, `password`, `business_address`, `city`, `state`, `pincode`, `gst_number`, `pan_number`, `license_upload`, `profile_image`, `bank_account_details`, `upi_id`, `service_area`, `experience_years`) VALUES ('\$business_name', '\$owner_name', '\$email', '\$phone_number', '\$password', '\$business_address', '\$city', '\$state', '\$pincode', '\$gst_number', '\$pan_number', '\$license_upload', '\$profile_image', '\$bank_account_details', '\$upi_id', '\$service_area', '\$experience_years')");

    echo "<script>alert('Registration Successful! Wait for Admin Approval.'); window.location.href='../servicep/login.php';</script>";
    exit;
}
?>
PHP,

    'servicep-login.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['login'])) {
    \$email = \$_POST['email'];
    \$password = \$_POST['password'];

    \$stmt = \$admin->ret("SELECT * FROM `vendors` WHERE `email`='\$email'");
    \$row = \$stmt->fetch(PDO::FETCH_ASSOC);

    if (\$row && password_verify(\$password, \$row['password'])) {
        if (\$row['status'] == 'Approved') {
            \$_SESSION['vendor_id'] = \$row['vendor_id'];
            \$_SESSION['business_name'] = \$row['business_name'];

            echo "<script>
                alert('Login Successful');
                window.location.href='../servicep/index.php';
            </script>";
            exit;
        } else {
            \$status = \$row['status'];
            echo "<script>alert('Account status: \$status. Please wait for approval or contact admin.'); window.location.href='../servicep/login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid Email or Password'); window.location.href='../servicep/login.php';</script>";
        exit;
    }
}
?>
PHP,

    'servicep-logout.php' => <<<PHP
<?php
require '../config.php';
unset(\$_SESSION['vendor_id']);
unset(\$_SESSION['business_name']);
echo "<script>window.location.href='../servicep/login.php';</script>";
exit;
?>
PHP,

    'manage-subcategory.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['add_subcategory'])) {
    \$category_id = \$_POST['category_id'];
    \$sub_category_name = \$_POST['sub_category_name'];
    \$description = \$_POST['description'];
    \$status = \$_POST['status'];

    \$image = '';
    if (isset(\$_FILES['image']['name']) && \$_FILES['image']['name'] != '') {
        \$target_dir = "../uploads/subcategories/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$image = time() . '_' . basename(\$_FILES["image"]["name"]);
        move_uploaded_file(\$_FILES["image"]["tmp_name"], \$target_dir . \$image);
    }

    \$admin->cud("INSERT INTO `sub_categories` (`category_id`, `sub_category_name`, `description`, `image`, `status`) VALUES ('\$category_id', '\$sub_category_name', '\$description', '\$image', '\$status')");

    echo "<script>alert('Sub Category Added Successfully'); window.location.href='../servicep/manage-subcategory.php';</script>";
    exit;
}

if (isset(\$_POST['update_subcategory'])) {
    \$sub_category_id = \$_POST['sub_category_id'];
    \$category_id = \$_POST['category_id'];
    \$sub_category_name = \$_POST['sub_category_name'];
    \$description = \$_POST['description'];
    \$status = \$_POST['status'];

    \$where_update = "`category_id`='\$category_id', `sub_category_name`='\$sub_category_name', `description`='\$description', `status`='\$status'";

    if (isset(\$_FILES['image']['name']) && \$_FILES['image']['name'] != '') {
        \$target_dir = "../uploads/subcategories/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$image = time() . '_' . basename(\$_FILES["image"]["name"]);
        move_uploaded_file(\$_FILES["image"]["tmp_name"], \$target_dir . \$image);
        \$where_update .= ", `image`='\$image'";
    }

    \$admin->cud("UPDATE `sub_categories` SET \$where_update WHERE `sub_category_id`='\$sub_category_id'");

    echo "<script>alert('Sub Category Updated Successfully'); window.location.href='../servicep/manage-subcategory.php';</script>";
    exit;
}
?>
PHP,

    'manage-package.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['add_package'])) {
    \$vendor_id = \$_SESSION['vendor_id']; 
    \$category_id = \$_POST['category_id'];
    \$sub_category_id = \$_POST['sub_category_id'];
    \$package_name = \$_POST['package_name'];
    \$price = \$_POST['price'];
    \$discount_price = \$_POST['discount_price'];
    \$description = \$_POST['description'];
    \$inclusions = \$_POST['inclusions'];
    \$exclusions = \$_POST['exclusions'];
    \$max_capacity = \$_POST['max_capacity'];
    \$service_duration = \$_POST['service_duration'];
    \$available_days = is_array(\$_POST['available_days']) ? implode(',', \$_POST['available_days']) : \$_POST['available_days'];
    \$blackout_dates = \$_POST['blackout_dates'];
    \$cancellation_policy = \$_POST['cancellation_policy'];
    \$refund_policy = \$_POST['refund_policy'];
    \$status = \$_POST['status'];

    \$package_id = \$admin->Rcud("INSERT INTO `packages` (`vendor_id`, `category_id`, `sub_category_id`, `package_name`, `price`, `discount_price`, `description`, `inclusions`, `exclusions`, `max_capacity`, `service_duration`, `available_days`, `blackout_dates`, `cancellation_policy`, `refund_policy`, `status`) VALUES ('\$vendor_id', '\$category_id', '\$sub_category_id', '\$package_name', '\$price', '\$discount_price', '\$description', '\$inclusions', '\$exclusions', '\$max_capacity', '\$service_duration', '\$available_days', '\$blackout_dates', '\$cancellation_policy', '\$refund_policy', '\$status')");

    if (isset(\$_FILES['images']['name']) && \$_FILES['images']['name'][0] != '') {
        \$target_dir = "../uploads/packages/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$total_files = count(\$_FILES['images']['name']);
        for(\$key = 0; \$key < \$total_files; \$key++) {
            if (\$_FILES['images']['name'][\$key] != '') {
                \$image_path = time() . '_' . basename(\$_FILES["images"]["name"][\$key]);
                move_uploaded_file(\$_FILES["images"]["tmp_name"][\$key], \$target_dir . \$image_path);
                \$admin->cud("INSERT INTO `package_images` (`package_id`, `image_path`) VALUES ('\$package_id', '\$image_path')");
            }
        }
    }

    echo "<script>alert('Package Added Successfully'); window.location.href='../servicep/manage-package.php';</script>";
    exit;
}

if (isset(\$_POST['update_package'])) {
    \$package_id = \$_POST['package_id'];
    \$category_id = \$_POST['category_id'];
    \$sub_category_id = \$_POST['sub_category_id'];
    \$package_name = \$_POST['package_name'];
    \$price = \$_POST['price'];
    \$discount_price = \$_POST['discount_price'];
    \$description = \$_POST['description'];
    \$inclusions = \$_POST['inclusions'];
    \$exclusions = \$_POST['exclusions'];
    \$max_capacity = \$_POST['max_capacity'];
    \$service_duration = \$_POST['service_duration'];
    \$available_days = is_array(\$_POST['available_days']) ? implode(',', \$_POST['available_days']) : \$_POST['available_days'];
    \$blackout_dates = \$_POST['blackout_dates'];
    \$cancellation_policy = \$_POST['cancellation_policy'];
    \$refund_policy = \$_POST['refund_policy'];
    \$status = \$_POST['status'];

    \$admin->cud("UPDATE `packages` SET `category_id`='\$category_id', `sub_category_id`='\$sub_category_id', `package_name`='\$package_name', `price`='\$price', `discount_price`='\$discount_price', `description`='\$description', `inclusions`='\$inclusions', `exclusions`='\$exclusions', `max_capacity`='\$max_capacity', `service_duration`='\$service_duration', `available_days`='\$available_days', `blackout_dates`='\$blackout_dates', `cancellation_policy`='\$cancellation_policy', `refund_policy`='\$refund_policy', `status`='\$status' WHERE `package_id`='\$package_id'");

    if (isset(\$_FILES['images']['name']) && \$_FILES['images']['name'][0] != '') {
        \$target_dir = "../uploads/packages/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$total_files = count(\$_FILES['images']['name']);
        for(\$key = 0; \$key < \$total_files; \$key++) {
            if (\$_FILES['images']['name'][\$key] != '') {
                \$image_path = time() . '_' . basename(\$_FILES["images"]["name"][\$key]);
                move_uploaded_file(\$_FILES["images"]["tmp_name"][\$key], \$target_dir . \$image_path);
                \$admin->cud("INSERT INTO `package_images` (`package_id`, `image_path`) VALUES ('\$package_id', '\$image_path')");
            }
        }
    }

    echo "<script>alert('Package Updated Successfully'); window.location.href='../servicep/manage-package.php';</script>";
    exit;
}
?>
PHP,

    'servicep-manage-booking.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['update_booking'])) {
    \$booking_id = \$_POST['booking_id'];
    \$status = \$_POST['status']; 
    \$rejection_reason = isset(\$_POST['rejection_reason']) ? \$_POST['rejection_reason'] : '';

    if (\$status == 'Rejected' && empty(\$rejection_reason)) {
        echo "<script>alert('Rejection reason is mandatory'); window.history.back();</script>";
        exit;
    }

    \$admin->cud("UPDATE `bookings` SET `status`='\$status', `rejection_reason`='\$rejection_reason' WHERE `booking_id`='\$booking_id'");

    echo "<script>alert('Booking Status Updated Successfully'); window.location.href='../servicep/manage-bookings.php';</script>";
    exit;
}
?>
PHP,

    'user-register.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['register'])) {
    \$full_name = \$_POST['full_name'];
    \$email = \$_POST['email'];
    \$phone_number = \$_POST['phone_number'];
    \$password_raw = \$_POST['password'];
    \$confirm_password = \$_POST['confirm_password'];
    \$address = \$_POST['address'];
    \$city = \$_POST['city'];
    \$state = \$_POST['state'];
    \$pincode = \$_POST['pincode'];
    
    if (!isset(\$_POST['accept_terms'])) {
        echo "<script>alert('You must accept the Terms & Conditions'); window.location.href='../register.php';</script>";
        exit;
    }

    if (\$password_raw !== \$confirm_password) {
        echo "<script>alert('Passwords do not match'); window.location.href='../register.php';</script>";
        exit;
    }

    \$stmt = \$admin->ret("SELECT * FROM `users` WHERE `email`='\$email'");
    if (\$stmt->rowCount() > 0) {
        echo "<script>alert('Email already exists'); window.location.href='../register.php';</script>";
        exit;
    }

    \$password = password_hash(\$password_raw, PASSWORD_BCRYPT);

    \$admin->cud("INSERT INTO `users` (`full_name`, `email`, `phone_number`, `password`, `address`, `city`, `state`, `pincode`) VALUES ('\$full_name', '\$email', '\$phone_number', '\$password', '\$address', '\$city', '\$state', '\$pincode')");

    echo "<script>alert('Registration Successful'); window.location.href='../login.php';</script>";
    exit;
}
?>
PHP,

    'user-login.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['login'])) {
    \$email = \$_POST['email'];
    \$password = \$_POST['password'];

    \$stmt = \$admin->ret("SELECT * FROM `users` WHERE `email`='\$email'");
    \$row = \$stmt->fetch(PDO::FETCH_ASSOC);

    if (\$row && password_verify(\$password, \$row['password'])) {
        if (\$row['status'] == 'Blocked') {
            echo "<script>alert('Your account is blocked. Please contact admin.'); window.location.href='../login.php';</script>";
            exit;
        }

        \$_SESSION['user_id'] = \$row['user_id'];
        \$_SESSION['full_name'] = \$row['full_name'];
        \$_SESSION['role'] = \$row['role'];

        echo "<script>
            alert('Login Successful');
            window.location.href='../index.php';
        </script>";
        exit;
    } else {
        echo "<script>alert('Invalid Email or Password'); window.location.href='../login.php';</script>";
        exit;
    }
}
?>
PHP,

    'user-logout.php' => <<<PHP
<?php
require '../config.php';
unset(\$_SESSION['user_id']);
unset(\$_SESSION['full_name']);
unset(\$_SESSION['role']);
echo "<script>window.location.href='../login.php';</script>";
exit;
?>
PHP,

    'user-book-package.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['book_package'])) {
    if (!isset(\$_SESSION['user_id'])) {
        echo "<script>alert('Please login to book a package'); window.location.href='../login.php';</script>";
        exit;
    }

    \$user_id = \$_SESSION['user_id'];
    \$vendor_id = \$_POST['vendor_id'];
    \$package_id = \$_POST['package_id'];
    
    \$event_type = \$_POST['event_type'];
    \$event_date = \$_POST['event_date'];
    
    if (strtotime(\$event_date) < strtotime(date('Y-m-d'))) {
        echo "<script>alert('You cannot select a past date.'); window.history.back();</script>";
        exit;
    }
    
    \$check_stmt = \$admin->ret("SELECT * FROM `bookings` WHERE `event_date`='\$event_date' AND `vendor_id`='\$vendor_id' AND `status` NOT IN ('Rejected', 'Cancelled')");
    if(\$check_stmt->rowCount() > 0) {
        echo "<script>alert('This date is already booked. Please choose another date.'); window.history.back();</script>";
        exit;
    }

    \$start_time = \$_POST['start_time'];
    \$end_time = \$_POST['end_time'];
    \$number_of_guests = \$_POST['number_of_guests'];
    \$venue_address = \$_POST['venue_address'];
    \$special_requirements = \$_POST['special_requirements'];
    
    if (!isset(\$_POST['agree_cancellation_policy'])) {
        echo "<script>alert('You must agree to the cancellation policy'); window.history.back();</script>";
        exit;
    }

    \$reference_image = '';
    if (isset(\$_FILES['reference_image']['name']) && \$_FILES['reference_image']['name'] != '') {
        \$target_dir = "../uploads/bookings/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$reference_image = time() . '_' . basename(\$_FILES["reference_image"]["name"]);
        move_uploaded_file(\$_FILES["reference_image"]["tmp_name"], \$target_dir . \$reference_image);
    }

    \$total_price = \$_POST['total_price']; 

    \$booking_id = \$admin->Rcud("INSERT INTO `bookings` (`user_id`, `vendor_id`, `package_id`, `event_type`, `event_date`, `start_time`, `end_time`, `number_of_guests`, `venue_address`, `special_requirements`, `reference_image`, `total_price`) VALUES ('\$user_id', '\$vendor_id', '\$package_id', '\$event_type', '\$event_date', '\$start_time', '\$end_time', '\$number_of_guests', '\$venue_address', '\$special_requirements', '\$reference_image', '\$total_price')");

    echo "<script>alert('Booking initiated! Proceeding to Payment.'); window.location.href='../payment.php?booking_id=\$booking_id';</script>";
    exit;
}
?>
PHP,

    'user-payment.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['submit_payment'])) {
    if (!isset(\$_SESSION['user_id'])) {
        echo "<script>alert('Please login'); window.location.href='../login.php';</script>";
        exit;
    }

    \$booking_id = \$_POST['booking_id'];
    \$user_id = \$_SESSION['user_id'];
    
    \$stmt = \$admin->ret("SELECT `vendor_id`, `total_price` FROM `bookings` WHERE `booking_id`='\$booking_id'");
    \$booking = \$stmt->fetch(PDO::FETCH_ASSOC);
    \$vendor_id = \$booking['vendor_id'];
    \$amount = \$booking['total_price'];

    if (!isset(\$_POST['payment_terms'])) {
        echo "<script>alert('You must confirm payment terms'); window.history.back();</script>";
        exit;
    }

    \$card_holder_name = isset(\$_POST['card_holder_name']) ? \$_POST['card_holder_name'] : '';
    \$payment_method = \$_POST['payment_method']; 
    \$billing_address = \$_POST['billing_address'];
    \$gst_number = isset(\$_POST['gst_number']) ? \$_POST['gst_number'] : '';

    \$transaction_id = 'TXN' . time() . rand(100, 999);

    \$payment_id = \$admin->Rcud("INSERT INTO `payments` (`booking_id`, `user_id`, `vendor_id`, `card_holder_name`, `payment_method`, `transaction_id`, `amount`, `payment_status`, `billing_address`, `gst_number`) VALUES ('\$booking_id', '\$user_id', '\$vendor_id', '\$card_holder_name', '\$payment_method', '\$transaction_id', '\$amount', 'Pending', '\$billing_address', '\$gst_number')");

    \$admin->cud("UPDATE `bookings` SET `status`='Payment Pending' WHERE `booking_id`='\$booking_id'");

    echo "<script>alert('Payment submitted successfully! Waiting for Confirmation.'); window.location.href='../my-bookings.php';</script>";
    exit;
}
?>
PHP,

    'user-feedback.php' => <<<PHP
<?php
require '../config.php';
\$admin = new Admin();

if (isset(\$_POST['submit_feedback'])) {
    if (!isset(\$_SESSION['user_id'])) {
        echo "<script>alert('Please login'); window.location.href='../login.php';</script>";
        exit;
    }

    \$user_id = \$_SESSION['user_id'];
    \$booking_id = \$_POST['booking_id'];
    
    \$stmt = \$admin->ret("SELECT `vendor_id`, `package_id` FROM `bookings` WHERE `booking_id`='\$booking_id'");
    \$booking = \$stmt->fetch(PDO::FETCH_ASSOC);
    \$vendor_id = \$booking['vendor_id'];
    \$package_id = \$booking['package_id'];

    \$rating = \$_POST['rating'];
    \$review_title = \$_POST['review_title'];
    \$review_comment = \$_POST['review_comment'];
    \$is_anonymous = isset(\$_POST['anonymous']) ? 1 : 0;

    \$images = '';
    if (isset(\$_FILES['images']['name']) && \$_FILES['images']['name'][0] != '') {
        \$target_dir = "../uploads/feedbacks/";
        if (!is_dir(\$target_dir)) { mkdir(\$target_dir, 0777, true); }
        \$img_array = [];
        \$total_files = count(\$_FILES['images']['name']);
        for(\$key = 0; \$key < \$total_files; \$key++) {
            if (\$_FILES['images']['name'][\$key] != '') {
                \$image_path = time() . '_' . basename(\$_FILES["images"]["name"][\$key]);
                move_uploaded_file(\$_FILES["images"]["tmp_name"][\$key], \$target_dir . \$image_path);
                \$img_array[] = \$image_path;
            }
        }
        \$images = implode(',', \$img_array);
    }

    \$admin->cud("INSERT INTO `feedbacks` (`booking_id`, `user_id`, `vendor_id`, `package_id`, `rating`, `review_title`, `review_comment`, `images`, `is_anonymous`) VALUES ('\$booking_id', '\$user_id', '\$vendor_id', '\$package_id', '\$rating', '\$review_title', '\$review_comment', '\$images', '\$is_anonymous')");

    echo "<script>alert('Feedback submitted successfully!'); window.location.href='../my-bookings.php';</script>";
    exit;
}
?>
PHP

];

foreach (\$files as \$filename => \$content) {
    file_put_contents(\$dir . \$filename, \$content);
    echo "Created controller: \$filename\\n";
}

echo "All backend files generated successfully.";
?>
