<?php
session_start();
include 'db.php';

// Redirect to login if the user is not signed in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ensure the database connection exists
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Pagination setup
$limit = 10; // Number of products per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch paginated products
$stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Fetch total product count
$totalSql = "SELECT COUNT(*) AS total FROM products";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agri E-Marketplace</title>
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h1>Welcome to the Agri E-Marketplace</h1>
    </div>

    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>    
        <?php if (!empty($_SESSION['role']) && ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Seller')): ?>
            <a href="add_product.php">Add New Product</a>
        <?php endif; ?>
        <a href="view_orders.php">View Products</a>
        <a href="new_order.php">New Order</a>
        <a href="bill.php">Bill</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">Logout</a>
    </div>

    <div class="content">
        <h2>Available Products</h2>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
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
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>
                                <?php
                                    $imagePath = "uploads/" . htmlspecialchars($row['image']);
                                    if (!file_exists($imagePath)) {
                                        $imagePath = "img/default-image.jpg"; // Placeholder image
                                    }
                                ?>
                                <img src="<?php echo $imagePath; ?>" alt="Product Image" width="50">
                            </td>
                            <td><?php echo htmlspecialchars($row['weight']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td>
                                <div class="action-links">
                                    <?php if (!empty($_SESSION['role']) && ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Seller')): ?>
                                        <a href="edit_product.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                                        <a href="delete_product.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

            <!-- Pagination Links -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php else: ?>
            <p class="no-products">No products available.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
