<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Agri Dashboard</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
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

        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-fluid p-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent px-4 px-lg-5 py-3 py-lg-0">
            <a href="index.php" class="navbar-brand p-0">
                <h1 class="display-6 text-primary m-0"><i class="fas fa-tractor me-3"></i>Agri Dashboard</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Dashboard</a>
                    <a href="about.php" class="nav-item nav-link">About Us</a>
                    <a href="services.php" class="nav-item nav-link">Services</a>
                    <a href="products.php" class="nav-item nav-link">Products</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
                <a href="login.php" class="btn btn-light border border-primary rounded-pill text-primary py-2 px-4 me-4">Log In</a>
                <a href="signup.php" class="btn btn-primary rounded-pill text-white py-2 px-4">Sign Up</a>
            </div>
        </nav>
        </div>
        <!-- Navbar & Hero End -->


         <!-- Header Start -->
         <div class="container-fluid bg-breadcrumb">
            <ul class="breadcrumb-animation">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="container text-center py-5" style="max-width: 900px;">
                <h3 class="display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Learn About Us</h1>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active text-primary">About</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->


        <!-- About Start -->
        <div class="container-fluid overflow-hidden py-5 mt-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="RotateMoveLeft">
                            <img src="img/about-1.png" class="img-fluid w-100" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <h4 class="mb-1 text-primary">Our Story</h4>
                        <h1 class="display-5 mb-4">Your Journey to Better Farming Starts Here</h1>
                        <p class="mb-4">We are committed to providing farmers with innovative solutions for their agricultural needs. With years of expertise, we aim to deliver products and services that enhance productivity and sustainability. Join us on this exciting journey!
                        </p>
                        <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Feature Start -->
        <div class="container-fluid feature overflow-hidden py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                    <h4 class="text-primary">Our Key Features</h4>
                    <h1 class="display-5 mb-4">Revolutionizing Farming Through Technology</h1>
                    <p class="mb-0">Our features include easy-to-use tools for better resource management, efficient crop production, and increased profitability. Explore the tools that make a difference in modern farming.
                    </p>
                </div>
                <div class="row g-4 justify-content-center text-center mb-5">
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="text-center p-4">
                            <div class="d-inline-block rounded bg-light p-4 mb-4"><i class="fas fa-envelope fa-5x text-secondary"></i></div>
                            <div class="feature-content">
                                <a href="#" class="h4">Email Notifications <i class="fa fa-long-arrow-alt-right"></i></a>
                                <p class="mt-4 mb-0">Stay updated with the latest news and alerts directly to your inbox.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="text-center p-4">
                            <div class="d-inline-block rounded bg-light p-4 mb-4"><i class="fas fa-mail-bulk fa-5x text-secondary"></i></div>
                            <div class="feature-content">
                                <a href="#" class="h4">Product Catalog <i class="fa fa-long-arrow-alt-right"></i></a>
                                <p class="mt-4 mb-0">Browse through our diverse range of agricultural products for your farm.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="text-center rounded p-4">
                            <div class="d-inline-block rounded bg-light p-4 mb-4"><i class="fas fa-sitemap fa-5x text-secondary"></i></div>
                            <div class="feature-content">
                                <a href="#" class="h4">Client Dashboard <i class="fa fa-long-arrow-alt-right"></i></a>
                                <p class="mt-4 mb-0">Monitor and track your farm's performance from the comfort of your dashboard.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="text-center rounded p-4">
                            <div class="d-inline-block rounded bg-light p-4 mb-4"><i class="fas fa-tasks fa-5x text-secondary"></i></div>
                            <div class="feature-content">
                                <a href="#" class="h4">Task Management <i class="fa fa-long-arrow-alt-right"></i></a>
                                <p class="mt-4 mb-0">Manage daily tasks and improve farm productivity with our intuitive tools.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="my-3">
                            <a href="#" class="btn btn-primary d-inline rounded-pill px-5 py-3">Explore More Features</a>
                        </div>
                    </div>
                </div>
                <div class="row g-5 pt-5" style="margin-top: 6rem;">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="feature-img RotateMoveLeft h-100" style="object-fit: cover;">
                            <img src="img/features-1.png" class="img-fluid w-100 h-100" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.1s">
                        <h4 class="text-primary">Our Vision</h4>
                        <h1 class="display-5 mb-4">Transforming Agriculture for a Better Future</h1>
                        <p class="mb-4">We believe in empowering farmers with the latest technologies and resources to ensure long-term success and sustainable farming practices.</p>
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="d-flex">
                                    <i class="fas fa-newspaper fa-4x text-secondary"></i>
                                    <div class="d-flex flex-column ms-3">
                                        <h2 class="mb-0 fw-bold">150+</h2>
                                        <small class="text-dark">Projects Completed</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex">
                                    <i class="fas fa-users fa-4x text-secondary"></i>
                                    <div class="d-flex flex-column ms-3">
                                        <h2 class="mb-0 fw-bold">5000+</h2>
                                        <small class="text-dark">Happy Customers</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->


        <!-- Blog Start -->
        <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                    <h4 class="text-primary">Our Latest News</h4>
                    <h1 class="display-5 mb-4">Stay Updated With Our Blog</h1>
                    <p class="mb-0">Get the latest trends, tips, and updates from the world of agriculture, technology, and farming innovation.</p>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="img/blog-1.png" class="img-fluid w-100" alt="">
                                <div class="blog-info">
                                    <span><i class="fa fa-clock"></i> Jan 15, 2025</span>
                                    <div class="d-flex">
                                        <span class="me-3"> 12 <i class="fa fa-heart"></i></span>
                                        <a href="#" class="text-white">5 <i class="fa fa-comment"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-content text-dark border p-4 ">
                                <h5 class="mb-4">How to Optimize Your Farm's Output</h5>
                                <p class="mb-4">Discover proven strategies for boosting productivity in your agricultural operations.</p>
                                <a class="btn btn-light rounded-pill py-2 px-4" href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="img/blog-2.png" class="img-fluid w-100" alt="">
                                <div class="blog-info">
                                    <span><i class="fa fa-clock"></i> Jan 12, 2025</span>
                                    <div class="d-flex">
                                        <span class="me-3"> 8 <i class="fa fa-heart"></i></span>
                                        <a href="#" class="text-white">3 <i class="fa fa-comment"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-content text-dark border p-4">
                                <h5 class="mb-4">Latest Trends in Agricultural Technology</h5>
                                <p class="mb-4">Explore how modern technology is reshaping farming practices and increasing yields.</p>
                                <a class="btn btn-light rounded-pill py-2 px-4" href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer py-5">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h3 class="text-primary mb-4">Contact</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2">Email: info@agridash.com</li>
                            <li class="mb-2">Phone: (123) 456-7890</li>
                            <li class="mb-2">Address: 123 Agri St, Farm City</li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h3 class="text-primary mb-4">Quick Links</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-white-50">Home</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50">About</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50">Services</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50">Products</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>

</html>
