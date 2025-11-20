@extends('layouts.admin')

@section('title', 'Detail Orang Tua')
@section('page-title', 'Detail Orang Tua')
@section('page-description', 'Informasi lengkap orang tua siswa')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Detail Orang Tua</h3>
        <a href="{{ route('orang-tua.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Data Orang Tua</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px; width: 200px;"><strong>Nama</strong></td>
                    <td style="padding: 8px;">: {{ $orangTua->nama_orang_tua }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Hubungan</strong></td>
                    <td style="padding: 8px;">: 
                        <span class="badge badge-{{ $orangTua->hubungan == 'Ayah' ? 'primary' : ($orangTua->hubungan == 'Ibu' ? 'success' : 'warning') }}">
                            {{ $orangTua->hubungan }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Pekerjaan</strong></td>
                    <td style="padding: 8px;">: {{ $orangTua->pekerjaan ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Pendidikan</strong></td>
                    <td style="padding: 8px;">: {{ $orangTua->pendidikan ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>No. Telepon</strong></td>
                    <td style="padding: 8px;">: {{ $orangTua->no_telp ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Alamat</strong></td>
                    <td style="padding: 8px;">: {{ $orangTua->alamat }}</td>
                </tr>
            </table>
        </div>

        <div style="grid-column: 1 / -1;">
            <h4 style="margin-bottom: 15px; color: var(--primary);">Data Siswa</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px; width: 200px;"><strong>NIS</strong></td>
                    <td style="padding: 8px;">: {{ $orangTua->siswa->nis }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Nama</strong></td>
                    <td style="padding: 8px;">: {{ $orangTua->siswa->nama }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><strong>Kelas</strong></td>
                    <td style="padding: 8px;">: {{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div style="margin-top: 30px; display: flex; gap: 10px;">
        <a href="{{ route('orang-tua.edit', $orangTua->orang_tua_id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('orang-tua.destroy', $orangTua->orang_tua_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data orang tua ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>
@endsection
