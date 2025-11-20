# Sistem Input Siswa oleh Wali Kelas

## Perubahan yang Diimplementasi

### 1. Pembagian Peran
- **Wali Kelas**: Input data siswa di kelasnya + data orang tua
- **Kesiswaan**: Melihat dan mengelola data yang diinput wali kelas
- **Orang Tua**: Login otomatis dengan akun yang dibuat sistem

### 2. Akses Berdasarkan Level User

#### Wali Kelas
- ✅ Input siswa baru di kelasnya
- ✅ Edit/hapus siswa di kelasnya
- ✅ Input data orang tua sekaligus
- ✅ Sistem otomatis buat akun login orang tua
- ❌ Tidak bisa akses siswa kelas lain

#### Kesiswaan/Admin
- ✅ Melihat semua data siswa
- ✅ Edit data siswa (jika diperlukan)
- ❌ Tidak perlu input siswa manual

#### Orang Tua
- ✅ Login otomatis dengan username/password
- ✅ Melihat data anak saja
- ❌ Tidak bisa edit data

### 3. Fitur Otomatis

#### Pembuatan Akun Orang Tua
Ketika wali kelas input siswa baru:
1. Sistem otomatis buat 2 user account:
   - Username: `ayah_[NIS]` 
   - Username: `ibu_[NIS]`
   - Password: `[NIS]` (untuk keduanya)

2. Sistem otomatis buat data orang tua:
   - Data ayah dengan hubungan "Ayah"
   - Data ibu dengan hubungan "Ibu"
   - Terhubung dengan user account masing-masing

### 4. Form Input yang Diperluas

Form tambah siswa sekarang include:
- Data siswa lengkap
- Data ayah (nama, pekerjaan, no telp, pendidikan)
- Data ibu (nama, pekerjaan, no telp, pendidikan)
- Kelas otomatis sesuai kelas wali kelas

### 5. Keamanan dan Validasi

- Wali kelas hanya bisa input siswa di kelasnya sendiri
- Validasi kelas_id sesuai dengan kelas wali kelas
- Middleware mengatur akses berdasarkan level user
- Orang tua hanya akses data anak sendiri

## Alur Kerja Sistem

### 1. Wali Kelas Input Siswa
```
Wali Kelas Login → Siswa → Tambah Siswa → 
Input Data Siswa + Orang Tua → Submit →
Sistem Buat Akun Ayah & Ibu Otomatis
```

### 2. Kesiswaan Monitor
```
Kesiswaan Login → Siswa → 
Lihat Semua Data dari Wali Kelas →
Edit jika diperlukan
```

### 3. Orang Tua Akses
```
Orang Tua Login (ayah_NIS/ibu_NIS, password: NIS) →
Dashboard Orang Tua → Lihat Data Anak
```

## File yang Dimodifikasi

1. `SiswaController.php` - Logic pembatasan akses dan pembuatan akun
2. `siswa/index.blade.php` - Tampilan berbeda per level user  
3. `siswa/create.blade.php` - Form diperluas dengan data orang tua
4. `CheckOrangTuaAccess.php` - Middleware untuk wali kelas
5. `SISTEM_WALI_KELAS.md` - Dokumentasi ini

## Keuntungan Sistem Ini

1. **Efisiensi**: Wali kelas yang paling tahu siswa di kelasnya
2. **Akurasi**: Data langsung dari sumber yang tepat
3. **Otomatisasi**: Akun orang tua dibuat otomatis
4. **Transparansi**: Kesiswaan bisa monitor semua data
5. **Keamanan**: Setiap level user punya akses terbatas sesuai peran