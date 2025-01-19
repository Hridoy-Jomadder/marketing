<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
    // Sanitize and validate inputs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
        header("Location: login.php");
        exit();
    }

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'Admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] === 'Seller') {
                header("Location: index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid credentials.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "No user found with that email.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <!-- Display error messages if any -->
    <?php
    if (isset($_SESSION['error_message'])) {
        echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error_message']) . "</p>";
        unset($_SESSION['error_message']);
    }
    ?>

    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="hidden" name="action" value="login">
        <button type="submit">Login</button>
    </form>
    <br>
    <a href="signup.php">Don't have an account? Sign up here</a>
</body>
</html>
