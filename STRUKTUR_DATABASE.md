# STRUKTUR DATABASE SISTEM PELANGGARAN SISWA

## 📊 OVERVIEW DATABASE

**Database Name**: `sistem_pelanggaran_siswa`  
**Engine**: InnoDB  
**Charset**: utf8mb4_unicode_ci  
**Collation**: utf8mb4_unicode_ci

---

## 📋 DAFTAR TABEL

Total: **15 Tabel**

1. users
2. siswa
3. kelas
4. orang_tua
5. wali_kelas
6. tahun_ajaran
7. jenis_pelanggaran
8. pelanggaran
9. sanksi
10. jenis_sanksi
11. pelaksanaan_sanksi
12. bimbingan_konseling
13. jenis_prestasi
14. prestasi
15. notifikasi

---

## 1️⃣ TABEL: users

**Deskripsi**: Menyimpan data pengguna sistem

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| user_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik user |
| username | VARCHAR | 50 | UNIQUE, NOT NULL | - | Username login |
| password | VARCHAR | 255 | NOT NULL | - | Password (bcrypt hash) |
| nama_lengkap | VARCHAR | 100 | NOT NULL | - | Nama lengkap user |
| level | ENUM | - | NOT NULL | - | 'admin','kesiswaan','bk','guru','wali_kelas','orang_tua','siswa' |
| is_active | BOOLEAN | 1 | NOT NULL | TRUE | Status aktif user |
| remember_token | VARCHAR | 100 | NULLABLE | NULL | Token remember me |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY: `user_id`
- UNIQUE KEY: `username`
- INDEX: `level`

**Contoh Data**:
```sql
INSERT INTO users VALUES
(1, 'admin', '$2y$10$...', 'Administrator', 'admin', 1, NULL, NOW(), NOW()),
(2, 'guru01', '$2y$10$...', 'Budi Santoso', 'guru', 1, NULL, NOW(), NOW()),
(3, 'siswa001', '$2y$10$...', 'Ahmad Fauzi', 'siswa', 1, NULL, NOW(), NOW());
```

---

## 2️⃣ TABEL: kelas

**Deskripsi**: Menyimpan data kelas

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| kelas_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik kelas |
| nama_kelas | VARCHAR | 50 | NOT NULL | - | Nama kelas (X PPLG 1) |
| tingkat | INT | 11 | NULLABLE | NULL | Tingkat kelas (10,11,12) |
| jurusan | ENUM | - | NOT NULL | - | 'PPLG','AKT','BDP','DKV','ANM' |
| rombel | INT | 11 | NULLABLE | NULL | Rombongan belajar |
| kapasitas | INT | 11 | NOT NULL | 40 | Kapasitas maksimal siswa |
| wali_kelas_id | BIGINT | 20 | FOREIGN KEY, NULLABLE | NULL | Relasi ke users.user_id |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Foreign Key**:
- `wali_kelas_id` REFERENCES `users(user_id)` ON DELETE SET NULL

**Index**:
- PRIMARY KEY: `kelas_id`
- FOREIGN KEY: `wali_kelas_id`
- INDEX: `jurusan`

**Contoh Data**:
```sql
INSERT INTO kelas VALUES
(1, 'X PPLG 1', 10, 'PPLG', 1, 36, 2, NOW(), NOW()),
(2, 'XI AKT 1', 11, 'AKT', 1, 36, NULL, NOW(), NOW());
```

---

## 3️⃣ TABEL: siswa

