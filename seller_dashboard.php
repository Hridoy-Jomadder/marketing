<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Seller') {
    header("Location: login.php");  // Redirect if the user is not a seller
    exit();
}

echo "<h1>Welcome, Seller</h1>";
echo "<p>You have access to the seller dashboard.</p>";
// Your seller functionalities here
?>
