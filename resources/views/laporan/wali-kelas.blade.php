@extends('layouts.admin')

@section('title', 'Cetak Laporan PDF')
@section('page-title', 'Cetak Laporan Kelas')
@section('page-description', 'Cetak laporan pelanggaran kelas ' . ($kelas->nama_kelas ?? ''))

@section('content')
<div class="content-card">
    <h3 style="margin-bottom: 20px;">Laporan Kelas {{ $kelas->nama_kelas }}</h3>
    
    <div style="background: #f9fafb; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
            <div>
                <strong>Nama Kelas:</strong> {{ $kelas->nama_kelas }}
            </div>
            <div>
                <strong>Jurusan:</strong> {{ $kelas->jurusan }}
            </div>
            <div>
                <strong>Wali Kelas:</strong> {{ auth()->user()->nama_lengkap }}
            </div>
            <div>
                <strong>Kapasitas:</strong> {{ $kelas->kapasitas }} siswa
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('laporan.wali-kelas.pdf') }}" class="btn btn-danger" style="padding: 15px 30px; font-size: 1.1rem;">
            <i class="bi bi-file-earmark-pdf"></i> Download Laporan PDF
        </a>
    </div>
    
    <div class="alert" style="background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd;">
        <i class="bi bi-info-circle"></i> Laporan akan berisi data siswa dan pelanggaran kelas {{ $kelas->nama_kelas }}
    </div>
</div>
@endsection