**Deskripsi**: Menyimpan data siswa

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| siswa_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik siswa |
| user_id | BIGINT | 20 | FOREIGN KEY, NULLABLE | NULL | Relasi ke users.user_id |
| nis | VARCHAR | 20 | UNIQUE, NOT NULL | - | Nomor Induk Siswa |
| nisn | VARCHAR | 20 | UNIQUE, NOT NULL | - | Nomor Induk Siswa Nasional |
| nama_siswa | VARCHAR | 100 | NOT NULL | - | Nama lengkap siswa |
| jenis_kelamin | ENUM | - | NOT NULL | - | 'L','P' |
| tanggal_lahir | DATE | - | NOT NULL | - | Tanggal lahir (YYYY-MM-DD) |
| tempat_lahir | VARCHAR | 50 | NOT NULL | - | Tempat lahir |
| alamat | TEXT | - | NOT NULL | - | Alamat lengkap |
| no_telp | VARCHAR | 15 | NULLABLE | NULL | Nomor telepon siswa |
| kelas_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Relasi ke kelas.kelas_id |
| foto | VARCHAR | 255 | NULLABLE | NULL | Path foto siswa |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Foreign Key**:
- `user_id` REFERENCES `users(user_id)` ON DELETE SET NULL
- `kelas_id` REFERENCES `kelas(kelas_id)` ON DELETE RESTRICT

**Index**:
- PRIMARY KEY: `siswa_id`
- UNIQUE KEY: `nis`, `nisn`
- FOREIGN KEY: `user_id`, `kelas_id`
- INDEX: `nama_siswa`

**Contoh Data**:
```sql
INSERT INTO siswa VALUES
(1, 3, '12345', '0012345678', 'Ahmad Fauzi', 'L', '2008-05-15', 'Jakarta', 
'Jl. Merdeka No. 10', '081234567890', 1, NULL, NOW(), NOW());
```

---

## 4️⃣ TABEL: orang_tua

**Deskripsi**: Menyimpan data orang tua/wali siswa

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| orang_tua_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik orang tua |
| user_id | BIGINT | 20 | FOREIGN KEY, NULLABLE | NULL | Relasi ke users.user_id |
| siswa_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Relasi ke siswa.siswa_id |
| nama_ayah | VARCHAR | 100 | NULLABLE | NULL | Nama ayah |
| nama_ibu | VARCHAR | 100 | NULLABLE | NULL | Nama ibu |
| no_telp_ayah | VARCHAR | 15 | NULLABLE | NULL | Telepon ayah |
| no_telp_ibu | VARCHAR | 15 | NULLABLE | NULL | Telepon ibu |
| pekerjaan_ayah | VARCHAR | 50 | NULLABLE | NULL | Pekerjaan ayah |
| pekerjaan_ibu | VARCHAR | 50 | NULLABLE | NULL | Pekerjaan ibu |
| hubungan | ENUM | - | NOT NULL | - | 'Ayah','Ibu','Wali' |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Foreign Key**:
- `user_id` REFERENCES `users(user_id)` ON DELETE SET NULL
- `siswa_id` REFERENCES `siswa(siswa_id)` ON DELETE CASCADE

**Index**:
- PRIMARY KEY: `orang_tua_id`
- FOREIGN KEY: `user_id`, `siswa_id`

**Contoh Data**:
```sql
INSERT INTO orang_tua VALUES
(1, 4, 1, 'Budi Hartono', 'Siti Aminah', '081234567891', '081234567892',
'Wiraswasta', 'Ibu Rumah Tangga', 'Ayah', NOW(), NOW());
```

---

## 5️⃣ TABEL: tahun_ajaran

**Deskripsi**: Menyimpan data tahun ajaran

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| tahun_ajaran_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik tahun ajaran |
| nama_tahun_ajaran | VARCHAR | 20 | NOT NULL | - | Contoh: 2024/2025 |
| semester | ENUM | - | NOT NULL | - | 'Ganjil','Genap' |
| tanggal_mulai | DATE | - | NOT NULL | - | Tanggal mulai |
| tanggal_selesai | DATE | - | NOT NULL | - | Tanggal selesai |
| status_aktif | BOOLEAN | 1 | NOT NULL | FALSE | Status aktif |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY: `tahun_ajaran_id`
- INDEX: `status_aktif`

**Contoh Data**:
```sql
INSERT INTO tahun_ajaran VALUES
(1, '2024/2025', 'Ganjil', '2024-07-15', '2024-12-20', 1, NOW(), NOW());
```

---

## 6️⃣ TABEL: jenis_pelanggaran

