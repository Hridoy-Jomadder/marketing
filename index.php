<?php
// Include database connection file
include 'db.php';

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch products
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Check for errors in the query
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Pagination logic (if needed)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

// Get total number of products
$totalQuery = "SELECT COUNT(*) as total FROM products";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalProducts = $totalRow['total'];

// Total pages
$totalPages = ceil($totalProducts / $limit);

// Fetch paginated results
$query .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agri E-Marketplace</title>
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_product.php">Add Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="bill.php">Bill</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Available Products</h2>

        <?php if ($result && $result->num_rows > 0): ?>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Weight (kg)</th>
                        <th>Unit/Price (BDT)</th>
                        <th>Total Amount (BDT)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>
                                <img src="<?php echo "uploads/" . htmlspecialchars($row['image']); ?>" alt="Product Image" width="60">
                            </td>
                            <td><?php echo htmlspecialchars($row['weight']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo number_format($row['weight'] * $row['price'], 0); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_product.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <strong>No products available yet.</strong>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Agri E-Marketplace. All Rights Reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
