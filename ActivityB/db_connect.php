<?php
// ============================================
// Database connection settings
// Update these to match your local MySQL setup
// ============================================
$host   = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "registration_system";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>