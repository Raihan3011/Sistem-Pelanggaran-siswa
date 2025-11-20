<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kesiswaan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 5px 0; }
        .statistik { margin-bottom: 20px; }
        .statistik table { width: 100%; }
        .statistik td { padding: 5px; border: 1px solid #ddd; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .section-title { font-size: 13px; font-weight: bold; margin-top: 25px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMK BAKTI NUSANTARA</h2>
        <h3>LAPORAN DATA KESISWAAN</h3>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="statistik">
        <strong>STATISTIK KESELURUHAN</strong>
        <table>
            <tr>
                <td width="25%"><strong>Total Siswa</strong></td>
                <td width="25%">{{ $statistik['total_siswa'] }} siswa</td>
                <td width="25%"><strong>Total Kelas</strong></td>
                <td width="25%">{{ $statistik['total_kelas'] }} kelas</td>
            </tr>
            <tr>
                <td><strong>Total Pelanggaran</strong></td>
                <td>{{ $statistik['total_pelanggaran'] }}</td>
                <td><strong>Terverifikasi</strong></td>
                <td>{{ $statistik['pelanggaran_terverifikasi'] }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">DAFTAR KELAS</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Kelas</th>
                <th width="20%">Jurusan</th>
                <th width="20%">Wali Kelas</th>
                <th width="15%">Jumlah Siswa</th>
                <th width="10%">Kapasitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelas as $index => $k)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $k->nama_kelas }}</td>
                <td>{{ $k->jurusan }}</td>
                <td>{{ $k->waliKelas->nama_lengkap ?? '-' }}</td>
                <td>{{ $k->siswa_count }}</td>
                <td>{{ $k->kapasitas }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">DAFTAR SISWA PER KELAS</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS</th>
                <th width="30%">Nama Siswa</th>
                <th width="20%">Kelas</th>
                <th width="15%">Jenis Kelamin</th>
                <th width="15%">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $s->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                <td>{{ $pelanggaran->where('siswa_id', $s->siswa_id)->sum('point') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">RIWAYAT PELANGGARAN</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tanggal</th>
                <th width="20%">Nama Siswa</th>
                <th width="15%">Kelas</th>
                <th width="25%">Jenis Pelanggaran</th>
                <th width="8%">Poin</th>
                <th width="12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggaran->take(50) as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $p->siswa->nama_siswa }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                <td>{{ $p->point }}</td>
                <td>{{ $p->status_verifikasi }}</td>
            </tr>
            @endforeach
            @if($pelanggaran->count() > 50)
            <tr>
                <td colspan="7" style="text-align: center; font-style: italic;">
                    Menampilkan 50 dari {{ $pelanggaran->count() }} pelanggaran
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 40px;">
        <table width="100%" style="border: none;">
            <tr style="border: none;">
                <td width="50%" style="border: none; text-align: center;">
                    <p>Mengetahui,<br>Kepala Sekolah</p>
                    <br><br><br>
                    <p>_____________________</p>
                </td>
                <td width="50%" style="border: none; text-align: center;">
                    <p>{{ date('d F Y') }}<br>Bagian Kesiswaan</p>
                    <br><br><br>
                    <p>{{ auth()->user()->nama_lengkap }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
