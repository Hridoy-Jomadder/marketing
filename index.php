<?php
// Include the database connection
include 'db.php';

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agri E-Marketplace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .add-product {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Agri E-Marketplace</h1>
    
    <div class="add-product">
        <a href="add_product.php">Add New Product</a>
    </div>

    <h2>Available Products</h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Weight (kg)</th>
                    <th>Price (BDT)</th>
                    <th>Actions</th>
                </tr>";
        
        // Display each product
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>
                    <td>" . htmlspecialchars($row['image']) . "</td>
                    <td>{$row['weight']}</td>
                    <td>{$row['price']}</td>
                    <td>
                        <a href='edit_product.php?id={$row['id']}'>Edit</a> | 
                        <a href='delete_product.php?id={$row['id']}'>Delete</a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No products available.</p>";
    }

    // Close database connection
    $conn->close();
    ?>
</body>
</html>

