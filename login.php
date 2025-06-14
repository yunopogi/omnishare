<?php
require 'db.php';

$input = $_POST['username_or_email'] ?? '';
$password = $_POST['password'] ?? '';

// Log what is received
file_put_contents("login_debug.txt", "Input: $input\nPassword: $password\n", FILE_APPEND);

if (!$input || !$password) {
    echo json_encode(["success" => false, "message" => "Missing login fields"]);
    exit;
}

// Look up user
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->execute([$input, $input]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Log what is fetched
file_put_contents("login_debug.txt", "User found: " . print_r($user, true) . "\n", FILE_APPEND);

// Password check
if ($user && password_verify($password, $user['password_hash'])) {
    echo json_encode(["success" => true, "user_id" => $user['id']]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid credentials"]);
}
?>
