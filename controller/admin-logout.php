<?php
require '../config.php';

unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);

echo "<script>window.location.href='../admin/login.php';</script>";
exit;
?>
