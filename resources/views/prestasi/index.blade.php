@extends('layouts.admin')

@section('title', 'Data Prestasi')
@section('page-title', 'Data Prestasi')
@section('page-description', 'Kelola data prestasi siswa')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Prestasi Siswa</h3>
        @if(in_array(auth()->user()->level, ['admin', 'kesiswaan']))
        <a href="{{ route('prestasi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Prestasi
        </a>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Prestasi</th>
                <th>Tingkat</th>
                <th>Jenis</th>
                @if(in_array(auth()->user()->level, ['admin', 'kesiswaan']))
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($prestasi as $p)
            <tr>
                <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                <td>{{ $p->siswa->nama_siswa }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas }}</td>
                <td>{{ $p->penghargaan }}</td>
                <td><span class="badge badge-primary">{{ $p->tingkat }}</span></td>
                <td><span class="badge badge-success">{{ $p->jenisPrestasi->nama_jenis ?? '-' }}</span></td>
                @if(in_array(auth()->user()->level, ['admin', 'kesiswaan']))
                <td>
                    <a href="{{ route('prestasi.show', $p->prestasi_id) }}" class="btn btn-sm btn-info" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('prestasi.edit', $p->prestasi_id) }}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('prestasi.destroy', $p->prestasi_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus prestasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #666;">Belum ada data prestasi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .badge-primary {
        background: rgba(29, 78, 216, 0.1);
        color: #1d4ed8;
    }
    .badge-success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    .btn-sm {
        padding: 6px 12px;
        font-size: 0.85rem;
    }
    .btn-info {
        background: #0891b2;
        color: white;
    }
</style>
@endsection
