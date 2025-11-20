-- =====================================================
-- DATABASE SISTEM PELANGGARAN SISWA
-- SMK Bakti Nusantara 666
-- =====================================================

SET FOREIGN_KEY_CHECKS = 0;

-- Drop tables if exists
DROP TABLE IF EXISTS verifikasi_data;
DROP TABLE IF EXISTS monitoring_pelanggaran;
DROP TABLE IF EXISTS bimbingan_konseling;
DROP TABLE IF EXISTS pelaksanaan_sanksi;
DROP TABLE IF EXISTS sanksi;
DROP TABLE IF EXISTS prestasi;
DROP TABLE IF EXISTS jenis_prestasi;
DROP TABLE IF EXISTS pelanggaran;
DROP TABLE IF EXISTS jenis_pelanggaran;
DROP TABLE IF EXISTS orang_tua;
DROP TABLE IF EXISTS siswa;
DROP TABLE IF EXISTS tahun_ajaran;
DROP TABLE IF EXISTS kelas;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS guru;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- CORE TABLES
-- =====================================================

-- Table: guru
CREATE TABLE guru (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(50) UNIQUE,
    nama_guru VARCHAR(100) NOT NULL,
    bidang_studi VARCHAR(100),
    status ENUM('aktif', 'non_aktif', 'pensiun', 'cuti') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nip (nip),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: users
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    guru_id BIGINT UNSIGNED NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    level ENUM('admin', 'guru', 'wali_kelas', 'kesiswaan', 'bk', 'kepsek', 'siswa', 'orang_tua') NOT NULL,
    can_verify BOOLEAN DEFAULT FALSE,
    name VARCHAR(100),
    nip VARCHAR(50),
    no_telepon VARCHAR(20),
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE SET NULL,
    INDEX idx_guru_id (guru_id),
    INDEX idx_level (level),
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: kelas
CREATE TABLE kelas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(50) NOT NULL,
    jurusan VARCHAR(100),
    tingkat INT,
    wali_kelas_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (wali_kelas_id) REFERENCES guru(id) ON DELETE SET NULL,
    INDEX idx_wali_kelas (wali_kelas_id),
    INDEX idx_tingkat (tingkat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: tahun_ajaran
CREATE TABLE tahun_ajaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun_ajaran VARCHAR(20) NOT NULL,
    semester ENUM('ganjil', 'genap') NOT NULL,
    status_aktif BOOLEAN DEFAULT FALSE,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status_aktif (status_aktif)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: siswa
CREATE TABLE siswa (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(50) UNIQUE NOT NULL,
    nisn VARCHAR(50) UNIQUE,
    nama_siswa VARCHAR(100) NOT NULL,
    kelas_id BIGINT UNSIGNED NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tempat_lahir VARCHAR(100),
    tanggal_lahir DATE,
    alamat TEXT,
    no_telepon VARCHAR(20),
    email VARCHAR(100),
    status ENUM('aktif', 'lulus', 'pindah', 'drop_out', 'cuti') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE SET NULL,
    INDEX idx_nis (nis),
    INDEX idx_kelas_id (kelas_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: orang_tua
CREATE TABLE orang_tua (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    siswa_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    nama_ayah VARCHAR(100),
    nama_ibu VARCHAR(100),
    pekerjaan_ayah VARCHAR(100),
    pekerjaan_ibu VARCHAR(100),
    no_telepon_ayah VARCHAR(20),
    no_telepon_ibu VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_siswa_id (siswa_id),
    INDEX idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- PELANGGARAN & SANKSI TABLES
-- =====================================================

-- Table: jenis_pelanggaran
CREATE TABLE jenis_pelanggaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggaran VARCHAR(200) NOT NULL,
    poin INT NOT NULL DEFAULT 0,
    kategori ENUM('ringan', 'sedang', 'berat', 'sangat_berat') NOT NULL,
    sanksi_rekomendasi TEXT,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_kategori (kategori),
    INDEX idx_poin (poin)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pelanggaran
CREATE TABLE pelanggaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    siswa_id BIGINT UNSIGNED NOT NULL,
    guru_pencatat BIGINT UNSIGNED NOT NULL,
    jenis_pelanggaran_id BIGINT UNSIGNED NOT NULL,
    tahun_ajaran_id BIGINT UNSIGNED NOT NULL,
    poin INT NOT NULL DEFAULT 0,
    tanggal_pelanggaran DATE NOT NULL,
    tempat_kejadian VARCHAR(200),
    keterangan TEXT,
    bukti_foto VARCHAR(255),
    status_verifikasi ENUM('menunggu', 'diverifikasi', 'ditolak', 'revisi') DEFAULT 'menunggu',
    guru_verifikator BIGINT UNSIGNED NULL,
    tanggal_verifikasi DATETIME NULL,
    catatan_verifikasi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_pencatat) REFERENCES guru(id) ON DELETE RESTRICT,
    FOREIGN KEY (jenis_pelanggaran_id) REFERENCES jenis_pelanggaran(id) ON DELETE RESTRICT,
    FOREIGN KEY (tahun_ajaran_id) REFERENCES tahun_ajaran(id) ON DELETE RESTRICT,
    FOREIGN KEY (guru_verifikator) REFERENCES guru(id) ON DELETE SET NULL,
    INDEX idx_siswa_id (siswa_id),
    INDEX idx_guru_pencatat (guru_pencatat),
    INDEX idx_jenis_pelanggaran (jenis_pelanggaran_id),
    INDEX idx_tahun_ajaran (tahun_ajaran_id),
    INDEX idx_status_verifikasi (status_verifikasi),
    INDEX idx_tanggal (tanggal_pelanggaran)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: sanksi
CREATE TABLE sanksi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pelanggaran_id BIGINT UNSIGNED NOT NULL,
    jenis_sanksi VARCHAR(200) NOT NULL,
    deskripsi_sanksi TEXT,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE,
    durasi_hari INT,
    status ENUM('direncanakan', 'berjalan', 'selesai', 'ditunda', 'dibatalkan') DEFAULT 'direncanakan',
    guru_pemberi_sanksi BIGINT UNSIGNED,
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pelanggaran_id) REFERENCES pelanggaran(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_pemberi_sanksi) REFERENCES guru(id) ON DELETE SET NULL,
    INDEX idx_pelanggaran_id (pelanggaran_id),
    INDEX idx_status (status),
    INDEX idx_tanggal_mulai (tanggal_mulai)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pelaksanaan_sanksi
CREATE TABLE pelaksanaan_sanksi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sanksi_id BIGINT UNSIGNED NOT NULL,
    tanggal_pelaksanaan DATE NOT NULL,
    bukti_pelaksanaan VARCHAR(255),
    catatan TEXT,
    status ENUM('terjadwal', 'dikerjakan', 'tuntas', 'terlambat', 'perpanjangan') DEFAULT 'terjadwal',
    guru_pengawas BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sanksi_id) REFERENCES sanksi(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_pengawas) REFERENCES guru(id) ON DELETE SET NULL,
    INDEX idx_sanksi_id (sanksi_id),
    INDEX idx_status (status),
    INDEX idx_tanggal (tanggal_pelaksanaan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- PRESTASI TABLES
-- =====================================================

-- Table: jenis_prestasi
CREATE TABLE jenis_prestasi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_prestasi VARCHAR(200) NOT NULL,
    jenis ENUM('akademik', 'non_akademik', 'olahraga', 'seni', 'lainnya') NOT NULL,
    kategori ENUM('sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional') NOT NULL,
    poin INT NOT NULL DEFAULT 0,
    penghargaan VARCHAR(200),
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_jenis (jenis),
    INDEX idx_kategori (kategori)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: prestasi
CREATE TABLE prestasi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    siswa_id BIGINT UNSIGNED NOT NULL,
    guru_pencatat BIGINT UNSIGNED NOT NULL,
    jenis_prestasi_id BIGINT UNSIGNED NOT NULL,
    tahun_ajaran_id BIGINT UNSIGNED NOT NULL,
    poin INT NOT NULL DEFAULT 0,
    tingkat VARCHAR(50),
    penghargaan VARCHAR(200),
    tanggal_prestasi DATE NOT NULL,
    tempat VARCHAR(200),
    keterangan TEXT,
    bukti_dokumen VARCHAR(255),
    status_verifikasi ENUM('menunggu', 'diverifikasi', 'ditolak', 'revisi') DEFAULT 'menunggu',
    guru_verifikator BIGINT UNSIGNED NULL,
    tanggal_verifikasi DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_pencatat) REFERENCES guru(id) ON DELETE RESTRICT,
    FOREIGN KEY (jenis_prestasi_id) REFERENCES jenis_prestasi(id) ON DELETE RESTRICT,
    FOREIGN KEY (tahun_ajaran_id) REFERENCES tahun_ajaran(id) ON DELETE RESTRICT,
    FOREIGN KEY (guru_verifikator) REFERENCES guru(id) ON DELETE SET NULL,
    INDEX idx_siswa_id (siswa_id),
    INDEX idx_guru_pencatat (guru_pencatat),
    INDEX idx_jenis_prestasi (jenis_prestasi_id),
    INDEX idx_status_verifikasi (status_verifikasi),
    INDEX idx_tanggal (tanggal_prestasi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SUPPORT TABLES
-- =====================================================

-- Table: bimbingan_konseling
CREATE TABLE bimbingan_konseling (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    siswa_id BIGINT UNSIGNED NOT NULL,
    guru_konselor BIGINT UNSIGNED NOT NULL,
    topik VARCHAR(200) NOT NULL,
    jenis_bimbingan ENUM('akademik', 'pribadi', 'sosial', 'karir') NOT NULL,
    tanggal_bimbingan DATE NOT NULL,
    tindakan TEXT,
    hasil TEXT,
    tindak_lanjut TEXT,
    status ENUM('terdaftar', 'diproses', 'selesai', 'tindak_lanjut') DEFAULT 'terdaftar',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_konselor) REFERENCES guru(id) ON DELETE RESTRICT,
    INDEX idx_siswa_id (siswa_id),
    INDEX idx_guru_konselor (guru_konselor),
    INDEX idx_status (status),
    INDEX idx_tanggal (tanggal_bimbingan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: monitoring_pelanggaran
CREATE TABLE monitoring_pelanggaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pelanggaran_id BIGINT UNSIGNED NOT NULL,
    guru_kepsek BIGINT UNSIGNED NOT NULL,
    tanggal_monitoring DATE NOT NULL,
    catatan TEXT,
    rekomendasi TEXT,
    status ENUM('ditinjau', 'disetujui', 'ditolak', 'perlu_tindak_lanjut') DEFAULT 'ditinjau',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pelanggaran_id) REFERENCES pelanggaran(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_kepsek) REFERENCES guru(id) ON DELETE RESTRICT,
    INDEX idx_pelanggaran_id (pelanggaran_id),
    INDEX idx_guru_kepsek (guru_kepsek),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: verifikasi_data
CREATE TABLE verifikasi_data (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tabel_terkait VARCHAR(100) NOT NULL,
    id_terkait BIGINT UNSIGNED NOT NULL,
    guru_verifikator BIGINT UNSIGNED NOT NULL,
    status ENUM('menunggu', 'diverifikasi', 'ditolak', 'revisi') DEFAULT 'menunggu',
    catatan TEXT,
    tanggal_verifikasi DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guru_verifikator) REFERENCES guru(id) ON DELETE RESTRICT,
    INDEX idx_tabel_terkait (tabel_terkait),
    INDEX idx_id_terkait (id_terkait),
    INDEX idx_guru_verifikator (guru_verifikator),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERT SAMPLE DATA
-- =====================================================

-- Insert Tahun Ajaran
INSERT INTO tahun_ajaran (tahun_ajaran, semester, status_aktif, tanggal_mulai, tanggal_selesai) VALUES
('2024/2025', 'ganjil', TRUE, '2024-07-15', '2024-12-20'),
('2024/2025', 'genap', FALSE, '2025-01-06', '2025-06-20');

-- Insert Guru Sample
INSERT INTO guru (nip, nama_guru, bidang_studi, status) VALUES
('198501012010011001', 'Drs. Ahmad Fauzi, M.Pd', 'Matematika', 'aktif'),
('198703152011012002', 'Sri Wahyuni, S.Pd', 'Bahasa Indonesia', 'aktif'),
('199001202015011003', 'Budi Santoso, S.Kom', 'Teknik Komputer', 'aktif');

-- Insert Admin User (password: password)
INSERT INTO users (guru_id, username, email, password, level, can_verify, name) VALUES
(1, 'admin', 'admin@smkbn666.sch.id', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', TRUE, 'Administrator');

-- Insert Jenis Pelanggaran Sample
INSERT INTO jenis_pelanggaran (nama_pelanggaran, poin, kategori, sanksi_rekomendasi) VALUES
('Terlambat masuk kelas', 5, 'ringan', 'Teguran lisan'),
('Tidak mengerjakan tugas', 10, 'ringan', 'Membuat tugas tambahan'),
('Merokok di area sekolah', 50, 'berat', 'Skorsing 3 hari'),
('Berkelahi', 75, 'sangat_berat', 'Skorsing 1 minggu + panggilan orang tua');

-- Insert Jenis Prestasi Sample
INSERT INTO jenis_prestasi (nama_prestasi, jenis, kategori, poin, penghargaan) VALUES
('Juara 1 Olimpiade Matematika', 'akademik', 'nasional', 100, 'Piala + Sertifikat'),
('Juara 1 Lomba Futsal', 'olahraga', 'provinsi', 75, 'Medali Emas'),
('Juara 2 Lomba Seni Tari', 'seni', 'kabupaten', 50, 'Piagam Penghargaan');

-- =====================================================
-- END OF SCRIPT
-- =====================================================
