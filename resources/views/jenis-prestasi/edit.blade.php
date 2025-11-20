@extends('layouts.admin')

@section('title', 'Edit Jenis Prestasi')
@section('page-title', 'Edit Jenis Prestasi')
@section('page-description', 'Edit data jenis prestasi')

@section('content')
<div class="content-card">
    <form action="{{ route('jenis-prestasi.update', $jenisPrestasi->jenis_prestasi_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Prestasi *</label>
                <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi', $jenisPrestasi->nama_prestasi) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nama_prestasi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Deskripsi</label>
                <textarea name="deskripsi" rows="4" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('deskripsi', $jenisPrestasi->deskripsi) }}</textarea>
                @error('deskripsi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('jenis-prestasi.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
