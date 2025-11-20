@extends('layouts.admin')

@section('title', 'Data Wali Kelas')
@section('page-title', 'Data Wali Kelas')
@section('page-description', 'Kelola data wali kelas')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Wali Kelas</h3>
        @if(auth()->user()->level === 'admin')
            <a href="{{ route('wali-kelas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Wali Kelas
            </a>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama Guru</th>
                <th>Jenis Kelamin</th>
                <th>Bidang Studi</th>
                <th>Email</th>
                <th>Kelas Diampu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($waliKelas as $wk)
            <tr>
                <td>{{ $wk->nip }}</td>
                <td>{{ $wk->nama_guru }}</td>
                <td>{{ $wk->jenis_kelamin_text }}</td>
                <td>{{ $wk->bidang_studi }}</td>
                <td>{{ $wk->email }}</td>
                <td>
                    @if(isset($wk->kelas_diampu) && $wk->kelas_diampu)
                        {{ $wk->kelas_diampu->tingkat }} {{ $wk->kelas_diampu->jurusan }} {{ $wk->kelas_diampu->rombel }}
                    @else
                        <span style="color: #dc3545;">Belum ada kelas</span>
                    @endif
                </td>
                <td>
                    <span class="badge badge-{{ $wk->status == 'Aktif' ? 'success' : 'danger' }}">
                        {{ $wk->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('wali-kelas.show', $wk->wali_kelas_id) }}" class="btn btn-sm btn-info" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    @if(auth()->user()->level === 'admin')
                        @if(!isset($wk->kelas_diampu) || !$wk->kelas_diampu)
                            <button class="btn btn-sm btn-success" onclick="showInputModal({{ $wk->wali_kelas_id }}, '{{ $wk->nama_guru }}')" title="Input Kelas">
                                <i class="bi bi-plus"></i> Input
                            </button>
                        @endif
                        <a href="{{ route('wali-kelas.edit', $wk->wali_kelas_id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('wali-kelas.destroy', $wk->wali_kelas_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus wali kelas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #666;">Belum ada data wali kelas</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Input Kelas -->
<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 1000;" id="inputModal">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
            <h4 style="margin: 0; color: #1f2937;">Input Kelas</h4>
        </div>
        <form id="inputForm" method="POST">
            @csrf
            <div style="padding: 20px;">
                <p style="margin-bottom: 20px; color: #6b7280;">Input kelas untuk: <strong id="namaGuru" style="color: #1f2937;"></strong></p>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #374151;">Pilih Kelas *</label>
                    <select name="kelas_id" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px; background: white;">
                        <option value="">Pilih Kelas</option>
                        @php
                            $kelasAvailable = \App\Models\Kelas::whereNull('wali_kelas_id')
                                ->orderBy('tingkat')->orderBy('jurusan')->orderBy('rombel')->get();
                            $kelasByTingkat = $kelasAvailable->groupBy('tingkat');
                        @endphp
                        @foreach(['X', 'XI', 'XII'] as $tingkat)
                            @if(isset($kelasByTingkat[$tingkat]))
                                <optgroup label="Kelas {{ $tingkat }}">
                                    @foreach($kelasByTingkat[$tingkat] as $kelas)
                                        <option value="{{ $kelas->kelas_id }}">
                                            {{ $kelas->jurusan }} {{ $kelas->rombel }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="padding: 20px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeInputModal()" class="btn btn-danger">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showInputModal(waliKelasId, namaGuru) {
    document.getElementById('namaGuru').textContent = namaGuru;
    document.getElementById('inputForm').action = `/wali-kelas/${waliKelasId}/assign-kelas`;
    document.getElementById('inputModal').style.display = 'block';
}

function closeInputModal() {
    document.getElementById('inputModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('inputModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInputModal();
    }
});
</script>
@endsection
