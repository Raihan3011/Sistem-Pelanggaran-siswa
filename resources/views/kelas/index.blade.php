@extends('layouts.admin')

@section('page-title', 'Data Kelas')
@section('page-description', 'Kelola data kelas sekolah')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data Kelas</h4>
        @if(auth()->user()->level === 'admin')
            <a href="{{ route('kelas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Kelas
            </a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Jurusan</th>
                    <th>Kapasitas</th>
                    <th>Wali Kelas</th>
                    <th>Jumlah Siswa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $k->nama_kelas }}</td>
                    <td>{{ $k->jurusan }}</td>
                    <td>{{ $k->kapasitas }}</td>
                    <td>{{ $k->waliKelas->nama_lengkap ?? '-' }}</td>
                    <td>{{ $k->siswa_count }} siswa</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('kelas.show', $k) }}" class="btn" style="background: #0ea5e9; color: white; padding: 5px 10px; font-size: 0.8rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->level === 'admin')
                                <a href="{{ route('kelas.edit', $k) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.8rem;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('kelas.destroy', $k) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #666;">Tidak ada data kelas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
