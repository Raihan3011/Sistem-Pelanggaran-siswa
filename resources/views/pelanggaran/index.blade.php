@extends('layouts.admin')

@section('title', 'Data Pelanggaran')
@section('page-title', 'Data Pelanggaran')
@section('page-description', 'Kelola data pelanggaran siswa')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Pelanggaran</h3>
        @if(in_array(auth()->user()->level, ['admin', 'kesiswaan', 'wali_kelas', 'guru']))
        <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pelanggaran
        </a>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggaran as $p)
            <tr>
                <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                <td>{{ $p->point }}</td>
                <td>
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: {{ $p->status_verifikasi == 'Pending' ? 'rgba(245, 158, 11, 0.1)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $p->status_verifikasi == 'Pending' ? '#f59e0b' : '#10b981' }};">
                        {{ $p->status_verifikasi }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('pelanggaran.show', $p->pelanggaran_id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-eye"></i>
                    </a>
                    @if(in_array(auth()->user()->level, ['admin', 'kesiswaan', 'wali_kelas', 'guru']))
                    <a href="{{ route('pelanggaran.edit', $p->pelanggaran_id) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('pelanggaran.destroy', $p->pelanggaran_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.9rem;" onclick="return confirm('Yakin hapus?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #666;">Belum ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection