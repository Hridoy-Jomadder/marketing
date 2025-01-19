<?php
session_start();
include 'db.php';

// Redirect to login if the user is not signed in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch bills associated with the user
$sql = "SELECT * FROM bills WHERE user_id = ? ORDER BY bill_date DESC";
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
    <title>Bill Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Header Style */
        header {
            background: linear-gradient(90deg, #007bff, #6c63ff);
            color: white;
            padding: 2rem 0;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-link.active {
            font-weight: bold;
            color: #f0ad4e !important;
        }

        .table {
            margin-top: 20px;
            font-size: 1rem;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        footer {
            margin-top: 50px;
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Your Bills</h1>
        <p>View and manage your payment details with ease.</p>
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
                    <li class="nav-item"><a class="nav-link" href="view_orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link active" href="bill.php">Bill</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Your Bills</h2>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Bill ID</th>
                            <th>Date</th>
                            <th>Total Amount (BDT)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['bill_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['total_amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td>
                                    <a href="view_bill.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary btn-sm">View</a>
                                    <?php if ($row['status'] === 'Unpaid'): ?>
                                        <a href="pay_bill.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-success btn-sm">Pay</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <strong>No bills available yet.</strong>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <footer>
        <p>&copy; 2025 Agri E-Marketplace. All Rights Reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
