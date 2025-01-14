<?php
include 'db.php';

// SQL to fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<h2>Product List</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image ID</th>
                <th>Weight</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Display each product
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . (!empty($row["name"]) ? $row["name"] : "Not Provided") . "</td>";
        echo "<td>" . (!empty($row["description"]) ? $row["description"] : "Not Provided") . "</td>";
        echo "<td>" . (!empty($row["image"]) ? $row["image"] : "Not Provided") . "</td>";
        echo "<td>" . $row["weight"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td><a href='edit_product.php?id=" . $row["id"] . "'>Edit</a> | 
                      <a href='delete_product.php?id=" . $row["id"] . "'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No products found.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <form method="POST">
        <label for="name">Product Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>
        
        <label for="image">Image ID or Filename:</label><br>
        <input type="text" id="image" name="image" required><br><br>
        
        <label for="weight">Weight:</label><br>
        <input type="number" id="weight" name="weight" required><br><br>
        
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" required><br><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
