<?php
session_start();
if ($_SESSION['role'] !== 'Admin') {
    die("Access denied. Admins only.");
}
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
