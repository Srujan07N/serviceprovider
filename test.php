<?php
require 'config.php';
$admin = new Admin();
$stmt = $admin->ret("DESCRIBE users");
$cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($cols, JSON_PRETTY_PRINT);
?>
