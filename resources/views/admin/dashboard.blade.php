@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalSiswa ?? '1,250' }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
        </div>
        
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $pelanggaranBulanIni ?? '156' }}</div>
                <div class="stat-label">Pelanggaran Bulan Ini</div>
            </div>
        </div>
        
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $siswaTertib ?? '89' }}%</div>
                <div class="stat-label">Siswa Tertib</div>
            </div>
        </div>
        
        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $perluTindakLanjut ?? '24' }}</div>
                <div class="stat-label">Perlu Tindak Lanjut</div>
            </div>
        </div>
    </div>

    <div class="grid-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
        <!-- Recent Pelanggaran -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pelanggaran Terbaru</h3>
                <a href="{{ route('admin.pelanggaran.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah
                </a>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Pelanggaran</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPelanggaran as $pelanggaran)
                            <tr>
                                <td>{{ $pelanggaran->siswa->nama }}</td>
                                <td>{{ $pelanggaran->kategori->nama }}</td>
                                <td>{{ $pelanggaran->tanggal->format('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $pelanggaran->status == 'selesai' ? 'success' : 'warning' }}">
                                        {{ $pelanggaran->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pelanggaran.show', $pelanggaran->id) }}" class="btn btn-outline btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Pelanggaran -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kategori Pelanggaran Terbanyak</h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    @foreach($topKategori as $kategori)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-red-100 rounded flex items-center justify-center">
                                <i class="bi bi-exclamation-triangle text-red-600"></i>
                            </div>
                            <span>{{ $kategori->nama }}</span>
                        </div>
                        <span class="font-semibold">{{ $kategori->total }} kasus</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik -->
    <div class="card" style="margin-top: 20px;">
        <div class="card-header">
            <h3 class="card-title">Statistik Pelanggaran 6 Bulan Terakhir</h3>
        </div>
        <div class="card-body">
            <div style="height: 300px; background: #f8fafc; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                [Grafik Statistik akan ditampilkan di sini]
            </div>
        </div>
    </div>
@endsection