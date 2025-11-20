@extends('layouts.admin')

@section('page-title', 'Data Tahun Ajaran')
@section('page-description', 'Kelola data tahun ajaran sekolah')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data Tahun Ajaran</h4>
        <a href="{{ route('tahun-ajaran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Tahun Ajaran
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
            </thead>
            <tbody>
                @forelse($tahunAjaran as $index => $ta)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ta->kode_tahun }}</td>
                    <td>{{ $ta->tahun_ajaran }}</td>
                    <td>{{ $ta->semester == 1 ? 'Ganjil' : 'Genap' }}</td>
                    <td>{{ \Carbon\Carbon::parse($ta->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($ta->tanggal_selesai)->format('d/m/Y') }}</td>
                    <td>
                        @if($ta->status_aktif)
                            <span style="background: var(--success); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Aktif</span>
                        @else
                            <span style="background: #6b7280; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('tahun-ajaran.show', $ta) }}" class="btn" style="background: #0ea5e9; color: white; padding: 5px 10px; font-size: 0.8rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('tahun-ajaran.edit', $ta) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.8rem;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if(!$ta->status_aktif)
                                <form action="{{ route('tahun-ajaran.activate', $ta) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success" style="padding: 5px 10px; font-size: 0.8rem;" onclick="return confirm('Aktifkan tahun ajaran ini?')">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('tahun-ajaran.destroy', $ta) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #666;">Tidak ada data tahun ajaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection