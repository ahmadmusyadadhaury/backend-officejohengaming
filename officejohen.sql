-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: officejohen
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `officejohen`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `officejohen` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `officejohen`;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `activity_logs_model_model_id_index` (`model`,`model_id`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,16,'127.0.0.1','Chrome','ticket.created','Ticket TK-20260731-0001 dibuat','App\\Models\\Ticket',1,NULL,'{\"ticket_number\":\"TK-20260731-0001\",\"user_id\":16,\"category_id\":\"5\",\"title\":\"tesd\",\"description\":\"tes\",\"location\":\"Lantai 2\",\"department\":\"TIM IT\",\"position\":\"Koordinator\",\"priority\":\"medium\",\"status\":\"open\",\"sla_due_at\":\"2026-08-01T08:04:51.000000Z\",\"updated_at\":\"2026-07-31T08:04:51.000000Z\",\"created_at\":\"2026-07-31T08:04:51.000000Z\",\"id\":1}','2026-07-31 08:04:51'),(2,16,'127.0.0.1','Chrome','ticket.comment','Komentar pada TK-20260731-0001 oleh ahmad','App\\Models\\Ticket',1,NULL,NULL,'2026-07-31 08:05:05'),(3,1,'127.0.0.1','Chrome','ticket.comment','Komentar pada TK-20260731-0001 oleh Admin Master','App\\Models\\Ticket',1,NULL,NULL,'2026-08-03 04:00:15'),(4,22,'127.0.0.1','Chrome','ticket.created','Ticket TK-20260803-0001 dibuat','App\\Models\\Ticket',2,NULL,'{\"ticket_number\":\"TK-20260803-0001\",\"user_id\":22,\"category_id\":null,\"title\":\"dada\",\"description\":\"dadaaaadadad\",\"location\":null,\"department\":\"Johen PUBG\",\"position\":\"Karyawan\",\"priority\":\"low\",\"status\":\"open\",\"sla_due_at\":\"2026-08-06T04:33:15.000000Z\",\"updated_at\":\"2026-08-03T04:33:15.000000Z\",\"created_at\":\"2026-08-03T04:33:15.000000Z\",\"id\":2}','2026-08-03 04:33:16'),(5,22,'127.0.0.1','Chrome','ticket.comment','Komentar pada TK-20260803-0001 oleh jors','App\\Models\\Ticket',2,NULL,NULL,'2026-08-03 04:33:44'),(6,16,'127.0.0.1','Chrome','ticket.taken','Ticket TK-20260803-0001 diambil oleh ahmad','App\\Models\\Ticket',2,'open','assigned','2026-08-03 04:34:30'),(7,16,'127.0.0.1','Chrome','ticket.status','Status TK-20260803-0001 berubah','App\\Models\\Ticket',2,'assigned','in_progress','2026-08-03 04:34:47'),(8,16,'127.0.0.1','Chrome','ticket.status','Status TK-20260803-0001 berubah','App\\Models\\Ticket',2,'in_progress','resolved','2026-08-03 04:35:03'),(9,16,'127.0.0.1','Chrome','ticket.status','Status TK-20260803-0001 berubah','App\\Models\\Ticket',2,'resolved','reopened','2026-08-03 04:35:13'),(10,16,'127.0.0.1','Chrome','ticket.resolved','Ticket TK-20260803-0001 diselesaikan','App\\Models\\Ticket',2,'reopened','resolved','2026-08-03 04:35:17'),(11,22,'127.0.0.1','Chrome','ticket.closed','Ticket TK-20260803-0001 ditutup','App\\Models\\Ticket',2,'resolved','closed','2026-08-03 04:35:53'),(12,22,'127.0.0.1','Chrome','ticket.rated','Ticket TK-20260803-0001 diberi rating 5','App\\Models\\Ticket',2,NULL,'5','2026-08-03 04:35:59'),(13,22,'127.0.0.1','Chrome','ticket.created','Ticket TK-20260803-0002 dibuat','App\\Models\\Ticket',3,NULL,'{\"ticket_number\":\"TK-20260803-0002\",\"user_id\":22,\"category_id\":\"10\",\"title\":\"tes\",\"description\":\"tes\",\"location\":null,\"department\":\"Johen PUBG\",\"position\":\"Karyawan\",\"priority\":\"medium\",\"status\":\"open\",\"sla_due_at\":\"2026-08-04T04:49:51.000000Z\",\"updated_at\":\"2026-08-03T04:49:51.000000Z\",\"created_at\":\"2026-08-03T04:49:51.000000Z\",\"id\":3}','2026-08-03 04:49:51'),(14,22,'127.0.0.1','Chrome','ticket.reopened','Ticket TK-20260803-0001 dibuka kembali','App\\Models\\Ticket',2,'closed','reopened','2026-08-03 09:41:11');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_tokens`
--

DROP TABLE IF EXISTS `api_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `token` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_tokens_token_unique` (`token`),
  KEY `api_tokens_user_id_foreign` (`user_id`),
  CONSTRAINT `api_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_tokens`
--

LOCK TABLES `api_tokens` WRITE;
/*!40000 ALTER TABLE `api_tokens` DISABLE KEYS */;
INSERT INTO `api_tokens` VALUES (1,1,'xPKflhirjHvcdOYXQIvUh2Mu2hBQndOPdlzQ10AnpkNMnh9jVF079ABm0z6QllaV','API Token','2026-08-04 08:41:09','2026-09-03 08:41:08','2026-08-04 08:41:08','2026-08-04 08:41:09'),(2,1,'3WkoBIPV6FGCtMLKjq12DjIfLL8WL47OI8266FBR1OoXERDMMhYXTabZ1B28K7pd','API Token','2026-08-04 08:41:34','2026-09-03 08:41:34','2026-08-04 08:41:34','2026-08-04 08:41:34'),(3,1,'BK7cyGqnTWXoi2uy5E0LtImAEd5cjcqU5i93C1W6LcRQkdiXYSBTmJBaLgWDGLAt','API Token','2026-08-04 08:52:31','2026-09-03 08:52:31','2026-08-04 08:52:31','2026-08-04 08:52:31'),(4,1,'LMHbTNenjEzVHqdTe8hgOpTg4xUwd0rRScU09A8KDJxMUi2o57xxor9rVyaUtZsy','API Token',NULL,'2026-09-03 08:58:47','2026-08-04 08:58:47','2026-08-04 08:58:47'),(5,1,'PEyOHDrl6T0JQeC1DEklA8yBKc8QYe1LEqLcbD0rv2aga5wlvEobFUghUMx97Na4','API Token',NULL,'2026-09-03 09:53:56','2026-08-04 09:53:56','2026-08-04 09:53:56'),(6,1,'3vhM5KpjrTS2ll70NKkLEwkYJrClOsB9VnKLukhVGSAxNYFayA76PFVTTs8bv0k5','API Token','2026-08-04 10:01:15','2026-09-03 10:01:14','2026-08-04 10:01:14','2026-08-04 10:01:15'),(7,1,'uPhlyAa8w6NpIZl0nSec1pofmUlSQnIY0mujacYwPGdQoJFeq7SEDuRLuZ5BCfvK','API Token','2026-08-04 11:10:01','2026-09-03 10:02:13','2026-08-04 10:02:13','2026-08-04 11:10:01'),(8,1,'xkFcdGK2DFTavmBEjnSxuKOtGYieKPq2dp4qZTTkwaSBTeOoacH6hSA766h2hO3P','API Token',NULL,'2026-09-04 02:07:55','2026-08-05 02:07:55','2026-08-05 02:07:55'),(9,1,'8ezGGzUJ4pYE7sJY3UEgqnNkc7HxQT9lPt4CzIe1YPY59IjY2VyC99rhHBLqjAbc','API Token','2026-08-06 03:16:58','2026-09-04 02:08:11','2026-08-05 02:08:11','2026-08-06 03:16:58'),(10,1,'khc26leMAnz2OE6VnNPybqubHVGStEzNYlF3hyyLiLkdAcUYEoqQwZBXnSkPD7Pq','API Token',NULL,'2026-09-04 02:25:38','2026-08-05 02:25:38','2026-08-05 02:25:38'),(11,1,'Q1I05cFmkuFZwxU0NC1NBR0njDqqwWJTnHistZQyTwi9DvUKgQh6T0qW4VRH8esv','API Token','2026-08-06 03:12:44','2026-09-05 03:12:42','2026-08-06 03:12:42','2026-08-06 03:12:44'),(12,1,'f7230DKJLXIinVhebqhu3kKdaMaBM8ebsqIlhLxxJ4bS93kBVbL4qEksEW3BKkNz','API Token','2026-08-06 03:12:59','2026-09-05 03:12:59','2026-08-06 03:12:59','2026-08-06 03:12:59'),(13,1,'mIre6EETO7V3JzEtLRfqRcYoHG8HC1CVYFrMOBDtUSsz65T3md9LynahnoNvbKPA','API Token','2026-08-06 03:13:08','2026-09-05 03:13:08','2026-08-06 03:13:08','2026-08-06 03:13:08');
/*!40000 ALTER TABLE `api_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aset_mes`
--

DROP TABLE IF EXISTS `aset_mes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aset_mes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('putra','putri') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'putra',
  `jumlah` int NOT NULL DEFAULT '1',
  `penanggung_jawab` bigint unsigned DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aset_mes_penanggung_jawab_foreign` (`penanggung_jawab`),
  CONSTRAINT `aset_mes_penanggung_jawab_foreign` FOREIGN KEY (`penanggung_jawab`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aset_mes`
--

