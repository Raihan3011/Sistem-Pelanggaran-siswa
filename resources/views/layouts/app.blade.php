<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pelanggaran Siswa - SMK Bakti Nusantara 666')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        /* CSS dari welcome.blade.php */
        :root {
            --primary: #1d4ed8;
            --secondary: #60a5fa;
            --accent: #f59e0b;
            --success: #10b981;
            --dark: #111827;
            --light: #f3f4f6;
            --gradient: linear-gradient(135deg, #1e3a8a, #3b82f6);
            --gradient-accent: linear-gradient(135deg, #f59e0b, #f97316);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        /* Tambahkan semua CSS dari welcome.blade.php di sini */
        /* ... (copy semua CSS dari welcome.blade.php) ... */
        
    </style>
    @stack('styles')
</head>
<body>
    @include('layouts.navigation')
    
    <main>
    </main>

    <!-- Footer dari welcome.blade.php -->
    <footer>
        <div class="footer-content">
            <div class="footer-about">
                <div class="footer-logo">
                    <div class="logo">
                        <i class="bi bi-mortarboard-fill"></i>
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

    @stack('scripts')
</body>
</html>