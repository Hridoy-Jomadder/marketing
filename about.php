<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Agri E-Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Header Style */
        header {
            background: linear-gradient(90deg, #007bff, #6c63ff);
            color: white;
            padding: 2rem 0;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-link.active {
            font-weight: bold;
            color: #f0ad4e !important;
        }

        footer {
            margin-top: 50px;
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        .content-section {
            margin-top: 50px;
        }

        .content-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .content-section p {
            font-size: 1.2rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to the Agri E-Marketplace</h1>
    <p>Find and manage agricultural products with ease.</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Agri E-Marketplace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_product.php">Add Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="bill.php">Bill</a></li>
                    <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container content-section">
    <h2>About Agri E-Marketplace</h2>
    <p>Agri E-Marketplace is an online platform designed to connect sellers and buyers of agricultural products. Whether you are a farmer looking to sell your fresh produce or a customer seeking quality products, our platform offers a wide range of options to fulfill your needs.</p>
    <p>Our mission is to streamline the agricultural supply chain, providing a seamless experience for both buyers and sellers. We aim to enhance accessibility and transparency in the agricultural market, ensuring that fresh produce reaches customers at affordable prices while offering sellers a platform to showcase their products.</p>
    <p>We value sustainability, transparency, and quality in every transaction. Join us today and become a part of the Agri E-Marketplace community.</p>
</div>

<footer>
    <p>&copy; 2025 Agri E-Marketplace. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
