@extends('layouts.admin')

@section('title', 'Detail Pelanggaran')
@section('page-title', 'Detail Pelanggaran')
@section('page-description', 'Informasi lengkap pelanggaran siswa')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Detail Pelanggaran</h3>
        <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <!-- Data Siswa -->
        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Data Siswa</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px; width: 200px;"><strong>Nama Siswa</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->siswa->nama }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>NIS</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->siswa->nis }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Kelas</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Data Pelanggaran -->
        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Data Pelanggaran</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px; width: 200px;"><strong>Tanggal</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->tanggal->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Jenis Pelanggaran</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Kategori</strong></td>
                    <td style="padding: 8px;">: 
                        <span class="badge badge-{{ $pelanggaran->jenisPelanggaran->kategori == 'Ringan' ? 'success' : ($pelanggaran->jenisPelanggaran->kategori == 'Sedang' ? 'warning' : 'danger') }}">
                            {{ $pelanggaran->jenisPelanggaran->kategori }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Poin</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->point }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Keterangan</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Guru Pencatat</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->guruPencatat->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Status Verifikasi</strong></td>
                    <td style="padding: 8px;">: 
                        <span class="badge badge-{{ $pelanggaran->status_verifikasi == 'Terverifikasi' ? 'success' : 'warning' }}">
                            {{ $pelanggaran->status_verifikasi }}
                        </span>
                    </td>
                </tr>
                @if($pelanggaran->status_verifikasi == 'Terverifikasi')
                <tr>
                    <td style="padding: 8px;"><strong>Tanggal Verifikasi</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Guru Verifikator</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->guruVerifikator->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top;"><strong>Alasan Verifikasi</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->catatan_verifikasi ?? '-' }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Bukti Foto -->
        @if($pelanggaran->bukti_foto)
        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Bukti Foto</h4>
            <img src="{{ asset('storage/' . $pelanggaran->bukti_foto) }}" alt="Bukti Foto" style="max-width: 400px; border-radius: 8px; border: 1px solid #e5e7eb;">
        </div>
        @endif

        <!-- Sanksi -->
        @if($pelanggaran->sanksi)
        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Sanksi</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px; width: 200px;"><strong>Jenis Sanksi</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->sanksi->jenis_sanksi }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Deskripsi</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->sanksi->deskripsi_sanksi }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Periode</strong></td>
                    <td style="padding: 8px;">: {{ $pelanggaran->sanksi->tanggal_mulai->format('d/m/Y') }} - {{ $pelanggaran->sanksi->tanggal_selesai->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Status</strong></td>
                    <td style="padding: 8px;">: 
                        <span class="badge badge-{{ $pelanggaran->sanksi->status == 'Selesai' ? 'success' : 'primary' }}">
                            {{ $pelanggaran->sanksi->status }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        @endif
    </div>

    <div style="margin-top: 30px; display: flex; gap: 10px;">
        <a href="{{ route('pelanggaran.edit', $pelanggaran->pelanggaran_id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('pelanggaran.destroy', $pelanggaran->pelanggaran_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus pelanggaran ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>
@endsection
