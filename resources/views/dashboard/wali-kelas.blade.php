@extends('layouts.admin')

@section('page-title', 'Dashboard Wali Kelas')
@section('page-description', 'Selamat datang di dashboard wali kelas')

@section('content')
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="content-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="margin: 0; opacity: 0.9;">Kelas</p>
                <h2 style="margin: 10px 0 0 0; font-size: 2rem;">{{ $kelas->nama_kelas ?? '-' }}</h2>
            </div>
            <i class="bi bi-door-open" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
    
    <div class="content-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="margin: 0; opacity: 0.9;">Total Siswa</p>
                <h2 style="margin: 10px 0 0 0; font-size: 2.5rem;">{{ $totalSiswa }}</h2>
            </div>
            <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
    
    <div class="content-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="margin: 0; opacity: 0.9;">Pelanggaran Kelas</p>
                <h2 style="margin: 10px 0 0 0; font-size: 2.5rem;">{{ $pelanggaranKelas }}</h2>
            </div>
            <i class="bi bi-exclamation-triangle" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px;">
    <div class="content-card">
        <h4 style="margin-bottom: 20px;">Siswa Kelas {{ $kelas->nama_kelas ?? '-' }}</h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswaList as $s)
                    <tr>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->nama_siswa }}</td>
                        <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>
                            <a href="{{ route('siswa.show', $s) }}" class="btn" style="background: #0ea5e9; color: white; padding: 4px 8px; font-size: 0.8rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #666;">Tidak ada siswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="content-card">
        <h4 style="margin-bottom: 20px;">Quick Actions</h4>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary" style="width: 100%; text-align: left;">
                <i class="bi bi-plus-circle"></i> Input Pelanggaran
            </a>
            <a href="{{ route('siswa.index') }}" class="btn btn-success" style="width: 100%; text-align: left;">
                <i class="bi bi-people"></i> Kelola Siswa
            </a>
            <a href="{{ route('pelanggaran.index') }}" class="btn btn-warning" style="width: 100%; text-align: left;">
                <i class="bi bi-list-ul"></i> Riwayat Pelanggaran
            </a>
        </div>
    </div>
</div>

<div class="content-card">
    <h4 style="margin-bottom: 20px;">Pelanggaran Terbaru Kelas {{ $kelas->nama_kelas ?? '-' }}</h4>
    <div class="table-responsive">
        <table class="table">
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
                @forelse($recentPelanggaran as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $p->siswa->nama_siswa }}</td>
                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                    <td><span style="background: var(--danger); color: white; padding: 2px 8px; border-radius: 4px;">{{ $p->point }}</span></td>
                    <td>
                        @if($p->status_verifikasi == 'Terverifikasi')
                            <span style="background: var(--success); color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">Terverifikasi</span>
                        @elseif($p->status_verifikasi == 'Pending')
                            <span style="background: var(--warning); color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">Pending</span>
                        @else
                            <span style="background: #6b7280; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">Ditolak</span>
                        @endif
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
@endsection
