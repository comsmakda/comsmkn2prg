-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2026 at 05:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `com_smkn2_pinrang`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` enum('hadir','izin','alpa') DEFAULT 'alpa',
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_sessions`
--

CREATE TABLE `attendance_sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nia_sequence`
--

CREATE TABLE `nia_sequence` (
  `tahun` year(4) NOT NULL,
  `last_seq` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nia_sequence`
--

INSERT INTO `nia_sequence` (`tahun`, `last_seq`) VALUES
('2026', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pab_registrations`
--

CREATE TABLE `pab_registrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `kelas` varchar(30) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pab_registrations`
--

INSERT INTO `pab_registrations` (`id`, `nama_lengkap`, `kelas`, `no_hp`, `password_hash`, `foto`, `status`, `catatan_admin`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Ikhsan', 'Alumni', '082197497924', '$2y$12$/jXrs2f2UxFr/yj6pKnjmueE7cj/XpxhOE0rD7WnUTYh2koynpHja', 'pab_1777691821_72f5bc46.png', 'approved', NULL, 2, '2026-05-02 03:17:01', '2026-05-02 03:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `label` varchar(150) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `label`, `updated_at`) VALUES
(1, 'org_name', 'COM SMKN 2 Pinrang', 'Nama Organisasi', '2026-05-02 02:59:59'),
(2, 'org_tagline', 'Creative, Outstanding, Meaningful', 'Tagline', '2026-05-02 02:59:59'),
(3, 'org_description', 'Organisasi siswa bidang komputer dan multimedia dan juga jaringan di SMKN 2 Pinrang.', 'Deskripsi', '2026-05-03 12:21:26'),
(4, 'org_vision', 'Menjadi organisasi siswa yang unggul dalam teknologi dan kreativitas.', 'Visi', '2026-05-02 02:59:59'),
(5, 'org_mission', '1. Mengembangkan kemampuan anggota di bidang IT.\r\n2. Membangun karakter pemimpin muda.\r\n3. Berinovasi untuk kemajuan sekolah.', 'Misi', '2026-05-02 12:05:35'),
(6, 'org_logo', 'logo_1777723535_0a66325a.png', 'Logo Organisasi', '2026-05-02 12:05:35'),
(7, 'hero_image', '', 'Gambar Hero', '2026-05-02 02:59:59'),
(8, 'contact_email', 'com@smkn2pinrang.sch.id', 'Email Kontak', '2026-05-02 02:59:59'),
(9, 'contact_phone', '', 'No HP Kontak', '2026-05-02 02:59:59'),
(10, 'pab_status', '1', 'Status PAB (1=Buka, 0=Tutup)', '2026-05-02 03:16:16'),
(11, 'pab_info', 'Pendaftaran anggota baru COM SMKN 2 Pinrang.', 'Info PAB', '2026-05-02 02:59:59'),
(12, 'pab_deadline', '', 'Batas Akhir PAB', '2026-05-02 02:59:59'),
(13, 'footer_text', '© 2024 COM SMKN 2 Pinrang. All rights reserved.', 'Teks Footer', '2026-05-02 02:59:59'),
(26, 'hero_badge_text', 'Organisasi Resmi · SMKN 2 Pinrang', 'Hero: Teks Badge', '2026-05-03 12:19:46'),
(27, 'org_photo', 'org_photo_1777810886_b20400f6.png', 'Foto Organisasi (About)', '2026-05-03 12:21:26'),
(29, 'stat_members', '100+', 'Statistik: Anggota Aktif', '2026-05-03 12:19:46'),
(30, 'stat_years', '5+', 'Statistik: Tahun Berdiri', '2026-05-03 12:19:46'),
(31, 'stat_events', '50+', 'Statistik: Kegiatan', '2026-05-03 12:19:46'),
(32, 'stat_awards', '20+', 'Statistik: Prestasi', '2026-05-03 12:19:46'),
(33, 'ticker_items', 'COM Academy|Penerimaan Anggota Baru|Tech Talk & Workshop|Creative Festival|Bakti Sosial Digital|Absensi Digital|Manajemen Anggota|Platform Modern', 'Ticker: Item (pisah dengan |)', '2026-05-03 12:19:46'),
(34, 'feature_1_title', 'Manajemen Anggota', 'Fitur 1: Judul', '2026-05-03 12:19:46'),
(35, 'feature_1_desc', 'Data anggota terorganisir dengan sistem NIA otomatis, status keanggotaan, dan riwayat lengkap.', 'Fitur 1: Deskripsi', '2026-05-03 12:19:46'),
(36, 'feature_2_title', 'Absensi Digital', 'Fitur 2: Judul', '2026-05-03 12:19:46'),
(37, 'feature_2_desc', 'Sistem presensi kegiatan berbasis web yang mudah dikelola admin dengan laporan cetak siap pakai.', 'Fitur 2: Deskripsi', '2026-05-03 12:19:46'),
(38, 'feature_3_title', 'Pendaftaran PAB', 'Fitur 3: Judul', '2026-05-03 12:19:46'),
(39, 'feature_3_desc', 'Penerimaan Anggota Baru online yang transparan dan terverifikasi admin secara real-time.', 'Fitur 3: Deskripsi', '2026-05-03 12:19:46'),
(40, 'feature_4_title', 'Profil Anggota', 'Fitur 4: Judul', '2026-05-03 12:19:46'),
(41, 'feature_4_desc', 'Dashboard pribadi untuk kelola profil, lihat surat pernyataan, dan riwayat keikutsertaan.', 'Fitur 4: Deskripsi', '2026-05-03 12:19:46'),
(42, 'feature_5_title', 'Keamanan Data', 'Fitur 5: Judul', '2026-05-03 12:19:46'),
(43, 'feature_5_desc', 'Proteksi CSRF, enkripsi password, dan manajemen sesi yang aman untuk seluruh data organisasi.', 'Fitur 5: Deskripsi', '2026-05-03 12:19:46'),
(44, 'feature_6_title', 'Admin Dashboard', 'Fitur 6: Judul', '2026-05-03 12:19:46'),
(45, 'feature_6_desc', 'Panel admin lengkap untuk mengelola seluruh data, verifikasi anggota, dan konfigurasi CMS.', 'Fitur 6: Deskripsi', '2026-05-03 12:19:46'),
(46, 'program_1_title', 'COM Academy', 'Program 1: Judul', '2026-05-03 12:19:46'),
(47, 'program_1_desc', 'Pelatihan intensif multi-bidang setiap semester untuk meningkatkan hard skill anggota di bidang IT dan multimedia.', 'Program 1: Deskripsi', '2026-05-03 12:19:46'),
(48, 'program_1_tag', 'Rutin · Setiap Semester', 'Program 1: Tag', '2026-05-03 12:19:46'),
(49, 'program_2_title', 'COM Creative Festival', 'Program 2: Judul', '2026-05-03 12:19:46'),
(50, 'program_2_desc', 'Festival kreativitas tahunan yang menampilkan karya terbaik anggota dalam pameran digital dan kompetisi internal.', 'Program 2: Deskripsi', '2026-05-03 12:19:46'),
(51, 'program_2_tag', 'Tahunan · Terbuka Umum', 'Program 2: Tag', '2026-05-03 12:19:46'),
(52, 'program_3_title', 'Tech Talk & Workshop', 'Program 3: Judul', '2026-05-03 12:19:46'),
(53, 'program_3_desc', 'Sesi berbagi bersama praktisi industri, alumni berprestasi, dan pakar teknologi dari berbagai bidang keahlian.', 'Program 3: Deskripsi', '2026-05-03 12:19:46'),
(54, 'program_3_tag', 'Bulanan · Undangan', 'Program 3: Tag', '2026-05-03 12:19:46'),
(55, 'program_4_title', 'Bakti Sosial Digital', 'Program 4: Judul', '2026-05-03 12:19:46'),
(56, 'program_4_desc', 'Pengabdian masyarakat berbasis teknologi seperti pelatihan komputer gratis dan pembuatan konten edukasi komunitas.', 'Program 4: Deskripsi', '2026-05-03 12:19:46'),
(57, 'program_4_tag', 'Semesteran · Sosial', 'Program 4: Tag', '2026-05-03 12:19:46'),
(58, 'testi_1_quote', 'Bergabung dengan organisasi ini membuka wawasan saya tentang teknologi dan kepemimpinan. Program COM Academy sangat bermanfaat!', 'Testimoni 1: Quote', '2026-05-03 12:19:47'),
(59, 'testi_1_name', 'Ahmad Rizki', 'Testimoni 1: Nama', '2026-05-03 12:19:47'),
(60, 'testi_1_role', 'Anggota Aktif · XI RPL 1', 'Testimoni 1: Jabatan', '2026-05-03 12:19:47'),
(61, 'testi_2_quote', 'Platform digital yang dikelola sangat memudahkan absensi dan koordinasi kegiatan. Benar-benar solusi modern untuk organisasi sekolah.', 'Testimoni 2: Quote', '2026-05-03 12:19:47'),
(62, 'testi_2_name', 'Siti Nurhaliza', 'Testimoni 2: Nama', '2026-05-03 12:19:47'),
(63, 'testi_2_role', 'Sekretaris · XII TKJ 2', 'Testimoni 2: Jabatan', '2026-05-03 12:19:47'),
(64, 'testi_3_quote', 'Creative Festival adalah pengalaman yang tidak terlupakan. Saya belajar banyak tentang desain grafis dan pembuatan konten digital.', 'Testimoni 3: Quote', '2026-05-03 12:19:47'),
(65, 'testi_3_name', 'Budi Santoso', 'Testimoni 3: Nama', '2026-05-03 12:19:47'),
(66, 'testi_3_role', 'Anggota Aktif · X RPL 3', 'Testimoni 3: Jabatan', '2026-05-03 12:19:47'),
(67, 'testi_4_quote', 'Bakti Sosial Digital membantu masyarakat sekitar melek teknologi. Bangga bisa berkontribusi nyata lewat organisasi ini.', 'Testimoni 4: Quote', '2026-05-03 12:19:47'),
(68, 'testi_4_name', 'Dewi Rahayu', 'Testimoni 4: Nama', '2026-05-03 12:19:47'),
(69, 'testi_4_role', 'Koordinator Sosial · XI MM', 'Testimoni 4: Jabatan', '2026-05-03 12:19:47'),
(70, 'testi_5_quote', 'Tech Talk bersama praktisi industri memberi gambaran nyata tentang dunia kerja. Sangat memotivasi untuk terus belajar dan berkembang.', 'Testimoni 5: Quote', '2026-05-03 12:19:47'),
(71, 'testi_5_name', 'Fajar Pratama', 'Testimoni 5: Nama', '2026-05-03 12:19:47'),
(72, 'testi_5_role', 'Anggota Aktif · XII RPL 2', 'Testimoni 5: Jabatan', '2026-05-03 12:19:47'),
(73, 'gallery_img_1', 'gallery_img_1_1777810912_a46022c0.jpeg', 'Galeri: Foto 1', '2026-05-03 12:21:52'),
(74, 'gallery_img_2', '', 'Galeri: Foto 2', '2026-05-03 12:19:47'),
(75, 'gallery_img_3', '', 'Galeri: Foto 3', '2026-05-03 12:19:47'),
(76, 'gallery_img_4', '', 'Galeri: Foto 4', '2026-05-03 12:19:47'),
(77, 'gallery_img_5', '', 'Galeri: Foto 5', '2026-05-03 12:19:47'),
(78, 'gallery_img_6', '', 'Galeri: Foto 6', '2026-05-03 12:19:47'),
(79, 'gallery_label_1', 'COM Academy 2024', 'Galeri: Label Foto 1', '2026-05-03 12:19:47'),
(80, 'gallery_label_2', 'Creative Festival', 'Galeri: Label Foto 2', '2026-05-03 12:19:47'),
(81, 'gallery_label_3', 'Tech Workshop', 'Galeri: Label Foto 3', '2026-05-03 12:19:47'),
(82, 'gallery_label_4', 'Bakti Sosial', 'Galeri: Label Foto 4', '2026-05-03 12:19:47'),
(83, 'gallery_label_5', 'Pelantikan Anggota', 'Galeri: Label Foto 5', '2026-05-03 12:19:47'),
(84, 'gallery_label_6', 'Rapat Koordinasi', 'Galeri: Label Foto 6', '2026-05-03 12:19:47'),
(85, 'cta_title', 'Siap Bergabung Bersama Kami?', 'CTA: Judul', '2026-05-03 12:19:47'),
(86, 'cta_desc', 'Daftarkan diri kamu melalui program Penerimaan Anggota Baru dan jadilah bagian dari keluarga besar organisasi kami.', 'CTA: Deskripsi', '2026-05-03 12:19:47'),
(87, 'contact_address', 'SMKN 2 Pinrng', 'Alamat', '2026-05-03 12:21:26'),
(93, 'org_nilai', 'Integritas, inovasi, kolaborasi, dan dedikasi menjadi fondasi setiap langkah kami dalam berorganisasi.', NULL, '2026-05-03 12:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nia` varchar(20) DEFAULT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `kelas` varchar(30) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('admin','anggota') NOT NULL DEFAULT 'anggota',
  `status` enum('pending','aktif','nonaktif') NOT NULL DEFAULT 'pending',
  `sumber` enum('pab','manual') NOT NULL DEFAULT 'manual',
  `tahun_daftar` year(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nia`, `nama_lengkap`, `kelas`, `no_hp`, `email`, `password_hash`, `foto`, `role`, `status`, `sumber`, `tahun_daftar`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Administrator', NULL, NULL, 'admin@com.smkn2pinrang.sch.id', '$2y$12$.dpATHAPL081j9oOYdpQ3eLJWSy7SmoXpWAlxbZGS2RjkUp8eUPpG', NULL, 'admin', 'aktif', 'manual', NULL, '2026-05-02 02:59:59', '2026-05-02 03:10:27'),
(2, '202624001', 'Ikhsan Pratama', 'XII RPL 2', '082197497924', NULL, '$2y$12$/jXrs2f2UxFr/yj6pKnjmueE7cj/XpxhOE0rD7WnUTYh2koynpHja', 'edit_1777725402_2dbff852.jpeg', 'anggota', 'aktif', 'pab', '2026', '2026-05-02 03:17:32', '2026-05-02 12:36:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_session_user` (`session_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `nia_sequence`
--
ALTER TABLE `nia_sequence`
  ADD PRIMARY KEY (`tahun`);

--
-- Indexes for table `pab_registrations`
--
ALTER TABLE `pab_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nia` (`nia`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pab_registrations`
--
ALTER TABLE `pab_registrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `attendance_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD CONSTRAINT `attendance_sessions_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pab_registrations`
--
ALTER TABLE `pab_registrations`
  ADD CONSTRAINT `pab_registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
