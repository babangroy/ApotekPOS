-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for apotekpos
CREATE DATABASE IF NOT EXISTS `apotekpos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `apotekpos`;

-- Dumping structure for table apotekpos.barangs
CREATE TABLE IF NOT EXISTS `barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_id` bigint unsigned NOT NULL,
  `kategori_id` bigint unsigned NOT NULL,
  `merek_id` bigint unsigned NOT NULL,
  `pabrikan_id` bigint unsigned DEFAULT NULL,
  `satuan_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barangs_kode_unique` (`kode`),
  UNIQUE KEY `barangs_barcode_unique` (`barcode`),
  KEY `barangs_jenis_id_foreign` (`jenis_id`),
  KEY `barangs_kategori_id_foreign` (`kategori_id`),
  KEY `barangs_merek_id_foreign` (`merek_id`),
  KEY `barangs_satuan_id_foreign` (`satuan_id`),
  KEY `barangs_nama_index` (`nama`),
  KEY `barangs_pabrikan_id_foreign` (`pabrikan_id`),
  CONSTRAINT `barangs_jenis_id_foreign` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `barangs_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `barangs_merek_id_foreign` FOREIGN KEY (`merek_id`) REFERENCES `mereks` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `barangs_pabrikan_id_foreign` FOREIGN KEY (`pabrikan_id`) REFERENCES `pabrikans` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `barangs_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuans` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.barangs: ~20 rows (approximately)
INSERT INTO `barangs` (`id`, `kode`, `barcode`, `nama`, `jenis_id`, `kategori_id`, `merek_id`, `pabrikan_id`, `satuan_id`, `created_at`, `updated_at`) VALUES
	(2, 'BRG-00002', '84545656164197', 'Amoxicillin 500 mg', 2, 3, 12, 2, 8, '2025-11-06 07:25:20', '2025-11-06 08:39:05'),
	(3, 'BRG-00003', '15512125451215', 'Loratadine 10 mg', 3, 2, 13, 3, 1, '2025-11-06 07:41:11', '2025-11-06 08:39:34'),
	(4, 'BRG-00004', '787845415452', 'Omeprazole 20 mg', 4, 3, 14, 4, 8, '2025-11-06 07:46:42', '2025-11-06 08:40:04'),
	(5, 'BRG-00005', '452154512124515', 'Vitamin C 500 mg', 5, 1, 15, 5, 1, '2025-11-06 08:00:05', '2025-11-06 08:40:44'),
	(6, 'BRG-00006', '865984564984561', 'Paracetamol 500 mg', 1, 1, 16, 1, 1, '2025-11-06 08:32:26', '2025-11-06 08:32:26'),
	(7, 'BRG-00007', '784946516785', 'Metformin 500 mg', 8, 3, 17, 6, 1, '2025-11-06 08:44:50', '2025-11-06 08:44:50'),
	(8, 'BRG-00008', '464651941651651', 'Ambroxol 30 mg', 9, 2, 18, 7, 1, '2025-11-06 08:58:22', '2025-11-06 08:58:22'),
	(9, 'BRG-00009', '32326455151', 'Asam Mefenamat 500 mg', 1, 2, 19, 4, 8, '2025-11-06 09:00:00', '2025-11-06 09:00:00'),
	(10, 'BRG-00010', '787841651651', 'Cetirizine 10 mg', 3, 2, 20, 8, 1, '2025-11-06 09:00:57', '2025-11-06 09:00:57'),
	(11, 'BRG-00011', '985654251622', 'Antasida', 4, 1, 21, 4, 1, '2025-11-06 09:01:58', '2025-11-06 09:01:58'),
	(12, 'BRG-00012', '751231846', 'Ibuprofen 400 mg', 1, 2, 22, 9, 1, '2025-11-06 09:08:41', '2025-11-06 09:08:41'),
	(13, 'BRG-00013', '7894651326', 'Salbutamol 2 mg', 10, 3, 23, 1, 1, '2025-11-06 09:09:40', '2025-11-06 09:09:40'),
	(14, 'BRG-00014', '9556682215151', 'Simvastatin 20 mg', 11, 3, 24, 6, 1, '2025-11-06 09:11:05', '2025-11-06 09:11:05'),
	(15, 'BRG-00015', '7894564561516', 'Captopril 25 mg', 12, 3, 25, 10, 1, '2025-11-06 09:12:30', '2025-11-06 09:12:30'),
	(16, 'BRG-00016', '3213216465456', 'Glibenclamide 5 mg', 8, 3, 26, 11, 1, '2025-11-06 09:13:22', '2025-11-06 09:13:22'),
	(17, 'BRG-00017', '9312154356000', 'Ranitidine 150 mg', 13, 3, 27, 1, 1, '2025-11-06 09:14:47', '2025-11-06 09:14:47'),
	(18, 'BRG-00018', '789596616126', 'Dexamethasone 0.5 mg', 14, 3, 1, 2, 1, '2025-11-06 09:16:25', '2025-11-06 09:16:25'),
	(19, 'BRG-00019', '133320002544', 'Furosemide 40 mg', 15, 3, 28, 11, 1, '2025-11-06 09:17:28', '2025-11-06 09:17:28'),
	(20, 'BRG-00020', '7899846516111256', 'Cefadroxil 500 mg', 2, 3, 1, 12, 8, '2025-11-06 09:18:25', '2025-11-06 09:18:25'),
	(21, 'BRG-00021', '798495165161', 'Metronidazole 500 mg', 16, 3, 29, 11, 1, '2025-11-06 09:20:06', '2025-11-06 09:20:06');

