@extends('layouts.admin')

@section('page-title', 'Verifikasi Pelanggaran')
@section('page-description', 'Verifikasi data pelanggaran yang diinput guru')

@section('content')
<div class="content-card">
    <h4 style="margin-bottom: 20px;">Pelanggaran Menunggu Verifikasi</h4>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Poin</th>
                    <th>Guru Pencatat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggaran as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $p->siswa->nama_siswa }}</td>
                    <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                    <td>{{ $p->point }}</td>
                    <td>{{ $p->guruPencatat->nama_lengkap }}</td>
                    <td>
                        <button class="btn btn-success" style="padding: 5px 10px; font-size: 0.8rem;" onclick="showModal({{ $p->pelanggaran_id }}, 'Terverifikasi')">
                            <i class="bi bi-check-circle"></i> Terima
                        </button>
                        <button class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;" onclick="showModal({{ $p->pelanggaran_id }}, 'Ditolak')">
                            <i class="bi bi-x-circle"></i> Tolak
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #666;">Tidak ada pelanggaran yang menunggu verifikasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="verifikasiModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 15px; width: 500px; max-width: 90%;">
        <h4 style="margin-bottom: 20px;">Verifikasi Pelanggaran</h4>
        <form id="verifikasiForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status_verifikasi" id="statusVerifikasi">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Catatan Verifikasi (Opsional)</label>
                <textarea name="catatan_verifikasi" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;"></textarea>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <button type="button" class="btn" style="background: #6b7280; color: white;" onclick="closeModal()">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showModal(pelanggaranId, status) {
    document.getElementById('verifikasiForm').action = '/verifikasi/pelanggaran/' + pelanggaranId;
    document.getElementById('statusVerifikasi').value = status;
    document.getElementById('verifikasiModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('verifikasiModal').style.display = 'none';
}
</script>
@endsection
