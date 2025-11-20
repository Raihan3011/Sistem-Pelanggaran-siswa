<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bimbingan Konseling</title>
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
        <h3>LAPORAN BIMBINGAN KONSELING</h3>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="statistik">
        <strong>STATISTIK BIMBINGAN KONSELING</strong>
        <table>
            <tr>
                <td width="33%"><strong>Total Bimbingan</strong></td>
                <td width="33%">{{ $statistik['total_bimbingan'] }} sesi</td>
                <td width="34%"><strong>Siswa Dibimbing</strong></td>
            </tr>
            <tr>
                <td><strong>Total Pelanggaran</strong></td>
                <td>{{ $statistik['total_pelanggaran'] }}</td>
                <td>{{ $statistik['total_siswa_dibimbing'] }} siswa</td>
            </tr>
        </table>
    </div>

    <div class="section-title">RIWAYAT BIMBINGAN KONSELING</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Nama Siswa</th>
                <th width="12%">Kelas</th>
                <th width="30%">Permasalahan</th>
                <th width="21%">Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bimbingan as $index => $b)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $b->siswa->nama_siswa }}</td>
                <td>{{ $b->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $b->permasalahan }}</td>
                <td>{{ $b->tindak_lanjut ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data bimbingan konseling</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">SISWA DENGAN PELANGGARAN TINGGI (Perlu Bimbingan)</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS</th>
                <th width="25%">Nama Siswa</th>
                <th width="15%">Kelas</th>
                <th width="15%">Total Poin</th>
                <th width="25%">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $siswaPerluBimbingan = $siswa->filter(function($s) use ($pelanggaran) {
                    $totalPoin = $pelanggaran->where('siswa_id', $s->siswa_id)->sum('point');
                    return $totalPoin >= 50;
                })->sortByDesc(function($s) use ($pelanggaran) {
                    return $pelanggaran->where('siswa_id', $s->siswa_id)->sum('point');
                });
            @endphp
            @forelse($siswaPerluBimbingan->take(20) as $index => $s)
            @php
                $totalPoin = $pelanggaran->where('siswa_id', $s->siswa_id)->sum('point');
                $sudahDibimbing = $bimbingan->where('siswa_id', $s->siswa_id)->count() > 0;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $totalPoin }}</td>
                <td>{{ $sudahDibimbing ? 'Sudah Dibimbing' : 'Perlu Bimbingan' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada siswa dengan poin tinggi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">PELANGGARAN TERBARU</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Nama Siswa</th>
                <th width="15%">Kelas</th>
                <th width="30%">Jenis Pelanggaran</th>
                <th width="10%">Poin</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggaran->take(30) as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $p->siswa->nama_siswa }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                <td>{{ $p->point }}</td>
                <td>{{ substr($p->status_verifikasi, 0, 1) }}</td>
            </tr>
            @endforeach
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
                    <p>{{ date('d F Y') }}<br>Guru BK</p>
                    <br><br><br>
                    <p>{{ auth()->user()->nama_lengkap }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
