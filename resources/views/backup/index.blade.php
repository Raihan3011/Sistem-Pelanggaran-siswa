@extends('layouts.admin')

@section('title', 'Backup Database')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard-style.css') }}">

<div class="dashboard-welcome">
    <div class="welcome-content">
        <h1><i class="bi bi-database"></i> Backup Database</h1>
        <p>Kelola backup database sistem secara otomatis dan manual</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<div class="content-section">
    <div class="section-header">
        <h2><i class="bi bi-info-circle"></i> Jadwal Backup Otomatis</h2>
    </div>
    <div class="backup-schedule">
        <div class="schedule-item">
            <i class="bi bi-clock"></i>
            <div>
                <strong>Daily Backup</strong>
                <p>Setiap hari pukul 00:00 WIB</p>
            </div>
        </div>
        <div class="schedule-item">
            <i class="bi bi-calendar-week"></i>
            <div>
                <strong>Weekly Full Backup</strong>
                <p>Setiap Minggu pukul 02:00 WIB</p>
            </div>
        </div>
        <div class="schedule-item">
            <i class="bi bi-calendar-month"></i>
            <div>
                <strong>Monthly Archive</strong>
                <p>Setiap akhir bulan pukul 23:00 WIB</p>
            </div>
        </div>
    </div>
</div>

<div class="content-section">
    <div class="section-header">
        <h2><i class="bi bi-plus-circle"></i> Backup Manual</h2>
    </div>
    <form action="{{ route('backup.create') }}" method="POST" style="display: flex; gap: 10px; margin-bottom: 20px;">
        @csrf
        <select name="type" class="form-control" style="max-width: 200px;">
            <option value="daily">Daily Backup</option>
            <option value="weekly">Weekly Backup</option>
            <option value="monthly">Monthly Backup</option>
        </select>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-download"></i> Buat Backup Sekarang
        </button>
    </form>
</div>

<div class="content-section">
    <div class="section-header">
        <h2><i class="bi bi-calendar-day"></i> Daily Backups</h2>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Ukuran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailyBackups as $backup)
                <tr>
                    <td>{{ $backup['name'] }}</td>
                    <td>{{ $backup['size'] }}</td>
                    <td>{{ $backup['date'] }}</td>
                    <td>
                        <a href="{{ route('backup.download', ['type' => 'daily', 'filename' => $backup['name']]) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <form action="{{ route('backup.restore', ['type' => 'daily', 'filename' => $backup['name']]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin restore backup ini? Data saat ini akan diganti!')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning">
                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                            </button>
                        </form>
                        <form action="{{ route('backup.delete', ['type' => 'daily', 'filename' => $backup['name']]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin hapus backup ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada backup daily</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="content-section">
    <div class="section-header">
        <h2><i class="bi bi-calendar-week"></i> Weekly Backups</h2>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Ukuran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($weeklyBackups as $backup)
                <tr>
                    <td>{{ $backup['name'] }}</td>
                    <td>{{ $backup['size'] }}</td>
                    <td>{{ $backup['date'] }}</td>
                    <td>
                        <a href="{{ route('backup.download', ['type' => 'weekly', 'filename' => $backup['name']]) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <form action="{{ route('backup.restore', ['type' => 'weekly', 'filename' => $backup['name']]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin restore backup ini?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning">
                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                            </button>
                        </form>
                        <form action="{{ route('backup.delete', ['type' => 'weekly', 'filename' => $backup['name']]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin hapus backup ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada backup weekly</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="content-section">
    <div class="section-header">
        <h2><i class="bi bi-calendar-month"></i> Monthly Backups</h2>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Ukuran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($monthlyBackups as $backup)
                <tr>
                    <td>{{ $backup['name'] }}</td>
                    <td>{{ $backup['size'] }}</td>
                    <td>{{ $backup['date'] }}</td>
                    <td>
                        <a href="{{ route('backup.download', ['type' => 'monthly', 'filename' => $backup['name']]) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <form action="{{ route('backup.restore', ['type' => 'monthly', 'filename' => $backup['name']]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin restore backup ini?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning">
                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                            </button>
                        </form>
                        <form action="{{ route('backup.delete', ['type' => 'monthly', 'filename' => $backup['name']]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin hapus backup ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada backup monthly</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.backup-schedule {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.schedule-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, #e0f2fe, #bae6fd);
    border-radius: 10px;
}

.schedule-item i {
    font-size: 2rem;
    color: #0ea5e9;
}

.schedule-item strong {
    display: block;
    color: #0284c7;
    margin-bottom: 5px;
}

.schedule-item p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background: #d1fae5;
    border: 1px solid #a7f3d0;
    color: #065f46;
}

.alert-danger {
    background: #fee2e2;
    border: 1px solid #fecaca;
    color: #dc2626;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: white;
}

.btn-info {
    background: #0ea5e9;
    color: white;
}

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-sm {
    padding: 6px 12px;
    font-size: 0.875rem;
}

.form-control {
    padding: 10px 15px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #0ea5e9;
}
</style>
@endsection
