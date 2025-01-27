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

// Include database connection file
include 'db.php';

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all orders for the logged-in user
$sql = "SELECT o.id AS order_id, o.order_date, o.order_status, b.total_amount, b.bill_date
        FROM orders o
        JOIN bills b ON o.bill_id = b.id
        WHERE o.user_id = ?
        ORDER BY o.order_date DESC";  // Order by most recent orders first

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Your Orders</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Order Status</th>
                <th>Total Amount (BDT)</th>
                <th>Bill Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_status']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_amount']); ?></td>
                    <td><?php echo htmlspecialchars($row['bill_date']); ?></td>
                    <td>
                        <a href="bill.php?bill_id=<?php echo $row['order_id']; ?>" class="btn btn-info">View Bill</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
