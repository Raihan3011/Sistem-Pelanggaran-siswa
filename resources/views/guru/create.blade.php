@extends('layouts.admin')

@section('title', 'Tambah Guru')
@section('page-title', 'Tambah Guru')
@section('page-description', 'Tambah data guru baru')

@section('content')
<div class="content-card">
    <form action="{{ route('guru.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nama_lengkap')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Username *</label>
                <input type="text" name="username" value="{{ old('username') }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('username')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Password *</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('password')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Level *</label>
                <select name="level" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Level</option>
                    <option value="guru">Guru</option>
                    <option value="wali_kelas">Wali Kelas</option>
                    <option value="kesiswaan">Kesiswaan</option>
                </select>
                @error('level')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nip')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">No. Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('no_telepon')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('guru.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
