# 🖥️ Sistem Informasi Organisasi COM SMKN 2 Pinrang

Aplikasi web berbasis **PHP Native** untuk manajemen organisasi COM SMKN 2 Pinrang.

---

## 🗂️ Struktur Folder

```
com-smkn2-pinrang/
├── .htaccess                  ← Redirect root ke /public
├── setup.php                  ← Script setup password admin
├── config/
│   ├── app.php                ← Konstanta & session_start
│   └── database.php           ← Kredensial DB
├── core/
│   ├── Database.php           ← PDO singleton
│   ├── Router.php             ← Clean URL router
│   ├── Controller.php         ← Base controller (view, auth, flash, csrf)
│   ├── Model.php              ← Base model (PDO helpers)
│   ├── NiaGenerator.php       ← Generator NIA otomatis
│   └── FileUploader.php       ← Upload & validasi foto
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── PabController.php
│   │   ├── AdminController.php
│   │   └── MemberController.php
│   ├── models/
│   │   ├── UserModel.php
│   │   ├── PabModel.php
│   │   ├── SettingModel.php
│   │   └── AttendanceModel.php
│   └── views/
│       ├── layouts/
│       │   ├── main.php       ← Layout publik (navbar + footer)
│       │   ├── auth.php       ← Layout login (centered)
│       │   ├── admin.php      ← Layout admin (sidebar)
│       │   ├── member.php     ← Layout member (sidebar)
│       │   └── print.php      ← Layout cetak (bersih)
│       ├── pages/
│       │   ├── home.php       ← Landing page
│       │   ├── login.php
│       │   └── pab.php        ← Form pendaftaran PAB
│       ├── admin/
│       │   ├── dashboard.php
│       │   ├── anggota.php
│       │   ├── anggota_form.php
│       │   ├── anggota_edit.php
│       │   ├── pab.php
│       │   ├── absensi.php
│       │   ├── absensi_print.php
│       │   └── settings.php
│       ├── member/
│       │   ├── dashboard.php
│       │   ├── profile.php
│       │   └── surat_pernyataan.php
│       └── errors/
│           ├── 403.php
│           └── 404.php
├── public/
│   ├── .htaccess              ← Clean URL (mod_rewrite)
│   ├── index.php              ← Front controller
│   ├── assets/
│   │   ├── css/custom.css
│   │   └── js/main.js
│   └── uploads/photos/        ← Foto anggota (auto-created)
└── database/
    └── schema.sql             ← Skema + data awal
```

---

## ⚙️ Instalasi

### Prasyarat
- PHP 8.1+
- MySQL 5.7+ / MariaDB 10.4+
- Apache dengan `mod_rewrite` aktif

### Langkah

**1. Clone / Extract** project ke folder web server:
```
htdocs/com-smkn2-pinrang/
```

**2. Import database:**
```sql
mysql -u root -p < database/schema.sql
```

**3. Konfigurasi database** di `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'com_smkn2_pinrang');
define('DB_USER', 'root');
define('DB_PASS', '');
```

**4. Sesuaikan BASE_URL** di `config/app.php`:
```php
define('BASE_URL', 'http://localhost/com-smkn2-pinrang/public');
```

**5. Jalankan setup admin:**
```bash
php setup.php
```

**6. Pastikan folder uploads writable:**
```bash
chmod -R 755 public/uploads/
```

**7. Aktifkan `mod_rewrite`** (Apache):
```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

**8. Buka browser:**
```
http://localhost/com-smkn2-pinrang/public/
```

---

## 🔐 Akun Default

| Role  | Email                              | Password      |
|-------|------------------------------------|---------------|
| Admin | admin@com.smkn2pinrang.sch.id      | Admin@COM2024 |

> **Ganti password admin** segera setelah login pertama!

---

## 🎫 Format NIA

```
[Tahun Daftar] [Kode Organisasi: 24] [Nomor Urut 3 digit]
Contoh: 202624001
```

NIA di-generate otomatis saat Admin:
- Menyetujui pendaftar PAB
- Mengaktifkan anggota manual

---

## 🔗 Route Utama

| URL                              | Keterangan                  |
|----------------------------------|-----------------------------|
| `/`                              | Halaman beranda (CMS)       |
| `/login`                         | Login admin & anggota       |
| `/pab`                           | Form pendaftaran PAB        |
| `/admin/dashboard`               | Dashboard admin             |
| `/admin/anggota`                 | CRUD anggota                |
| `/admin/pab`                     | Verifikasi pendaftar PAB    |
| `/admin/absensi`                 | Manajemen sesi absensi      |
| `/admin/absensi/:id/print`       | Cetak daftar hadir          |
| `/admin/settings`                | CMS & pengaturan            |
| `/member/dashboard`              | Dashboard anggota           |
| `/member/surat-pernyataan`       | Download surat pernyataan   |
| `/member/profile`                | Edit profil anggota         |

---

## 🛡️ Keamanan

- CSRF token pada semua form POST
- Password di-hash dengan `bcrypt` (cost 12)
- Validasi MIME type file upload
- Input di-sanitasi dengan `htmlspecialchars`
- Direktori sensitif dilindungi `.htaccess`
- PDO prepared statements (anti SQL injection)
