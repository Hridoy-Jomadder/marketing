<?php
// Database connection
include 'db.php';
// Get the product ID from the URL
$product_id = $_GET['id'];

// SQL to delete the product from the database
$sql = "DELETE FROM products WHERE id = $product_id";

if ($conn->query($sql) === TRUE) {
    echo "Product deleted successfully.";
    header("Location: index.php"); // Redirect to the product list page
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
