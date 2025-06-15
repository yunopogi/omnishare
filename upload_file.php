<?php
// Show all PHP errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

$userId = $_POST['user_id'] ?? null;
$expiry = intval($_POST['expiry_minutes'] ?? 15);
$file = $_FILES['file'] ?? null;

if (!$userId || !$file) {
    die('Missing user or file');
}

$originalName = $file['name'];
$storedName = uniqid() . "_" . basename($originalName);
$path = __DIR__ . "/uploads/" . $storedName;

if (!move_uploaded_file($file['tmp_name'], $path)) {
    die('Upload failed');
}

$fileSize = filesize($path);
$shareCode = bin2hex(random_bytes(8));
$fileUrl = "https://YOUR_DOMAIN/download.php?c=$shareCode";

// Save to DB
$stmt = $pdo->prepare("INSERT INTO files (user_id, original_filename, stored_filename, file_size, file_url, expiry_minutes, share_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$userId, $originalName, $storedName, $fileSize, $fileUrl, $expiry, $shareCode]);

echo json_encode([
    "success" => true,
    "file_url" => $fileUrl
]);
?>
