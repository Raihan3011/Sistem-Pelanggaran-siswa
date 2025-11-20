@extends('layouts.admin')

@section('title', 'Data Sanksi')
@section('page-title', 'Data Sanksi')
@section('page-description', 'Kelola data sanksi pelanggaran')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Sanksi</h3>
        @if(in_array(auth()->user()->level, ['admin', 'kesiswaan']))
        <a href="{{ route('sanksi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Sanksi
        </a>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Jenis Pelanggaran</th>
                <th>Jenis Sanksi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sanksi as $item)
            <tr>
                <td>
                    <strong>{{ $item->pelanggaran->siswa->nama_siswa ?? '-' }}</strong><br>
                    <small class="text-muted">{{ $item->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</small>
                </td>
                <td>
                    <span class="badge badge-{{ $item->pelanggaran->jenisPelanggaran->kategori == 'Ringan' ? 'success' : ($item->pelanggaran->jenisPelanggaran->kategori == 'Sedang' ? 'warning' : 'danger') }}">
                        {{ $item->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}
                    </span><br>
                    <small class="text-muted">{{ $item->pelanggaran->jenisPelanggaran->poin ?? 0 }} poin</small>
                </td>
                <td>{{ $item->jenis_sanksi }}</td>
                <td>{{ $item->tanggal_mulai->format('d/m/Y') }}</td>
                <td>{{ $item->tanggal_selesai->format('d/m/Y') }}</td>
                <td>
                    @if($item->status == 'Dijadwalkan')
                        <span class="badge badge-secondary">Dijadwalkan</span>
                    @elseif($item->status == 'Berjalan')
                        <span class="badge badge-primary">Berjalan</span>
                    @elseif($item->status == 'Selesai')
                        <span class="badge badge-success">Selesai</span>
                    @else
                        <span class="badge badge-danger">Dibatalkan</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('sanksi.show', $item->sanksi_id) }}" class="btn btn-sm btn-info" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    @if(in_array(auth()->user()->level, ['admin', 'kesiswaan']) && $item->status == 'Dijadwalkan')
                    <a href="{{ route('sanksi.edit', $item->sanksi_id) }}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('sanksi.destroy', $item->sanksi_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus sanksi ini?')">
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
                <td colspan="7" style="text-align: center; color: #666;">Belum ada data sanksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection