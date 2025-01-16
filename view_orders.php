<?php
session_start();
include 'db.php';

// Redirect to login if the user is not signed in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ensure the database is selected
$conn->select_db('family_data');

// Query to fetch orders
$sql = "SELECT o.id, o.user_id, o.order_date, o.status, o.total_price, o.shipping_address, o.payment_method 
        FROM orders o 
        WHERE o.user_id = ?";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h1>Your Orders</h1>";
        while ($row = $result->fetch_assoc()) {
            echo "Order ID: " . htmlspecialchars($row['id']) . "<br>";
            echo "Order Date: " . htmlspecialchars($row['order_date']) . "<br>";
            echo "Status: " . htmlspecialchars($row['status']) . "<br>";
            echo "Total Price: $" . htmlspecialchars($row['total_price']) . "<br>";
            echo "Shipping Address: " . htmlspecialchars($row['shipping_address']) . "<br>";
            echo "Payment Method: " . htmlspecialchars($row['payment_method']) . "<br><hr>";
        }
    } else {
        echo "No orders found.";
    }

    $stmt->close();
} else {
    echo "SQL Error: " . $conn->error;
}

$conn->close();
?>

<a href="seller_dashboard.php">Back to Dashboard</a><br>
<a href="logout.php">Logout</a>
