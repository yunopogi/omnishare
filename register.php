<?php
require 'db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, terms_accepted) VALUES (?, ?, ?, TRUE)");
$stmt->execute([$username, $email, $password]);

echo json_encode(["success" => true]);
?>
