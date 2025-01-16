<?php
session_start();
include 'db.php';

// Redirect to login if the user is not signed in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user details to pre-fill the form
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $role = trim($_POST['role']); // Admin can change the role, but keep it read-only for others

    // Prevent non-admin users from changing roles
    if ($_SESSION['role'] !== 'Admin') {
        $role = $user['role'];  // Prevent changing the role
    }

    $update_sql = "UPDATE users SET email = ?, password = ?, full_name = ?, phone = ?, address = ?, role = ? WHERE id = ?";
    
    // Hash the password if it's provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Keep the old password if no new one is provided
        $hashed_password = $user['password'];
    }

    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $email, $hashed_password, $full_name, $phone, $address, $role, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['role'] = $role;  // Update the role in the session if it's changed
        echo "Profile updated successfully!";
        // Redirect to the dashboard after updating
        header("Location: seller_dashboard.php");
        exit();
    } else {
        echo "Error updating profile: " . $update_stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    
    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <label>Full Name:</label><br>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br><br>

        <label>Address:</label><br>
        <textarea name="address"><?php echo htmlspecialchars($user['address']); ?></textarea><br><br>

        <label>Role:</label><br>
        <input type="text" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" readonly><br><br>

        <button type="submit">Update Profile</button>
    </form>
    
    <br>
    <a href="seller_dashboard.php">Back to Dashboard</a>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
