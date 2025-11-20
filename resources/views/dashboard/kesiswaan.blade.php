@extends('layouts.admin')

@section('title', 'Dashboard Kesiswaan')
@section('page-title', 'Dashboard Kesiswaan')
@section('page-description', 'Selamat datang di sistem pelanggaran siswa')

@section('content')
<style>
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
    .stat-card.primary::before { background: #1d4ed8; }
    .stat-card.danger::before { background: #ef4444; }
    .stat-card.warning::before { background: #f59e0b; }
    .stat-card.success::before { background: #10b981; }
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
    .stat-icon.primary { background: #1d4ed8; }
    .stat-icon.danger { background: #ef4444; }
    .stat-icon.warning { background: #f59e0b; }
    .stat-icon.success { background: #10b981; }
    .stat-number {
        font-size: 2.2rem;
        font-weight: 700;
        color: #111827;
    }
    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-top: 5px;
    }
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
    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
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
        color: #111827;
        margin-bottom: 5px;
    }
    .violation-count {
        background: #1d4ed8;
        color: white;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }
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
        background: #f8fafc;
        font-weight: 600;
        color: #111827;
    }
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    .status-verified {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    .category-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .badge-ringan {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    .badge-sedang {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    .badge-berat {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-header">
            <div class="stat-icon primary">
                <i class="bi bi-people"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalSiswa }}</div>
        <div class="stat-label">Total Siswa</div>
    </div>

    <div class="stat-card danger">
        <div class="stat-header">
            <div class="stat-icon danger">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalPelanggaran }}</div>
        <div class="stat-label">Total Pelanggaran</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-icon warning">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
        <div class="stat-number">{{ $pelanggaranPending }}</div>
        <div class="stat-label">Pelanggaran Pending</div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon success">
                <i class="bi bi-shield-check"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalSanksi }}</div>
        <div class="stat-label">Total Sanksi</div>
    </div>

    <div class="stat-card primary">
        <div class="stat-header">
            <div class="stat-icon primary">
                <i class="bi bi-clipboard-check"></i>
            </div>
        </div>
        <div class="stat-number">{{ \App\Models\JenisSanksi::count() }}</div>
        <div class="stat-label">Jenis Sanksi</div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="content-grid">
    <!-- Monthly Violations Chart -->
    <div class="chart-card">
        <h3 class="card-title">Grafik Pelanggaran Bulanan</h3>
        <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Top Violations -->
    <div class="table-card">
        <h3 class="card-title">Pelanggaran Terbanyak</h3>
        <div class="violations-list">
            @forelse($topViolations as $violation)
            <div class="violation-item">
                <div class="violation-info">
                    <h4>{{ $violation->nama_pelanggaran }}</h4>
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

<!-- Violations by Category -->
<div class="chart-card" style="margin-bottom: 30px;">
    <h3 class="card-title">Pelanggaran Berdasarkan Kategori</h3>
    <div style="display: flex; gap: 20px; justify-content: center; align-items: center; padding: 20px;">
        @forelse($violationsByCategory as $cat)
        <div style="text-align: center;">
            <div style="font-size: 2rem; font-weight: 700; color: {{ $cat->kategori == 'Ringan' ? '#10b981' : ($cat->kategori == 'Sedang' ? '#f59e0b' : '#ef4444') }};">
                {{ $cat->total }}
            </div>
            <span class="category-badge badge-{{ strtolower($cat->kategori) }}">{{ $cat->kategori }}</span>
        </div>
        @empty
        <div style="text-align: center; color: #666;">Belum ada data</div>
        @endforelse
    </div>
</div>

<!-- Recent Violations Table -->
<div class="table-card">
    <h3 class="card-title">Pelanggaran Terbaru</h3>
    <div style="overflow-x: auto;">
        <table class="violations-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Kategori</th>
                    <th>Poin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentViolations as $violation)
                <tr>
                    <td>{{ $violation->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $violation->siswa->nama ?? 'N/A' }}</td>
                    <td>{{ $violation->siswa->kelas->nama_kelas ?? 'N/A' }}</td>
                    <td>{{ $violation->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}</td>
                    <td>
                        <span class="category-badge badge-{{ strtolower($violation->jenisPelanggaran->kategori ?? 'ringan') }}">
                            {{ $violation->jenisPelanggaran->kategori ?? 'N/A' }}
                        </span>
                    </td>
                    <td>{{ $violation->jenisPelanggaran->poin ?? 0 }}</td>
                    <td>
                        <span class="status-badge {{ $violation->status_verifikasi == 'Pending' ? 'status-pending' : 'status-verified' }}">
                            {{ $violation->status_verifikasi }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #666;">Belum ada data pelanggaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyViolations);
    
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
@endsection
