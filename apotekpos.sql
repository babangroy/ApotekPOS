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
  `kode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

-- Dumping data for table apotekpos.barangs: ~0 rows (approximately)
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
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.cache: ~2 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('sehat-farma-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1762420102),
	('sehat-farma-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1762420102;', 1762420102);

-- Dumping structure for table apotekpos.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.cache_locks: ~0 rows (approximately)

-- Dumping structure for table apotekpos.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table apotekpos.jenis
CREATE TABLE IF NOT EXISTS `jenis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.jenis: ~0 rows (approximately)
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
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.job_batches: ~0 rows (approximately)

-- Dumping structure for table apotekpos.kategoris
CREATE TABLE IF NOT EXISTS `kategoris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

-- Dumping structure for table apotekpos.mereks
CREATE TABLE IF NOT EXISTS `mereks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mereks_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.mereks: ~10 rows (approximately)
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
	(29, 'Flagyl', '2025-11-06 09:19:45', '2025-11-06 09:19:45');

-- Dumping structure for table apotekpos.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.migrations: ~4 rows (approximately)
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
	(12, '2025_11_06_151852_add_pabrikan_to_barangs_table', 9);

-- Dumping structure for table apotekpos.pabrikans
CREATE TABLE IF NOT EXISTS `pabrikans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pabrikans_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.pabrikans: ~0 rows (approximately)
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table apotekpos.satuans
CREATE TABLE IF NOT EXISTS `satuans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `satuans_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.satuans: ~6 rows (approximately)
INSERT INTO `satuans` (`id`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 'Tablet', '2025-11-06 05:27:15', '2025-11-06 05:27:15'),
	(2, 'Strip', '2025-11-06 05:27:26', '2025-11-06 05:27:26'),
	(3, 'Box', '2025-11-06 05:27:33', '2025-11-06 05:27:33'),
	(4, 'Ampul', '2025-11-06 05:27:39', '2025-11-06 05:27:39'),
	(5, 'Pcs', '2025-11-06 05:27:44', '2025-11-06 05:27:44'),
	(6, 'Botol', '2025-11-06 05:28:00', '2025-11-06 05:28:00'),
	(7, 'Iya', '2025-11-06 07:22:14', '2025-11-06 07:22:14'),
	(8, 'Kapsul', '2025-11-06 07:25:15', '2025-11-06 07:25:15');

-- Dumping structure for table apotekpos.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table apotekpos.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('Dfs5txJjvrB6G32ksxpFo5Zex843gtDnegJ7a7eW', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoib2dBbWZhamJaVTBMWTVNbEZtZ0N3eFQ1WkFnR3hDdTVUUDBjS00xaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9hcG90ZWtwb3MudGVzdC9hZG1pbi9tYXN0ZXIvbWVyZWtzIjtzOjU6InJvdXRlIjtzOjQ0OiJmaWxhbWVudC5hZG1pbi5tYXN0ZXIucmVzb3VyY2VzLm1lcmVrcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkQ2pTUWJ6RExxakVjQWtESndUZDFKZVMvMGQzc0FoTnhYeWU1emRtVS4wNVNmWGVxcHZGQ1MiO3M6NjoidGFibGVzIjthOjc6e3M6NDA6IjVhMmE2MWQ3YzVmNDFmNDVhM2FiOWIyM2I1YmE0ZjgzX2NvbHVtbnMiO2E6OTp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoia29kZSI7czo1OiJsYWJlbCI7czoxMToiS29kZSBCYXJhbmciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjc6ImJhcmNvZGUiO3M6NToibGFiZWwiO3M6MTQ6IkJhcmNvZGUgQmFyYW5nIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjExOiJOYW1hIEJhcmFuZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImplbmlzLm5hbWEiO3M6NToibGFiZWwiO3M6NToiSmVuaXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJrYXRlZ29yaS5uYW1hIjtzOjU6ImxhYmVsIjtzOjg6IkthdGVnb3JpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoibWVyZWsubmFtYSI7czo1OiJsYWJlbCI7czo1OiJNZXJlayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6InBhYnJpa2FuLm5hbWEiO3M6NToibGFiZWwiO3M6ODoiUGFicmlrYW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJzYXR1YW4ubmFtYSI7czo1OiJsYWJlbCI7czoxNToiU2F0dWFuIFRlcmtlY2lsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiI0MDgzODBlZTljNjg4NThkMmYwODdlYjYyODlkMjQ1Y19jb2x1bW5zIjthOjI6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyOiJubyI7czo1OiJsYWJlbCI7czozOiJOby4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6NToiSmVuaXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjI1ODQ0YzZlZmQ0MTRjNjdjYzQ1NWZjZDYwYzE1ZDhlX2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czo4OiJLYXRlZ29yaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MToiNWEyYTYxZDdjNWY0MWY0NWEzYWI5YjIzYjViYTRmODNfcGVyX3BhZ2UiO3M6MjoiMjUiO3M6NDA6IjNhOWM3NTQ4NjQ0Mjk4ZmYwNmFhYjljZmYxZDYwNDU0X2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czo1OiJNZXJlayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiMTllMzY5NTcwNzczYzE0MzAwYTI5OTNhZGJlNDJlMGFfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjEzOiJOYW1hIFBhYnJpa2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiI5ZGQ2MjBkZmQ0YWU4ZmI3Y2U4ZTAwNjg1NWFjYWViZl9jb2x1bW5zIjthOjI6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyOiJubyI7czo1OiJsYWJlbCI7czozOiJOby4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6MTE6Ik5hbWEgU2F0dWFuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX19czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1762422119),
	('J23oi5l2Bd9He7FP0EE7TIeRj5ccrd8rnbv3xylW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiemZCd2FzeWI3ZFJ6TDc1eFhuUzdGOWNQcUpjdHFDeGhsTzJibFFrNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL21hc3Rlci9iYXJhbmdzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoyNToiZmlsYW1lbnQuYWRtaW4uYXV0aC5sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762415646),
	('sAAsGdDIWwn044gTgmIwoq6rl7h7LUE37En6YpQG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoieTZEYWE5N1pTNFhIOFZOYzNqV0NSU0ZsSzRLSmdBVlB1c0JyaElkMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYXN0ZXIvYmFyYW5ncyI7czo1OiJyb3V0ZSI7czo0NToiZmlsYW1lbnQuYWRtaW4ubWFzdGVyLnJlc291cmNlcy5iYXJhbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJENqU1FiekRMcWpFY0FrREp3VGQxSmVTLzBkM3NBaE54WHllNXpkbVUuMDVTZlhlcXB2RkNTIjtzOjY6InRhYmxlcyI7YTo2OntzOjQwOiI1YTJhNjFkN2M1ZjQxZjQ1YTNhYjliMjNiNWJhNGY4M19jb2x1bW5zIjthOjk6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyOiJubyI7czo1OiJsYWJlbCI7czozOiJOby4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6ImtvZGUiO3M6NToibGFiZWwiO3M6MTE6IktvZGUgQmFyYW5nIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo3OiJiYXJjb2RlIjtzOjU6ImxhYmVsIjtzOjE0OiJCYXJjb2RlIEJhcmFuZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czoxMToiTmFtYSBCYXJhbmciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJqZW5pcy5uYW1hIjtzOjU6ImxhYmVsIjtzOjU6IkplbmlzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMzoia2F0ZWdvcmkubmFtYSI7czo1OiJsYWJlbCI7czo4OiJLYXRlZ29yaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6Im1lcmVrLm5hbWEiO3M6NToibGFiZWwiO3M6NToiTWVyZWsiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJwYWJyaWthbi5uYW1hIjtzOjU6ImxhYmVsIjtzOjg6IlBhYnJpa2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6ODthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToic2F0dWFuLm5hbWEiO3M6NToibGFiZWwiO3M6MTU6IlNhdHVhbiBUZXJrZWNpbCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiNDA4MzgwZWU5YzY4ODU4ZDJmMDg3ZWI2Mjg5ZDI0NWNfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjU6IkplbmlzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiIyNTg0NGM2ZWZkNDE0YzY3Y2M0NTVmY2Q2MGMxNWQ4ZV9jb2x1bW5zIjthOjI6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyOiJubyI7czo1OiJsYWJlbCI7czozOiJOby4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6ODoiS2F0ZWdvcmkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjNhOWM3NTQ4NjQ0Mjk4ZmYwNmFhYjljZmYxZDYwNDU0X2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czo1OiJNZXJlayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiOWRkNjIwZGZkNGFlOGZiN2NlOGUwMDY4NTVhY2FlYmZfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjExOiJOYW1hIFNhdHVhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiMTllMzY5NTcwNzczYzE0MzAwYTI5OTNhZGJlNDJlMGFfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjEzOiJOYW1hIFBhYnJpa2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX19czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1762419728),
	('T89m2dgBGRfbSSoAemn1Zz5wrldQfjTnl9iZJESt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiTVNMUzNBdmtlQW4xb2p4S0pMYXUxcWRqMXY4ZWROSGRMZEhIZ09kYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYXN0ZXIvYmFyYW5ncyI7czo1OiJyb3V0ZSI7czo0NToiZmlsYW1lbnQuYWRtaW4ubWFzdGVyLnJlc291cmNlcy5iYXJhbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRDalNRYnpETHFqRWNBa0RKd1RkMUplUy8wZDNzQWhOeFh5ZTV6ZG1VLjA1U2ZYZXFwdkZDUyI7czo2OiJ0YWJsZXMiO2E6NTp7czo0MDoiNDA4MzgwZWU5YzY4ODU4ZDJmMDg3ZWI2Mjg5ZDI0NWNfY29sdW1ucyI7YToyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjU6IkplbmlzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiIyNTg0NGM2ZWZkNDE0YzY3Y2M0NTVmY2Q2MGMxNWQ4ZV9jb2x1bW5zIjthOjI6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyOiJubyI7czo1OiJsYWJlbCI7czozOiJOby4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6ODoiS2F0ZWdvcmkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjlkZDYyMGRmZDRhZThmYjdjZThlMDA2ODU1YWNhZWJmX2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czoxMToiTmFtYSBTYXR1YW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjNhOWM3NTQ4NjQ0Mjk4ZmYwNmFhYjljZmYxZDYwNDU0X2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6Im5vIjtzOjU6ImxhYmVsIjtzOjM6Ik5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czo1OiJNZXJlayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiNWEyYTYxZDdjNWY0MWY0NWEzYWI5YjIzYjViYTRmODNfY29sdW1ucyI7YTo4OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjoibm8iO3M6NToibGFiZWwiO3M6MzoiTm8uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJrb2RlIjtzOjU6ImxhYmVsIjtzOjExOiJLb2RlIEJhcmFuZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NzoiYmFyY29kZSI7czo1OiJsYWJlbCI7czoxNDoiQmFyY29kZSBCYXJhbmciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6MTE6Ik5hbWEgQmFyYW5nIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiamVuaXMubmFtYSI7czo1OiJsYWJlbCI7czo1OiJKZW5pcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6ImthdGVnb3JpLm5hbWEiO3M6NToibGFiZWwiO3M6ODoiS2F0ZWdvcmkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJtZXJlay5uYW1hIjtzOjU6ImxhYmVsIjtzOjU6Ik1lcmVrIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToic2F0dWFuLm5hbWEiO3M6NToibGFiZWwiO3M6MTU6IlNhdHVhbiBUZXJrZWNpbCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319fXM6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1762415598);

-- Dumping structure for table apotekpos.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
