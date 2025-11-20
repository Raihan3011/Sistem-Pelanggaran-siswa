@extends('layouts.admin')

@section('title', 'Edit Orang Tua')
@section('page-title', 'Edit Orang Tua')
@section('page-description', 'Edit data orang tua siswa')

@section('content')
<div class="content-card">
    <form action="{{ route('orang-tua.update', $orangTua->orang_tua_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Siswa</label>
                <select name="siswa_id" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Siswa (Opsional)</option>
                    @foreach($siswa as $s)
                    <option value="{{ $s->siswa_id }}" {{ old('siswa_id', $orangTua->siswa_id) == $s->siswa_id ? 'selected' : '' }}>
                        {{ $s->nis }} - {{ $s->nama }}
                    </option>
                    @endforeach
                </select>
                @error('siswa_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
                <small style="color: #666; display: block; margin-top: 5px;">Kosongkan jika belum ada siswa yang terhubung</small>
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Hubungan *</label>
                <select name="hubungan" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Hubungan</option>
                    <option value="Ayah" {{ old('hubungan', $orangTua->hubungan) == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                    <option value="Ibu" {{ old('hubungan', $orangTua->hubungan) == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                    <option value="Wali" {{ old('hubungan', $orangTua->hubungan) == 'Wali' ? 'selected' : '' }}>Wali</option>
                </select>
                @error('hubungan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Orang Tua *</label>
                <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua', $orangTua->nama_orang_tua) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nama_orang_tua')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $orangTua->pekerjaan) }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('pekerjaan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pendidikan</label>
                <input type="text" name="pendidikan" value="{{ old('pendidikan', $orangTua->pendidikan) }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('pendidikan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">No. Telepon</label>
                <input type="text" name="no_telp" value="{{ old('no_telp', $orangTua->no_telp) }}" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('no_telp')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Alamat *</label>
                <textarea name="alamat" rows="3" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('alamat', $orangTua->alamat) }}</textarea>
                @error('alamat')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('orang-tua.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
