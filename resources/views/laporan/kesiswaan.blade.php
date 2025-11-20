@extends('layouts.admin')

@section('title', 'Cetak Laporan PDF')
@section('page-title', 'Cetak Laporan Kesiswaan')
@section('page-description', 'Cetak laporan data kesiswaan sekolah')

@section('content')
<div class="content-card">
    <h3 style="margin-bottom: 20px;">Laporan Data Kesiswaan</h3>
    
    <div style="background: #f9fafb; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <p style="margin-bottom: 10px;">Laporan ini berisi:</p>
        <ul style="margin-left: 20px;">
            <li>Statistik keseluruhan (total siswa, kelas, pelanggaran)</li>
            <li>Daftar semua kelas dengan jumlah siswa</li>
            <li>Daftar semua siswa per kelas</li>
            <li>Riwayat pelanggaran seluruh sekolah</li>
        </ul>
    </div>
    
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('laporan.kesiswaan.pdf') }}" class="btn btn-danger" style="padding: 15px 30px; font-size: 1.1rem;">
            <i class="bi bi-file-earmark-pdf"></i> Download Laporan PDF
        </a>
    </div>
    
    <div class="alert" style="background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd;">
        <i class="bi bi-info-circle"></i> Laporan akan berisi data lengkap kesiswaan sekolah
    </div>
</div>
@endsection
