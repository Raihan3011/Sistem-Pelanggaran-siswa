@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')
@section('page-description', 'Tambah pengguna baru ke sistem')

@section('content')
<div class="content-card">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Username *</label>
                <input type="text" name="username" value="{{ old('username') }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('username')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Password *</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('password')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
                <small style="color: #666;">Minimal 6 karakter</small>
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nama_lengkap')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Level *</label>
                <select name="level" id="level" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;" onchange="toggleKelasField()">
                    <option value="">Pilih Level</option>
                    <option value="admin" {{ old('level') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kesiswaan" {{ old('level') == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                    <option value="bk" {{ old('level') == 'bk' ? 'selected' : '' }}>BK</option>
                    <option value="wali_kelas" {{ old('level') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="orang_tua" {{ old('level') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="siswa" {{ old('level') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('level')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div id="kelasField" style="display: none;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kelas Binaan *</label>
                <select name="kelas_id" id="kelas_id" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->kelas_id }}" {{ old('kelas_id') == $k->kelas_id ? 'selected' : '' }}>
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
                <i class="bi bi-save"></i> Simpan
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

// Check on page load if wali_kelas is selected (for old input)
window.addEventListener('DOMContentLoaded', function() {
    toggleKelasField();
});
</script>
@endsection
