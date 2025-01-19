<?php
session_start();
include_once 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details
    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    // If product exists
    if ($product) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = $_POST['quantity'];
            $total_price = $product['price'] * $quantity;
            $customer_name = $_SESSION['email']; // Assuming user email is stored in session

            // Insert the order into the database
            $order_query = "INSERT INTO orders (customer_name, product_name, quantity, total_price, order_status, user_id, product_id)
                            VALUES ('$customer_name', '{$product['name']}', '$quantity', '$total_price', 'Pending', '{$_SESSION['user_id']}', '$product_id')";
            if (mysqli_query($conn, $order_query)) {
                echo "<p>Order placed successfully!</p>";
            } else {
                echo "<p>Error placing order.</p>";
            }
        }
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - Marketing Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Order Product</h2>
        <?php if (isset($product)): ?>
            <form method="POST">
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Place Order</button>
            </form>
            <h4 class="mt-3">Product Details:</h4>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($product['name']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
            <p><strong>Price:</strong> $<?php echo $product['price']; ?></p>
        <?php endif; ?>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
