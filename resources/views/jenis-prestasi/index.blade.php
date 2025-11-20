@extends('layouts.admin')

@section('title', 'Jenis Prestasi')
@section('page-title', 'Jenis Prestasi')
@section('page-description', 'Kelola jenis prestasi siswa')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Jenis Prestasi</h3>
        <a href="{{ route('jenis-prestasi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Jenis Prestasi
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Prestasi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenisPrestasi as $jp)
            <tr>
                <td>{{ $jp->nama_prestasi }}</td>
                <td>{{ $jp->deskripsi }}</td>
                <td>
                    <a href="{{ route('jenis-prestasi.edit', $jp->jenis_prestasi_id) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('jenis-prestasi.destroy', $jp->jenis_prestasi_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.9rem;" onclick="return confirm('Yakin hapus?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; color: #666;">Belum ada data jenis prestasi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
