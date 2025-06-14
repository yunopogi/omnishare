<?php
require 'db.php';

$user_id = $_POST['user_id'];
$original_name = $_POST['original_filename'];
$stored_name = $_POST['stored_filename'];
$file_size = $_POST['file_size'];
$expiry = $_POST['expiry_minutes'];
$link = $_POST['file_url'];

$stmt = $pdo->prepare("INSERT INTO files (user_id, original_filename, stored_filename, file_size, file_url, expiry_minutes)
VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $original_name, $stored_name, $file_size, $link, $expiry]);

echo json_encode(["success" => true]);
?>
