@extends('layouts.admin')

@section('page-title', 'Detail Verifikator')
@section('page-description', 'Informasi detail verifikator')

@section('content')
<div class="content-card">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('verifikator.index') }}" class="btn" style="background: #6b7280; color: white;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Nama Verifikator</label>
            <p style="font-size: 1.1rem;">{{ $verifikator->nama_verifikator }}</p>
        </div>
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">NIP</label>
            <p style="font-size: 1.1rem;">{{ $verifikator->nip ?? '-' }}</p>
        </div>
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Username</label>
            <p style="font-size: 1.1rem;">{{ $verifikator->user->username ?? '-' }}</p>
        </div>
        <div>
            <label style="font-weight: 600; color: #666; display: block; margin-bottom: 5px;">Status</label>
            <p style="font-size: 1.1rem;">
                @if($verifikator->status == 'Aktif')
                    <span style="background: var(--success); color: white; padding: 4px 12px; border-radius: 4px;">Aktif</span>
                @else
                    <span style="background: #6b7280; color: white; padding: 4px 12px; border-radius: 4px;">Nonaktif</span>
                @endif
            </p>
        </div>
    </div>
</div>
@endsection
