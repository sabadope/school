<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TCU-Connect</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <style>
            .hero-section {
                background-color: #f8f9fa;
                padding: 120px 0;
                margin-bottom: 60px;
            }
            .feature-card {
                border: 1px solid #dee2e6;
                border-radius: 12px;
                padding: 40px 25px;
                margin-bottom: 30px;
                transition: all 0.3s ease;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                background: #fff;
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 16px rgba(0,0,0,0.1);
                border-color: #0d6efd;
            }
            .feature-icon {
                font-size: 3rem;
                margin-bottom: 25px;
                color: #0d6efd;
                background: rgba(13, 110, 253, 0.1);
                width: 80px;
                height: 80px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: all 0.3s ease;
            }
            .feature-card:hover .feature-icon {
                background: #0d6efd;
                color: #fff;
            }
            .feature-card h5 {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 15px;
                color: #212529;
            }
            .feature-card p {
                font-size: 0.95rem;
                line-height: 1.6;
                color: #6c757d;
                margin: 0;
            }
            .navbar {
                padding: 15px 0;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .navbar-brand {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .navbar-brand img {
                height: 40px;
                width: auto;
            }
            .hero-content {
                padding-right: 40px;
            }
            .hero-image {
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                height: 400px;
                background-image: url('{{ asset('assets/img/TCU-LOGO.jpg') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-color: #fff;
                width: 100%;
                object-fit: cover;
            }
            .section-title {
                margin-bottom: 60px;
                position: relative;
                padding-bottom: 15px;
            }
            .section-title:after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 3px;
                background-color: #0d6efd;
            }
            .features-section {
                padding: 100px 0;
                background-color: #f8f9fa;
            }
            .btn-lg {
                padding: 12px 30px;
            }
            .footer {
                background-color: #f8f9fa;
                padding: 40px 0;
                margin-top: 60px;
            }
            .footer-links {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .footer-links li {
                margin-bottom: 10px;
            }
            .footer-links a {
                color: #6c757d;
                text-decoration: none;
                transition: color 0.3s;
            }
            .footer-links a:hover {
                color: #0d6efd;
            }
            .social-links {
                display: flex;
                gap: 15px;
                margin-top: 20px;
            }
            .social-links a {
                color: #6c757d;
                font-size: 1.5rem;
                transition: color 0.3s;
            }
            .social-links a:hover {
                color: #0d6efd;
            }
            @media (max-width: 991.98px) {
                .hero-content {
                    padding-right: 0;
                    margin-bottom: 40px;
                    text-align: center;
                }
                .hero-section {
                    padding: 80px 0;
                }
                .d-flex.gap-3 {
                    justify-content: center;
                }
            }
        </style>
    </head>
    
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    <span class="fw-bold">TCU-Connect</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item me-4">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item me-4">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('apply') }}" class="btn btn-primary">
                                <i class="bi bi-mortarboard" style="margin-right: 5px;"></i> Apply Now
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section" id="home">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 hero-content">
                        <h1 class="display-4 fw-bold mb-4">Welcome to TCU-Connect</h1>
                        <p class="lead mb-5">Connect, Learn, and Grow Together</p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('apply') }}" class="btn btn-primary btn-lg">Get Started</a>
                            <a href="#features" class="btn btn-outline-primary btn-lg">Learn More</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section" id="features">
            <div class="container">
                <h2 class="text-center section-title">Our Services</h2>
                <div class="row g-4">
                    <!-- Student Portal -->
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <h5>Student Portal</h5>
                            <p>Your all-in-one platform for academic success and personal growth.</p>
                        </div>
                    </div>
                    <!-- Teacher Dashboard -->
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <h5>Teacher Dashboard</h5>
                            <p>Empower your teaching with smart tools and seamless communication.</p>
                        </div>
                    </div>
                    <!-- Department Management -->
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <h5>Department Section</h5>
                            <p>Streamlined solutions for efficient academic administration.</p>
                        </div>
                    </div>
                    <!-- Financial Management -->
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <h5>Financial Management</h5>
                            <p>Simplified financial operations for better resource management.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <h5 class="mb-3">TCU-Connect</h5>
                        <p class="text-muted">Empowering education through technology and innovation.</p>
                        <div class="social-links">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <h5 class="mb-3">Quick Links</h5>
                        <ul class="footer-links">
                            <li><a href="#home">Home</a></li>
                            <li><a href="#features">Features</a></li>
                            <li><a href="{{ route('apply') }}">Apply Now</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="mb-3">Contact Us</h5>
                        <ul class="footer-links">
                            <li><i class="bi bi-geo-alt me-2"></i> 123 Education St, City</li>
                            <li><i class="bi bi-telephone me-2"></i> (123) 456-7890</li>
                            <li><i class="bi bi-envelope me-2"></i> info@tcu-connect.com</li>
                        </ul>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center text-muted">
                    <small>&copy; 2024 TCU-Connect. All rights reserved.</small>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html> 