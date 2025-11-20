@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')
@section('page-description', 'Edit data pengguna sistem')

@section('content')
<div class="content-card">
    <form action="{{ route('users.update', $user->user_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Username *</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('username')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Password</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('password')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
                <small style="color: #666;">Minimal 6 karakter</small>
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nama_lengkap')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Level *</label>
                <select name="level" id="level" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;" onchange="toggleKelasField()">
                    <option value="">Pilih Level</option>
                    <option value="admin" {{ old('level', $user->level) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kesiswaan" {{ old('level', $user->level) == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                    <option value="bk" {{ old('level', $user->level) == 'bk' ? 'selected' : '' }}>BK</option>
                    <option value="wali_kelas" {{ old('level', $user->level) == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="orang_tua" {{ old('level', $user->level) == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="siswa" {{ old('level', $user->level) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('level')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div id="kelasField" style="display: none;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kelas Binaan *</label>
                <select name="kelas_id" id="kelas_id" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->kelas_id }}" {{ old('kelas_id', $kelasUser->kelas_id ?? '') == $k->kelas_id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} - {{ $k->jurusan }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
                <small style="color: #666;">Pilih kelas yang akan dibina</small>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
function toggleKelasField() {
    const level = document.getElementById('level').value;
    const kelasField = document.getElementById('kelasField');
    const kelasSelect = document.getElementById('kelas_id');
    
    if (level === 'wali_kelas') {
        kelasField.style.display = 'block';
        kelasSelect.required = true;
    } else {
        kelasField.style.display = 'none';
        kelasSelect.required = false;
        kelasSelect.value = '';
    }
}

window.addEventListener('DOMContentLoaded', function() {
    toggleKelasField();
});
</script>
@endsection
