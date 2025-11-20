@extends('layouts.admin')

@section('page-title', 'Tambah Jenis Sanksi')
@section('page-description', 'Tambah jenis sanksi baru')

@section('content')
<div class="content-card">
    <form action="{{ route('jenis-sanksi.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Sanksi</label>
            <input type="text" name="nama_sanksi" class="form-control" value="{{ old('nama_sanksi') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            @error('nama_sanksi')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; min-height: 100px;">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Poin Minimal</label>
            <input type="number" name="poin_minimal" class="form-control" value="{{ old('poin_minimal') }}" required min="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            @error('poin_minimal')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Poin Maksimal</label>
            <input type="number" name="poin_maksimal" class="form-control" value="{{ old('poin_maksimal') }}" required min="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            @error('poin_maksimal')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('jenis-sanksi.index') }}" class="btn" style="background: #6b7280; color: white;">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
