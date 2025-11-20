@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')
@section('page-description', 'Kelola data siswa sekolah')

@section('content')
@php
    $user = auth()->user();
    $orangTua = \App\Models\OrangTua::where('user_id', $user->user_id)->first();
    $isWaliKelas = in_array($user->level, ['wali_kelas', 'guru']);
    $isAdmin = $user->level == 'admin';
    $isKesiswaan = in_array($user->level, ['admin', 'kesiswaan']);
    $canCreate = in_array($user->level, ['admin', 'wali_kelas', 'guru']);
    $canEdit = in_array($user->level, ['admin', 'wali_kelas', 'guru']);
    $canDelete = in_array($user->level, ['admin', 'wali_kelas', 'guru']);
@endphp

<div class="content-card">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>
            @if($orangTua)
                Data Anak Anda
            @elseif($isWaliKelas)
                Data Siswa
            @else
                Daftar Siswa
            @endif
        </h3>
        @if($canCreate)
        <a href="{{ route('siswa.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Siswa
        </a>
        @endif
    </div>
    
    @if($orangTua)
    <div class="alert alert-info" style="margin-bottom: 20px;">
        <i class="bi bi-info-circle"></i> Menampilkan data anak Anda
    </div>
    @elseif($isWaliKelas)
    <div class="alert alert-info" style="margin-bottom: 20px;">
        <i class="bi bi-info-circle"></i> Menampilkan siswa di kelas Anda. Anda memiliki akses penuh untuk mengelola data siswa.
    </div>
    @elseif($isAdmin)
    <div class="alert alert-success" style="margin-bottom: 20px;">
        <i class="bi bi-shield-check"></i> Admin: Anda memiliki akses penuh untuk mengelola semua data siswa. Data orang tua dikelola terpisah melalui menu "Data Orang Tua".
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>No. Telp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $s)
            <tr>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $s->no_telp ?? '-' }}</td>
                <td>
                    <a href="{{ route('siswa.show', $s) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-eye"></i>
                    </a>
                    @if($canEdit)
                    <a href="{{ route('siswa.edit', $s) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    @endif
                    @if($canDelete)
                    <form action="{{ route('siswa.destroy', $s) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.9rem;" onclick="return confirm('Yakin hapus siswa ini?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #666;">Belum ada data siswa</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection