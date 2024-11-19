<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedAsset - Healthcare Asset Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #10B981;
            --dark-green: #059669;
            --light-green: #D1FAE5;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/api/placeholder/1920/1080') center/cover;
            opacity: 0.1;
        }

        .floating-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            backdrop-filter: blur(10px);
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: var(--light-green);
            color: var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background: var(--primary-green);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-green);
        }

        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .circle-decoration {
            position: absolute;
            border-radius: 50%;
            background: var(--light-green);
            opacity: 0.3;
            z-index: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-transparent">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="#">
                <i class="fas fa-hospital me-2"></i>MedAsset
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#stats">Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light ms-2 fw-500" href="/login">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center position-relative">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="floating-card">
                        <h1 class="display-4 fw-bold mb-4" style="color: var(--dark-green)">
                            Manajemen Aset Medis Modern
                        </h1>
                        <p class="lead mb-4 text-muted">
                            Tingkatkan efisiensi pengelolaan aset elektronik rumah sakit Anda dengan sistem manajemen yang terintegrasi dan modern.
                        </p>
                        <div class="d-flex gap-3">
                            <a href="/register" class="btn btn-primary btn-lg">
                                <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                            </a>
                            <a href="#demo" class="btn btn-outline-dark btn-lg">
                                <i class="fas fa-play me-2"></i>Lihat Demo
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src={{asset('img/dashboard.png')}} alt="Dashboard Preview" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light" id="features">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-uppercase fw-bold" style="color: var(--primary-green)">Fitur Unggulan</h6>
                <h2 class="display-5 fw-bold mb-4">Solusi Lengkap untuk Aset Medis Anda</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Monitoring Real-time</h4>
                        <p class="text-muted mb-0">Pantau status dan performa peralatan medis secara real-time dengan dashboard interaktif.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Maintenance Terjadwal</h4>
                        <p class="text-muted mb-0">Kelola jadwal perawatan dan kalibrasi peralatan dengan sistem pengingat otomatis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-file-medical-alt fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Laporan Digital</h4>
                        <p class="text-muted mb-0">Generate laporan komprehensif dan analisis performa aset dengan sekali klik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5" id="stats">
        <div class="container py-5">
            <div class="row g-4 justify-content-center">
                <div class="col-md-3 text-center">
                    <div class="stat-number">98%</div>
                    <p class="text-muted">Tingkat Akurasi</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="stat-number">50+</div>
                    <p class="text-muted">Rumah Sakit Partner</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="stat-number">24/7</div>
                    <p class="text-muted">Monitoring Support</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="stat-number">1000+</div>
                    <p class="text-muted">Aset Terkelola</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-4">Siap Mengoptimalkan Aset Medis Anda?</h2>
                    <p class="lead text-muted mb-4">Bergabung dengan lebih dari 50 rumah sakit yang telah menggunakan sistem kami</p>
                    <a href="/register" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-paper-plane me-2"></i>Mulai 30 Hari Trial Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-4 border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <a class="navbar-brand" href="#" style="color: var(--primary-green)">
                        <i class="fas fa-hospital me-2"></i>MedAsset
                    </a>
                    <p class="text-muted mb-0 mt-2">Sistem Manajemen Aset Medis Modern</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="text-muted">
                        © 2024 MedAsset. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>