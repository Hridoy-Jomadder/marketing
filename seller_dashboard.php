<?php
session_start();

// Redirect to login if the user is not signed in or not a seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Seller') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch the seller's products (only the products of the logged-in seller)
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM products WHERE user_id = ? ORDER BY id DESC";
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
    <title>Seller Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .add-product {
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: blue;
        }
        a:hover {
            text-decoration: underline;
        }
        .action-links {
            display: flex;
            gap: 10px;
        }
        .logout {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Welcome, Seller</h1>
    <p>You have access to the seller dashboard.</p>

    <nav>
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="add_product.php">Add New Product</a>
        <a href="view_orders.php">View Orders</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>

    <h2>Your Products</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Weight (kg)</th>
                <th>Price (BDT)</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image" width="50"></td>
                    <td><?php echo $row['weight']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td>
                        <div class="action-links">
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No products available. <a href="add_product.php">Add a new product</a></p>
    <?php endif; ?>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <?php $conn->close(); ?>
</body>
</html>

