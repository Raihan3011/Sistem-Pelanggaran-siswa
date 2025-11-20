@extends('layouts.admin')

@section('page-title', 'Edit Kelas')
@section('page-description', 'Edit data kelas')

@section('content')
<div class="content-card">
    <form action="{{ route('kelas.update', $kela) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas', $kela->nama_kelas) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            @error('nama_kelas')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tingkat</label>
            <select name="tingkat" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                <option value="">Pilih Tingkat</option>
                <option value="X" {{ old('tingkat', $kela->tingkat) == 'X' ? 'selected' : '' }}>X</option>
                <option value="XI" {{ old('tingkat', $kela->tingkat) == 'XI' ? 'selected' : '' }}>XI</option>
                <option value="XII" {{ old('tingkat', $kela->tingkat) == 'XII' ? 'selected' : '' }}>XII</option>
            </select>
            @error('tingkat')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Jurusan</label>
            <select name="jurusan" id="jurusan" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                <option value="">Pilih Jurusan</option>
                <option value="PPLG" {{ old('jurusan', $kela->jurusan) == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                <option value="AKT" {{ old('jurusan', $kela->jurusan) == 'AKT' ? 'selected' : '' }}>AKT</option>
                <option value="BDP" {{ old('jurusan', $kela->jurusan) == 'BDP' ? 'selected' : '' }}>BDP</option>
                <option value="DKV" {{ old('jurusan', $kela->jurusan) == 'DKV' ? 'selected' : '' }}>DKV</option>
                <option value="ANM" {{ old('jurusan', $kela->jurusan) == 'ANM' ? 'selected' : '' }}>ANM</option>
            </select>
            @error('jurusan')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Rombel</label>
            <select name="rombel" id="rombel" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                <option value="">Pilih Rombel</option>
            </select>
            @error('rombel')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kapasitas</label>
            <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', $kela->kapasitas) }}" required min="1" max="50" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            @error('kapasitas')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Wali Kelas (Opsional)</label>
            <select name="wali_kelas_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                <option value="">Pilih Wali Kelas</option>
                @foreach($guru as $g)
                    <option value="{{ $g->user_id }}" {{ old('wali_kelas_id', $kela->wali_kelas_id) == $g->user_id ? 'selected' : '' }}>
                        {{ $g->nama_lengkap }}
                    </option>
                @endforeach
            </select>
            @error('wali_kelas_id')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('kelas.index') }}" class="btn" style="background: #6b7280; color: white;">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
const rombelOptions = {
    'PPLG': ['1', '2', '3'],
    'AKT': ['1', '2'],
    'BDP': ['1'],
    'DKV': ['1'],
    'ANM': ['1']
};

const currentRombel = '{{ old('rombel', $kela->rombel) }}';

function populateRombel(jurusan, selectedRombel = '') {
    const rombelSelect = document.getElementById('rombel');
    rombelSelect.innerHTML = '<option value="">Pilih Rombel</option>';
    
    if (jurusan && rombelOptions[jurusan]) {
        rombelOptions[jurusan].forEach(rombel => {
            const option = document.createElement('option');
            option.value = rombel;
            option.textContent = rombel;
            if (rombel === selectedRombel) {
                option.selected = true;
            }
            rombelSelect.appendChild(option);
        });
    }
}

document.getElementById('jurusan').addEventListener('change', function() {
    populateRombel(this.value);
});

// Populate on page load
const initialJurusan = document.getElementById('jurusan').value;
if (initialJurusan) {
    populateRombel(initialJurusan, currentRombel);
}
</script>
@endsection
