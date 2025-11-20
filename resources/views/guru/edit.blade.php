@extends('layouts.admin')

@section('title', 'Edit Guru')
@section('page-title', 'Edit Guru')
@section('page-description', 'Update data guru')

@section('content')
<div class="content-card">
    <form action="{{ route('guru.update', $guru->user_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nama_lengkap')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Username *</label>
                <input type="text" name="username" value="{{ old('username', $guru->username) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('username')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Password</label>
                <input type="password" name="password" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                <small style="color: #666;">Kosongkan jika tidak ingin mengubah password</small>
                @error('password')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Level *</label>
                <select name="level" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Level</option>
                    <option value="guru" {{ $guru->level == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="wali_kelas" {{ $guru->level == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="kesiswaan" {{ $guru->level == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                </select>
                @error('level')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nip')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">No. Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $guru->no_telepon) }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('no_telepon')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('guru.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
