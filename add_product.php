<?php
// Include database connection
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);
    $weight = (float) $_POST['weight'];
    $price = (float) $_POST['price'];

    // Insert data into the products table
    $stmt = $conn->prepare("INSERT INTO products (name, description, image, weight, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdd", $name, $description, $image, $weight, $price);

    if ($stmt->execute()) {
        echo "<p>Product added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        form {
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h2>Add New Product</h2>
    <form method="POST">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="image">Image Filename or ID:</label>
        <input type="text" id="image" name="image" required>

        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" step="0.01" required>

        <label for="price">Price (BDT):</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <button type="submit">Add Product</button>
    </form>

    <p><a href="index.php">Back to Product List</a></p>
</body>
</html>
