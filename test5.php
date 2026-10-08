<?php
require 'config.php';
$admin = new Admin();
$pwd = password_hash("password123", PASSWORD_BCRYPT);
$admin->cud("UPDATE `users` SET `password`='$pwd' WHERE `password`=''", "");
echo "Done";
?>