**Deskripsi**: Menyimpan jenis-jenis pelanggaran

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| jenis_pelanggaran_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik jenis pelanggaran |
| nama_pelanggaran | VARCHAR | 100 | NOT NULL | - | Nama pelanggaran |
| kategori | ENUM | - | NOT NULL | - | 'Ringan','Sedang','Berat' |
| poin_minimal | INT | 11 | NOT NULL | - | Poin minimal |
| poin_maksimal | INT | 11 | NOT NULL | - | Poin maksimal |
| deskripsi | TEXT | - | NULLABLE | NULL | Deskripsi pelanggaran |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY: `jenis_pelanggaran_id`
- INDEX: `kategori`

**Contoh Data**:
```sql
INSERT INTO jenis_pelanggaran VALUES
(1, 'Terlambat', 'Ringan', 5, 10, 'Datang terlambat ke sekolah', NOW(), NOW()),
(2, 'Bolos', 'Sedang', 10, 15, 'Tidak masuk tanpa keterangan', NOW(), NOW()),
(3, 'Merokok', 'Berat', 25, 30, 'Merokok di lingkungan sekolah', NOW(), NOW());
```

---

## 7️⃣ TABEL: pelanggaran

**Deskripsi**: Menyimpan data pelanggaran siswa

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| pelanggaran_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik pelanggaran |
| siswa_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Relasi ke siswa.siswa_id |
| jenis_pelanggaran_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Relasi ke jenis_pelanggaran |
| guru_pencatat | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Guru yang mencatat |
| guru_verifikator | BIGINT | 20 | FOREIGN KEY, NULLABLE | NULL | Guru yang verifikasi |
| tahun_ajaran_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Tahun ajaran |
| point | INT | 11 | NOT NULL | - | Poin pelanggaran |
| tanggal | DATE | - | NOT NULL | - | Tanggal pelanggaran |
| keterangan | TEXT | - | NULLABLE | NULL | Keterangan tambahan |
| bukti_foto | VARCHAR | 255 | NULLABLE | NULL | Path foto bukti |
| status_verifikasi | ENUM | - | NOT NULL | 'Pending' | 'Pending','Terverifikasi','Ditolak' |
| catatan_verifikasi | TEXT | - | NULLABLE | NULL | Catatan verifikasi |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Foreign Key**:
- `siswa_id` REFERENCES `siswa(siswa_id)` ON DELETE CASCADE
- `jenis_pelanggaran_id` REFERENCES `jenis_pelanggaran(jenis_pelanggaran_id)`
- `guru_pencatat` REFERENCES `users(user_id)`
- `guru_verifikator` REFERENCES `users(user_id)` ON DELETE SET NULL
- `tahun_ajaran_id` REFERENCES `tahun_ajaran(tahun_ajaran_id)`

**Index**:
- PRIMARY KEY: `pelanggaran_id`
- FOREIGN KEY: `siswa_id`, `jenis_pelanggaran_id`, `guru_pencatat`, `tahun_ajaran_id`
- INDEX: `tanggal`, `status_verifikasi`

**Contoh Data**:
```sql
INSERT INTO pelanggaran VALUES
(1, 1, 1, 2, 1, 1, 7, '2025-01-15', 'Terlambat 15 menit', 
'bukti/foto1.jpg', 'Terverifikasi', 'Sudah dikonfirmasi', NOW(), NOW());
```

---

## 8️⃣ TABEL: sanksi

**Deskripsi**: Menyimpan data sanksi

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| sanksi_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik sanksi |
| pelanggaran_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Relasi ke pelanggaran |
| jenis_sanksi | VARCHAR | 100 | NOT NULL | - | Jenis sanksi |
| deskripsi | TEXT | - | NOT NULL | - | Deskripsi sanksi |
| tanggal_mulai | DATE | - | NOT NULL | - | Tanggal mulai sanksi |
| tanggal_selesai | DATE | - | NOT NULL | - | Tanggal selesai sanksi |
| status | ENUM | - | NOT NULL | 'Aktif' | 'Aktif','Selesai','Dibatalkan' |
| guru_penanggung_jawab | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Guru PJ |
| catatan | TEXT | - | NULLABLE | NULL | Catatan tambahan |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Foreign Key**:
- `pelanggaran_id` REFERENCES `pelanggaran(pelanggaran_id)` ON DELETE CASCADE
- `guru_penanggung_jawab` REFERENCES `users(user_id)`

