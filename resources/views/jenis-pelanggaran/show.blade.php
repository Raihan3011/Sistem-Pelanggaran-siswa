@extends('layouts.admin')

@section('title', 'Detail Jenis Pelanggaran')
@section('page-title', 'Detail Jenis Pelanggaran')
@section('page-description', 'Informasi lengkap jenis pelanggaran')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h3>{{ $jenisPelanggaran->nama_pelanggaran }}</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('jenis-pelanggaran.edit', $jenisPelanggaran->jenis_pelanggaran_id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('jenis-pelanggaran.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
        <div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Nama Pelanggaran</label>
                <div style="padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                    {{ $jenisPelanggaran->nama_pelanggaran }}
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Kategori</label>
                <div style="padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; 
                        @if($jenisPelanggaran->kategori == 'Ringan') background: #dcfce7; color: #166534;
                        @elseif($jenisPelanggaran->kategori == 'Sedang') background: #fef3c7; color: #92400e;
                        @else background: #fee2e2; color: #dc2626; @endif">
                        {{ $jenisPelanggaran->kategori }}
                    </span>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Poin</label>
                <div style="padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <span style="font-size: 1.2rem; font-weight: 700; color: var(--danger);">
                        {{ $jenisPelanggaran->point }} Poin
                    </span>
                </div>
            </div>
        </div>

        <div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Deskripsi</label>
                <div style="padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; min-height: 100px;">
                    {{ $jenisPelanggaran->deskripsi ?? 'Tidak ada deskripsi' }}
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Dibuat</label>
                <div style="padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                    {{ $jenisPelanggaran->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 5px;">Terakhir Diupdate</label>
                <div style="padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                    {{ $jenisPelanggaran->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    @if($jenisPelanggaran->pelanggaran->count() > 0)
    <div style="margin-top: 40px;">
        <h4 style="margin-bottom: 20px; color: #374151;">Riwayat Pelanggaran ({{ $jenisPelanggaran->pelanggaran->count() }} kasus)</h4>
        
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisPelanggaran->pelanggaran->take(10) as $pelanggaran)
                    <tr>
                        <td>{{ $pelanggaran->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $pelanggaran->siswa->nama_siswa }}</td>
                        <td>{{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;
                                @if($pelanggaran->status_verifikasi == 'Terverifikasi') background: #dcfce7; color: #166534;
                                @elseif($pelanggaran->status_verifikasi == 'Menunggu') background: #fef3c7; color: #92400e;
                                @else background: #fee2e2; color: #dc2626; @endif">
                                {{ $pelanggaran->status_verifikasi }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pelanggaran.show', $pelanggaran->pelanggaran_id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($jenisPelanggaran->pelanggaran->count() > 10)
        <div style="margin-top: 15px; text-align: center;">
            <a href="{{ route('pelanggaran.index') }}?jenis={{ $jenisPelanggaran->jenis_pelanggaran_id }}" class="btn btn-primary">
                Lihat Semua Pelanggaran
            </a>
        </div>
        @endif
    </div>
    @else
    <div style="margin-top: 40px; text-align: center; padding: 40px; background: #f9fafb; border-radius: 8px;">
        <i class="bi bi-info-circle" style="font-size: 3rem; color: #6b7280; margin-bottom: 15px;"></i>
        <h4 style="color: #374151; margin-bottom: 10px;">Belum Ada Pelanggaran</h4>
        <p style="color: #6b7280;">Jenis pelanggaran ini belum pernah dicatat dalam sistem.</p>
    </div>
    @endif
</div>
@endsection