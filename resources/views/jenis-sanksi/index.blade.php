@extends('layouts.admin')

@section('page-title', 'Jenis Sanksi')
@section('page-description', 'Kelola jenis sanksi berdasarkan poin pelanggaran')

@section('content')
<div class="content-card">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('jenis-sanksi.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">
            <i class="bi bi-plus-circle"></i> Tambah Jenis Sanksi
        </a>
        <h4>Jenis Sanksi</h4>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Sanksi</th>
                    <th>Deskripsi</th>
                    <th>Poin Minimal</th>
                    <th>Poin Maksimal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisSanksi as $index => $js)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $js->nama_sanksi }}</td>
                    <td>{{ Str::limit($js->deskripsi, 50) }}</td>
                    <td>{{ $js->poin_minimal }}</td>
                    <td>{{ $js->poin_maksimal }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('jenis-sanksi.show', $js) }}" class="btn" style="background: #0ea5e9; color: white; padding: 5px 10px; font-size: 0.8rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('jenis-sanksi.edit', $js) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.8rem;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('jenis-sanksi.destroy', $js) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #666;">Tidak ada data jenis sanksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
