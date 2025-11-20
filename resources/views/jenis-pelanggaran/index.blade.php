@extends('layouts.admin')

@section('title', 'Jenis Pelanggaran')
@section('page-title', 'Jenis Pelanggaran')
@section('page-description', 'Kelola jenis pelanggaran')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Jenis Pelanggaran</h3>
        <a href="{{ route('jenis-pelanggaran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Jenis Pelanggaran
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Pelanggaran</th>
                <th>Kategori</th>
                <th>Poin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenisPelanggaran as $jp)
            <tr>
                <td>{{ $jp->nama_pelanggaran }}</td>
                <td>
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: {{ $jp->kategori == 'Ringan' ? 'rgba(16, 185, 129, 0.1)' : ($jp->kategori == 'Sedang' ? 'rgba(245, 158, 11, 0.1)' : 'rgba(239, 68, 68, 0.1)') }}; color: {{ $jp->kategori == 'Ringan' ? '#10b981' : ($jp->kategori == 'Sedang' ? '#f59e0b' : '#ef4444') }};">
                        {{ $jp->kategori }}
                    </span>
                </td>
                <td>
                    <strong>{{ $jp->poin_minimal ?? 1 }}-{{ $jp->poin_maksimal ?? 15 }}</strong> poin
                </td>
                <td>
                    <a href="{{ route('jenis-pelanggaran.show', $jp->jenis_pelanggaran_id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('jenis-pelanggaran.edit', $jp->jenis_pelanggaran_id) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('jenis-pelanggaran.destroy', $jp->jenis_pelanggaran_id) }}" method="POST" style="display: inline;">
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
                <td colspan="4" style="text-align: center; color: #666;">Belum ada data jenis pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection