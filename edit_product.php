<?php
// Include database connection
include 'db.php';

// Get the product ID from the URL
$product_id = intval($_GET['id']);

// Fetch product details securely
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit();
}

// Handle form submission for updating product details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $weight = trim($_POST['weight']);
    $total_amount = $weight * $price;

    // Handle image upload
    $uploaded_image = $row['image']; // Default to current image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $uploaded_image = basename($_FILES['image']['name']);
    }

    // Update product in the database
    $sql = "UPDATE products SET name = ?, description = ?, price = ?, weight = ?, total_amount = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddisi", $name, $description, $price, $weight, $total_amount, $uploaded_image, $product_id);

    if ($stmt->execute()) {
        $success_message = "Product updated successfully!";
        header("Location: index.php?success=1");
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Product</h2>

    <!-- Display success or error messages -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        <div class="mb-3">
            <label for="name" class="form-label">Product Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($row['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Product Image:</label>
            <input type="file" id="image" name="image" class="form-control">
            <?php if (!empty($row['image'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image" class="mt-2" style="max-height: 100px;">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="weight" class="form-label">Weight (kg):</label>
            <input type="number" id="weight" name="weight" step="0.01" class="form-control" value="<?php echo $row['weight']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price (BDT):</label>
            <input type="number" id="price" name="price" step="0.01" class="form-control" value="<?php echo $row['price']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="index.php" class="btn btn-secondary">Back to Product List</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
