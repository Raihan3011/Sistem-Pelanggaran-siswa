<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kelas {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 5px 0; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .section-title { font-size: 14px; font-weight: bold; margin-top: 30px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMK BAKTI NUSANTARA</h2>
        <h3>LAPORAN KELAS {{ strtoupper($kelas->nama_kelas) }}</h3>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="150"><strong>Nama Kelas</strong></td>
            <td>: {{ $kelas->nama_kelas }}</td>
            <td width="150"><strong>Jurusan</strong></td>
            <td>: {{ $kelas->jurusan }}</td>
        </tr>
        <tr>
            <td><strong>Wali Kelas</strong></td>
            <td>: {{ auth()->user()->nama_lengkap }}</td>
            <td><strong>Jumlah Siswa</strong></td>
            <td>: {{ $siswa->count() }} siswa</td>
        </tr>
    </table>

    <div class="section-title">DAFTAR SISWA</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS</th>
                <th width="30%">Nama Siswa</th>
                <th width="15%">Jenis Kelamin</th>
                <th width="20%">No. Telp</th>
                <th width="15%">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $s->no_telp ?? '-' }}</td>
                <td>{{ $pelanggaran->where('siswa_id', $s->siswa_id)->sum('point') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data siswa</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">RIWAYAT PELANGGARAN</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Nama Siswa</th>
                <th width="25%">Jenis Pelanggaran</th>
                <th width="10%">Poin</th>
                <th width="15%">Status</th>
                <th width="13%">Pencatat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggaran as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $p->siswa->nama_siswa }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                <td>{{ $p->point }}</td>
                <td>{{ $p->status_verifikasi }}</td>
                <td>{{ $p->guruPencatat->nama_lengkap ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 50px;">
        <table width="100%" style="border: none;">
            <tr style="border: none;">
                <td width="50%" style="border: none; text-align: center;">
                    <p>Mengetahui,<br>Kepala Sekolah</p>
                    <br><br><br>
                    <p>_____________________</p>
                </td>
                <td width="50%" style="border: none; text-align: center;">
                    <p>{{ date('d F Y') }}<br>Wali Kelas</p>
                    <br><br><br>
                    <p>{{ auth()->user()->nama_lengkap }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
