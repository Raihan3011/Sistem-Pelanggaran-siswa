@extends('layouts.admin')

@section('title', 'Edit Prestasi')
@section('page-title', 'Edit Prestasi')
@section('page-description', 'Update data prestasi siswa')

@section('content')
<div class="content-card">
    <form action="{{ route('prestasi.update', $prestasi->prestasi_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Siswa *</label>
                <select name="siswa_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Siswa</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->siswa_id }}" {{ $prestasi->siswa_id == $s->siswa_id ? 'selected' : '' }}>
                            {{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Penghargaan *</label>
                <input type="text" name="penghargaan" value="{{ old('penghargaan', $prestasi->penghargaan) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('penghargaan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tingkat *</label>
                <select name="tingkat" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Tingkat</option>
                    <option value="Sekolah" {{ $prestasi->tingkat == 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                    <option value="Kecamatan" {{ $prestasi->tingkat == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                    <option value="Kabupaten" {{ $prestasi->tingkat == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                    <option value="Provinsi" {{ $prestasi->tingkat == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                    <option value="Nasional" {{ $prestasi->tingkat == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="Internasional" {{ $prestasi->tingkat == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                </select>
                @error('tingkat')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal Prestasi *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $prestasi->tanggal->format('Y-m-d')) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('tanggal')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Bukti Dokumen</label>
                <input type="file" name="bukti_dokumen" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @if($prestasi->bukti_dokumen)
                    <small style="color: #666;">Dokumen saat ini: {{ basename($prestasi->bukti_dokumen) }}</small>
                @endif
                @error('bukti_dokumen')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Keterangan</label>
                <textarea name="keterangan" rows="4" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('keterangan', $prestasi->keterangan) }}</textarea>
                @error('keterangan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('prestasi.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
