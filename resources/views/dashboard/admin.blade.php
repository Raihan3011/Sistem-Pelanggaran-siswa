@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-description', 'Selamat datang di sistem pelanggaran siswa')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard-style.css') }}">
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
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
    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-welcome">
    <h1><i class="bi bi-speedometer2"></i> Dashboard Admin</h1>
    <p>Selamat datang, {{ auth()->user()->nama_lengkap }}! Kelola sistem pelanggaran siswa dengan mudah.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon primary">
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-card-title">Total Siswa</div>
        <div class="stat-card-value">{{ $totalSiswa }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon danger">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="stat-card-title">Total Pelanggaran</div>
        <div class="stat-card-value">{{ $totalPelanggaran }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon warning">
            <i class="bi bi-list-check"></i>
        </div>
        <div class="stat-card-title">Jenis Pelanggaran</div>
        <div class="stat-card-value">{{ $totalJenisPelanggaran }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon success">
            <i class="bi bi-shield-check"></i>
        </div>
        <div class="stat-card-title">Total Sanksi</div>
        <div class="stat-card-value">{{ $totalSanksi }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon info">
            <i class="bi bi-person-gear"></i>
        </div>
        <div class="stat-card-title">Total Pengguna</div>
        <div class="stat-card-value">{{ $totalUsers }}</div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="content-grid">
    <!-- Monthly Violations Chart -->
    <div class="content-section">
        <h3 class="section-title"><i class="bi bi-graph-up"></i> Grafik Pelanggaran Bulanan</h3>
        <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Top Violations -->
    <div class="content-section">
        <h3 class="section-title"><i class="bi bi-trophy"></i> Pelanggaran Terbanyak</h3>
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

<!-- Recent Violations Table -->
<div class="content-section">
    <h3 class="section-title"><i class="bi bi-clock-history"></i> Pelanggaran Terbaru</h3>
    <div style="overflow-x: auto;">
        <table class="violations-table table-modern">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Poin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentViolations as $violation)
                <tr>
                    <td>{{ $violation->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $violation->siswa->nama_siswa ?? 'N/A' }}</td>
                    <td>{{ $violation->siswa->kelas->nama_kelas ?? 'N/A' }}</td>
                    <td>{{ $violation->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}</td>
                    <td>{{ $violation->point ?? 0 }}</td>
                    <td>
                        <span class="status-badge {{ $violation->status_verifikasi == 'Pending' ? 'status-pending' : 'status-verified' }}">
                            {{ $violation->status_verifikasi }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #666;">Belum ada data pelanggaran</td>
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
