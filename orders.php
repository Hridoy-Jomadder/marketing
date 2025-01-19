<?php
// Include database connection
include 'db.php';

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: You must be logged in to access this page.";
    exit();
}

// Get the logged-in user ID
$user_id = $_SESSION['user_id'];

// Get the bill ID from the URL
$bill_id = isset($_GET['bill_id']) ? intval($_GET['bill_id']) : null;

// Validate that `bill_id` is provided
if (!$bill_id) {
    echo "Error: Bill ID is required. <a href='index.php'>Back to Home</a>";
    exit();
}

// Fetch orders for the given bill ID
$sql = "SELECT o.id AS order_id, o.product_name, o.quantity, o.total_price, o.order_status, p.name AS product_name, b.total_amount AS bill_total
        FROM orders o
        JOIN products p ON o.product_id = p.id
        JOIN bills b ON b.id = o.id
        WHERE b.id = ? AND b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $bill_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are orders for the bill
if ($result->num_rows === 0) {
    echo "No orders found for this bill.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
</head>
<body>
<header>
        <h1>Welcome to the Agri E-Marketplace</h1>
        <p>Your personal profile</p>
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
                    <li class="nav-item"><a class="nav-link active" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="bill.php">Bill</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <h2>Orders for Bill ID: <?php echo htmlspecialchars($bill_id); ?></h2>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price (BDT)</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_status']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <p><a href="index.php">Back to Home</a></p>
</body>
</html>