**Index**:
- PRIMARY KEY: `sanksi_id`
- FOREIGN KEY: `pelanggaran_id`, `guru_penanggung_jawab`
- INDEX: `status`, `tanggal_mulai`

**Contoh Data**:
```sql
INSERT INTO sanksi VALUES
(1, 1, 'Panggilan Orang Tua', 'Konseling bersama orang tua', 
'2025-01-17', '2025-01-17', 'Selesai', 2, 'Orang tua kooperatif', NOW(), NOW());
```

---

## 9️⃣ TABEL: notifikasi

**Deskripsi**: Menyimpan notifikasi untuk user

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| notifikasi_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik notifikasi |
| user_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Penerima notifikasi |
| judul | VARCHAR | 100 | NOT NULL | - | Judul notifikasi |
| pesan | TEXT | - | NOT NULL | - | Isi pesan |
| tipe | VARCHAR | 50 | NOT NULL | - | 'pelanggaran','sanksi','info' |
| referensi_id | BIGINT | 20 | NULLABLE | NULL | ID referensi |
| dibaca | BOOLEAN | 1 | NOT NULL | FALSE | Status dibaca |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Foreign Key**:
- `user_id` REFERENCES `users(user_id)` ON DELETE CASCADE

**Index**:
- PRIMARY KEY: `notifikasi_id`
- FOREIGN KEY: `user_id`
- INDEX: `dibaca`, `created_at`

**Contoh Data**:
```sql
INSERT INTO notifikasi VALUES
(1, 3, 'Pelanggaran Baru', 'Anda melakukan pelanggaran: Terlambat (7 poin)', 
'pelanggaran', 1, 0, NOW(), NOW());
```

---

## 🔟 TABEL: wali_kelas

**Deskripsi**: Menyimpan data wali kelas per tahun ajaran

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| wali_kelas_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik wali kelas |
| user_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Relasi ke users |
| kelas_id | BIGINT | 20 | FOREIGN KEY, NULLABLE | NULL | Relasi ke kelas |
| tahun_ajaran_id | BIGINT | 20 | FOREIGN KEY, NULLABLE | NULL | Tahun ajaran |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

**Foreign Key**:
- `user_id` REFERENCES `users(user_id)` ON DELETE CASCADE
- `kelas_id` REFERENCES `kelas(kelas_id)` ON DELETE SET NULL
- `tahun_ajaran_id` REFERENCES `tahun_ajaran(tahun_ajaran_id)` ON DELETE SET NULL

---

## 1️⃣1️⃣ TABEL: bimbingan_konseling

**Deskripsi**: Menyimpan data bimbingan konseling

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| bimbingan_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik bimbingan |
| siswa_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Siswa yang dibimbing |
| guru_konselor | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Guru BK |
| tahun_ajaran_id | BIGINT | 20 | FOREIGN KEY, NULLABLE | NULL | Tahun ajaran |
| tanggal | DATE | - | NOT NULL | - | Tanggal bimbingan |
| topik | VARCHAR | 100 | NOT NULL | - | Topik bimbingan |
| masalah | TEXT | - | NOT NULL | - | Deskripsi masalah |
| solusi | TEXT | - | NOT NULL | - | Solusi yang diberikan |
| status | ENUM | - | NOT NULL | 'Proses' | 'Proses','Selesai' |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

---

## 1️⃣2️⃣ TABEL: jenis_prestasi

**Deskripsi**: Menyimpan jenis prestasi

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| jenis_prestasi_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik jenis prestasi |
| nama_prestasi | VARCHAR | 100 | NOT NULL | - | Nama prestasi |
| tingkat | ENUM | - | NOT NULL | - | 'Sekolah','Kota','Provinsi','Nasional','Internasional' |
| poin_prestasi | INT | 11 | NOT NULL | 0 | Poin prestasi |
| deskripsi | TEXT | - | NULLABLE | NULL | Deskripsi |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

