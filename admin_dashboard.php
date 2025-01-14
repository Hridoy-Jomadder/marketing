<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");  // Redirect if the user is not an admin
    exit();
}

echo "<h1>Welcome, Admin</h1>";
echo "<p>You have access to the admin dashboard.</p>";
// Your admin functionalities here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome Admin!</h1>
    <a href="logout.php">Logout</a>
</body>
</html>


