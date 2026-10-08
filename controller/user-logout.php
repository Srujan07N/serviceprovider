<?php
require '../config.php';
unset($_SESSION['user_id']);
unset($_SESSION['full_name']);
unset($_SESSION['role']);
echo "<script>window.location.href='../login.php';</script>";
exit;
?>
