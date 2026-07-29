-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260707.3e756d69dd
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2026 at 06:35 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `officejohen`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_tokens`
--

CREATE TABLE `api_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `token` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aset_daya`
--

CREATE TABLE `aset_daya` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_aset` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daya` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggung_jawab` bigint UNSIGNED DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aset_mes`
--

CREATE TABLE `aset_mes` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `penanggung_jawab` bigint UNSIGNED DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aset_ruko`
--

CREATE TABLE `aset_ruko` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int UNSIGNED NOT NULL DEFAULT '1',
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aset_tim`
--

CREATE TABLE `aset_tim` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `penanggung_jawab` bigint UNSIGNED DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `expire_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `name`, `description`, `quantity`, `is_active`, `expire_date`, `created_at`, `updated_at`) VALUES
(1, 'TV', NULL, 2, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(2, 'Speaker', NULL, 2, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(3, 'Proyektor', NULL, 2, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(4, 'Whiteboard', NULL, 2, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(5, 'Laptop', NULL, 2, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(6, 'Kamera', NULL, 2, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-tagihan_check_1', 'b:1;', 1783937346),
('laravel-cache-tagihan_check_4', 'b:1;', 1783937292);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `digital_assets`
--

CREATE TABLE `digital_assets` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mulai` date NOT NULL,
  `berakhir` date NOT NULL,
  `biaya` decimal(15,2) NOT NULL DEFAULT '0.00',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `electricity_token_readings`
--

CREATE TABLE `electricity_token_readings` (
  `id` bigint UNSIGNED NOT NULL,
  `remaining_kwh` decimal(10,2) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked_date` date NOT NULL,
  `checked_by` bigint UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internet_usage_checks`
--

CREATE TABLE `internet_usage_checks` (
  `id` bigint UNSIGNED NOT NULL,
  `ruangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `penggunaan_wifi` decimal(10,2) NOT NULL DEFAULT '0.00',
  `penggunaan_ethernet` decimal(10,2) NOT NULL DEFAULT '0.00',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `checked_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `requested_by` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL,
  `why` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `what` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meeting_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `actual_end_time` time DEFAULT NULL,
  `how_expected` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected','confirmed','cancelled','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `queue_position` int UNSIGNED DEFAULT NULL COMMENT 'null = tidak antri, 0 = sedang berlangsung, 1,2,3... = antrian ke-n',
  `reject_reason` text COLLATE utf8mb4_unicode_ci,
  `is_weekly` tinyint(1) NOT NULL DEFAULT '0',
  `weekly_day` tinyint DEFAULT NULL COMMENT '0=Sunday, 1=Monday, ..., 6=Saturday',
  `weekly_time` time DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_assets`
--

CREATE TABLE `meeting_assets` (
  `id` bigint UNSIGNED NOT NULL,
  `meeting_id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_invitations`
--

CREATE TABLE `meeting_invitations` (
  `id` bigint UNSIGNED NOT NULL,
  `meeting_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_override_requests`
--

CREATE TABLE `meeting_override_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `requester_meeting_id` bigint UNSIGNED NOT NULL,
  `target_meeting_id` bigint UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_participants`
--

CREATE TABLE `meeting_participants` (
  `id` bigint UNSIGNED NOT NULL,
  `meeting_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('invited','confirmed','attended','absent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'invited',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_reminders`
--

CREATE TABLE `meeting_reminders` (
  `id` bigint UNSIGNED NOT NULL,
  `meeting_id` bigint UNSIGNED NOT NULL,
  `type` enum('h1_day','h1_hour') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_teams`
--

CREATE TABLE `meeting_teams` (
  `id` bigint UNSIGNED NOT NULL,
  `meeting_id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_01_000002_create_teams_rooms_assets_table', 1),
(5, '2026_01_01_000003_create_meetings_table', 1),
(6, '2026_01_01_000004_add_file_and_invitations', 1),
(7, '2026_01_01_000005_create_meeting_teams_table', 1),
(8, '2026_01_01_000006_create_weekly_meeting_sessions_table', 1),
(9, '2026_01_01_000007_add_queue_to_meetings_table', 1),
(10, '2026_01_01_000008_add_avatar_to_users_table', 1),
(11, '2026_05_18_162207_create_notifications_table', 1),
(12, '2026_05_18_171129_create_push_subscriptions_table', 1),
(13, '2026_05_19_141433_create_meeting_override_requests_table', 1),
(14, '2026_06_15_112356_add_ceo_role_to_users_table', 1),
(15, '2026_06_20_000001_add_expire_date_to_assets_table', 1),
(16, '2026_06_23_000001_create_vehicles_table', 1),
(17, '2026_06_23_000002_create_digital_assets_table', 1),
(18, '2026_06_23_000003_create_sim_cards_table', 1),
(19, '2026_06_23_000004_create_peralatan_kantor_table', 1),
(20, '2026_06_23_000005_create_aset_ruko_table', 1),
(21, '2026_06_23_110801_create_payments_table', 1),
(22, '2026_06_23_111647_create_wifi_payments_table', 1),
(23, '2026_06_23_112341_recreate_payments_table', 1),
(24, '2026_06_23_113217_create_wifi_payments_table', 1),
(25, '2026_06_23_174040_add_new_columns_to_vehicles_table', 1),
(26, '2026_06_24_000001_create_electricity_token_readings_table', 1),
(27, '2026_06_24_000002_add_status_to_electricity_token_readings_table', 1),
(28, '2026_06_24_000003_create_token_payments_table', 1),
(29, '2026_06_24_152809_add_jenis_to_payments_table', 1),
(30, '2026_06_25_162147_create_pembayaran_aset_digital_table', 1),
(31, '2026_06_25_162152_create_pembayaran_ipl_ruko_table', 1),
(32, '2026_06_25_162157_migrate_payment_data_to_new_tables', 1),
(33, '2026_06_25_163354_add_settings_to_users_table', 1),
(34, '2026_06_27_000001_create_vehicle_pajak_requests_table', 1),
(35, '2026_06_27_000002_add_email_to_users_table', 1),
(36, '2026_06_27_115001_add_digital_asset_id_to_pembayaran_aset_digital_table', 1),
(37, '2026_06_28_000001_create_messages_table', 1),
(38, '2026_06_28_105200_add_approval_to_payments_tables', 1),
(39, '2026_06_28_114000_add_performance_indexes', 1),
(40, '2026_06_28_210736_add_pic_jabatan_to_payment_tables', 1),
(41, '2026_06_29_143910_add_nominal_to_token_payments_table', 1),
(42, '2026_06_30_000001_create_sosial_media_table', 1),
(43, '2026_06_30_000002_create_internet_usage_checks_table', 1),
(44, '2026_07_01_085102_add_admin_ga_role_to_users_table', 1),
(45, '2026_07_05_000001_add_period_to_payment_tables', 1),
(46, '2026_07_07_100709_create_aset_daya_table', 1),
(47, '2026_07_07_100709_create_aset_tim_table', 1),
(48, '2026_07_07_100710_create_pembayaran_aset_daya_table', 1),
(49, '2026_07_07_100710_create_pembayaran_aset_tim_table', 1),
(50, '2026_07_07_100711_add_jenis_aset_to_aset_daya_table', 1),
(51, '2026_07_08_000001_create_api_tokens_table', 1),
(52, '2026_07_08_000002_increase_nominal_in_vehicle_pajak_requests', 1),
(53, '2026_07_08_000003_create_aset_mes_table', 1),
(54, '2026_07_08_000004_create_pembayaran_aset_mes_table', 1),
(55, '2026_07_08_000005_drop_merk_from_aset_mes_table', 1),
(56, '2026_07_09_000001_add_status_to_sosial_media_table', 1),
(57, '2026_07_10_000001_add_kode_aset_and_barcode_to_peralatan_kantor_table', 1),
(58, '2026_07_12_151753_drop_payments_table', 2),
(59, '2026_07_12_200952_add_foto_to_peralatan_kantor_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `moms`
--

CREATE TABLE `moms` (
  `id` bigint UNSIGNED NOT NULL,
  `meeting_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `decisions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_plan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Penanggung jawab',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','sent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dedup_key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `url`, `dedup_key`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'meeting', 'Meeting Mingguan Dimulai 🔁', 'Weekly Meeting di Meeting Room Utama sudah dimulai! [weekly_start_1]', 'http://127.0.0.1:8000/weekly-undangan', NULL, 0, NULL, '2026-07-13 06:00:10', '2026-07-13 06:00:10'),
(2, 4, 'meeting', 'Meeting Mingguan Dimulai 🔁', 'Weekly Meeting di Meeting Room Utama sudah dimulai! [weekly_start_1]', 'http://127.0.0.1:8000/weekly-undangan', NULL, 0, NULL, '2026-07-13 06:00:11', '2026-07-13 06:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_aset_daya`
--

CREATE TABLE `pembayaran_aset_daya` (
  `id` bigint UNSIGNED NOT NULL,
  `aset_daya_id` bigint UNSIGNED DEFAULT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','jatuh_tempo','lunas','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` date DEFAULT NULL,
  `requested_by` bigint UNSIGNED DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_aset_digital`
--

CREATE TABLE `pembayaran_aset_digital` (
  `id` bigint UNSIGNED NOT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jatuh_tempo',
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `digital_asset_id` bigint UNSIGNED DEFAULT NULL,
  `requested_by` bigint UNSIGNED DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_aset_mes`
--

CREATE TABLE `pembayaran_aset_mes` (
  `id` bigint UNSIGNED NOT NULL,
  `aset_mes_id` bigint UNSIGNED DEFAULT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','jatuh_tempo','lunas','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` date DEFAULT NULL,
  `requested_by` bigint UNSIGNED DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_aset_tim`
--

CREATE TABLE `pembayaran_aset_tim` (
  `id` bigint UNSIGNED NOT NULL,
  `aset_tim_id` bigint UNSIGNED DEFAULT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','jatuh_tempo','lunas','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` date DEFAULT NULL,
  `requested_by` bigint UNSIGNED DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_ipl_ruko`
--

CREATE TABLE `pembayaran_ipl_ruko` (
  `id` bigint UNSIGNED NOT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jatuh_tempo',
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `requested_by` bigint UNSIGNED DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peralatan_kantor`
--

CREATE TABLE `peralatan_kantor` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int UNSIGNED NOT NULL DEFAULT '1',
  `detail` text COLLATE utf8mb4_unicode_ci,
  `sub_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Peralatan Kantor',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `lokasi_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `milik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Milik Perusahaan',
  `pengadaan_tahun` year NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `kategori_nilai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rendah',
  `kategori_ukuran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kecil',
  `nilai` decimal(15,2) NOT NULL DEFAULT '0.00',
  `waktu_pakai_per_hari` int NOT NULL DEFAULT '2',
  `estimasi_waktu_barang` int NOT NULL DEFAULT '2',
  `pengurangan_harga_per_hari` decimal(15,2) NOT NULL DEFAULT '0.00',
  `harga_per_hari_ini` decimal(15,2) NOT NULL DEFAULT '0.00',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atasan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_atasan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peralatan_kantor`
--

INSERT INTO `peralatan_kantor` (`id`, `kode_aset`, `barcode`, `foto`, `nama_barang`, `jumlah`, `detail`, `sub_kategori`, `keterangan`, `lokasi_unit`, `ruangan`, `milik`, `pengadaan_tahun`, `tanggal_pembelian`, `kategori_nilai`, `kategori_ukuran`, `nilai`, `waktu_pakai_per_hari`, `estimasi_waktu_barang`, `pengurangan_harga_per_hari`, `harga_per_hari_ini`, `pic`, `jabatan`, `atasan`, `jabatan_atasan`, `kondisi`, `created_at`, `updated_at`) VALUES
(1, 'PK-2026-0001', 'PK-2026-0001', 'peralatan-kantor/wZhXW6aC3Cgxqb6n6yeUfBqwcKeeH4qC1ckpbIEt.jpg', '242', 424, '3232', 'Peralatan Kantor', '3232', '1', 'Ruang IT', 'Sewa', '2025', '2026-07-13', 'Rendah', 'Kecil', 2000.00, 2, 2, 1000.00, 1657.60, 'Admin Master', 'Koordinator', 'RInaldo', 'Head of Store', 'baik', '2026-07-13 01:13:03', '2026-07-13 01:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `endpoint` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p256dh` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int UNSIGNED NOT NULL DEFAULT '50',
  `facilities` json DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `capacity`, `facilities`, `location`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Meeting Room Utama', 50, '[\"Proyektor\", \"TV\", \"Speaker\", \"Whiteboard\", \"AC\"]', 'Lantai 1', 'Ruang meeting utama Johen Gaming', 1, '2026-07-11 04:15:35', '2026-07-11 04:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0EZcBdcjVn9vP4PnQdWd1DrudwSPx7OBFZHUI2df', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJYcHVLWU1JdktGVHdzUWtiMUJ5MG04SFlUOEp1MjNNOXhwajBCVmttIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3JlYWx0aW1lXC9ub3RpZiIsInJvdXRlIjoicmVhbHRpbWUubm90aWYifSwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3JlYWx0aW1lXC9ub3RpZiJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NH0=', 1783937052),
('49lCiCPjAYgiv4rEnIGobD9cVHc9ZcI2F9qjoyMF', NULL, '127.0.0.1', 'curl/8.19.0', 'eyJfdG9rZW4iOiJad04zQ0hkNml5UlZsNmhMdjhtZEJjbWRwblZaaHpGWXc5enlUWHJIIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9kYXNoYm9hcmQifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJhZG1pbi5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783932537),
('aLrYYwbyCsCDntTceFbNjpfgM17QtlSSlodMrrAx', NULL, '127.0.0.1', 'curl/8.19.0', 'eyJfdG9rZW4iOiJlU0lDVHRxMnhMNzRWZllMS3ZnUHlMRWcyNVg3R2Z0UEE5VTF6NUE1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783932617),
('CbGU5zkNjs5bw51MsCP6kNU32NbrKR7vp6PTpZ0M', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.8655', 'eyJfdG9rZW4iOiJvMXNvMTI2d3Q4Z29nZ0Izd2JodzkzcVVoTkNOZ3J6SXJYQ3lDQXU0IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9kYXNoYm9hcmQifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783932310),
('Dk5QEEY3Nq4J2JsvAVOoTF59dYF4dnTdBghdj84j', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.8655', 'eyJfdG9rZW4iOiJtN2lSMDN2RjhndXh2SGxRbDhQNGY4NWE5YzloMFZmSUtuTkpvTERQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJhZG1pbi5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJ1cmwiOnsiaW50ZW5kZWQiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYWRtaW5cL2Rhc2hib2FyZCJ9fQ==', 1783932359),
('fCdku3Mz468BxCb7IJHs2abt3E2aK1hOB5Rl6FTU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.8655', 'eyJfdG9rZW4iOiJjZHpkbGdib3JPOUcyUlR3bjRlSjdNSEw4bHNyWTJlejVOY1JsOUZyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783932337),
('Gz3caa7S55DVP9xe8bhOBRYo7wEx6r5ygx61Rl5V', NULL, '127.0.0.1', 'curl/8.19.0', 'eyJfdG9rZW4iOiJLRXRNbjRZb0xRcGQ0UjdDdFZsbDF1Q2I2T2tzWFg4cFJmckpGcllJIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783932618),
('isLbRC519Q73KkRWRJqL6KGkaZXiGTgXUPvLzxfi', NULL, '127.0.0.1', 'curl/8.19.0', 'eyJfdG9rZW4iOiJvTEQ2MUNMclJZa25nQmcwdmNKcmxOQ1FPYXNEMEFLUldTSkloQTlyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783932537),
('lr76JTyx8UG1r7DwKMGqzSrckTYmqP0RalHAZWPB', NULL, '127.0.0.1', 'curl/8.19.0', 'eyJfdG9rZW4iOiJoU1lXeGJDS2lQYzlBY1NVVUhTTEdHUmJjRzVaUFpsYTNxdzFrVGg1IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9kYXNoYm9hcmQifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJhZG1pbi5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783932528),
('NDuMahJnRnSCDp9Bs0RbrKsEUbeH3wxwo1gpe7xd', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ5SGE4YU9wdnRScFlwTFYxRGY0cm5WOXZUOUpWRXhlNkFMdUMzUjg3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9yZWFsdGltZVwvZGFzaGJvYXJkIiwicm91dGUiOiJyZWFsdGltZS5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1783937045),
('qZ0bsCRBQ4v7Mm7Wds4CWBlyS8hP53Z5qh8lbDxC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.8655', 'eyJfdG9rZW4iOiI3ZEVVRFI2QmJOTFpaaE02NnBYTlRCeTdOMmlrZnV2WlBYNDdmZGVVIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9kYXNoYm9hcmQifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783932468),
('YGH0C8cMUjmgy5BDUF5sBTJQuQYKskTrND81TT0X', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.128.0 Chrome/148.0.7778.271 Electron/42.5.0 Safari/537.36', 'eyJfdG9rZW4iOiJidm5WZVk0MXh5VjhDMlk3UVI2MGVTQXV0SWRLMGJlSnhYQ0d4Slh5IiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9yZWFsdGltZVwvZGFzaGJvYXJkIiwicm91dGUiOiJyZWFsdGltZS5kYXNoYm9hcmQifX0=', 1783937046);

-- --------------------------------------------------------

--
-- Table structure for table `sim_cards`
--

CREATE TABLE `sim_cards` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_sim_card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `masa_aktif` date NOT NULL,
  `masa_tenggang` date NOT NULL,
  `status_paket_kuota` tinyint(1) NOT NULL DEFAULT '1',
  `status_kartu` tinyint(1) NOT NULL DEFAULT '1',
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sosial_media`
--

CREATE TABLE `sosial_media` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `followers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Tim Konten', 'Tim yang mengelola konten', 1, '2026-07-11 04:15:32', '2026-07-11 04:15:32'),
(2, 'Tim Host Live', 'Tim yang mengelola live streaming', 1, '2026-07-11 04:15:33', '2026-07-11 04:15:33'),
(3, 'Tim Marketing', 'Tim yang mengelola pemasaran', 1, '2026-07-11 04:15:33', '2026-07-11 04:15:33'),
(4, 'Tim Operasional', 'Tim yang mengelola operasional', 1, '2026-07-11 04:15:33', '2026-07-11 04:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `token_payments`
--

CREATE TABLE `token_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `amount_kwh` decimal(10,2) NOT NULL,
  `nominal` decimal(15,2) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `period` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','koordinator','head_of_store','gm','hr','user','ceo','admin_ga') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `team_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `app_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `avatar`, `password`, `role`, `team_id`, `is_active`, `theme`, `email_notifications`, `app_notifications`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Master', 'admin', 'admin@johen.com', NULL, '$2y$12$QeZUwQ9I7hXebTm9ippRS.gI2qrMdxc6aGbxpuYnLcmfUnKYVZVTW', 'admin', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:33', '2026-07-11 04:15:33'),
(2, 'Head of Store', 'headstore', 'headstore@johen.com', NULL, '$2y$12$FBmFkrKqMM/nPpJcZ.scz.20MqZqbuFmLWas16vU6d9sQa83tZJze', 'head_of_store', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:33', '2026-07-11 04:15:33'),
(3, 'General Manager', 'gm', 'gm@johen.com', NULL, '$2y$12$/5QRpmE/Ez7aYPjF2HBWBOjAa0oamQBBA593y5OZdvpuOMBAE5d0q', 'gm', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:33', '2026-07-11 04:15:33'),
(4, 'HR Manager', 'hr', 'hr@johen.com', NULL, '$2y$12$KDC11Jou0guIGYqZhNrcqOt6zWlDiDxjPwAG3pen83xLpQqt4i8eO', 'hr', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:33', '2026-07-11 04:15:33'),
(5, 'Chief Executive Officer', 'ceo', 'ceo@johen.com', NULL, '$2y$12$cZohdBCKfy0hFUod2UWJ/ucFZXjpCYO4.KkvPRkDTP96d9Kemy.He', 'ceo', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:33', '2026-07-11 04:15:33'),
(6, 'Admin General Affairs', 'admin_ga', 'admin_ga@johen.com', NULL, '$2y$12$I4Ei6v2Ges37tK4dYVF9oeUXK7KmmQ8pIbCYk4/pSxvOw9IeRcSIe', 'admin_ga', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:34', '2026-07-11 04:15:34'),
(7, 'Koordinator Konten', 'koordinator1', 'koordinator1@johen.com', NULL, '$2y$12$6YBDp9/sk/H0oKIHMES57.PrliOdcRvLc1ZeP6neWkKK2YyE5u/8G', 'koordinator', 1, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:34', '2026-07-11 04:15:34'),
(8, 'Koordinator Johen.roblox', 'Johen.roblox', 'johen.roblox@johen.com', NULL, '$2y$12$I3ItzezgycQNOutcFg0JeOaCLM5d2Atf5v5tfe7BzbrcpPM6shfze', 'koordinator', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:34', '2026-07-11 04:15:34'),
(9, 'Koordinator Johen.PUBG', 'Johen.PUBG', 'johen.pubg@johen.com', NULL, '$2y$12$fg8g50YGsvnLvM.YsJ/jH.czo9mUO9xAiiN2r/DmXCPlfoGrFrfKa', 'koordinator', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:34', '2026-07-11 04:15:34'),
(10, 'Koordinator Johen.MLBB', 'Johen.MLBB', 'johen.mlbb@johen.com', NULL, '$2y$12$IzHohuxe5WMk68O0Guw2i.tMEzJunzOgHbggVhgPiMlhhXO/wY6me', 'koordinator', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:34', '2026-07-11 04:15:34'),
(11, 'Koordinator Johen.Free Fire', 'Johen.FreeFire', 'johen.freefire@johen.com', NULL, '$2y$12$7wVDoneT9biYQ5ppOwjS0.0dH5oHXt8AY0WiV4oPiKCzumGlZju/i', 'koordinator', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(12, 'Koordinator Johen.E-Footbal', 'Johen.EFootbal', 'johen.efootbal@johen.com', NULL, '$2y$12$haCl2mFKGcam15pM7o3Y4ucTeg2jEBV5r5VzgWhL/KcWjL2LDv.wm', 'koordinator', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(13, 'Koordinator Creatif', 'creatif', 'creatif@johen.com', NULL, '$2y$12$p4xIjzDP08mtVLzQE5Wq6.XmvHa2rt0MRZ/6GmWwIYMJnYHw32q.u', 'koordinator', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(14, 'Koordinator IT', 'it', 'it@johen.com', NULL, '$2y$12$Rk2J0poXu2VgviqoQ8cJb.ymdtG.eTCNRjDoYdC6csnF9NAGKATE.', 'koordinator', NULL, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35'),
(15, 'Karyawan Konten', 'user1', 'user1@johen.com', NULL, '$2y$12$8n/H5Wm6o2MPw4r5vvdeTOqh8il6CUeXEgkqcuZiv9uT1ZnWYYIgS', 'user', 1, 1, NULL, 1, 1, NULL, '2026-07-11 04:15:35', '2026-07-11 04:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk_tipe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plat_nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `warna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_rangka` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_mesin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pajak_tahunan` date NOT NULL,
  `pajak_5_tahun` date NOT NULL,
  `kepemilikan_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Milik Perusahaan',
  `biaya_kendaraan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_pajak_requests`
--

CREATE TABLE `vehicle_pajak_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `requested_by` bigint UNSIGNED NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` decimal(20,2) NOT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_meetings`
--

CREATE TABLE `weekly_meetings` (
  `id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Weekly Meeting',
  `day_of_week` tinyint NOT NULL COMMENT '1=Monday, ..., 7=Sunday',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekly_meetings`
--

INSERT INTO `weekly_meetings` (`id`, `room_id`, `title`, `day_of_week`, `start_time`, `end_time`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Weekly Meeting', 1, '13:00:00', '15:00:00', 1, 1, '2026-07-11 04:15:35', '2026-07-11 04:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_meeting_contributions`
--

CREATE TABLE `weekly_meeting_contributions` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `what_to_discuss` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_meeting_invitations`
--

CREATE TABLE `weekly_meeting_invitations` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekly_meeting_invitations`
--

INSERT INTO `weekly_meeting_invitations` (`id`, `session_id`, `user_id`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(2, 1, 2, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(3, 1, 3, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(4, 1, 4, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(5, 1, 5, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(6, 1, 6, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(7, 1, 7, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(8, 1, 8, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(9, 1, 9, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(10, 1, 10, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(11, 1, 11, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(12, 1, 12, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(13, 1, 13, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(14, 1, 14, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26'),
(15, 1, 15, 0, NULL, '2026-07-13 01:07:26', '2026-07-13 01:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_meeting_sessions`
--

CREATE TABLE `weekly_meeting_sessions` (
  `id` bigint UNSIGNED NOT NULL,
  `weekly_meeting_id` bigint UNSIGNED NOT NULL,
  `session_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `actual_end_time` time DEFAULT NULL,
  `status` enum('active','extended','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekly_meeting_sessions`
--

INSERT INTO `weekly_meeting_sessions` (`id`, `weekly_meeting_id`, `session_date`, `start_time`, `end_time`, `actual_end_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-07-13', '13:00:00', '15:00:00', NULL, 'active', '2026-07-13 01:07:26', '2026-07-13 01:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `wifi_payments`
--

CREATE TABLE `wifi_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_internet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `masa_tenggang` date NOT NULL,
  `biaya` decimal(15,2) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jatuh_tempo',
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `requested_by` bigint UNSIGNED DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_tokens`
--
ALTER TABLE `api_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_tokens_token_unique` (`token`),
  ADD KEY `api_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `aset_daya`
--
ALTER TABLE `aset_daya`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aset_daya_penanggung_jawab_foreign` (`penanggung_jawab`);

--
-- Indexes for table `aset_mes`
--
ALTER TABLE `aset_mes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aset_mes_penanggung_jawab_foreign` (`penanggung_jawab`);

--
-- Indexes for table `aset_ruko`
--
ALTER TABLE `aset_ruko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aset_tim`
--
ALTER TABLE `aset_tim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aset_tim_penanggung_jawab_foreign` (`penanggung_jawab`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `digital_assets`
--
ALTER TABLE `digital_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `electricity_token_readings`
--
ALTER TABLE `electricity_token_readings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `electricity_token_readings_checked_by_foreign` (`checked_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `internet_usage_checks`
--
ALTER TABLE `internet_usage_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internet_usage_checks_checked_by_foreign` (`checked_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meetings_room_id_foreign` (`room_id`),
  ADD KEY `meetings_requested_by_foreign` (`requested_by`),
  ADD KEY `meetings_team_id_foreign` (`team_id`),
  ADD KEY `meetings_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `meeting_assets`
--
ALTER TABLE `meeting_assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_assets_meeting_id_foreign` (`meeting_id`),
  ADD KEY `meeting_assets_asset_id_foreign` (`asset_id`);

--
-- Indexes for table `meeting_invitations`
--
ALTER TABLE `meeting_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meeting_invitations_meeting_id_user_id_unique` (`meeting_id`,`user_id`),
  ADD KEY `meeting_invitations_user_id_foreign` (`user_id`);

--
-- Indexes for table `meeting_override_requests`
--
ALTER TABLE `meeting_override_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_override_requests_requester_meeting_id_foreign` (`requester_meeting_id`),
  ADD KEY `meeting_override_requests_target_meeting_id_foreign` (`target_meeting_id`);

--
-- Indexes for table `meeting_participants`
--
ALTER TABLE `meeting_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meeting_participants_meeting_id_user_id_unique` (`meeting_id`,`user_id`),
  ADD KEY `meeting_participants_user_id_foreign` (`user_id`);

--
-- Indexes for table `meeting_reminders`
--
ALTER TABLE `meeting_reminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_reminders_meeting_id_foreign` (`meeting_id`);

--
-- Indexes for table `meeting_teams`
--
ALTER TABLE `meeting_teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meeting_teams_meeting_id_team_id_unique` (`meeting_id`,`team_id`),
  ADD KEY `meeting_teams_team_id_foreign` (`team_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moms`
--
ALTER TABLE `moms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `moms_meeting_id_unique` (`meeting_id`),
  ADD KEY `moms_created_by_foreign` (`created_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`),
  ADD KEY `notifications_dedup_key_user_id_index` (`dedup_key`,`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pembayaran_aset_daya`
--
ALTER TABLE `pembayaran_aset_daya`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_aset_daya_aset_daya_id_foreign` (`aset_daya_id`),
  ADD KEY `pembayaran_aset_daya_requested_by_foreign` (`requested_by`),
  ADD KEY `pembayaran_aset_daya_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `pembayaran_aset_digital`
--
ALTER TABLE `pembayaran_aset_digital`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_aset_digital_digital_asset_id_foreign` (`digital_asset_id`),
  ADD KEY `pembayaran_aset_digital_requested_by_foreign` (`requested_by`),
  ADD KEY `pembayaran_aset_digital_approved_by_foreign` (`approved_by`),
  ADD KEY `idx_aset_status_jatuh` (`status`,`jatuh_tempo`);

--
-- Indexes for table `pembayaran_aset_mes`
--
ALTER TABLE `pembayaran_aset_mes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_aset_mes_aset_mes_id_foreign` (`aset_mes_id`),
  ADD KEY `pembayaran_aset_mes_requested_by_foreign` (`requested_by`),
  ADD KEY `pembayaran_aset_mes_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `pembayaran_aset_tim`
--
ALTER TABLE `pembayaran_aset_tim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_aset_tim_aset_tim_id_foreign` (`aset_tim_id`),
  ADD KEY `pembayaran_aset_tim_requested_by_foreign` (`requested_by`),
  ADD KEY `pembayaran_aset_tim_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `pembayaran_ipl_ruko`
--
ALTER TABLE `pembayaran_ipl_ruko`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_ipl_ruko_requested_by_foreign` (`requested_by`),
  ADD KEY `pembayaran_ipl_ruko_approved_by_foreign` (`approved_by`),
  ADD KEY `idx_ipl_status_jatuh` (`status`,`jatuh_tempo`);

--
-- Indexes for table `peralatan_kantor`
--
ALTER TABLE `peralatan_kantor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peralatan_kantor_kode_aset_unique` (`kode_aset`),
  ADD UNIQUE KEY `peralatan_kantor_barcode_unique` (`barcode`);

--
-- Indexes for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_endpoint` (`user_id`,`endpoint`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sim_cards`
--
ALTER TABLE `sim_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sosial_media`
--
ALTER TABLE `sosial_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token_payments`
--
ALTER TABLE `token_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token_payments_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_team_id_foreign` (`team_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_plat_nomor_unique` (`plat_nomor`);

--
-- Indexes for table `vehicle_pajak_requests`
--
ALTER TABLE `vehicle_pajak_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_pajak_requests_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `vehicle_pajak_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `vehicle_pajak_requests_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `weekly_meetings`
--
ALTER TABLE `weekly_meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekly_meetings_room_id_foreign` (`room_id`),
  ADD KEY `weekly_meetings_created_by_foreign` (`created_by`);

--
-- Indexes for table `weekly_meeting_contributions`
--
ALTER TABLE `weekly_meeting_contributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekly_meeting_contributions_session_id_foreign` (`session_id`),
  ADD KEY `weekly_meeting_contributions_user_id_foreign` (`user_id`);

--
-- Indexes for table `weekly_meeting_invitations`
--
ALTER TABLE `weekly_meeting_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `weekly_meeting_invitations_session_id_user_id_unique` (`session_id`,`user_id`),
  ADD KEY `weekly_meeting_invitations_user_id_foreign` (`user_id`);

--
-- Indexes for table `weekly_meeting_sessions`
--
ALTER TABLE `weekly_meeting_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `weekly_meeting_sessions_weekly_meeting_id_session_date_unique` (`weekly_meeting_id`,`session_date`);

--
-- Indexes for table `wifi_payments`
--
ALTER TABLE `wifi_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wifi_payments_requested_by_foreign` (`requested_by`),
  ADD KEY `wifi_payments_approved_by_foreign` (`approved_by`),
  ADD KEY `idx_wifi_status_masa` (`status`,`masa_tenggang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_tokens`
--
ALTER TABLE `api_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aset_daya`
--
ALTER TABLE `aset_daya`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aset_mes`
--
ALTER TABLE `aset_mes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aset_ruko`
--
ALTER TABLE `aset_ruko`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aset_tim`
--
ALTER TABLE `aset_tim`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `digital_assets`
--
ALTER TABLE `digital_assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `electricity_token_readings`
--
ALTER TABLE `electricity_token_readings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internet_usage_checks`
--
ALTER TABLE `internet_usage_checks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_assets`
--
ALTER TABLE `meeting_assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_invitations`
--
ALTER TABLE `meeting_invitations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_override_requests`
--
ALTER TABLE `meeting_override_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_participants`
--
ALTER TABLE `meeting_participants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_reminders`
--
ALTER TABLE `meeting_reminders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_teams`
--
ALTER TABLE `meeting_teams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `moms`
--
ALTER TABLE `moms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran_aset_daya`
--
ALTER TABLE `pembayaran_aset_daya`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran_aset_digital`
--
ALTER TABLE `pembayaran_aset_digital`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran_aset_mes`
--
ALTER TABLE `pembayaran_aset_mes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran_aset_tim`
--
ALTER TABLE `pembayaran_aset_tim`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran_ipl_ruko`
--
ALTER TABLE `pembayaran_ipl_ruko`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peralatan_kantor`
--
ALTER TABLE `peralatan_kantor`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sim_cards`
--
ALTER TABLE `sim_cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sosial_media`
--
ALTER TABLE `sosial_media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `token_payments`
--
ALTER TABLE `token_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_pajak_requests`
--
ALTER TABLE `vehicle_pajak_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekly_meetings`
--
ALTER TABLE `weekly_meetings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `weekly_meeting_contributions`
--
ALTER TABLE `weekly_meeting_contributions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekly_meeting_invitations`
--
ALTER TABLE `weekly_meeting_invitations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `weekly_meeting_sessions`
--
ALTER TABLE `weekly_meeting_sessions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wifi_payments`
--
ALTER TABLE `wifi_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `api_tokens`
--
ALTER TABLE `api_tokens`
  ADD CONSTRAINT `api_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `aset_daya`
--
ALTER TABLE `aset_daya`
  ADD CONSTRAINT `aset_daya_penanggung_jawab_foreign` FOREIGN KEY (`penanggung_jawab`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `aset_mes`
--
ALTER TABLE `aset_mes`
  ADD CONSTRAINT `aset_mes_penanggung_jawab_foreign` FOREIGN KEY (`penanggung_jawab`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `aset_tim`
--
ALTER TABLE `aset_tim`
  ADD CONSTRAINT `aset_tim_penanggung_jawab_foreign` FOREIGN KEY (`penanggung_jawab`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `electricity_token_readings`
--
ALTER TABLE `electricity_token_readings`
  ADD CONSTRAINT `electricity_token_readings_checked_by_foreign` FOREIGN KEY (`checked_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `internet_usage_checks`
--
ALTER TABLE `internet_usage_checks`
  ADD CONSTRAINT `internet_usage_checks_checked_by_foreign` FOREIGN KEY (`checked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `meetings_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meetings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meetings_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meeting_assets`
--
ALTER TABLE `meeting_assets`
  ADD CONSTRAINT `meeting_assets_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_assets_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meeting_invitations`
--
ALTER TABLE `meeting_invitations`
  ADD CONSTRAINT `meeting_invitations_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meeting_override_requests`
--
ALTER TABLE `meeting_override_requests`
  ADD CONSTRAINT `meeting_override_requests_requester_meeting_id_foreign` FOREIGN KEY (`requester_meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_override_requests_target_meeting_id_foreign` FOREIGN KEY (`target_meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meeting_participants`
--
ALTER TABLE `meeting_participants`
  ADD CONSTRAINT `meeting_participants_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meeting_reminders`
--
ALTER TABLE `meeting_reminders`
  ADD CONSTRAINT `meeting_reminders_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meeting_teams`
--
ALTER TABLE `meeting_teams`
  ADD CONSTRAINT `meeting_teams_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `moms`
--
ALTER TABLE `moms`
  ADD CONSTRAINT `moms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `moms_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran_aset_daya`
--
ALTER TABLE `pembayaran_aset_daya`
  ADD CONSTRAINT `pembayaran_aset_daya_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_aset_daya_aset_daya_id_foreign` FOREIGN KEY (`aset_daya_id`) REFERENCES `aset_daya` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_aset_daya_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran_aset_digital`
--
ALTER TABLE `pembayaran_aset_digital`
  ADD CONSTRAINT `pembayaran_aset_digital_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_aset_digital_digital_asset_id_foreign` FOREIGN KEY (`digital_asset_id`) REFERENCES `digital_assets` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_aset_digital_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran_aset_mes`
--
ALTER TABLE `pembayaran_aset_mes`
  ADD CONSTRAINT `pembayaran_aset_mes_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_aset_mes_aset_mes_id_foreign` FOREIGN KEY (`aset_mes_id`) REFERENCES `aset_mes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_aset_mes_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran_aset_tim`
--
ALTER TABLE `pembayaran_aset_tim`
  ADD CONSTRAINT `pembayaran_aset_tim_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_aset_tim_aset_tim_id_foreign` FOREIGN KEY (`aset_tim_id`) REFERENCES `aset_tim` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_aset_tim_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran_ipl_ruko`
--
ALTER TABLE `pembayaran_ipl_ruko`
  ADD CONSTRAINT `pembayaran_ipl_ruko_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_ipl_ruko_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD CONSTRAINT `push_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `token_payments`
--
ALTER TABLE `token_payments`
  ADD CONSTRAINT `token_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vehicle_pajak_requests`
--
ALTER TABLE `vehicle_pajak_requests`
  ADD CONSTRAINT `vehicle_pajak_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehicle_pajak_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_pajak_requests_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weekly_meetings`
--
ALTER TABLE `weekly_meetings`
  ADD CONSTRAINT `weekly_meetings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `weekly_meetings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weekly_meeting_contributions`
--
ALTER TABLE `weekly_meeting_contributions`
  ADD CONSTRAINT `weekly_meeting_contributions_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `weekly_meeting_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `weekly_meeting_contributions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weekly_meeting_invitations`
--
ALTER TABLE `weekly_meeting_invitations`
  ADD CONSTRAINT `weekly_meeting_invitations_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `weekly_meeting_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `weekly_meeting_invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weekly_meeting_sessions`
--
ALTER TABLE `weekly_meeting_sessions`
  ADD CONSTRAINT `weekly_meeting_sessions_weekly_meeting_id_foreign` FOREIGN KEY (`weekly_meeting_id`) REFERENCES `weekly_meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wifi_payments`
--
ALTER TABLE `wifi_payments`
  ADD CONSTRAINT `wifi_payments_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `wifi_payments_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
