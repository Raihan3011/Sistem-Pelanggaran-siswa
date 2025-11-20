@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')
@section('page-description', 'Informasi lengkap siswa')

@section('content')
<div class="content-card">
    <div style="display: grid; grid-template-columns: 200px 1fr; gap: 30px;">
        <div>
            @if($siswa->foto)
                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto" style="width: 100%; border-radius: 10px;">
            @else
                <div style="width: 100%; height: 200px; background: var(--light); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-person" style="font-size: 80px; color: #ccc;"></i>
                </div>
            @endif
        </div>

        <div>
            <h3 style="margin-bottom: 20px;">{{ $siswa->nama_siswa }}</h3>
            
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 10px 0; font-weight: 600; width: 200px;">NIS</td>
                    <td style="padding: 10px 0;">{{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">NISN</td>
                    <td style="padding: 10px 0;">{{ $siswa->nisn }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Kelas</td>
                    <td style="padding: 10px 0;">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Jenis Kelamin</td>
                    <td style="padding: 10px 0;">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Tempat, Tanggal Lahir</td>
                    <td style="padding: 10px 0;">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">Alamat</td>
                    <td style="padding: 10px 0;">{{ $siswa->alamat }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: 600;">No. Telepon</td>
                    <td style="padding: 10px 0;">{{ $siswa->no_telp ?? '-' }}</td>
                </tr>
            </table>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('siswa.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">

    <h4 style="margin-bottom: 20px;">Riwayat Pelanggaran</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa->pelanggaran as $p)
            <tr>
                <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                <td>{{ $p->point }}</td>
                <td>{{ $p->status_verifikasi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #666;">Belum ada riwayat pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection