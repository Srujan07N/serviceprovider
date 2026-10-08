CREATE DATABASE IF NOT EXISTS `serviceprovider`;
USE `serviceprovider`;

CREATE TABLE IF NOT EXISTS `admin` (
    `admin_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin` (`name`, `email`, `password`) VALUES ('Admin', 'admin@gmail.com', '$2y$10$YkIgqrDqLmtevAeHt4fz/uOYJF07Zo/NERpnAwADXRk7aEXffPzcq');

CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `full_name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `phone_number` varchar(20) NOT NULL,
    `password` varchar(255) NOT NULL,
    `address` text NOT NULL,
    `city` varchar(50) NOT NULL,
    `state` varchar(50) NOT NULL,
    `pincode` varchar(10) NOT NULL,
    `status` enum('Active','Blocked') DEFAULT 'Active',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `role` varchar(20) DEFAULT 'User',
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `vendors` (
    `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
    `business_name` varchar(100) NOT NULL,
    `owner_name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `phone_number` varchar(20) NOT NULL,
    `password` varchar(255) NOT NULL,
    `business_address` text NOT NULL,
    `city` varchar(50) NOT NULL,
    `state` varchar(50) NOT NULL,
    `pincode` varchar(10) NOT NULL,
    `gst_number` varchar(20) NOT NULL,
    `pan_number` varchar(20) NOT NULL,
    `license_upload` varchar(255) NOT NULL,
    `profile_image` varchar(255) NOT NULL,
    `bank_account_details` text NOT NULL,
    `upi_id` varchar(50) NOT NULL,
    `service_area` varchar(100) NOT NULL,
    `experience_years` int(11) NOT NULL,
    `status` enum('Pending','Approved','Rejected','Blocked') DEFAULT 'Pending',
    `rejection_reason` text DEFAULT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `categories` (
    `category_id` int(11) NOT NULL AUTO_INCREMENT,
    `category_name` varchar(100) NOT NULL,
    `category_slug` varchar(100) NOT NULL,
    `category_image` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `status` enum('Active','Inactive') DEFAULT 'Active',
    `display_order` int(11) DEFAULT 0,
    `meta_title` varchar(255) DEFAULT NULL,
    `meta_description` text DEFAULT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `sub_categories` (
    `sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
    `category_id` int(11) NOT NULL,
    `sub_category_name` varchar(100) NOT NULL,
    `description` text NOT NULL,
    `image` varchar(255) NOT NULL,
    `status` enum('Active','Inactive') DEFAULT 'Active',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`sub_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `packages` (
    `package_id` int(11) NOT NULL AUTO_INCREMENT,
    `vendor_id` int(11) NOT NULL,
    `category_id` int(11) NOT NULL,
    `sub_category_id` int(11) NOT NULL,
    `package_name` varchar(100) NOT NULL,
    `price` decimal(10,2) NOT NULL,
    `discount_price` decimal(10,2) DEFAULT NULL,
    `description` text NOT NULL,
    `inclusions` text NOT NULL,
    `exclusions` text NOT NULL,
    `max_capacity` int(11) NOT NULL,
    `service_duration` int(11) NOT NULL,
    `available_days` text NOT NULL,
    `blackout_dates` text DEFAULT NULL,
    `cancellation_policy` text NOT NULL,
    `refund_policy` text NOT NULL,
    `status` enum('Active','Inactive') DEFAULT 'Active',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `package_images` (
    `image_id` int(11) NOT NULL AUTO_INCREMENT,
    `package_id` int(11) NOT NULL,
    `image_path` varchar(255) NOT NULL,
    PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `bookings` (
    `booking_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `vendor_id` int(11) NOT NULL,
    `package_id` int(11) NOT NULL,
    `event_type` varchar(100) NOT NULL,
    `event_date` date NOT NULL,
    `start_time` time NOT NULL,
    `end_time` time NOT NULL,
    `number_of_guests` int(11) NOT NULL,
    `venue_address` text DEFAULT NULL,
    `special_requirements` text DEFAULT NULL,
    `reference_image` varchar(255) DEFAULT NULL,
    `status` enum('Pending','Approved','Rejected','Payment Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
    `rejection_reason` text DEFAULT NULL,
    `payment_status` enum('Pending','Completed','Failed') DEFAULT 'Pending',
    `total_price` decimal(10,2) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `payments` (
    `payment_id` int(11) NOT NULL AUTO_INCREMENT,
    `booking_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `vendor_id` int(11) NOT NULL,
    `card_holder_name` varchar(100) DEFAULT NULL,
    `payment_method` varchar(50) NOT NULL,
    `transaction_id` varchar(100) DEFAULT NULL,
    `amount` decimal(10,2) NOT NULL,
    `payment_status` enum('Pending','Completed','Failed') DEFAULT 'Pending',
    `billing_address` text DEFAULT NULL,
    `gst_number` varchar(20) DEFAULT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `feedbacks` (
    `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
    `booking_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `vendor_id` int(11) NULL,
    `package_id` int(11) NULL,
    `rating` int(11) NOT NULL,
    `review_title` varchar(100) DEFAULT NULL,
    `review_comment` text NOT NULL,
    `images` text DEFAULT NULL,
    `is_anonymous` tinyint(1) DEFAULT 0,
    `is_flagged` tinyint(1) DEFAULT 0,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
