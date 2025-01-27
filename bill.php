<?php
// Start session to track logged-in user
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header('Location: login.php');
    exit();
}

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Get the bill_id from the URL (e.g., bill.php?bill_id=123)
if (!isset($_GET['bill_id'])) {
    echo "No bill ID provided.";
    exit();
}
$bill_id = $_GET['bill_id'];

// Include database connection file
include 'db.php';

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the bill details
$sql = "SELECT b.id AS bill_id, b.total_amount, b.bill_date, b.status
        FROM bills b
        WHERE b.id = ? AND b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $bill_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Bill not found or you're not authorized to view this bill.";
    exit();
}

$bill = $result->fetch_assoc();

// Fetch ordered products under this bill
$sql_products = "SELECT p.name AS product_name, o.quantity, o.total_price
                 FROM orders o
                 JOIN products p ON p.id = o.product_id
                 WHERE o.bill_id = ? AND o.user_id = ?";
$stmt_products = $conn->prepare($sql_products);
$stmt_products->bind_param("ii", $bill_id, $user_id);
$stmt_products->execute();
$result_products = $stmt_products->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 800px; margin-top: 20px; }
        .print-btn { margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <header class="text-center bg-dark text-white p-3">
        <h2>Bill Details (ID: <?php echo htmlspecialchars($bill['bill_id']); ?>)</h2>
    </header>

    <table class="table table-bordered mt-4">
        <tr><th>Total Amount (BDT)</th><td><?php echo htmlspecialchars($bill['total_amount']); ?></td></tr>
        <tr><th>Bill Date</th><td><?php echo htmlspecialchars($bill['bill_date']); ?></td></tr>
        <tr><th>Status</th><td><?php echo htmlspecialchars($bill['status']); ?></td></tr>
    </table>

    <h3 class="mt-4">Ordered Products</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price (BDT)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_products->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="text-center">
        <button class="btn btn-primary print-btn" onclick="window.print()">Print Bill</button>
        <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
