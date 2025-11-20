@extends('layouts.admin')

@section('title', 'Edit Sanksi')
@section('page-title', 'Edit Sanksi')
@section('page-description', 'Edit sanksi pelanggaran')

@section('content')
<div class="content-card">
    <form action="{{ route('sanksi.update', $sanksi) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pelanggaran *</label>
                <select name="pelanggaran_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Pelanggaran</option>
                    @foreach($pelanggaran as $p)
                    <option value="{{ $p->pelanggaran_id }}" {{ old('pelanggaran_id', $sanksi->pelanggaran_id) == $p->pelanggaran_id ? 'selected' : '' }}>
                        {{ $p->siswa->nama }} - {{ $p->jenisPelanggaran->nama_pelanggaran }} ({{ $p->tanggal_pelanggaran->format('d/m/Y') }})
                    </option>
                    @endforeach
                </select>
                @error('pelanggaran_id')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Jenis Sanksi *</label>
                <select name="jenis_sanksi" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Jenis Sanksi</option>
                    @foreach($jenisSanksi as $js)
                    <option value="{{ $js->nama_sanksi }}" {{ old('jenis_sanksi', $sanksi->jenis_sanksi) == $js->nama_sanksi ? 'selected' : '' }}>
                        {{ $js->nama_sanksi }} ({{ $js->poin_minimal }}-{{ $js->poin_maksimal }} poin)
                    </option>
                    @endforeach
                </select>
                @error('jenis_sanksi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Guru Penanggung Jawab *</label>
                <select name="guru_penanggung_jawab" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <option value="">Pilih Guru</option>
                    @foreach($guru as $g)
                    <option value="{{ $g->user_id }}" {{ old('guru_penanggung_jawab', $sanksi->guru_penanggung_jawab) == $g->user_id ? 'selected' : '' }}>
                        {{ $g->nama_lengkap }} ({{ ucfirst($g->level) }})
                    </option>
                    @endforeach
                </select>
                @error('guru_penanggung_jawab')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal Mulai *</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $sanksi->tanggal_mulai) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('tanggal_mulai')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal Selesai *</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $sanksi->tanggal_selesai) }}" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">
                @error('tanggal_selesai')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Deskripsi Sanksi *</label>
                <textarea name="deskripsi_sanksi" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('deskripsi_sanksi', $sanksi->deskripsi_sanksi) }}</textarea>
                @error('deskripsi_sanksi')<span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('sanksi.index') }}" class="btn btn-danger">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisSanksiSelect = document.querySelector('select[name="jenis_sanksi"]');
    const tanggalMulai = document.querySelector('input[name="tanggal_mulai"]');
    const tanggalSelesai = document.querySelector('input[name="tanggal_selesai"]');
    
    function checkDropOut() {
        const selectedValue = jenisSanksiSelect.value.toLowerCase();
        if (selectedValue.includes('drop out') || selectedValue.includes('dikeluarkan')) {
            tanggalSelesai.value = tanggalMulai.value;
            tanggalSelesai.readOnly = true;
            tanggalSelesai.style.background = '#f3f4f6';
        } else {
            tanggalSelesai.readOnly = false;
            tanggalSelesai.style.background = 'white';
        }
    }
    
    jenisSanksiSelect.addEventListener('change', checkDropOut);
    tanggalMulai.addEventListener('change', function() {
        const selectedValue = jenisSanksiSelect.value.toLowerCase();
        if (selectedValue.includes('drop out') || selectedValue.includes('dikeluarkan')) {
            tanggalSelesai.value = tanggalMulai.value;
        }
    });
    
    checkDropOut();
});
</script>
@endsection
