<?php
$host = "localhost";
$dbname = "omnishare_db";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
