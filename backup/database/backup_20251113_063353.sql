-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_pelanggaran_siswa
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bimbingan_konseling`
--

DROP TABLE IF EXISTS `bimbingan_konseling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bimbingan_konseling` (
  `bk_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `guru_konselor` bigint(20) unsigned NOT NULL,
  `tahun_ajaran_id` bigint(20) unsigned DEFAULT NULL,
  `jenis_layanan` enum('Konseling Individual','Konseling Kelompok','Bimbingan Klasikal','Lainnya') NOT NULL,
  `topik` varchar(200) NOT NULL,
  `keluhan_masalah` text NOT NULL,
  `tindakan_solusi` text DEFAULT NULL,
  `status` enum('Pending','Proses','Selesai','Tindak Lanjut') NOT NULL DEFAULT 'Pending',
  `tanggal_konseling` date NOT NULL,
  `tanggal_tindak_lanjut` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bk_id`),
  KEY `bimbingan_konseling_siswa_id_foreign` (`siswa_id`),
  KEY `bimbingan_konseling_guru_konselor_foreign` (`guru_konselor`),
  KEY `bimbingan_konseling_tahun_ajaran_id_foreign` (`tahun_ajaran_id`),
  CONSTRAINT `bimbingan_konseling_guru_konselor_foreign` FOREIGN KEY (`guru_konselor`) REFERENCES `users` (`user_id`),
  CONSTRAINT `bimbingan_konseling_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`siswa_id`),
  CONSTRAINT `bimbingan_konseling_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`tahun_ajaran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bimbingan_konseling`
--

LOCK TABLES `bimbingan_konseling` WRITE;
/*!40000 ALTER TABLE `bimbingan_konseling` DISABLE KEYS */;
INSERT INTO `bimbingan_konseling` VALUES (1,7,24,NULL,'Konseling Individual','Membahas Masa Depan','Hilang jati diri','Konsultasi','Selesai','2025-11-15',NULL,'2025-11-12 18:54:38','2025-11-12 18:55:10');
/*!40000 ALTER TABLE `bimbingan_konseling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_pelanggaran`
--

DROP TABLE IF EXISTS `jenis_pelanggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_pelanggaran` (
  `jenis_pelanggaran_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_pelanggaran` varchar(200) NOT NULL,
  `point` int(11) NOT NULL,
  `kategori` enum('Ringan','Sedang','Berat','Sangat Berat') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `sanksi_rekomendasi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`jenis_pelanggaran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_pelanggaran`
--

