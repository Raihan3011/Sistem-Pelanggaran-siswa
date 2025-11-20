@extends('layouts.admin')

@section('title', 'Detail Sanksi')
@section('page-title', 'Detail Sanksi')
@section('page-description', 'Informasi lengkap sanksi pelanggaran')

@section('content')
<div class="content-card">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('sanksi.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; gap: 30px;">
        <!-- Informasi Sanksi -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 20px; color: var(--primary);">Informasi Sanksi</h3>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 10px 0; width: 200px; font-weight: 600;">Jenis Sanksi</td>
                    <td style="padding: 10px 0;">{{ $sanksi->jenis_sanksi }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Deskripsi</td>
                    <td style="padding: 10px 0;">{{ $sanksi->deskripsi_sanksi }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Tanggal Mulai</td>
                    <td style="padding: 10px 0;">{{ $sanksi->tanggal_mulai->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Tanggal Selesai</td>
                    <td style="padding: 10px 0;">{{ $sanksi->tanggal_selesai->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Guru Penanggung Jawab</td>
                    <td style="padding: 10px 0;">{{ $sanksi->guruPenanggungJawab->nama_lengkap ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Informasi Pelanggaran -->
        <div style="background: #fef3c7; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 20px; color: #f59e0b;">Informasi Pelanggaran</h3>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 10px 0; width: 200px; font-weight: 600;">Nama Siswa</td>
                    <td style="padding: 10px 0;">{{ $sanksi->pelanggaran->siswa->nama_siswa ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Kelas</td>
                    <td style="padding: 10px 0;">{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Jenis Pelanggaran</td>
                    <td style="padding: 10px 0;">{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Tanggal Pelanggaran</td>
                    <td style="padding: 10px 0;">{{ $sanksi->pelanggaran->tanggal->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Poin</td>
                    <td style="padding: 10px 0;"><strong style="color: #ef4444;">{{ $sanksi->pelanggaran->jenisPelanggaran->poin ?? 0 }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Keterangan</td>
                    <td style="padding: 10px 0;">{{ $sanksi->pelanggaran->keterangan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if(in_array(auth()->user()->level, ['admin', 'kesiswaan']))
    <div style="margin-top: 30px; display: flex; gap: 10px;">
        <a href="{{ route('sanksi.edit', $sanksi->sanksi_id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('sanksi.destroy', $sanksi->sanksi_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus sanksi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
