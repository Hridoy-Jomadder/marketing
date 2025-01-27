<?php
// Include database connection
include 'db.php';

// Secure session handling
session_set_cookie_params(['httponly' => true]);
session_start();
session_regenerate_id(true);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user ID
$user_id = $_SESSION['user_id'];

// Pagination settings
$limit = 10; // Number of orders per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch all orders for the logged-in user with pagination
$sql = "SELECT o.id AS order_id, o.product_name, o.quantity, 
               o.total_price, o.order_status, o.order_date,
               b.id AS bill_id, b.total_amount, b.bill_date
        FROM orders o
        LEFT JOIN bills b ON o.bill_id = b.id
        WHERE o.user_id = ?
        LIMIT ?, ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Fetch total orders count for pagination
$count_sql = "SELECT COUNT(*) AS total FROM orders WHERE user_id = ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_orders = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_orders / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Agri E-Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        header {
            background: linear-gradient(90deg, #007bff, #6c63ff);
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        .table { margin-top: 20px; font-size: 1rem; }
        .pagination { justify-content: center; margin-top: 20px; }
        footer { margin-top: 50px; background-color: #f8f9fa; padding: 20px; text-align: center; }
        .text-warning { color: orange; }
        .text-success { color: green; }
        .text-danger { color: red; }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to the Agri E-Marketplace</h1>
        <p>Find and manage agricultural products with ease.</p>
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

<table class="table table-bordered table-striped mt-4">
<thead class="table-dark">
    <tr>
        <th>Order ID</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Total Price (BDT)</th>
        <th>Order Status</th>
        <th>Order Date</th>
    </tr>
</thead>
<tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['total_price']); ?></td>
            <td class="<?php echo ($row['order_status'] == 'Pending') ? 'text-warning' : (($row['order_status'] == 'Completed') ? 'text-success' : 'text-danger'); ?>">
                <?php echo htmlspecialchars($row['order_status']); ?>
            </td>
            <td><?php echo date("d M Y, h:i A", strtotime($row['order_date'])); ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>

<p class="text-center"><a href="index.php" class="btn btn-primary">Back to Home</a></p>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
