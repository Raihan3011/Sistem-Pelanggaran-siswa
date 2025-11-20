@extends('layouts.admin')

@section('title', 'Data Pengguna')
@section('page-title', 'Data Pengguna')
@section('page-description', 'Kelola data pengguna sistem')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Pengguna</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pengguna
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Level</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama_lengkap }}</td>
                <td>{{ $user->level_text }}</td>
                <td>
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: {{ $user->is_active ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $user->is_active ? '#10b981' : '#ef4444' }};">
                        {{ $user->status_text }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('users.show', $user->user_id) }}" class="btn" style="background: #0ea5e9; color: white; padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="force" value="1">
                        <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.9rem;" onclick="return confirm('Yakin hapus user ini? Semua data pelanggaran dan sanksi terkait akan ditransfer ke admin.')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #666;">Belum ada data pengguna</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection