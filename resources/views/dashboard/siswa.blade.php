@extends('layouts.admin')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')
@section('page-description', 'Pantau pelanggaran dan sanksi Anda')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard-style.css') }}">
<style>
    .profile-card {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }
    .profile-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: #3b82f6;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-card, .table-card {
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
    .chart-container {
        position: relative;
        height: 300px;
    }
</style>

<!-- Profile Card -->
<div class="profile-card">
    <div class="profile-info">
        <div class="profile-avatar">
            {{ strtoupper(substr($siswa->nama_siswa ?? 'S', 0, 1)) }}
        </div>
        <div>
            <h2 style="margin: 0; font-size: 1.8rem;">{{ $siswa->nama_siswa ?? 'N/A' }}</h2>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">{{ $siswa->kelas->nama_kelas ?? 'N/A' }} | NIS: {{ $siswa->nis ?? 'N/A' }}</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon danger">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="stat-card-title">Total Pelanggaran</div>
        <div class="stat-card-value">{{ $totalPelanggaran }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon warning">
            <i class="bi bi-calendar-event"></i>
        </div>
        <div class="stat-card-title">Pelanggaran Bulan Ini</div>
        <div class="stat-card-value">{{ $pelanggaranBulanIni }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon info">
            <i class="bi bi-star"></i>
        </div>
        <div class="stat-card-title">Total Poin Pelanggaran</div>
        <div class="stat-card-value">{{ $totalPoin }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-icon success">
            <i class="bi bi-trophy"></i>
        </div>
        <div class="stat-card-title">Total Prestasi</div>
        <div class="stat-card-value">{{ $totalPrestasi }}</div>
    </div>
</div>

<!-- Chart -->
<div class="content-section">
    <h3 class="section-title"><i class="bi bi-graph-up"></i> Grafik Pelanggaran Bulanan</h3>
    <div class="chart-container">
        <canvas id="monthlyChart"></canvas>
    </div>
</div>

<!-- Recent Violations Table -->
<div class="content-section">
    <h3 class="section-title"><i class="bi bi-clock-history"></i> Riwayat Pelanggaran Saya</h3>
    <div style="overflow-x: auto;">
        <table class="violations-table table-modern">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Poin</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentViolations as $violation)
                <tr>
                    <td>{{ $violation->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $violation->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}</td>
                    <td><strong>{{ $violation->jenisPelanggaran->poin ?? 0 }}</strong></td>
                    <td>{{ $violation->keterangan ?? '-' }}</td>
                    <td>
                        <span class="status-badge {{ $violation->status_verifikasi == 'Pending' ? 'status-pending' : 'status-verified' }}">
                            {{ $violation->status_verifikasi }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #666;">Belum ada pelanggaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Prestasi Table -->
<div class="content-section">
    <h3 class="section-title"><i class="bi bi-trophy"></i> Prestasi Saya</h3>
    <div style="overflow-x: auto;">
        <table class="violations-table table-modern">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Penghargaan</th>
                    <th>Tingkat</th>
                    <th>Poin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestasi as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $p->penghargaan }}</td>
                    <td>{{ $p->tingkat }}</td>
                    <td><strong style="color: #10b981;">{{ $p->point }}</strong></td>
                    <td>
                        @if($p->status_verifikasi == 'Pending')
                            <span class="status-badge status-pending">Pending</span>
                        @elseif($p->status_verifikasi == 'Verified')
                            <span class="status-badge status-verified">Verified</span>
                        @else
                            <span class="status-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #666;">Belum ada prestasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Sanksi Table -->
<div class="content-section">
    <h3 class="section-title"><i class="bi bi-shield-exclamation"></i> Sanksi yang Harus Saya Jalani</h3>
    <div style="overflow-x: auto;">
        <table class="violations-table table-modern">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Jenis Sanksi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sanksi as $s)
                <tr>
                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                    <td>{{ $s->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}</td>
                    <td>{{ $s->jenis_sanksi }}</td>
                    <td>{{ $s->tanggal_mulai->format('d/m/Y') }}</td>
                    <td>{{ $s->tanggal_selesai->format('d/m/Y') }}</td>
                    <td>
                        @if($s->status == 'Dijadwalkan')
                            <span class="status-badge" style="background: rgba(107, 114, 128, 0.1); color: #6b7280;">Dijadwalkan</span>
                        @elseif($s->status == 'Berjalan')
                            <span class="status-badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">Berjalan</span>
                        @elseif($s->status == 'Selesai')
                            <span class="status-badge status-verified">Selesai</span>
                        @else
                            <span class="status-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #666;">Belum ada sanksi</td>
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
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah Pelanggaran',
                data: chartData,
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: '#ef4444',
                borderWidth: 2
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
                    ticks: {
                        stepSize: 1
                    },
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