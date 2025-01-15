<?php
session_start();

// Ensure the user is logged in and is an Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");  // Redirect to login if not an admin
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .logout {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, Admin!</h1>
        <p>You have full access to the administrative controls.</p>
    </header>
    
    <div class="container">
        <h2>Admin Controls</h2>
        <ul>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="add_product.php">Add New Product</a></li>
            <li><a href="view_orders.php">View Orders</a></li>
        </ul>

        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
