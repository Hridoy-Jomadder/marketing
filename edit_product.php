<?php

// Database connection
include 'db.php';   
// Get the product ID from the URL
$product_id = $_GET['id'];

// Fetch the product details from the database
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit();
}

// Handle form submission for updating product details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $weight = $_POST['weight'];
    $price = $_POST['price'];

    // SQL to update the product in the database
    $sql = "UPDATE products SET name='$name', description='$description', image='$image', weight='$weight', price='$price' WHERE id=$product_id";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully.";
        header("Location: index.php"); // Redirect to the product list page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?php echo $row['description']; ?></textarea><br><br>
        
        <label for="image">Image ID or Filename:</label><br>
        <input type="text" id="image" name="image" value="<?php echo $row['image']; ?>" required><br><br>
        
        <label for="weight">Weight:</label><br>
        <input type="number" id="weight" name="weight" value="<?php echo $row['weight']; ?>" required><br><br>
        
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $row['price']; ?>" required><br><br>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
