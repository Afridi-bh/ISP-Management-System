<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BetterNet - ISP Billing System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background: #f8f9fa;
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 800;
            color: #667eea;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
        }

        .nav-link {
            color: #2d3436;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #667eea;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            font-weight: 600;
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 120px 0 80px;
            text-align: center;
        }

        .hero-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .hero-icon i {
            font-size: 3.5rem;
            color: white;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.95;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-hero-primary {
            background: white;
            color: #667eea;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: #667eea;
        }

        .btn-hero-secondary {
            background: transparent;
            color: white;
            border: 3px solid white;
        }

        .btn-hero-secondary:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 900;
            color: #2d3436;
            margin-bottom: 15px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #636e72;
            margin-bottom: 60px;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            height: 100%;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: white;
        }

        .icon-purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .icon-blue { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .icon-green { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .icon-orange { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .icon-red { background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); }
        .icon-teal { background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%); }

        .feature-card h3 {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: #2d3436;
        }

        .feature-card p {
            color: #636e72;
            line-height: 1.7;
            margin: 0;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .stats-section h2 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 60px;
        }

        .stat-item {
            margin-bottom: 30px;
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            backdrop-filter: blur(10px);
        }

        .stat-label {
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* CTA Section */
        .cta-section {
            background: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 900;
            color: #2d3436;
            margin-bottom: 20px;
        }

        .cta-section p {
            font-size: 1.2rem;
            color: #636e72;
            margin-bottom: 40px;
        }

        /* Footer */
        .footer {
            background: #2d3436;
            color: white;
            padding: 40px 0 20px;
            text-align: center;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 900;
        }

        .footer-description {
            color: #b2bec3;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .footer-link {
            color: #b2bec3;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .footer-link:hover {
            color: #667eea;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            color: #b2bec3;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }
            .hero-section p {
                font-size: 1.1rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            .btn-hero {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <div class="logo-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <span>BetterNet</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="/login" class="btn btn-login">
                            <i class="fas fa-lock me-2"></i>Admin Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-icon">
                <i class="fas fa-network-wired"></i>
            </div>
            <h1>ISP Billing & Management System</h1>
            <p>Complete solution for modern Internet Service Providers</p>
            <div class="hero-buttons">
                <a href="/login" class="btn-hero btn-hero-primary">
                    <i class="fas fa-user-shield"></i>
                    <span>Admin Portal</span>
                </a>
                <a href="/customer/login" class="btn-hero btn-hero-secondary">
                    <i class="fas fa-user"></i>
                    <span>Customer Portal</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Powerful Features</h2>
            <p class="section-subtitle">Everything you need to manage your ISP business</p>
            
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon icon-purple">
                            <i class="fas fa-server"></i>
                        </div>
                        <h3>Mikrotik Integration</h3>
                        <p>Seamlessly manage multiple routers with full Mikrotik API support, real-time monitoring, and complete network control from a single dashboard.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon icon-blue">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h3>Multiple Payment Gateways</h3>
                        <p>Accept payments via Cash, Stripe, and bKash with instant confirmation, automated receipts, and comprehensive payment tracking.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon icon-green">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h3>Automated Billing</h3>
                        <p>Generate invoices instantly with one-click billing, automated cycles, email reminders, and PDF generation for all customers.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon icon-orange">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3>Dual Portal System</h3>
                        <p>Separate admin and customer portals with role-based access, comprehensive dashboards, and self-service capabilities.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon icon-red">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>Support Tickets</h3>
                        <p>Efficient ticket management system with status tracking, email notifications, priority levels, and complete issue resolution.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon icon-teal">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Reports & Analytics</h3>
                        <p>Track revenue, user analytics, payment reports, and export data to PDF/Excel for comprehensive business insights.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" id="about">
        <div class="container">
            <h2>Why Choose BetterNet?</h2>
            
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="stat-label">Fast & Efficient</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="stat-label">Secure & Reliable</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="stat-label">Mobile Responsive</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-label">24/7 Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Get Started?</h2>
            <p>Transform your ISP business with our comprehensive billing solution</p>
            <div class="hero-buttons">
                <a href="/login" class="btn-hero btn-hero-primary">
                    <i class="fas fa-user-shield"></i>
                    <span>Access Admin Portal</span>
                </a>
                <a href="/customer/login" class="btn-hero btn-hero-secondary">
                    <i class="fas fa-user"></i>
                    <span>Customer Login</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-logo">
                <div class="footer-logo-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <span class="footer-brand">BetterNet</span>
            </div>
            <p class="footer-description">
                Complete Billing & Management Solution for Internet Service Providers
            </p>
            <div class="footer-links">
                <a href="/login" class="footer-link">Admin Portal</a>
                <a href="/customer/login" class="footer-link">Customer Portal</a>
                <a href="#features" class="footer-link">Features</a>
                <a href="#about" class="footer-link">About</a>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; 2024 BetterNet ISP Billing System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>