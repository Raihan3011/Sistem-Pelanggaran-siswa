@extends('layouts.admin')

@section('title', 'Data Guru')
@section('page-title', 'Data Guru')
@section('page-description', 'Kelola data guru dan staff')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Guru & Staff</h3>
        <a href="{{ route('guru.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Guru
        </a>
    </div>

    @if(session('success'))
    <div style="padding: 12px; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NIP</th>
                <th>No. Telepon</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guru as $index => $g)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $g->name }}</td>
                <td>{{ $g->email }}</td>
                <td>{{ $g->nip ?? '-' }}</td>
                <td>{{ $g->no_telepon ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $g->level == 'kesiswaan' ? 'primary' : ($g->level == 'wali_kelas' ? 'success' : 'info') }}">
                        {{ ucfirst(str_replace('_', ' ', $g->level)) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('guru.show', $g->user_id) }}" class="btn btn-sm btn-info" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('guru.edit', $g->user_id) }}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('guru.destroy', $g->user_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #666;">Belum ada data guru</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .badge-primary {
        background: rgba(29, 78, 216, 0.1);
        color: #1d4ed8;
    }
    .badge-success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    .badge-info {
        background: rgba(8, 145, 178, 0.1);
        color: #0891b2;
    }
    .btn-sm {
        padding: 6px 12px;
        font-size: 0.85rem;
    }
    .btn-info {
        background: #0891b2;
        color: white;
    }
</style>
@endsection
