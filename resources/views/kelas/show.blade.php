@extends('layouts.admin')

@section('page-title', 'Detail Kelas')
@section('page-description', 'Informasi detail kelas')

@section('content')
<div class="content-card">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('kelas.index') }}" class="btn" style="background: #6b7280; color: white;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Nama Kelas</label>
            <p style="font-size: 1.1rem;">{{ $kela->nama_kelas }}</p>
        </div>
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Jurusan</label>
            <p style="font-size: 1.1rem;">{{ $kela->jurusan }}</p>
        </div>
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Kapasitas</label>
            <p style="font-size: 1.1rem;">{{ $kela->kapasitas }} siswa</p>
        </div>
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Wali Kelas</label>
            <p style="font-size: 1.1rem;">{{ $kela->waliKelas->nama_lengkap ?? '-' }}</p>
        </div>
    </div>

    <hr style="margin: 30px 0;">

    <h4 style="margin-bottom: 20px;">Daftar Siswa ({{ $kela->siswa->count() }} siswa)</h4>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kela->siswa as $index => $siswa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama_siswa }}</td>
                    <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>
                        <a href="{{ route('siswa.show', $siswa) }}" class="btn" style="background: #0ea5e9; color: white; padding: 5px 10px; font-size: 0.8rem;">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px; color: #666;">Belum ada siswa di kelas ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
