@extends('layouts.admin')

@section('title', 'Sambungkan Orang Tua')
@section('page-title', 'Sambungkan Orang Tua dengan Siswa')
@section('page-description', 'Hubungkan user orang tua yang sudah terdaftar dengan siswa')

@section('content')
<div class="content-card">
    <form action="{{ route('orang-tua.store') }}" method="POST">
        @csrf
        
        <div class="alert alert-info" style="margin-bottom: 20px;">
            <i class="bi bi-info-circle"></i> Pilih user orang tua yang sudah terdaftar dan siswa untuk menyambungkan keduanya.
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">User Orang Tua *</label>
                <select name="user_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih User Orang Tua</option>
                    @foreach($users as $user)
                    <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                        {{ $user->nama_lengkap }} ({{ $user->username }})
                    </option>
                    @endforeach
                </select>
                @error('user_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Siswa *</label>
                <select name="siswa_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Siswa</option>
                    @foreach($siswa as $s)
                        @php
                            $hasParent = \App\Models\OrangTua::where('siswa_id', $s->siswa_id)->where('siswa_id', '!=', null)->exists();
                        @endphp
                        @if(!$hasParent)
                        <option value="{{ $s->siswa_id }}" {{ old('siswa_id') == $s->siswa_id ? 'selected' : '' }}>
                            {{ $s->nis }} - {{ $s->nama }}
                        </option>
                        @endif
                    @endforeach
                </select>
                @error('siswa_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Hubungan *</label>
                <select name="hubungan" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Hubungan</option>
                    <option value="Ayah" {{ old('hubungan') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                    <option value="Ibu" {{ old('hubungan') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                    <option value="Wali" {{ old('hubungan') == 'Wali' ? 'selected' : '' }}>Wali</option>
                </select>
                @error('hubungan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('pekerjaan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pendidikan</label>
                <select name="pendidikan" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Pendidikan</option>
                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                    <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA/SMK Sederajat</option>
                    <option value="D1" {{ old('pendidikan') == 'D1' ? 'selected' : '' }}>Diploma 1</option>
                    <option value="D2" {{ old('pendidikan') == 'D2' ? 'selected' : '' }}>Diploma 2</option>
                    <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>Diploma 3</option>
                    <option value="D4" {{ old('pendidikan') == 'D4' ? 'selected' : '' }}>Diploma 4</option>
                    <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                    <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                    <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                </select>
                @error('pendidikan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">No. Telepon</label>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('no_telp')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Alamat *</label>
                <textarea name="alamat" rows="3" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('alamat') }}</textarea>
                @error('alamat')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-link"></i> Sambungkan
            </button>
            <a href="{{ route('orang-tua.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
