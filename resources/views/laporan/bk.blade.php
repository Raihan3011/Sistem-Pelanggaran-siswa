@extends('layouts.admin')

@section('title', 'Cetak Laporan PDF')
@section('page-title', 'Cetak Laporan Bimbingan Konseling')
@section('page-description', 'Cetak laporan bimbingan konseling dan pelanggaran siswa')

@section('content')
<div class="content-card">
    <h3 style="margin-bottom: 20px;">Laporan Bimbingan Konseling</h3>
    
    <div style="background: #f9fafb; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <p style="margin-bottom: 10px;">Laporan ini berisi:</p>
        <ul style="margin-left: 20px;">
            <li>Statistik bimbingan konseling</li>
            <li>Daftar siswa yang dibimbing</li>
            <li>Riwayat bimbingan konseling</li>
            <li>Data pelanggaran siswa yang memerlukan bimbingan</li>
        </ul>
    </div>
    
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('laporan.bk.pdf') }}" class="btn btn-danger" style="padding: 15px 30px; font-size: 1.1rem;">
            <i class="bi bi-file-earmark-pdf"></i> Download Laporan PDF
        </a>
    </div>
    
    <div class="alert" style="background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd;">
        <i class="bi bi-info-circle"></i> Laporan akan berisi data lengkap bimbingan konseling dan pelanggaran siswa
    </div>
</div>
@endsection
