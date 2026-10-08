<?php
$password_raw = "password123";
$password = password_hash($password_raw, PASSWORD_BCRYPT);
echo "Hash: " . $password . "\n";
$sql = "INSERT INTO `users` (`password`) VALUES ('$password')";
echo "SQL: " . $sql . "\n";
?>
