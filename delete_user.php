<?php
session_start();
include 'db.php';

// Check if the user is an Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Get user ID from the query parameter
$user_id = $_GET['id'];

// Delete user from the database
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "User deleted successfully.";
    header("Location: manage_users.php");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}

$conn->close();
?>
