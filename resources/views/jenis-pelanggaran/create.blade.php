@extends('layouts.admin')

@section('title', 'Tambah Jenis Pelanggaran')
@section('page-title', 'Tambah Jenis Pelanggaran')
@section('page-description', 'Tambah jenis pelanggaran baru')

@section('content')
<div class="content-card">
    <form action="{{ route('jenis-pelanggaran.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Pelanggaran *</label>
                <input type="text" name="nama_pelanggaran" value="{{ old('nama_pelanggaran') }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('nama_pelanggaran')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kategori *</label>
                <select name="kategori" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriOptions as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                    @endforeach
                </select>
                @error('kategori')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Poin Minimal *</label>
                <input type="number" name="poin_minimal" value="{{ old('poin_minimal', 1) }}" required min="1" max="100" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('poin_minimal')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Poin Maksimal *</label>
                <input type="number" name="poin_maksimal" value="{{ old('poin_maksimal', 15) }}" required min="1" max="100" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('poin_maksimal')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Deskripsi</label>
                <textarea name="deskripsi" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Sanksi Rekomendasi</label>
                <textarea name="sanksi_rekomendasi" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('sanksi_rekomendasi') }}</textarea>
                @error('sanksi_rekomendasi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('jenis-pelanggaran.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.querySelector('select[name="kategori"]');
    const poinMinimal = document.querySelector('input[name="poin_minimal"]');
    const poinMaksimal = document.querySelector('input[name="poin_maksimal"]');
    
    const rangeMap = {
        'Ringan': { min: 1, max: 15 },
        'Sedang': { min: 16, max: 30 },
        'Berat': { min: 31, max: 50 },
        'Sangat Berat': { min: 51, max: 100 }
    };
    
    kategoriSelect.addEventListener('change', function() {
        const selectedKategori = this.value;
        if (rangeMap[selectedKategori]) {
            poinMinimal.value = rangeMap[selectedKategori].min;
            poinMaksimal.value = rangeMap[selectedKategori].max;
        }
    });
});
</script>
@endsection