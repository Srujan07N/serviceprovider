<?php
require '../config.php';
unset($_SESSION['vendor_id']);
unset($_SESSION['business_name']);
echo "<script>window.location.href='../servicep/login.php';</script>";
exit;
?>
