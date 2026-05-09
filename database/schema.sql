-- ============================================================
--  DATABASE: Sistem Informasi Organisasi COM SMKN 2 Pinrang
-- ============================================================

CREATE DATABASE IF NOT EXISTS com_smkn2_pinrang
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE com_smkn2_pinrang;

-- ============================================================
--  TABEL: settings (CMS & konfigurasi global)
-- ============================================================
CREATE TABLE settings (
  id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key`     VARCHAR(100) NOT NULL UNIQUE,
  value     TEXT,
  label     VARCHAR(150),
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO settings (`key`, value, label) VALUES
  ('org_name',        'COM SMKN 2 Pinrang',                  'Nama Organisasi'),
  ('org_tagline',     'Creative, Outstanding, Meaningful',   'Tagline'),
  ('org_description', 'Organisasi siswa bidang komputer dan multimedia di SMKN 2 Pinrang.', 'Deskripsi'),
  ('org_vision',      'Menjadi organisasi siswa yang unggul dalam teknologi dan kreativitas.', 'Visi'),
  ('org_mission',     '1. Mengembangkan kemampuan anggota di bidang IT.\n2. Membangun karakter pemimpin muda.\n3. Berinovasi untuk kemajuan sekolah.', 'Misi'),
  ('org_logo',        '',                                    'Logo Organisasi'),
  ('hero_image',      '',                                    'Gambar Hero'),
  ('contact_email',   'com@smkn2pinrang.sch.id',             'Email Kontak'),
  ('contact_phone',   '',                                    'No HP Kontak'),
  ('pab_status',      '0',                                   'Status PAB (1=Buka, 0=Tutup)'),
  ('pab_info',        'Pendaftaran anggota baru COM SMKN 2 Pinrang.',  'Info PAB'),
  ('pab_deadline',    '',                                    'Batas Akhir PAB'),
  ('footer_text',     '© 2024 COM SMKN 2 Pinrang. All rights reserved.', 'Teks Footer');

-- ============================================================
--  TABEL: users (Admin & Anggota)
-- ============================================================
CREATE TABLE users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nia           VARCHAR(20)  UNIQUE,          -- NULL sampai diverifikasi
  nama_lengkap  VARCHAR(150) NOT NULL,
  kelas         VARCHAR(30),
  no_hp         VARCHAR(20),
  email         VARCHAR(100) UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  foto          VARCHAR(255) DEFAULT NULL,
  role          ENUM('admin','anggota') NOT NULL DEFAULT 'anggota',
  status        ENUM('pending','aktif','nonaktif') NOT NULL DEFAULT 'pending',
  sumber        ENUM('pab','manual') NOT NULL DEFAULT 'manual',
  tahun_daftar  YEAR,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sequence generator NIA per tahun
CREATE TABLE nia_sequence (
  tahun        YEAR NOT NULL PRIMARY KEY,
  last_seq     SMALLINT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ============================================================
--  TABEL: pab_registrations (Antrian pendaftar PAB)
-- ============================================================
CREATE TABLE pab_registrations (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama_lengkap  VARCHAR(150) NOT NULL,
  kelas         VARCHAR(30)  NOT NULL,
  no_hp         VARCHAR(20)  NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  foto          VARCHAR(255),
  status        ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  catatan_admin TEXT,
  user_id       INT UNSIGNED DEFAULT NULL,   -- di-set saat diapprove
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
--  TABEL: attendances (Sesi absensi)
-- ============================================================
CREATE TABLE attendance_sessions (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  judul       VARCHAR(200) NOT NULL,
  tanggal     DATE         NOT NULL,
  keterangan  TEXT,
  created_by  INT UNSIGNED,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE attendance_records (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  session_id    INT UNSIGNED NOT NULL,
  user_id       INT UNSIGNED NOT NULL,
  status        ENUM('hadir','izin','alpa') DEFAULT 'alpa',
  keterangan    VARCHAR(255),
  UNIQUE KEY uq_session_user (session_id, user_id),
  FOREIGN KEY (session_id) REFERENCES attendance_sessions(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id)    REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
--  ADMIN DEFAULT (password: Admin@COM2024)
-- ============================================================
INSERT INTO users (nama_lengkap, email, password_hash, role, status, sumber)
VALUES (
  'Administrator',
  'admin@com.smkn2pinrang.sch.id',
  '$2y$12$3vT9Q4Z5qF0sRzXlP1kMWuOoN8yIvB2Kd3hJeE7tGaHcSfLwYpDmO', -- Admin@COM2024
  'admin',
  'aktif',
  'manual'
);
-- Jalankan query berikut di PHP untuk hash yang benar:
-- password_hash('Admin@COM2024', PASSWORD_BCRYPT, ['cost'=>12])
