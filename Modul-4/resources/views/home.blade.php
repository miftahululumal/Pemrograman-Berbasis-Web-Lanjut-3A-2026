<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Perpustakaan</title>
    
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Top Header Green */
        .top-header {
            background-color: #1b4332;
            color: white;
            padding: 15px 0;
        }

        /* Navbar Style */
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* Hero Card Style */
        .hero-card {
            background-color: #d8f3dc;
            border-radius: 20px;
            padding: 40px;
            margin-top: 30px;
        }

        .hero-badge {
            background-color: #2d6a4f;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 6px 16px;
            border-radius: 50px;
        }

        .btn-green {
            background-color: #1b4332;
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-green:hover {
            background-color: #2d6a4f;
            color: white;
        }

        /* Animated Buttons */
        .btn-animated {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

    <!-- Header Atas Hijau (Perpustakaan Digital) -->
    <div class="top-header">
        <div class="container d-flex align-items-center gap-3">
            <span class="fs-3">📚</span>
            <div>
                <h4 class="m-0 fw-bold">Perpustakaan Digital</h4>
                <small class="opacity-75">Tempat menemukan berbagai koleksi buku</small>
            </div>
        </div>
    </div>

    <!-- Navbar Putih (Beranda, Daftar Buku, Login, Daftar) -->
    <nav class="navbar navbar-expand-lg navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-secondary" href="/">Perpustakaan</a>
            
            <div class="d-flex align-items-center gap-4">

                <!-- TOMBOL AUTENTIKASI BREEZE -->
                @if (Route::has('login'))
                    @auth
                        <!-- Jika User Sudah Login -->
                        <a href="{{ route('dashboard') }}" class="btn btn-green btn-animated">
                            Dashboard ({{ auth()->user()->getRoleNames()->first() ?? 'User' }})
                        </a>
                    @else
                        <!-- Jika Belum Login (Tamu) -->
                        <a href="{{ route('login') }}" class="btn btn-outline-success fw-bold rounded-pill px-4 btn-animated">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-success fw-bold rounded-pill px-4 btn-animated">
                                Daftar
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Content Utama -->
    <div class="container">
        
        <!-- Hero Section -->
        <div class="hero-card">
            <span class="hero-badge text-uppercase mb-3 d-inline-block">
                Selamat Datang
            </span>

            <h1 class="fw-bold text-dark display-5 mb-3">
                Selamat Datang di Perpustakaan Digital
            </h1>

            <p class="text-secondary fs-5 mb-4" style="max-width: 600px;">
                Temukan berbagai koleksi buku untuk menambah wawasan, pengetahuan, dan keterampilanmu.
            </p>

            <div class="d-flex gap-3">
                <a href="{{ route('buku.index') }}" class="btn btn-green btn-animated">
                    Lihat Daftar Buku
                </a>
            </div>
        </div>

        <!-- Section Tentang Perpustakaan -->
        <div class="my-5 text-center">
            <h2 class="fw-bold mb-4">Tentang Perpustakaan</h2>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="fs-1 mb-2">📖</div>
                        <h4 class="fw-bold">Koleksi Buku</h4>
                        <p class="text-secondary m-0">Berbagai buku tersedia untuk membantu proses belajar.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="fs-1 mb-2">💻</div>
                        <h4 class="fw-bold">Mudah Diakses</h4>
                        <p class="text-secondary m-0">Jelajahi daftar buku dengan tampilan yang sederhana.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="fs-1 mb-2">🎓</div>
                        <h4 class="fw-bold">Untuk Belajar</h4>
                        <p class="text-secondary m-0">Temukan referensi untuk mendukung kegiatan akademik.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>