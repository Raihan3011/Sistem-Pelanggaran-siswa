@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('page-description', 'Laporan pelanggaran siswa')

@section('content')
<div class="content-card">
    <h3 style="margin-bottom: 20px;">Laporan Pelanggaran Siswa</h3>
    
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="padding: 20px; background: #f8fafc; border-radius: 10px; border-left: 4px solid var(--primary); display: flex; flex-direction: column;">
            <h4 style="color: #666; font-size: 0.9rem; margin-bottom: 10px;">Laporan Harian</h4>
            <form action="{{ route('laporan.harian') }}" method="GET" style="display: flex; flex-direction: column; flex: 1;">
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 10px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: auto;">
                    <i class="bi bi-download"></i> Download PDF
                </button>
            </form>
        </div>
        
        <div style="padding: 20px; background: #f8fafc; border-radius: 10px; border-left: 4px solid var(--success); display: flex; flex-direction: column;">
            <h4 style="color: #666; font-size: 0.9rem; margin-bottom: 10px;">Laporan Bulanan</h4>
            <form action="{{ route('laporan.bulanan') }}" method="GET" style="display: flex; flex-direction: column; flex: 1;">
                <select name="bulan" required style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 5px;">
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
                <input type="number" name="tahun" value="{{ date('Y') }}" required style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 10px;">
                <button type="submit" class="btn btn-success" style="width: 100%; margin-top: auto;">
                    <i class="bi bi-download"></i> Download PDF
                </button>
            </form>
        </div>
        
        <div style="padding: 20px; background: #f8fafc; border-radius: 10px; border-left: 4px solid var(--warning); display: flex; flex-direction: column;">
            <h4 style="color: #666; font-size: 0.9rem; margin-bottom: 10px;">Laporan Per Kelas</h4>
            <form action="{{ route('laporan.kelas') }}" method="GET" style="display: flex; flex-direction: column; flex: 1;">
                <select name="kelas_id" required style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 10px;">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->kelas_id }}">
                        @if($k->tingkat && $k->jurusan && $k->rombel)
                            {{ $k->tingkat }} {{ $k->jurusan }} {{ $k->rombel }}
                        @else
                            {{ $k->nama_kelas }}
                        @endif
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-warning" style="width: 100%; margin-top: auto;">
                    <i class="bi bi-download"></i> Download PDF
                </button>
            </form>
        </div>
        
        <div style="padding: 20px; background: #f8fafc; border-radius: 10px; border-left: 4px solid var(--danger); display: flex; flex-direction: column;">
            <h4 style="color: #666; font-size: 0.9rem; margin-bottom: 10px;">Laporan Per Siswa</h4>
            <form action="{{ route('laporan.siswa') }}" method="GET" style="display: flex; flex-direction: column; flex: 1;">
                <input type="text" id="search-siswa" placeholder="Cari siswa (NIS/Nama)..." style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 5px;">
                <select name="siswa_id" id="siswa-select" required style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 10px; max-height: 200px;">
                    <option value="">Pilih Siswa</option>
                    @foreach($siswa as $s)
                    <option value="{{ $s->siswa_id }}" data-nis="{{ $s->nis }}" data-nama="{{ strtolower($s->nama_siswa) }}">
                        {{ $s->nis }} - {{ $s->nama_siswa }} ({{ $s->kelas ? $s->kelas->tingkat . ' ' . $s->kelas->jurusan . ' ' . $s->kelas->rombel : 'Tanpa Kelas' }})
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-danger" style="width: 100%; margin-top: auto;">
                    <i class="bi bi-download"></i> Download PDF
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const searchInput = document.getElementById('search-siswa');
const siswaSelect = document.getElementById('siswa-select');
const allOptions = Array.from(siswaSelect.options).slice(1);

searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    
    siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
    
    allOptions.forEach(option => {
        const nis = option.dataset.nis.toLowerCase();
        const nama = option.dataset.nama;
        
        if (nis.includes(searchTerm) || nama.includes(searchTerm)) {
            siswaSelect.appendChild(option.cloneNode(true));
        }
    });
});
</script>
@endsection