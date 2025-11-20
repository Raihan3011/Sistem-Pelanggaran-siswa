@extends('layouts.admin')

@section('title', 'Detail Wali Kelas')
@section('page-title', 'Detail Wali Kelas')
@section('page-description', 'Informasi lengkap wali kelas')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Detail Wali Kelas</h3>
        <a href="{{ route('wali-kelas.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Data Wali Kelas</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px; width: 200px;"><strong>NIP</strong></td>
                    <td style="padding: 8px;">: {{ $waliKela->nip }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Nama Guru</strong></td>
                    <td style="padding: 8px;">: {{ $waliKela->nama_guru }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Jenis Kelamin</strong></td>
                    <td style="padding: 8px;">: {{ $waliKela->jenis_kelamin_text }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Bidang Studi</strong></td>
                    <td style="padding: 8px;">: {{ $waliKela->bidang_studi }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Email</strong></td>
                    <td style="padding: 8px;">: {{ $waliKela->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>No. Telepon</strong></td>
                    <td style="padding: 8px;">: {{ $waliKela->no_telp ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Status</strong></td>
                    <td style="padding: 8px;">: 
                        <span class="badge badge-{{ $waliKela->status == 'Aktif' ? 'success' : 'danger' }}">
                            {{ $waliKela->status }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Kelas yang Diampu</h4>
            @if($waliKela->kelas)
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px; width: 200px;"><strong>Kelas</strong></td>
                    <td style="padding: 8px;">: {{ $waliKela->kelas->tingkat }} {{ $waliKela->kelas->jurusan }} {{ $waliKela->kelas->rombel }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Jumlah Siswa</strong></td>
                    <td style="padding: 8px;">: {{ $waliKela->kelas->siswa->count() }} siswa</td>
                </tr>
            </table>
            @else
            <p style="color: #666; padding: 20px 0;">Belum ada kelas yang diampu</p>
            @endif
        </div>
    </div>

    <div style="margin-top: 30px; display: flex; gap: 10px;">
        <a href="{{ route('wali-kelas.edit', $waliKela->wali_kelas_id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('wali-kelas.destroy', $waliKela->wali_kelas_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus wali kelas ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>
@endsection
