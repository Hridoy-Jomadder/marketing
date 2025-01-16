<?php
session_start();
include 'db.php';

// Redirect to login if the user is not signed in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details to display
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);

    // Image upload handling
    $profile_image = $user['profile_image']; // Retain current image if no new upload
    $upload_dir = "uploads/user_$user_id/"; // Directory for this user

    // Ensure the user folder exists
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (!empty($_FILES['profile_image']['name'])) {
        $image_name = basename($_FILES['profile_image']['name']);
        $unique_image_name = uniqid("img_") . "_" . $image_name;
        $target_file = $upload_dir . $unique_image_name;

        // Validate file type (only allow image files)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array(mime_content_type($_FILES['profile_image']['tmp_name']), $allowed_types)) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $profile_image = $target_file;
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Invalid image format.";
        }
    }

    // Hash password if updated
    $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user['password'];

    // Update user data in the database
    $update_sql = "UPDATE users SET email = ?, full_name = ?, phone = ?, address = ?, password = ?, profile_image = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $email, $full_name, $phone, $address, $hashed_password, $profile_image, $user_id);

    if ($update_stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $update_stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
    <style>
    .profile-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin-top: 20px;
    }

    .profile-container img {
        border-radius: 50%;
        margin-bottom: 20px;
    }

    .profile-container p {
        margin: 5px 0;
        font-size: 18px;
    }

    .profile-container a {
        display: inline-block;
        margin-top: 10px;
        font-size: 16px;
        text-decoration: none;
        color: #007bff;
    }
</style>

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

    <h1>Profile</h1>

<div class="profile-container">
    <?php if (!empty($user['profile_image']) && file_exists($user['profile_image'])): ?>
        <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" width="150">
    <?php else: ?>
        <p>No profile image available.</p>
    <?php endif; ?>

    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>

    <a href="seller_dashboard.php">Back to Dashboard</a>
    <a href="logout.php">Logout</a>
</div>

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