LOCK TABLES `jenis_pelanggaran` WRITE;
/*!40000 ALTER TABLE `jenis_pelanggaran` DISABLE KEYS */;
INSERT INTO `jenis_pelanggaran` VALUES (2,'bolos',1,'Berat','kabur','sp 1','2025-11-10 22:57:43','2025-11-10 22:57:43'),(3,'tawuran',1,'Sangat Berat','tawuran pelajar','do','2025-11-11 22:16:40','2025-11-11 22:16:40');
/*!40000 ALTER TABLE `jenis_pelanggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_prestasi`
--

DROP TABLE IF EXISTS `jenis_prestasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_prestasi` (
  `jenis_prestasi_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_prestasi` varchar(200) NOT NULL,
  `jenis` enum('Akademik','Non-Akademik','Olahraga','Seni','Lainnya') NOT NULL,
  `kategori` enum('Sekolah','Kecamatan','Kota','Provinsi','Nasional','Internasional') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `reward` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`jenis_prestasi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_prestasi`
--

LOCK TABLES `jenis_prestasi` WRITE;
/*!40000 ALTER TABLE `jenis_prestasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_prestasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kelas` (
  `kelas_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) NOT NULL,
  `jurusan` enum('PPLG','AKT','BDP','DKV','ANM') NOT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 40,
  `wali_kelas_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kelas_id`),
  KEY `kelas_wali_kelas_id_foreign` (`wali_kelas_id`),
  CONSTRAINT `kelas_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'X PPLG 1','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(2,'X PPLG 2','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(3,'X PPLG 3','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(4,'X ANM 1','ANM',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(5,'X DKV 1','DKV',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(6,'X BDP 1','BDP',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(7,'X AKT 1','AKT',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(8,'X AKT 2','AKT',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(9,'XI PPLG 1','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(10,'XI PPLG 2','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(11,'XI PPLG 3','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(12,'XI ANM 1','ANM',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(13,'XI DKV 1','DKV',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(14,'XI BDP 1','BDP',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(15,'XI AKT 1','AKT',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(16,'XI AKT 2','AKT',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(17,'XII PPLG 1','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(18,'XII PPLG 2','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(19,'XII PPLG 3','PPLG',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(20,'XII ANM 1','ANM',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(21,'XII DKV 1','DKV',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(22,'XII BDP 1','BDP',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(23,'XII AKT 1','AKT',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22'),(24,'XII AKT 2','AKT',40,NULL,'2025-11-10 22:22:22','2025-11-10 22:22:22');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_11_10_055243_create_tahun_ajaran_table',1),(5,'2025_11_10_055255_create_kelas_table',1),(6,'2025_11_10_055307_create_siswas_table',1),(7,'2025_11_10_055326_create_wali_kelas_table',1),(8,'2025_11_10_055346_create_orang_tua_table',1),(9,'2025_11_10_055357_create_jenis_pelanggaran_table',1),(10,'2025_11_10_055410_create_pelanggaran_table',1),(11,'2025_11_10_055425_create_monitoring_pelanggaran_table',1),(12,'2025_11_10_055440_create_jenis_prestasi_table',1),(13,'2025_11_10_055452_create_prestasi_table',1),(14,'2025_11_10_055503_create_bimbingan_konseling_table',1),(15,'2025_11_10_065321_create_sanksi_table',1),(16,'2025_11_10_070340_create_pelaksanaan_sanksi_table',1),(17,'2025_11_10_212833_create_sessions_table',2),(18,'2024_01_15_000000_add_user_id_to_siswa_table',3),(19,'2024_01_15_000001_update_users_level_enum',4),(20,'2024_01_15_000002_fix_orang_tua_foreign_key',5),(21,'2024_11_12_000001_update_users_level_column',6),(22,'2025_11_13_025136_make_tahun_ajaran_id_nullable_in_bimbingan_konseling_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monitoring_pelanggaran`
--

DROP TABLE IF EXISTS `monitoring_pelanggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monitoring_pelanggaran` (
  `monitor_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pelanggaran_id` bigint(20) unsigned NOT NULL,
  `guru_kepsek` bigint(20) unsigned NOT NULL,
  `status_monitoring` enum('Diproses','Ditindaklanjuti','Selesai','Dibatalkan') NOT NULL DEFAULT 'Diproses',
  `catatan_monitoring` text DEFAULT NULL,
  `tanggal_monitoring` date NOT NULL,
  `tindak_lanjut` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`monitor_id`),
  KEY `monitoring_pelanggaran_guru_kepsek_foreign` (`guru_kepsek`),
  KEY `monitoring_pelanggaran_pelanggaran_id_index` (`pelanggaran_id`),
  KEY `monitoring_pelanggaran_status_monitoring_index` (`status_monitoring`),
  KEY `monitoring_pelanggaran_tanggal_monitoring_index` (`tanggal_monitoring`),
  CONSTRAINT `monitoring_pelanggaran_guru_kepsek_foreign` FOREIGN KEY (`guru_kepsek`) REFERENCES `users` (`user_id`),
  CONSTRAINT `monitoring_pelanggaran_pelanggaran_id_foreign` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`pelanggaran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monitoring_pelanggaran`
--

LOCK TABLES `monitoring_pelanggaran` WRITE;
/*!40000 ALTER TABLE `monitoring_pelanggaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `monitoring_pelanggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orang_tua`
--

DROP TABLE IF EXISTS `orang_tua`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orang_tua` (
  `orang_tua_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `hubungan` enum('Ayah','Ibu','Wali') NOT NULL,
  `nama_orang_tua` varchar(100) NOT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `pendidikan` varchar(50) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`orang_tua_id`),
  UNIQUE KEY `orang_tua_siswa_id_hubungan_unique` (`siswa_id`,`hubungan`),
  KEY `orang_tua_user_id_foreign` (`user_id`),
  CONSTRAINT `orang_tua_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`siswa_id`),
  CONSTRAINT `orang_tua_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orang_tua`
--

LOCK TABLES `orang_tua` WRITE;
/*!40000 ALTER TABLE `orang_tua` DISABLE KEYS */;
INSERT INTO `orang_tua` VALUES (1,NULL,2,'Ayah','akbar','pengusaha','s1 Manajemen','08976','bandung','2025-11-11 14:51:22','2025-11-11 14:51:22'),(2,NULL,1,'Ayah','Akbar','Wiraswasta',NULL,'081234567890','Jakarta','2025-11-11 17:05:11','2025-11-11 17:05:11'),(3,17,3,'Ayah','Saaep','Kurir','SMA','0897689','Jatinangor Sumedang','2025-11-11 21:44:22','2025-11-11 21:44:22'),(4,NULL,3,'Ibu','Fatimah','Ibu Rumah tangga','S2','098927782','Jatinangor Sumedang','2025-11-11 21:44:23','2025-11-11 21:44:23'),(10,NULL,6,'Ibu','Sel','rumah tangga','sd','008090909','jnjnjn','2025-11-12 16:19:08','2025-11-12 16:19:08');
/*!40000 ALTER TABLE `orang_tua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pelaksanaan_sanksi`
--

DROP TABLE IF EXISTS `pelaksanaan_sanksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pelaksanaan_sanksi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pelanggaran_id` bigint(20) unsigned NOT NULL,
  `guru_pengawas` bigint(20) unsigned NOT NULL,
  `deskripsi_pelaksanaan` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('pending','dalam_proses','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pelaksanaan_sanksi_pelanggaran_id_foreign` (`pelanggaran_id`),
  KEY `pelaksanaan_sanksi_guru_pengawas_foreign` (`guru_pengawas`),
  CONSTRAINT `pelaksanaan_sanksi_guru_pengawas_foreign` FOREIGN KEY (`guru_pengawas`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `pelaksanaan_sanksi_pelanggaran_id_foreign` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`pelanggaran_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelaksanaan_sanksi`
--

LOCK TABLES `pelaksanaan_sanksi` WRITE;
/*!40000 ALTER TABLE `pelaksanaan_sanksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `pelaksanaan_sanksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pelanggaran`
--

DROP TABLE IF EXISTS `pelanggaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pelanggaran` (
  `pelanggaran_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `guru_pencatat` bigint(20) unsigned NOT NULL,
  `jenis_pelanggaran_id` bigint(20) unsigned NOT NULL,
  `tahun_ajaran_id` bigint(20) unsigned NOT NULL,
  `point` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('Pending','Terverifikasi','Ditolak') NOT NULL DEFAULT 'Pending',
  `guru_verifikator` bigint(20) unsigned DEFAULT NULL,
  `catatan_verifikasi` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pelanggaran_id`),
  KEY `pelanggaran_jenis_pelanggaran_id_foreign` (`jenis_pelanggaran_id`),
  KEY `pelanggaran_tahun_ajaran_id_foreign` (`tahun_ajaran_id`),
  KEY `pelanggaran_guru_verifikator_foreign` (`guru_verifikator`),
  KEY `pelanggaran_siswa_id_index` (`siswa_id`),
  KEY `pelanggaran_status_verifikasi_index` (`status_verifikasi`),
  KEY `pelanggaran_tanggal_index` (`tanggal`),
  KEY `pelanggaran_guru_pencatat_index` (`guru_pencatat`),
  CONSTRAINT `pelanggaran_guru_pencatat_foreign` FOREIGN KEY (`guru_pencatat`) REFERENCES `users` (`user_id`),
  CONSTRAINT `pelanggaran_guru_verifikator_foreign` FOREIGN KEY (`guru_verifikator`) REFERENCES `users` (`user_id`),
  CONSTRAINT `pelanggaran_jenis_pelanggaran_id_foreign` FOREIGN KEY (`jenis_pelanggaran_id`) REFERENCES `jenis_pelanggaran` (`jenis_pelanggaran_id`),
  CONSTRAINT `pelanggaran_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`siswa_id`),
  CONSTRAINT `pelanggaran_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`tahun_ajaran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelanggaran`
--

LOCK TABLES `pelanggaran` WRITE;
/*!40000 ALTER TABLE `pelanggaran` DISABLE KEYS */;
INSERT INTO `pelanggaran` VALUES (2,2,7,3,1,1,'Nais','bukti-pelanggaran/LNLnE9qZXbqwajnO8qh70Tu5hrG29YYLR5bjMCNy.png','Terverifikasi',NULL,NULL,'2025-11-18','2025-11-11 22:47:08','2025-11-11 22:51:21'),(3,1,7,2,1,1,'Kabur','bukti-pelanggaran/kXoPvesORGUIhADV7EVx5IV50vtippr4Ku8a6Wsp.png','Terverifikasi',NULL,NULL,'2025-11-08','2025-11-11 22:52:18','2025-11-11 22:52:28'),(4,7,7,2,1,1,'kabur','bukti-pelanggaran/9mN6ymzIrpGPYyh8A2dCgz6zzI6hHNDLS2DfERqG.png','Terverifikasi',NULL,NULL,'2025-11-13','2025-11-12 16:37:35','2025-11-12 16:37:48');
/*!40000 ALTER TABLE `pelanggaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestasi`
--

DROP TABLE IF EXISTS `prestasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestasi` (
  `prestasi_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `guru_pencatat` bigint(20) unsigned NOT NULL,
  `jenis_prestasi_id` bigint(20) unsigned NOT NULL,
  `tahun_ajaran_id` bigint(20) unsigned NOT NULL,
  `point` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tingkat` enum('Sekolah','Kecamatan','Kota','Provinsi','Nasional','Internasional') NOT NULL,
  `penghargaan` varchar(100) DEFAULT NULL,
  `bukti_dokumen` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('Pending','Terverifikasi','Ditolak') NOT NULL DEFAULT 'Pending',
  `guru_verifikator` bigint(20) unsigned DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`prestasi_id`),
  KEY `prestasi_jenis_prestasi_id_foreign` (`jenis_prestasi_id`),
  KEY `prestasi_tahun_ajaran_id_foreign` (`tahun_ajaran_id`),
  KEY `prestasi_guru_verifikator_foreign` (`guru_verifikator`),
  KEY `prestasi_siswa_id_index` (`siswa_id`),
  KEY `prestasi_status_verifikasi_index` (`status_verifikasi`),
  KEY `prestasi_tanggal_index` (`tanggal`),
  KEY `prestasi_guru_pencatat_index` (`guru_pencatat`),
  CONSTRAINT `prestasi_guru_pencatat_foreign` FOREIGN KEY (`guru_pencatat`) REFERENCES `users` (`user_id`),
  CONSTRAINT `prestasi_guru_verifikator_foreign` FOREIGN KEY (`guru_verifikator`) REFERENCES `users` (`user_id`),
  CONSTRAINT `prestasi_jenis_prestasi_id_foreign` FOREIGN KEY (`jenis_prestasi_id`) REFERENCES `jenis_prestasi` (`jenis_prestasi_id`),
  CONSTRAINT `prestasi_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`siswa_id`),
  CONSTRAINT `prestasi_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`tahun_ajaran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestasi`
--

LOCK TABLES `prestasi` WRITE;
/*!40000 ALTER TABLE `prestasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sanksi`
--

DROP TABLE IF EXISTS `sanksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sanksi` (
  `sanksi_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pelanggaran_id` bigint(20) unsigned NOT NULL,
  `jenis_sanksi` varchar(100) NOT NULL,
  `deskripsi_sanksi` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('Dijadwalkan','Berjalan','Selesai','Dibatalkan') NOT NULL DEFAULT 'Dijadwalkan',
  `catatan_pelaksanaan` text DEFAULT NULL,
  `guru_penanggung_jawab` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sanksi_id`),
  KEY `sanksi_pelanggaran_id_index` (`pelanggaran_id`),
  KEY `sanksi_status_index` (`status`),
  KEY `sanksi_tanggal_mulai_index` (`tanggal_mulai`),
  KEY `sanksi_guru_penanggung_jawab_index` (`guru_penanggung_jawab`),
  CONSTRAINT `sanksi_guru_penanggung_jawab_foreign` FOREIGN KEY (`guru_penanggung_jawab`) REFERENCES `users` (`user_id`),
  CONSTRAINT `sanksi_pelanggaran_id_foreign` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`pelanggaran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sanksi`
--

LOCK TABLES `sanksi` WRITE;
/*!40000 ALTER TABLE `sanksi` DISABLE KEYS */;
INSERT INTO `sanksi` VALUES (2,2,'berat','Wajib Di do','2025-11-12','2025-11-13','Dijadwalkan',NULL,7,'2025-11-11 22:53:35','2025-11-11 22:53:35');
/*!40000 ALTER TABLE `sanksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('rqtrw1ZlPA2pDDVW0eIjXVbsIft6NE2R2lsETG4O',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibDVSbE53eDRSdXI5UzdROGlCRUJBbVJYWWFIOVpLOW0wNkRtenU4ViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7czo1OiJyb3V0ZSI7czo4OiJyZWdpc3RlciI7fXM6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=',1763014564);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siswa` (
  `siswa_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `nis` varchar(20) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `kelas_id` bigint(20) unsigned NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`siswa_id`),
  UNIQUE KEY `siswa_nis_unique` (`nis`),
  UNIQUE KEY `siswa_nisn_unique` (`nisn`),
  KEY `siswa_kelas_id_foreign` (`kelas_id`),
  KEY `siswa_user_id_foreign` (`user_id`),
  CONSTRAINT `siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`),
  CONSTRAINT `siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa`
--

LOCK TABLES `siswa` WRITE;
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
INSERT INTO `siswa` VALUES (1,15,'2024001','`1222234','Ahmad Rizki','L','2007-06-12','bandung','permata biru','098885',19,'foto-siswa/p9uCwFmzM0K4sLDGj4S3CKqXraMl9yJJavVMCQI6.png','2025-11-10 22:24:01','2025-11-11 19:13:32'),(2,NULL,'1212133334','897889','Anwarudin','L','2025-11-12','jogja','cileunyi','0897665',18,'foto-siswa/k8bXUJYoG3WzTQFJL2qWELu2s6JICYJPv8qmMef1.png','2025-11-10 22:27:29','2025-11-11 19:00:09'),(3,NULL,'76388','12331122','Fahmi Raihan','L','2025-11-29','Cileunyi','Jatinangor Sumedang','098637388',11,'foto-siswa/y1O63xAhtn9kRmtTs1o0JOm6SKfPbjspOdfOEUiU.png','2025-11-11 21:44:22','2025-11-11 21:44:46'),(4,NULL,'1212133345','7677775876','Azman','L','2025-11-24','Jatinangor','Tanjung Sari','089977',16,'foto-siswa/9QrrbbmC9uPIDLcpDcPIIyFHvLxchywsmWXDVlFk.png','2025-11-11 22:06:19','2025-11-11 22:06:19'),(6,21,'788829','82921','farhat','P','2025-11-01','malang','jawa','099888',10,'foto-siswa/HvtJrdsCZywec8Y0ZdQ3bE51r3sCstrYy1TTQCJL.png','2025-11-12 16:18:14','2025-11-12 16:18:14'),(7,22,'652778','78929','Bagas Bagus','L','2025-11-16','Cirebon','Cirebon','09090909',19,'foto-siswa/E6YcEtQHJbq1HymU4VoeiDPtCs5xCJe9v7JNXP25.png','2025-11-12 16:30:33','2025-11-12 16:30:33');
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tahun_ajaran`
--

DROP TABLE IF EXISTS `tahun_ajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tahun_ajaran` (
  `tahun_ajaran_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_tahun` varchar(10) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 0,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tahun_ajaran_id`),
  UNIQUE KEY `tahun_ajaran_kode_tahun_unique` (`kode_tahun`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tahun_ajaran`
--

LOCK TABLES `tahun_ajaran` WRITE;
/*!40000 ALTER TABLE `tahun_ajaran` DISABLE KEYS */;
INSERT INTO `tahun_ajaran` VALUES (1,'2024/2025','2024/2025','1',1,'2024-07-01','2025-06-30','2025-11-10 22:21:36','2025-11-10 22:21:36');
/*!40000 ALTER TABLE `tahun_ajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `level` varchar(20) NOT NULL,
  `can_verify` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$12$PxvVD9DA30BtzTTqcz2tUuFXcIWKhXCTESRaIw9ZsSQ2G7leoR.gy','Administrator','admin',1,1,NULL,'2025-11-10 21:57:29','2025-11-10 21:57:29'),(4,'wakel','$2y$12$cYCMKDd9Xa79xKrUiMXfz.rximLSN9FM8Kf8a3jcRyEWR/zNlV9YC','wakel','guru',0,1,NULL,'2025-11-11 05:52:00','2025-11-11 18:40:39'),(7,'kesiswaan','$2y$12$TnqaweQPtTNfPwrPSLXyPuPLf6lvXWOenOTfai4cH/9KjNqAlIrii','Staff Kesiswaan','kesiswaan',1,1,NULL,'2025-11-11 16:23:36','2025-11-11 17:39:02'),(15,'Ami','$2y$12$Q2mGXrAQ30XHvqRejl.zzOk571rLH.YbGIE8D0BCoXxn9MNKBT6w.','Raihan Fahmi','murid',0,1,NULL,'2025-11-11 19:13:32','2025-11-11 22:26:59'),(17,'Abay','$2y$12$55SQtwqS5Y7JNFeCEl61zu8D7EtBVipnWB.yX8uq3MWOK1itzcuoW','Saaep','orang_tua',0,1,NULL,'2025-11-11 21:44:22','2025-11-12 18:59:41'),(20,'1298228','$2y$12$WutvlAUixCR5utyCOj7yOu1LwB6U1j0zSnq6lMGy1oNWQb11oQ4tO','Rizki','siswa',0,1,NULL,'2025-11-12 16:15:05','2025-11-12 16:15:05'),(21,'788829','$2y$12$BKrpqpub6PhDRdO2OcMd1uz2z9SmdT2cvPxS242B6jsVKImwqeunS','farhat','siswa',0,1,NULL,'2025-11-12 16:18:14','2025-11-12 16:18:14'),(22,'bagas','$2y$12$H3.snmIL5ICvAwM/zTg1LuxGL70kgqLtbvrGtzoY6.WrOkwS4dWYq','Bagas Bagus','siswa',0,1,NULL,'2025-11-12 16:30:33','2025-11-12 16:30:33'),(23,'bk','$2y$12$EDogLw4LRyaVDioc/DxvMuo80oIgP4WW.CdRz/.rdaFJG.pwBkjry','bk','guru',0,1,NULL,'2025-11-12 17:55:28','2025-11-12 17:55:28'),(24,'gurubk','$2y$12$C..BDIAubrTfR9psd/MtoeW.dJxC2g0/YbbH5fSnsOhBUUe2AtEOm','Guru BK','bk',1,1,NULL,'2025-11-12 17:57:46','2025-11-12 17:57:46'),(25,'kepsek','$2y$12$MAcik6MTQobvl.ub7Kaemu8Q5o6ih38nX.C1ZDuP0YXrkPhkm1aDm','kepsek','kepsek',0,1,NULL,'2025-11-12 19:40:05','2025-11-12 19:52:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wali_kelas`
--

DROP TABLE IF EXISTS `wali_kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wali_kelas` (
  `wali_kelas_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `bidang_studi` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `status` enum('Aktif','Non-Aktif') NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`wali_kelas_id`),
  UNIQUE KEY `wali_kelas_nip_unique` (`nip`),
  UNIQUE KEY `wali_kelas_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wali_kelas`
--

LOCK TABLES `wali_kelas` WRITE;
/*!40000 ALTER TABLE `wali_kelas` DISABLE KEYS */;
INSERT INTO `wali_kelas` VALUES (2,'872829','Sdap','L','PKN','ranzzz071103@gmail.com','090872727','Aktif','2025-11-11 22:19:49','2025-11-11 22:20:02');
/*!40000 ALTER TABLE `wali_kelas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-13 14:33:54
