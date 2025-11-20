@extends('layouts.admin')

@section('title', 'Detail Bimbingan Konseling')
@section('page-title', 'Detail Bimbingan Konseling')
@section('page-description', 'Informasi lengkap bimbingan konseling')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Detail Bimbingan Konseling</h3>
        <a href="{{ route('bimbingan-konseling.index') }}" class="btn btn-secondary">
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
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->siswa->nama_siswa }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>NIS</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->siswa->nis }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Kelas</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Wali Kelas</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->siswa->kelas->waliKelas->name ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Data Bimbingan -->
        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Data Bimbingan Konseling</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px; width: 200px;"><strong>Tanggal Konseling</strong></td>
                    <td style="padding: 8px;">: {{ \Carbon\Carbon::parse($bimbinganKonseling->tanggal_konseling)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Guru BK</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->guruKonselor->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Jenis Layanan</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->jenis_layanan }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Topik</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->topik }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top;"><strong>Keluhan/Masalah</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->keluhan_masalah }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top;"><strong>Tindakan/Solusi</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->tindakan_solusi ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Status</strong></td>
                    <td style="padding: 8px;">: 
                        @if($bimbinganKonseling->status == 'Pending')
                            <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(107, 114, 128, 0.1); color: #6b7280;">Pending</span>
                        @elseif($bimbinganKonseling->status == 'Proses')
                            <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">Proses</span>
                        @elseif($bimbinganKonseling->status == 'Selesai')
                            <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(16, 185, 129, 0.1); color: #10b981;">Selesai</span>
                        @else
                            <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(59, 130, 246, 0.1); color: #3b82f6;">Tindak Lanjut</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Tahun Ajaran</strong></td>
                    <td style="padding: 8px;">: {{ $bimbinganKonseling->tahunAjaran->tahun_ajaran ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div style="margin-top: 30px; display: flex; gap: 10px;">
        @php
            $isOrangTua = \App\Models\OrangTua::where('user_id', auth()->id())->exists();
        @endphp
        @if(!$isOrangTua && $bimbinganKonseling->status != 'Selesai')
        <a href="{{ route('bimbingan-konseling.edit', $bimbinganKonseling->bk_id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('bimbingan-konseling.destroy', $bimbinganKonseling->bk_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