-- Dumping structure for table apotekpos.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.cache: ~2 rows (approximately)

-- Dumping structure for table apotekpos.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.cache_locks: ~0 rows (approximately)

-- Dumping structure for table apotekpos.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table apotekpos.jenis
CREATE TABLE IF NOT EXISTS `jenis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.jenis: ~15 rows (approximately)
INSERT INTO `jenis` (`id`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 'Analgesic', '2025-11-06 04:59:59', '2025-11-06 04:59:59'),
	(2, 'Antibiotik', '2025-11-06 05:03:46', '2025-11-06 05:03:46'),
	(3, 'Antihistamin', '2025-11-06 05:03:53', '2025-11-06 05:03:53'),
	(4, 'Antasida', '2025-11-06 05:04:12', '2025-11-06 05:04:12'),
	(5, 'Vitamin & Suplemen', '2025-11-06 05:04:21', '2025-11-06 05:04:21'),
	(6, 'Kardiovaskular', '2025-11-06 05:04:33', '2025-11-06 05:04:33'),
	(8, 'Antidiabetes', '2025-11-06 08:44:03', '2025-11-06 08:44:03'),
	(9, 'Ekspektoran', '2025-11-06 08:56:57', '2025-11-06 08:56:57'),
	(10, 'Bronkodilator', '2025-11-06 09:09:05', '2025-11-06 09:09:05'),
	(11, 'Antikolesterol', '2025-11-06 09:10:36', '2025-11-06 09:10:36'),
	(12, 'Antihipertensi', '2025-11-06 09:11:56', '2025-11-06 09:11:56'),
	(13, 'Antiulcer', '2025-11-06 09:14:05', '2025-11-06 09:14:05'),
	(14, 'Kortikosteroid', '2025-11-06 09:15:49', '2025-11-06 09:15:49'),
	(15, 'Diuretik', '2025-11-06 09:16:49', '2025-11-06 09:16:49'),
	(16, 'Antiprotozoa', '2025-11-06 09:19:30', '2025-11-06 09:19:30');

-- Dumping structure for table apotekpos.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.jobs: ~0 rows (approximately)

-- Dumping structure for table apotekpos.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.job_batches: ~0 rows (approximately)

-- Dumping structure for table apotekpos.kategoris
CREATE TABLE IF NOT EXISTS `kategoris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.kategoris: ~5 rows (approximately)
INSERT INTO `kategoris` (`id`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 'Obat Bebas', '2025-11-06 05:18:57', '2025-11-06 05:18:57'),
	(2, 'Obat Bebas Terbatas', '2025-11-06 05:19:08', '2025-11-06 05:19:08'),
	(3, 'Obat Keras', '2025-11-06 05:19:16', '2025-11-06 05:19:16'),
	(4, 'Psikotropika', '2025-11-06 05:19:21', '2025-11-06 05:19:21'),
	(5, 'Narkotika', '2025-11-06 05:19:27', '2025-11-06 05:19:27');

