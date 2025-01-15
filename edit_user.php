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

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

// Handle form submission to update user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user in the database
    $update_sql = "UPDATE users SET email = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $email, $role, $user_id);

    if ($stmt->execute()) {
        echo "User updated successfully.";
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="Admin" <?php if ($user['role'] === 'Admin') echo 'selected'; ?>>Admin</option>
            <option value="Seller" <?php if ($user['role'] === 'Seller') echo 'selected'; ?>>Seller</option>
            <option value="Customer" <?php if ($user['role'] === 'Customer') echo 'selected'; ?>>Customer</option>
        </select><br><br>

        <button type="submit">Update User</button>
    </form>

    <p><a href="manage_users.php">Back to Manage Users</a></p>
</body>
</html>
