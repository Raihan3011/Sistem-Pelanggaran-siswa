<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggaran Per Kelas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2, h3 { text-align: center; margin: 5px 0; }
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
    <h3>Laporan Pelanggaran Per Kelas</h3>
    <p class="text-center">Kelas: 
        @if($kelas->tingkat && $kelas->jurusan && $kelas->rombel)
            {{ $kelas->tingkat }} {{ $kelas->jurusan }} {{ $kelas->rombel }}
        @else
            {{ $kelas->nama_kelas }}
        @endif
    </p>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="15%">NIS</th>
                <th width="23%">Nama Siswa</th>
                <th width="30%">Jenis Pelanggaran</th>
                <th width="10%">Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggaran as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                <td>{{ $p->siswa->nis }}</td>
                <td>{{ $p->siswa->nama }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                <td class="text-center">{{ $p->point }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-center">Total Poin</th>
                <th class="text-center">{{ $pelanggaran->sum('point') }}</th>
            </tr>
        </tfoot>
    </table>
    
    <div style="margin-top: 50px; text-align: right;">
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>
</body>
</html>
