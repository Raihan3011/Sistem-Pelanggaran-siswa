<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggaran = [
            // RINGAN (1-15 poin)
            ['nama_pelanggaran' => 'Terlambat masuk kelas', 'kategori' => 'Ringan', 'poin_minimal' => 1, 'poin_maksimal' => 5, 'deskripsi' => 'Datang terlambat ke kelas tanpa alasan yang jelas', 'sanksi_rekomendasi' => 'Teguran lisan dan membuat surat pernyataan'],
            ['nama_pelanggaran' => 'Tidak mengerjakan PR', 'kategori' => 'Ringan', 'poin_minimal' => 2, 'poin_maksimal' => 5, 'deskripsi' => 'Tidak menyelesaikan tugas rumah yang diberikan guru', 'sanksi_rekomendasi' => 'Teguran dan wajib mengerjakan PR'],
            ['nama_pelanggaran' => 'Tidak memakai atribut lengkap', 'kategori' => 'Ringan', 'poin_minimal' => 3, 'poin_maksimal' => 8, 'deskripsi' => 'Tidak memakai dasi, topi, atau atribut sekolah lainnya', 'sanksi_rekomendasi' => 'Teguran dan penyitaan atribut'],
            ['nama_pelanggaran' => 'Berpakaian tidak rapi', 'kategori' => 'Ringan', 'poin_minimal' => 2, 'poin_maksimal' => 7, 'deskripsi' => 'Baju tidak dimasukkan, sepatu tidak sesuai aturan', 'sanksi_rekomendasi' => 'Teguran dan pembinaan'],
            ['nama_pelanggaran' => 'Rambut tidak sesuai aturan', 'kategori' => 'Ringan', 'poin_minimal' => 3, 'poin_maksimal' => 10, 'deskripsi' => 'Rambut terlalu panjang atau dicat warna', 'sanksi_rekomendasi' => 'Teguran dan wajib potong rambut'],
            ['nama_pelanggaran' => 'Membawa makanan/minuman ke kelas', 'kategori' => 'Ringan', 'poin_minimal' => 1, 'poin_maksimal' => 5, 'deskripsi' => 'Membawa makanan atau minuman saat pembelajaran', 'sanksi_rekomendasi' => 'Teguran dan penyitaan'],
            ['nama_pelanggaran' => 'Tidur saat pembelajaran', 'kategori' => 'Ringan', 'poin_minimal' => 3, 'poin_maksimal' => 8, 'deskripsi' => 'Tertidur di kelas saat guru mengajar', 'sanksi_rekomendasi' => 'Teguran dan membuat resume materi'],
            ['nama_pelanggaran' => 'Tidak membawa buku pelajaran', 'kategori' => 'Ringan', 'poin_minimal' => 2, 'poin_maksimal' => 6, 'deskripsi' => 'Tidak membawa buku yang diperlukan untuk pembelajaran', 'sanksi_rekomendasi' => 'Teguran lisan'],
            ['nama_pelanggaran' => 'Ramai di kelas', 'kategori' => 'Ringan', 'poin_minimal' => 2, 'poin_maksimal' => 7, 'deskripsi' => 'Membuat keributan yang mengganggu proses belajar', 'sanksi_rekomendasi' => 'Teguran dan duduk di depan kelas'],
            ['nama_pelanggaran' => 'Membuang sampah sembarangan', 'kategori' => 'Ringan', 'poin_minimal' => 2, 'poin_maksimal' => 6, 'deskripsi' => 'Tidak membuang sampah pada tempatnya', 'sanksi_rekomendasi' => 'Teguran dan piket kebersihan'],
            
            // SEDANG (16-30 poin)
            ['nama_pelanggaran' => 'Bolos pelajaran', 'kategori' => 'Sedang', 'poin_minimal' => 16, 'poin_maksimal' => 25, 'deskripsi' => 'Tidak masuk kelas tanpa izin yang sah', 'sanksi_rekomendasi' => 'Panggilan orang tua dan skorsing 1 hari'],
            ['nama_pelanggaran' => 'Keluar kelas tanpa izin', 'kategori' => 'Sedang', 'poin_minimal' => 10, 'poin_maksimal' => 20, 'deskripsi' => 'Meninggalkan kelas saat pembelajaran tanpa izin guru', 'sanksi_rekomendasi' => 'Teguran keras dan surat pernyataan'],
            ['nama_pelanggaran' => 'Menyontek saat ujian', 'kategori' => 'Sedang', 'poin_minimal' => 15, 'poin_maksimal' => 25, 'deskripsi' => 'Melakukan kecurangan dalam ujian atau ulangan', 'sanksi_rekomendasi' => 'Nilai ujian 0 dan panggilan orang tua'],
            ['nama_pelanggaran' => 'Membawa HP saat pembelajaran', 'kategori' => 'Sedang', 'poin_minimal' => 10, 'poin_maksimal' => 20, 'deskripsi' => 'Menggunakan handphone saat proses belajar mengajar', 'sanksi_rekomendasi' => 'Penyitaan HP dan panggilan orang tua'],
            ['nama_pelanggaran' => 'Berbohong kepada guru', 'kategori' => 'Sedang', 'poin_minimal' => 12, 'poin_maksimal' => 22, 'deskripsi' => 'Memberikan keterangan palsu kepada guru atau staf', 'sanksi_rekomendasi' => 'Pembinaan dan surat pernyataan'],
            ['nama_pelanggaran' => 'Merusak fasilitas sekolah', 'kategori' => 'Sedang', 'poin_minimal' => 15, 'poin_maksimal' => 28, 'deskripsi' => 'Merusak atau mencoret-coret fasilitas milik sekolah', 'sanksi_rekomendasi' => 'Ganti rugi dan skorsing'],
            ['nama_pelanggaran' => 'Berkelahi dengan teman', 'kategori' => 'Sedang', 'poin_minimal' => 18, 'poin_maksimal' => 30, 'deskripsi' => 'Terlibat perkelahian fisik dengan sesama siswa', 'sanksi_rekomendasi' => 'Skorsing 3 hari dan panggilan orang tua'],
            ['nama_pelanggaran' => 'Membawa rokok', 'kategori' => 'Sedang', 'poin_minimal' => 20, 'poin_maksimal' => 30, 'deskripsi' => 'Membawa rokok ke lingkungan sekolah', 'sanksi_rekomendasi' => 'Penyitaan, skorsing, dan panggilan orang tua'],
            ['nama_pelanggaran' => 'Tidak masuk tanpa keterangan', 'kategori' => 'Sedang', 'poin_minimal' => 15, 'poin_maksimal' => 25, 'deskripsi' => 'Tidak hadir ke sekolah tanpa surat izin atau keterangan', 'sanksi_rekomendasi' => 'Panggilan orang tua dan surat pernyataan'],
            ['nama_pelanggaran' => 'Memalsukan tanda tangan', 'kategori' => 'Sedang', 'poin_minimal' => 18, 'poin_maksimal' => 28, 'deskripsi' => 'Memalsukan tanda tangan orang tua atau guru', 'sanksi_rekomendasi' => 'Panggilan orang tua dan skorsing'],
            
            // BERAT (31-50 poin)
            ['nama_pelanggaran' => 'Merokok di lingkungan sekolah', 'kategori' => 'Berat', 'poin_minimal' => 31, 'poin_maksimal' => 45, 'deskripsi' => 'Merokok di area sekolah atau saat kegiatan sekolah', 'sanksi_rekomendasi' => 'Skorsing 1 minggu dan panggilan orang tua'],
            ['nama_pelanggaran' => 'Membawa senjata tajam', 'kategori' => 'Berat', 'poin_minimal' => 35, 'poin_maksimal' => 50, 'deskripsi' => 'Membawa pisau, cutter, atau senjata tajam lainnya', 'sanksi_rekomendasi' => 'Skorsing 2 minggu dan laporan polisi'],
            ['nama_pelanggaran' => 'Tawuran antar sekolah', 'kategori' => 'Berat', 'poin_minimal' => 40, 'poin_maksimal' => 50, 'deskripsi' => 'Terlibat perkelahian massal dengan sekolah lain', 'sanksi_rekomendasi' => 'Skorsing dan pertimbangan dikeluarkan'],
            ['nama_pelanggaran' => 'Mencuri barang milik sekolah/teman', 'kategori' => 'Berat', 'poin_minimal' => 35, 'poin_maksimal' => 48, 'deskripsi' => 'Mengambil barang milik orang lain tanpa izin', 'sanksi_rekomendasi' => 'Ganti rugi, skorsing, dan laporan polisi'],
            ['nama_pelanggaran' => 'Membully teman', 'kategori' => 'Berat', 'poin_minimal' => 30, 'poin_maksimal' => 45, 'deskripsi' => 'Melakukan intimidasi atau kekerasan verbal/fisik', 'sanksi_rekomendasi' => 'Skorsing dan konseling wajib'],
            ['nama_pelanggaran' => 'Memalak/memeras teman', 'kategori' => 'Berat', 'poin_minimal' => 35, 'poin_maksimal' => 50, 'deskripsi' => 'Meminta uang atau barang dengan paksa', 'sanksi_rekomendasi' => 'Skorsing dan laporan polisi'],
            ['nama_pelanggaran' => 'Membawa minuman keras', 'kategori' => 'Berat', 'poin_minimal' => 40, 'poin_maksimal' => 50, 'deskripsi' => 'Membawa atau mengonsumsi minuman beralkohol', 'sanksi_rekomendasi' => 'Skorsing dan pertimbangan dikeluarkan'],
            ['nama_pelanggaran' => 'Berjudi di lingkungan sekolah', 'kategori' => 'Berat', 'poin_minimal' => 32, 'poin_maksimal' => 45, 'deskripsi' => 'Melakukan perjudian dalam bentuk apapun', 'sanksi_rekomendasi' => 'Skorsing 2 minggu dan panggilan orang tua'],
            ['nama_pelanggaran' => 'Membawa konten pornografi', 'kategori' => 'Berat', 'poin_minimal' => 35, 'poin_maksimal' => 48, 'deskripsi' => 'Membawa atau menyebarkan materi pornografi', 'sanksi_rekomendasi' => 'Skorsing dan konseling'],
            ['nama_pelanggaran' => 'Melakukan vandalisme', 'kategori' => 'Berat', 'poin_minimal' => 30, 'poin_maksimal' => 45, 'deskripsi' => 'Merusak properti sekolah secara sengaja dan parah', 'sanksi_rekomendasi' => 'Ganti rugi penuh dan skorsing'],
            
            // SANGAT BERAT (51-100 poin)
            ['nama_pelanggaran' => 'Membawa/menggunakan narkoba', 'kategori' => 'Sangat Berat', 'poin_minimal' => 80, 'poin_maksimal' => 100, 'deskripsi' => 'Membawa, menggunakan, atau mengedarkan narkotika', 'sanksi_rekomendasi' => 'Dikeluarkan dari sekolah dan laporan polisi'],
            ['nama_pelanggaran' => 'Melakukan kekerasan terhadap guru', 'kategori' => 'Sangat Berat', 'poin_minimal' => 70, 'poin_maksimal' => 100, 'deskripsi' => 'Melakukan tindakan kekerasan fisik kepada guru/staf', 'sanksi_rekomendasi' => 'Dikeluarkan dari sekolah dan laporan polisi'],
            ['nama_pelanggaran' => 'Melakukan tindakan asusila', 'kategori' => 'Sangat Berat', 'poin_minimal' => 75, 'poin_maksimal' => 100, 'deskripsi' => 'Melakukan pelecehan seksual atau tindakan asusila', 'sanksi_rekomendasi' => 'Dikeluarkan dari sekolah dan laporan polisi'],
            ['nama_pelanggaran' => 'Membawa senjata api', 'kategori' => 'Sangat Berat', 'poin_minimal' => 90, 'poin_maksimal' => 100, 'deskripsi' => 'Membawa senjata api atau bahan peledak', 'sanksi_rekomendasi' => 'Dikeluarkan dari sekolah dan laporan polisi'],
            ['nama_pelanggaran' => 'Melakukan tindak kriminal', 'kategori' => 'Sangat Berat', 'poin_minimal' => 70, 'poin_maksimal' => 100, 'deskripsi' => 'Terlibat tindak kriminal yang merugikan orang lain', 'sanksi_rekomendasi' => 'Dikeluarkan dari sekolah dan laporan polisi'],
            ['nama_pelanggaran' => 'Mengedarkan narkoba', 'kategori' => 'Sangat Berat', 'poin_minimal' => 90, 'poin_maksimal' => 100, 'deskripsi' => 'Menjual atau mengedarkan narkotika di sekolah', 'sanksi_rekomendasi' => 'Dikeluarkan dari sekolah dan laporan polisi'],
            ['nama_pelanggaran' => 'Merusak nama baik sekolah', 'kategori' => 'Sangat Berat', 'poin_minimal' => 60, 'poin_maksimal' => 85, 'deskripsi' => 'Melakukan tindakan yang mencemarkan nama sekolah', 'sanksi_rekomendasi' => 'Skorsing panjang atau dikeluarkan'],
            ['nama_pelanggaran' => 'Memalsukan dokumen resmi', 'kategori' => 'Sangat Berat', 'poin_minimal' => 65, 'poin_maksimal' => 90, 'deskripsi' => 'Memalsukan ijazah, rapor, atau dokumen resmi lainnya', 'sanksi_rekomendasi' => 'Dikeluarkan dari sekolah dan laporan polisi'],
        ];

        foreach ($pelanggaran as $data) {
            DB::table('jenis_pelanggaran')->insert([
                'nama_pelanggaran' => $data['nama_pelanggaran'],
                'kategori' => $data['kategori'],
                'point' => 0,
                'poin_minimal' => $data['poin_minimal'],
                'poin_maksimal' => $data['poin_maksimal'],
                'deskripsi' => $data['deskripsi'],
                'sanksi_rekomendasi' => $data['sanksi_rekomendasi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
