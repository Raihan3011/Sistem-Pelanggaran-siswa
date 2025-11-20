@extends('layouts.admin')

@section('page-title', 'Detail Tahun Ajaran')
@section('page-description', 'Detail informasi tahun ajaran')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h4 style="margin: 0;">Detail Tahun Ajaran</h4>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('tahun-ajaran.edit', $tahunAjaran) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('tahun-ajaran.index') }}" class="btn" style="background: #6b7280; color: white;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
        <div>
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 10px 0; text-align: left; width: 40%; font-weight: 600;">Kode Tahun</th>
                    <td style="padding: 10px 0;">: {{ $tahunAjaran->kode_tahun }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 10px 0; text-align: left; font-weight: 600;">Tahun Ajaran</th>
                    <td style="padding: 10px 0;">: {{ $tahunAjaran->tahun_ajaran }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 10px 0; text-align: left; font-weight: 600;">Semester</th>
                    <td style="padding: 10px 0;">: {{ $tahunAjaran->semester == 1 ? 'Ganjil' : 'Genap' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 10px 0; text-align: left; font-weight: 600;">Tanggal Mulai</th>
                    <td style="padding: 10px 0;">: {{ \Carbon\Carbon::parse($tahunAjaran->tanggal_mulai)->format('d F Y') }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 10px 0; text-align: left; font-weight: 600;">Tanggal Selesai</th>
                    <td style="padding: 10px 0;">: {{ \Carbon\Carbon::parse($tahunAjaran->tanggal_selesai)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th style="padding: 10px 0; text-align: left; font-weight: 600;">Status</th>
                    <td style="padding: 10px 0;">: 
                        @if($tahunAjaran->status_aktif)
                            <span style="background: var(--success); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Aktif</span>
                        @else
                            <span style="background: #6b7280; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <div style="background: var(--light); padding: 20px; border-radius: 10px;">
                <h5 style="margin: 0 0 20px 0; font-weight: 600;">Statistik Data</h5>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; text-align: center;">
                    <div style="padding-right: 20px; border-right: 1px solid #d1d5db;">
                        <h4 style="color: var(--primary); margin: 0;">{{ $tahunAjaran->wali_kelas_count ?? 0 }}</h4>
                        <small style="color: #666;">Wali Kelas</small>
                    </div>
                    <div>
                        <h4 style="color: #0ea5e9; margin: 0;">{{ $tahunAjaran->pelanggaran_count ?? 0 }}</h4>
                        <small style="color: #666;">Pelanggaran</small>
                    </div>
                </div>
                <hr style="margin: 20px 0; border: none; border-top: 1px solid #d1d5db;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; text-align: center;">
                    <div style="padding-right: 20px; border-right: 1px solid #d1d5db;">
                        <h4 style="color: var(--success); margin: 0;">{{ $tahunAjaran->prestasi_count ?? 0 }}</h4>
                        <small style="color: #666;">Prestasi</small>
                    </div>
                    <div>
                        <h4 style="color: var(--warning); margin: 0;">{{ $tahunAjaran->bimbingan_konseling_count ?? 0 }}</h4>
                        <small style="color: #666;">Bimbingan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($tahunAjaran->waliKelas->count() > 0)
    <div style="margin-top: 30px;">
        <h5 style="margin-bottom: 20px; font-weight: 600;">Daftar Wali Kelas</h5>
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Kelas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tahunAjaran->waliKelas as $index => $wali)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $wali->user->name ?? '-' }}</td>
                        <td>{{ $wali->kelas->nama_kelas ?? '-' }}</td>
                        <td>
                            @if($wali->status_aktif)
                                <span style="background: var(--success); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Aktif</span>
                            @else
                                <span style="background: #6b7280; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection