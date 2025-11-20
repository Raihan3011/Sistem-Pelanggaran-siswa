@extends('layouts.admin')

@section('title', 'Edit Pelanggaran')
@section('page-title', 'Edit Pelanggaran')
@section('page-description', 'Edit data pelanggaran siswa')

@section('content')
<div class="content-card">
    <form action="{{ route('pelanggaran.update', $pelanggaran->pelanggaran_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Siswa *</label>
                <select name="siswa_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    @foreach($siswa as $s)
                        <option value="{{ $s->siswa_id }}" {{ old('siswa_id', $pelanggaran->siswa_id) == $s->siswa_id ? 'selected' : '' }}>
                            {{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas ?? '' }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Jenis Pelanggaran *</label>
                <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    @foreach($jenisPelanggaran as $jp)
                        <option value="{{ $jp->jenis_pelanggaran_id }}" 
                                data-poin-min="{{ $jp->poin_minimal }}" 
                                data-poin-max="{{ $jp->poin_maksimal }}"
                                {{ old('jenis_pelanggaran_id', $pelanggaran->jenis_pelanggaran_id) == $jp->jenis_pelanggaran_id ? 'selected' : '' }}>
                            {{ $jp->nama_pelanggaran }} ({{ $jp->poin_minimal }}-{{ $jp->poin_maksimal }} poin)
                        </option>
                    @endforeach
                </select>
                @error('jenis_pelanggaran_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Point Pelanggaran *</label>
                <input type="number" name="point" id="point" value="{{ old('point', $pelanggaran->point) }}" required min="1" max="100" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                <small style="color: #6b7280;">Point akan disesuaikan dengan range jenis pelanggaran</small>
                @error('point')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $pelanggaran->tanggal->format('Y-m-d')) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('tanggal')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Status Verifikasi</label>
                <select name="status_verifikasi" id="status_verifikasi" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="Pending" {{ old('status_verifikasi', $pelanggaran->status_verifikasi) == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Terverifikasi" {{ old('status_verifikasi', $pelanggaran->status_verifikasi) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="Ditolak" {{ old('status_verifikasi', $pelanggaran->status_verifikasi) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status_verifikasi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div id="alasan_verifikasi_wrapper" style="display: {{ old('status_verifikasi', $pelanggaran->status_verifikasi) == 'Terverifikasi' ? 'block' : 'none' }};">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Alasan Verifikasi</label>
                <textarea name="catatan_verifikasi" id="catatan_verifikasi" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;" placeholder="Masukkan alasan verifikasi...">{{ old('catatan_verifikasi', $pelanggaran->catatan_verifikasi) }}</textarea>
                <small style="color: #6b7280;">Wajib diisi saat status Terverifikasi</small>
                @error('catatan_verifikasi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Bukti Foto</label>
                <input type="file" name="bukti_foto" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @if($pelanggaran->bukti_foto)
                    <small style="color: #666;">Foto saat ini: {{ basename($pelanggaran->bukti_foto) }}</small>
                @endif
                @error('bukti_foto')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Keterangan</label>
                <textarea name="keterangan" rows="4" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('keterangan', $pelanggaran->keterangan) }}</textarea>
                @error('keterangan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('pelanggaran.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle status verifikasi
    document.getElementById('status_verifikasi').addEventListener('change', function() {
        const alasanWrapper = document.getElementById('alasan_verifikasi_wrapper');
        if (this.value === 'Terverifikasi') {
            alasanWrapper.style.display = 'block';
        } else {
            alasanWrapper.style.display = 'none';
        }
    });
    
    // Handle point range based on jenis pelanggaran
    const jenisPelanggaranSelect = document.getElementById('jenis_pelanggaran_id');
    const pointInput = document.getElementById('point');
    
    jenisPelanggaranSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const poinMin = parseInt(selectedOption.getAttribute('data-poin-min'));
            const poinMax = parseInt(selectedOption.getAttribute('data-poin-max'));
            
            pointInput.min = poinMin;
            pointInput.max = poinMax;
            
            // Jika point saat ini di luar range, set ke minimal
            if (parseInt(pointInput.value) < poinMin || parseInt(pointInput.value) > poinMax) {
                pointInput.value = poinMin;
            }
            
            // Update placeholder atau helper text
            const helpText = pointInput.nextElementSibling;
            if (helpText && helpText.tagName === 'SMALL') {
                helpText.textContent = `Point harus antara ${poinMin} - ${poinMax}`;
            }
        } else {
            pointInput.min = 1;
            pointInput.max = 100;
        }
    });
    
    // Trigger change event jika ada nilai yang sudah dipilih (untuk old input)
    if (jenisPelanggaranSelect.value) {
        jenisPelanggaranSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection