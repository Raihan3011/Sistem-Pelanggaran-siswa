<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pelanggaran Siswa - SMK Bakti Nusantara 666</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/Logo_SMK.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --primary: #0ea5e9;
            --secondary: #38bdf8;
            --accent: #0284c7;
            --success: #10b981;
            --dark: #111827;
            --light: #f0f9ff;
            --gradient: linear-gradient(135deg, #0ea5e9, #38bdf8);
            --gradient-dark: linear-gradient(135deg, #0284c7, #0ea5e9);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #f8fbff;
            color: var(--dark);
            line-height: 1.7;
        }

        header {
            background: white;
            color: var(--dark);
            padding: 20px 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 15px rgba(14, 165, 233, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo i {
            font-size: 24px;
            color: var(--primary);
        }

        .school-name {
            display: flex;
            flex-direction: column;
        }

        .school-name h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .school-name span {
            font-size: 0.9rem;
            color: #64748b;
        }

        nav {
            display: flex;
            gap: 25px;
        }

        nav a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            padding: 8px 15px;
            border-radius: 8px;
            position: relative;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--gradient);
            transition: width 0.3s;
        }

        nav a:hover::after {
            width: 80%;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a[style*="background"] {
            background: var(--gradient) !important;
            color: white !important;
        }

        nav a[style*="background"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 80px;
            padding: 100px 80px;
            min-height: 85vh;
            background: linear-gradient(to right, #e0f2fe 0%, #bae6fd 100%);
            color: #0c4a6e;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -3%;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }



        .hero-content {
            text-align: left;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.8rem;
            font-weight: 600;
            margin-bottom: 25px;
            line-height: 1.3;
            color: #0c4a6e;
        }

        .hero p {
            font-size: 1.15rem;
            margin-bottom: 40px;
            line-height: 1.8;
            color: #075985;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            margin-top: 40px;
        }

        .hero-image {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-illustration {
            width: 100%;
            max-width: 500px;
            height: auto;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.2));
        }

        .cta-btn {
            padding: 14px 35px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: white;
            border: none;
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .cta-btn.secondary {
            background: white;
            border: 2px solid #0ea5e9;
            color: #0ea5e9;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.1);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.35);
        }

        .cta-btn.secondary:hover {
            background: #0ea5e9;
            color: white;
        }

        .features {
            padding: 90px 20px;
            background: white;
        }

        .section-title {
            text-align: left;
            font-size: 2.5rem;
            color: #0c4a6e;
            margin-bottom: 15px;
            font-weight: 600;
            padding: 0 80px;
        }

        .section-subtitle {
            text-align: left;
            font-size: 1.1rem;
            color: #64748b;
            margin: 0 0 60px;
            padding: 0 80px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 0 80px;
            max-width: 1400px;
            margin: 0 auto;
        }

        @media (max-width: 1200px) {
            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .card {
            background: white;
            padding: 35px 30px;
            border-radius: 16px;
            text-align: left;
            transition: all 0.3s;
            border: 1px solid #e0f2fe;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.12);
            border-color: #0ea5e9;
        }

        .card i {
            font-size: 42px;
            color: #0ea5e9;
            display: inline-block;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
        }

        .card h3 {
            font-size: 1.25rem;
            margin: 0;
            color: #0c4a6e;
            font-weight: 600;
            line-height: 1.4;
        }

        .card p {
            color: #64748b;
            line-height: 1.7;
            font-size: 0.95rem;
            margin: 0;
        }

        .stats {
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
            color: white;
            padding: 70px 20px;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .stat-item {
            padding: 20px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.05rem;
            opacity: 0.95;
        }

        .how-it-works {
            padding: 90px 20px;
            background: #f8fbff;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            max-width: 1000px;
            margin: 50px auto 0;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: var(--primary);
            z-index: 1;
        }

        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            margin: 0 auto 20px;
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.25);
            transition: all 0.3s;
        }

        .step:hover .step-number {
            transform: scale(1.08);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.35);
        }

        .step h3 {
            margin-bottom: 10px;
            color: #0c4a6e;
            font-weight: 600;
        }

        .step p {
            color: #64748b;
            max-width: 250px;
            margin: 0 auto;
            line-height: 1.6;
        }

        footer {
            background: #0c4a6e;
            color: white;
            padding: 60px 20px 25px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .footer-logo .logo {
            width: 40px;
            height: 40px;
        }

        .footer-logo h3 {
            font-size: 1.3rem;
        }

        .footer-links h4 {
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #374151;
            color: #9ca3af;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }
            
            .hero {
                grid-template-columns: 1fr;
                padding: 60px 20px;
                text-align: center;
            }

            .hero-content {
                text-align: center;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-image {
                display: none;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .section-title,
            .section-subtitle,
            .feature-grid {
                padding: 0 20px;
                text-align: center;
            }
            
            .cta-btn {
                width: 200px;
            }
            
            .feature-grid {
                grid-template-columns: 1fr;
            }

            .card {
                text-align: center;
            }

            .card i {
                margin: 0 auto 15px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .steps {
                flex-direction: column;
                gap: 40px;
            }
            
            .steps::before {
                display: none;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <div class="logo">
            <img src="{{ asset('storage/Logo_SMK.png') }}" alt="Logo SMK" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <i class="bi bi-mortarboard-fill" style="display: none;"></i>
        </div>
        <div class="school-name">
            <h2>SMK Bakti Nusantara 666</h2>
            <span>Teknologi & Inovasi</span>
        </div>
    </div>
    <nav>
        <a href="#home">Beranda</a>
        <a href="#features">Fitur</a>
        <a href="#how-it-works">Cara Kerja</a>
        <a href="#contact">Kontak</a>
        <a href="{{ route('login') }}" style="background: rgba(255,255,255,0.2);">Login</a>
    </nav>
</header>

<section class="hero" id="home">
    <div class="hero-content">
        <h1>Sistem Pelanggaran Siswa</h1>
        <p>Platform digital untuk memantau, mengelola dan mencatat pelanggaran siswa secara terstruktur dan real-time untuk menciptakan lingkungan belajar yang lebih baik.</p>
        
        <div class="cta-buttons">
            <button class="cta-btn" onclick="redirectToLogin()">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
            <button class="cta-btn secondary" onclick="redirectToRegister()">
                <i class="bi bi-person-plus"></i> Daftar
            </button>
        </div>
    </div>
    <div class="hero-image">
        <svg class="hero-illustration" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
            <circle cx="250" cy="250" r="200" fill="rgba(255,255,255,0.2)"/>
            <circle cx="250" cy="250" r="150" fill="rgba(255,255,255,0.3)"/>
            <circle cx="250" cy="250" r="100" fill="white"/>
            <path d="M250 180 L250 220 M230 200 L270 200" stroke="#0ea5e9" stroke-width="8" stroke-linecap="round"/>
            <circle cx="250" cy="280" r="40" fill="#0ea5e9"/>
            <rect x="210" y="320" width="80" height="100" rx="10" fill="#0ea5e9"/>
        </svg>
    </div>
</section>

<section class="features" id="features">
    <h2 class="section-title">Fitur Terbaik Sistem</h2>
    <p class="section-subtitle">Dilengkapi dengan berbagai fitur canggih untuk memudahkan pengelolaan pelanggaran siswa</p>

    <div class="feature-grid">
        <div class="card">
            <i class="bi bi-clipboard-data"></i>
            <h3>Pencatatan Digital</h3>
            <p>Pencatatan otomatis lebih cepat dan efisien dengan sistem digital yang terintegrasi.</p>
        </div>
        <div class="card">
            <i class="bi bi-speedometer"></i>
            <h3>Real-time Monitoring</h3>
            <p>Pantau grafik dan poin pelanggaran siswa secara real-time dengan dashboard interaktif.</p>
        </div>
        <div class="card">
            <i class="bi bi-bar-chart"></i>
            <h3>Laporan Analitik</h3>
            <p>Laporan otomatis terstruktur siap cetak dengan analisis data yang mendalam.</p>
        </div>
        <div class="card">
            <i class="bi bi-shield-shaded"></i>
            <h3>Keamanan Data</h3>
            <p>Sistem aman dengan level akses berbeda untuk setiap pengguna.</p>
        </div>
        <div class="card">
            <i class="bi bi-bell"></i>
            <h3>Notifikasi Sistem</h3>
            <p>Memberikan informasi ketika pelanggaran mencapai batas tertentu.</p>
        </div>
        <div class="card">
            <i class="bi bi-graph-up-arrow"></i>
            <h3>Prestasi Kontra-Poin</h3>
            <p>Prestasi siswa dapat mengurangi akumulasi poin pelanggaran.</p>
        </div>
    </div>
</section>

<section class="stats">
    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-number">1+</div>
            <div class="stat-label">Tahun Pengalaman</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">100%</div>
            <div class="stat-label">Sistem Digital</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">20+</div>
            <div class="stat-label">Guru Aktif</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Akses Online</div>
        </div>
    </div>
</section>

<section class="how-it-works" id="how-it-works">
    <h2 class="section-title">Cara Kerja Sistem</h2>
    <p class="section-subtitle">Proses sederhana dan efektif dalam mengelola pelanggaran siswa</p>

    <div class="steps">
        <div class="step">
            <div class="step-number">1</div>
            <h3>Input Data</h3>
            <p>Guru mencatat pelanggaran siswa melalui aplikasi web atau mobile</p>
        </div>
        <div class="step">
            <div class="step-number">2</div>
            <h3>Analisis Otomatis</h3>
            <p>Sistem menganalisis dan mengkategorikan pelanggaran secara otomatis</p>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <h3>Notifikasi</h3>
            <p>Orang tua dan wali kelas menerima notifikasi real-time</p>
        </div>
        <div class="step">
            <div class="step-number">4</div>
            <h3>Laporan</h3>
            <p>Generate laporan lengkap untuk evaluasi dan tindak lanjut</p>
        </div>
    </div>
</section>

<section class="features">
    <h2 class="section-title">Fitur Lengkap Sistem</h2>
    <p class="section-subtitle">Semua yang Anda butuhkan untuk mengelola pelanggaran siswa secara efektif</p>

    <div class="feature-grid">
        <div class="card">
            <i class="bi bi-eye"></i>
            <h3>Monitoring Pelanggaran</h3>
            <p>Pantau riwayat pelanggaran siswa secara real-time lengkap dengan poin dan kategori.</p>
        </div>
        <div class="card">
            <i class="bi bi-exclamation-triangle"></i>
            <h3>Data Sanksi Otomatis</h3>
            <p>Setiap poin pelanggaran terakumulasi hingga memunculkan kategori sanksi secara otomatis.</p>
        </div>
        <div class="card">
            <i class="bi bi-people"></i>
            <h3>Dashboard Orang Tua</h3>
            <p>Orang tua dapat memantau perkembangan dan pelanggaran anaknya dengan akses khusus.</p>
        </div>
        <div class="card">
            <i class="bi bi-trophy"></i>
            <h3>Prestasi Kontra-Poin</h3>
            <p>Prestasi siswa dapat mengurangi akumulasi poin pelanggaran sebagai bentuk reward.</p>
        </div>
        <div class="card">
            <i class="bi bi-clock-history"></i>
            <h3>Riwayat Terintegrasi</h3>
            <p>Semua data terhubung dengan siswa, wali kelas, dan BP sekolah dalam satu sistem.</p>
        </div>
        <div class="card">
            <i class="bi bi-chat-dots"></i>
            <h3>Notifikasi Sistem</h3>
            <p>Memberikan informasi real-time ketika pelanggaran mencapai batas tertentu.</p>
        </div>
    </div>
</section>

<footer id="contact">
    <div class="footer-content">
        <div class="footer-about">
            <div class="footer-logo">
                <div class="logo">
                    <img src="{{ asset('storage/Logo_SMK.png') }}" alt="Logo SMK" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <i class="bi bi-mortarboard-fill" style="display: none;"></i>
                </div>
                <h3>SMK Bakti Nusantara 666</h3>
            </div>
            <p>Sistem Pelanggaran Siswa yang dirancang untuk membantu sekolah dalam menciptakan lingkungan belajar yang disiplin dan kondusif.</p>
        </div>
        <div class="footer-links">
            <h4>Tautan Cepat</h4>
            <ul>
                <li><a href="#home">Beranda</a></li>
                <li><a href="#features">Fitur</a></li>
                <li><a href="#how-it-works">Cara Kerja</a></li>
                <li><a href="{{ route('register') }}">Daftar</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Kontak Kami</h4>
            <ul>
                <li><i class="bi bi-geo-alt"></i> Jl. Raya Percobaan No.65, Cileunyi Kulon, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40622</li>
                <li><i class="bi bi-telephone"></i> (021) 1234-5678</li>
                <li><i class="bi bi-envelope"></i> info@smkbn666.sch.id</li>
                <li><i class="bi bi-clock"></i> Senin - Jumat: 07.00 - 16.00</li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        © {{ date('Y') }} SMK Bakti Nusantara 666 | Sistem Pelanggaran Siswa. All rights reserved.
    </div>
</footer>

<script>
    // Fungsi untuk redirect ke halaman login
    function redirectToLogin() {
        window.location.href = '{{ route('login') }}';
    }

    // Fungsi untuk redirect ke halaman register
    function redirectToRegister() {
        window.location.href = '{{ route('register') }}';
    }

    // Animasi untuk tombol CTA
    document.querySelectorAll('.cta-btn').forEach(btn => {
        btn.addEventListener('mouseover', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        btn.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animasi scroll untuk card
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Terapkan animasi pada semua card
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });

    // Smooth scrolling untuk navigasi
    document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Tambahkan event listener untuk tombol login di header
    document.querySelector('nav a[href="{{ route('login') }}"]').addEventListener('click', function(e) {
        e.preventDefault();
        redirectToLogin();
    });
</script>

</body>
</html>