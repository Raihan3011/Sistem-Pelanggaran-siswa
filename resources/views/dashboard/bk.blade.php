@extends('layouts.admin')

@section('title', 'Dashboard Guru BK')
@section('page-title', 'Dashboard Guru BK')
@section('page-description', 'Selamat datang di sistem bimbingan konseling')

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
    .priority-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .priority-tinggi {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    .priority-sedang {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    .priority-rendah {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

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
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-number">{{ $siswaBermasalah }}</div>
        <div class="stat-label">Siswa Bermasalah</div>
    </div>

    <div class="stat-card primary">
        <div class="stat-icon primary">
            <i class="bi bi-chat-dots"></i>
        </div>
        <div class="stat-number">{{ $totalBimbingan }}</div>
        <div class="stat-label">Sesi Bimbingan</div>
    </div>

    <div class="stat-card success">
        <div class="stat-icon success">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-number">{{ $bimbinganSelesai }}</div>
        <div class="stat-label">Bimbingan Selesai</div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="content-grid">
    <!-- Siswa Prioritas Tinggi -->
    <div class="table-card">
        <h3 class="card-title">Siswa Prioritas Bimbingan</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Total Poin</th>
                    <th>Prioritas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswaPrioritas as $siswa)
                <tr>
                    <td>{{ $siswa->nama_siswa }}</td>
                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $siswa->total_poin }}</td>
                    <td>
                        <span class="priority-badge priority-{{ $siswa->total_poin >= 100 ? 'tinggi' : ($siswa->total_poin >= 50 ? 'sedang' : 'rendah') }}">
                            {{ $siswa->total_poin >= 100 ? 'Tinggi' : ($siswa->total_poin >= 50 ? 'Sedang' : 'Rendah') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('siswa.show', $siswa) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #666;">Tidak ada siswa yang memerlukan bimbingan prioritas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Kategori Pelanggaran -->
    <div class="table-card">
        <h3 class="card-title">Kategori Pelanggaran</h3>
        <div style="padding: 20px;">
            @foreach($kategoriPelanggaran as $kategori)
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="font-weight: 600;">{{ $kategori->kategori }}</span>
                    <span style="color: #666;">{{ $kategori->total }}</span>
                </div>
                <div style="background: #e5e7eb; height: 8px; border-radius: 4px; overflow: hidden;">
                    <div style="background: {{ $kategori->kategori == 'Berat' ? '#ef4444' : ($kategori->kategori == 'Sedang' ? '#f59e0b' : '#10b981') }}; height: 100%; width: {{ ($kategori->total / $totalPelanggaran) * 100 }}%;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Pelanggaran Terbaru -->
<div class="table-card">
    <h3 class="card-title">Pelanggaran Terbaru yang Perlu Ditindaklanjuti</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Kategori</th>
                <th>Poin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggaranTerbaru as $pelanggaran)
            <tr>
                <td>{{ $pelanggaran->tanggal->format('d/m/Y') }}</td>
                <td>{{ $pelanggaran->siswa->nama_siswa ?? 'N/A' }}</td>
                <td>{{ $pelanggaran->siswa->kelas->nama_kelas ?? 'N/A' }}</td>
                <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}</td>
                <td>
                    <span class="priority-badge priority-{{ strtolower($pelanggaran->jenisPelanggaran->kategori ?? 'rendah') }}">
                        {{ $pelanggaran->jenisPelanggaran->kategori ?? 'N/A' }}
                    </span>
                </td>
                <td>{{ $pelanggaran->point }}</td>
                <td>
                    <a href="{{ route('pelanggaran.show', $pelanggaran->pelanggaran_id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #666;">Belum ada pelanggaran yang perlu ditindaklanjuti</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
