<?php
require 'config.php';
$admin = new Admin();
$stmt = $admin->ret("SELECT user_id, email, password FROM users ORDER BY user_id DESC LIMIT 5");
$cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($cols, JSON_PRETTY_PRINT);
?>
