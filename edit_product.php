<?php
// Include database connection
include 'db.php';

// Get the product ID from the URL
$product_id = intval($_GET['id']);

// Fetch product details securely
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit();
}

// Handle form submission for updating product details
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);
    $weight = (float) $_POST['weight'];
    $price = (float) $_POST['price'];

    // Update product details securely
    $update_sql = "UPDATE products SET name = ?, description = ?, image = ?, weight = ?, price = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssddi", $name, $description, $image, $weight, $price, $product_id);

    if ($update_stmt->execute()) {
        echo "Product updated successfully.";
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="POST">
        <label for="name">Product Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea><br><br>
        
        <label for="image">Image ID or Filename:</label><br>
        <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($row['image']); ?>" required><br><br>
        
        <label for="weight">Weight (kg):</label><br>
        <input type="number" id="weight" name="weight" step="0.01" value="<?php echo $row['weight']; ?>" required><br><br>
        
        <label for="price">Price (BDT):</label><br>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo $row['price']; ?>" required><br><br>

        <button type="submit">Update Product</button>
    </form>

    <p><a href="index.php">Back to Product List</a></p>
</body>
</html>
