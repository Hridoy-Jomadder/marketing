<?php
// Start session to track logged-in user
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header('Location: login.php');
    exit();
}

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Include database connection file
include 'db.php';

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Pagination variables
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query to fetch products for the logged-in user with pagination
$query = "SELECT * FROM products WHERE user_id = ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $user_id, $limit, $offset); // Bind the user_id, limit, and offset
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Agri Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Agriculture Dashboard, Management, Tools" name="keywords">
    <meta content="Manage your agriculture projects efficiently with our dashboard" name="description">

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

    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> -->
    <!-- Spinner End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid header position-relative overflow-hidden p-0">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="index.php" class="navbar-brand p-0">
                <h1 class="display-6 text-primary m-0"><i class="fas fa-tractor me-3"></i>AgriDashboard</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Dashboard</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="service.php" class="nav-item nav-link">Services</a>
                    <a href="products.php" class="nav-item nav-link">Products</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
                <!-- <a href="login.php" class="btn btn-light border border-primary rounded-pill text-primary py-2 px-4 me-4">Log In</a>
                <a href="signup.php" class="btn btn-primary rounded-pill text-white py-2 px-4">Sign Up</a> -->
            </div>
        </nav>

        <!-- Hero Header Start -->
        <div class="hero-header overflow-hidden px-5">
            <div class="rotate-img">
                <img src="img/agri-bg.png" class="img-fluid w-100" alt="Agriculture Background">
            </div>
            <div class="row gy-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h1 class="display-4 text-dark mb-4">Empower Your Agriculture Business</h1>
                    <p class="fs-4 mb-4">Power your agribusiness
                    Increase sales and productivity of your agricultural products with cutting-edge agribusiness and data insights. follow my text</p>
                    <a href="products.php" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <img src="img/dashboard-preview.png" class="img-fluid w-100 h-100" alt="Dashboard Preview">
                </div>
            </div>
        </div>
        <!-- Hero Header End -->
    </div>
    <!-- Navbar & Hero End -->

    <!-- About Start -->
    <div class="container-fluid overflow-hidden py-5" style="margin-top: 6rem;">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <img src="img/about-dashboard.png" class="img-fluid w-100" alt="About Dashboard">
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h4 class="mb-1 text-primary">About AgriDashboard</h4>
                    <h1 class="display-5 mb-4">Streamline Agriculture Management</h1>
                    <p class="mb-4">Our platform enables farmers and agricultural managers to track, manage, and optimize their operations in real-time.</p>
                    <a href="about.php" class="btn btn-primary rounded-pill py-3 px-5">Learn More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Service Start -->
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                <h4 class="mb-1 text-primary">Our Services</h4>
                <h1 class="display-5 mb-4">What We Offer</h1>
                <p class="mb-0">From crop management to market analytics, AgriDashboard provides the tools you need to succeed in agriculture.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center rounded p-4">
                        <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><i class="fas fa-seedling fa-5x text-secondary"></i></div>
                        <div class="service-content">
                            <h4 class="mb-4">Crop Monitoring</h4>
                            <p>Track and analyze crop health to maximize yields and reduce waste.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center rounded p-4">
                        <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><i class="fas fa-chart-line fa-5x text-secondary"></i></div>
                        <div class="service-content">
                            <h4 class="mb-4">Market Insights</h4>
                            <p>Access up-to-date market trends and pricing for better decision-making.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center rounded p-4">
                        <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><i class="fas fa-tractor fa-5x text-secondary"></i></div>
                        <div class="service-content">
                            <h4 class="mb-4">Equipment Tracking</h4>
                            <p>Monitor and maintain your farming equipment effortlessly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- ই-মার্কেটপ্লেস পরিকল্পনা -->
    <div class="container-fluid py-5 bg-light">
        <div class="container">
            <h3 class="text-center text-primary mb-4">ই-মার্কেটপ্লেস পরিকল্পনা</h3>
            <p class="text-center text-muted mb-5">তারিখ: <span id="currentDate"></span></p>
            <ul>
                <li><strong>পণ্যের সংগ্রহ ও সরবরাহ</strong>: স্থানীয় কৃষকদের সঙ্গে সরাসরি চুক্তি নিশ্চিত করা...</li>
                <li><strong>পণ্যের ক্যাটাগরি</strong>: পণ্যগুলোকে শ্রেণিবদ্ধ করে সহজে খুঁজে পাওয়ার ব্যবস্থা...</li>
                <li><strong>প্ল্যাটফর্মের ফিচার</strong>: বিস্তারিত পণ্যের তালিকা, অর্ডার ট্র্যাকিং, নিরাপদ পেমেন্ট...</li>
                <li><strong>ব্যবসায়িক মডেল</strong>: বিক্রয় থেকে কমিশন, সাবস্ক্রিপশন মডেল...</li>
                <li><strong>মার্কেটিং পরিকল্পনা</strong>: সোশ্যাল মিডিয়া প্রচারণা, স্থানীয় প্রচারণা...</li>
            </ul>

        </div>
    </div>
    <!-- JavaScript to Add Date -->
    <script>
        document.getElementById("currentDate").textContent = new Date().toLocaleDateString('bn-BD');
    </script>


</body>

</html>
