<?php
require 'db.php';
$code = $_GET['c'] ?? '';
if (!$code) {
    die('Invalid link.');
}

// Fetch file record
$stmt = $pdo->prepare("SELECT * FROM files WHERE share_code = ?");
$stmt->execute([$code]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$file) {
    die('Link not found.');
}

// Check expiry
$expTime = strtotime($file['uploaded_at']) + $file['expiry_minutes'] * 60;
if (time() > $expTime) {
    die('Link expired.');
}

// Deliver file
$path = __DIR__ . '/uploads/' . $file['stored_filename'];
if (!file_exists($path)) {
    die('File missing.');
}
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file['original_filename']) . '"');
readfile($path);