-- Dumping structure for table apotekpos.konversi_satuans
CREATE TABLE IF NOT EXISTS `konversi_satuans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barang_id` bigint unsigned NOT NULL,
  `sat_lv_1` bigint unsigned NOT NULL,
  `jlh_lv_1` int unsigned NOT NULL,
  `sat_lv_2` bigint unsigned DEFAULT NULL,
  `jlh_lv_2` int unsigned DEFAULT NULL,
  `sat_lv_3` bigint unsigned DEFAULT NULL,
  `jlh_lv_3` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `konversi_satuans_barang_id_foreign` (`barang_id`),
  KEY `konversi_satuans_sat_lv_1_foreign` (`sat_lv_1`),
  KEY `konversi_satuans_sat_lv_2_foreign` (`sat_lv_2`),
  KEY `konversi_satuans_sat_lv_3_foreign` (`sat_lv_3`),
  CONSTRAINT `konversi_satuans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `konversi_satuans_sat_lv_1_foreign` FOREIGN KEY (`sat_lv_1`) REFERENCES `satuans` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `konversi_satuans_sat_lv_2_foreign` FOREIGN KEY (`sat_lv_2`) REFERENCES `satuans` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `konversi_satuans_sat_lv_3_foreign` FOREIGN KEY (`sat_lv_3`) REFERENCES `satuans` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.konversi_satuans: ~20 rows (approximately)
INSERT INTO `konversi_satuans` (`id`, `barang_id`, `sat_lv_1`, `jlh_lv_1`, `sat_lv_2`, `jlh_lv_2`, `sat_lv_3`, `jlh_lv_3`, `created_at`, `updated_at`) VALUES
	(1, 6, 1, 1, 2, 10, 3, 10, '2025-11-06 11:52:55', '2025-11-06 11:52:55'),
	(2, 16, 1, 1, 2, 10, 3, 10, '2025-11-06 12:18:14', '2025-11-06 12:18:14'),
	(3, 2, 8, 1, 4, 10, NULL, NULL, '2025-11-06 13:07:53', '2025-11-06 13:44:11'),
	(4, 13, 1, 1, 2, 10, 3, 10, '2025-11-06 13:41:34', '2025-11-06 13:41:34'),
	(5, 21, 1, 1, 2, 10, NULL, NULL, '2025-11-06 14:25:18', '2025-11-06 15:29:23'),
	(6, 14, 1, 1, 2, 10, NULL, NULL, '2025-11-06 14:47:35', '2025-11-06 14:47:35'),
	(7, 19, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:25:49', '2025-11-06 15:25:49'),
	(8, 3, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:27:11', '2025-11-06 15:27:11'),
	(9, 4, 8, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:27:16', '2025-11-06 15:27:16'),
	(10, 5, 1, 1, 2, 10, NULL, NULL, '2025-11-06 15:27:21', '2025-11-06 16:00:54'),
	(11, 7, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:27:31', '2025-11-06 15:27:31'),
	(12, 8, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:27:39', '2025-11-06 15:27:39'),
	(13, 9, 8, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:27:51', '2025-11-06 15:27:51'),
	(14, 10, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:27:58', '2025-11-06 15:27:58'),
	(15, 11, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:28:03', '2025-11-06 15:28:03'),
	(16, 12, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:28:08', '2025-11-06 15:28:08'),
	(17, 15, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:28:26', '2025-11-06 15:28:26'),
	(18, 17, 1, 1, 2, 10, NULL, NULL, '2025-11-06 15:28:40', '2025-11-06 16:06:17'),
	(19, 18, 1, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:28:45', '2025-11-06 15:28:45'),
	(20, 20, 8, 1, NULL, NULL, NULL, NULL, '2025-11-06 15:28:55', '2025-11-06 15:28:55');

-- Dumping structure for table apotekpos.mereks
CREATE TABLE IF NOT EXISTS `mereks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mereks_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.mereks: ~19 rows (approximately)
INSERT INTO `mereks` (`id`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 'Generik', '2025-11-06 05:36:49', '2025-11-06 05:36:49'),
	(12, 'Amoxan', '2025-11-06 07:24:53', '2025-11-06 07:24:53'),
	(13, 'Claritin', '2025-11-06 07:40:57', '2025-11-06 07:40:57'),
	(14, 'Omeprol', '2025-11-06 07:46:31', '2025-11-06 07:46:31'),
	(15, 'Xon-Ce', '2025-11-06 07:59:53', '2025-11-06 07:59:53'),
	(16, 'Panadol', '2025-11-06 08:31:54', '2025-11-06 08:31:54'),
	(17, 'Glucophage', '2025-11-06 08:44:27', '2025-11-06 08:44:27'),
	(18, 'Woods', '2025-11-06 08:57:54', '2025-11-06 08:57:54'),
	(19, 'Mefinal', '2025-11-06 08:59:38', '2025-11-06 08:59:38'),
	(20, 'Zyrtec', '2025-11-06 09:00:34', '2025-11-06 09:00:34'),
	(21, 'Promag', '2025-11-06 09:01:39', '2025-11-06 09:01:39'),
	(22, 'Proris', '2025-11-06 09:08:15', '2025-11-06 09:08:15'),
	(23, 'Ventolin', '2025-11-06 09:09:20', '2025-11-06 09:09:20'),
	(24, 'Zocor', '2025-11-06 09:10:51', '2025-11-06 09:10:51'),
	(25, 'Capoten', '2025-11-06 09:12:12', '2025-11-06 09:12:12'),
	(26, 'Daonil', '2025-11-06 09:13:05', '2025-11-06 09:13:05'),
	(27, 'Zantac', '2025-11-06 09:14:26', '2025-11-06 09:14:26'),
	(28, 'Lasix', '2025-11-06 09:17:08', '2025-11-06 09:17:08'),
	(29, 'Flagyl', '2025-11-06 09:19:45', '2025-11-06 09:19:45'),
	(30, 'Hanox', '2025-11-06 16:29:14', '2025-11-06 16:29:14');

