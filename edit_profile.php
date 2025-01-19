<?php
session_start();
include 'db.php';

// Redirect to login if the user is not signed in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user details to pre-fill the form
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

// Update profile data if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $profile_image = $_FILES['profile_image']['name'];
    $target_file = $user['profile_image']; // Default to existing image

    // Handle file upload for profile image
    if ($profile_image) {
        $upload_dir = "uploads/$user_id/";

        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Define the target file path
        $file_extension = pathinfo($profile_image, PATHINFO_EXTENSION);
        $target_file = $upload_dir . "profile_image." . $file_extension;

        // Move the uploaded file
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            // Success
        } else {
            $_SESSION['error'] = "Failed to upload profile image.";
            header("Location: edit_profile.php");
            exit();
        }
    }

    // Update the user data in the database
    $update_sql = "UPDATE users SET full_name = ?, phone = ?, address = ?, profile_image = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssi", $full_name, $phone, $address, $target_file, $user_id);
    $stmt->execute();

    $_SESSION['success'] = "Profile updated successfully.";
    header("Location: profile.php");
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Profile</h1>

        <!-- Success and Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <textarea id="address" name="address" class="form-control"><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="division" class="form-label">Division:</label>
                <input type="text" id="division" name="division" class="form-control" value="<?php echo htmlspecialchars($user['division']); ?>">
            </div>

            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image" class="form-control">
                <?php if (!empty($user['profile_image'])): ?>
                    <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" class="mt-2" style="max-height: 100px;">
                <?php endif; ?>
            </div>


            <!-- <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <input type="text" id="role" name="role" class="form-control" value="<?php echo htmlspecialchars($user['role']); ?>" readonly>
            </div> -->

            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>