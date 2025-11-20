@extends('layouts.admin')

@section('title', 'Edit Bimbingan Konseling')
@section('page-title', 'Edit Bimbingan Konseling')
@section('page-description', 'Edit data bimbingan konseling')

@section('content')
<div class="content-card">
    <form action="{{ route('bimbingan-konseling.update', $bimbinganKonseling->bk_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Siswa *</label>
                <select name="siswa_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Siswa</option>
                    @foreach($siswa as $s)
                    <option value="{{ $s->siswa_id }}" {{ old('siswa_id', $bimbinganKonseling->siswa_id) == $s->siswa_id ? 'selected' : '' }}>
                        {{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas ?? '-' }}
                    </option>
                    @endforeach
                </select>
                @error('siswa_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Guru BK *</label>
                <select name="guru_konselor" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Guru BK</option>
                    @foreach($guruBK as $guru)
                    <option value="{{ $guru->user_id }}" {{ old('guru_konselor', $bimbinganKonseling->guru_konselor) == $guru->user_id ? 'selected' : '' }}>
                        {{ $guru->name }}
                    </option>
                    @endforeach
                </select>
                @error('guru_konselor')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal Konseling *</label>
                <input type="date" name="tanggal_konseling" value="{{ old('tanggal_konseling', $bimbinganKonseling->tanggal_konseling) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('tanggal_konseling')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Jenis Layanan *</label>
                <select name="jenis_layanan" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Jenis Layanan</option>
                    <option value="Konseling Individual" {{ old('jenis_layanan', $bimbinganKonseling->jenis_layanan) == 'Konseling Individual' ? 'selected' : '' }}>Konseling Individual</option>
                    <option value="Konseling Kelompok" {{ old('jenis_layanan', $bimbinganKonseling->jenis_layanan) == 'Konseling Kelompok' ? 'selected' : '' }}>Konseling Kelompok</option>
                    <option value="Bimbingan Klasikal" {{ old('jenis_layanan', $bimbinganKonseling->jenis_layanan) == 'Bimbingan Klasikal' ? 'selected' : '' }}>Bimbingan Klasikal</option>
                    <option value="Lainnya" {{ old('jenis_layanan', $bimbinganKonseling->jenis_layanan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis_layanan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Status *</label>
                <select name="status" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="Pending" {{ old('status', $bimbinganKonseling->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Proses" {{ old('status', $bimbinganKonseling->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Selesai" {{ old('status', $bimbinganKonseling->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Tindak Lanjut" {{ old('status', $bimbinganKonseling->status) == 'Tindak Lanjut' ? 'selected' : '' }}>Tindak Lanjut</option>
                </select>
                @error('status')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Topik *</label>
                <input type="text" name="topik" value="{{ old('topik', $bimbinganKonseling->topik) }}" maxlength="200" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('topik')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Keluhan/Masalah *</label>
                <textarea name="keluhan_masalah" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('keluhan_masalah', $bimbinganKonseling->keluhan_masalah) }}</textarea>
                @error('keluhan_masalah')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tindakan/Solusi</label>
                <textarea name="tindakan_solusi" rows="4" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('tindakan_solusi', $bimbinganKonseling->tindakan_solusi) }}</textarea>
                @error('tindakan_solusi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('bimbingan-konseling.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
