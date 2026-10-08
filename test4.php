<?php
require 'config.php';
$admin = new Admin();

// Mimic exactly what user-register.php does AFTER my fix
$full_name = "Test User";
$email = "test".time()."@gmail.com";
$phone_number = "1234567890";
$password_raw = "password123";
$address = "123 Test St";
$city = "Test City";
$state = "Test State";
$pincode = "123456";

$password = password_hash($password_raw, PASSWORD_BCRYPT);
echo "Password hash to be inserted: $password\n";

$query = "INSERT INTO `users` (`full_name`, `email`, `phone_number`, `password`, `address`, `city`, `state`, `pincode`) VALUES ('$full_name', '$email', '$phone_number', '$password', '$address', '$city', '$state', '$pincode')";
echo "Executing: $query\n";

$admin->cud($query, "");

// Check if it stored.
$stmt = $admin->ret("SELECT user_id, email, password FROM users ORDER BY user_id DESC LIMIT 1");
$cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Latest user in DB:\n";
echo json_encode($cols, JSON_PRETTY_PRINT);
?>
