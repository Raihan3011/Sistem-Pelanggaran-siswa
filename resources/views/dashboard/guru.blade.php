@extends('layouts.admin')

@section('page-title', 'Dashboard Guru')
@section('page-description', 'Selamat datang di dashboard guru')

@section('content')
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="content-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="margin: 0; opacity: 0.9;">Total Siswa</p>
                <h2 style="margin: 10px 0 0 0; font-size: 2.5rem;">{{ $totalSiswa }}</h2>
            </div>
            <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
    
    <div class="content-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="margin: 0; opacity: 0.9;">Pelanggaran Hari Ini</p>
                <h2 style="margin: 10px 0 0 0; font-size: 2.5rem;">{{ $pelanggaranHariIni }}</h2>
            </div>
            <i class="bi bi-exclamation-triangle" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
    
    <div class="content-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="margin: 0; opacity: 0.9;">Pelanggaran Bulan Ini</p>
                <h2 style="margin: 10px 0 0 0; font-size: 2.5rem;">{{ $pelanggaranBulanIni }}</h2>
            </div>
            <i class="bi bi-calendar-month" style="font-size: 3rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px;">
    <div class="content-card">
        <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
            <h4 style="margin: 0;">Data Siswa</h4>
            <a href="{{ route('siswa.index') }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                <i class="bi bi-eye"></i> Lihat Semua
            </a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswaList as $s)
                    <tr>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->nama_siswa }}</td>
                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td>
                            <a href="{{ route('siswa.show', $s) }}" class="btn" style="background: #0ea5e9; color: white; padding: 4px 8px; font-size: 0.8rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #666;">Tidak ada data siswa</td>
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
                <i class="bi bi-people"></i> Lihat Data Siswa
            </a>
            <a href="{{ route('pelanggaran.index') }}" class="btn btn-warning" style="width: 100%; text-align: left;">
                <i class="bi bi-list-ul"></i> Riwayat Pelanggaran
            </a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <div class="content-card">
        <h4 style="margin-bottom: 20px;">Pelanggaran Terbaru</h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Jenis</th>
                        <th>Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPelanggaran as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $p->siswa->nama_siswa }}</td>
                        <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                        <td><span style="background: var(--danger); color: white; padding: 2px 8px; border-radius: 4px;">{{ $p->point }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #666;">Belum ada pelanggaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="content-card">
        <h4 style="margin-bottom: 20px;">Jadwal Pelajaran</h4>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            @forelse($jadwalPelajaran as $jadwal)
            <div style="padding: 12px; background: var(--light); border-radius: 8px; border-left: 4px solid var(--primary);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <strong>{{ $jadwal['hari'] }}</strong>
                    <span style="color: #666; font-size: 0.9rem;">{{ $jadwal['jam'] }}</span>
                </div>
                <div style="color: #666;">{{ $jadwal['kelas'] }} - {{ $jadwal['mapel'] }}</div>
            </div>
            @empty
            <p style="text-align: center; color: #666;">Tidak ada jadwal</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
