<?php
session_start();
include 'db.php';

// Check if the user is an Admin or Seller
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['Admin', 'Seller'])) {
    header("Location: login.php");
    exit();
}

// Fetch orders from the database
$sql = "SELECT orders.id, orders.customer_name, orders.product_name, orders.quantity, orders.total_price, orders.order_status, orders.order_date 
        FROM orders ORDER BY orders.order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        a {
            text-decoration: none;
            color: blue;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>View Orders</h1>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price (BDT)</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . htmlspecialchars($row['customer_name']) . "</td>
                        <td>" . htmlspecialchars($row['product_name']) . "</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['total_price']}</td>
                        <td>{$row['order_status']}</td>
                        <td>{$row['order_date']}</td>
                        <td>
                            <a href='update_order_status.php?id={$row['id']}'>Update Status</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No orders found.</td></tr>";
        }

        $conn->close();
        ?>

    </table>
    <br>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
