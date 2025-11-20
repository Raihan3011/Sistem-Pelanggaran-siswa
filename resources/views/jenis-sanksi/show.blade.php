@extends('layouts.admin')

@section('page-title', 'Detail Jenis Sanksi')
@section('page-description', 'Informasi detail jenis sanksi')

@section('content')
<div class="content-card">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('jenis-sanksi.index') }}" class="btn" style="background: #6b7280; color: white;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Nama Sanksi</label>
            <p style="font-size: 1.1rem;">{{ $jenisSanksi->nama_sanksi }}</p>
        </div>
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Range Poin</label>
            <p style="font-size: 1.1rem;">{{ $jenisSanksi->poin_minimal }} - {{ $jenisSanksi->poin_maksimal }}</p>
        </div>
        <div style="grid-column: 1 / -1;">
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Deskripsi</label>
            <p style="font-size: 1rem; line-height: 1.6;">{{ $jenisSanksi->deskripsi }}</p>
        </div>
    </div>
</div>
@endsection
