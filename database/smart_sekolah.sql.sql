-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 19 Jan 2026 pada 02.42
-- Versi server: 8.0.44-0ubuntu0.24.04.2
-- Versi PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `classrooms`
--

CREATE TABLE `classrooms` (
  `id` bigint NOT NULL,
  `school_id` bigint NOT NULL,
  `entry_year` int NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='contoh class_name: RPL 1, angkatan disimpan terpisah';

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `image_generation_histories`
--

CREATE TABLE `image_generation_histories` (
  `id` bigint NOT NULL,
  `user_input` text NOT NULL,
  `image_style_id` int NOT NULL,
  `reference` text NOT NULL,
  `output_file_path` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `image_models`
--

CREATE TABLE `image_models` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `learning_modules`
--

CREATE TABLE `learning_modules` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `classroom` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `summary` text,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prompt_image_generation`
--

CREATE TABLE `prompt_image_generation` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `preview_path` varchar(255) NOT NULL,
  `prompt` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `prompt_image_generation`
--

INSERT INTO `prompt_image_generation` (`id`, `name`, `preview_path`, `prompt`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(4, 'Gambar Realistis', '/assets/image/ai/realistis.png', 'Buat Gambar realistis dari {{description}}, pencahayaan alami, detail jelas, fokus tajam, resolusi standar, ukuran file minimal, tanpa efek berlebihan, tanpa gaya kartun atau ilustrasi.', '2026-01-04 00:50:09', 1, '2026-01-11 13:38:14', 2, NULL, NULL),
(5, 'Cat Air', '/assets/image/ai/cat-air.png', 'Buat Lukisan cat air dari {{description}}, sapuan kuas lembut, warna tipis dan bersih, tekstur sederhana, resolusi standar, ukuran file minimal, tampilan jelas dan tidak ramai.', '2026-01-04 02:49:13', 1, '2026-01-11 13:38:04', 2, NULL, NULL),
(6, 'Infografis', '/assets/image/ai/infografis.png', 'Buat Ilustrasi infografis dari {{description}}, gunakan teks berbahasa Indonesia, tata letak rapi, ikon sederhana, warna terbatas, resolusi standar, ukuran file minimal, teks harus jelas dan mudah dibaca.', '2026-01-04 03:14:43', 1, '2026-01-11 13:37:54', 2, NULL, NULL),
(7, 'Sketsa Pensil', '/assets/image/ai/sketsa-pensil.png', 'Buat sketsa pensil sederhana yang menggambarkan {{description}} untuk materi pembelajaran sekolah. Utamakan kejelasan tulisan dan bentuk utama, gunakan resolusi rendah dan ukuran file minimal.', '2026-01-04 05:57:55', 1, '2026-01-11 13:37:22', 2, NULL, NULL),
(8, 'Vektor Datar', '/assets/image/ai/vektor-datar.png', 'Buat Ilustrasi vektor sederhana dari {{description}}, garis bersih, warna solid, tanpa gradasi dan bayangan, detail minimal, resolusi standar, ukuran file minimal, fokus pada kejelasan bentuk.', '2026-01-04 06:01:37', 1, '2026-01-11 13:37:06', 2, NULL, NULL),
(9, '3D Kartun', '/assets/image/ai/3d-kartun.png', 'Buat Ilustrasi 3D kartun dari {{description}}, bentuk sederhana, proporsi ramah, warna lembut, detail secukupnya, resolusi standar, ukuran file minimal, fokus pada kejelasan visual.', '2026-01-06 15:21:06', 1, '2026-01-11 13:36:56', 2, NULL, NULL);
-- --------------------------------------------------------

--
-- Struktur dari tabel `prompt_text_generation`
--

CREATE TABLE `prompt_text_generation` (
  `id` bigint NOT NULL,
  `categories` varchar(255) NOT NULL,
  `text_prompt` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `prompt_text_generation`
--

INSERT INTO `prompt_text_generation` (`id`, `categories`, `text_prompt`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'MODULBELAJAR', 'Role: Professional Curriculum Developer\r\nTask: Create a structured \"Modul Pembelajaran\" based on the input description.\r\nOutput Language: Bahasa Indonesia (Strictly).\r\n\r\nSTYLE & FORMATTING RULES:\r\n1. Use Markdown Headers (#, ##, ###) strictly for section titles.\r\n2. Do NOT use bold formatting (**text**) inside normal paragraphs. Only use it for Table Headers or specific terms if absolutely necessary.\r\n3. Tables: Ensure all tables have valid Markdown syntax with headers and rows aligned.\r\n4. Lists: Use proper Markdown numbering (1. , 2. ) or bullets (- ) with a blank line between items to ensure readability.\r\n5. Evaluasi Section: MUST be formatted as a Numbered List (1., 2., 3.) with clear formatting for fill-in-the-blanks (use ______).\r\n\r\nCONTENT STRUCTURE:\r\n\r\n# [MODUL TITLE - UPPERCASE]\r\n## [Subtitle/Specific Topic]\r\n([Target Audience])\r\n\r\n## 1. PENGENALAN DAN TUJUAN\r\n- Markdown Table: | Nama Modul | Target Peserta | Alokasi Waktu | Pengajar |\r\n### A. Selamat Datang!\r\n- (A welcoming paragraph introducing the topic excitingly).\r\n### B. Tujuan Pembelajaran\r\n- (List of 3-4 specific learning objectives using bullet points).\r\n\r\n## 2. MATERI INTI: [TOPIC NAME]\r\n(Divide content into 3 logical sub-sessions. Use this format):\r\n\r\n### Sesi 2.1. [Sub-Topic 1 Name]\r\n- Explanation of the concept/era.\r\n- Key Details.\r\n- Tahukah Kamu?: (One interesting trivia fact).\r\n\r\n### Sesi 2.2. [Sub-Topic 2 Name]\r\n- Explanation of the concept/era.\r\n- Key Details.\r\n\r\n### Sesi 2.3. [Sub-Topic 3 Name]\r\n- Explanation of the concept/era.\r\n- Legacy/Impact.\r\n\r\n## 3. AKTIVITAS DAN DISKUSI\r\n### Aktivitas 3.1. [Activity Name] (Individual)\r\n- (Description of task).\r\n- (Provide an Answer Key if applicable).\r\n### Aktivitas 3.2. [Project Name] (Diskusi Kelompok)\r\n- (Scenario-based question for discussion).\r\n\r\n## 4. RANGKUMAN DAN KATA KUNCI\r\n### A. Rangkuman Materi\r\n- (A brief paragraph summarizing the 3 sessions).\r\n### B. Kata Kunci Penting\r\n- Markdown Table: | Kata Kunci | Arti Singkat | (List 4-5 keywords).\r\n\r\n## 5. UJI PEMAHAMAN (EVALUASI)\r\n(Instructions: Create 5 questions. MUST use a numbered list format. Do not combine into one paragraph).\r\n\r\n[Closing Sentence: Congratulate the student]\r\n\r\nINPUT DESCRIPTION:\r\n{{description}}', '2026-01-08 01:23:59', 1, NULL, NULL, NULL, NULL),
(2, 'PPT', 'You are an educational content generator.The input description is written in English.You MUST generate the output in Bahasa Indonesia.Description:{{description}}Content category:PPT Outline (Teacher Material)OUTPUT RULES:- Output MUST be valid Markdown- Use a clear and clean table format- Do NOT output JSON- Do NOT include explanations or extra text outside the content- Do NOT wrap the output in code blocks- All text must be in Bahasa Indonesia- The result must directly resemble a teacher PPT outlineSTRUCTURE RULES:- Start with a main title using a level-1 heading (#)- Follow with a level-2 heading (##) for the topic description- Use ONE Markdown table with the following columns:  1. Slide  2. Judul Slide (Bahasa Indonesia)  3. Poin Utama & Visualisasi (Catatan Pengajar)TABLE CONTENT RULES:- Maximum 10 slides- Each slide represents one teaching idea- Column \"Poin Utama & Visualisasi\" MUST include:  - Visual:  - Tujuan:  - Catatan:- Use <br><br> to separate sections inside table cells- Language must be simple, student-friendly, and suitable for teaching- Focus on clarity and teaching intent, not lengthGenerate ONLY the Markdown content.', '2026-01-07 14:53:08', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint NOT NULL,
  `teacher_id` bigint NOT NULL,
  `classroom_id` bigint NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='kuis online ';

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz_answers`
--

CREATE TABLE `quiz_answers` (
  `id` bigint NOT NULL,
  `quiz_id` bigint NOT NULL,
  `question_id` bigint NOT NULL,
  `student_id` bigint NOT NULL,
  `answer_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz_options`
--

CREATE TABLE `quiz_options` (
  `id` bigint NOT NULL,
  `question_id` bigint NOT NULL,
  `option_label` varchar(255) DEFAULT NULL COMMENT 'A, B, C, D',
  `option_text` varchar(255) NOT NULL,
  `is_correct` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint NOT NULL,
  `quiz_id` bigint NOT NULL,
  `question` text NOT NULL,
  `question_type` varchar(255) DEFAULT NULL COMMENT 'multiple_choice, essay',
  `explanation` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` bigint NOT NULL,
  `quiz_id` bigint NOT NULL,
  `student_id` bigint NOT NULL,
  `score` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `schools`
--

CREATE TABLE `schools` (
  `id` bigint NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `mou_date` date DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `no_tlp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `grade` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `id` bigint NOT NULL,
  `school_id` bigint NOT NULL,
  `user_id` int NOT NULL,
  `classroom_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='1 siswa = 1 kelas aktif';

-- --------------------------------------------------------

--
-- Struktur dari tabel `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `task_date` date NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1: Todo, 2: In Progress, 3: Done',
  `task_category_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_categories`
--

CREATE TABLE `task_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint NOT NULL,
  `school_id` bigint NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `text_generation_histories`
--

CREATE TABLE `text_generation_histories` (
  `id` bigint NOT NULL,
  `user_input` text NOT NULL,
  `type` int DEFAULT NULL COMMENT '0 : PPT\r\n1 : Modul Belajar',
  `output_text` text NOT NULL,
  `output_file_path` text NOT NULL,
  `token_usage` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `school_id` int DEFAULT NULL,
  `access_type` int DEFAULT NULL COMMENT '1=SuperAdmin, 2=AdminSekolah, 3=Guru, 4=Siswa',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `is_active` tinyint DEFAULT NULL,
  `is_test` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='tabel user utama';

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `classrooms_schools_FK` (`school_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `image_generation_histories`
--
ALTER TABLE `image_generation_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_image_generation_created_by_users` (`created_by`),
  ADD KEY `fk_image_generation_updated_by_users` (`updated_by`),
  ADD KEY `fk_image_generation_deleted_by_users` (`deleted_by`),
  ADD KEY `fk_image_generation_image_style_id` (`image_style_id`);

--
-- Indeks untuk tabel `image_models`
--
ALTER TABLE `image_models`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `learning_modules`
--
ALTER TABLE `learning_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_learning_modules_subject` (`subject_id`),
  ADD KEY `fk_learning_modules_created_by` (`created_by`),
  ADD KEY `fk_learning_modules_updated_by` (`updated_by`),
  ADD KEY `fk_learning_modules_deleted_by` (`deleted_by`),
  ADD KEY `fk_learning_modules_school` (`school_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `prompt_image_generation`
--
ALTER TABLE `prompt_image_generation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prompt_image_generation_created_by_users` (`created_by`),
  ADD KEY `fk_prompt_image_generation_deleted_by_users` (`deleted_by`),
  ADD KEY `fk_prompt_image_generation_updated_by_users` (`updated_by`);

--
-- Indeks untuk tabel `prompt_text_generation`
--
ALTER TABLE `prompt_text_generation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prompt_text_generation_created_by_users` (`created_by`),
  ADD KEY `fk_prompt_text_generation_updated_by_users` (`updated_by`),
  ADD KEY `fk_prompt_text_generation_deleted_by_users` (`deleted_by`);

--
-- Indeks untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `quizzes_teachers_FK` (`teacher_id`),
  ADD KEY `quizzes_classrooms_FK` (`classroom_id`);

--
-- Indeks untuk tabel `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `quiz_answers_quizzes_FK` (`quiz_id`),
  ADD KEY `quiz_answers_quiz_questions_FK` (`question_id`);

--
-- Indeks untuk tabel `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `quiz_options_quiz_questions_FK` (`question_id`);

--
-- Indeks untuk tabel `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `quiz_questions_quizzes_FK` (`quiz_id`);

--
-- Indeks untuk tabel `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `quiz_results_quizzes_FK` (`quiz_id`),
  ADD KEY `quiz_results_students_FK` (`student_id`);

--
-- Indeks untuk tabel `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `students_schools_FK` (`school_id`),
  ADD KEY `students_users_FK` (`user_id`),
  ADD KEY `students_classrooms_FK` (`classroom_id`);

--
-- Indeks untuk tabel `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_task_category_id_foreign` (`task_category_id`);

--
-- Indeks untuk tabel `task_categories`
--
ALTER TABLE `task_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `teachers_users_FK` (`user_id`),
  ADD KEY `teachers_schools_FK` (`school_id`);

--
-- Indeks untuk tabel `text_generation_histories`
--
ALTER TABLE `text_generation_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tgh_created_by` (`created_by`),
  ADD KEY `fk_tgh_updated_by` (`updated_by`),
  ADD KEY `fk_tgh_deleted_by` (`deleted_by`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `image_generation_histories`
--
ALTER TABLE `image_generation_histories`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `image_models`
--
ALTER TABLE `image_models`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `learning_modules`
--
ALTER TABLE `learning_modules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `prompt_image_generation`
--
ALTER TABLE `prompt_image_generation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `prompt_text_generation`
--
ALTER TABLE `prompt_text_generation`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `quiz_answers`
--
ALTER TABLE `quiz_answers`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `quiz_options`
--
ALTER TABLE `quiz_options`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `task_categories`
--
ALTER TABLE `task_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `text_generation_histories`
--
ALTER TABLE `text_generation_histories`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `classrooms`
--
ALTER TABLE `classrooms`
  ADD CONSTRAINT `classrooms_schools_FK` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Ketidakleluasaan untuk tabel `image_generation_histories`
--
ALTER TABLE `image_generation_histories`
  ADD CONSTRAINT `fk_image_generation_created_by_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_image_generation_deleted_by_users` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_image_generation_image_style_id` FOREIGN KEY (`image_style_id`) REFERENCES `prompt_image_generation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_image_generation_updated_by_users` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `learning_modules`
--
ALTER TABLE `learning_modules`
  ADD CONSTRAINT `fk_learning_modules_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_learning_modules_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_learning_modules_school` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_learning_modules_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_learning_modules_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `prompt_image_generation`
--
ALTER TABLE `prompt_image_generation`
  ADD CONSTRAINT `fk_prompt_image_generation_created_by_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prompt_image_generation_deleted_by_users` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prompt_image_generation_updated_by_users` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `prompt_text_generation`
--
ALTER TABLE `prompt_text_generation`
  ADD CONSTRAINT `fk_prompt_text_generation_created_by_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_prompt_text_generation_deleted_by_users` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_prompt_text_generation_updated_by_users` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_classrooms_FK` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`),
  ADD CONSTRAINT `quizzes_teachers_FK` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Ketidakleluasaan untuk tabel `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD CONSTRAINT `quiz_answers_quiz_questions_FK` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`),
  ADD CONSTRAINT `quiz_answers_quizzes_FK` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Ketidakleluasaan untuk tabel `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD CONSTRAINT `quiz_options_quiz_questions_FK` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`);

--
-- Ketidakleluasaan untuk tabel `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_quizzes_FK` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Ketidakleluasaan untuk tabel `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_quizzes_FK` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `quiz_results_students_FK` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Ketidakleluasaan untuk tabel `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_classrooms_FK` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`),
  ADD CONSTRAINT `students_schools_FK` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `students_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_task_category_id_foreign` FOREIGN KEY (`task_category_id`) REFERENCES `task_categories` (`id`);

--
-- Ketidakleluasaan untuk tabel `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_schools_FK` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `teachers_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `text_generation_histories`
--
ALTER TABLE `text_generation_histories`
  ADD CONSTRAINT `fk_tgh_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tgh_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tgh_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
