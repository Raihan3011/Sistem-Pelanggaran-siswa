@extends('layouts.admin')

@section('page-title', 'Edit Tahun Ajaran')
@section('page-description', 'Edit data tahun ajaran')

@section('content')
<div class="content-card">
    <form action="{{ route('tahun-ajaran.update', $tahunAjaran) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="kode_tahun" style="display: block; margin-bottom: 5px; font-weight: 600;">Kode Tahun <span style="color: var(--danger);">*</span></label>
                <input type="text" id="kode_tahun" name="kode_tahun" value="{{ old('kode_tahun', $tahunAjaran->kode_tahun) }}" 
                       placeholder="Contoh: 2024-1" 
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; @error('kode_tahun') border-color: var(--danger); @enderror">
                @error('kode_tahun')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="tahun_ajaran" style="display: block; margin-bottom: 5px; font-weight: 600;">Tahun Ajaran <span style="color: var(--danger);">*</span></label>
                <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $tahunAjaran->tahun_ajaran) }}" 
                       placeholder="Contoh: 2024/2025" 
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; @error('tahun_ajaran') border-color: var(--danger); @enderror">
                @error('tahun_ajaran')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="semester" style="display: block; margin-bottom: 5px; font-weight: 600;">Semester <span style="color: var(--danger);">*</span></label>
                <select id="semester" name="semester" 
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; @error('semester') border-color: var(--danger); @enderror">
                    <option value="">Pilih Semester</option>
                    <option value="1" {{ old('semester', $tahunAjaran->semester) == '1' ? 'selected' : '' }}>Ganjil</option>
                    <option value="2" {{ old('semester', $tahunAjaran->semester) == '2' ? 'selected' : '' }}>Genap</option>
                </select>
                @error('semester')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="tanggal_mulai" style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal Mulai <span style="color: var(--danger);">*</span></label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $tahunAjaran->tanggal_mulai) }}" 
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; @error('tanggal_mulai') border-color: var(--danger); @enderror">
                @error('tanggal_mulai')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="tanggal_selesai" style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal Selesai <span style="color: var(--danger);">*</span></label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $tahunAjaran->tanggal_selesai) }}" 
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; @error('tanggal_selesai') border-color: var(--danger); @enderror">
                @error('tanggal_selesai')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" id="status_aktif" name="status_aktif" value="1" 
                       {{ old('status_aktif', $tahunAjaran->status_aktif) ? 'checked' : '' }}>
                <label for="status_aktif" style="font-weight: 600;">Aktifkan tahun ajaran ini</label>
            </div>
            <small style="color: #666; font-size: 0.8rem;">Jika dicentang, tahun ajaran lain akan dinonaktifkan secara otomatis</small>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 30px;">
            <a href="{{ route('tahun-ajaran.index') }}" class="btn" style="background: #6b7280; color: white;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection