@extends('layouts.admin')

@section('page-title', 'Edit Verifikator')
@section('page-description', 'Edit verifikator')

@section('content')
<div class="content-card">
    <form action="{{ route('verifikator.update', $verifikator) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">User</label>
            <select name="user_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                <option value="">Pilih User</option>
                @foreach($users as $u)
                    <option value="{{ $u->user_id }}" {{ old('user_id', $verifikator->user_id) == $u->user_id ? 'selected' : '' }}>
                        {{ $u->nama_lengkap }} ({{ $u->username }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Verifikator</label>
            <input type="text" name="nama_verifikator" class="form-control" value="{{ old('nama_verifikator', $verifikator->nama_verifikator) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            @error('nama_verifikator')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">NIP (Opsional)</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $verifikator->nip) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            @error('nip')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Status</label>
            <select name="status" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                <option value="Aktif" {{ old('status', $verifikator->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ old('status', $verifikator->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')
                <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ route('verifikator.index') }}" class="btn" style="background: #6b7280; color: white;">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
