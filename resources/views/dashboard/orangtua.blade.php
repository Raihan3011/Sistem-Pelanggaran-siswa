@extends('layouts.admin')

@section('title', 'Dashboard Orang Tua')
@section('page-title', 'Dashboard Orang Tua')
@section('page-description', 'Pantau perkembangan anak Anda')

@section('content')
<style>
    .profile-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
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
        color: #667eea;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
    .stat-card.danger::before { background: #ef4444; }
    .stat-card.warning::before { background: #f59e0b; }
    .stat-card.info::before { background: #06b6d4; }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 15px;
    }
    .stat-icon.danger { background: #ef4444; }
    .stat-icon.warning { background: #f59e0b; }
    .stat-icon.info { background: #06b6d4; }
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
    }
    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-top: 5px;
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
    <div class="stat-card danger">
        <div class="stat-icon danger">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="stat-number">{{ $totalPelanggaran }}</div>
        <div class="stat-label">Total Pelanggaran</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-icon warning">
            <i class="bi bi-calendar-event"></i>
        </div>
        <div class="stat-number">{{ $pelanggaranBulanIni }}</div>
        <div class="stat-label">Pelanggaran Bulan Ini</div>
    </div>

    <div class="stat-card info">
        <div class="stat-icon info">
            <i class="bi bi-star"></i>
        </div>
        <div class="stat-number">{{ $totalPoin }}</div>
        <div class="stat-label">Total Poin Pelanggaran</div>
    </div>
</div>

<!-- Chart -->
<div class="chart-card">
    <h3 class="card-title">Grafik Pelanggaran Bulanan</h3>
    <div class="chart-container">
        <canvas id="monthlyChart"></canvas>
    </div>
</div>

<!-- Student Info Table -->
<div class="table-card">
    <h3 class="card-title">Informasi Siswa</h3>
    <table class="violations-table">
        <tr>
            <th style="width: 200px;">NIS</th>
            <td>{{ $siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <th>NISN</th>
            <td>{{ $siswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $siswa->nama_siswa ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $siswa->jenis_kelamin ?? '-' }}</td>
        </tr>
        <tr>
            <th>Total Poin Pelanggaran</th>
            <td><strong style="color: #ef4444; font-size: 1.2rem;">{{ $totalPoin }}</strong></td>
        </tr>
    </table>
</div>

<!-- Recent Violations Table -->
<div class="table-card" style="margin-top: 30px;">
    <h3 class="card-title">Riwayat Pelanggaran</h3>
    <div style="overflow-x: auto;">
        <table class="violations-table">
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

<!-- Sanksi Table -->
<div class="table-card" style="margin-top: 30px;">
    <h3 class="card-title">Riwayat Sanksi</h3>
    <div style="overflow-x: auto;">
        <table class="violations-table">
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

<!-- Bimbingan Konseling Table -->
<div class="table-card" style="margin-top: 30px;">
    <h3 class="card-title"><i class="bi bi-chat-heart" style="margin-right: 8px;"></i>Riwayat Bimbingan Konseling</h3>
    <div style="overflow-x: auto;">
        <table class="violations-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Guru BK</th>
                    <th>Topik</th>
                    <th>Jenis Layanan</th>
                    <th>Keluhan/Masalah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bimbinganKonseling as $bk)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($bk->tanggal_konseling)->format('d/m/Y') }}</td>
                    <td>{{ $bk->guruKonselor->name ?? 'N/A' }}</td>
                    <td>{{ $bk->topik }}</td>
                    <td>{{ $bk->jenis_layanan }}</td>
                    <td>{{ Str::limit($bk->keluhan_masalah, 50) }}</td>
                    <td>
                        @if($bk->status == 'Pending')
                            <span class="status-badge" style="background: rgba(107, 114, 128, 0.1); color: #6b7280;">Pending</span>
                        @elseif($bk->status == 'Proses')
                            <span class="status-badge status-pending">Proses</span>
                        @elseif($bk->status == 'Selesai')
                            <span class="status-badge status-verified">Selesai</span>
                        @else
                            <span class="status-badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">Tindak Lanjut</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #666;">Belum ada bimbingan konseling</td>
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
