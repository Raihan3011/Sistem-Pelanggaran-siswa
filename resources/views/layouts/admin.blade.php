<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Pelanggaran Siswa</title>
    @include('layouts.favicon')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @stack('styles')
    <style>
        :root {
            --primary: #1d4ed8;
            --secondary: #60a5fa;
            --success: #10b981;
            --warning: #0891b2;
            --danger: #ef4444;
            --dark: #111827;
            --light: #f8fafc;
            --sidebar-width: 280px;
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
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0ea5e9 0%, #0284c7 100%);
            box-shadow: 2px 0 20px rgba(0,0,0,0.2);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            overflow: hidden;
            background: transparent;
        }
        
        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: transparent;
        }
        
        .logo-icon i {
            color: var(--primary);
        }

        .logo-text h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
        }

        .logo-text span {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.7);
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            margin: 0 10px;
            border-radius: 10px;
        }

        .nav-link:hover {
            background: rgba(56, 189, 248, 0.2);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            color: white;
            border-left-color: transparent;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
        }

        .nav-link i {
            font-size: 18px;
            width: 20px;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(14, 165, 233, 0.3);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
        }

        .header-title p {
            color: rgba(255,255,255,0.9);
            margin-top: 5px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0ea5e9;
            font-weight: 600;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .content-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .table th {
            background: var(--light);
            font-weight: 600;
            color: var(--dark);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <img src="{{ asset('storage/Logo_SMK.png') }}" alt="Logo SMK" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <i class="bi bi-mortarboard-fill" style="display: none;"></i>
                    </div>
                    <div class="logo-text">
                        <h3>SMK Bakti Nusantara</h3>
                        @php
                            $panelName = 'Panel';
                            if (auth()->user()->level == 'orang_tua') {
                                $panelName = 'Portal Orang Tua';
                            } elseif (auth()->user()->level == 'admin') {
                                $panelName = 'Admin Panel';
                            } elseif (auth()->user()->level == 'kesiswaan') {
                                $panelName = 'Kesiswaan Panel';
                            } elseif (auth()->user()->level == 'bk') {
                                $panelName = 'Guru BK Panel';
                            } elseif (auth()->user()->level == 'kepsek') {
                                $panelName = 'Kepala Sekolah Panel';
                            } elseif (auth()->user()->level == 'guru') {
                                $panelName = 'Guru Panel';
                            } elseif (auth()->user()->level == 'wali_kelas') {
                                $panelName = 'Wali Kelas Panel';
                            }
                        @endphp
                        <span>{{ $panelName }}</span>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                @php
                    $isOrangTua = \App\Models\OrangTua::where('user_id', auth()->id())->exists();
                    $isAdmin = auth()->user()->level == 'admin';
                @endphp
                
                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </div>
                
                @if($isAdmin)
                {{-- Admin memiliki akses ke semua menu --}}
                <div class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Data Siswa
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('orang-tua.index') }}" class="nav-link {{ request()->routeIs('orang-tua.*') ? 'active' : '' }}">
                        <i class="bi bi-person-hearts"></i>
                        Data Orang Tua
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link {{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('jenis-pelanggaran.index') }}" class="nav-link {{ request()->routeIs('jenis-pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-list-check"></i>
                        Jenis Pelanggaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('jenis-sanksi.index') }}" class="nav-link {{ request()->routeIs('jenis-sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i>
                        Jenis Sanksi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('wali-kelas.index') }}" class="nav-link {{ request()->routeIs('wali-kelas.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i>
                        Wali Kelas
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('prestasi.index') }}" class="nav-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}">
                        <i class="bi bi-trophy"></i>
                        Prestasi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('jenis-prestasi.index') }}" class="nav-link {{ request()->routeIs('jenis-prestasi.*') ? 'active' : '' }}">
                        <i class="bi bi-award"></i>
                        Jenis Prestasi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('guru.index') }}" class="nav-link {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                        <i class="bi bi-person-video3"></i>
                        Data Guru
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-person-gear"></i>
                        Pengguna
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('tahun-ajaran.index') }}" class="nav-link {{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-range"></i>
                        Tahun Ajaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                        <i class="bi bi-door-open"></i>
                        Data Kelas
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('bimbingan-konseling.index') }}" class="nav-link {{ request()->routeIs('bimbingan-konseling.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-heart"></i>
                        Bimbingan Konseling
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Laporan
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('backup.index') }}" class="nav-link {{ request()->routeIs('backup.*') ? 'active' : '' }}">
                        <i class="bi bi-database"></i>
                        Backup Database
                    </a>
                </div>
                
                @elseif(auth()->user()->level == 'orang_tua')
                {{-- Menu untuk Orang Tua --}}
                <div class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i>
                        Data Anak
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran Anak
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link {{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi Anak
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('prestasi.index') }}" class="nav-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}">
                        <i class="bi bi-trophy"></i>
                        Prestasi Anak
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('bimbingan-konseling.index') }}" class="nav-link {{ request()->routeIs('bimbingan-konseling.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-heart"></i>
                        Bimbingan Konseling
                    </a>
                </div>
                
                @elseif(auth()->user()->level == 'kepsek')
                {{-- Menu untuk Kepala Sekolah --}}
                <div class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Data Siswa
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link {{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('bimbingan-konseling.index') }}" class="nav-link {{ request()->routeIs('bimbingan-konseling.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-heart"></i>
                        Bimbingan Konseling
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('prestasi.index') }}" class="nav-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}">
                        <i class="bi bi-trophy"></i>
                        Prestasi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Laporan
                    </a>
                </div>
                
                @elseif(auth()->user()->level == 'kesiswaan')
                {{-- Menu untuk Kesiswaan --}}
                <div class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Data Siswa
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                        <i class="bi bi-door-open"></i>
                        Data Kelas
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('verifikator.index') }}" class="nav-link {{ request()->routeIs('verifikator.*') ? 'active' : '' }}">
                        <i class="bi bi-patch-check"></i>
                        Data Verifikator
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('verifikasi.pelanggaran') }}" class="nav-link {{ request()->routeIs('verifikasi.pelanggaran') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i>
                        Verifikasi Pelanggaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('verifikasi.prestasi') }}" class="nav-link {{ request()->routeIs('verifikasi.prestasi') ? 'active' : '' }}">
                        <i class="bi bi-award"></i>
                        Verifikasi Prestasi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link {{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('jenis-pelanggaran.index') }}" class="nav-link {{ request()->routeIs('jenis-pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-list-check"></i>
                        Jenis Pelanggaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('jenis-sanksi.index') }}" class="nav-link {{ request()->routeIs('jenis-sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i>
                        Jenis Sanksi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('wali-kelas.index') }}" class="nav-link {{ request()->routeIs('wali-kelas.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i>
                        Wali Kelas
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('prestasi.index') }}" class="nav-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}">
                        <i class="bi bi-trophy"></i>
                        Prestasi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('jenis-prestasi.index') }}" class="nav-link {{ request()->routeIs('jenis-prestasi.*') ? 'active' : '' }}">
                        <i class="bi bi-award"></i>
                        Jenis Prestasi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('laporan.kesiswaan') }}" class="nav-link {{ request()->routeIs('laporan.kesiswaan') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Cetak Laporan PDF
                    </a>
                </div>
                
                @elseif(auth()->user()->level == 'bk')
                {{-- Menu untuk Guru BK --}}
                <div class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Data Siswa
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('bimbingan-konseling.index') }}" class="nav-link {{ request()->routeIs('bimbingan-konseling.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-heart"></i>
                        Bimbingan Konseling
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link {{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('laporan.bk') }}" class="nav-link {{ request()->routeIs('laporan.bk') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Cetak Laporan PDF
                    </a>
                </div>
                
                @elseif(auth()->user()->level == 'wali_kelas')
                {{-- Menu untuk Wali Kelas --}}
                <div class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Data Siswa
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('orang-tua.index') }}" class="nav-link {{ request()->routeIs('orang-tua.*') ? 'active' : '' }}">
                        <i class="bi bi-person-hearts"></i>
                        Data Orang Tua
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran Kelas
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link {{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('laporan.wali-kelas') }}" class="nav-link {{ request()->routeIs('laporan.wali-kelas') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Cetak Laporan PDF
                    </a>
                </div>
                
                @elseif(auth()->user()->level == 'guru')
                {{-- Menu untuk Guru --}}
                <div class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Data Siswa
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('orang-tua.index') }}" class="nav-link {{ request()->routeIs('orang-tua.*') ? 'active' : '' }}">
                        <i class="bi bi-person-hearts"></i>
                        Data Orang Tua
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link {{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi
                    </a>
                </div>
                
                @elseif(auth()->user()->level == 'siswa')
                {{-- Menu untuk Siswa --}}
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran Saya
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link {{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi Saya
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('prestasi.index') }}" class="nav-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}">
                        <i class="bi bi-trophy"></i>
                        Prestasi Saya
                    </a>
                </div>
                @endif
            </nav>
        </aside>

        <main class="main-content">
            <div class="header">
                <div class="header-title">
                    <h1>@yield('page-title')</h1>
                    <p>@yield('page-description')</p>
                </div>
                <div class="user-info">
                    @php
                        $unreadNotif = \App\Models\Notifikasi::where('user_id', auth()->id())->where('dibaca', false)->count();
                        $unreadChat = 0;
                        $showChat = false;
                        
                        if (auth()->user()->level === 'wali_kelas') {
                            $showChat = true;
                            $unreadChat = \App\Models\Chat::where('penerima_id', auth()->id())->where('dibaca', false)->count();
                        } elseif (auth()->user()->level === 'orang_tua') {
                            $orangTuaData = \App\Models\OrangTua::where('user_id', auth()->id())->first();
                            if ($orangTuaData) {
                                $showChat = true;
                                $unreadChat = \App\Models\Chat::where('penerima_id', auth()->id())->where('dibaca', false)->count();
                            }
                        }
                    @endphp
                    @if($showChat)
                    <a href="{{ route('chat.index') }}" style="position: relative; margin-right: 20px; text-decoration: none; color: white;">
                        <i class="bi bi-chat-dots" style="font-size: 1.5rem;"></i>
                        @if($unreadChat > 0)
                        <span style="position: absolute; top: -5px; right: -5px; background: #10b981; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 600;">{{ $unreadChat }}</span>
                        @endif
                    </a>
                    @endif
                    <a href="{{ route('notifikasi.index') }}" style="position: relative; margin-right: 20px; text-decoration: none; color: white;">
                        <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
                        @if($unreadNotif > 0)
                        <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 600;">{{ $unreadNotif }}</span>
                        @endif
                    </a>
                    <div class="profile-dropdown" style="position: relative;">
                        <div class="profile-trigger" style="display: flex; align-items: center; gap: 15px; cursor: pointer;" onclick="toggleProfileDropdown()">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: white;">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</div>
                                <div style="font-size: 0.8rem; color: rgba(255,255,255,0.8);">{{ auth()->user()->level_text ?? 'Administrator' }}</div>
                            </div>
                            <i class="bi bi-chevron-down" style="color: white;"></i>
                        </div>
                        <div id="profileDropdown" class="profile-dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 10px; background: white; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); min-width: 200px; z-index: 1000;">
                            <div style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                                <div style="font-weight: 600; color: var(--dark);">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</div>
                                <div style="font-size: 0.8rem; color: #666;">{{ auth()->user()->email ?? '' }}</div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" style="padding: 10px;">
                                @csrf
                                <button type="submit" style="width: 100%; padding: 10px; border: none; background: none; text-align: left; cursor: pointer; border-radius: 5px; display: flex; align-items: center; gap: 10px; color: var(--danger); font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='none'">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-x-circle"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.profile-dropdown');
            if (dropdown && !dropdown.contains(event.target)) {
                document.getElementById('profileDropdown').style.display = 'none';
            }
        });

        // Prevent scroll to top when clicking sidebar links
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Store current scroll position
                    const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                    
                    // Allow the navigation to proceed
                    setTimeout(() => {
                        // Restore scroll position after navigation
                        window.scrollTo(0, scrollPosition);
                    }, 10);
                });
            });
        });
    </script>
</body>
</html>