<?php
session_start();
require_once 'config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query to fetch user details
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['error_message'] = "Incorrect password.";
        }
    } else {
        $_SESSION['error_message'] = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - DashboardAgri</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h2 class="text-center">Login</h2>

        <!-- Display error messages -->
        <?php if (isset($_SESSION['error_message'])) : ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error_message']); ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <input type="hidden" name="action" value="login">
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3">
            <a href="signup.php">Don't have an account? Sign up here</a>
        </p>
    </div>

    <script src="js/main.js"></script>
</body>

</html>