---

## 1️⃣3️⃣ TABEL: prestasi

**Deskripsi**: Menyimpan data prestasi siswa

| Field | Tipe Data | Length | Constraint | Default | Keterangan |
|-------|-----------|--------|------------|---------|------------|
| prestasi_id | BIGINT | 20 | PRIMARY KEY, AUTO_INCREMENT | - | ID unik prestasi |
| siswa_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Siswa berprestasi |
| jenis_prestasi_id | BIGINT | 20 | FOREIGN KEY, NOT NULL | - | Jenis prestasi |
| tanggal | DATE | - | NOT NULL | - | Tanggal prestasi |
| penyelenggara | VARCHAR | 100 | NOT NULL | - | Penyelenggara |
| peringkat | VARCHAR | 20 | NULLABLE | NULL | Juara 1, 2, 3, dll |
| bukti_sertifikat | VARCHAR | 255 | NULLABLE | NULL | Path sertifikat |
| keterangan | TEXT | - | NULLABLE | NULL | Keterangan |
| created_at | TIMESTAMP | - | NULLABLE | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULLABLE | NULL | Waktu diupdate |

---

## 📊 RELASI ANTAR TABEL (ERD)

```
users (1) ──────────── (0..1) siswa
  │                              │
  │                              │
  │                         (1) ─┴─ (N) pelanggaran
  │                                      │
  │                                      │
  │                                 (1) ─┴─ (0..N) sanksi
  │
  ├─ (1) ────────── (N) orang_tua ─── (1) siswa
  │
  ├─ (1) ────────── (0..N) wali_kelas ─── (0..1) kelas
  │
  └─ (1) ────────── (N) notifikasi

kelas (1) ────────── (N) siswa

tahun_ajaran (1) ──── (N) pelanggaran
             (1) ──── (N) wali_kelas

jenis_pelanggaran (1) ─── (N) pelanggaran
jenis_prestasi (1) ──────── (N) prestasi
```

---

## 🔐 CONSTRAINT & VALIDASI

### Primary Keys
Semua tabel menggunakan BIGINT AUTO_INCREMENT sebagai primary key

### Foreign Keys
- ON DELETE CASCADE: Data child ikut terhapus
- ON DELETE SET NULL: Foreign key di-set NULL
- ON DELETE RESTRICT: Tidak bisa hapus jika ada relasi

### Unique Constraints
- users.username
- siswa.nis
- siswa.nisn

### Check Constraints
- poin_minimal <= poin_maksimal (jenis_pelanggaran)
- tanggal_mulai <= tanggal_selesai (tahun_ajaran, sanksi)

---

## 📈 ESTIMASI UKURAN DATA

### Per Tahun Ajaran (1000 siswa):

| Tabel | Estimasi Record | Ukuran/Record | Total |
|-------|----------------|---------------|-------|
| users | 1,100 | 500 bytes | 550 KB |
| siswa | 1,000 | 1 KB | 1 MB |
| kelas | 30 | 200 bytes | 6 KB |
| pelanggaran | 5,000 | 500 bytes | 2.5 MB |
| sanksi | 500 | 400 bytes | 200 KB |
| notifikasi | 15,000 | 300 bytes | 4.5 MB |
| **TOTAL** | | | **~9 MB/tahun** |

---

## 🔧 MAINTENANCE

### Backup Schedule
- Daily: Incremental backup
- Weekly: Full backup
- Monthly: Archive backup

### Index Optimization
```sql
-- Analyze table
ANALYZE TABLE pelanggaran;

-- Optimize table
OPTIMIZE TABLE pelanggaran;

-- Check index usage
SHOW INDEX FROM pelanggaran;
```

### Clean Old Data
```sql
-- Archive data > 3 tahun
-- Delete notifikasi > 6 bulan yang sudah dibaca
DELETE FROM notifikasi 
WHERE dibaca = 1 
AND created_at < DATE_SUB(NOW(), INTERVAL 6 MONTH);
```

---

**Dokumen Database v1.0**  
**Dibuat**: Januari 2025  
**Database Engine**: MySQL 8.0+
