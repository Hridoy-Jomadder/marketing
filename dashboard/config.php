<?php
// config.php
// Database configuration
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "marketplace"; // Database name

// Create a connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optionally, set the character set to UTF-8
mysqli_set_charset($conn, "utf8");
?>
