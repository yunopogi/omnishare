<?php
$host = 'localhost';
$dbname = 'omnishare_db';
$user = 'root'; // Change this if you set a different MySQL username
$pass = '';     // And change this if you set a password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>
