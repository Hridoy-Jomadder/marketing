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
    <title>Agri Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Agriculture Dashboard, Management, Tools" name="keywords">
    <meta content="Manage your agriculture projects efficiently with our dashboard" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar & Hero Start -->
    <div class="container-fluid header position-relative overflow-hidden p-0">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="index.php" class="navbar-brand p-0">
                <h1 class="display-6 text-primary m-0"><i class="fas fa-tractor me-3"></i>AgriDashboard</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <!-- <a href="index.php" class="nav-item nav-link">Dashboard</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="service.php" class="nav-item nav-link">Services</a>
                    <a href="products.php" class="nav-item nav-link">Products</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a> -->
                </div>
                <a href="login.php" class="btn btn-light border border-primary rounded-pill text-primary py-2 px-4 me-4">Log In</a>
                <a href="signup.php" class="btn btn-primary rounded-pill text-white py-2 px-4">Sign Up</a>
            </div>
        </nav>

    <div class="container">
    <div class="container py-5">
<br>
<br>
<br>
<br>        
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
        <br>
        <br>
        <br>
        <br>
    </div>
</div>
    <script src="js/main.js"></script>
</body>

</html>
