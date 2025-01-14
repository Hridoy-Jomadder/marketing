<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php");  // Redirect if the user is not a customer
    exit();
}

echo "<h1>Welcome, Customer</h1>";
echo "<p>You have access to the customer dashboard.</p>";
// Your customer functionalities here
?>
