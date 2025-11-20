@extends('layouts.admin')

@section('title', 'Tambah Wali Kelas')
@section('page-title', 'Tambah Wali Kelas')
@section('page-description', 'Tambah data wali kelas baru')

@section('content')
<div class="content-card">
    <form action="{{ route('wali-kelas.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pilih Akun (Opsional)</label>
                <select name="user_id" id="user_id" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Buat Akun Baru</option>
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                            {{ $user->nama_lengkap }} ({{ $user->username }})
                        </option>
                    @endforeach
                </select>
                <small style="color: #6b7280;">Pilih akun yang sudah ada atau biarkan kosong untuk membuat akun baru</small>
                @error('user_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">NIP *</label>
                <input type="text" name="nip" value="{{ old('nip') }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nip')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>



            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Jenis Kelamin *</label>
                <select name="jenis_kelamin" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Bidang Studi *</label>
                <input type="text" name="bidang_studi" value="{{ old('bidang_studi') }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('bidang_studi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('email')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">No. Telepon</label>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('no_telp')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pilih Kelas *</label>
                <select name="kelas_id" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Kelas</option>
                    @php
                        $kelasByTingkat = $kelas->groupBy('tingkat');
                    @endphp
                    @foreach(['X', 'XI', 'XII'] as $tingkat)
                        @if(isset($kelasByTingkat[$tingkat]))
                            <optgroup label="Kelas {{ $tingkat }}">
                                @foreach($kelasByTingkat[$tingkat] as $k)
                                <option value="{{ $k->kelas_id }}" 
                                        {{ old('kelas_id') == $k->kelas_id ? 'selected' : '' }}
                                        {{ $k->wali_kelas_id ? 'style=color:#dc3545;' : '' }}>
                                    {{ $k->jurusan }} {{ $k->rombel }}
                                    @if($k->wali_kelas_id)
                                        (Sudah ada wali: {{ $k->waliKelas->nama_lengkap ?? 'Unknown' }})
                                    @else
                                        (Tersedia)
                                    @endif
                                </option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach
                </select>
                <small style="color: #6b7280;">Kelas berwarna merah sudah memiliki wali kelas. Memilih kelas tersebut akan mengganti wali kelas yang lama.</small>
                @error('kelas_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('wali-kelas.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('user_id').addEventListener('change', function() {
    const formFields = ['nama_guru'];
    const isExistingUser = this.value !== '';
    
    formFields.forEach(field => {
        const input = document.querySelector(`input[name="${field}"]`);
        if (input) {
            input.disabled = isExistingUser;
            if (isExistingUser) {
                input.style.backgroundColor = '#f3f4f6';
            } else {
                input.style.backgroundColor = '';
            }
        }
    });
});
</script>
@endsection
