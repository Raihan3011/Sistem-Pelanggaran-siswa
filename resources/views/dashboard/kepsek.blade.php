@extends('layouts.admin')

@section('title', 'Dashboard Kepala Sekolah')
@section('page-title', 'Dashboard Kepala Sekolah')
@section('page-description', 'Monitoring dan Laporan Sistem Pelanggaran Siswa')

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
    .stat-card.success::before { background: #10b981; }
    .stat-card.warning::before { background: #f59e0b; }
    .stat-card.danger::before { background: #ef4444; }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        margin-bottom: 15px;
    }
    .stat-icon.primary { background: #1d4ed8; }
    .stat-icon.success { background: #10b981; }
    .stat-icon.warning { background: #f59e0b; }
    .stat-icon.danger { background: #ef4444; }
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #111827;
    }
    .stat-label {
        color: #666;
        font-size: 0.95rem;
        margin-top: 5px;
    }
    .chart-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-icon primary">
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-number">{{ $totalSiswa }}</div>
        <div class="stat-label">Total Siswa</div>
    </div>

    <div class="stat-card danger">
        <div class="stat-icon danger">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="stat-number">{{ $totalPelanggaran }}</div>
        <div class="stat-label">Total Pelanggaran</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-icon warning">
            <i class="bi bi-shield-exclamation"></i>
        </div>
        <div class="stat-number">{{ $totalSanksi }}</div>
        <div class="stat-label">Total Sanksi</div>
    </div>

    <div class="stat-card success">
        <div class="stat-icon success">
            <i class="bi bi-list-check"></i>
        </div>
        <div class="stat-number">{{ $totalJenisPelanggaran }}</div>
        <div class="stat-label">Jenis Pelanggaran</div>
    </div>
</div>

<!-- Chart -->
<div class="chart-card">
    <h3 class="card-title">Grafik Pelanggaran Bulanan ({{ date('Y') }})</h3>
    <canvas id="monthlyChart" style="max-height: 350px;"></canvas>
</div>

<!-- Top Violations -->
<div class="chart-card">
    <h3 class="card-title">Top 5 Jenis Pelanggaran</h3>
    <canvas id="topViolationsChart" style="max-height: 300px;"></canvas>
</div>

<!-- Recent Violations Table -->
<div class="chart-card">
    <h3 class="card-title">Pelanggaran Terbaru</h3>
    <table class="table">
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
                <td>{{ $violation->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $violation->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $violation->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                <td><strong>{{ $violation->jenisPelanggaran->poin ?? 0 }}</strong></td>
                <td>
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: {{ $violation->status_verifikasi == 'Pending' ? 'rgba(245, 158, 11, 0.1)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $violation->status_verifikasi == 'Pending' ? '#f59e0b' : '#10b981' }};">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyViolations);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const chartData = new Array(12).fill(0);
    
    monthlyData.forEach(item => {
        chartData[item.month - 1] = item.total;
    });

    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah Pelanggaran',
                data: chartData,
                backgroundColor: 'rgba(29, 78, 216, 0.1)',
                borderColor: '#1d4ed8',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Top Violations Chart
    const topCtx = document.getElementById('topViolationsChart').getContext('2d');
    const topViolations = @json($topViolations);
    
    new Chart(topCtx, {
        type: 'bar',
        data: {
            labels: topViolations.map(v => v.nama_pelanggaran),
            datasets: [{
                label: 'Jumlah Kasus',
                data: topViolations.map(v => v.pelanggaran_count),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(139, 92, 246, 0.8)'
                ],
                borderColor: [
                    '#ef4444',
                    '#f59e0b',
                    '#3b82f6',
                    '#10b981',
                    '#8b5cf6'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
