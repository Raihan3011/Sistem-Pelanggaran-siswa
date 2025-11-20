@extends('layouts.admin')

@section('page-title', 'Data Verifikator')
@section('page-description', 'Kelola data verifikator pelanggaran')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data Verifikator</h4>
        <a href="{{ route('verifikator.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Verifikator
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Verifikator</th>
                    <th>NIP</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($verifikator as $index => $v)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $v->nama_verifikator }}</td>
                    <td>{{ $v->nip ?? '-' }}</td>
                    <td>{{ $v->user->username ?? '-' }}</td>
                    <td>
                        @if($v->status == 'Aktif')
                            <span style="background: var(--success); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Aktif</span>
                        @else
                            <span style="background: #6b7280; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('verifikator.show', $v) }}" class="btn" style="background: #0ea5e9; color: white; padding: 5px 10px; font-size: 0.8rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('verifikator.edit', $v) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.8rem;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('verifikator.destroy', $v) }}" method="POST" style="display: inline;">
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
                    <td colspan="6" style="text-align: center; padding: 20px; color: #666;">Tidak ada data verifikator</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