LOCK TABLES `aset_mes` WRITE;
/*!40000 ALTER TABLE `aset_mes` DISABLE KEYS */;
INSERT INTO `aset_mes` VALUES (1,'pjph','putra',3,12,'3','tes','tes',1,'2026-07-16 03:21:27','2026-08-04 02:52:33'),(4,'dua','putri',1,6,'HR Manager','Staff IT','tes',1,'2026-08-04 01:35:26','2026-08-04 02:55:15');
/*!40000 ALTER TABLE `aset_mes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aset_ruko`
--

DROP TABLE IF EXISTS `aset_ruko`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aset_ruko` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int unsigned NOT NULL DEFAULT '1',
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aset_ruko`
--

LOCK TABLES `aset_ruko` WRITE;
/*!40000 ALTER TABLE `aset_ruko` DISABLE KEYS */;
/*!40000 ALTER TABLE `aset_ruko` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aset_saya`
--

DROP TABLE IF EXISTS `aset_saya`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aset_saya` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_aset` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daya` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggung_jawab` bigint unsigned DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aset_daya_penanggung_jawab_foreign` (`penanggung_jawab`),
  CONSTRAINT `aset_daya_penanggung_jawab_foreign` FOREIGN KEY (`penanggung_jawab`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aset_saya`
--

LOCK TABLES `aset_saya` WRITE;
/*!40000 ALTER TABLE `aset_saya` DISABLE KEYS */;
INSERT INTO `aset_saya` VALUES (1,'PC','Operasional','2',NULL,16,NULL,NULL,'tes',1,'2026-07-27 03:05:00','2026-07-27 03:05:00'),(2,'te','fe','fe',NULL,16,NULL,NULL,'fe',1,'2026-07-28 07:06:34','2026-07-28 07:06:34'),(3,'tes','tes','11',NULL,16,NULL,NULL,'tes',1,'2026-07-29 03:00:35','2026-07-29 03:00:35');
/*!40000 ALTER TABLE `aset_saya` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aset_tim`
--

DROP TABLE IF EXISTS `aset_tim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aset_tim` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `penanggung_jawab` bigint unsigned DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aset_tim_penanggung_jawab_foreign` (`penanggung_jawab`),
  CONSTRAINT `aset_tim_penanggung_jawab_foreign` FOREIGN KEY (`penanggung_jawab`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aset_tim`
--

LOCK TABLES `aset_tim` WRITE;
/*!40000 ALTER TABLE `aset_tim` DISABLE KEYS */;
INSERT INTO `aset_tim` VALUES (3,'TES','Tim Marketing',1,16,'Admin General Affairs','Staff IT','tes',1,'2026-08-04 02:30:47','2026-08-04 02:53:54'),(4,'TES','Tim Konten',1,NULL,NULL,NULL,NULL,1,'2026-08-04 02:31:03','2026-08-04 02:53:40');
/*!40000 ALTER TABLE `aset_tim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `expire_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES (1,'TV',NULL,2,1,NULL,'2026-07-15 08:40:17','2026-07-15 08:40:17'),(2,'Speaker',NULL,2,1,NULL,'2026-07-15 08:40:17','2026-07-15 08:40:17'),(3,'Proyektor',NULL,2,1,NULL,'2026-07-15 08:40:17','2026-07-15 08:40:17'),(4,'Whiteboard',NULL,2,1,NULL,'2026-07-15 08:40:17','2026-07-15 08:40:17'),(5,'Laptop',NULL,2,1,NULL,'2026-07-15 08:40:17','2026-07-15 08:40:17'),(6,'Kamera',NULL,2,1,NULL,'2026-07-15 08:40:17','2026-07-15 08:40:17');
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-tagihan_check_1','b:1;',1785927279),('laravel-cache-tagihan_check_16','b:1;',1785814820),('laravel-cache-tagihan_check_21','b:1;',1785814224),('laravel-cache-tagihan_check_22','b:1;',1785757251),('laravel-cache-tagihan_check_4','b:1;',1785897218);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
-- Table structure for table `digital_assets`
--

DROP TABLE IF EXISTS `digital_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `digital_assets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `digital_assets`
--

LOCK TABLES `digital_assets` WRITE;
/*!40000 ALTER TABLE `digital_assets` DISABLE KEYS */;
INSERT INTO `digital_assets` VALUES (1,'Laptop','ahmadmusyadadhaury@gmail.com','2026-07-22','2026-07-23',111111.00,'Ahmad','Koordinator','tes',1,'2026-07-22 09:44:14','2026-07-22 09:44:14'),(2,'Laptop','ahmadmusyadadhaury@gmail.com','2026-08-01','2026-08-02',10000.00,'Koordinator Johen.Free Fire','Chief Executive Officer (CEO)','tes',1,'2026-07-29 04:38:00','2026-07-29 04:38:00'),(3,'Laptop','ahmadmusyadadhaury@gmail.com','2026-07-30','2026-08-01',10000.00,'Koordinator Johen.MLBB','General Manager (GM)','tes',1,'2026-07-29 04:38:57','2026-07-29 04:38:57'),(5,'Kaca','ahmadmusyadadhaury@gmail.com','2026-07-28','2026-07-29',10000.00,'ahmad','Koordinator','tes',1,'2026-07-29 08:14:48','2026-07-29 08:14:48');
/*!40000 ALTER TABLE `digital_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `electricity_token_readings`
--

DROP TABLE IF EXISTS `electricity_token_readings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `electricity_token_readings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `remaining_kwh` decimal(10,2) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked_date` date NOT NULL,
  `checked_by` bigint unsigned NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `electricity_token_readings_checked_by_foreign` (`checked_by`),
  CONSTRAINT `electricity_token_readings_checked_by_foreign` FOREIGN KEY (`checked_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `electricity_token_readings`
--

LOCK TABLES `electricity_token_readings` WRITE;
/*!40000 ALTER TABLE `electricity_token_readings` DISABLE KEYS */;
INSERT INTO `electricity_token_readings` VALUES (1,100.00,'segera_isi','2026-08-04',1,'edit test','2026-08-04 08:02:09','2026-08-04 08:28:12');
/*!40000 ALTER TABLE `electricity_token_readings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `internet_usage_checks`
--

DROP TABLE IF EXISTS `internet_usage_checks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `internet_usage_checks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ruangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `penggunaan_wifi` decimal(10,2) NOT NULL DEFAULT '0.00',
  `penggunaan_ethernet` decimal(10,2) NOT NULL DEFAULT '0.00',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `checked_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `internet_usage_checks_checked_by_foreign` (`checked_by`),
  CONSTRAINT `internet_usage_checks_checked_by_foreign` FOREIGN KEY (`checked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `internet_usage_checks`
--

LOCK TABLES `internet_usage_checks` WRITE;
/*!40000 ALTER TABLE `internet_usage_checks` DISABLE KEYS */;
/*!40000 ALTER TABLE `internet_usage_checks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_assets`
--

DROP TABLE IF EXISTS `meeting_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_assets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `asset_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meeting_assets_meeting_id_foreign` (`meeting_id`),
  KEY `meeting_assets_asset_id_foreign` (`asset_id`),
  CONSTRAINT `meeting_assets_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `meeting_assets_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_assets`
--

LOCK TABLES `meeting_assets` WRITE;
/*!40000 ALTER TABLE `meeting_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `meeting_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_invitations`
--

DROP TABLE IF EXISTS `meeting_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_invitations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_invitations_meeting_id_user_id_unique` (`meeting_id`,`user_id`),
  KEY `meeting_invitations_user_id_foreign` (`user_id`),
  CONSTRAINT `meeting_invitations_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `meeting_invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_invitations`
--

LOCK TABLES `meeting_invitations` WRITE;
/*!40000 ALTER TABLE `meeting_invitations` DISABLE KEYS */;
INSERT INTO `meeting_invitations` VALUES (1,1,8,0,NULL,'2026-07-24 02:04:52','2026-07-24 02:04:52'),(2,2,14,1,'2026-07-24 02:10:00','2026-07-24 02:09:25','2026-07-24 02:10:00'),(3,2,16,1,'2026-07-24 02:10:00','2026-07-24 02:09:25','2026-07-24 02:10:00'),(4,3,14,1,'2026-07-28 06:34:12','2026-07-28 06:28:49','2026-07-28 06:34:12'),(5,3,16,1,'2026-07-28 06:34:12','2026-07-28 06:28:49','2026-07-28 06:34:12');
/*!40000 ALTER TABLE `meeting_invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_override_requests`
--

DROP TABLE IF EXISTS `meeting_override_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_override_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `requester_meeting_id` bigint unsigned NOT NULL,
  `target_meeting_id` bigint unsigned NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meeting_override_requests_requester_meeting_id_foreign` (`requester_meeting_id`),
  KEY `meeting_override_requests_target_meeting_id_foreign` (`target_meeting_id`),
  CONSTRAINT `meeting_override_requests_requester_meeting_id_foreign` FOREIGN KEY (`requester_meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `meeting_override_requests_target_meeting_id_foreign` FOREIGN KEY (`target_meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_override_requests`
--

LOCK TABLES `meeting_override_requests` WRITE;
/*!40000 ALTER TABLE `meeting_override_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `meeting_override_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_participants`
--

DROP TABLE IF EXISTS `meeting_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_participants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` enum('invited','confirmed','attended','absent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'invited',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_participants_meeting_id_user_id_unique` (`meeting_id`,`user_id`),
  KEY `meeting_participants_user_id_foreign` (`user_id`),
  CONSTRAINT `meeting_participants_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `meeting_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_participants`
--

LOCK TABLES `meeting_participants` WRITE;
/*!40000 ALTER TABLE `meeting_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `meeting_participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_recordings`
--

DROP TABLE IF EXISTS `meeting_recordings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_recordings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `audio_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transcript` longtext COLLATE utf8mb4_unicode_ci,
  `summary` longtext COLLATE utf8mb4_unicode_ci,
  `duration` int NOT NULL DEFAULT '0' COMMENT 'durasi dalam detik',
  `status` enum('draft','finalized') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `finalized_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_recordings_meeting_id_unique` (`meeting_id`),
  KEY `meeting_recordings_created_by_foreign` (`created_by`),
  CONSTRAINT `meeting_recordings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `meeting_recordings_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_recordings`
--

LOCK TABLES `meeting_recordings` WRITE;
/*!40000 ALTER TABLE `meeting_recordings` DISABLE KEYS */;
/*!40000 ALTER TABLE `meeting_recordings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_reminders`
--

DROP TABLE IF EXISTS `meeting_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_reminders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `type` enum('h1_day','h1_hour') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meeting_reminders_meeting_id_foreign` (`meeting_id`),
  CONSTRAINT `meeting_reminders_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_reminders`
--

LOCK TABLES `meeting_reminders` WRITE;
/*!40000 ALTER TABLE `meeting_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `meeting_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_teams`
--

DROP TABLE IF EXISTS `meeting_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `team_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_teams_meeting_id_team_id_unique` (`meeting_id`,`team_id`),
  KEY `meeting_teams_team_id_foreign` (`team_id`),
  CONSTRAINT `meeting_teams_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `meeting_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_teams`
--

LOCK TABLES `meeting_teams` WRITE;
/*!40000 ALTER TABLE `meeting_teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `meeting_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meetings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint unsigned NOT NULL,
  `requested_by` bigint unsigned NOT NULL,
  `team_id` bigint unsigned NOT NULL,
  `why` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `what` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meeting_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `actual_end_time` time DEFAULT NULL,
  `how_expected` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected','confirmed','cancelled','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `queue_position` int unsigned DEFAULT NULL COMMENT 'null = tidak antri, 0 = sedang berlangsung, 1,2,3... = antrian ke-n',
  `reject_reason` text COLLATE utf8mb4_unicode_ci,
  `is_weekly` tinyint(1) NOT NULL DEFAULT '0',
  `weekly_day` tinyint DEFAULT NULL COMMENT '0=Sunday, 1=Monday, ..., 6=Saturday',
  `weekly_time` time DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meetings_room_id_foreign` (`room_id`),
  KEY `meetings_requested_by_foreign` (`requested_by`),
  KEY `meetings_team_id_foreign` (`team_id`),
  KEY `meetings_approved_by_foreign` (`approved_by`),
  CONSTRAINT `meetings_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `meetings_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `meetings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `meetings_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meetings`
--

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
INSERT INTO `meetings` VALUES (1,'sa',1,8,2,'sa','sa','2026-07-24','09:30:00','10:00:00',NULL,'sa',NULL,'approved',0,NULL,0,NULL,NULL,4,'2026-07-24 02:04:52','2026-07-21 01:44:09','2026-07-24 02:06:17'),(2,'sd',1,16,5,'ds','ds','2026-07-24','10:08:00','11:08:00','10:09:00','sd',NULL,'completed',0,NULL,0,NULL,NULL,4,'2026-07-24 02:09:25','2026-07-24 02:09:11','2026-07-24 02:10:00'),(3,'tes',1,16,5,'tes','tes','2026-07-28','13:28:00','14:28:00','13:34:00','tes',NULL,'completed',0,NULL,0,NULL,NULL,4,'2026-07-28 06:28:49','2026-07-28 06:28:20','2026-07-28 06:34:12');
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_01_01_000002_create_teams_rooms_assets_table',1),(5,'2026_01_01_000003_create_meetings_table',1),(6,'2026_01_01_000004_add_file_and_invitations',1),(7,'2026_01_01_000005_create_meeting_teams_table',1),(8,'2026_01_01_000006_create_weekly_meeting_sessions_table',1),(9,'2026_01_01_000007_add_queue_to_meetings_table',1),(10,'2026_01_01_000008_add_avatar_to_users_table',1),(11,'2026_05_18_162207_create_notifications_table',1),(12,'2026_05_18_171129_create_push_subscriptions_table',1),(13,'2026_05_19_141433_create_meeting_override_requests_table',1),(14,'2026_06_15_112356_add_ceo_role_to_users_table',1),(15,'2026_06_20_000001_add_expire_date_to_assets_table',1),(16,'2026_06_23_000001_create_vehicles_table',1),(17,'2026_06_23_000002_create_digital_assets_table',1),(18,'2026_06_23_000003_create_sim_cards_table',1),(19,'2026_06_23_000004_create_peralatan_kantor_table',1),(20,'2026_06_23_000005_create_aset_ruko_table',1),(21,'2026_06_23_110801_create_payments_table',1),(22,'2026_06_23_111647_create_wifi_payments_table',1),(23,'2026_06_23_112341_recreate_payments_table',1),(24,'2026_06_23_113217_create_wifi_payments_table',1),(25,'2026_06_23_174040_add_new_columns_to_vehicles_table',1),(26,'2026_06_24_000001_create_electricity_token_readings_table',1),(27,'2026_06_24_000002_add_status_to_electricity_token_readings_table',1),(28,'2026_06_24_000003_create_token_payments_table',1),(29,'2026_06_24_152809_add_jenis_to_payments_table',1),(30,'2026_06_25_162147_create_pembayaran_aset_digital_table',1),(31,'2026_06_25_162152_create_pembayaran_ipl_ruko_table',1),(32,'2026_06_25_162157_migrate_payment_data_to_new_tables',1),(33,'2026_06_25_163354_add_settings_to_users_table',1),(34,'2026_06_27_000001_create_vehicle_pajak_requests_table',1),(35,'2026_06_27_000002_add_email_to_users_table',1),(36,'2026_06_27_115001_add_digital_asset_id_to_pembayaran_aset_digital_table',1),(37,'2026_06_28_000001_create_messages_table',1),(38,'2026_06_28_105200_add_approval_to_payments_tables',1),(39,'2026_06_28_114000_add_performance_indexes',1),(40,'2026_06_28_210736_add_pic_jabatan_to_payment_tables',1),(41,'2026_06_29_143910_add_nominal_to_token_payments_table',1),(42,'2026_06_30_000001_create_sosial_media_table',1),(43,'2026_06_30_000002_create_internet_usage_checks_table',1),(44,'2026_07_01_085102_add_admin_ga_role_to_users_table',1),(45,'2026_07_05_000001_add_period_to_payment_tables',1),(46,'2026_07_07_100709_create_aset_daya_table',1),(47,'2026_07_07_100709_create_aset_tim_table',1),(48,'2026_07_07_100710_create_pembayaran_aset_daya_table',1),(49,'2026_07_07_100710_create_pembayaran_aset_tim_table',1),(50,'2026_07_07_100711_add_jenis_aset_to_aset_daya_table',1),(51,'2026_07_08_000001_create_api_tokens_table',1),(52,'2026_07_08_000002_increase_nominal_in_vehicle_pajak_requests',1),(53,'2026_07_08_000003_create_aset_mes_table',1),(54,'2026_07_08_000004_create_pembayaran_aset_mes_table',1),(55,'2026_07_08_000005_drop_merk_from_aset_mes_table',1),(56,'2026_07_09_000001_add_status_to_sosial_media_table',1),(57,'2026_07_10_000001_add_kode_aset_and_barcode_to_peralatan_kantor_table',1),(58,'2026_07_12_151753_drop_payments_table',1),(59,'2026_07_12_200952_add_foto_to_peralatan_kantor_table',1),(60,'2026_07_16_141048_alter_peralatan_kantor_make_jabatan_nullable',2),(61,'2026_07_16_141442_alter_peralatan_kantor_make_pic_atasan_nullable',3),(62,'2026_07_18_000001_add_atasan_to_sim_cards_table',4),(63,'2026_07_22_100638_add_team_id_to_rooms_table',5),(64,'2026_07_22_110000_create_team_compositions_table',6),(65,'2026_07_24_134303_change_teams_description_to_text',7),(66,'2026_07_29_162511_make_vehicle_pajak_requests_requested_by_nullable',8),(67,'2026_07_29_163050_add_biaya_pajak_to_vehicles_table',9),(68,'2026_07_31_000001_create_ticket_categories_table',10),(69,'2026_07_31_000002_create_ticket_sla_table',10),(70,'2026_07_31_000003_create_ticket_team_members_table',10),(71,'2026_07_31_000004_create_tickets_table',10),(72,'2026_07_31_000005_create_ticket_comments_table',10),(73,'2026_07_31_000006_create_ticket_attachments_table',10),(74,'2026_07_31_000007_create_ticket_histories_table',10),(75,'2026_07_31_000008_create_ticket_ratings_table',10),(76,'2026_07_31_000009_create_ticket_notifications_table',10),(77,'2026_07_31_000010_create_activity_logs_table',10),(78,'2026_08_03_112844_make_tickets_location_nullable',11),(79,'2026_08_04_082623_add_kategori_to_aset_mes_table',12),(80,'2026_08_04_100000_create_meeting_recordings_table',13),(81,'2026_08_04_144706_add_bukti_bayar_to_token_payments_table',14),(82,'2026_08_05_000001_add_nik_to_users_table',15),(83,'2026_08_06_000001_rename_aset_daya_to_aset_saya',16);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moms`
--

DROP TABLE IF EXISTS `moms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `moms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `decisions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_plan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Penanggung jawab',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','sent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `moms_meeting_id_unique` (`meeting_id`),
  KEY `moms_created_by_foreign` (`created_by`),
  CONSTRAINT `moms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `moms_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moms`
--

LOCK TABLES `moms` WRITE;
/*!40000 ALTER TABLE `moms` DISABLE KEYS */;
INSERT INTO `moms` VALUES (1,2,16,'sd','sd','sd','ahmad',NULL,'sent','2026-07-24 02:10:21','2026-07-24 02:10:21','2026-07-24 02:10:21');
/*!40000 ALTER TABLE `moms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dedup_key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`),
  KEY `notifications_dedup_key_user_id_index` (`dedup_key`,`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,1,'activity','Request Meeting Baru','Koordinator Johen.roblox mengajukan request meeting: sa','http://127.0.0.1:8000/admin/meetings/1',NULL,1,'2026-07-23 01:13:41','2026-07-21 01:44:09','2026-07-23 01:13:41'),(2,2,'activity','Request Meeting Baru','Koordinator Johen.roblox mengajukan request meeting: sa','http://127.0.0.1:8000/admin/meetings/1',NULL,0,NULL,'2026-07-21 01:44:09','2026-07-21 01:44:09'),(3,3,'activity','Request Meeting Baru','Koordinator Johen.roblox mengajukan request meeting: sa','http://127.0.0.1:8000/admin/meetings/1',NULL,1,'2026-07-24 02:04:26','2026-07-21 01:44:09','2026-07-24 02:04:26'),(4,4,'activity','Request Meeting Baru','Koordinator Johen.roblox mengajukan request meeting: sa','http://127.0.0.1:8000/admin/meetings/1',NULL,1,'2026-07-24 02:04:48','2026-07-21 01:44:09','2026-07-24 02:04:48'),(5,5,'activity','Request Meeting Baru','Koordinator Johen.roblox mengajukan request meeting: sa','http://127.0.0.1:8000/admin/meetings/1',NULL,0,NULL,'2026-07-21 01:44:09','2026-07-21 01:44:09'),(6,3,'approval','Persetujuan Aset Digital','Laptop menunggu persetujuan','http://127.0.0.1:8000/admin/payment-approvals','approval_pembayaran_aset_digital_1',0,NULL,'2026-07-22 09:49:44','2026-07-22 09:49:44'),(7,1,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Januari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-23 03:03:07','2026-07-23 02:55:22','2026-07-23 03:03:07'),(8,2,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Januari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:55:22','2026-07-23 02:55:22'),(9,3,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Januari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:26','2026-07-23 02:55:22','2026-07-24 02:04:26'),(10,4,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Januari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:48','2026-07-23 02:55:22','2026-07-24 02:04:48'),(11,5,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Januari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:55:22','2026-07-23 02:55:22'),(12,1,'tagihan','Tagihan IPL Ruko','Juli 2026 ??? Rp 1.700.000','http://127.0.0.1:8000/payment-approval/tagihan','tagihan_pembayaran_ipl_ruko_7',0,NULL,'2026-07-23 02:55:24','2026-07-23 02:55:24'),(13,1,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Februari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-23 03:03:07','2026-07-23 02:58:15','2026-07-23 03:03:07'),(14,2,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Februari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:58:15','2026-07-23 02:58:15'),(15,3,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Februari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:26','2026-07-23 02:58:15','2026-07-24 02:04:26'),(16,4,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Februari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:48','2026-07-23 02:58:15','2026-07-24 02:04:48'),(17,5,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Februari 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:58:15','2026-07-23 02:58:15'),(18,1,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Maret 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-23 03:03:07','2026-07-23 02:58:43','2026-07-23 03:03:07'),(19,2,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Maret 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:58:43','2026-07-23 02:58:43'),(20,3,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Maret 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:26','2026-07-23 02:58:43','2026-07-24 02:04:26'),(21,4,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Maret 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:48','2026-07-23 02:58:43','2026-07-24 02:04:48'),(22,5,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Maret 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:58:43','2026-07-23 02:58:43'),(23,1,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juli 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-23 03:03:07','2026-07-23 02:59:09','2026-07-23 03:03:07'),(24,2,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juli 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:59:09','2026-07-23 02:59:09'),(25,3,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juli 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:26','2026-07-23 02:59:09','2026-07-24 02:04:26'),(26,4,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juli 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:48','2026-07-23 02:59:09','2026-07-24 02:04:48'),(27,5,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juli 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:59:09','2026-07-23 02:59:09'),(28,1,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juni 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-23 03:03:07','2026-07-23 02:59:56','2026-07-23 03:03:07'),(29,2,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juni 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:59:56','2026-07-23 02:59:56'),(30,3,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juni 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:26','2026-07-23 02:59:56','2026-07-24 02:04:26'),(31,4,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juni 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:48','2026-07-23 02:59:56','2026-07-24 02:04:48'),(32,5,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Juni 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 02:59:56','2026-07-23 02:59:56'),(33,1,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Mei 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-23 03:03:07','2026-07-23 03:00:13','2026-07-23 03:03:07'),(34,2,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Mei 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 03:00:13','2026-07-23 03:00:13'),(35,3,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Mei 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:26','2026-07-23 03:00:13','2026-07-24 02:04:26'),(36,4,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Mei 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:48','2026-07-23 03:00:13','2026-07-24 02:04:48'),(37,5,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (Mei 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 03:00:13','2026-07-23 03:00:13'),(38,1,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (April 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-23 03:03:07','2026-07-23 03:00:28','2026-07-23 03:03:07'),(39,2,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (April 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 03:00:28','2026-07-23 03:00:28'),(40,3,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (April 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:26','2026-07-23 03:00:28','2026-07-24 02:04:26'),(41,4,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (April 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-24 02:04:48','2026-07-23 03:00:28','2026-07-24 02:04:48'),(42,5,'activity','Pengajuan Pembayaran','Pembayaran IPL Ruko (April 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-23 03:00:28','2026-07-23 03:00:28'),(43,1,'activity','Pembayaran Disetujui','Pembayaran IPL Ruko (Januari 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-07-24 02:05:10','2026-07-23 09:06:10','2026-07-24 02:05:10'),(44,1,'activity','Pembayaran Disetujui','Pembayaran IPL Ruko (Februari 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-07-24 02:05:10','2026-07-23 09:06:10','2026-07-24 02:05:10'),(45,1,'activity','Pembayaran Disetujui','Pembayaran IPL Ruko (Maret 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-07-24 02:05:10','2026-07-23 09:06:10','2026-07-24 02:05:10'),(46,1,'activity','Pembayaran Disetujui','Pembayaran IPL Ruko (April 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-07-24 02:05:10','2026-07-23 09:06:10','2026-07-24 02:05:10'),(47,1,'activity','Pembayaran Disetujui','Pembayaran IPL Ruko (Mei 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-07-24 02:05:10','2026-07-23 09:06:10','2026-07-24 02:05:10'),(48,1,'activity','Pembayaran Disetujui','Pembayaran IPL Ruko (Juni 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-07-24 02:05:10','2026-07-23 09:06:10','2026-07-24 02:05:10'),(49,1,'activity','Pembayaran Disetujui','Pembayaran IPL Ruko (Juli 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-07-24 02:05:10','2026-07-23 09:06:10','2026-07-24 02:05:10'),(50,3,'approval','Persetujuan IPL Ruko','Agustus 2026 menunggu persetujuan','http://127.0.0.1:8000/admin/payment-approvals','approval_pembayaran_ipl_ruko_13',0,NULL,'2026-07-24 01:12:34','2026-07-24 01:12:34'),(51,8,'activity','Meeting Disetujui ???','Meeting \"sa\" telah disetujui. Status: Sedang Berlangsung','http://127.0.0.1:8000/koordinator/meetings/1',NULL,0,NULL,'2026-07-24 02:04:52','2026-07-24 02:04:52'),(52,1,'activity','Request Meeting Baru','ahmad mengajukan request meeting: sd','http://127.0.0.1:8000/admin/meetings/2',NULL,1,'2026-07-27 03:54:51','2026-07-24 02:09:11','2026-07-27 03:54:51'),(53,2,'activity','Request Meeting Baru','ahmad mengajukan request meeting: sd','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:09:11','2026-07-24 02:09:11'),(54,3,'activity','Request Meeting Baru','ahmad mengajukan request meeting: sd','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:09:11','2026-07-24 02:09:11'),(55,4,'activity','Request Meeting Baru','ahmad mengajukan request meeting: sd','http://127.0.0.1:8000/admin/meetings/2',NULL,1,'2026-07-24 02:09:22','2026-07-24 02:09:11','2026-07-24 02:09:22'),(56,5,'activity','Request Meeting Baru','ahmad mengajukan request meeting: sd','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:09:11','2026-07-24 02:09:11'),(57,16,'activity','Meeting Disetujui ???','Meeting \"sd\" telah disetujui. Status: Sedang Berlangsung','http://127.0.0.1:8000/koordinator/meetings/2',NULL,1,'2026-07-24 02:09:53','2026-07-24 02:09:25','2026-07-24 02:09:53'),(58,14,'meeting','Undangan Meeting Baru ????','Kamu diundang ke meeting: sd pada 24 Jul 2026','http://127.0.0.1:8000/undangan',NULL,0,NULL,'2026-07-24 02:09:25','2026-07-24 02:09:25'),(59,1,'activity','Meeting Selesai','sd telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/2',NULL,1,'2026-07-27 03:54:51','2026-07-24 02:10:00','2026-07-27 03:54:51'),(60,2,'activity','Meeting Selesai','sd telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:10:00','2026-07-24 02:10:00'),(61,3,'activity','Meeting Selesai','sd telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:10:00','2026-07-24 02:10:00'),(62,4,'activity','Meeting Selesai','sd telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/2',NULL,1,'2026-07-28 01:32:42','2026-07-24 02:10:00','2026-07-28 01:32:42'),(63,5,'activity','Meeting Selesai','sd telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:10:00','2026-07-24 02:10:00'),(64,14,'activity','MOM Terkirim ????','Minutes of Meeting untuk \"sd\" telah dikirim.','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:10:21','2026-07-24 02:10:21'),(65,16,'activity','MOM Terkirim ????','Minutes of Meeting untuk \"sd\" telah dikirim.','http://127.0.0.1:8000/admin/meetings/2',NULL,1,'2026-07-24 02:10:23','2026-07-24 02:10:21','2026-07-24 02:10:23'),(66,1,'activity','MOM Terkirim ????','Minutes of Meeting untuk \"sd\" telah dikirim.','http://127.0.0.1:8000/admin/meetings/2',NULL,1,'2026-07-27 03:54:51','2026-07-24 02:10:21','2026-07-27 03:54:51'),(67,2,'activity','MOM Terkirim ????','Minutes of Meeting untuk \"sd\" telah dikirim.','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:10:21','2026-07-24 02:10:21'),(68,3,'activity','MOM Terkirim ????','Minutes of Meeting untuk \"sd\" telah dikirim.','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:10:21','2026-07-24 02:10:21'),(69,4,'activity','MOM Terkirim ????','Minutes of Meeting untuk \"sd\" telah dikirim.','http://127.0.0.1:8000/admin/meetings/2',NULL,1,'2026-07-28 01:32:42','2026-07-24 02:10:21','2026-07-28 01:32:42'),(70,5,'activity','MOM Terkirim ????','Minutes of Meeting untuk \"sd\" telah dikirim.','http://127.0.0.1:8000/admin/meetings/2',NULL,0,NULL,'2026-07-24 02:10:21','2026-07-24 02:10:21'),(71,1,'meeting','Meeting Mingguan Dimulai ????','Weekly Meeting di Meeting Room Utama sudah dimulai! [weekly_start_2]','http://127.0.0.1:8000/weekly-undangan',NULL,0,NULL,'2026-07-27 06:00:03','2026-07-27 06:00:03'),(72,1,'activity','Request Meeting Baru','ahmad mengajukan request meeting: tes','http://127.0.0.1:8000/admin/meetings/3',NULL,1,'2026-07-29 01:55:55','2026-07-28 06:28:20','2026-07-29 01:55:55'),(73,2,'activity','Request Meeting Baru','ahmad mengajukan request meeting: tes','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:28:20','2026-07-28 06:28:20'),(74,3,'activity','Request Meeting Baru','ahmad mengajukan request meeting: tes','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:28:20','2026-07-28 06:28:20'),(75,4,'activity','Request Meeting Baru','ahmad mengajukan request meeting: tes','http://127.0.0.1:8000/admin/meetings/3',NULL,1,'2026-07-28 06:28:36','2026-07-28 06:28:20','2026-07-28 06:28:36'),(76,5,'activity','Request Meeting Baru','ahmad mengajukan request meeting: tes','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:28:20','2026-07-28 06:28:20'),(77,16,'activity','Meeting Disetujui ???','Meeting \"tes\" telah disetujui. Status: Sedang Berlangsung','http://127.0.0.1:8000/koordinator/meetings/3',NULL,1,'2026-07-28 06:29:28','2026-07-28 06:28:49','2026-07-28 06:29:28'),(78,14,'meeting','Undangan Meeting Baru ????','Kamu diundang ke meeting: tes pada 28 Jul 2026','http://127.0.0.1:8000/undangan',NULL,0,NULL,'2026-07-28 06:28:49','2026-07-28 06:28:49'),(79,16,'meeting','Meeting Dimulai ????','tes di Meeting Room Utama sudah dimulai! [meeting_start_3]','http://127.0.0.1:8000/undangan',NULL,1,'2026-07-29 02:30:50','2026-07-28 06:29:03','2026-07-29 02:30:50'),(80,1,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,1,'2026-07-29 01:55:55','2026-07-28 06:30:33','2026-07-29 01:55:55'),(81,2,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:30:33','2026-07-28 06:30:33'),(82,3,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:30:33','2026-07-28 06:30:33'),(83,4,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,1,'2026-08-05 02:29:52','2026-07-28 06:30:33','2026-08-05 02:29:52'),(84,5,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:30:33','2026-07-28 06:30:33'),(85,1,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,1,'2026-07-29 01:55:55','2026-07-28 06:34:12','2026-07-29 01:55:55'),(86,2,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:34:12','2026-07-28 06:34:12'),(87,3,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:34:12','2026-07-28 06:34:12'),(88,4,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,1,'2026-08-05 02:29:52','2026-07-28 06:34:12','2026-08-05 02:29:52'),(89,5,'activity','Meeting Selesai','tes telah diselesaikan oleh ahmad','http://127.0.0.1:8000/admin/meetings/3',NULL,0,NULL,'2026-07-28 06:34:12','2026-07-28 06:34:12'),(90,1,'tagihan','Tagihan Aset Digital','tes ??? Rp 100.000','http://127.0.0.1:8000/payment-approval/tagihan','tagihan_pembayaran_aset_digital_8',0,NULL,'2026-07-29 08:05:49','2026-07-29 08:05:49'),(91,16,'tagihan','Tagihan Aset Digital','tes ??? Rp 100.000','http://127.0.0.1:8000/payment-approval/tagihan','tagihan_pembayaran_aset_digital_8',0,NULL,'2026-07-29 08:24:34','2026-07-29 08:24:34'),(92,1,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-29 09:26:35','2026-07-29 08:58:06','2026-07-29 09:26:35'),(93,2,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:06','2026-07-29 08:58:06'),(94,3,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:06','2026-07-29 08:58:06'),(95,4,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-08-05 02:29:52','2026-07-29 08:58:06','2026-08-05 02:29:52'),(96,5,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:06','2026-07-29 08:58:06'),(97,1,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-29 09:26:35','2026-07-29 08:58:21','2026-07-29 09:26:35'),(98,2,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:21','2026-07-29 08:58:21'),(99,3,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:21','2026-07-29 08:58:21'),(100,4,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-08-05 02:29:52','2026-07-29 08:58:21','2026-08-05 02:29:52'),(101,5,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Kaca (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:21','2026-07-29 08:58:21'),(102,1,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Laptop (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-29 09:26:35','2026-07-29 08:58:52','2026-07-29 09:26:35'),(103,2,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Laptop (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:52','2026-07-29 08:58:52'),(104,3,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Laptop (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:52','2026-07-29 08:58:52'),(105,4,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Laptop (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-08-05 02:29:52','2026-07-29 08:58:52','2026-08-05 02:29:52'),(106,5,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Laptop (Perpanjangan)) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 08:58:52','2026-07-29 08:58:52'),(107,4,'tagihan','Tagihan Aset Digital','tes ??? Rp 100.000','http://127.0.0.1:8000/payment-approval/tagihan','tagihan_pembayaran_aset_digital_8',0,NULL,'2026-07-29 08:59:23','2026-07-29 08:59:23'),(108,16,'activity','Pembayaran Disetujui','Pembayaran Aset Digital (Kaca) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-08-03 03:20:35','2026-07-29 08:59:31','2026-08-03 03:20:35'),(109,16,'activity','Pembayaran Disetujui','Pembayaran Aset Digital (Laptop (Perpanjangan)) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-08-03 03:20:35','2026-07-29 08:59:31','2026-08-03 03:20:35'),(110,16,'activity','Pembayaran Disetujui','Pembayaran Aset Digital (Kaca (Perpanjangan)) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-08-03 03:20:35','2026-07-29 08:59:31','2026-08-03 03:20:35'),(111,1,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Desember 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-29 09:26:35','2026-07-29 09:07:47','2026-07-29 09:26:35'),(112,2,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Desember 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:07:47','2026-07-29 09:07:47'),(113,3,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Desember 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:07:47','2026-07-29 09:07:47'),(114,4,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Desember 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-08-05 02:29:52','2026-07-29 09:07:47','2026-08-05 02:29:52'),(115,5,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (Desember 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:07:47','2026-07-29 09:07:47'),(116,1,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-29 09:26:35','2026-07-29 09:08:42','2026-07-29 09:26:35'),(117,2,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:08:42','2026-07-29 09:08:42'),(118,3,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:08:42','2026-07-29 09:08:42'),(119,4,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-08-05 02:29:52','2026-07-29 09:08:42','2026-08-05 02:29:52'),(120,5,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:08:42','2026-07-29 09:08:42'),(121,1,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-07-29 09:26:35','2026-07-29 09:09:00','2026-07-29 09:26:35'),(122,2,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:09:00','2026-07-29 09:09:00'),(123,3,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:09:00','2026-07-29 09:09:00'),(124,4,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,1,'2026-08-05 02:29:52','2026-07-29 09:09:00','2026-08-05 02:29:52'),(125,5,'activity','Pengajuan Pembayaran','Pembayaran Aset Digital (November 2026) menunggu approval.','http://127.0.0.1:8000/admin/payment-approvals',NULL,0,NULL,'2026-07-29 09:09:00','2026-07-29 09:09:00'),(126,16,'activity','Pembayaran Disetujui','Pembayaran Aset Digital (November 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-08-03 03:20:35','2026-07-29 09:09:36','2026-08-03 03:20:35'),(127,16,'activity','Pembayaran Disetujui','Pembayaran Aset Digital (November 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-08-03 03:20:35','2026-07-29 09:09:36','2026-08-03 03:20:35'),(128,16,'activity','Pembayaran Disetujui','Pembayaran Aset Digital (Desember 2026) telah disetujui oleh HR Manager.','http://127.0.0.1:8000/payment-approval',NULL,1,'2026-08-03 03:20:35','2026-07-29 09:09:36','2026-08-03 03:20:35'),(129,1,'ticket','Ticket Baru','Ticket TK-20260731-0001 ??? tesd dibuka oleh ahmad','http://127.0.0.1:8000/tickets/1',NULL,0,NULL,'2026-07-31 08:04:51','2026-07-31 08:04:51'),(130,14,'ticket','Ticket Baru','Ticket TK-20260731-0001 ??? tesd dibuka oleh ahmad','http://127.0.0.1:8000/tickets/1',NULL,0,NULL,'2026-07-31 08:04:51','2026-07-31 08:04:51'),(131,1,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260731-0001 oleh ahmad.','http://127.0.0.1:8000/tickets/1',NULL,0,NULL,'2026-07-31 08:05:05','2026-07-31 08:05:05'),(132,14,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260731-0001 oleh ahmad.','http://127.0.0.1:8000/tickets/1',NULL,0,NULL,'2026-07-31 08:05:05','2026-07-31 08:05:05'),(133,21,'tagihan','Tagihan Aset Digital','tes ??? Rp 100.000','http://127.0.0.1:8000/payment-approval/tagihan','tagihan_pembayaran_aset_digital_8',0,NULL,'2026-07-31 08:22:40','2026-07-31 08:22:40'),(134,16,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260731-0001 oleh Admin Master.','http://127.0.0.1:8000/tickets/1',NULL,0,NULL,'2026-08-03 04:00:15','2026-08-03 04:00:15'),(135,22,'tagihan','Tagihan Aset Digital','tes ??? Rp 100.000','http://127.0.0.1:8000/payment-approval/tagihan','tagihan_pembayaran_aset_digital_8',0,NULL,'2026-08-03 04:01:37','2026-08-03 04:01:37'),(136,1,'ticket','Ticket Baru','Ticket TK-20260803-0001 ??? dada dibuka oleh jors','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(137,14,'ticket','Ticket Baru','Ticket TK-20260803-0001 ??? dada dibuka oleh jors','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(138,16,'ticket','Ticket Baru','Ticket TK-20260803-0001 ??? dada dibuka oleh jors','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(139,21,'ticket','Ticket Baru','Ticket TK-20260803-0001 ??? dada dibuka oleh jors','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(140,1,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260803-0001 oleh jors.','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(141,14,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260803-0001 oleh jors.','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(142,16,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260803-0001 oleh jors.','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(143,21,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260803-0001 oleh jors.','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(144,22,'ticket','Ticket Diambil','Ticket TK-20260803-0001 telah diambil oleh ahmad.','http://127.0.0.1:8000/tickets/2',NULL,1,'2026-08-03 04:51:56','2026-08-03 04:34:30','2026-08-03 04:51:56'),(145,22,'ticket','Update Status','Status ticket TK-20260803-0001 menjadi In Progress.','http://127.0.0.1:8000/tickets/2',NULL,1,'2026-08-03 04:51:56','2026-08-03 04:34:47','2026-08-03 04:51:56'),(146,22,'ticket','Update Status','Status ticket TK-20260803-0001 menjadi Resolved.','http://127.0.0.1:8000/tickets/2',NULL,1,'2026-08-03 04:51:56','2026-08-03 04:35:03','2026-08-03 04:51:56'),(147,22,'ticket','Update Status','Status ticket TK-20260803-0001 menjadi Reopened.','http://127.0.0.1:8000/tickets/2',NULL,1,'2026-08-03 04:51:56','2026-08-03 04:35:13','2026-08-03 04:51:56'),(148,22,'ticket','Ticket Selesai ????','Ticket TK-20260803-0001 telah diselesaikan. Mohon konfirmasi ??? masih bermasalah atau selesai?','http://127.0.0.1:8000/tickets/2',NULL,1,'2026-08-03 04:51:56','2026-08-03 04:35:17','2026-08-03 04:51:56'),(149,16,'ticket','Ticket Ditutup','Ticket TK-20260803-0001 telah dikonfirmasi selesai oleh jors.','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:35:53','2026-08-03 04:35:53'),(150,16,'ticket','Rating Baru ???','Ticket TK-20260803-0001 mendapatkan rating 5 bintang.','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 04:35:59','2026-08-03 04:35:59'),(151,1,'ticket','Ticket Baru','Ticket TK-20260803-0002 ??? tes dibuka oleh jors','http://127.0.0.1:8000/tickets/3',NULL,0,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(152,14,'ticket','Ticket Baru','Ticket TK-20260803-0002 ??? tes dibuka oleh jors','http://127.0.0.1:8000/tickets/3',NULL,0,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(153,16,'ticket','Ticket Baru','Ticket TK-20260803-0002 ??? tes dibuka oleh jors','http://127.0.0.1:8000/tickets/3',NULL,0,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(154,21,'ticket','Ticket Baru','Ticket TK-20260803-0002 ??? tes dibuka oleh jors','http://127.0.0.1:8000/tickets/3',NULL,0,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(155,22,'meeting','Meeting Mingguan Dimulai ????','Weekly Meeting di Meeting Room Utama sudah dimulai! [weekly_start_3]','http://127.0.0.1:8000/weekly-undangan',NULL,0,NULL,'2026-08-03 06:00:27','2026-08-03 06:00:27'),(156,16,'ticket','Ticket Dibuka Kembali','Ticket TK-20260803-0001 dibuka kembali oleh jors.','http://127.0.0.1:8000/tickets/2',NULL,0,NULL,'2026-08-03 09:41:11','2026-08-03 09:41:11');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_aset_digital`
--

DROP TABLE IF EXISTS `pembayaran_aset_digital`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran_aset_digital` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `digital_asset_id` bigint unsigned DEFAULT NULL,
  `requested_by` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  PRIMARY KEY (`id`),
  KEY `pembayaran_aset_digital_digital_asset_id_foreign` (`digital_asset_id`),
  KEY `pembayaran_aset_digital_requested_by_foreign` (`requested_by`),
  KEY `pembayaran_aset_digital_approved_by_foreign` (`approved_by`),
  KEY `idx_aset_status_jatuh` (`status`,`jatuh_tempo`),
  CONSTRAINT `pembayaran_aset_digital_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_aset_digital_digital_asset_id_foreign` FOREIGN KEY (`digital_asset_id`) REFERENCES `digital_assets` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_aset_digital_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_aset_digital`
--

LOCK TABLES `pembayaran_aset_digital` WRITE;
/*!40000 ALTER TABLE `pembayaran_aset_digital` DISABLE KEYS */;
INSERT INTO `pembayaran_aset_digital` VALUES (5,'Laptop','2026-07-29','2026-08-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 04:38:00','2026-07-29 08:59:31',2,NULL,4,'2026-07-29 08:59:31',NULL,NULL,'bulanan'),(6,'Laptop','2026-07-29','2026-08-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 04:38:57','2026-07-29 08:59:31',3,NULL,4,'2026-07-29 08:59:31',NULL,NULL,'bulanan'),(7,'PC','2026-07-29','2026-08-28',1111.00,NULL,NULL,'lunas',NULL,'2026-07-29 04:39:47','2026-07-29 08:59:31',NULL,NULL,4,'2026-07-29 08:59:31',NULL,NULL,'bulanan'),(8,'tes','2026-07-29','2026-07-29',100000.00,NULL,NULL,'jatuh_tempo',NULL,'2026-07-29 08:01:00','2026-07-29 08:01:00',NULL,NULL,NULL,NULL,NULL,NULL,'bulanan'),(9,'Kaca','2026-07-29','2026-08-28',10000.00,'ahmad','Admin HR','lunas','2026-07-29','2026-07-29 08:14:48','2026-07-29 08:59:31',5,16,4,'2026-07-29 08:59:31','payment-bukti/XVA0nkn11YNaQBON7VKipkZgNR0o3zD77EuxsjW2.jpg',NULL,'bulanan'),(10,'Laptop (Perpanjangan)','2026-07-29','2026-08-28',111111.00,'ahmad','Koordinator','lunas','2026-07-29','2026-07-29 08:36:33','2026-07-29 08:59:31',1,16,4,'2026-07-29 08:59:31','payment-bukti/6qSem2ARXa44BAY7X5ESbGeXQY9SPEbrBrfIok5t.jpg',NULL,'bulanan'),(11,'Laptop (Perpanjangan)','2026-07-29','2026-08-28',10000.00,'Koordinator Johen.Free Fire','Chief Executive Officer (CEO)','lunas',NULL,'2026-07-29 08:36:33','2026-07-29 08:59:31',2,NULL,4,'2026-07-29 08:59:31',NULL,NULL,'bulanan'),(12,'Laptop (Perpanjangan)','2026-07-29','2026-08-28',10000.00,'Koordinator Johen.MLBB','General Manager (GM)','lunas',NULL,'2026-07-29 08:36:33','2026-07-29 08:59:31',3,NULL,4,'2026-07-29 08:59:31',NULL,NULL,'bulanan'),(13,'Kaca (Perpanjangan)','2026-07-29','2026-08-28',10000.00,'ahmad','Admin HR','lunas','2026-07-29','2026-07-29 08:36:33','2026-07-29 08:59:31',5,16,4,'2026-07-29 08:59:31','payment-bukti/ebXI50QYrBIE0gtohSIKkt8DfYyQtQ1u6m9yeh9p.jpg',NULL,'bulanan'),(14,'September 2026','2026-08-29','2026-09-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:31','2026-07-29 08:59:37',2,NULL,4,'2026-07-29 08:59:37',NULL,NULL,'bulanan'),(15,'September 2026','2026-08-29','2026-09-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:31','2026-07-29 08:59:37',3,NULL,4,'2026-07-29 08:59:37',NULL,NULL,'bulanan'),(16,'September 2026','2026-08-29','2026-09-28',1111.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:31','2026-07-29 08:59:37',NULL,NULL,4,'2026-07-29 08:59:37',NULL,NULL,'bulanan'),(17,'September 2026','2026-08-29','2026-09-28',10000.00,'ahmad','Admin HR','lunas',NULL,'2026-07-29 08:59:31','2026-07-29 08:59:37',5,NULL,4,'2026-07-29 08:59:37',NULL,NULL,'bulanan'),(18,'September 2026','2026-08-29','2026-09-28',111111.00,'ahmad','Koordinator','lunas',NULL,'2026-07-29 08:59:31','2026-07-29 08:59:37',1,NULL,4,'2026-07-29 08:59:37',NULL,NULL,'bulanan'),(19,'September 2026','2026-08-29','2026-09-28',10000.00,'Koordinator Johen.Free Fire','Chief Executive Officer (CEO)','lunas',NULL,'2026-07-29 08:59:31','2026-07-29 08:59:37',2,NULL,4,'2026-07-29 08:59:37',NULL,NULL,'bulanan'),(20,'September 2026','2026-08-29','2026-09-28',10000.00,'Koordinator Johen.MLBB','General Manager (GM)','lunas',NULL,'2026-07-29 08:59:31','2026-07-29 08:59:37',3,NULL,4,'2026-07-29 08:59:37',NULL,NULL,'bulanan'),(21,'September 2026','2026-08-29','2026-09-28',10000.00,'ahmad','Admin HR','lunas',NULL,'2026-07-29 08:59:31','2026-07-29 08:59:37',5,NULL,4,'2026-07-29 08:59:37',NULL,NULL,'bulanan'),(22,'Oktober 2026','2026-09-29','2026-10-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:37','2026-07-29 08:59:47',2,NULL,4,'2026-07-29 08:59:47',NULL,NULL,'bulanan'),(23,'Oktober 2026','2026-09-29','2026-10-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:37','2026-07-29 08:59:47',3,NULL,4,'2026-07-29 08:59:47',NULL,NULL,'bulanan'),(24,'Oktober 2026','2026-09-29','2026-10-28',1111.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:37','2026-07-29 08:59:47',NULL,NULL,4,'2026-07-29 08:59:47',NULL,NULL,'bulanan'),(25,'Oktober 2026','2026-09-29','2026-10-28',10000.00,'ahmad','Admin HR','lunas',NULL,'2026-07-29 08:59:37','2026-07-29 08:59:47',5,NULL,4,'2026-07-29 08:59:47',NULL,NULL,'bulanan'),(26,'Oktober 2026','2026-09-29','2026-10-28',111111.00,'ahmad','Koordinator','lunas',NULL,'2026-07-29 08:59:37','2026-07-29 08:59:47',1,NULL,4,'2026-07-29 08:59:47',NULL,NULL,'bulanan'),(27,'Oktober 2026','2026-09-29','2026-10-28',10000.00,'Koordinator Johen.Free Fire','Chief Executive Officer (CEO)','lunas',NULL,'2026-07-29 08:59:37','2026-07-29 08:59:47',2,NULL,4,'2026-07-29 08:59:47',NULL,NULL,'bulanan'),(28,'Oktober 2026','2026-09-29','2026-10-28',10000.00,'Koordinator Johen.MLBB','General Manager (GM)','lunas',NULL,'2026-07-29 08:59:37','2026-07-29 08:59:47',3,NULL,4,'2026-07-29 08:59:47',NULL,NULL,'bulanan'),(29,'Oktober 2026','2026-09-29','2026-10-28',10000.00,'ahmad','Admin HR','lunas',NULL,'2026-07-29 08:59:37','2026-07-29 08:59:47',5,NULL,4,'2026-07-29 08:59:47',NULL,NULL,'bulanan'),(30,'November 2026','2026-10-29','2026-11-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:47','2026-07-29 09:09:36',2,NULL,4,'2026-07-29 09:09:36',NULL,NULL,'bulanan'),(31,'November 2026','2026-10-29','2026-11-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:47','2026-07-29 09:09:36',3,NULL,4,'2026-07-29 09:09:36',NULL,NULL,'bulanan'),(32,'November 2026','2026-10-29','2026-11-28',1111.00,NULL,NULL,'lunas',NULL,'2026-07-29 08:59:47','2026-07-29 09:09:36',NULL,NULL,4,'2026-07-29 09:09:36',NULL,NULL,'bulanan'),(33,'November 2026','2026-10-29','2026-11-28',10000.00,'ahmad','IT Staff','lunas','2026-07-29','2026-07-29 08:59:47','2026-07-29 09:09:36',5,16,4,'2026-07-29 09:09:36','payment-bukti/2AonzxBEYxXNLOoRLnBuGqLAyQeelu61LV6mW8Hx.jpg',NULL,'bulanan'),(34,'November 2026','2026-10-29','2026-11-28',111111.00,'ahmad','IT Staff','lunas','2026-07-29','2026-07-29 08:59:47','2026-07-29 09:09:36',1,16,4,'2026-07-29 09:09:36','payment-bukti/PbJkMsNP8aZZLDgloPmAUCpUg3RsasYDpfUGAu49.jpg',NULL,'bulanan'),(35,'November 2026','2026-10-29','2026-11-28',10000.00,'Koordinator Johen.Free Fire','Chief Executive Officer (CEO)','lunas',NULL,'2026-07-29 08:59:47','2026-07-29 09:09:36',2,NULL,4,'2026-07-29 09:09:36',NULL,NULL,'bulanan'),(36,'November 2026','2026-10-29','2026-11-28',10000.00,'Koordinator Johen.MLBB','General Manager (GM)','lunas',NULL,'2026-07-29 08:59:47','2026-07-29 09:09:36',3,NULL,4,'2026-07-29 09:09:36',NULL,NULL,'bulanan'),(37,'November 2026','2026-10-29','2026-11-28',10000.00,'ahmad','Admin HR','lunas',NULL,'2026-07-29 08:59:47','2026-07-29 08:59:55',5,NULL,4,'2026-07-29 08:59:55',NULL,NULL,'bulanan'),(38,'Desember 2026','2026-11-29','2026-12-28',10000.00,'ahmad','IT Staff','lunas','2026-07-29','2026-07-29 08:59:55','2026-07-29 09:09:36',5,16,4,'2026-07-29 09:09:36','payment-bukti/lRcsUSnusO9A77UXmWAGt7SdpYhPT7HRwSB1zjGK.png',NULL,'bulanan'),(39,'Desember 2026','2026-11-29','2026-12-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 09:09:36','2026-07-29 09:09:46',2,NULL,4,'2026-07-29 09:09:46',NULL,NULL,'bulanan'),(40,'Desember 2026','2026-11-29','2026-12-28',10000.00,NULL,NULL,'lunas',NULL,'2026-07-29 09:09:36','2026-07-29 09:10:23',3,NULL,4,'2026-07-29 09:10:23',NULL,NULL,'bulanan'),(41,'Desember 2026','2026-11-29','2026-12-28',1111.00,NULL,NULL,'lunas',NULL,'2026-07-29 09:09:36','2026-07-29 09:10:17',NULL,NULL,4,'2026-07-29 09:10:17',NULL,NULL,'bulanan'),(42,'Desember 2026','2026-11-29','2026-12-28',10000.00,'ahmad','IT Staff','lunas',NULL,'2026-07-29 09:09:36','2026-07-29 09:10:10',5,NULL,4,'2026-07-29 09:10:10',NULL,NULL,'bulanan'),(43,'Desember 2026','2026-11-29','2026-12-28',111111.00,'ahmad','IT Staff','lunas',NULL,'2026-07-29 09:09:36','2026-07-29 09:10:04',1,NULL,4,'2026-07-29 09:10:04',NULL,NULL,'bulanan'),(44,'Desember 2026','2026-11-29','2026-12-28',10000.00,'Koordinator Johen.Free Fire','Chief Executive Officer (CEO)','lunas',NULL,'2026-07-29 09:09:36','2026-07-29 09:10:00',2,NULL,4,'2026-07-29 09:10:00',NULL,NULL,'bulanan'),(45,'Desember 2026','2026-11-29','2026-12-28',10000.00,'Koordinator Johen.MLBB','General Manager (GM)','lunas',NULL,'2026-07-29 09:09:36','2026-07-29 09:09:57',3,NULL,4,'2026-07-29 09:09:57',NULL,NULL,'bulanan'),(46,'Januari 2027','2026-12-29','2027-01-28',10000.00,'ahmad','IT Staff','lunas',NULL,'2026-07-29 09:09:36','2026-07-29 09:09:52',5,NULL,4,'2026-07-29 09:09:52',NULL,NULL,'bulanan');
/*!40000 ALTER TABLE `pembayaran_aset_digital` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_aset_mes`
--

DROP TABLE IF EXISTS `pembayaran_aset_mes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran_aset_mes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aset_mes_id` bigint unsigned DEFAULT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','jatuh_tempo','lunas','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` date DEFAULT NULL,
  `requested_by` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayaran_aset_mes_aset_mes_id_foreign` (`aset_mes_id`),
  KEY `pembayaran_aset_mes_requested_by_foreign` (`requested_by`),
  KEY `pembayaran_aset_mes_approved_by_foreign` (`approved_by`),
  CONSTRAINT `pembayaran_aset_mes_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_aset_mes_aset_mes_id_foreign` FOREIGN KEY (`aset_mes_id`) REFERENCES `aset_mes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_aset_mes_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_aset_mes`
--

LOCK TABLES `pembayaran_aset_mes` WRITE;
/*!40000 ALTER TABLE `pembayaran_aset_mes` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran_aset_mes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_aset_saya`
--

DROP TABLE IF EXISTS `pembayaran_aset_saya`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran_aset_saya` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aset_saya_id` bigint unsigned DEFAULT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','jatuh_tempo','lunas','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` date DEFAULT NULL,
  `requested_by` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayaran_aset_daya_requested_by_foreign` (`requested_by`),
  KEY `pembayaran_aset_daya_approved_by_foreign` (`approved_by`),
  KEY `pembayaran_aset_saya_aset_saya_id_foreign` (`aset_saya_id`),
  CONSTRAINT `pembayaran_aset_daya_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_aset_daya_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_aset_saya_aset_saya_id_foreign` FOREIGN KEY (`aset_saya_id`) REFERENCES `aset_saya` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_aset_saya`
--

LOCK TABLES `pembayaran_aset_saya` WRITE;
/*!40000 ALTER TABLE `pembayaran_aset_saya` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran_aset_saya` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_aset_tim`
--

DROP TABLE IF EXISTS `pembayaran_aset_tim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran_aset_tim` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aset_tim_id` bigint unsigned DEFAULT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','jatuh_tempo','lunas','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` date DEFAULT NULL,
  `requested_by` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayaran_aset_tim_aset_tim_id_foreign` (`aset_tim_id`),
  KEY `pembayaran_aset_tim_requested_by_foreign` (`requested_by`),
  KEY `pembayaran_aset_tim_approved_by_foreign` (`approved_by`),
  CONSTRAINT `pembayaran_aset_tim_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_aset_tim_aset_tim_id_foreign` FOREIGN KEY (`aset_tim_id`) REFERENCES `aset_tim` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_aset_tim_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_aset_tim`
--

LOCK TABLES `pembayaran_aset_tim` WRITE;
/*!40000 ALTER TABLE `pembayaran_aset_tim` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran_aset_tim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_ipl_ruko`
--

DROP TABLE IF EXISTS `pembayaran_ipl_ruko`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran_ipl_ruko` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `requested_by` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  PRIMARY KEY (`id`),
  KEY `pembayaran_ipl_ruko_requested_by_foreign` (`requested_by`),
  KEY `pembayaran_ipl_ruko_approved_by_foreign` (`approved_by`),
  KEY `idx_ipl_status_jatuh` (`status`,`jatuh_tempo`),
  CONSTRAINT `pembayaran_ipl_ruko_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_ipl_ruko_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_ipl_ruko`
--

LOCK TABLES `pembayaran_ipl_ruko` WRITE;
/*!40000 ALTER TABLE `pembayaran_ipl_ruko` DISABLE KEYS */;
INSERT INTO `pembayaran_ipl_ruko` VALUES (1,'Januari 2026','2026-01-30','2026-01-22',1700000.00,'Admin Master','Admin GA','lunas','2026-07-23','2026-07-23 02:53:52','2026-07-23 09:06:10',1,4,'2026-07-23 09:06:10','payment-bukti/EVTZ3hjhWiGIbUtzoJ9UaKBdGrW6akGU47V3XduO.png',NULL,'bulanan'),(2,'Februari 2026','2026-02-28','2026-02-22',1700000.00,'Admin Master','Admin HR','lunas','2026-07-23','2026-07-23 02:53:52','2026-07-23 09:06:10',1,4,'2026-07-23 09:06:10','payment-bukti/lTeDgoiwEzF3pllFWi7D6Z2hMX7ECnCNeWmzDHvH.png',NULL,'bulanan'),(3,'Maret 2026','2026-03-30','2026-03-22',1700000.00,'Admin Master','Admin GA','lunas','2026-07-23','2026-07-23 02:53:52','2026-07-23 09:06:10',1,4,'2026-07-23 09:06:10','payment-bukti/qu2cHtisuIgSXQZqP5hRn6jTk2IrMwI03vFDcDYH.png',NULL,'bulanan'),(4,'April 2026','2026-04-30','2026-04-22',1700000.00,'Admin Master','Admin GA','lunas','2026-07-23','2026-07-23 02:53:52','2026-07-23 09:06:10',1,4,'2026-07-23 09:06:10','payment-bukti/Lad8STp1RJgKsXR6gXvmEF8tMcbfRcMQKkTstQqL.png',NULL,'bulanan'),(5,'Mei 2026','2026-05-30','2026-05-22',1700000.00,'Admin Master','Admin GA','lunas','2026-07-23','2026-07-23 02:53:52','2026-07-23 09:06:10',1,4,'2026-07-23 09:06:10','payment-bukti/cVhJWwNYtF7MLCTIH66QlqtCpepZA1PhCObs2VtQ.png',NULL,'bulanan'),(6,'Juni 2026','2026-06-30','2026-06-22',1700000.00,'Admin Master','Admin GA','lunas','2026-07-23','2026-07-23 02:53:52','2026-07-23 09:06:10',1,4,'2026-07-23 09:06:10','payment-bukti/k6N1vZ2QE7xHe9BnCkH7cd3Dtdr9SFRNVh8E579v.png',NULL,'bulanan'),(7,'Juli 2026','2026-07-30','2026-07-22',1700000.00,'Admin Master','Admin GA','lunas','2026-07-23','2026-07-23 02:53:52','2026-07-23 09:06:10',1,4,'2026-07-23 09:06:10','payment-bukti/rAbEDvSCv0HV9j7xSBFuKYFyZEdIgsELp5yGIPdG.png',NULL,'bulanan'),(8,'Agustus 2026','2026-08-30','2026-08-22',1700000.00,NULL,NULL,'menunggu',NULL,'2026-07-23 02:53:52','2026-07-23 02:53:52',NULL,NULL,NULL,NULL,NULL,'bulanan'),(9,'September 2026','2026-09-30','2026-09-22',1700000.00,NULL,NULL,'menunggu',NULL,'2026-07-23 02:53:52','2026-07-23 02:53:52',NULL,NULL,NULL,NULL,NULL,'bulanan'),(10,'Oktober 2026','2026-10-30','2026-10-22',1700000.00,NULL,NULL,'menunggu',NULL,'2026-07-23 02:53:52','2026-07-23 02:53:52',NULL,NULL,NULL,NULL,NULL,'bulanan'),(11,'November 2026','2026-11-30','2026-11-22',1700000.00,NULL,NULL,'menunggu',NULL,'2026-07-23 02:53:52','2026-07-23 02:53:52',NULL,NULL,NULL,NULL,NULL,'bulanan'),(12,'Desember 2026','2026-12-30','2026-12-22',1700000.00,NULL,NULL,'menunggu',NULL,'2026-07-23 02:53:52','2026-07-23 02:53:52',NULL,NULL,NULL,NULL,NULL,'bulanan'),(13,'Agustus 2026','2026-08-30','2026-08-22',1700000.00,'Admin Master','Admin GA','rejected',NULL,'2026-07-23 09:06:10','2026-07-24 01:13:26',NULL,1,'2026-07-24 01:13:26',NULL,'0','bulanan');
/*!40000 ALTER TABLE `pembayaran_ipl_ruko` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peralatan_kantor`
--

DROP TABLE IF EXISTS `peralatan_kantor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peralatan_kantor` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int unsigned NOT NULL DEFAULT '1',
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
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `atasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_atasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peralatan_kantor_kode_aset_unique` (`kode_aset`),
  UNIQUE KEY `peralatan_kantor_barcode_unique` (`barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=1668 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peralatan_kantor`
--

LOCK TABLES `peralatan_kantor` WRITE;
/*!40000 ALTER TABLE `peralatan_kantor` DISABLE KEYS */;
INSERT INTO `peralatan_kantor` VALUES (1153,'123','JSAPer63',NULL,'Sikat',1,'-','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',30000.00,-196,365,82.19,13841.25,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1154,'32','JSAAtk3',NULL,'Buku Folio @200lembar',2,'Biru, kuning','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Besar',35000.00,-196,90,388.89,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1155,'31','JSAAtk2',NULL,'Sticky notes besar',1,'Pink, hijau','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Besar',20000.00,-196,60,333.33,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1156,'21','JSAAtk1',NULL,'Penggaris besi',1,'Silver','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',10000.00,-196,60,166.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1157,'20','JSAAtk6',NULL,'Pensil',12,'Hitam','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',42000.00,-196,60,700.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1158,'23','JSAAtk4',NULL,'Tip X basah',1,'Merah','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',11000.00,-196,60,183.33,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1159,'24','JSAAtk5',NULL,'Tip X kering',1,'Hitam','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',6000.00,-196,60,100.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1160,'26','JSAAtk7',NULL,'Serutan',1,'Biru','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',5000.00,-196,365,13.70,2306.88,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1161,'27','JSAAtk8',NULL,'Sticky notes kecil',1,'Kuning, hijau, pink','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',17500.00,-196,60,291.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1162,'28','JSAAtk9',NULL,'Penanda buku',1,'Merah, orange, pink, kuning, hijau, neon, cyan, biru dan ungu','Atk (Alat tulis kantor)','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,60,250.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1163,'10','JSABag1',NULL,'Saklar lampu 2',3,'Putih','Bagunan','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1825,54.79,89227.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1164,'135','JSABag2',NULL,'Keran air',2,'-','Bagunan','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,1095,136.99,123068.75,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1165,'138','JSABag3',NULL,'Cermin',1,'-','Bagunan','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2025,'2026-01-01','Kecil','Sedang',100000.00,-196,1825,54.79,89227.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1166,'8','JSABag12',NULL,'Saklar lampu 1',2,'Putih','Bagunan','Bagus','Lantai 1','Ruang Operasional 1','Perusahaan',2026,'2026-01-01','Kecil','Kecil',76000.00,-196,1825,41.64,67812.90,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1167,'11','JSABag5',NULL,'Saklar lampu 2',2,'Putih','Bagunan','Berfungsi 1 tombol','Lantai 1','Ruang Operasional 1','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1825,54.79,89227.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1168,'143','JSABag6',NULL,'Wc duduk',1,'Putih','Bagunan','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2025,'2026-01-01','Sedang','Sedang',600000.00,-196,2920,205.48,559603.13,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1169,'144','JSABag7',NULL,'Shower',1,'Putih','Bagunan','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2025,'2026-01-01','Sedang','Kecil',400000.00,-196,1460,273.97,346137.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1170,'145','JSABag8',NULL,'Bidet toilet',1,'Silver','Bagunan','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2025,'2026-01-01','Kecil','Kecil',500000.00,-196,1460,342.47,432671.88,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1171,'149','JSABag9',NULL,'Wastafel',1,'Putih','Bagunan','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Sedang',600000.00,-196,2920,205.48,559603.13,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1172,'155','JSABag10',NULL,'Saklar lampu 1',4,'Putih','Bagunan','2 tidak berfungsi','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Kecil','Kecil',76000.00,-196,1825,41.64,67812.90,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1173,'156','JSABag11',NULL,'Saklar lampu 2',2,'Putih','Bagunan','Tidak Berfungsi','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Kecil','Kecil',100000.00,-196,1825,54.79,89227.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1174,'7','JSABag21',NULL,'Saklar lampu 1',1,'Putih','Bagunan','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',76000.00,-196,1825,41.64,67812.90,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1175,'41','JSABag14',NULL,'Kaca besar',1,'Bening','Bagunan','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Besar',2000000.00,-196,1825,1095.89,1784550.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1176,'157','JSABag29',NULL,'Lampu LED',3,'Putih','Bagunan','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Kecil','Besar',16400000.00,-196,1460,11232.88,14191637.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1177,'72','JSABag16',NULL,'Lampu TL',2,'Putih','Bagunan','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Besar',150000.00,-196,1460,102.74,129801.56,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1178,'160','JSABag30',NULL,'Stop kontak',4,'Putih, 6 colokan','Bagunan','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Kecil','Kecil',100000.00,-196,1460,68.49,86534.38,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1179,'181','JSABag31',NULL,'Stop kontak',3,'Putih','Bagunan','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1460,68.49,86534.38,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1180,'250','JSABag32',NULL,'Lampu LED',6,'Putih','Bagunan','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,1460,34.25,43267.19,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1181,'298','JSABag33',NULL,'Lampu TL',1,'Putih','Bagunan','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Besar',80000.00,-196,1460,54.79,69227.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1182,'323','JSABag34',NULL,'Stop kontak',2,'Putih, 5 colokan','Bagunan','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',200000.00,-196,1460,136.99,173068.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1183,'42','JSABag23',NULL,'Kaca sedang',1,'Bening','Bagunan','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Sedang',1500000.00,-196,1825,821.92,1338412.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1184,'338','JSABag35',NULL,'Saklar lampu 1',1,'Putih','Bagunan','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',76000.00,-196,1825,41.64,67812.90,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1185,'343','JSABag36',NULL,'Lampu TL',1,'Putih','Bagunan','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Kecil','Besar',80000.00,-196,1460,54.79,69227.50,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1186,'394','JSABag37',NULL,'Shower',1,'Putih','Bagunan','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Kecil',400000.00,-196,1825,219.18,356910.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1187,'395','JSABag38',NULL,'Bidet toilet',1,'Silver','Bagunan','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,1460,34.25,43267.19,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1188,'398','JSABag39',NULL,'Wastafel',1,'Putih','Bagunan','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Besar','Sedang',600000.00,-196,2920,205.48,559603.12,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1189,'399','JSABag40',NULL,'Cermin',1,'Clear','Bagunan','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Besar','Sedang',100000.00,-196,1825,54.79,89227.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1190,'400','JSABag41',NULL,'Saklar lampu 1',7,'Putih','Bagunan','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',76000.00,-196,1825,41.64,67812.90,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1191,'401','JSABag42',NULL,'Saklar lampu 2',2,'Putih','Bagunan','Bagus','Lantai 3','Ruang Operasional 3','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1825,54.79,89227.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1192,'406','JSABag43',NULL,'Lampu LED',4,'Putih','Bagunan','Bagus','Lantai 3','Ruang Operasional 3','Perusahaan',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,1460,34.25,43267.19,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1193,'437','JSABag45',NULL,'Stop kontak',10,'Putih','Bagunan','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1460,68.49,86534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1194,'438','JSABag46',NULL,'Lampu TL',18,'Putih','Bagunan','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Besar',80000.00,-196,1460,54.79,69227.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1195,'448','JSABag47',NULL,'Meja',2,'Coklat Muda','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',200000.00,-196,2920,68.49,186534.37,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1196,'449','JSABag48',NULL,'Meja',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',200000.00,-196,2920,68.49,186534.37,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1197,'450','JSABag49',NULL,'Kursi',3,'Coklat Muda','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',300000.00,-196,1825,164.38,267682.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1198,'451','JSABag50',NULL,'Kursi',5,'Coklat Tua','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',300000.00,-196,1825,164.38,267682.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1199,'452','JSABag51',NULL,'Kursi plastik',2,'Biru','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',100000.00,-196,1825,54.79,89227.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1200,'453','JSABag52',NULL,'Kursi',1,'Coklat','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',300000.00,-196,1825,164.38,267682.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1201,'454','JSABag53',NULL,'Kursi',1,'Abu','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',300000.00,-196,1825,164.38,267682.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1202,'455','JSABag54',NULL,'Lemari Pantry',1,'Hitam Marble','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',700000.00,-196,1095,639.27,574320.83,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1203,'529','JSABag55',NULL,'Handrail',1,'Hitam','Bagunan','Bagus','Lantai 2','Tangga','Ruko',2026,'2026-01-01','Besar','Besar',500000.00,-196,4000,125.00,475425.23,'Muhammad Rafly Firdaus','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1204,'531','JSABag56',NULL,'Saklar',2,'Putih','Bagunan','Bagus','Lantai 2','Ruang Kreatif','Ruko',2026,'2026-01-01','Kecil','Sedang',40000.00,-196,1820,21.98,35679.16,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1205,'532','JSABag57',NULL,'Shower',1,'Putih','Bagunan','Bagus','Lantai 2','Toilet','Ruko',2026,'2026-01-01','Besar','Sedang',500000.00,-196,3650,136.99,473068.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1206,'533','JSABag58',NULL,'Wastafel',1,'Putih','Bagunan','Bagus','Lantai 2','Toilet','Ruko',2026,'2026-01-01','Besar','Sedang',350000.00,-196,3650,95.89,331148.12,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1207,'534','JSABag59',NULL,'Lampu Bulat Toilet',1,'Putih','Bagunan','Bagus','Lantai 2','Toilet','Ruko',2026,'2026-01-01','Kecil','Kecil',30000.00,-196,1460,20.55,25960.31,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1208,'535','JSABag60',NULL,'WC Duduk',1,'Putih','Bagunan','Bagus','Lantai 2','Toilet','Ruko',2026,'2026-01-01','Besar','Besar',1000000.00,-196,3650,273.97,946137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1209,'536','JSABag61',NULL,'Lampu Bulat',3,'Putih','Bagunan','Bagus','Lantai 2','Lantai 2','Ruko',2026,'2026-01-01','Kecil','Kecil',30000.00,-196,1460,20.55,25960.31,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1210,'537','JSABag62',NULL,'Lampu Bulat',2,'Putih','Bagunan','Bagus','Lantai 2','Ruang Tengah','Ruko',2026,'2026-01-01','Kecil','Kecil',30000.00,-196,1460,20.55,25960.31,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1211,'538','JSABag63',NULL,'Lampu Bulat',1,'Putih','Bagunan','Bagus','Lantai 2','Area Tangga','Ruko',2026,'2026-01-01','Kecil','Kecil',30000.00,-196,1460,20.55,25960.31,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1212,'540','JSABag64',NULL,'Stop Kontak Schneider',3,'Putih','Bagunan','Bagus','Lantai 2','Ruang Admin','Ruko',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,1460,34.25,43267.19,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1213,'541','JSABag65',NULL,'Stop Kontak',1,'Putih','Bagunan','Bagus','Lantai 3','Tangga Lantai 3','Ruko',2026,'2026-01-01','Kecil','Kecil',25000.00,-196,1460,17.12,21633.59,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1214,'542','JSABag66',NULL,'Closet Duduk',1,'Putih','Bagunan','Bagus','Lantai 3','Toilet','Ruko',2026,'2026-01-01','Besar','Besar',1000000.00,-196,3650,273.97,946137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1215,'543','JSABag67',NULL,'Shower',1,'Putih','Bagunan','Bagus','Lantai 3','Toilet','Ruko',2026,'2026-01-01','Besar','Sedang',500000.00,-196,3650,136.99,473068.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1216,'544','JSABag68',NULL,'Wastafel',1,'Putih','Bagunan','Bagus','Lantai 3','Toilet','Ruko',2026,'2026-01-01','Besar','Besar',350000.00,-196,3650,95.89,331148.12,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1217,'545','JSABag69',NULL,'Saklar Live',3,'Putih','Bagunan','Bagus','Lantai 3','Ruang Live 1 Lantai 3','Ruko',2026,'2026-01-01','Kecil','Kecil',40000.00,-196,1820,21.98,35679.16,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1218,'546','JSABag70',NULL,'Stop Kontak Schneider',3,'Putih','Bagunan','Bagus','Lantai 3','Ruang Live 3','Ruko',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,1460,34.25,43267.19,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1219,'547','JSABag71',NULL,'Stop Kontak',1,'Putih','Bagunan','Bagus','Lantai 3','Ruang Live 4 Serbaguna','Ruko',2026,'2026-01-01','Kecil','Kecil',25000.00,-196,1460,17.12,21633.59,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1220,'548','JSABag72',NULL,'Stop Kontak',1,'Putih','Bagunan','Bagus','Lantai 3','Ruang Live Mobile Legend','Ruko',2026,'2026-01-01','Kecil','Kecil',25000.00,-196,1460,17.12,21633.59,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1221,'549','JSABag73',NULL,'Stop Kontak',1,'Putih','Bagunan','Bagus','Lantai 3','Ruang Live PUBG','Ruko',2026,'2026-01-01','Kecil','Kecil',25000.00,-196,1460,17.12,21633.59,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1222,'550','JSABag74',NULL,'Stop Kontak',1,'Putih','Bagunan','Bagus','Lantai 3','Ruang Admin','Ruko',2026,'2026-01-01','Kecil','Kecil',25000.00,-196,1460,17.12,21633.59,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1223,'551','JSABag75',NULL,'Stop Kontak',1,'Putih','Bagunan','Bagus','Lantai 3','Ruang Live 3','Ruko',2026,'2026-01-01','Kecil','Kecil',25000.00,-196,1460,17.12,21633.59,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1224,'552','JSABag76',NULL,'Tangga Darurat',1,'Hitam','Bagunan','Bagus','Lantai 3','Gudang','Ruko',2026,'2026-01-01','Besar','Besar',350000.00,-196,1950,179.49,314713.16,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1225,'584','JSABag77',NULL,'Stop kontak',1,'Putih, 1 colokan','Bagunan','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1460,68.49,86534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1226,'439','JSAKen1',NULL,'Motor Scoopy',1,'Biru','Kendaraan','Bagus','Kantor','Kantor','Perusahaan',2024,'2026-01-01','Besar','Besar',17000000.00,-196,1825,9315.07,15168675.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1227,'440','JSAKen2',NULL,'Motor Vario',1,'Hitam','Kendaraan','Bagus','Kantor','Kantor','Perusahaan',2026,'2026-01-01','Besar','Besar',16000000.00,-196,1825,8767.12,14276400.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1228,'558','JSAKen3',NULL,'Motor CBR',1,'Hitam','Kendaraan','Kurang Bagus','Kantor','Kantor','Perusahaan',2026,'2026-05-30','Besar','Besar',28000000.00,-47,1825,15342.47,27269727.39,'Pamungkas Chris Hermanto','Head Of Store Manager','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1229,'559','JSAKen4',NULL,'Motor Skywave',1,'Hitam','Kendaraan','Bagus','Kantor','Kantor','Perusahaan',2026,'2026-03-04','Besar','Besar',17000000.00,-134,1825,9315.07,15746209.24,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1230,'560','JSAKen5',NULL,'Motor Aerox',1,'Navy-Hitam','Kendaraan','Kurang Bagus','Kantor','Kantor','Perusahaan',2026,'2026-05-12','Besar','Besar',28300000.00,-65,1825,15506.85,27282779.75,'Rinaldo Pardomuan Sinaga','Head Of Store Manager','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1231,'15','JSAPer10',NULL,'Stop kontak',1,'Putih, 5 colokan','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,1460,34.25,43267.19,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1232,'174','JSAPer100',NULL,'Meja Zulfa',1,'Putih cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1233,'175','JSAPer101',NULL,'Meja Adel',1,'Putih cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Della Adelia Zahra','Video Editor MLBB','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1234,'176','JSAPer102',NULL,'Meja Fathir',1,'Putih cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Abdillah Azka Al-Fathir','Design Grafis','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1235,'177','JSAPer103',NULL,'Stop kontak',8,'Putih, 5 colokan','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Kecil','Kecil',42000.00,-196,1460,28.77,36344.44,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1236,'179','JSAPer105',NULL,'Stop kontak',4,'Putih, 3 colokan','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Kecil','Kecil',27000.00,-196,1460,18.49,23364.28,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1237,'565','JSAPer106',NULL,'Stop kontak',4,'Putih, 6 Colokan','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-01-01','Kecil','Kecil',51000.00,-196,1460,34.93,44132.53,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1238,'183','JSAPer108',NULL,'Kalender meja',7,'Biru, cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,365,136.99,23068.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1239,'185','JSAPer109',NULL,'PC Fiki Sugiana',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',15000000.00,-196,1825,8219.18,13384124.99,'Fiki Sugiana','Admin Record MLBB','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1240,'37','JSAPer11',NULL,'Meja resepsionis',1,'Biru, putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Besar',1200000.00,-196,2920,410.96,1119206.25,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1241,'186','JSAPer110',NULL,'PC Adelia',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',15000000.00,-196,1825,8219.18,13384124.99,'Della Adelia Zahra','Video Editor MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1242,'187','JSAPer111',NULL,'PC Fathir',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',15000000.00,-196,1825,8219.18,13384124.99,'Abdillah Azka Al-Fathir','Design Grafis','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1243,'188','JSAPer112',NULL,'PC Reza',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Besar',15000000.00,-196,1825,8219.18,13384124.99,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1244,'189','JSAPer113',NULL,'PC Suci',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Besar',15000000.00,-196,1825,8219.18,13384124.99,'Suci Muptiah Ajahra','Admin Pagi Monkey & Dex','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1245,'190','JSAPer114',NULL,'PC belum dipakai',1,'-','Peralatan kantor','Bagus','Lantai 2','Ruang IT','Perusahaan',2026,'2026-01-01','Besar','Besar',15000000.00,-196,1825,8219.18,13384124.99,'Suci Muptiah Ajahra','Host Live Gameplay + Worker Joki MLBB','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1246,'191','JSAPer115',NULL,'PC Julian',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',15000000.00,-196,1825,8219.18,13384124.99,'Julian Hardi Winata','Host Live Gameplay + Worker Joki MLBB','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1247,'192','JSAPer116',NULL,'PC Destya',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Besar',15000000.00,-196,1825,8219.18,13384124.99,'Destya Marsya Susanti','Admin Pagi Johen PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1248,'194','JSAPer117',NULL,'Keyboard Julian',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Kecil',250000.00,-196,1460,171.23,216335.94,'Julian Hardi Winata','Host Live Gameplay + Worker Joki MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1249,'195','JSAPer118',NULL,'Keyboard Adel',1,'Hitam','Peralatan kantor','Huruf A eror','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',250000.00,-196,1460,171.23,216335.94,'Della Adelia Zahra','Video Editor MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1250,'196','JSAPer119',NULL,'Keyboard Fathir',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',250000.00,-196,1460,171.23,216335.94,'Abdillah Azka Al-Fathir','Design Grafis','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1251,'16','JSAPer31',NULL,'Mixer',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Sedang',500000.00,-196,1825,273.97,446137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1252,'38','JSAPer12',NULL,'Tempat tisu',1,'Abu muda','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Sedang',20000.00,-196,1095,18.26,16409.17,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1253,'197','JSAPer120',NULL,'Keyboard Fiki Sugiana',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',250000.00,-196,1460,171.23,216335.94,'Fiki Sugiana','Admin Record MLBB','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1254,'198','JSAPer121',NULL,'Keyboard Destya',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Kecil',250000.00,-196,1460,171.23,216335.94,'Destya Marsya Susanti','Admin Pagi Johen PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1255,'199','JSAPer122',NULL,'Keyboard Suci',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Kecil',250000.00,-196,1460,171.23,216335.94,'Suci Muptiah Ajahra','Admin Pagi Monkey & Dex','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1256,'200','JSAPer123',NULL,'Keyboard Reza',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Kecil',250000.00,-196,1460,171.23,216335.94,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1257,'202','JSAPer124',NULL,'Monitor Adel',1,'Black','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Della Adelia Zahra','Video Editor MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1258,'203','JSAPer125',NULL,'Monitor Fathir',1,'Black','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Abdillah Azka Al-Fathir','Design Grafis','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1259,'204','JSAPer126',NULL,'Monitor Fiki Sugiana',1,'Black','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Fiki Sugiana','Admin Record MLBB','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1260,'205','JSAPer127',NULL,'Monitor Suci',1,'Black','Peralatan kantor','Kendala tidak bisa save record akun','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Destya Marsya Susanti','Admin Pagi Monkey & Dex','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1261,'206','JSAPer128',NULL,'Monitor Julian',1,'Black','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Suci Muptiah Ajahra','Host Live Gameplay + Worker Joki MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1262,'207','JSAPer129',NULL,'Monitor Destya',1,'Black','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Reza Virgi Herviana','Admin Pagi Johen PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1263,'39','JSAPer13',NULL,'Set sofa',1,'Abu','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Besar',7000000.00,-196,2920,2397.26,6528703.12,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1264,'208','JSAPer130',NULL,'Monitor Reza',1,'Black','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Della Adelia Zahra','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1265,'210','JSAPer131',NULL,'Xr Fiki Sugiana',1,'Yellow','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2024,'2024-01-02','Besar','Kecil',5000000.00,-926,1460,3424.66,1826718.74,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1266,'211','JSAPer132',NULL,'Xr Regi',1,'Red','Peralatan kantor','Port USB longgar','Lantai 2','Ruang Operasional 2','Perusahaan',2024,'2024-01-03','Besar','Kecil',5000000.00,-925,1460,3424.66,1830143.40,'Suci Muptiah Ajahra','Admin Record PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1267,'212','JSAPer133',NULL,'Xr Reza',1,'Black','Peralatan kantor','Ghost touch, Full storage','Lantai 2','Ruang Admin','Perusahaan',2024,'2024-01-04','Besar','Kecil',5000000.00,-924,1460,3424.66,1833568.06,'Julian Hardi Winata','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1268,'213','JSAPer134',NULL,'Xr Agnia',1,'Orange','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2024,'2024-01-05','Besar','Kecil',5000000.00,-923,1460,3424.66,1836992.72,'Destya Marsya Susanti','Admin KOL/Talent','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1269,'214','JSAPer135',NULL,'Xr Destia',1,'Blue','Peralatan kantor','Ghost touch','Lantai 2','Ruang Admin','Perusahaan',2024,'2024-01-06','Besar','Kecil',5000000.00,-922,1460,3424.66,1840417.37,'Reza Virgi Herviana','Admin Pagi Johen PUBG','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1270,'215','JSAPer136',NULL,'Xr Destia',1,'White','Peralatan kantor','Ghost touch, LCD rusak','Lantai 2','Ruang Admin','Perusahaan',2024,'2024-01-07','Besar','Kecil',5000000.00,-921,1460,3424.66,1843842.03,'Destya Marsya Susanti','Admin Pagi Johen PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1271,'216','JSAPer137',NULL,'Xiaomi pad 6',1,'-','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Besar','Sedang',4000000.00,-196,1460,2739.73,3461374.99,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1272,'217','JSAPer138',NULL,'Xs',1,'Gold, grey','Peralatan kantor','Grey pecah LCD','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Besar','Kecil',5000000.00,-196,1460,3424.66,4326718.74,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1273,'218','JSAPer139',NULL,'Xs max',1,'gold','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',5000000.00,-196,1460,3424.66,4326718.74,'Rizki Ramdani','Content Creator','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1274,'40','JSAPer14',NULL,'Meja kecil',1,'Hitam marble','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Kecil',300000.00,-196,2920,102.74,279801.56,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1275,'220','JSAPer140',NULL,'Ip 11 promax',1,'Midnight green','Peralatan kantor','Storage terlalu kecil dan sering kena banned','Lantai 2','GM-Room','Perusahaan',2025,'2025-01-01','Besar','Kecil',4000000.00,-561,1095,3652.97,1948499.99,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Yuliana Sventy Yasmine Aulhia Sugiat','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1276,'221','JSAPer141',NULL,'Ip 11 promax Suci',1,'Midnight green','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2025-01-02','Besar','Kecil',4000000.00,-560,1095,3652.97,1952152.96,'Suci Muptiah Ajahra','Admin Pagi Monkey & Dex','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1277,'222','JSAPer142',NULL,'Ip 12',1,'Biru','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Besar','Kecil',4000000.00,-196,1095,3652.97,3281833.33,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1278,'223','JSAPer143',NULL,'Infinix GT 20 pro',1,'Abu Abu','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2024,'2026-01-01','Besar','Kecil',1000000.00,-196,1095,913.24,820458.33,'Abdillah Azka Al-Fathir','Design Grafis','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1279,'225','JSAPer144',NULL,'Charger iPhone Fiki',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',285000.00,-196,365,780.82,131491.87,'Fiki Sugiana','Admin Record MLBB','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1280,'226','JSAPer145',NULL,'Charger iPhone Fiki',1,'Putih','Peralatan kantor','Kabel mengelupas','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',285000.00,-196,365,780.82,131491.87,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1281,'227','JSAPer146',NULL,'Charger iPhone Destya',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',299000.00,-196,365,819.18,137951.12,'Destya Marsya Susanti','Admin Pagi Johen PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1282,'228','JSAPer147',NULL,'Charger iPhone Agnia',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',285000.00,-196,365,780.82,131491.87,'Agnia Sasa Fadilah','Admin KOL/Talent','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1283,'229','JSAPer148',NULL,'Adaptor',1,'Butuh kabel charger','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2025,'2026-01-01','Besar','Kecil',140000.00,-196,1095,127.85,114864.17,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1284,'230','JSAPer149',NULL,'Kulkas',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',3000000.00,-196,2920,1027.40,2798015.62,'Yuga Redisa Maulana','Office Boy','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1285,'45','JSAPer15',NULL,'Speaker',2,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',750000.00,-196,1825,410.96,669206.25,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1286,'231','JSAPer150',NULL,'Gelas kecil',6,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',54000.00,-196,1095,49.32,44304.75,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1287,'232','JSAPer151',NULL,'Mug',2,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',66000.00,-196,1095,60.27,54150.25,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1288,'233','JSAPer152',NULL,'Gelas bar',6,'Bening','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',46000.00,-196,1095,42.01,37741.08,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1289,'238','JSAPer153',NULL,'Tutup gelas',2,'Biru','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',24000.00,-196,365,65.75,11073.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1290,'239','JSAPer154',NULL,'Lap',3,'Putih, hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,60,250.00,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1291,'240','JSAPer155',NULL,'Sendok',1,'Silver','Peralatan kantor','Bagus','Lantai 1','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',18000.00,-196,1460,12.33,15576.19,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1292,'241','JSAPer156',NULL,'Garpu',1,'Silver','Peralatan kantor','Bagus','Lantai 1','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',18000.00,-196,1460,12.33,15576.19,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1293,'242','JSAPer157',NULL,'Pisau',1,'Silver','Peralatan kantor','Bagus','Lantai 1','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',18000.00,-196,730,24.66,13152.37,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1294,'243','JSAPer158',NULL,'Toples kaca',3,'Bening','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',21000.00,-196,1460,14.38,18172.22,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1295,'244','JSAPer159',NULL,'Nampan',2,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Sedang',25000.00,-196,1095,22.83,20511.46,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1296,'48','JSAPer16',NULL,'AC',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Sedang',8200000.00,-196,2920,2808.22,7647909.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1297,'245','JSAPer160',NULL,'Termos',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Sedang',150000.00,-196,1825,82.19,133841.25,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1298,'246','JSAPer161',NULL,'Dispenser',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Pantry 2','Perusahaan',2025,'2026-01-01','Besar','Besar',1500000.00,-196,1460,1027.40,1298015.62,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1299,'247','JSAPer162',NULL,'Kulkas',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Besar','Besar',3000000.00,-196,2920,1027.40,2798015.62,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1300,'248','JSAPer163',NULL,'Kursi plastik',1,'Biru','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Sedang',50000.00,-196,1825,27.40,44613.75,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1301,'249','JSAPer164',NULL,'Cctv',3,'Putih','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Kecil',1000000.00,-196,1825,547.95,892275.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1302,'252','JSAPer165',NULL,'Mouse pad Adel',1,'Red blue','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,730,136.99,73068.75,'Della Adelia Zahra','Video Editor MLBB','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1303,'253','JSAPer166',NULL,'Mouse pad Fathir',1,'Black','Peralatan kantor','Kurang bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-02','Kecil','Kecil',100000.00,-195,730,136.99,73205.74,'Abdillah Azka Al-Fathir','Design Grafis','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1304,'254','JSAPer167',NULL,'Mouse pad Suci',1,'Grey','Peralatan kantor','Kurang bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-03','Kecil','Kecil',100000.00,-194,730,136.99,73342.72,'Suci Muptiah Ajahra','Admin Pagi Monkey & Dex','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1305,'255','JSAPer168',NULL,'Mouse pad Reza',1,'BW','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-04','Kecil','Kecil',100000.00,-193,730,136.99,73479.71,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1306,'256','JSAPer169',NULL,'Mouse pad Fiki',1,'Black','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Sedang',100000.00,-196,730,136.99,73068.75,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1307,'49','JSAPer17',NULL,'Remote AC',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Kecil',285000.00,-196,1095,260.27,233830.62,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1308,'258','JSAPer170',NULL,'Mouse pad kecil Suci',1,'Pink','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,730,205.48,109603.12,'Suci Muptiah Ajahra','Admin Pagi Monkey & Dex','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1309,'259','JSAPer171',NULL,'Mouse pad kecil Reza',1,'Dark grey','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,730,205.48,109603.12,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1310,'260','JSAPer172',NULL,'Mouse pad kecil Reza',1,'Black','Peralatan kantor','Kurang bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,730,205.48,109603.12,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1311,'261','JSAPer173',NULL,'Mouse pad kecil Destya',1,'Blue','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,730,205.48,109603.12,'Destya Marsya Susanti','Admin Pagi Johen PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1312,'262','JSAPer174',NULL,'Mouse pad kecil Adel',1,'Pink','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,730,205.48,109603.12,'Della Adelia Zahra','Video Editor MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1313,'263','JSAPer175',NULL,'Mouse pad kecil Fiki Sugiana',1,'Blue black','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,730,205.48,109603.12,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1314,'264','JSAPer176',NULL,'Mouse pad kecil Julian',1,'Black Prooftech','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',10000.00,-196,730,13.70,7306.87,'Julian Hardi Winata','Host Live Gameplay + Worker Joki MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1315,'265','JSAPer177',NULL,'Mouse pad kecil Pak Nando',1,'Blue','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,730,205.48,109603.12,'Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1316,'266','JSAPer178',NULL,'Mic',1,'Hitam HyperX','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Kecil',500000.00,-196,1460,342.47,432671.87,'Julian Hardi Winata','Host Live Gameplay + Worker Joki MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1317,'268','JSAPer179',NULL,'Mouse Adel',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',70000.00,-196,1095,63.93,57432.08,'Della Adelia Zahra','Video Editor MLBB','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1318,'50','JSAPer18',NULL,'Cctv',2,'Putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Kecil',650000.00,-196,1825,356.16,579978.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1319,'269','JSAPer180',NULL,'Mouse Fathir',1,'Hitam','Peralatan kantor','Kurang bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',70000.00,-196,1095,63.93,57432.08,'Abdillah Azka Al-Fathir','Design Grafis','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1320,'270','JSAPer181',NULL,'Mouse Fiki Sugiana',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',70000.00,-196,1095,63.93,57432.08,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1321,'271','JSAPer182',NULL,'Mouse Destya',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Sedang','Kecil',330000.00,-196,1095,301.37,270751.25,'Destya Marsya Susanti','Admin Pagi Johen PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1322,'272','JSAPer183',NULL,'Mouse Suci',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Sedang','Kecil',175000.00,-196,1095,159.82,143580.21,'Suci Muptiah Ajahra','Admin Pagi Monkey & Dex','Rinaldo Pardomuan Sinaga','Host Live Gameplay + Worker Joki MLBB','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1323,'273','JSAPer184',NULL,'Mouse Julian',1,'Hitam Rexus','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Kecil',0.00,-196,1095,0.00,0.00,'Julian Hardi Winata','Host Live Gameplay + Worker Joki MLBB','Julian Hardi Winata',NULL,'baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1324,'274','JSAPer185',NULL,'Mouse Reza',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Sedang','Kecil',175000.00,-196,1095,159.82,143580.21,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1325,'275','JSAPer186',NULL,'Pengki',1,'Merah','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Sedang',32500.00,-196,730,44.52,23747.34,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1326,'276','JSAPer187',NULL,'Wifi',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',500000.00,-196,1825,273.97,446137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1327,'278','JSAPer188',NULL,'Speaker Fiki Sugiana',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',130000.00,-196,1825,71.23,115995.75,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1328,'279','JSAPer189',NULL,'Speaker Fathir',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',130000.00,-196,1825,71.23,115995.75,'Abdillah Azka Al-Fathir','Design Grafis','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1329,'52','JSAPer19',NULL,'Keset Kecil',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Sedang',50000.00,-196,365,136.99,23068.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1330,'280','JSAPer190',NULL,'Speaker Reza',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Sedang','Kecil',130000.00,-196,1825,71.23,115995.75,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1331,'281','JSAPer191',NULL,'Wireless mic set',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',2009000.00,-196,1825,1100.82,1792580.47,'Rizki Ramdani','Content Creator','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1332,'283','JSAPer192',NULL,'Headphone Destya',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Sedang','Sedang',210000.00,-196,730,287.67,153444.37,'Destya Marsya Susanti','Admin Pagi Johen PUBG','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1333,'284','JSAPer193',NULL,'Headphone Reza',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Sedang','Sedang',210000.00,-196,730,287.67,153444.37,'Reza Virgi Herviana','Admin Pagi Johen MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1334,'285','JSAPer194',NULL,'Headphone Suci',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Sedang','Sedang',210000.00,-196,730,287.67,153444.37,'Suci Muptiah Ajahra','Admin Pagi Monkey & Dex','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1335,'286','JSAPer195',NULL,'Headphone Fathir',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Sedang',210000.00,-196,730,287.67,153444.37,'Abdillah Azka Al-Fathir','Design Grafis','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1336,'287','JSAPer196',NULL,'Headphone Adel',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Sedang',210000.00,-196,730,287.67,153444.37,'Della Adelia Zahra','Video Editor MLBB','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1337,'288','JSAPer197',NULL,'Headphone Aghni',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Sedang',210000.00,-196,730,287.67,153444.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1338,'289','JSAPer198',NULL,'Tempat tisu',1,'Abu','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Sedang',28000.00,-196,1095,25.57,22972.83,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1339,'290','JSAPer199',NULL,'Keset bulu',1,'Abu, pink','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Sedang',35000.00,-196,365,95.89,16148.12,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1340,'53','JSAPer20',NULL,'Keset Besar',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Sedang',50000.00,-196,365,136.99,23068.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1341,'291','JSAPer200',NULL,'Rak baju',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Besar',65000.00,-196,1825,35.62,57997.87,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1342,'292','JSAPer201',NULL,'Rak sepatu',1,'Silver','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Sedang',50000.00,-196,1825,27.40,44613.75,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1343,'293','JSAPer202',NULL,'Kapstok',2,'Coklat','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,60,250.00,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1344,'294','JSAPer203',NULL,'Microtik',2,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',500000.00,-196,1825,273.97,446137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1345,'295','JSAPer204',NULL,'Stand Hp',1,'Pink','Peralatan kantor','Perlu ganti','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',60000.00,-196,1825,32.88,53536.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1346,'296','JSAPer205',NULL,'Ac',1,'Putih','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Besar','Sedang',8200000.00,-196,2920,2808.22,7647909.36,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1347,'297','JSAPer206',NULL,'Remote AC',1,'Putih','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Besar','Kecil',285000.00,-196,1095,260.27,233830.62,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1348,'299','JSAPer207',NULL,'Tong sampah kecil',3,'Abu','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',23600.00,-196,1460,16.16,20422.11,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1349,'300','JSAPer208',NULL,'Kursi',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Sedang','Sedang',1200000.00,-196,1825,657.53,1070730.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1350,'302','JSAPer209',NULL,'Box file besar',1,'Cyan','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Besar',38000.00,-196,1460,26.03,32883.06,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1351,'55','JSAPer21',NULL,'Tong sampah kecil',1,'Biru','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Sedang','Kecil',23600.00,-196,1460,16.16,20422.11,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1352,'303','JSAPer210',NULL,'Map dokumen',1,'Biru','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Besar','Sedang',34000.00,-196,60,566.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1353,'304','JSAPer211',NULL,'Double tip extra kuat',1,'Hijau','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',10000.00,-196,60,166.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1354,'305','JSAPer212',NULL,'Double tip kertas',1,'Putih','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',6000.00,-196,60,100.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1355,'306','JSAPer213',NULL,'Selotip',1,'Putih','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',10000.00,-196,60,166.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1356,'307','JSAPer214',NULL,'Gunting',1,'Clear','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',30000.00,-196,60,500.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1357,'308','JSAPer215',NULL,'Lever file',1,'Abu muda','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',80000.00,-196,60,1333.33,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1358,'309','JSAPer216',NULL,'Map coklat',5,'Coklat','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',10000.00,-196,60,166.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1359,'310','JSAPer217',NULL,'Glossy photo paper',1,'A4','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Sedang',70000.00,-196,60,1166.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1360,'311','JSAPer218',NULL,'Map kertas',2,'Biru','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Sedang',40000.00,-196,60,666.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1361,'312','JSAPer219',NULL,'Folder file',2,'Biru','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Sedang',8000.00,-196,60,133.33,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1362,'56','JSAPer22',NULL,'Tong sampah besar',1,'Abu','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Sedang','Besar',150000.00,-196,1460,102.74,129801.56,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1363,'313','JSAPer220',NULL,'Pelubang kertas',1,'Biru','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,60,250.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1364,'314','JSAPer221',NULL,'Stapler',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',66000.00,-196,60,1100.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1365,'315','JSAPer222',NULL,'Staples',1,'Silver','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',7000.00,-196,60,116.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1366,'316','JSAPer223',NULL,'Cutter',1,'Merah','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',20000.00,-196,60,333.33,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1367,'317','JSAPer224',NULL,'Tinta',4,'Hitam, kuning, magenta, cyan','Peralatan kantor','Habis','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',380000.00,-196,60,6333.33,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1368,'318','JSAPer225',NULL,'HVS',1,'A4','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Sedang',55000.00,-196,60,916.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1369,'319','JSAPer226',NULL,'Binder clip sedang',1,'Hitam, 25mm','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Sedang',8000.00,-196,60,133.33,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1370,'320','JSAPer227',NULL,'Binder clip besar',1,'Hitam, 32mm','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Besar',15000.00,-196,60,250.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1371,'321','JSAPer228',NULL,'Amplop polos',1,'Putih','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',24000.00,-196,60,400.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1372,'322','JSAPer229',NULL,'Lemari dokumen',1,'Hitam cream','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Besar',500000.00,-196,1460,342.47,432671.87,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1373,'57','JSAPer23',NULL,'Lampu sorot',4,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',250000.00,-196,1460,171.23,216335.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1374,'324','JSAPer230',NULL,'Stop kontak',1,'Putih, 3 colokan','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',32000.00,-196,1460,21.92,27691.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1375,'325','JSAPer231',NULL,'PC',2,'Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Besar','Besar',13000000.00,-196,1825,7123.29,11599574.97,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1376,'326','JSAPer232',NULL,'Webcam',5,'Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Besar','Kecil',2500000.00,-196,1460,1712.33,2163359.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1377,'327','JSAPer233',NULL,'Keyboard',2,'Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Besar','Kecil',269000.00,-196,1460,184.25,232777.47,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1378,'328','JSAPer234',NULL,'Mouse pad kecil',3,'Pink, Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Sedang','Kecil',179000.00,-196,730,245.21,130793.06,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1379,'329','JSAPer235',NULL,'Mouse',2,'Putih, Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Sedang','Kecil',527000.00,-196,1095,481.28,432381.54,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1380,'330','JSAPer236',NULL,'Paper clip',1,'50mm','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',10500.00,-196,60,175.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1381,'331','JSAPer237',NULL,'Permanen marker',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',12000.00,-196,60,200.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1382,'332','JSAPer238',NULL,'White board marker',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Sedang','Kecil',10000.00,-196,1825,5.48,8922.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1383,'333','JSAPer239',NULL,'Sticky notes sedang',1,'Kuning, hijau, pink','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Sedang',17500.00,-196,60,291.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1384,'70','JSAPer24',NULL,'PC',1,'Hitam','Peralatan kantor','Belum dites','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Besar',13000000.00,-196,1825,7123.29,11599574.97,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1385,'334','JSAPer240',NULL,'Correction tape',2,'Hitam','Peralatan kantor','1 masih baru','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',22000.00,-196,60,366.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1386,'335','JSAPer241',NULL,'Pulpen',2,'Hitam, Biru','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,60,833.33,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1387,'336','JSAPer242',NULL,'Sticky notes besar',1,'Pink, kuning, orange','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Besar',17500.00,-196,60,291.67,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1388,'337','JSAPer243',NULL,'Kalender meja',2,'Biru','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',48000.00,-196,365,131.51,22146.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1389,'339','JSAPer244',NULL,'Monitor Cctv',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Besar',1500000.00,-196,1825,821.92,1338412.50,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1390,'340','JSAPer245',NULL,'Server cctv',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Sedang',3000000.00,-196,1825,1643.84,2676824.99,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1391,'341','JSAPer246',NULL,'Laptop ROG',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1392,'342','JSAPer247',NULL,'Cctv',1,'Putih','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Kecil',1000000.00,-196,1825,547.95,892275.00,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1393,'344','JSAPer248',NULL,'Remote AC',1,'Putih','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Kecil',285000.00,-196,1095,260.27,233830.62,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1394,'345','JSAPer249',NULL,'Kursi',2,'Hitam','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Sedang',1200000.00,-196,1825,657.53,1070730.00,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1395,'71','JSAPer25',NULL,'Kabel HDMI',1,'Hitam','Peralatan kantor','Belum dites','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Kecil',180000.00,-196,1095,164.38,147682.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1396,'346','JSAPer250',NULL,'Sofa panjang',1,'Abu','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1397,'347','JSAPer251',NULL,'Meja kerja',1,'Hitam Cream','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Besar',2700000.00,-196,2920,924.66,2518214.06,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1398,'348','JSAPer252',NULL,'Tong sampah kecil',1,'Abu Hitam','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Sedang','Kecil',23600.00,-196,1460,16.16,20422.11,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1399,'349','JSAPer253',NULL,'Tempat akrilik 1',1,'Clear','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',40000.00,-196,1460,27.40,34613.75,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1400,'350','JSAPer254',NULL,'Gunting',1,'Hijau','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',6000.00,-196,1460,4.11,5192.06,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1401,'351','JSAPer255',NULL,'Minibar set',1,'Meja bar, lemari atas bawah','Peralatan kantor','Bagus','Lantai 3','Pantry 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,1825,273.97,446137.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1402,'352','JSAPer256',NULL,'Tong sampah kecil',4,'Abu Hitam','Peralatan kantor','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Sedang','Kecil',23600.00,-196,1460,16.16,20422.11,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1403,'353','JSAPer257',NULL,'Tong sampah sedang',1,'Biru','Peralatan kantor','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Sedang','Besar',47000.00,-196,1460,32.19,40671.16,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1404,'355','JSAPer258',NULL,'Meja kerja Monkey & Dex',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',2700000.00,-196,2920,924.66,2518214.06,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1405,'356','JSAPer259',NULL,'Meja kerja MLBB JOHEN',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',2700000.00,-196,2920,924.66,2518214.06,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1406,'357','JSAPer260',NULL,'Meja kerja PUBG JOHEN',2,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',2700000.00,-196,2920,924.66,2518214.06,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1407,'359','JSAPer261',NULL,'Meja kerja ROBLOX',2,'Cream & Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',2700000.00,-196,2920,924.66,2518214.06,'Albert Christian Simanungkalit','End to end Roblox','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1408,'360','JSAPer262',NULL,'Meja tamu',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Sedang',500000.00,-196,2920,171.23,466335.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1409,'361','JSAPer263',NULL,'Meja kecil',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Kecil',300000.00,-196,2920,102.74,279801.56,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1410,'362','JSAPer264',NULL,'Sofa besar',1,'Biru','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1411,'363','JSAPer265',NULL,'Lemari dokumen',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,0,0,500000.00,0.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1412,'366','JSAPer266',NULL,'PC Monkey & Dex',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',10000000.00,-196,1825,5479.45,8922749.98,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1413,'367','JSAPer267',NULL,'PC PUBG JOHEN',1,'Hitam LEXA GAMING','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',10000000.00,-196,1825,5479.45,8922749.98,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1414,'368','JSAPer268',NULL,'PC MLBB JOHEN',1,'Hitam LEXA GAMING','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',10000000.00,-196,1825,5479.45,8922749.98,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1415,'369','JSAPer269',NULL,'PC ROBLOX',1,'Putih HOSE','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',10000000.00,-196,1825,5479.45,8922749.98,'Albert Christian Simanungkalit','End to end Roblox','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1416,'75','JSAPer27',NULL,'Monitor',1,'Hitam','Peralatan kantor','Belum dites','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Sedang',10000000.00,-196,1825,5479.45,8922749.98,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1417,'371','JSAPer270',NULL,'Monitor Monkey & Dex',1,'Putih LENOVO','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,1825,273.97,446137.50,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1418,'372','JSAPer271',NULL,'Monitor MLBB JOHEN',1,'Hitam ACER','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,1825,273.97,446137.50,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1419,'373','JSAPer272',NULL,'Monitor PUBG JOHEN',1,'Hitam LG','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,1825,273.97,446137.50,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1420,'374','JSAPer273',NULL,'Monitor PUBG JOHEN',1,'Hitam Xiaomi','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,1825,273.97,446137.50,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1421,'375','JSAPer274',NULL,'Monitor Lounge',1,'Hitam SAMSUNG','Peralatan kantor','Belum dites','Lantai 3','Staff Lounge','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,1825,273.97,446137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1422,'376','JSAPer275',NULL,'Monitor Roblox',1,'Abu LENOVO','Peralatan kantor','Bagus','Lantai 3','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,1825,273.97,446137.50,'Albert Christian Simanungkalit','End to end Roblox','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1423,'378','JSAPer276',NULL,'Keboard Monkey & Dex',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Sedang',200000.00,-196,1460,136.99,173068.75,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1424,'379','JSAPer277',NULL,'Keyboard MLBB JOHEN',1,'Putih RED DRAGON','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Sedang',200000.00,-196,1460,136.99,173068.75,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1425,'380','JSAPer278',NULL,'Keyboard PUBG JOHEN',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Sedang',200000.00,-196,1460,136.99,173068.75,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1426,'381','JSAPer279',NULL,'Keyboard PUBG JOHEN',1,'Hitam Abu','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Sedang',200000.00,-196,1460,136.99,173068.75,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1427,'77','JSAPer28',NULL,'Absen',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Ruang Operasional 1','Perusahaan',2026,'2026-01-01','Besar','Kecil',10000000.00,-196,1460,6849.32,8653437.47,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1428,'382','JSAPer280',NULL,'Keyboard ROBLOX',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Sedang',200000.00,-196,1460,136.99,173068.75,'Albert Christian Simanungkalit','End to end Roblox','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1429,'383','JSAPer281',NULL,'Keyboard ROBLOX',1,'Hitam Abu','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Sedang',200000.00,-196,1460,136.99,173068.75,'Albert Christian Simanungkalit','End to end Roblox','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1430,'385','JSAPer282',NULL,'Laptop ASUS PUBG JOHEN',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Sedang',10000000.00,-196,1825,5479.45,8922749.97,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1431,'386','JSAPer283',NULL,'Laptop ASUS MLBB JOHEN',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Sedang',10000000.00,-196,1825,5479.45,8922749.97,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1432,'387','JSAPer284',NULL,'Laptop ASUS PUBG MONKEY',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Sedang',10000000.00,-196,1825,5479.45,8922749.97,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1433,'388','JSAPer285',NULL,'AC',14,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Sedang',10000000.00,-196,2920,3424.66,9326718.73,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1434,'389','JSAPer286',NULL,'Nampan',3,'Putih','Peralatan kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Kecil','Sedang',40000.00,-196,1095,36.53,32818.33,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1435,'391','JSAPer287',NULL,'Ember',1,'Biru','Peralatan kantor','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Sedang',45000.00,-196,1095,41.10,36920.62,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1436,'392','JSAPer288',NULL,'Gayung',1,'Hijau','Peralatan kantor','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Sedang','Kecil',16000.00,-196,730,21.92,11691.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1437,'396','JSAPer289',NULL,'Sikat wc',1,'Biru','Peralatan kantor','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Kecil',40000.00,-196,365,109.59,18455.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1438,'78','JSAPer29',NULL,'Electronic Ballast',4,'Abu muda','Peralatan kantor','Belum dites','Lantai 1','Ruang Operasional 1','Perusahaan',2026,'2026-01-01','Besar','Kecil',100000.00,-196,1460,68.49,86534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1439,'397','JSAPer290',NULL,'Kapstok',1,'Coklat','Peralatan kantor','Bagus','Lantai 3','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,60,250.00,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1440,'402','JSAPer291',NULL,'Cctv',9,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',1000000.00,-196,1825,547.95,892275.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1441,'403','JSAPer292',NULL,'Stop kontak',5,'Putih, 5 colokan','Peralatan kantor','Bagus','Lantai 3','Ruang Operasional 3','Perusahaan',2026,'2026-01-01','Kecil','Besar',42000.00,-196,1460,28.77,36344.44,'Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1442,'404','JSAPer293',NULL,'Stop kontak',1,'Putih, 4 lubang','Peralatan kantor','Bagus','Lantai 3','Ruang Operasional 3','Perusahaan',2026,'2026-01-01','Kecil','Kecil',35000.00,-196,1460,23.97,30287.03,'Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1443,'405','JSAPer294',NULL,'Stop kontak',1,'Putih, 3 lubang','Peralatan kantor','Bagus','Lantai 3','Ruang Operasional 3','Perusahaan',2026,'2026-01-01','Kecil','Sedang',27000.00,-196,1460,18.49,23364.28,'Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1444,'407','JSAPer295',NULL,'Meja dokumen',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang IT','Perusahaan',2026,'2026-01-01','Besar','Besar',50000.00,-196,2920,17.12,46633.59,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1445,'408','JSAPer296',NULL,'Set sofa',1,'1 kursi double, 1 sofa panjang','Peralatan kantor','Bagus','Lantai 3','GM-Room','Perusahaan',2026,'2026-01-01','Besar','Besar',3000000.00,-196,2920,1027.40,2798015.62,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1446,'409','JSAPer297',NULL,'Tangga',1,'Silver orange','Peralatan kantor','Bagus','Lantai 3','Gudang','Perusahaan',2026,'2026-01-01','Besar','Besar',1900000.00,-196,1825,1041.10,1695322.49,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1447,'410','JSAPer298',NULL,'Router',2,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang IT','Perusahaan',2026,'2026-01-01','Sedang','Kecil',350000.00,-196,1825,191.78,312296.25,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1448,'411','JSAPer299',NULL,'Stand tv',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Staff Lounge','Perusahaan',2026,'2026-01-01','Sedang','Besar',400000.00,-196,1825,219.18,356910.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1449,'413','JSAPer300',NULL,'Tripod webcam Monkey & Dex',1,'Hitam TAFF STUDIO BS300','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Kecil',250000.00,-196,1460,171.23,216335.94,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1450,'414','JSAPer301',NULL,'Tripod webcam MLBB JOHEN',1,'Hitam TNW','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Kecil',200000.00,-196,1460,136.99,173068.75,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1451,'415','JSAPer302',NULL,'Tripod webcam PUBG JOHEN',1,'Hitam INBEX','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Kecil',200000.00,-196,1460,136.99,173068.75,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1452,'416','JSAPer303',NULL,'Webcam Monkey & Dex',1,'Hitam LOGITECH','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Kecil',1500000.00,-196,1460,1027.40,1298015.62,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1453,'417','JSAPer304',NULL,'Webcam MLBB JOHEN',1,'Hitam LOGITECH','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Kecil',1500000.00,-196,1460,1027.40,1298015.62,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1454,'418','JSAPer305',NULL,'Webcam PUBG JOHEN',1,'Hitam LOGITECH','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Kecil',1500000.00,-196,1460,1027.40,1298015.62,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1455,'420','JSAPer306',NULL,'Speaker Monkey & Dex',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',130000.00,-196,1825,71.23,115995.75,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1456,'421','JSAPer307',NULL,'Speaker MLBB JOHEN',1,'Hitam NEMESIS','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',280000.00,-196,1825,153.42,249837.00,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1457,'422','JSAPer308',NULL,'Speaker ROBLOX',1,'Putih NEMESIS','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',280000.00,-196,1825,153.42,249837.00,'Albert Christian Simanungkalit','End to end Roblox','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1458,'423','JSAPer309',NULL,'Speaker PUBG JOHEN',1,'Hitam NEMESIS','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',280000.00,-196,1825,153.42,249837.00,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1459,'424','JSAPer310',NULL,'Speaker PUBG JOHEN',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',130000.00,-196,1825,71.23,115995.75,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1460,'425','JSAPer311',NULL,'Mouse Monkey & Dex',1,'LOGITECH','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',200000.00,-196,1095,182.65,164091.67,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1461,'426','JSAPer312',NULL,'Mouse MLBB JOHEN',1,'LOGITECH','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',200000.00,-196,1095,182.65,164091.67,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1462,'427','JSAPer313',NULL,'Mouse PUBG JOHEN',1,'Hitam LOGITECH','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',250000.00,-196,1095,228.31,205114.58,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1463,'428','JSAPer314',NULL,'Mouse ROBLOX',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Kecil',200000.00,-196,1095,182.65,164091.67,'Albert Christian Simanungkalit','End to end Roblox','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1464,'429','JSAPer315',NULL,'IPAD Monkey & Dex',1,'Grey','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Sedang',5000000.00,-196,1095,4566.21,4102291.64,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1465,'430','JSAPer316',NULL,'IPAD MLBB JOHEN',1,'Grey','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Sedang',5000000.00,-196,1095,4566.21,4102291.64,'Mohamad Rafli Bahtiar','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1466,'431','JSAPer317',NULL,'IPAD PUBG JOHEN',1,NULL,'Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Sedang',5000000.00,-196,1095,4566.21,4102291.64,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1467,'432','JSAPer318',NULL,'Mic Monkey & Dex',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Kecil',500000.00,-196,1460,342.47,432671.87,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1468,'433','JSAPer319',NULL,'Mic PUBG JOHEN',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Kecil',500000.00,-196,1460,342.47,432671.87,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1469,'81','JSAPer32',NULL,'Loker',40,'Abu','Peralatan kantor','Bagus','Lantai 1','Ruang Operasional 1','Perusahaan',2026,'2026-01-01','Besar','Besar',11700000.00,-196,1825,6410.96,10439617.46,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1470,'434','JSAPer320',NULL,'Mic MLBB JOHEN',1,'Hitam HyperX','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Kecil',500000.00,-196,1460,342.47,432671.87,'Albert Christian Simanungkalit','Host Live MLBB (pagi)','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1471,'435','JSAPer321',NULL,'Lighting PUBG JOHEN',1,'Hitam Putih MIXIO PL36','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Sedang',400000.00,-196,1460,273.97,346137.50,'Fathan Muhamad Fauzan','Host Live PUBG (siang)','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1472,'436','JSAPer322',NULL,'Lighting ROBLOX',1,'Hitam Putih TNW LED11','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Kecil','Sedang',200000.00,-196,1460,136.99,173068.75,'Albert Christian Simanungkalit','End to end Roblox','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1473,'444','JSAPer324',NULL,'Tripod HP',1,'Putih','Peralatan kantor','Bagus','Lantai 2','HRD Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',150000.00,-196,1460,102.74,129801.56,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1474,'445','JSAPer325',NULL,'Remote AC',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Meeting Room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1460,68.49,86534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1475,'446','JSAPer326',NULL,'Lemari Penyimpanan',1,'Hitam Putih','Peralatan kantor','Bagus','Lantai 1','Ruang Operasional 1','Perusahaan',2026,'2026-01-01','Sedang','Sedang',900000.00,-196,1095,821.92,738412.49,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1476,'82','JSAPer33',NULL,'Wifi',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Kecil',500000.00,-196,1825,273.97,446137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1477,'456','JSAPer336',NULL,'Mangkok',2,'Biru','Peralatan Kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Kecil','Kecil',24000.00,-196,1095,21.92,19691.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1478,'457','JSAPer337',NULL,'Piring',1,'Coklat','Peralatan Kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Kecil','Kecil',20000.00,-196,1460,13.70,17306.87,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1479,'458','JSAPer338',NULL,'Piring',7,'Hitam','Peralatan Kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Kecil','Kecil',200000.00,-196,1460,136.99,173068.75,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1480,'459','JSAPer339',NULL,'Gelas Mug',5,'Clear','Peralatan Kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,1095,13.70,12306.87,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1481,'83','JSAPer34',NULL,'Tempat akrilik 2',1,'Clear','Peralatan kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Kecil','Kecil',18500.00,-196,1095,16.89,15178.48,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1482,'460','JSAPer340',NULL,'Sapu',1,NULL,'Peralatan Kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,730,20.55,10960.31,'Yuga Redisa Maulana','Office Boy','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1483,'461','JSAPer341',NULL,'Keyboard',1,'Navy - Taro Switch','Peralatan Kantor','Bagus','Lantai 2','Admin Transaksi','Perusahaan',2026,'2026-01-01','Besar','Kecil',150000.00,-196,1460,102.74,129801.56,'Kornelius Adrian','Koordinator Admin','Rinaldo Pardomuan Sinaga','Head of Store Manager','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1484,'462','JSAPer342',NULL,'Kabel USB C to USB C',1,'Hitam','Peralatan Kantor','Bagus','Lantai 3','IT','Perusahaan',2026,'2026-06-14','Kecil','Kecil',65000.00,-32,1095,59.36,63064.95,'Ahmad Musyaddad Haury','Fullstack','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1485,'463','JSAPer343',NULL,'Kabel USB C to Lighting',1,'Hitam','Peralatan Kantor','Bagus','Lantai 3','IT','Perusahaan',2026,'2026-06-16','Kecil','Kecil',200000.00,-30,1095,182.65,194411.30,'Ahmad Musyaddad Haury','Fullstack','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1486,'464','JSAPer344',NULL,'Kabel USB',1,'Abu-abu','Peralatan Kantor','Bagus','Lantai 3','IT','Perusahaan',2026,'2026-06-16','Kecil','Kecil',50000.00,-30,1095,45.66,48602.83,'Ahmad Musyaddad Haury','Fullstack','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1487,'465','JSAPer345',NULL,'Tempat Tisu',1,'Coklat','Peralatan Kantor','Bagus','Lantai 2','Admin Stock','Perusahaan',2026,'2026-06-16','Kecil','Kecil',75000.00,-30,1095,68.49,72904.24,'Tasya Lutfiah','Koordinator Admin Stock','Pamungkas Chris Hermanto','Head of Store Manager','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1488,'466','JSAPer346',NULL,'Topeng Anonymous',2,'Metalic dan Putih','Peralatan kantor','Bagus','Lantai 2','Creative','Perusahaan',2026,'2026-06-16','Kecil','Kecil',15000.00,-30,100,150.00,10410.28,'Zulfa Rahamani','Koordinator Creative','Rinaldo Pardomuan Sinaga','Head of Store Manager','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1489,'467','JSAPer347',NULL,'Infinix Note Edge 5G',1,'Lunar Titanium','Peralatan kantor','Bagus','Lantai 3','Admin Transaksi','Perusahaan',2026,'2026-06-17','Besar','Sedang',380000.00,-29,1095,347.03,369728.50,'Kornelius Adrian','Koordinator Admin','Rinaldo Pardomuan Sinaga','Head of Store Manager','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1490,'468','JSAPer348',NULL,'Mic E-Football',1,'Hitam HyperX','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-06-17','Besar','Sedang',1500000.00,-29,1460,1027.40,1469590.96,'Mochamad Rizal Hanapi','Admin Johen Dexx dan Monkey','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1491,'469','JSAPer349',NULL,'Mouse Gaming Wireless',3,'Grey','Peralatan kantor','Bagus','Lantai 3','IT','Perusahaan',2026,'2026-06-17','Kecil','Kecil',117000.00,-29,1095,106.85,113837.46,'Ahmad Musyaddad Haury','Fullstack','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1492,'84','JSAPer35',NULL,'Set sofa',5,'Abu, 3 kursi besar & 2 kursi single','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Besar',3000000.00,-196,2920,1027.40,2798015.62,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1493,'470','JSAPer350',NULL,'Kepala Charger Ugreen',2,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-06-17','Kecil','Kecil',159000.00,-29,1095,145.21,154702.19,'Mochamad Rizal Hanapi','Admin Johen Dexx dan Monkey','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1494,'471','JSAPer351',NULL,'Kabel USB C to USB C',2,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-06-17','Kecil','Kecil',130000.00,-29,1095,118.72,126486.07,'Mochamad Rizal Hanapi','Admin Johen Dexx dan Monkey','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1495,'472','JSAPer352',NULL,'Modem Wifi Huawei',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-06-17','Besar','Kecil',1900000.00,-29,1095,1735.16,1848642.51,'Mochamad Rizal Hanapi','Admin Johen Dexx dan Monkey','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1496,'473','JSAPer353',NULL,'Doorlock Paloma',1,'Silver','Peralatan kantor','Bagus','Lantai 2','Admin Transaksi','Perusahaan',2026,'2026-06-17','Besar','Sedang',3400000.00,-29,1095,3105.02,3308097.13,'Kornelius Adrian','Koordinator Admin','Rinaldo Pardomuan Sinaga','Head of Store Manager','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1497,'474','JSAPer354',NULL,'Monitor Asus ZenScreen',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-06-17','Besar','Sedang',1866000.00,-29,1825,1022.47,1835736.92,'Gonzaga Gogo Silalahi','GM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1498,'475','JSAPer355',NULL,'Kursi Kerja',2,'Putih','Peralatan kantor','Bagus','Lantai 3','HSM Room','Perusahaan',2026,'2026-06-17','Besar','Besar',1358000.00,-29,1825,744.11,1335975.75,'Rinaldo Pardomuan Sinaga','HSM','Rinaldo Pardomuan Sinaga','Head of Store Manager','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1499,'476','JSAPer356',NULL,'Kursi Bar',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-06-17','Sedang','Sedang',359000.00,-29,1825,196.71,353177.68,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1500,'477','JSAPer357',NULL,'Kabel LAN 5 Meter',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','IT','Perusahaan',2026,'2026-06-17','Kecil','Kecil',52000.00,-29,1095,47.49,50594.43,'Ahmad Musyaddad Haury','Fullstack','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1501,'478','JSAPer358',NULL,'Kabel LAN 3 Meter',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','IT','Perusahaan',2026,'2026-06-17','Kecil','Kecil',40000.00,-29,1095,36.53,38918.79,'Ahmad Musyaddad Haury','Fullstack','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1502,'479','JSAPer359',NULL,'Patung Manekin Full Body',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-06-17','Sedang','Sedang',734000.00,-29,1460,502.74,719119.84,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1503,'85','JSAPer36',NULL,'Meja meeting',1,'Hitam coklat','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Besar',4200000.00,-196,2920,1438.36,3917221.87,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1504,'480','JSAPer360',NULL,'Stand TV',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','GM-Room','Perusahaan',2026,'2026-06-17','Sedang','Besar',570000.00,-29,1825,312.33,560755.65,'Gonzaga Gogo Silalahi','GM','Pamungkas Chris Hermanto','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1505,'481','JSAPer361',NULL,'Stand TV',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Creative','Perusahaan',2026,'2026-06-17','Sedang','Besar',570000.00,-29,1825,312.33,560755.65,'Zulfa Rahamani','Koordinator Creative','Pamungkas Chris Hermanto','Head of Store Manager','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1506,'483','JSAPer363',NULL,'Stand Ipad Amino',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Free Fire','Perusahaan',2026,'2026-06-22','Kecil','Kecil',80000.00,-24,1095,73.06,78202.88,'Mochamad Rizal Hanapi','Asisten Koor Free Fire','Pamungkas Chris Hermanto','Head of Store Manager','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1507,'485','JSAPer364',NULL,'Stand Ipad Amino',1,'Silver','Peralatan kantor','Bagus','Lantai 3','PUBG','Perusahaan',2026,'2026-06-22','Kecil','Kecil',80000.00,-24,1095,73.06,78202.88,'Muhammad Rafly Firdaus','Koordinator Johen PUBG','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1508,'487','JSAPer365',NULL,'Keset',3,'Putih-Ungu, Hijau, Orange','Peralatan kantor','Bagus','Lantai 2','Admin Stock','Perusahaan',2026,'2026-06-22','Kecil','Kecil',26099.00,-24,730,35.75,25219.57,'Fathan Muhamad Fauzan','Koordinator Admin Stock','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1509,'488','JSAPer366',NULL,'Tempat Sampah',1,'Abu-abu','Peralatan kantor','Bagus','Lantai 2','Admin Stock','Perusahaan',2026,'2026-06-22','Kecil','Kecil',43080.00,-24,1460,29.51,42354.19,'Tasya Lutfiah','Koordinator Admin Stock','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1510,'489','JSAPer367',NULL,'Mouse Pad',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','PUBG','Perusahaan',2026,'2026-06-22','Kecil','Kecil',36000.00,-24,1095,32.88,35191.29,'Tasya Lutfiah','Asisten Koor Free Fire','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1511,'490','JSAPer368',NULL,'Laptop Asus Vivobook (Seri T8N0SH00R457332)',1,'Silver','Peralatan kantor','Bagus','Lantai 2','Ruang HRGA','Perusahaan',2026,'2026-03-30','Besar','Sedang',8000000.00,-108,1825,4383.56,7523953.40,'Muhammad Rafly Firdaus','Human Source Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1512,'491','JSAPer369',NULL,'Asus Zenbook 14 UX3405CA',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang IT','Perusahaan',2026,'2026-03-25','Besar','Sedang',15000000.00,-113,1825,8219.18,14066316.73,'Yuliana Sventy Yasmine Aulhia Sugiat','Head Of Store Manager','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1513,'86','JSAPer37',NULL,'Meja',1,'Biru putih','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Besar',1000000.00,-196,2920,342.47,932671.87,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1514,'492','JSAPer370',NULL,'Asus Zenbook 14 UX3405CA',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang IT','Perusahaan',2026,'2026-03-30','Besar','Sedang',15000000.00,-108,1825,8219.18,14107412.62,'Rinaldo Pardomuan Sinaga','Head Of Store Manager','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1515,'493','JSAPer371',NULL,'Asus Vivobook',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang PUBG','Perusahaan',2026,'2026-03-30','Besar','Sedang',8000000.00,-108,1825,4383.56,7523953.40,'Pamungkas Chris Hermanto','Host Live JOHEN PUBG (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1516,'494','JSAPer372',NULL,'Asus Vivobook',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang MLBB','Perusahaan',2026,'2026-03-30','Besar','Sedang',8000000.00,-108,1825,4383.56,7523953.40,'Fathan Muhamad Fauzan','Host Live MLBB (sesi 1)','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1517,'495','JSAPer373',NULL,'Asus Vivobook',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang E-Football','Perusahaan',2026,'2026-03-30','Besar','Sedang',8000000.00,-108,1825,4383.56,7523953.40,'Mohamad Rafli Bahtiar','Koor&Host Live E-Football','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1518,'496','JSAPer374',NULL,'Asus Vivobook',1,'Silver','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-05-26','Besar','Sedang',8000000.00,-51,1825,4383.56,7773816.41,'Mochamad Rizal Hanapi','Koordinator Admin Stock','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1519,'497','JSAPer375',NULL,'Asus Vivobook Go E1504FA',1,'Abu-Abu','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-04-25','Besar','Sedang',8000000.00,-82,1825,4383.56,7637926.00,'Tasya Lutfiah Nur Azizah','Koordinator Admin','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1520,'498','JSAPer376',NULL,'Laptop HP (CNDO3417SL)',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Monkey PUBG','Perusahaan',2026,'2026-06-11','Besar','Sedang',5700000.00,-35,1825,3123.29,5588816.79,'Kornelius Adrian','Host Live Monkey PUBG (sesi 3)','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1521,'499','JSAPer377',NULL,'Laptop HP (seri CNDO3417KC)',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang PUBG','Perusahaan',2026,'2026-02-04','Besar','Sedang',5700000.00,-162,1825,3123.29,5192159.26,'Yogi Ginanjar','Host Live JOHEN PUBG (sesi 2)','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1522,'500','JSAPer378',NULL,'Asus Vivobook Go E1504FA',1,'Silver','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-01-01','Besar','Sedang',8000000.00,-196,1825,4383.56,7138199.97,'Muhamad Rafly Firdaus','Sosial Media Specialist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1523,'501','JSAPer379',NULL,'Laptop HP (Seri CND03417NQ)',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang HRGA','Perusahaan',2026,'2026-06-17','Besar','Sedang',5700000.00,-29,1825,3123.29,5607556.52,'Zulfa Rahmani','Admin GA','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1524,'94','JSAPer38',NULL,'Kursi',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Sedang',600000.00,-196,1825,328.77,535365.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1525,'502','JSAPer380',NULL,'Laptop HP (Seri CND03417NW)',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang HRGA','Perusahaan',2026,'2026-06-17','Besar','Sedang',5700000.00,-29,1825,3123.29,5607556.52,'Wanda Nabila Wening Katresna','Admin HR','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1526,'503','JSAPer381',NULL,'Tas Laptop',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang HRGA','Perusahaan',2026,'2026-03-30','Kecil','Kecil',30000.00,-108,1095,27.40,27024.71,'Ririn Nur Aini','Human Source Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1527,'504','JSAPer382',NULL,'Mouse',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang HRGA','Perusahaan',2026,'2026-03-30','Kecil','Kecil',60000.00,-108,1095,54.79,54049.42,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Source Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1528,'505','JSAPer383',NULL,'Charger Adaptor',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang HRGA','Perusahaan',2026,'2026-03-30','Sedang','Sedang',120000.00,-108,1095,109.59,108098.83,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Source Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1529,'506','JSAPer384',NULL,'Mousepad',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang HRGA','Perusahaan',2026,'2026-03-30','Kecil','Kecil',50000.00,-108,1095,45.66,45041.18,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Source Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1530,'507','JSAPer385',NULL,'Mouse',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Head Of Store Manager','Perusahaan',2026,'2026-03-25','Kecil','Kecil',60000.00,-113,1095,54.79,53775.44,'Yuliana Sventy Yasmine Aulhia Sugiat','Head Of Store Manager','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1531,'508','JSAPer386',NULL,'Mousepad',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Head Of Store Manager','Perusahaan',2026,'2026-03-25','Kecil','Kecil',50000.00,-113,1095,45.66,44812.87,'Rinaldo Pardomuan Sinaga','Head Of Store Manager','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1532,'509','JSAPer387',NULL,'Tas Laptop',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Head Of Store Manager','Perusahaan',2026,'2026-03-25','Kecil','Kecil',30000.00,-113,1095,27.40,26887.72,'Rinaldo Pardomuan Sinaga','Head Of Store Manager','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1533,'510','JSAPer388',NULL,'Charger',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Head Of Store Manager','Perusahaan',2026,'2026-03-25','Sedang','Sedang',120000.00,-113,1095,109.59,107550.89,'Rinaldo Pardomuan Sinaga','Head Of Store Manager','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1534,'511','JSAPer389',NULL,'Mouse',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang PUBG','Perusahaan',2026,'2026-03-30','Kecil','Kecil',60000.00,-108,1095,54.79,54049.42,'Rinaldo Pardomuan Sinaga','Host Live JOHEN PUBG (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1535,'95','JSAPer39',NULL,'Cctv',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Kecil',650000.00,-196,1825,356.16,579978.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1536,'512','JSAPer390',NULL,'Mousepad',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang PUBG','Perusahaan',2026,'2026-03-30','Kecil','Kecil',50000.00,-108,1095,45.66,45041.18,'Fathan Muhamad Fauzan','Host Live JOHEN PUBG (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1537,'513','JSAPer391',NULL,'Tas Laptop',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang PUBG','Perusahaan',2026,'2026-03-30','Kecil','Kecil',30000.00,-108,1095,27.40,27024.71,'Fathan Muhamad Fauzan','Host Live JOHEN PUBG (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1538,'514','JSAPer392',NULL,'Charger Asus Vivobook',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang PUBG','Perusahaan',2026,'2026-03-30','Sedang','Sedang',120000.00,-108,1095,109.59,108098.83,'Fathan Muhamad Fauzan','Host Live JOHEN PUBG (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1539,'515','JSAPer393',NULL,'Adaptor Charger',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang PUBG','Perusahaan',2026,'2026-03-30','Kecil','Kecil',50000.00,-108,1095,45.66,45041.18,'Fathan Muhamad Fauzan','Host Live JOHEN PUBG (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1540,'516','JSAPer394',NULL,'Mouse',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang MLBB','Perusahaan',2026,'2026-03-30','Kecil','Kecil',60000.00,-108,1095,54.79,54049.42,'Fathan Muhamad Fauzan','Host Live MLBB (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1541,'517','JSAPer395',NULL,'Mousepad',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang MLBB','Perusahaan',2026,'2026-03-30','Kecil','Kecil',50000.00,-108,1095,45.66,45041.18,'Mohamad Rafli Bahtiar','Host Live MLBB (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1542,'518','JSAPer396',NULL,'Tas Laptop',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang MLBB','Perusahaan',2026,'2026-03-30','Kecil','Kecil',30000.00,-108,1095,27.40,27024.71,'Mohamad Rafli Bahtiar','Host Live MLBB (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1543,'519','JSAPer397',NULL,'Charger Asus Vivobook',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang MLBB','Perusahaan',2026,'2026-03-30','Sedang','Sedang',120000.00,-108,1095,109.59,108098.83,'Mohamad Rafli Bahtiar','Host Live MLBB (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1544,'520','JSAPer398',NULL,'Adaptor Charger',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang MLBB','Perusahaan',2026,'2026-03-30','Kecil','Kecil',50000.00,-108,1095,45.66,45041.18,'Mohamad Rafli Bahtiar','Host Live MLBB (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1545,'521','JSAPer399',NULL,'Mouse',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang E-Football','Perusahaan',2026,'2026-03-30','Kecil','Kecil',60000.00,-108,1095,54.79,54049.42,'Mohamad Rafli Bahtiar','Koor & Host Live E-Football','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1546,'96','JSAPer40',NULL,'Cctv',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Kecil',650000.00,-196,1825,356.16,579978.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1547,'522','JSAPer400',NULL,'Mousepad',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang E-Football','Perusahaan',2026,'2026-03-30','Kecil','Kecil',50000.00,-108,1095,45.66,45041.18,'Mochamad Rizal Hanapi','Koor & Host Live E-Football','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1548,'523','JSAPer401',NULL,'Tas Laptop',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang E-Football','Perusahaan',2026,'2026-03-30','Kecil','Kecil',30000.00,-108,1095,27.40,27024.71,'Mochamad Rizal Hanapi','Koor & Host Live E-Football','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1549,'524','JSAPer402',NULL,'Charger Asus Vivobook',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang E-Football','Perusahaan',2026,'2026-03-30','Sedang','Sedang',120000.00,-108,1095,109.59,108098.83,'Mochamad Rizal Hanapi','Koor & Host Live E-Football','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1550,'29','JSAPer334',NULL,'Visitor badge',5,'Biru','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Sedang',7500.00,-196,365,20.55,3460.31,'Kenna Ida Febriana Putri','Resepsionis','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1551,'525','JSAPer403',NULL,'Adaptor Charger',1,'Putih','Peralatan kantor','Bagus','Lantai 3','Ruang E-Football','Perusahaan',2026,'2026-03-30','Kecil','Kecil',50000.00,-108,1095,45.66,45041.18,'Mochamad Rizal Hanapi','Koor & Host Live E-Football','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1552,'526','JSAPer404',NULL,'Ipad Pro gen 4 11 Inc',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang E-Football','Perusahaan',2026,'2026-06-22','Besar','Sedang',14000000.00,-24,1096,12773.72,13685790.26,'Mochamad Rizal Hanapi','Koor & Host Live E-Football','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1553,'527','JSAPer405',NULL,'Ipad Pro gen 4 11 Inc',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang PUBG','Perusahaan',2026,'2026-06-22','Besar','Sedang',14000000.00,-24,1096,12773.72,13685790.26,'Mochamad Rizal Hanapi','Koor PUBG','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1554,'528','JSAPer406',NULL,'Ipad Pro',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang Free fire','Perusahaan',2026,'2026-06-22','Besar','Sedang',17000000.00,-24,1096,15510.95,16618459.60,'Fathan Muhamad Fauzan','Asisten Koor Free fire','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1555,'530','JSAPer407',NULL,'Stop Kontak',2,'Putih','Peralatan Kantor','Bagus','Lantai 2','Ruang Admin','Ruko',2026,'2026-01-01','Kecil','Kecil',25000.00,-196,1460,17.12,21633.59,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1556,'539','JSAPer408',NULL,'Kotak Kabel',1,'Putih','Peralatan Kantor','Bagus','Lantai 2','Lantai 2','Ruko',2026,'2026-01-01','Sedang','Besar',150000.00,-196,10950,13.70,147306.87,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1557,'553','JSAPer409',NULL,'Keyboard',1,'Navy - Taro Switch','Peralatan Kantor','Bagus','Lantai 2','Admin Transaksi','Perusahaan',2026,'2026-01-01','Besar','Besar',400000.00,-196,1460,273.97,346137.50,'Kornelius Adrian','Koordinator Admin','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1558,'97','JSAPer41',NULL,'AC',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Sedang',10000000.00,-196,2920,3424.66,9326718.72,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1559,'554','JSAPer410',NULL,'Mouse',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Head Of Store Manager','Perusahaan',2026,'2026-03-25','Kecil','Kecil',60000.00,-113,1095,54.79,53775.44,'Pamungkas Chris Hermanto','Head Of Store Manager','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1560,'555','JSAPer411',NULL,'Mousepad',1,'Abu-abu','Peralatan kantor','Bagus','Lantai 3','Ruang Head Of Store Manager','Perusahaan',2026,'2026-03-25','Kecil','Kecil',50000.00,-113,1095,45.66,44812.87,'Pamungkas Chris Hermanto','Head Of Store Manager','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1561,'556','JSAPer412',NULL,'Tas Laptop',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Head Of Store Manager','Perusahaan',2026,'2026-03-25','Kecil','Kecil',30000.00,-113,1095,27.40,26887.72,'Pamungkas Chris Hermanto','Head Of Store Manager','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1562,'557','JSAPer413',NULL,'Charger',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang Head Of Store Manager','Perusahaan',2026,'2026-03-25','Sedang','Sedang',120000.00,-113,1095,109.59,107550.89,'Pamungkas Chris Hermanto','Head Of Store Manager','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1563,'570','JSAPer414',NULL,'Set Obeng',1,'Merah','Peralatan kantor','Bagus','Lantai 3','Ruang IT','Perusahaan',2026,'2026-06-24','Sedang','Sedang',209900.00,-22,1095,191.69,205568.18,'Muhamad Fijan Nainnatim Fauzi','IT Staff','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1564,'571','JSAPer415',NULL,'Kursi Susun',33,'Biru','Peralatan kantor','Bagus','Lantai 1','Meeting Room','Perusahaan',2026,'2026-01-01','Sedang','Sedang',240000.00,-196,1825,131.51,214146.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1565,'572','JSAPer416',NULL,'Sofa',4,'Abu-abu','Peralatan kantor','Bagus','Lantai 1','Meeting Room','Perusahaan',2026,'2026-01-01','Besar','Besar',600000.00,-196,1825,328.77,535365.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1566,'573','JSAPer417',NULL,'Meja Kerja',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Meeting Room','Perusahaan',2026,'2026-01-01','Sedang','Besar',200000.00,-196,2920,68.49,186534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1567,'574','JSAPer418',NULL,'Pembersih Kamera',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruang IT','Perusahaan',2026,'2026-06-29','Kecil','Kecil',52000.00,-17,1095,47.49,51164.29,'Muhamad Fijan Nainnatim Fauzi','IT Staff','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1568,'575','JSAPer419',NULL,'Deepcool Thermal Paste',1,'Hijau','Peralatan kantor','Bagus','Lantai 3','Ruang IT','Perusahaan',2026,'2026-06-29','Kecil','Kecil',45000.00,-17,1095,41.10,44276.79,'Muhamad Fijan Nainnatim Fauzi','IT Staff','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1569,'98','JSAPer42',NULL,'Gelas',6,'Clear','Peralatan kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Sedang','Kecil',38000.00,-196,1095,34.70,31177.42,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1570,'576','JSAPer420',NULL,'Wireless Vaccum Cleaner Komputer',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang HRGA','Perusahaan',2026,'2026-06-29','Kecil','Kecil',84000.00,-17,1460,57.53,82987.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1571,'577','JSAPer421',NULL,'Zybar Bag',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-06-16','Kecil','Kecil',30000.00,-30,360,83.33,27450.16,'Zulfa Rahamani','Sosial Media Specialist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1572,'578','JSAPer422',NULL,'Bubble Wrap',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-06-16','Kecil','Kecil',35000.00,-30,360,97.22,32025.18,'Zulfa Rahamani','Sosial Media Specialist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1573,'579','JSAPer423',NULL,'Plastik Packing',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-06-16','Kecil','Kecil',25000.00,-30,360,69.44,22875.13,'Zulfa Rahamani','Sosial Media Specialist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1574,'580','JSAPer424',NULL,'Stop Kontak',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-06-16','Kecil','Sedang',50000.00,-30,1460,34.25,48952.12,'Zulfa Rahamani','Sosial Media Specialist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1575,'581','JSAPer425',NULL,'Stop Kontak',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-06-16','Kecil','Sedang',50000.00,-30,1460,34.25,48952.12,'Zulfa Rahamani','Sosial Media Specialist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1576,'582','JSAPer426',NULL,'Mic Mikrofon',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-06-16','Sedang','Sedang',100000.00,-30,1460,68.49,97904.24,'Zulfa Rahamani','Sosial Media Specialist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1577,'583','JSAPer427',NULL,'Jubah',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Creative','Perusahaan',2026,'2026-06-16','Kecil','Kecil',100000.00,-30,1095,91.32,97205.65,'Zulfa Rahamani','Sosial Media Specialist','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1578,'585','JSAPer428',NULL,'Adata SSD 256 GB',1,'Biru','Peralatan kantor','Bagus','Lantai 3','Ruang Free fire','Perusahaan',2026,'2026-07-03','Sedang','Kecil',725750.00,-13,1460,497.09,718990.52,'Muhamad Fijan Nainnatim Fauzi','IT Staff','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1579,'586','JSAPer429',NULL,'Stella Japanese Sakura',2,'Pink','Peralatan kantor','Bagus','Lantai 3','Ruang MLBB & Lounge','Perusahaan',2026,'2026-07-03','Kecil','Kecil',68500.00,-13,360,190.28,65912.58,'Mohamad Rafli Bahtiar','Host Live MLBB (sesi 1)','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1580,'99','JSAPer43',NULL,'Nampan',1,'Silver','Peralatan kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Sedang','Sedang',50000.00,-196,1095,45.66,41022.92,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1581,'587','JSAPer430',NULL,'Stella Japanese Sakura Automatic',1,'Cream & Putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-07-03','Kecil','Kecil',95690.00,-13,360,265.81,92075.54,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1582,'588','JSAPer431',NULL,'Kabel LAN 20 Meter',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruangan Free Fire & Valorant','Perusahaan',2026,'2026-07-02','Kecil','Sedang',132700.00,-14,1095,121.19,130930.89,'Muhamad Fijan Nainnatim Fauzi','IT Staff','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1583,'589','JSAPer432',NULL,'Kabel LAN 25 Meter',1,'Hitam','Peralatan kantor','Bagus','Lantai 3','Ruangan Free Fire & Valorant','Perusahaan',2026,'2026-07-02','Kecil','Sedang',150200.00,-14,1095,137.17,148197.59,'Muhamad Fijan Nainnatim Fauzi','IT Staff','Pamungkas Chris Hermanto','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1584,'590','JSAPer433',NULL,'Laptop Asus Vivobook 14/15 GO 16 GB, RAM 512 GB',1,'Silver','Peralatan kantor','Bagus','Baleendah','Baleendah','Perusahaan',2026,'2026-07-06','Besar','Besar',8000000.00,-10,1825,4383.56,7953542.43,'Aygustini Simanungkalit','HR Cabang Baleendah',NULL,NULL,'baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1585,'591','JSAPer434',NULL,'Laptop Asus Vivobook 14/15 GO 16 GB, RAM 512 GB',1,'Silver','Peralatan kantor','Bagus','Baleendah','Baleendah','Perusahaan',2026,'2026-07-06','Besar','Besar',8000000.00,-10,1825,4383.56,7953542.43,'Moch Ilham Syah Alam','Koordinator Stock Cabang Baleendah',NULL,NULL,'baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1586,'592','JSAPer435',NULL,'Charger Asus Vivobook 14/15 GO 16 GB, RAM 512 GB',1,'Hitam','Peralatan kantor','Bagus','Baleendah','Baleendah','Perusahaan',2026,'2026-07-06','Sedang','Sedang',120000.00,-10,1095,109.59,118838.56,'Aygustini Simanungkalit','HR Cabang Baleendah',NULL,NULL,'baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1587,'593','JSAPer436',NULL,'Charger Asus Vivobook 14/15 GO 16 GB, RAM 512 GB',1,'Hitam','Peralatan kantor','Bagus','Baleendah','Baleendah','Perusahaan',2026,'2026-07-06','Sedang','Sedang',120000.00,-10,1095,109.59,118838.56,NULL,'Koordinator Stock Cabang Baleendah',NULL,NULL,'baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1588,'594','JSAPer437',NULL,'Tas Laptop Asus VivoBook 14/15 GO 16 GB, RAM 512 GB',1,'Hitam','Peralatan kantor','Bagus','Baleendah','Baleendah','Perusahaan',2026,'2026-07-06','Kecil','Sedang',50000.00,-10,1095,45.66,49516.07,NULL,'HR Cabang Baleendah',NULL,NULL,'baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1589,'595','JSAPer438',NULL,'Tas Laptop Asus VivoBook 14/15 GO 16 GB, RAM 512 GB',1,'Hitam','Peralatan kantor','Bagus','Baleendah','Baleendah','Perusahaan',2026,'2026-07-06','Kecil','Sedang',50000.00,-10,1095,45.66,49516.07,NULL,'Koordinator Stock Cabang Baleendah',NULL,NULL,'baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1590,'596','JSAPer439',NULL,'Injakan Tangga (Footstep)',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Ruang Operasional 1','Perusahaan',2026,'2026-01-01','Sedang','Sedang',125000.00,-196,1460,85.62,108167.97,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1591,'100','JSAPer44',NULL,'Tempat tisu',1,'Abu','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',20000.00,-196,1095,18.26,16409.17,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1592,'597','JSAPer440',NULL,'Dispenser',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Besar','Besar',1000000.00,-196,1825,547.95,892274.99,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1593,'598','JSAPer441',NULL,'Papan Informasi',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Sedang','Sedang',50000.00,-196,1095,45.66,41022.92,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1594,'599','JSAPer442',NULL,'Patung Johen',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Sedang','Besar',2000000.00,-196,1460,1369.86,1730687.49,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1595,'600','JSAPer443',NULL,'Kalender Meja',2,'Putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',48000.00,-196,365,131.51,22146.00,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1596,'601','JSAPer444',NULL,'Papan Nama Gate',2,'Putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,1095,45.66,41022.92,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1597,'602','JSAPer445',NULL,'Papan QR Payment',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Kecil','Kecil',50000.00,-196,1095,45.66,41022.92,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1598,'603','JSAPer446',NULL,'Keyboard',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Resepsionis','Perusahaan',2026,'2026-01-01','Sedang','Kecil',200000.00,-196,1460,136.99,173068.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1599,'604','JSAPer447',NULL,'Stop Kontak',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Sedang',50000.00,-196,1095,45.66,41022.92,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1600,'605','JSAPer448',NULL,'Tempat Sendok',1,'Silver','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',40000.00,-196,1095,36.53,32818.33,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1601,'606','JSAPer449',NULL,'Lemari Penyimpanan Helm',1,'Coklat','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Besar','Besar',2000000.00,-196,1460,1369.86,1730687.49,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1602,'101','JSAPer45',NULL,'Lemari penyimpanan',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Besar',1500000.00,-196,1095,1369.86,1230687.49,'Yuliana Sventy Yasmine Aulhia Sugiat','Office Boy','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1603,'607','JSAPer450',NULL,'Stop Kontak',2,'Putih, Colokan 4','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1460,68.49,86534.37,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1604,'608','JSAPer451',NULL,'Asbak',2,'Biru','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',20000.00,-196,1095,18.26,16409.17,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1605,'102','JSAPer46',NULL,'Lemari penyimpanan',1,'Hitam Putih','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Besar',1500000.00,-196,1095,1369.86,1230687.49,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1606,'103','JSAPer47',NULL,'Lemari penyimpanan',1,'Hitam coklat','Peralatan kantor','Bagus','Lantai 1','Ruang Operasional 1','Perusahaan',2026,'2026-01-01','Besar','Besar',1500000.00,-196,1095,1369.86,1230687.49,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1607,'104','JSAPer48',NULL,'Stand tv',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Besar',519000.00,-196,1825,284.38,463090.72,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1608,'105','JSAPer49',NULL,'Tv',1,'Philips','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Besar',4000000.00,-196,1825,2191.78,3569099.98,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1609,'107','JSAPer50',NULL,'Tong sampah',1,'Abu hitam','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Sedang','Kecil',23600.00,-196,1460,16.16,20422.11,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1610,'108','JSAPer51',NULL,'Stop kontak',8,'Putih, 2 colokan','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',100000.00,-196,1460,68.49,86534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1611,'109','JSAPer52',NULL,'Stop kontak',1,'Putih, 4 colokan','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Kecil','Besar',26000.00,-196,1460,17.81,22498.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1612,'113','JSAPer53',NULL,'Tempat tisu clear',1,'Coklat','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Kecil','Kecil',35000.00,-196,1095,31.96,28716.04,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1613,'114','JSAPer54',NULL,'Nintendo',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Kecil',500000.00,-196,1825,273.97,446137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1614,'115','JSAPer55',NULL,'Baju alter ego',1,'Hitam Merah','Peralatan kantor','Bagus','Lantai 1','Lemari Lantai 1','Perusahaan',2026,'2026-01-01','Kecil','Sedang',150000.00,-196,730,205.48,109603.12,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1615,'116','JSAPer56',NULL,'Router',1,'Hitam','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Kecil',350000.00,-196,1825,191.78,312296.25,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1616,'117','JSAPer57',NULL,'Microtik',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Meeting room','Perusahaan',2026,'2026-01-01','Besar','Kecil',500000.00,-196,1825,273.97,446137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1617,'118','JSAPer58',NULL,'Rak penyimpanan helm',1,'Coklat','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Besar','Besar',800000.00,-196,1825,438.36,713820.00,'Yuga Redisa Maulana','Office Boy','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1618,'119','JSAPer59',NULL,'Tong sampah besar',1,'Abu hitam','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Besar','Besar',150000.00,-196,1460,102.74,129801.56,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1619,'120','JSAPer60',NULL,'Sapu',2,'-','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',48000.00,-196,730,65.75,35073.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1620,'121','JSAPer61',NULL,'Pengki',1,'Merah putih','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',32500.00,-196,730,44.52,23747.34,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1621,'122','JSAPer62',NULL,'Sapu lidi',1,'Cokelat','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',20000.00,-196,730,27.40,14613.75,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1622,'124','JSAPer64',NULL,'Pel lantai',2,'-','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',40000.00,-196,730,54.79,29227.50,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1623,'125','JSAPer65',NULL,'Ember',3,'Hitam','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Sedang',15000.00,-196,1095,13.70,12306.87,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1624,'126','JSAPer66',NULL,'Soklin lantai',1,'-','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',18900.00,-196,60,315.00,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1625,'127','JSAPer67',NULL,'Sunlight',1,'Hijau','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,60,250.00,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1626,'128','JSAPer68',NULL,'Wpc',1,'Biru','Peralatan kantor','Setengah lagi','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Sedang',20000.00,-196,3650,5.48,18922.75,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1627,'129','JSAPer69',NULL,'Cling',1,'Biru','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',4000.00,-196,30,133.33,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1628,'130','JSAPer70',NULL,'Slugger kaca',1,'Biru','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',60000.00,-196,730,82.19,43841.25,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1629,'131','JSAPer71',NULL,'Asbak',3,'Silver','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',15000.00,-196,1460,10.27,12980.16,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1630,'132','JSAPer72',NULL,'Cutter',1,'Merah','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Kecil',20000.00,-196,60,333.33,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1631,'136','JSAPer73',NULL,'Selang air',1,'Biru','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Kecil','Sedang',100000.00,-196,730,136.99,73068.75,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1632,'137','JSAPer74',NULL,'Cctv',1,'Putih','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Besar','Kecil',1000000.00,-196,1825,547.95,892274.99,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1633,'139','JSAPer75',NULL,'Gayung',1,'Pink','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Kecil',16000.00,-196,730,21.92,11691.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1634,'140','JSAPer76',NULL,'Ember',2,'Abu, oren','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Sedang',20000.00,-196,1095,18.26,16409.17,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1635,'141','JSAPer77',NULL,'Tong sampah kecil',1,'Abu','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Sedang','Kecil',23600.00,-196,1460,16.16,20422.11,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1636,'142','JSAPer78',NULL,'Tong sampah sedang',1,'Biru','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Sedang','Sedang',38000.00,-196,1460,26.03,32883.06,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1637,'146','JSAPer79',NULL,'Sabun cair',1,'Merah','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Kecil',18000.00,-196,60,300.00,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1638,'147','JSAPer80',NULL,'Sabun cuci tangan',1,'Hijau','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Sedang',15000.00,-196,60,250.00,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1639,'148','JSAPer81',NULL,'Tisu toilet',1,'Putih','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Kecil',30000.00,-196,60,500.00,0.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1640,'150','JSAPer82',NULL,'Keset WC',1,'Merah','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Sedang',40000.00,-196,365,109.59,18455.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1641,'151','JSAPer83',NULL,'Sandal jepit',1,'Merah, biru','Peralatan kantor','Bagus','Lantai 2','Kamar Mandi','Perusahaan',2026,'2026-01-01','Kecil','Sedang',40000.00,-196,1825,21.92,35691.00,'Yuga Redisa Maulana','Office Boy','Yuliana Sventy Yasmine Aulhia Sugiat','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1642,'152','JSAPer84',NULL,'Kursi Kerja',7,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Kecil','Sedang',10200000.00,-196,1825,5589.04,9101204.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Yuliana Sventy Yasmine Aulhia Sugiat','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1643,'153','JSAPer85',NULL,'Sajadah',2,'Biru','Peralatan kantor','Bagus','Lantai 2','Mushola','External',2026,'2026-01-01','Kecil','Sedang',50000.00,-196,730,68.49,36534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1644,'154','JSAPer86',NULL,'Galon',5,'Biru','Peralatan kantor','Bagus','Lantai 1','Pantry 1','Perusahaan',2026,'2026-01-01','Sedang','Sedang',65500.00,-196,1095,59.82,53740.02,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1645,'158','JSAPer87',NULL,'AC',2,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2025,'2026-01-01','Besar','Sedang',10000000.00,-196,2920,3424.66,9326718.72,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1646,'159','JSAPer88',NULL,'Remote AC',2,'Putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2025,'2026-01-01','Besar','Kecil',150000.00,-196,1095,136.99,123068.75,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1647,'161','JSAPer89',NULL,'Rak',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2025,'2026-01-01','Besar','Sedang',500000.00,-196,1825,273.97,446137.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1648,'162','JSAPer90',NULL,'Meja laci',1,'Hitam putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Besar',600000.00,-196,2920,205.48,559603.12,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1649,'164','JSAPer91',NULL,'Webcam Pak Nando',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',500000.00,-196,1460,342.47,432671.87,'Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1650,'165','JSAPer92',NULL,'Webcam Julian',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Host Live','Perusahaan',2026,'2026-01-01','Sedang','Kecil',500000.00,-196,1460,342.47,432671.87,'Julian Hardi Winata','Host Live Gameplay + Worker Joki MLBB','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1651,'166','JSAPer93',NULL,'Wifi adapter',1,'Hitam','Peralatan kantor','Bagus','Lantai 2','Atas Pantry 2','Perusahaan',2026,'2026-01-01','Sedang','Kecil',150000.00,-196,1825,82.19,133841.25,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1652,'167','JSAPer94',NULL,'Meja kerja 8 orang',1,'Hitam putih','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Besar','Besar',4200000.00,-196,2920,1438.36,3917221.86,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1653,'169','JSAPer95',NULL,'Meja Regi',1,'Putih cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Regi Ganda Permana','Admin Record PUBG','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1654,'170','JSAPer96',NULL,'Meja Fiki Sugiana',1,'Putih cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Fiki Sugiana','Admin Record MLBB','Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1655,'171','JSAPer97',NULL,'Meja Zulfa',1,'Putih cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Rinaldo Pardomuan Sinaga','Head of Store Manager / PM','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1656,'172','JSAPer98',NULL,'Meja Aghni',1,'Putih cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1657,'173','JSAPer99',NULL,'Meja Deden',1,'Putih cream','Peralatan kantor','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2026,'2026-01-01','Besar','Besar',500000.00,-196,2920,171.23,466335.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','Head of Store Manager / PM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1658,'561','561',NULL,'Teko Kaca',1,'Clear','Peralatan kantor','Bagus','Lantai 1','Smoking Area','Perusahaan',2026,'2026-01-01','Sedang','Sedang',100000.00,-196,1460,68.49,86534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1659,'562','562',NULL,'Kursi Kerja',10,'Hitam','Peralatan kantor','Bagus','Lantai 2','Ruang Admin','Perusahaan',2026,'2026-01-01','Kecil','Sedang',10200000.00,-196,1825,5589.04,9101204.94,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Yuliana Sventy Yasmine Aulhia Sugiat','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1660,'563','563',NULL,'Lampu TL',6,'Putih','Bagunan','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Kecil','Kecil',85000.00,-196,1460,58.22,73554.22,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1661,'564','564',NULL,'Stop kontak',2,'Putih, 1 Colokan','Bagunan','Bagus','Lantai 2','Ruang Operasional 2','Perusahaan',2025,'2026-01-01','Kecil','Kecil',100000.00,-196,1460,68.49,86534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','Office Boy','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1662,'182','182',NULL,'Sapu',1,'-','Peralatan kantor','Bagus','Lantai 2','Pantry 2','Perusahaan',2026,'2026-01-01','Kecil','Kecil',19000.00,-196,730,26.03,13883.06,'Yuga Redisa Maulana','Office Boy','Pamungkas Chris Hermanto','Human Resources Generalist','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1663,'358','358',NULL,'Meja kerja Monkey JOHEN',1,'Silver','Peralatan kantor','Bagus','Lantai 3','Ruang Host Live','Perusahaan',2026,'2026-01-01','Besar','Besar',2700000.00,-196,2920,924.66,2518214.05,'Mochamad Rizal Hanapi','Host Live PUBG Monkey (siang) &Admin Johen Dexx dan Monkey (malam)','Rinaldo Pardomuan Sinaga','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1664,'566','566',NULL,'Saklar lampu 1',2,'Putih','Bagunan','Bagus','Lantai 3','Ruang Operasional 3','Perusahaan',2026,'2026-01-01','Kecil','Kecil',76000.00,-196,1825,41.64,67812.90,'Yuga Redisa Maulana','Human Resources Generalist','Yuliana Sventy Yasmine Aulhia Sugiat','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1665,'567','567',NULL,'Meja Kerja',2,'Hitam','Peralatan kantor','Bagus','Lantai 3','Staff Lounge','Perusahaan',2026,'2026-01-01','Sedang','Sedang',150000.00,-196,2920,51.37,139900.78,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1666,'568','568',NULL,'Kursi',2,'Hitam','Peralatan kantor','Bagus','Lantai 3','Staff Lounge','Perusahaan',2026,'2026-01-01','Sedang','Sedang',300000.00,-196,1825,164.38,267682.50,'Yuliana Sventy Yasmine Aulhia Sugiat','Human Resources Generalist','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18'),(1667,'569','569',NULL,'Sofa Kecil',2,'Abu','Peralatan kantor','Bagus','Lantai 3','Staff Lounge','Perusahaan',2026,'2026-01-01','Sedang','Kecil',200000.00,-196,2920,68.49,186534.37,'Yuliana Sventy Yasmine Aulhia Sugiat','0','Gonzaga Gogo Silalahi','GM','baik','2026-07-16 07:21:18','2026-07-16 07:21:18');
/*!40000 ALTER TABLE `peralatan_kantor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `push_subscriptions`
--

DROP TABLE IF EXISTS `push_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `push_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `endpoint` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p256dh` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_endpoint` (`user_id`,`endpoint`),
  CONSTRAINT `push_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `push_subscriptions`
--

LOCK TABLES `push_subscriptions` WRITE;
/*!40000 ALTER TABLE `push_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `push_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int unsigned NOT NULL DEFAULT '50',
  `facilities` json DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `team_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_team_id_foreign` (`team_id`),
  CONSTRAINT `rooms_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'Meeting Room Utama',50,'[\"Proyektor\", \"TV\", \"Speaker\", \"Whiteboard\", \"AC\"]','Lantai 1','Ruang meeting utama Johen Gaming',1,NULL,'2026-07-15 08:40:17','2026-07-15 08:40:17');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('Bv8QsDtK8kmBnv8RLlKj5fgryml0KygQYxWzOfK7',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.131.0 Chrome/148.0.7778.280 Electron/42.7.0 Safari/537.36','eyJfdG9rZW4iOiJ5V0lIakxOdjVaeDJUTURETWhvcjhLekNNVEZPcHJ1enRRM1RYUUFwIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3JlYWx0aW1lXC9ub3RpZiIsInJvdXRlIjoicmVhbHRpbWUubm90aWYifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9',1785927160),('IGzfVYqqPKqEHKcUzXX9DkSj6momMVKEiFwLV9De',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI4cnhMU0lnME45bE9oVEw1NzhwYkd6MDM3SHFheEI3NHBpc3NObmpvIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2NhbGVuZGFyIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvcmVhbHRpbWVcL25vdGlmIiwicm91dGUiOiJyZWFsdGltZS5ub3RpZiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1785927160);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_cards`
--

DROP TABLE IF EXISTS `sim_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sim_cards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_sim_card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `masa_aktif` date NOT NULL,
  `masa_tenggang` date NOT NULL,
  `status_paket_kuota` tinyint(1) NOT NULL DEFAULT '1',
  `status_kartu` tinyint(1) NOT NULL DEFAULT '1',
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_cards`
--

LOCK TABLES `sim_cards` WRITE;
/*!40000 ALTER TABLE `sim_cards` DISABLE KEYS */;
INSERT INTO `sim_cards` VALUES (1,'ssd','23','eq','Chief Executive Officer (CEO)','2026-07-18','2026-07-17',1,0,'eqeeqeqeqeqe','2026-07-18 05:09:51','2026-07-18 05:09:51');
/*!40000 ALTER TABLE `sim_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sosial_media`
--

DROP TABLE IF EXISTS `sosial_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sosial_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `followers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sosial_media`
--

LOCK TABLES `sosial_media` WRITE;
/*!40000 ALTER TABLE `sosial_media` DISABLE KEYS */;
INSERT INTO `sosial_media` VALUES (1,'ahmad','Ahmad Musyadad Haury',NULL,'Instagram','xx','ahmad',NULL,'aktif','2026-08-04 07:31:19','2026-08-04 07:31:19');
/*!40000 ALTER TABLE `sosial_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_compositions`
--

DROP TABLE IF EXISTS `team_compositions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_compositions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_count` int NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_compositions`
--

LOCK TABLES `team_compositions` WRITE;
/*!40000 ALTER TABLE `team_compositions` DISABLE KEYS */;
INSERT INTO `team_compositions` VALUES (1,'ceo','CEO',1,1,'2026-07-22 09:07:46','2026-07-22 09:20:46'),(2,'gm','General Manager',1,2,'2026-07-22 09:07:46','2026-07-22 09:20:46'),(3,'head_of_store','Head of Store',2,3,'2026-07-22 09:07:46','2026-07-22 09:20:46'),(4,'hr','HR',2,4,'2026-07-22 09:07:46','2026-07-22 09:20:46'),(5,'koordinator','Koordinator',11,5,'2026-07-22 09:07:46','2026-07-22 09:20:46'),(6,'total_team','Total Tim',11,6,'2026-07-22 09:07:46','2026-07-22 09:20:46'),(7,'karyawan','Karyawan',55,7,'2026-07-22 09:07:46','2026-07-22 09:20:46');
/*!40000 ALTER TABLE `team_compositions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Tim Konten','Tim yang mengelola konten',1,'2026-07-15 08:40:14','2026-07-15 08:40:14'),(2,'Tim Host Live','Tim yang mengelola live streaming',1,'2026-07-15 08:40:14','2026-07-15 08:40:14'),(3,'Tim Marketing','Tim yang mengelola pemasaran',1,'2026-07-15 08:40:14','2026-07-15 08:40:14'),(4,'Tim Operasional','Tim yang mengelola operasional',1,'2026-07-15 08:40:14','2026-07-15 08:40:14'),(5,'TIM IT',NULL,1,'2026-07-21 01:40:05','2026-07-21 01:40:05'),(6,'Tim Konten','Tim yang mengelola konten',1,'2026-07-31 08:01:48','2026-07-31 08:01:48'),(7,'Johen Roblox','Tim game Johen Roblox',1,'2026-07-31 08:01:48','2026-07-31 08:01:48'),(8,'Johen PUBG','Tim game Johen PUBG',1,'2026-07-31 08:01:48','2026-07-31 08:01:48'),(9,'Johen MLBB','Tim game Johen MLBB',1,'2026-07-31 08:01:48','2026-07-31 08:01:48'),(10,'Johen Free Fire','Tim game Johen Free Fire',1,'2026-07-31 08:01:48','2026-07-31 08:01:48'),(11,'Johen E-Football','Tim game Johen E-Football',1,'2026-07-31 08:01:48','2026-07-31 08:01:48'),(12,'Kreatif','Tim kreatif',1,'2026-07-31 08:01:48','2026-07-31 08:01:48'),(13,'IT','Tim IT',1,'2026-07-31 08:01:48','2026-07-31 08:01:48'),(14,'Tim Marketing','Tim yang mengelola pemasaran',1,'2026-07-31 08:01:49','2026-07-31 08:01:49'),(15,'Tim Operasional','Tim yang mengelola operasional',1,'2026-07-31 08:01:49','2026-07-31 08:01:49');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_attachments`
--

DROP TABLE IF EXISTS `ticket_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_attachments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `comment_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_attachments_comment_id_foreign` (`comment_id`),
  KEY `ticket_attachments_user_id_foreign` (`user_id`),
  KEY `ticket_attachments_ticket_id_created_at_index` (`ticket_id`,`created_at`),
  CONSTRAINT `ticket_attachments_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `ticket_comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_attachments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_attachments`
--

LOCK TABLES `ticket_attachments` WRITE;
/*!40000 ALTER TABLE `ticket_attachments` DISABLE KEYS */;
INSERT INTO `ticket_attachments` VALUES (1,1,NULL,16,'ticket-attachments/2026/07/otPPPD7nirerICsEXGrUfM8vhoz4zSeTerhmq0El.png','ChatGPT Image Jul 31, 2026, 02_41_18 PM.png','image/png',2264496,'2026-07-31 08:04:51','2026-07-31 08:04:51'),(2,2,NULL,22,'ticket-attachments/2026/08/nSwGAqOmZz6AlYo73dnQB8pa9PV2tUg1DXRLQgLB.png','ChatGPT Image Jul 31, 2026, 02_41_18 PM.png','image/png',2264496,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(3,3,NULL,22,'ticket-attachments/2026/08/G87ryLEeWOvdZM9py0k8V08E1dxhBfuK1liGeyeE.png','ChatGPT Image Jul 30, 2026, 10_55_19 AM.png','image/png',1844989,'2026-08-03 04:49:51','2026-08-03 04:49:51');
/*!40000 ALTER TABLE `ticket_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_categories`
--

DROP TABLE IF EXISTS `ticket_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_categories`
--

LOCK TABLES `ticket_categories` WRITE;
/*!40000 ALTER TABLE `ticket_categories` DISABLE KEYS */;
INSERT INTO `ticket_categories` VALUES (7,'Lainnya',NULL,'Permintaan bantuan IT lainnya',1,0,'2026-07-31 08:01:55','2026-07-31 08:01:55'),(8,'Perangkat',NULL,'Kerusakan atau kendala perangkat keras seperti komputer, laptop, dan aksesori',1,0,'2026-08-03 04:29:40','2026-08-03 04:29:40'),(9,'Aplikasi',NULL,'Masalah instalasi, penggunaan, atau error pada aplikasi dan sistem',1,0,'2026-08-03 04:29:40','2026-08-03 04:29:40'),(10,'Akun & Akses',NULL,'Reset password, pembuatan akun, dan masalah hak akses',1,0,'2026-08-03 04:29:40','2026-08-03 04:29:40'),(11,'Jaringan',NULL,'Koneksi internet, WiFi, dan masalah jaringan',1,0,'2026-08-03 04:29:40','2026-08-03 04:29:40');
/*!40000 ALTER TABLE `ticket_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_comments`
--

DROP TABLE IF EXISTS `ticket_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_comments_user_id_foreign` (`user_id`),
  KEY `ticket_comments_ticket_id_created_at_index` (`ticket_id`,`created_at`),
  CONSTRAINT `ticket_comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_comments`
--

LOCK TABLES `ticket_comments` WRITE;
/*!40000 ALTER TABLE `ticket_comments` DISABLE KEYS */;
INSERT INTO `ticket_comments` VALUES (1,1,16,'tes','2026-07-31 08:05:05','2026-07-31 08:05:05'),(2,1,1,'tes','2026-08-03 04:00:15','2026-08-03 04:00:15'),(3,2,22,'perbaiki','2026-08-03 04:33:44','2026-08-03 04:33:44');
/*!40000 ALTER TABLE `ticket_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_histories`
--

DROP TABLE IF EXISTS `ticket_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_histories_user_id_foreign` (`user_id`),
  KEY `ticket_histories_ticket_id_created_at_index` (`ticket_id`,`created_at`),
  CONSTRAINT `ticket_histories_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_histories`
--

LOCK TABLES `ticket_histories` WRITE;
/*!40000 ALTER TABLE `ticket_histories` DISABLE KEYS */;
INSERT INTO `ticket_histories` VALUES (1,1,16,'attachment','Lampiran ditambahkan: ChatGPT Image Jul 31, 2026, 02_41_18 PM.png',NULL,NULL,'2026-07-31 08:04:51','2026-07-31 08:04:51'),(2,1,16,'created','Ticket dibuat oleh ahmad',NULL,'open','2026-07-31 08:04:51','2026-07-31 08:04:51'),(3,1,16,'comment','Komentar ditambahkan oleh ahmad',NULL,NULL,'2026-07-31 08:05:05','2026-07-31 08:05:05'),(4,1,1,'comment','Komentar ditambahkan oleh Admin Master',NULL,NULL,'2026-08-03 04:00:15','2026-08-03 04:00:15'),(5,2,22,'attachment','Lampiran ditambahkan: ChatGPT Image Jul 31, 2026, 02_41_18 PM.png',NULL,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(6,2,22,'created','Ticket dibuat oleh jors',NULL,'open','2026-08-03 04:33:16','2026-08-03 04:33:16'),(7,2,22,'comment','Komentar ditambahkan oleh jors',NULL,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(8,2,16,'taken','Ticket diambil oleh ahmad','open','assigned','2026-08-03 04:34:30','2026-08-03 04:34:30'),(9,2,16,'status','Status berubah dari Assigned ke In Progress','assigned','in_progress','2026-08-03 04:34:47','2026-08-03 04:34:47'),(10,2,16,'status','Status berubah dari In Progress ke Resolved','in_progress','resolved','2026-08-03 04:35:03','2026-08-03 04:35:03'),(11,2,16,'status','Status berubah dari Resolved ke Reopened','resolved','reopened','2026-08-03 04:35:13','2026-08-03 04:35:13'),(12,2,16,'resolved','Ticket diselesaikan oleh ahmad','reopened','resolved','2026-08-03 04:35:17','2026-08-03 04:35:17'),(13,2,22,'closed','Ticket dikonfirmasi selesai oleh jors','resolved','closed','2026-08-03 04:35:53','2026-08-03 04:35:53'),(14,2,22,'rating','Rating 5 bintang diberikan',NULL,'5','2026-08-03 04:35:59','2026-08-03 04:35:59'),(15,3,22,'attachment','Lampiran ditambahkan: ChatGPT Image Jul 30, 2026, 10_55_19 AM.png',NULL,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(16,3,22,'created','Ticket dibuat oleh jors',NULL,'open','2026-08-03 04:49:51','2026-08-03 04:49:51'),(17,2,22,'reopened','Ticket dibuka kembali oleh jors','closed','reopened','2026-08-03 09:41:11','2026-08-03 09:41:11');
/*!40000 ALTER TABLE `ticket_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_notifications`
--

DROP TABLE IF EXISTS `ticket_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ticket',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_notifications_user_id_is_read_index` (`user_id`,`is_read`),
  KEY `ticket_notifications_ticket_id_user_id_index` (`ticket_id`,`user_id`),
  CONSTRAINT `ticket_notifications_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_notifications`
--

LOCK TABLES `ticket_notifications` WRITE;
/*!40000 ALTER TABLE `ticket_notifications` DISABLE KEYS */;
INSERT INTO `ticket_notifications` VALUES (1,1,1,'ticket','Ticket Baru','Ticket TK-20260731-0001 ??? tesd dibuka oleh ahmad','http://127.0.0.1:8000/tickets/1',0,NULL,'2026-07-31 08:04:51','2026-07-31 08:04:51'),(2,1,14,'ticket','Ticket Baru','Ticket TK-20260731-0001 ??? tesd dibuka oleh ahmad','http://127.0.0.1:8000/tickets/1',0,NULL,'2026-07-31 08:04:51','2026-07-31 08:04:51'),(3,1,1,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260731-0001 oleh ahmad.','http://127.0.0.1:8000/tickets/1',0,NULL,'2026-07-31 08:05:05','2026-07-31 08:05:05'),(4,1,14,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260731-0001 oleh ahmad.','http://127.0.0.1:8000/tickets/1',0,NULL,'2026-07-31 08:05:05','2026-07-31 08:05:05'),(5,1,16,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260731-0001 oleh Admin Master.','http://127.0.0.1:8000/tickets/1',0,NULL,'2026-08-03 04:00:15','2026-08-03 04:00:15'),(6,2,1,'ticket','Ticket Baru','Ticket TK-20260803-0001 ??? dada dibuka oleh jors','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(7,2,14,'ticket','Ticket Baru','Ticket TK-20260803-0001 ??? dada dibuka oleh jors','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(8,2,16,'ticket','Ticket Baru','Ticket TK-20260803-0001 ??? dada dibuka oleh jors','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(9,2,21,'ticket','Ticket Baru','Ticket TK-20260803-0001 ??? dada dibuka oleh jors','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:33:16','2026-08-03 04:33:16'),(10,2,1,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260803-0001 oleh jors.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(11,2,14,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260803-0001 oleh jors.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(12,2,16,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260803-0001 oleh jors.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(13,2,21,'ticket','Komentar Baru','Komentar baru pada ticket TK-20260803-0001 oleh jors.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:33:44','2026-08-03 04:33:44'),(14,2,22,'ticket','Ticket Diambil','Ticket TK-20260803-0001 telah diambil oleh ahmad.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:34:30','2026-08-03 04:34:30'),(15,2,22,'ticket','Update Status','Status ticket TK-20260803-0001 menjadi In Progress.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:34:47','2026-08-03 04:34:47'),(16,2,22,'ticket','Update Status','Status ticket TK-20260803-0001 menjadi Resolved.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:35:03','2026-08-03 04:35:03'),(17,2,22,'ticket','Update Status','Status ticket TK-20260803-0001 menjadi Reopened.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:35:13','2026-08-03 04:35:13'),(18,2,22,'ticket','Ticket Selesai ????','Ticket TK-20260803-0001 telah diselesaikan. Mohon konfirmasi ??? masih bermasalah atau selesai?','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:35:17','2026-08-03 04:35:17'),(19,2,16,'ticket','Ticket Ditutup','Ticket TK-20260803-0001 telah dikonfirmasi selesai oleh jors.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:35:53','2026-08-03 04:35:53'),(20,2,16,'ticket','Rating Baru ???','Ticket TK-20260803-0001 mendapatkan rating 5 bintang.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 04:35:59','2026-08-03 04:35:59'),(21,3,1,'ticket','Ticket Baru','Ticket TK-20260803-0002 ??? tes dibuka oleh jors','http://127.0.0.1:8000/tickets/3',0,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(22,3,14,'ticket','Ticket Baru','Ticket TK-20260803-0002 ??? tes dibuka oleh jors','http://127.0.0.1:8000/tickets/3',0,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(23,3,16,'ticket','Ticket Baru','Ticket TK-20260803-0002 ??? tes dibuka oleh jors','http://127.0.0.1:8000/tickets/3',0,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(24,3,21,'ticket','Ticket Baru','Ticket TK-20260803-0002 ??? tes dibuka oleh jors','http://127.0.0.1:8000/tickets/3',0,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51'),(25,2,16,'ticket','Ticket Dibuka Kembali','Ticket TK-20260803-0001 dibuka kembali oleh jors.','http://127.0.0.1:8000/tickets/2',0,NULL,'2026-08-03 09:41:11','2026-08-03 09:41:11');
/*!40000 ALTER TABLE `ticket_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_ratings`
--

DROP TABLE IF EXISTS `ticket_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL DEFAULT '5',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_ratings_ticket_id_unique` (`ticket_id`),
  KEY `ticket_ratings_user_id_created_at_index` (`user_id`,`created_at`),
  CONSTRAINT `ticket_ratings_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_ratings`
--

LOCK TABLES `ticket_ratings` WRITE;
/*!40000 ALTER TABLE `ticket_ratings` DISABLE KEYS */;
INSERT INTO `ticket_ratings` VALUES (1,2,22,5,NULL,'2026-08-03 04:35:59','2026-08-03 04:35:59');
/*!40000 ALTER TABLE `ticket_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_sla`
--

DROP TABLE IF EXISTS `ticket_sla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_sla` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `priority` enum('low','medium','high','urgent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration_minutes` int unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_sla_priority_unique` (`priority`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_sla`
--

LOCK TABLES `ticket_sla` WRITE;
/*!40000 ALTER TABLE `ticket_sla` DISABLE KEYS */;
INSERT INTO `ticket_sla` VALUES (1,'low',4320,NULL,'2026-07-31 08:01:55','2026-07-31 08:01:55'),(2,'medium',1440,NULL,'2026-07-31 08:01:55','2026-07-31 08:01:55'),(3,'high',240,NULL,'2026-07-31 08:01:55','2026-07-31 08:01:55'),(4,'urgent',120,NULL,'2026-07-31 08:01:55','2026-07-31 08:01:55');
/*!40000 ALTER TABLE `ticket_sla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_team_members`
--

DROP TABLE IF EXISTS `ticket_team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_team_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `is_leader` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_team_members_user_id_unique` (`user_id`),
  CONSTRAINT `ticket_team_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_team_members`
--

LOCK TABLES `ticket_team_members` WRITE;
/*!40000 ALTER TABLE `ticket_team_members` DISABLE KEYS */;
INSERT INTO `ticket_team_members` VALUES (1,14,1,'2026-07-31 08:01:56','2026-07-31 08:01:56'),(2,1,1,'2026-07-31 08:01:56','2026-07-31 08:01:56'),(3,16,0,'2026-07-31 08:31:00','2026-07-31 08:31:00'),(4,21,0,'2026-07-31 08:31:00','2026-07-31 08:31:00');
/*!40000 ALTER TABLE `ticket_team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `assigned_to` bigint unsigned DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` enum('low','medium','high','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `sla_due_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`),
  KEY `tickets_category_id_foreign` (`category_id`),
  KEY `tickets_user_id_status_index` (`user_id`,`status`),
  KEY `tickets_assigned_to_status_index` (`assigned_to`,`status`),
  KEY `tickets_priority_status_index` (`priority`,`status`),
  KEY `tickets_created_at_index` (`created_at`),
  KEY `tickets_status_index` (`status`),
  CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tickets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `ticket_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'TK-20260731-0001',16,NULL,NULL,'tesd','tes','Lantai 2','TIM IT','Koordinator','medium','open','2026-08-01 08:04:51',NULL,NULL,'2026-07-31 08:04:51','2026-07-31 08:04:51',NULL),(2,'TK-20260803-0001',22,NULL,16,'dada','dadaaaadadad',NULL,'Johen PUBG','Karyawan','low','reopened','2026-08-06 04:33:15',NULL,NULL,'2026-08-03 04:33:15','2026-08-03 09:41:11',NULL),(3,'TK-20260803-0002',22,10,NULL,'tes','tes',NULL,'Johen PUBG','Karyawan','medium','open','2026-08-04 04:49:51',NULL,NULL,'2026-08-03 04:49:51','2026-08-03 04:49:51',NULL);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token_payments`
--

DROP TABLE IF EXISTS `token_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `token_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `amount_kwh` decimal(10,2) NOT NULL,
  `nominal` decimal(15,2) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `period` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `token_payments_created_by_foreign` (`created_by`),
  CONSTRAINT `token_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token_payments`
--

LOCK TABLES `token_payments` WRITE;
/*!40000 ALTER TABLE `token_payments` DISABLE KEYS */;
INSERT INTO `token_payments` VALUES (1,8000.00,1500000.00,'2026-08-04','2026-08','edit topup test','payment-bukti/27QgVg1MJqEozcv0QihWNDLfHSL8mcZKRVfXFm2G.jpg',1,'2026-08-04 07:52:56','2026-08-04 08:27:14');
/*!40000 ALTER TABLE `token_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','koordinator','head_of_store','gm','hr','user','ceo','admin_ga') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `team_id` bigint unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `app_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nik_unique` (`nik`),
  KEY `users_team_id_foreign` (`team_id`),
  CONSTRAINT `users_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Master','admin','26030002','admin@johen.com',NULL,'$2y$12$khRfVyhkWnnqszcb7omAIeJDyuQ20SYzumge1fM5nl2CVyJYa//xm','admin',NULL,1,NULL,1,1,'rJoVDWFWWw1heaIu8EzslB5kJFXqGboVZVHmkDUrFUmchzCfYNgppgWbfau6','2026-07-15 08:40:14','2026-08-05 07:24:09'),(2,'Head of Store','headstore','26030009','headstore@johen.com',NULL,'$2y$12$9kKZjfU8qWA/61DRbN6/fuhO2VhpIgRYWaB40pbn4.hTrCinMmPiW','head_of_store',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:14','2026-08-05 07:24:09'),(3,'General Manager','gm','26030007','gm@johen.com',NULL,'$2y$12$C2e7wwOkse6PUBr4vZjUuegZB/D5KUwCSljK1vYsqmxc69ZyyEAES','gm',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:14','2026-08-05 07:24:09'),(4,'HR Manager','hr','26030010','hr@johen.com',NULL,'$2y$12$UAAfAQWAJnwNgSRLSuXg1.3n7hZxJyssufeThZGwNpH80/1tV6WlS','hr',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:14','2026-08-05 07:24:09'),(5,'Chief Executive Officer','ceo','26030004','ceo@johen.com',NULL,'$2y$12$VTdhfKFQN4yAGWHfbDzdIO.2uGzhhVYWMs1qBUUqUOPUbRzx4Vmyu','ceo',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:15','2026-08-05 07:24:09'),(6,'Admin General Affairs','admin_ga','26030001','admin_ga@johen.com',NULL,'$2y$12$gq55zpa.Xx.GorayZ6p80OlyF8Yj81pwGZCEIk3dzWliISIAILQQW','admin_ga',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:15','2026-08-05 07:24:09'),(8,'Koordinator Johen.roblox','Johen.roblox','26030021','johen.roblox@johen.com',NULL,'$2y$12$9XGWbypIceWl0154etFSh.stA5qJ5/aHppQ7hPE5KwK37uKwqyZGq','koordinator',2,1,NULL,1,1,NULL,'2026-07-15 08:40:15','2026-08-05 07:24:09'),(9,'Koordinator Johen.PUBG','Johen.PUBG','26030020','johen.pubg@johen.com',NULL,'$2y$12$iwOvqtW9Zvvlp23MbmRnk.T.GXmi9MBclMgmM1Z7dNWoxIC1sZodG','koordinator',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:15','2026-08-05 07:24:09'),(10,'Koordinator Johen.MLBB','Johen.MLBB','26030019','johen.mlbb@johen.com',NULL,'$2y$12$DXt.RwK97gX0rFSnAeH.FeuT.T2qwVxfC4U3oBaIEA.AT0eH8SLJi','koordinator',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:16','2026-08-05 07:24:09'),(11,'Koordinator Johen.Free Fire','Johen.FreeFire','26030018','johen.freefire@johen.com',NULL,'$2y$12$6OVatTNtLt5g9BUbtE5a6.2Xt3InTM6jod4Qx2jMSm5o2.XRYvENa','koordinator',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:16','2026-08-05 07:24:09'),(12,'Koordinator Johen.E-Footbal','Johen.EFootbal','26030017','johen.efootbal@johen.com',NULL,'$2y$12$nSaq0KwxA53FgVOzow0NdOpAwCTSKL11NPW5XfiaRGSTE4hzPYg/m','koordinator',NULL,1,NULL,1,1,NULL,'2026-07-15 08:40:16','2026-08-05 07:24:09'),(13,'Koordinator Creatif','creatif','26030014','creatif@johen.com',NULL,'$2y$12$DHYWsSbUhJ4dh7pTJHEaZu8GY/fLTnAYUVg7pGQaCV3VNp.a51UUi','koordinator',1,1,NULL,1,1,NULL,'2026-07-15 08:40:16','2026-08-05 07:24:09'),(14,'Koordinator IT','it','26030016','it@johen.com',NULL,'$2y$12$ii3tLaUSNbzrWuAfJCFkRupUuIJGQirNsigGQf8nVYua3Db86jQPC','user',5,1,NULL,1,1,NULL,'2026-07-15 08:40:16','2026-08-05 07:24:09'),(15,'Karyawan Konten','user1','26030013','user1@johen.com',NULL,'$2y$12$z9uPvAyGHf1NlB6aOV2v1ePoZvS3ANmZt56by.glFkEO6ddjjBUry','user',1,1,NULL,1,1,NULL,'2026-07-15 08:40:17','2026-08-05 07:24:09'),(16,'ahmad','ahmad','26030003',NULL,'avatars/16_1784860793.jpg','$2y$12$mTHfLbKvNfkJi4/UqqtXM.Va3PE/wVbPKei59uyPxpHkxFPSdT/3u','koordinator',5,1,NULL,1,1,NULL,'2026-07-22 09:46:08','2026-08-05 07:24:09'),(17,'df','df','26030005',NULL,NULL,'$2y$12$0dZ/oyVJFAxRvkYJgY0niuqaZTPKqT1H5h43O845zRtgsMSE2cb0i','koordinator',2,1,NULL,1,1,NULL,'2026-07-24 04:18:52','2026-08-05 07:24:09'),(18,'gf','gf','26030008',NULL,NULL,'$2y$12$EH.arMZ1BrFzE7j6MafuoeaFDnY6/.jwBeiUgcOJyIYCWqzoT72dO','koordinator',2,1,NULL,1,1,NULL,'2026-07-24 04:19:08','2026-08-05 07:24:09'),(19,'etge','hrj','26030006',NULL,NULL,'$2y$12$wdfG2TXiSY8wC77Vx7R8R.LTJdLw8/86GwtGNM9jNGW4A7kNN39kW','koordinator',2,1,NULL,1,1,NULL,'2026-07-24 04:19:33','2026-08-05 07:24:09'),(21,'ilyas','ilyas','26030011',NULL,NULL,'$2y$12$2hCtm91KfZJNyt/qKUtk1.Lo4ja6kb/3Oqem7YB1Ul//gKm4jLZ3G','user',5,1,NULL,1,1,NULL,'2026-07-31 08:22:29','2026-08-05 07:24:09'),(22,'jors','jors','26030012',NULL,NULL,'$2y$12$2RX896vTntACypW/7/S8iOItRTxioa.lOD9ob/BJQ.HQdPfxvsQ7K','user',8,1,NULL,1,1,NULL,'2026-08-03 04:01:28','2026-08-05 07:24:09');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_pajak_requests`
--

DROP TABLE IF EXISTS `vehicle_pajak_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_pajak_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` bigint unsigned NOT NULL,
  `requested_by` bigint unsigned DEFAULT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` decimal(20,2) NOT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_pajak_requests_vehicle_id_foreign` (`vehicle_id`),
  KEY `vehicle_pajak_requests_approved_by_foreign` (`approved_by`),
  KEY `vehicle_pajak_requests_requested_by_foreign` (`requested_by`),
  CONSTRAINT `vehicle_pajak_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `vehicle_pajak_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vehicle_pajak_requests_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_pajak_requests`
--

LOCK TABLES `vehicle_pajak_requests` WRITE;
/*!40000 ALTER TABLE `vehicle_pajak_requests` DISABLE KEYS */;
INSERT INTO `vehicle_pajak_requests` VALUES (1,1,NULL,'tahunan',0.00,NULL,'pending',NULL,NULL,NULL,'2026-07-29 09:26:40','2026-07-29 09:26:40'),(2,1,NULL,'5_tahunan',0.00,NULL,'pending',NULL,NULL,NULL,'2026-07-29 09:26:40','2026-07-29 09:26:40');
/*!40000 ALTER TABLE `vehicle_pajak_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `biaya_pajak_tahunan` decimal(15,2) DEFAULT NULL,
  `biaya_pajak_5_tahun` decimal(15,2) DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicles_plat_nomor_unique` (`plat_nomor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,'Toyota xenia','tes','toyota','D 1234 CS',2023,'Hitam','121212121212','21212123333333',NULL,'2026-07-25','2026-08-01','Milik Perusahaan',0.00,20000.00,NULL,'Admin General Affairs','admin','tes','2026-07-29 09:24:19','2026-07-29 09:34:02');
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weekly_meeting_contributions`
--

DROP TABLE IF EXISTS `weekly_meeting_contributions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `weekly_meeting_contributions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `what_to_discuss` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weekly_meeting_contributions_session_id_foreign` (`session_id`),
  KEY `weekly_meeting_contributions_user_id_foreign` (`user_id`),
  CONSTRAINT `weekly_meeting_contributions_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `weekly_meeting_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `weekly_meeting_contributions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weekly_meeting_contributions`
--

LOCK TABLES `weekly_meeting_contributions` WRITE;
/*!40000 ALTER TABLE `weekly_meeting_contributions` DISABLE KEYS */;
/*!40000 ALTER TABLE `weekly_meeting_contributions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weekly_meeting_invitations`
--

DROP TABLE IF EXISTS `weekly_meeting_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `weekly_meeting_invitations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `weekly_meeting_invitations_session_id_user_id_unique` (`session_id`,`user_id`),
  KEY `weekly_meeting_invitations_user_id_foreign` (`user_id`),
  CONSTRAINT `weekly_meeting_invitations_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `weekly_meeting_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `weekly_meeting_invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weekly_meeting_invitations`
--

LOCK TABLES `weekly_meeting_invitations` WRITE;
/*!40000 ALTER TABLE `weekly_meeting_invitations` DISABLE KEYS */;
INSERT INTO `weekly_meeting_invitations` VALUES (1,1,1,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(2,1,2,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(3,1,3,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(4,1,4,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(5,1,5,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(6,1,6,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(8,1,8,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(9,1,9,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(10,1,10,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(11,1,11,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(12,1,12,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(13,1,13,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(14,1,14,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(15,1,15,0,NULL,'2026-07-20 09:01:09','2026-07-20 09:01:09'),(16,2,1,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(17,2,2,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(18,2,3,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(19,2,4,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(20,2,5,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(21,2,6,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(22,2,8,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(23,2,9,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(24,2,10,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(25,2,11,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(26,2,12,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(27,2,13,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(28,2,14,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(29,2,15,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(30,2,16,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(31,2,17,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(32,2,18,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(33,2,19,0,NULL,'2026-07-27 02:56:56','2026-07-27 02:56:56'),(34,3,1,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(35,3,2,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(36,3,3,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(37,3,4,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(38,3,5,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(39,3,6,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(40,3,8,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(41,3,9,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(42,3,10,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(43,3,11,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(44,3,12,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(45,3,13,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(46,3,14,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(47,3,15,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(48,3,16,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(49,3,17,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(50,3,18,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(51,3,19,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(52,3,21,0,NULL,'2026-08-03 03:17:26','2026-08-03 03:17:26'),(53,3,22,0,NULL,'2026-08-03 04:01:35','2026-08-03 04:01:35');
/*!40000 ALTER TABLE `weekly_meeting_invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weekly_meeting_sessions`
--

DROP TABLE IF EXISTS `weekly_meeting_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `weekly_meeting_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `weekly_meeting_id` bigint unsigned NOT NULL,
  `session_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `actual_end_time` time DEFAULT NULL,
  `status` enum('active','extended','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `weekly_meeting_sessions_weekly_meeting_id_session_date_unique` (`weekly_meeting_id`,`session_date`),
  CONSTRAINT `weekly_meeting_sessions_weekly_meeting_id_foreign` FOREIGN KEY (`weekly_meeting_id`) REFERENCES `weekly_meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weekly_meeting_sessions`
--

LOCK TABLES `weekly_meeting_sessions` WRITE;
/*!40000 ALTER TABLE `weekly_meeting_sessions` DISABLE KEYS */;
INSERT INTO `weekly_meeting_sessions` VALUES (1,1,'2026-07-20','13:00:00','15:00:00','10:03:20','completed','2026-07-20 09:01:09','2026-07-23 03:03:20'),(2,1,'2026-07-27','13:00:00','15:00:00','08:25:18','completed','2026-07-27 02:56:56','2026-07-29 01:25:18'),(3,1,'2026-08-03','13:00:00','15:00:00','10:26:52','completed','2026-08-03 03:17:26','2026-08-04 03:26:52');
/*!40000 ALTER TABLE `weekly_meeting_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weekly_meetings`
--

DROP TABLE IF EXISTS `weekly_meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `weekly_meetings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Weekly Meeting',
  `day_of_week` tinyint NOT NULL COMMENT '1=Monday, ..., 7=Sunday',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weekly_meetings_room_id_foreign` (`room_id`),
  KEY `weekly_meetings_created_by_foreign` (`created_by`),
  CONSTRAINT `weekly_meetings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `weekly_meetings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weekly_meetings`
--

LOCK TABLES `weekly_meetings` WRITE;
/*!40000 ALTER TABLE `weekly_meetings` DISABLE KEYS */;
INSERT INTO `weekly_meetings` VALUES (1,1,'Weekly Meeting',1,'13:00:00','15:00:00',1,1,'2026-07-15 08:40:17','2026-07-15 08:40:17');
/*!40000 ALTER TABLE `weekly_meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wifi_payments`
--

DROP TABLE IF EXISTS `wifi_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wifi_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `requested_by` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `period` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bulanan',
  PRIMARY KEY (`id`),
  KEY `wifi_payments_requested_by_foreign` (`requested_by`),
  KEY `wifi_payments_approved_by_foreign` (`approved_by`),
  KEY `idx_wifi_status_masa` (`status`,`masa_tenggang`),
  CONSTRAINT `wifi_payments_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `wifi_payments_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wifi_payments`
--

LOCK TABLES `wifi_payments` WRITE;
/*!40000 ALTER TABLE `wifi_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `wifi_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'officejohen'
--

--
-- Dumping routines for database 'officejohen'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-06 10:20:11
