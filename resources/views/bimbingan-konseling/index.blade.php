@extends('layouts.admin')

@section('title', 'Bimbingan Konseling')
@section('page-title', 'Bimbingan Konseling')
@section('page-description', 'Kelola data bimbingan konseling siswa')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Bimbingan Konseling</h3>
        @if(!in_array(auth()->user()->level, ['orang_tua', 'kepsek']))
        <a href="{{ route('bimbingan-konseling.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Bimbingan
        </a>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Topik</th>
                <th>Jenis Layanan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bimbingan as $b)
            <tr>
                <td>{{ \Carbon\Carbon::parse($b->tanggal_konseling)->format('d/m/Y') }}</td>
                <td>{{ $b->siswa->nama_siswa }}</td>
                <td>{{ $b->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $b->topik }}</td>
                <td>{{ $b->jenis_layanan }}</td>
                <td>
                    @if($b->status == 'Pending')
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(107, 114, 128, 0.1); color: #6b7280;">Pending</span>
                    @elseif($b->status == 'Proses')
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">Proses</span>
                    @elseif($b->status == 'Selesai')
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(16, 185, 129, 0.1); color: #10b981;">Selesai</span>
                    @else
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(59, 130, 246, 0.1); color: #3b82f6;">Tindak Lanjut</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('bimbingan-konseling.show', $b->bk_id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-eye"></i>
                    </a>
                    @if(!in_array(auth()->user()->level, ['orang_tua', 'kepsek']) && $b->status != 'Selesai')
                    <a href="{{ route('bimbingan-konseling.edit', $b->bk_id) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('bimbingan-konseling.destroy', $b->bk_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.9rem;" onclick="return confirm('Yakin hapus data ini?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #666;">Belum ada data bimbingan konseling</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
