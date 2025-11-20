<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggaran Per Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2, h3 { text-align: center; margin: 5px 0; }
        .info { margin: 20px 0; }
        .info table { width: 50%; }
        .info td { padding: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        th { background: #f0f0f0; }
        .text-center { text-align: center; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <h2>SMK Bakti Nusantara 666</h2>
    <h3>Laporan Pelanggaran Per Siswa</h3>
    
    <div class="info">
        <table>
            <tr>
                <td width="30%"><strong>NIS</strong></td>
                <td>: {{ $siswa->nis }}</td>
            </tr>
            <tr>
                <td><strong>Nama</strong></td>
                <td>: {{ $siswa->nama }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="50%">Jenis Pelanggaran</th>
                <th width="15%">Poin</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggaran as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                <td class="text-center">{{ $p->point }}</td>
                <td class="text-center">{{ $p->status_verifikasi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-center">Total Poin</th>
                <th class="text-center">{{ $pelanggaran->sum('point') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    
    <div style="margin-top: 50px; text-align: right;">
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>
</body>
</html>
