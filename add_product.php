<?php
session_start();
include 'db.php';

// Redirect to login if the user is not signed in
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'Seller' && $_SESSION['role'] !== 'Admin')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $weight = trim($_POST['weight']);
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Upload image
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (name, description, price, weight, image, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdssi", $name, $description, $price, $weight, $image, $user_id);

        if ($stmt->execute()) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <meta content="" name="keywords">
    <meta content="" name="description">

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
<div class="header">
        <h1>Welcome to the Agri E-Marketplace</h1>
    </div>

    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>    
        <?php if (!empty($_SESSION['role']) && ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Seller')): ?>
            <a href="add_product.php">Add New Product</a>
        <?php endif; ?>
        <a href="view_orders.php">View Products</a>
        <a href="new_order.php">New Order</a>
        <a href="bill.php">Bill</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">Logout</a>
    </div>

    <h1>Add New Product</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Product Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>Price (BDT):</label><br>
        <input type="number" name="price" required><br><br>

        <label>Weight (kg):</label><br>
        <input type="number" step="0.01" name="weight" required><br><br>

        <label>Product Image:</label><br>
        <input type="file" name="image" required><br><br>

        <button type="submit">Add Product</button>
    </form>
    <br>
    <a href="seller_dashboard.php">Back to Dashboard</a>
       <!-- Back to Top -->
       <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>
</html>

