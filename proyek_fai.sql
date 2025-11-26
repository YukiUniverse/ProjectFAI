-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 09:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
/*
tambahan role untuk entry
Role	Username / Email	Password	Keterangan
Admin	admin@kampus.ac.id	password	Akses penuh dashboard admin
Siswa	budi@mhs.kampus.ac.id	password	Login menggunakan Data Budi Santoso (NRP: S1001)
Dosen	siti@dosen.kampus.ac.id	password	Login menggunakan Data Dr. Siti Aminah (Kode: D001)
*/
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyek_fai`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_departments`
--

CREATE TABLE `academic_departments` (
  `department_id` int(10) UNSIGNED NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_departments`
--

INSERT INTO `academic_departments` (`department_id`, `department_name`, `created_at`, `updated_at`) VALUES
(1, 'Informatika', NULL, NULL),
(2, 'DKV', NULL, NULL),
(3, 'Sistem Informasi', NULL, NULL),
(4, 'Teknik Informatika', '2025-11-25 05:47:18', '2025-11-25 05:47:18'),
(5, 'Sistem Informasi', '2025-11-25 05:47:18', '2025-11-25 05:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `activity_schedules`
--

CREATE TABLE `activity_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_activity_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_schedules`
--

INSERT INTO `activity_schedules` (`id`, `student_activity_id`, `title`, `start_time`, `end_time`, `location`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Technical Meeting', '2024-10-09 10:00:00', '2024-10-09 12:00:00', 'Zoom Meeting', 'completed', NULL, '2025-11-24 22:40:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_structures`
--

CREATE TABLE `activity_structures` (
  `activity_structure_id` int(10) UNSIGNED NOT NULL,
  `student_activity_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `student_role_id` int(10) UNSIGNED NOT NULL,
  `sub_role_id` int(10) UNSIGNED DEFAULT NULL,
  `structure_name` varchar(255) DEFAULT NULL,
  `structure_points` int(11) DEFAULT NULL,
  `final_point_percentage` double NOT NULL DEFAULT 100,
  `final_review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_structures`
--

INSERT INTO `activity_structures` (`activity_structure_id`, `student_activity_id`, `student_id`, `student_role_id`, `sub_role_id`, `structure_name`, `structure_points`, `final_point_percentage`, `final_review`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, 'Project Manager', 200, 100, NULL, '2025-11-24 22:40:30', NULL),
(2, 1, 2, 4, 3, 'Head of Creative & Media', 150, 100, 'Kerja bagus, rating dari anggota tinggi.', '2025-11-24 22:40:30', NULL),
(3, 2, 2, 1, 2, 'Exhibition Director', 250, 100, 'Kerja bagus, rating dari anggota tinggi.', '2025-10-24 22:40:30', NULL),
(4, 2, 3, 2, 1, 'Main Secretary', 180, 100, NULL, '2025-10-24 22:40:30', NULL),
(5, 2, 1, 3, 3, 'Logistics Staff', 100, 100, NULL, '2025-10-24 22:40:30', NULL),
(6, 3, 4, 1, 1, 'Head of Tournament', 220, 100, NULL, '2025-11-24 22:40:30', NULL),
(7, 1, 3, 3, 2, 'Graphic Designer', 100, 100, NULL, '2025-11-24 22:40:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `lecturer_id` int(10) UNSIGNED NOT NULL,
  `lecturer_code` varchar(10) NOT NULL,
  `lecturer_name` varchar(255) NOT NULL,
  `employee_nip` varchar(11) NOT NULL,
  `nidn` varchar(10) DEFAULT NULL,
  `employment_status` varchar(20) NOT NULL DEFAULT 'active',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_certified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`lecturer_id`, `lecturer_code`, `lecturer_name`, `employee_nip`, `nidn`, `employment_status`, `start_date`, `end_date`, `is_certified`, `created_at`, `updated_at`) VALUES
(1, 'L001', 'Prof. Sylvie Tan', 'EMP90001', '998877', 'active', '2015-08-01', '2099-12-31', 1, '2025-11-24 22:40:28', NULL),
(2, 'L014', 'Dr. Kenji Rao', 'EMP90014', '887766', 'active', '2018-01-15', '2099-12-31', 0, '2025-11-24 22:40:28', NULL),
(3, 'L022', 'Ir. Paula Este', 'EMP90022', '776655', 'active', '2012-06-10', '2099-12-31', 1, '2025-11-24 22:40:28', NULL),
(4, 'D001', 'Dr. Siti Aminah', '19850101', '001001', 'active', '2020-01-01', '2030-01-01', 1, '2025-11-25 05:47:18', '2025-11-25 05:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_11_19_022141_create_master_tables', 1),
(4, '2025_11_19_022223_create_activities_tables', 1),
(5, '2025_11_19_022303_create_recruitment_tables', 1),
(6, '2025_11_19_022344_create_ops_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `proposals`
--

INSERT INTO `proposals` (`id`, `student_id`, `title`, `description`, `status`, `reject_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 'Innovation Hackday 2024', 'Proposal kegiatan kompetisi pengembangan perangkat lunak tingkat universitas.', 'accepted', NULL, '2025-11-24 22:40:30', NULL),
(2, 2, 'Chromatic: Visual Art Exhibition', 'Pameran karya seni mahasiswa DKV.', 'accepted', NULL, '2025-10-24 22:40:30', NULL),
(3, 4, 'Campus Valorant Championship', 'Turnamen Valorant antar fakultas.', 'accepted', NULL, '2025-11-22 22:40:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recruitment_answers`
--

CREATE TABLE `recruitment_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recruitment_registration_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answer_text` text DEFAULT NULL,
  `interviewer_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recruitment_answers`
--

INSERT INTO `recruitment_answers` (`id`, `recruitment_registration_id`, `question_id`, `answer_text`, `interviewer_note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Ingin cari pengalaman', 'Semangat tinggi', NULL, NULL),
(2, 1, 2, 'Bisa banget kak', 'Portofolio valid', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recruitment_decisions`
--

CREATE TABLE `recruitment_decisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recruitment_registration_id` bigint(20) UNSIGNED NOT NULL,
  `judge_student_id` int(10) UNSIGNED NOT NULL,
  `verdict` enum('accept','reject') NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recruitment_decisions`
--

INSERT INTO `recruitment_decisions` (`id`, `recruitment_registration_id`, `judge_student_id`, `verdict`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'accept', 'Skill match dengan kebutuhan divisi', '2025-11-24 22:40:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recruitment_questions`
--

CREATE TABLE `recruitment_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_activity_id` int(10) UNSIGNED NOT NULL,
  `sub_role_id` int(10) UNSIGNED DEFAULT NULL,
  `question` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recruitment_questions`
--

INSERT INTO `recruitment_questions` (`id`, `student_activity_id`, `sub_role_id`, `question`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Apa motivasi kamu?', NULL, NULL),
(2, 1, 3, 'Bisa pakai Adobe Illustrator?', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recruitment_registrations`
--

CREATE TABLE `recruitment_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_activity_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `choice_1_sub_role_id` int(10) UNSIGNED NOT NULL,
  `reason_1` text NOT NULL,
  `choice_2_sub_role_id` int(10) UNSIGNED DEFAULT NULL,
  `reason_2` text DEFAULT NULL,
  `status` enum('pending','interview','accepted','rejected') NOT NULL DEFAULT 'pending',
  `decision_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recruitment_registrations`
--

INSERT INTO `recruitment_registrations` (`id`, `student_activity_id`, `student_id`, `choice_1_sub_role_id`, `reason_1`, `choice_2_sub_role_id`, `reason_2`, `status`, `decision_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2, 'Saya suka desain', 3, 'Saya kuat angkat barang', 'accepted', 'Portofolio sangat memuaskan', '2025-11-24 22:40:30', NULL),
(2, 1, 4, 2, 'Iseng aja', NULL, NULL, 'rejected', 'Tidak serius saat wawancara', '2025-11-24 22:40:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(10) UNSIGNED NOT NULL,
  `student_number` varchar(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `points_balance` int(11) NOT NULL DEFAULT 0,
  `class_group` char(1) NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_number`, `full_name`, `points_balance`, `class_group`, `department_id`, `created_at`, `updated_at`) VALUES
(1, '241000001', 'Iris Kalani', 50, 'A', 1, NULL, NULL),
(2, '241000452', 'Mateo Lin', 30, 'B', 2, NULL, NULL),
(3, '251000233', 'Sora Veld', 0, 'C', 3, NULL, NULL),
(4, '251000999', 'Riku Tendo', 0, 'A', 1, NULL, NULL),
(5, 'S1001', 'Budi Santoso', 0, 'A', 1, '2025-11-25 05:47:18', '2025-11-25 05:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `student_activities`
--

CREATE TABLE `student_activities` (
  `student_activity_id` int(10) UNSIGNED NOT NULL,
  `proposal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity_code` varchar(25) NOT NULL,
  `activity_catalog_code` varchar(10) NOT NULL,
  `student_organization_id` int(10) UNSIGNED NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `activity_description` text DEFAULT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `status` enum('preparation','open_recruitment','interview','active','grading_1','grading_2','finished') NOT NULL DEFAULT 'preparation',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_activities`
--

INSERT INTO `student_activities` (`student_activity_id`, `proposal_id`, `activity_code`, `activity_catalog_code`, `student_organization_id`, `activity_name`, `activity_description`, `start_datetime`, `end_datetime`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ACT1001', 'EVT', 1, 'Innovation Hackday 2024', 'Bergabunglah dalam maraton koding 24 jam di mana inovasi bertemu dengan eksekusi! Tantang dirimu untuk menyelesaikan masalah nyata menggunakan teknologi terkini (AI, IoT, Blockchain) dan menangkan total hadiah puluhan juta rupiah. Siapkan tim terbaikmu!', '2024-11-10 09:00:00', '2024-11-11 15:00:00', 'grading_1', '2025-11-24 22:40:30', NULL),
(2, 2, 'ACT2005', 'EXH', 2, 'Chromatic Exhibition 2024', 'Selami dunia penuh warna di Chromatic 2024! Pameran seni visual interaktif yang menggabungkan seni tradisional dan digital projection mapping. Saksikan karya terbaik dari mahasiswa berbakat yang akan memanjakan matamu.', '2025-11-30 05:40:30', '2025-12-02 05:40:30', 'active', '2025-10-24 22:40:30', NULL),
(3, 3, 'ACT3099', 'CMP', 1, 'Valorant Championship: Retake', 'Buktikan skill aim-mu di turnamen Valorant terbesar se-kampus! Rebut prize pool total Rp 5.000.000 dan gelar juara bertahan. Dilengkapi dengan live stream caster profesional dan setup PC high-end di auditorium utama.', '2024-12-20 10:00:00', '2024-12-22 20:00:00', 'preparation', '2025-11-24 22:40:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_organizations`
--

CREATE TABLE `student_organizations` (
  `student_organization_id` int(10) UNSIGNED NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_organizations`
--

INSERT INTO `student_organizations` (`student_organization_id`, `organization_name`, `created_at`, `updated_at`) VALUES
(1, 'Himpunan Mahasiswa Informatika', NULL, NULL),
(2, 'Badan Eksekutif Mahasiswa', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_ratings`
--

CREATE TABLE `student_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_activity_id` int(10) UNSIGNED NOT NULL,
  `rater_student_id` int(10) UNSIGNED NOT NULL,
  `rated_student_id` int(10) UNSIGNED NOT NULL,
  `stars` int(11) NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_ratings`
--

INSERT INTO `student_ratings` (`id`, `student_activity_id`, `rater_student_id`, `rated_student_id`, `stars`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2, 4, 'Koor paling asik dan membimbing', '2025-11-24 22:40:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_roles`
--

CREATE TABLE `student_roles` (
  `student_role_id` int(10) UNSIGNED NOT NULL,
  `role_code` varchar(10) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_roles`
--

INSERT INTO `student_roles` (`student_role_id`, `role_code`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'LEAD', 'Team Lead', NULL, NULL),
(2, 'NOTE', 'Secretary', NULL, NULL),
(3, 'MEBR', 'Member', NULL, NULL),
(4, 'COOR', 'Coordinator', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_roles`
--

CREATE TABLE `sub_roles` (
  `sub_role_id` int(10) UNSIGNED NOT NULL,
  `sub_role_code` varchar(10) NOT NULL,
  `sub_role_name` varchar(255) NOT NULL,
  `sub_role_name_en` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_roles`
--

INSERT INTO `sub_roles` (`sub_role_id`, `sub_role_code`, `sub_role_name`, `sub_role_name_en`, `created_at`, `updated_at`) VALUES
(1, 'SR01', 'BPH', 'Main', NULL, NULL),
(2, 'SR02', 'Acara', 'Event', NULL, NULL),
(3, 'SR03', 'Media', 'Media', NULL, NULL),
(4, 'SR04', 'Logistik', 'Logistics', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `student_number` varchar(255) DEFAULT NULL,
  `lecturer_code` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `student_number`, `lecturer_code`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Iris', 'user1@mail.com', '$2y$12$aDsSYX.rVFDlSHwWXVWcE.aoCtoDeTRVgWMHioLKaxCV0u3Hoo69.', '241000001', NULL, 'student', NULL, NULL, NULL),
(2, 'Mateo', 'user2@mail.com', '$2y$12$TWbKgeEOxWTAYCgb2twk7.So/W1aFZIZtmBolR/HlM77ACyWja5ni', '241000452', NULL, 'student', NULL, NULL, NULL),
(3, 'Sora', 'user3@mail.com', '$2y$12$OJo.ghjvY3C2.lB2QoWInODexf7oRmAz6z24utkMtBgsml6RVHTnC', '251000233', NULL, 'student', NULL, NULL, NULL),
(4, 'Riku', 'user4@mail.com', '$2y$12$8MGN3avWLeiDkjXJM4C0X.gRTZe5O/y2fv.VzwSFPxjJbguG1QTOa', '251000999', NULL, 'student', NULL, NULL, NULL),
(5, 'Prof. Sylvie Tan', 'user5@mail.com', '$2y$12$1FyCEnF9TEieC3ATBVOiPOZX6GSa23PFY74sy2zvDsgjTABGhByNK', NULL, 'L001', 'lecturer', NULL, NULL, NULL),
(6, 'Ir. Paula Este', 'admin@mail.com', '$2y$12$O31s9uZyhA8Tkuk5iroibOn.GZJHB6quFaFEyj45oMCXIhyqa1jb6', NULL, 'L022', 'admin', NULL, NULL, NULL),
(7, 'Admin Utama', 'admin@kampus.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 'admin', NULL, '2025-11-25 05:47:18', '2025-11-25 05:47:18'),
(8, 'Budi Santoso', 'budi@mhs.kampus.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'S1001', NULL, 'student', NULL, '2025-11-25 05:47:18', '2025-11-25 05:47:18'),
(9, 'Dr. Siti Aminah', 'siti@dosen.kampus.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'D001', 'dosen', NULL, '2025-11-25 05:47:18', '2025-11-25 05:47:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_departments`
--
ALTER TABLE `academic_departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `activity_schedules`
--
ALTER TABLE `activity_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_schedules_student_activity_id_foreign` (`student_activity_id`);

--
-- Indexes for table `activity_structures`
--
ALTER TABLE `activity_structures`
  ADD PRIMARY KEY (`activity_structure_id`),
  ADD KEY `activity_structures_student_activity_id_foreign` (`student_activity_id`),
  ADD KEY `activity_structures_student_id_foreign` (`student_id`),
  ADD KEY `activity_structures_student_role_id_foreign` (`student_role_id`),
  ADD KEY `activity_structures_sub_role_id_foreign` (`sub_role_id`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`lecturer_id`),
  ADD UNIQUE KEY `lecturers_lecturer_code_unique` (`lecturer_code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposals_student_id_foreign` (`student_id`);

--
-- Indexes for table `recruitment_answers`
--
ALTER TABLE `recruitment_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recruitment_answers_recruitment_registration_id_foreign` (`recruitment_registration_id`),
  ADD KEY `recruitment_answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `recruitment_decisions`
--
ALTER TABLE `recruitment_decisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recruitment_decisions_recruitment_registration_id_foreign` (`recruitment_registration_id`),
  ADD KEY `recruitment_decisions_judge_student_id_foreign` (`judge_student_id`);

--
-- Indexes for table `recruitment_questions`
--
ALTER TABLE `recruitment_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recruitment_questions_student_activity_id_foreign` (`student_activity_id`),
  ADD KEY `recruitment_questions_sub_role_id_foreign` (`sub_role_id`);

--
-- Indexes for table `recruitment_registrations`
--
ALTER TABLE `recruitment_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recruitment_registrations_student_activity_id_foreign` (`student_activity_id`),
  ADD KEY `recruitment_registrations_student_id_foreign` (`student_id`),
  ADD KEY `recruitment_registrations_choice_1_sub_role_id_foreign` (`choice_1_sub_role_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `students_student_number_unique` (`student_number`),
  ADD KEY `students_department_id_foreign` (`department_id`);

--
-- Indexes for table `student_activities`
--
ALTER TABLE `student_activities`
  ADD PRIMARY KEY (`student_activity_id`),
  ADD UNIQUE KEY `student_activities_activity_code_unique` (`activity_code`),
  ADD KEY `student_activities_proposal_id_foreign` (`proposal_id`),
  ADD KEY `student_activities_student_organization_id_foreign` (`student_organization_id`);

--
-- Indexes for table `student_organizations`
--
ALTER TABLE `student_organizations`
  ADD PRIMARY KEY (`student_organization_id`);

--
-- Indexes for table `student_ratings`
--
ALTER TABLE `student_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_ratings_student_activity_id_foreign` (`student_activity_id`),
  ADD KEY `student_ratings_rater_student_id_foreign` (`rater_student_id`),
  ADD KEY `student_ratings_rated_student_id_foreign` (`rated_student_id`);

--
-- Indexes for table `student_roles`
--
ALTER TABLE `student_roles`
  ADD PRIMARY KEY (`student_role_id`),
  ADD UNIQUE KEY `student_roles_role_code_unique` (`role_code`);

--
-- Indexes for table `sub_roles`
--
ALTER TABLE `sub_roles`
  ADD PRIMARY KEY (`sub_role_id`),
  ADD UNIQUE KEY `sub_roles_sub_role_code_unique` (`sub_role_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_student_number_foreign` (`student_number`),
  ADD KEY `users_lecturer_code_foreign` (`lecturer_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_departments`
--
ALTER TABLE `academic_departments`
  MODIFY `department_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `activity_schedules`
--
ALTER TABLE `activity_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_structures`
--
ALTER TABLE `activity_structures`
  MODIFY `activity_structure_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `lecturer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recruitment_answers`
--
ALTER TABLE `recruitment_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recruitment_decisions`
--
ALTER TABLE `recruitment_decisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recruitment_questions`
--
ALTER TABLE `recruitment_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recruitment_registrations`
--
ALTER TABLE `recruitment_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_activities`
--
ALTER TABLE `student_activities`
  MODIFY `student_activity_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_organizations`
--
ALTER TABLE `student_organizations`
  MODIFY `student_organization_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_ratings`
--
ALTER TABLE `student_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_roles`
--
ALTER TABLE `student_roles`
  MODIFY `student_role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_roles`
--
ALTER TABLE `sub_roles`
  MODIFY `sub_role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_schedules`
--
ALTER TABLE `activity_schedules`
  ADD CONSTRAINT `activity_schedules_student_activity_id_foreign` FOREIGN KEY (`student_activity_id`) REFERENCES `student_activities` (`student_activity_id`);

--
-- Constraints for table `activity_structures`
--
ALTER TABLE `activity_structures`
  ADD CONSTRAINT `activity_structures_student_activity_id_foreign` FOREIGN KEY (`student_activity_id`) REFERENCES `student_activities` (`student_activity_id`),
  ADD CONSTRAINT `activity_structures_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `activity_structures_student_role_id_foreign` FOREIGN KEY (`student_role_id`) REFERENCES `student_roles` (`student_role_id`),
  ADD CONSTRAINT `activity_structures_sub_role_id_foreign` FOREIGN KEY (`sub_role_id`) REFERENCES `sub_roles` (`sub_role_id`);

--
-- Constraints for table `proposals`
--
ALTER TABLE `proposals`
  ADD CONSTRAINT `proposals_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `recruitment_answers`
--
ALTER TABLE `recruitment_answers`
  ADD CONSTRAINT `recruitment_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `recruitment_questions` (`id`),
  ADD CONSTRAINT `recruitment_answers_recruitment_registration_id_foreign` FOREIGN KEY (`recruitment_registration_id`) REFERENCES `recruitment_registrations` (`id`);

--
-- Constraints for table `recruitment_decisions`
--
ALTER TABLE `recruitment_decisions`
  ADD CONSTRAINT `recruitment_decisions_judge_student_id_foreign` FOREIGN KEY (`judge_student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `recruitment_decisions_recruitment_registration_id_foreign` FOREIGN KEY (`recruitment_registration_id`) REFERENCES `recruitment_registrations` (`id`);

--
-- Constraints for table `recruitment_questions`
--
ALTER TABLE `recruitment_questions`
  ADD CONSTRAINT `recruitment_questions_student_activity_id_foreign` FOREIGN KEY (`student_activity_id`) REFERENCES `student_activities` (`student_activity_id`),
  ADD CONSTRAINT `recruitment_questions_sub_role_id_foreign` FOREIGN KEY (`sub_role_id`) REFERENCES `sub_roles` (`sub_role_id`);

--
-- Constraints for table `recruitment_registrations`
--
ALTER TABLE `recruitment_registrations`
  ADD CONSTRAINT `recruitment_registrations_choice_1_sub_role_id_foreign` FOREIGN KEY (`choice_1_sub_role_id`) REFERENCES `sub_roles` (`sub_role_id`),
  ADD CONSTRAINT `recruitment_registrations_student_activity_id_foreign` FOREIGN KEY (`student_activity_id`) REFERENCES `student_activities` (`student_activity_id`),
  ADD CONSTRAINT `recruitment_registrations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `academic_departments` (`department_id`);

--
-- Constraints for table `student_activities`
--
ALTER TABLE `student_activities`
  ADD CONSTRAINT `student_activities_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`),
  ADD CONSTRAINT `student_activities_student_organization_id_foreign` FOREIGN KEY (`student_organization_id`) REFERENCES `student_organizations` (`student_organization_id`);

--
-- Constraints for table `student_ratings`
--
ALTER TABLE `student_ratings`
  ADD CONSTRAINT `student_ratings_rated_student_id_foreign` FOREIGN KEY (`rated_student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `student_ratings_rater_student_id_foreign` FOREIGN KEY (`rater_student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `student_ratings_student_activity_id_foreign` FOREIGN KEY (`student_activity_id`) REFERENCES `student_activities` (`student_activity_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_lecturer_code_foreign` FOREIGN KEY (`lecturer_code`) REFERENCES `lecturers` (`lecturer_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_student_number_foreign` FOREIGN KEY (`student_number`) REFERENCES `students` (`student_number`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
