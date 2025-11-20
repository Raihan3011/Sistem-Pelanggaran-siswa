@extends('layouts.admin')

@section('title', 'Tambah Pelanggaran')
@section('page-title', 'Tambah Pelanggaran')
@section('page-description', 'Catat pelanggaran siswa baru')

@section('content')
<div class="content-card">
    <form action="{{ route('pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Siswa *</label>
                <select name="siswa_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Siswa</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->siswa_id }}" {{ old('siswa_id') == $s->siswa_id ? 'selected' : '' }}>
                            {{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas ?? '' }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Jenis Pelanggaran *</label>
                <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Jenis Pelanggaran</option>
                    @foreach($jenisPelanggaran as $jp)
                        <option value="{{ $jp->jenis_pelanggaran_id }}" 
                                data-poin-min="{{ $jp->poin_minimal }}" 
                                data-poin-max="{{ $jp->poin_maksimal }}"
                                {{ old('jenis_pelanggaran_id') == $jp->jenis_pelanggaran_id ? 'selected' : '' }}>
                            {{ $jp->nama_pelanggaran }} ({{ $jp->poin_minimal }}-{{ $jp->poin_maksimal }} poin)
                        </option>
                    @endforeach
                </select>
                @error('jenis_pelanggaran_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Point Pelanggaran *</label>
                <input type="number" name="point" id="point" value="{{ old('point', 1) }}" required min="1" max="100" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                <small style="color: #6b7280;">Point akan disesuaikan dengan range jenis pelanggaran</small>
                @error('point')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('tanggal')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Bukti Foto</label>
                <input type="file" name="bukti_foto" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('bukti_foto')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Keterangan</label>
                <textarea name="keterangan" rows="4" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('keterangan') }}</textarea>
                @error('keterangan')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('pelanggaran.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisPelanggaranSelect = document.getElementById('jenis_pelanggaran_id');
    const pointInput = document.getElementById('point');
    
    jenisPelanggaranSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const poinMin = parseInt(selectedOption.getAttribute('data-poin-min'));
            const poinMax = parseInt(selectedOption.getAttribute('data-poin-max'));
            
            pointInput.min = poinMin;
            pointInput.max = poinMax;
            pointInput.value = poinMin; // Set default ke poin minimal
            
            // Update placeholder atau helper text
            const helpText = pointInput.nextElementSibling;
            if (helpText && helpText.tagName === 'SMALL') {
                helpText.textContent = `Point harus antara ${poinMin} - ${poinMax}`;
            }
        } else {
            pointInput.min = 1;
            pointInput.max = 100;
            pointInput.value = 1;
        }
    });
    
    // Trigger change event jika ada nilai yang sudah dipilih (untuk old input)
    if (jenisPelanggaranSelect.value) {
        jenisPelanggaranSelect.dispatchEvent(new Event('change'));
    }
});
</script>


@endsection