-- Dumping structure for table apotekpos.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.migrations: ~12 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_11_06_044503_create_jenis_table', 2),
	(5, '2025_11_06_121145_create_kategoris_table', 3),
	(6, '2025_11_06_122037_create_satuans_table', 4),
	(7, '2025_11_06_122930_create_mereks_table', 5),
	(8, '2025_11_06_124234_create_barangs_table', 6),
	(9, '2025_11_06_143333_add_kode_to_barangs_table', 7),
	(10, '2025_11_06_151531_create_pabrikans_table', 8),
	(11, '2025_11_06_151545_add_pabrikan_to_barangs_table', 8),
	(12, '2025_11_06_151852_add_pabrikan_to_barangs_table', 9),
	(13, '2025_11_06_180539_create_konversi_satuans_table', 10);

-- Dumping structure for table apotekpos.pabrikans
CREATE TABLE IF NOT EXISTS `pabrikans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pabrikans_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.pabrikans: ~12 rows (approximately)
INSERT INTO `pabrikans` (`id`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 'GlaxoSmithKline', '2025-11-06 08:32:12', '2025-11-06 08:32:12'),
	(2, 'Dexa Medica', '2025-11-06 08:39:00', '2025-11-06 08:39:00'),
	(3, 'Bayer', '2025-11-06 08:39:29', '2025-11-06 08:39:29'),
	(4, 'Kalbe Farma', '2025-11-06 08:39:59', '2025-11-06 08:39:59'),
	(5, 'Konimex', '2025-11-06 08:40:39', '2025-11-06 08:40:39'),
	(6, 'Merck', '2025-11-06 08:44:40', '2025-11-06 08:44:40'),
	(7, 'Sterling', '2025-11-06 08:58:10', '2025-11-06 08:58:10'),
	(8, 'UCB', '2025-11-06 09:00:48', '2025-11-06 09:00:48'),
	(9, 'Kimia Farma', '2025-11-06 09:08:29', '2025-11-06 09:08:29'),
	(10, 'Bristol-Myers Squibb', '2025-11-06 09:12:22', '2025-11-06 09:12:22'),
	(11, 'Sanofi', '2025-11-06 09:13:14', '2025-11-06 09:13:14'),
	(12, 'Sanbe Farma', '2025-11-06 09:18:18', '2025-11-06 09:18:18');

-- Dumping structure for table apotekpos.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table apotekpos.satuans
CREATE TABLE IF NOT EXISTS `satuans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `satuans_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.satuans: ~8 rows (approximately)
INSERT INTO `satuans` (`id`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 'Tablet', '2025-11-06 05:27:15', '2025-11-06 05:27:15'),
	(2, 'Strip', '2025-11-06 05:27:26', '2025-11-06 05:27:26'),
	(3, 'Box', '2025-11-06 05:27:33', '2025-11-06 05:27:33'),
	(4, 'Ampul', '2025-11-06 05:27:39', '2025-11-06 05:27:39'),
	(5, 'Pcs', '2025-11-06 05:27:44', '2025-11-06 05:27:44'),
	(6, 'Botol', '2025-11-06 05:28:00', '2025-11-06 05:28:00'),
	(8, 'Kapsul', '2025-11-06 07:25:15', '2025-11-06 07:25:15');

-- Dumping structure for table apotekpos.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.sessions: ~0 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('hWlTVjLYSpRM0pWu8OVoJJaS8y9hANaa6HSQAqVj', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiSlE4SW5Wa051a2dKVWlsU0tKa1lRQXV6Y1VVRzFvUDN2ZmZNRHNqViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly9hcG90ZWtwb3MudGVzdC9hZG1pbi9tYXN0ZXIva29udmVyc2ktc2F0dWFucyI7czo1OiJyb3V0ZSI7czo1NDoiZmlsYW1lbnQuYWRtaW4ubWFzdGVyLnJlc291cmNlcy5rb252ZXJzaS1zYXR1YW5zLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRDalNRYnpETHFqRWNBa0RKd1RkMUplUy8wZDNzQWhOeFh5ZTV6ZG1VLjA1U2ZYZXFwdkZDUyI7czo2OiJ0YWJsZXMiO2E6Nzp7czo0MDoiNWEyYTYxZDdjNWY0MWY0NWEzYWI5YjIzYjViYTRmODNfY29sdW1ucyI7YTo5OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJrb2RlIjtzOjU6ImxhYmVsIjtzOjExOiJLb2RlIEJhcmFuZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NzoiYmFyY29kZSI7czo1OiJsYWJlbCI7czoxNDoiQmFyY29kZSBCYXJhbmciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6MTE6Ik5hbWEgQmFyYW5nIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiamVuaXMubmFtYSI7czo1OiJsYWJlbCI7czo1OiJKZW5pcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6ImthdGVnb3JpLm5hbWEiO3M6NToibGFiZWwiO3M6ODoiS2F0ZWdvcmkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJtZXJlay5uYW1hIjtzOjU6ImxhYmVsIjtzOjU6Ik1lcmVrIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMzoicGFicmlrYW4ubmFtYSI7czo1OiJsYWJlbCI7czo4OiJQYWJyaWthbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InNhdHVhbi5uYW1hIjtzOjU6ImxhYmVsIjtzOjE1OiJTYXR1YW4gVGVya2VjaWwiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6Ijk0NWQ1MWNjY2ZhMzIxNjE1YTFiMjExYzk5MmZiYzhiX2NvbHVtbnMiO2E6ODp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImJhcmFuZy5uYW1hIjtzOjU6ImxhYmVsIjtzOjExOiJOYW1hIEJhcmFuZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6InNhdHVhbl8xLm5hbWEiO3M6NToibGFiZWwiO3M6MTE6IlNhdHVhbiBMdi4xIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJqbGhfbHZfMSI7czo1OiJsYWJlbCI7czo4OiJKbGggbHYuMSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6InNhdHVhbl8yLm5hbWEiO3M6NToibGFiZWwiO3M6MTE6IlNhdHVhbiBMdi4yIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJqbGhfbHZfMiI7czo1OiJsYWJlbCI7czo4OiJKbGggbHYuMiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6InNhdHVhbl8zLm5hbWEiO3M6NToibGFiZWwiO3M6MTE6IlNhdHVhbiBMdi4zIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJqbGhfbHZfMyI7czo1OiJsYWJlbCI7czo4OiJKbGggbHYuMyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiNDA4MzgwZWU5YzY4ODU4ZDJmMDg3ZWI2Mjg5ZDI0NWNfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjU6IkplbmlzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiIyNTg0NGM2ZWZkNDE0YzY3Y2M0NTVmY2Q2MGMxNWQ4ZV9jb2x1bW5zIjthOjI6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyOiJubyI7czo1OiJsYWJlbCI7czozOiJOby4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6ODoiS2F0ZWdvcmkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjNhOWM3NTQ4NjQ0Mjk4ZmYwNmFhYjljZmYxZDYwNDU0X2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czo1OiJNZXJlayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiOWRkNjIwZGZkNGFlOGZiN2NlOGUwMDY4NTVhY2FlYmZfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjExOiJOYW1hIFNhdHVhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiMTllMzY5NTcwNzczYzE0MzAwYTI5OTNhZGJlNDJlMGFfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjEzOiJOYW1hIFBhYnJpa2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX19czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1762446636),
	('RpJqJgjySDJGCzQqR0hkKSRZfanK0lYRcedW3Klv', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiZmFhSnU3ZmEzcUI5RndoczAzTGp4MzE3NnNUSEIzRTF4enpiRXNsZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYXN0ZXIva2F0ZWdvcmlzIjtzOjU6InJvdXRlIjtzOjQ3OiJmaWxhbWVudC5hZG1pbi5tYXN0ZXIucmVzb3VyY2VzLmthdGVnb3Jpcy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRDalNRYnpETHFqRWNBa0RKd1RkMUplUy8wZDNzQWhOeFh5ZTV6ZG1VLjA1U2ZYZXFwdkZDUyI7czo2OiJ0YWJsZXMiO2E6NTp7czo0MDoiNWEyYTYxZDdjNWY0MWY0NWEzYWI5YjIzYjViYTRmODNfY29sdW1ucyI7YTo5OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJrb2RlIjtzOjU6ImxhYmVsIjtzOjExOiJLb2RlIEJhcmFuZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NzoiYmFyY29kZSI7czo1OiJsYWJlbCI7czoxNDoiQmFyY29kZSBCYXJhbmciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6MTE6Ik5hbWEgQmFyYW5nIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiamVuaXMubmFtYSI7czo1OiJsYWJlbCI7czo1OiJKZW5pcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6ImthdGVnb3JpLm5hbWEiO3M6NToibGFiZWwiO3M6ODoiS2F0ZWdvcmkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJtZXJlay5uYW1hIjtzOjU6ImxhYmVsIjtzOjU6Ik1lcmVrIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMzoicGFicmlrYW4ubmFtYSI7czo1OiJsYWJlbCI7czo4OiJQYWJyaWthbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InNhdHVhbi5uYW1hIjtzOjU6ImxhYmVsIjtzOjE1OiJTYXR1YW4gVGVya2VjaWwiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6Ijk0NWQ1MWNjY2ZhMzIxNjE1YTFiMjExYzk5MmZiYzhiX2NvbHVtbnMiO2E6ODp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImJhcmFuZy5uYW1hIjtzOjU6ImxhYmVsIjtzOjExOiJOYW1hIEJhcmFuZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6InNhdHVhbl8xLm5hbWEiO3M6NToibGFiZWwiO3M6MTE6IlNhdHVhbiBMdi4xIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJqbGhfbHZfMSI7czo1OiJsYWJlbCI7czo4OiJKbGggbHYuMSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6InNhdHVhbl8yLm5hbWEiO3M6NToibGFiZWwiO3M6MTE6IlNhdHVhbiBMdi4yIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJqbGhfbHZfMiI7czo1OiJsYWJlbCI7czo4OiJKbGggbHYuMiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6InNhdHVhbl8zLm5hbWEiO3M6NToibGFiZWwiO3M6MTE6IlNhdHVhbiBMdi4zIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJqbGhfbHZfMyI7czo1OiJsYWJlbCI7czo4OiJKbGggbHYuMyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiMjU4NDRjNmVmZDQxNGM2N2NjNDU1ZmNkNjBjMTVkOGVfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjg6IkthdGVnb3JpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiI0MDgzODBlZTljNjg4NThkMmYwODdlYjYyODlkMjQ1Y19jb2x1bW5zIjthOjI6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyOiJubyI7czo1OiJsYWJlbCI7czozOiJOby4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6NToiSmVuaXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjE5ZTM2OTU3MDc3M2MxNDMwMGEyOTkzYWRiZTQyZTBhX2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czoxMzoiTmFtYSBQYWJyaWthbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319fXM6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1762445266);

-- Dumping structure for table apotekpos.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'roy', 'roy@gmail.com', NULL, '$2y$12$CjSQbzDLqjEcAkDJwTd1JeS/0d3sAhNxXye5zdmU.05SfXeqpvFCS', NULL, '2025-11-05 20:15:18', '2025-11-05 20:15:18');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
