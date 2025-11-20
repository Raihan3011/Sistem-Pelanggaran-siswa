<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas - Sistem Pelanggaran Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1d4ed8;
            --secondary: #60a5fa;
            --success: #10b981;
            --warning: #f59e0b;
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

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .logo-text h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .logo-text span {
            font-size: 0.8rem;
            color: #666;
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
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(29, 78, 216, 0.1);
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .nav-link i {
            font-size: 18px;
            width: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
        }

        .header-title p {
            color: #666;
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
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .stat-card.primary::before { background: var(--primary); }
        .stat-card.success::before { background: var(--success); }
        .stat-card.warning::before { background: var(--warning); }
        .stat-card.danger::before { background: var(--danger); }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.primary { background: var(--primary); }
        .stat-icon.success { background: var(--success); }
        .stat-icon.warning { background: var(--warning); }
        .stat-icon.danger { background: var(--danger); }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Charts and Tables */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .chart-card, .table-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark);
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        /* Recent Violations Table */
        .violations-table {
            width: 100%;
            border-collapse: collapse;
        }

        .violations-table th,
        .violations-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .violations-table th {
            background: var(--light);
            font-weight: 600;
            color: var(--dark);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .status-verified {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        /* Top Violations List */
        .violation-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .violation-item:last-child {
            border-bottom: none;
        }

        .violation-info h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .violation-count {
            background: var(--primary);
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div class="logo-text">
                        <h3>SMK Bakti Nusantara</h3>
                        <span>Wali Kelas Panel</span>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link active">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link">
                        <i class="bi bi-people"></i>
                        Data Siswa
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('orang-tua.index') }}" class="nav-link">
                        <i class="bi bi-person-hearts"></i>
                        Data Orang Tua
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pelanggaran
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('sanksi.index') }}" class="nav-link">
                        <i class="bi bi-shield-exclamation"></i>
                        Sanksi
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-title">
                    <h1>Dashboard Wali Kelas</h1>
                    <p>Selamat datang di sistem pelanggaran siswa</p>
                </div>
                <div class="user-info">
                    <div class="profile-dropdown" style="position: relative;">
                        <div class="profile-trigger" style="display: flex; align-items: center; gap: 15px; cursor: pointer;" onclick="toggleProfileDropdown()">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ auth()->user()->name ?? 'Admin' }}</div>
                                <div style="font-size: 0.8rem; color: #666;">Wali Kelas</div>
                            </div>
                            <i class="bi bi-chevron-down" style="color: var(--dark);"></i>
                        </div>
                        <div id="profileDropdown" class="profile-dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 10px; background: white; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); min-width: 200px; z-index: 1000;">
                            <div style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                                <div style="font-weight: 600; color: var(--dark);">{{ auth()->user()->name ?? 'Admin' }}</div>
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

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card primary">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <div class="stat-number">{{ $totalSiswa ?? 0 }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>

                <div class="stat-card danger">
                    <div class="stat-header">
                        <div class="stat-icon danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="stat-number">{{ $totalPelanggaran ?? 0 }}</div>
                    <div class="stat-label">Total Pelanggaran</div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            <i class="bi bi-list-check"></i>
                        </div>
                    </div>
                    <div class="stat-number">{{ $totalJenisPelanggaran ?? 0 }}</div>
                    <div class="stat-label">Jenis Pelanggaran</div>
                </div>

                <div class="stat-card success">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="bi bi-person-gear"></i>
                        </div>
                    </div>
                    <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
                    <div class="stat-label">Total Pengguna</div>
                </div>
            </div>

            <!-- Charts and Tables -->
            <div class="content-grid">
                <!-- Monthly Violations Chart -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">Grafik Pelanggaran Bulanan</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <!-- Top Violations -->
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">Pelanggaran Terbanyak</h3>
                    </div>
                    <div class="violations-list">
                        @forelse($topViolations ?? [] as $violation)
                        <div class="violation-item">
                            <div class="violation-info">
                                <h4>{{ $violation->nama }}</h4>
                                <small style="color: #666;">Poin: {{ $violation->poin }}</small>
                            </div>
                            <div class="violation-count">{{ $violation->pelanggaran_count ?? 0 }}</div>
                        </div>
                        @empty
                        <div class="violation-item">
                            <div class="violation-info">
                                <h4>Belum ada data</h4>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Data Siswa Table -->
            <div class="table-card">
                <div class="card-header">
                    <h3 class="card-title">Data Siswa Kelas Anda</h3>
                    <a href="{{ route('siswa.create') }}" class="btn btn-primary" style="padding: 8px 16px; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-size: 0.9rem;">
                        <i class="bi bi-plus-circle"></i> Tambah Data
                    </a>
                </div>
                <div style="overflow-x: auto;">
                    <table class="violations-table">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Kelamin</th>
                                <th>No. Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswaList ?? [] as $siswa)
                            <tr>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $siswa->no_telp ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('siswa.show', $siswa) }}" style="padding: 4px 8px; background: var(--primary); color: white; text-decoration: none; border-radius: 6px; font-size: 0.8rem;">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('siswa.edit', $siswa) }}" style="padding: 4px 8px; background: var(--warning); color: white; text-decoration: none; border-radius: 6px; font-size: 0.8rem; margin-left: 5px;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" style="display: inline; margin-left: 5px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin hapus siswa ini?')" style="padding: 4px 8px; background: var(--danger); color: white; border: none; border-radius: 6px; font-size: 0.8rem; cursor: pointer;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #666;">Belum ada data siswa</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Violations Table -->
            <div class="table-card" style="margin-top: 30px;">
                <div class="card-header">
                    <h3 class="card-title">Pelanggaran Terbaru (Hanya Lihat)</h3>
                </div>
                <div style="overflow-x: auto;">
                    <table class="violations-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Poin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentViolations ?? [] as $violation)
                            <tr>
                                <td>{{ $violation->created_at->format('d/m/Y') }}</td>
                                <td>{{ $violation->siswa->nama ?? 'N/A' }}</td>
                                <td>{{ $violation->jenisPelanggaran->nama ?? 'N/A' }}</td>
                                <td>{{ $violation->jenisPelanggaran->poin ?? 0 }}</td>
                                <td>
                                    <span class="status-badge status-pending">Pending</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #666;">Belum ada data pelanggaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Orang Tua Table -->
            <div class="table-card" style="margin-top: 30px;">
                <div class="card-header">
                    <h3 class="card-title">Data Orang Tua Terbaru (Hanya Lihat)</h3>
                </div>
                <div style="overflow-x: auto;">
                    <table class="violations-table">
                        <thead>
                            <tr>
                                <th>Nama Orang Tua</th>
                                <th>Hubungan</th>
                                <th>Nama Siswa</th>
                                <th>Pekerjaan</th>
                                <th>No. Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrangTua ?? [] as $ot)
                            <tr>
                                <td>{{ $ot->nama_orang_tua }}</td>
                                <td>
                                    <span class="status-badge {{ $ot->hubungan == 'Ayah' ? 'status-verified' : 'status-pending' }}">
                                        {{ $ot->hubungan }}
                                    </span>
                                </td>
                                <td>{{ $ot->siswa->nama ?? 'N/A' }}</td>
                                <td>{{ $ot->pekerjaan ?? '-' }}</td>
                                <td>{{ $ot->no_telp ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #666;">Belum ada data orang tua</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

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

        // Monthly Violations Chart
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyData = @json($monthlyViolations ?? []);
        
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const chartData = new Array(12).fill(0);
        
        monthlyData.forEach(item => {
            chartData[item.month - 1] = item.total;
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Pelanggaran',
                    data: chartData,
                    borderColor: '#1d4ed8',
                    backgroundColor: 'rgba(29, 78, 216, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e5e7eb'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>