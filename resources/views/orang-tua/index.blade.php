@extends('layouts.admin')

@section('title', 'Data Orang Tua')
@section('page-title', 'Data Orang Tua')
@section('page-description', 'Kelola data orang tua siswa')

@section('content')
<div class="content-card">
    @php
        $currentOrangTua = \App\Models\OrangTua::where('user_id', auth()->id())->first();
    @endphp
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>{{ $currentOrangTua ? 'Data Keluarga Anak Anda' : 'Daftar Orang Tua' }}</h3>
        @if(!$currentOrangTua || in_array(auth()->user()->level, ['admin', 'kesiswaan']))
            <a href="{{ route('orang-tua.create') }}" class="btn btn-primary">
                <i class="bi bi-link"></i> Sambungkan Orang Tua
            </a>
        @elseif(auth()->user()->level == 'wali_kelas')
            @php
                $kelasWali = \App\Models\Kelas::where('wali_kelas_id', auth()->id())->first();
            @endphp
            @if($kelasWali)
                <a href="{{ route('orang-tua.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Orang Tua
                </a>
            @endif
        @endif
    </div>
    
    @if($currentOrangTua && $currentOrangTua->siswa_id)
    <div class="alert alert-info" style="margin-bottom: 20px;">
        <i class="bi bi-info-circle"></i> Anda melihat data keluarga untuk anak: <strong>{{ $currentOrangTua->siswa->nama_siswa }}</strong>
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nama Orang Tua</th>
                <th>Hubungan</th>
                <th>Nama Siswa</th>
                <th>Pekerjaan</th>
                <th>No. Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orangTua as $ot)
            <tr>
                <td>{{ $ot->nama_orang_tua }}</td>
                <td>
                    <span class="badge badge-{{ $ot->hubungan == 'Ayah' ? 'primary' : ($ot->hubungan == 'Ibu' ? 'success' : 'warning') }}">
                        {{ $ot->hubungan }}
                    </span>
                </td>
                <td>
                    @if($ot->siswa_id)
                        {{ $ot->siswa->nama }}
                    @else
                        <span class="badge badge-danger">Belum Tersambung</span>
                    @endif
                </td>
                <td>{{ $ot->pekerjaan ?? '-' }}</td>
                <td>{{ $ot->no_telp ?? '-' }}</td>
                <td>
                    <a href="{{ route('orang-tua.show', $ot->orang_tua_id) }}" class="btn btn-sm btn-info" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    @if(!$currentOrangTua || in_array(auth()->user()->level, ['admin', 'kesiswaan', 'wali_kelas']))
                    <a href="{{ route('orang-tua.edit', $ot->orang_tua_id) }}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('orang-tua.destroy', $ot->orang_tua_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data orang tua ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                    @if(auth()->user()->level == 'wali_kelas')
                        @php
                            $kelas = \App\Models\Kelas::where('wali_kelas_id', auth()->id())->first();
                        @endphp
                        @if(!$kelas)
                            <div style="color: #dc3545;">
                                <i class="bi bi-exclamation-triangle" style="font-size: 2rem; margin-bottom: 10px;"></i>
                                <h5>Anda Belum Memiliki Kelas</h5>
                                <p>Silahkan Hubungi Admin Untuk Melakukan Input Kelas</p>
                            </div>
                        @else
                            <div style="color: #666;">
                                <i class="bi bi-people" style="font-size: 2rem; margin-bottom: 10px;"></i>
                                <p>Belum ada data orang tua untuk siswa di kelas {{ $kelas->nama_kelas }}</p>
                            </div>
                        @endif
                    @else
                        <div style="color: #666;">
                            <i class="bi bi-people" style="font-size: 2rem; margin-bottom: 10px;"></i>
                            <p>Belum ada data orang tua</p>
                        </div>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
