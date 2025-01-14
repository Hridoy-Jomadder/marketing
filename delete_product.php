<?php
// Include database connection
include 'db.php';

// Get the product ID from the URL securely
$product_id = intval($_GET['id']);

// Delete product using a prepared statement
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    echo "Product deleted successfully.";
    header("Location: index.php");
    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}

$conn->close();
?>
