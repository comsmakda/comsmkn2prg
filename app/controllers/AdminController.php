<?php
// app/controllers/AdminController.php

class AdminController extends Controller
{
    // ════════════════════════════════════════════════════════
    //  DASHBOARD
    // ════════════════════════════════════════════════════════
    public function dashboard(): void
    {
        $this->requireAdmin();
        $db    = Database::getInstance();
        $stats = [
            'total_anggota'  => (int)$db->query("SELECT COUNT(*) FROM users WHERE role='anggota' AND status='aktif'")->fetchColumn(),
            'pending_pab'    => (int)$db->query("SELECT COUNT(*) FROM pab_registrations WHERE status='pending'")->fetchColumn(),
            'pending_manual' => (int)$db->query("SELECT COUNT(*) FROM users WHERE role='anggota' AND status='pending'")->fetchColumn(),
            'total_sesi'     => (int)$db->query("SELECT COUNT(*) FROM attendance_sessions")->fetchColumn(),
        ];
        $flash = $this->getFlash();
        $this->view('admin/dashboard', compact('stats', 'flash'), 'admin');
    }

    // ════════════════════════════════════════════════════════
    //  MANAJEMEN ANGGOTA
    // ════════════════════════════════════════════════════════
    public function anggota(): void
    {
        $this->requireAdmin();
        $filter    = ['kelas' => $_GET['kelas'] ?? '', 'search' => $_GET['search'] ?? ''];
        $um        = new UserModel();
        $list      = $um->getAnggotaAktif($filter);
        $pending   = $um->getPendingAnggota();
        $kelasList = $um->getKelasList();
        $flash     = $this->getFlash();
        $csrf      = $this->csrfToken();
        $this->view('admin/anggota', compact('list', 'pending', 'kelasList', 'filter', 'flash', 'csrf'), 'admin');
    }

    public function anggotaCreate(): void
    {
        $this->requireAdmin();
        $this->view('admin/anggota_form', ['flash' => $this->getFlash(), 'csrf' => $this->csrfToken()], 'admin');
    }

    public function anggotaStore(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $nama     = htmlspecialchars(trim($_POST['nama_lengkap'] ?? ''), ENT_QUOTES);
        $kelas    = htmlspecialchars(trim($_POST['kelas'] ?? ''), ENT_QUOTES);
        $no_hp    = preg_replace('/\D/', '', $_POST['no_hp'] ?? '');
        $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: null;
        $password = $_POST['password'] ?? '';
        $langsung = isset($_POST['aktivasi_langsung']);

        $errors = [];
        if (strlen($nama) < 3)    $errors[] = 'Nama minimal 3 karakter.';
        if (empty($kelas))         $errors[] = 'Kelas wajib diisi.';
        if (strlen($password) < 6) $errors[] = 'Password minimal 6 karakter.';

        if ($errors) {
            $this->flash('error', implode('<br>', $errors));
            $this->redirect('/admin/anggota/tambah');
        }

        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            try   { $foto = FileUploader::uploadFoto($_FILES['foto'], 'manual'); }
            catch (RuntimeException $e) {
                $this->flash('error', $e->getMessage());
                $this->redirect('/admin/anggota/tambah');
            }
        }

        $um     = new UserModel();
        $userId = $um->createAnggota([
            'nama_lengkap'  => $nama,
            'kelas'         => $kelas,
            'no_hp'         => $no_hp,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
            'foto'          => $foto,
            'sumber'        => 'manual',
            'tahun_daftar'  => date('Y'),
        ]);

        if ($langsung) {
            $nia = $um->aktivasi($userId);
            $this->flash('success', "Anggota ditambahkan & diaktifkan. NIA: <strong>{$nia}</strong>");
        } else {
            $this->flash('success', 'Anggota ditambahkan. Status: pending.');
        }
        $this->redirect('/admin/anggota');
    }

    public function anggotaActivate(string $id): void
    {
        $this->requireAdmin();
        try {
            $nia = (new UserModel())->aktivasi((int)$id);
            $this->flash('success', "Anggota diaktifkan. NIA: <strong>{$nia}</strong>");
        } catch (RuntimeException $e) {
            $this->flash('error', $e->getMessage());
        }
        $this->redirect('/admin/anggota');
    }

    public function anggotaEdit(string $id): void
    {
        $this->requireAdmin();
        $anggota = (new UserModel())->find((int)$id);
        if (!$anggota) { $this->flash('error', 'Data tidak ditemukan.'); $this->redirect('/admin/anggota'); }
        $this->view('admin/anggota_edit', ['anggota' => $anggota, 'flash' => $this->getFlash(), 'csrf' => $this->csrfToken()], 'admin');
    }

    public function anggotaUpdate(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();
        $d = [
            'nama_lengkap' => htmlspecialchars(trim($_POST['nama_lengkap'] ?? ''), ENT_QUOTES),
            'kelas'        => htmlspecialchars(trim($_POST['kelas'] ?? ''), ENT_QUOTES),
            'no_hp'        => preg_replace('/\D/', '', $_POST['no_hp'] ?? ''),
            'foto'         => null,
        ];
        if (!empty($_FILES['foto']['name'])) {
            try   { $d['foto'] = FileUploader::uploadFoto($_FILES['foto'], 'edit'); }
            catch (RuntimeException $e) { $this->flash('error', $e->getMessage()); $this->redirect("/admin/anggota/{$id}/edit"); }
        }
        (new UserModel())->updateProfile((int)$id, $d);
        $this->flash('success', 'Data anggota diperbarui.');
        $this->redirect('/admin/anggota');
    }

    public function anggotaDelete(string $id): void
    {
        $this->requireAdmin();
        (new UserModel())->softDelete((int)$id);
        $this->flash('success', 'Anggota dinonaktifkan.');
        $this->redirect('/admin/anggota');
    }

    // ════════════════════════════════════════════════════════
    //  PAB VERIFIKASI
    // ════════════════════════════════════════════════════════
    public function pab(): void
    {
        $this->requireAdmin();
        $pm      = new PabModel();
        $sm      = new SettingModel();
        $list    = $pm->getAll();
        $pabOpen = $sm->isPabOpen();
        $flash   = $this->getFlash();
        $csrf    = $this->csrfToken();
        $this->view('admin/pab', compact('list', 'pabOpen', 'flash', 'csrf'), 'admin');
    }

    public function pabApprove(string $id): void
    {
        $this->requireAdmin();
        try {
            $nia = (new PabModel())->approve((int)$id);
            $this->flash('success', "Pendaftar disetujui. NIA: <strong>{$nia}</strong>");
        } catch (RuntimeException $e) {
            $this->flash('error', $e->getMessage());
        }
        $this->redirect('/admin/pab');
    }

    public function pabReject(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();
        $catatan = htmlspecialchars(trim($_POST['catatan'] ?? ''), ENT_QUOTES);
        (new PabModel())->reject((int)$id, $catatan);
        $this->flash('success', 'Pendaftar ditolak.');
        $this->redirect('/admin/pab');
    }

    public function pabToggle(): void
    {
        $this->requireAdmin();
        $sm      = new SettingModel();
        $current = $sm->get('pab_status');
        $sm->set('pab_status', $current === '1' ? '0' : '1');
        $this->flash('success', 'Status PAB berhasil diubah.');
        $this->redirect('/admin/pab');
    }

    // ════════════════════════════════════════════════════════
    //  CMS / SETTINGS
    // ════════════════════════════════════════════════════════
    public function settings(): void
    {
        $this->requireAdmin();
        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();
        $csrf     = $this->csrfToken();
        $this->view('admin/settings', compact('settings', 'flash', 'csrf'), 'admin');
    }

    public function settingsSave(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        // ── Semua field teks yang diizinkan ──────────────────────────────────
        $allowed = [
            // Organisasi
            'org_name', 'org_tagline', 'org_description', 'org_vision', 'org_mission',
            'org_nilai',
            'contact_email', 'contact_phone', 'contact_address',
            'footer_text',
            // Hero
            'hero_badge_text', 'ticker_items',
            // Statistik
            'stat_members', 'stat_years', 'stat_events', 'stat_awards',
            // PAB
            'pab_info', 'pab_deadline',
            // CTA
            'cta_title', 'cta_desc',
        ];

        // Fitur (6 item × 2 field)
        for ($i = 1; $i <= 6; $i++) {
            $allowed[] = "feature_{$i}_title";
            $allowed[] = "feature_{$i}_desc";
        }

        // Program (4 item × 3 field)
        for ($i = 1; $i <= 4; $i++) {
            $allowed[] = "program_{$i}_title";
            $allowed[] = "program_{$i}_desc";
            $allowed[] = "program_{$i}_tag";
        }

        // Testimoni (5 item × 3 field)
        for ($i = 1; $i <= 5; $i++) {
            $allowed[] = "testi_{$i}_quote";
            $allowed[] = "testi_{$i}_name";
            $allowed[] = "testi_{$i}_role";
        }

        // Galeri labels (6 item)
        for ($i = 1; $i <= 6; $i++) {
            $allowed[] = "gallery_label_{$i}";
        }

        // ── Kumpulkan data teks ──────────────────────────────────────────────
        $data = [];
        foreach ($allowed as $key) {
            if (array_key_exists($key, $_POST)) {
                $data[$key] = strip_tags((string)$_POST[$key]);
            }
        }

        // ── Upload file: definisi slot ────────────────────────────────────────
        // Format: ['field_name' => 'settings_key']
        $fileSlots = [
            'org_logo'    => 'org_logo',
            'org_photo'   => 'org_photo',
            'hero_image'  => 'hero_image',
        ];
        for ($i = 1; $i <= 6; $i++) {
            $fileSlots["gallery_img_{$i}"] = "gallery_img_{$i}";
        }

        foreach ($fileSlots as $fieldName => $settingKey) {
            if (!empty($_FILES[$fieldName]['name'])) {
                try {
                    $data[$settingKey] = FileUploader::uploadFoto($_FILES[$fieldName], $settingKey);
                } catch (RuntimeException $e) {
                    $this->flash('error', "Upload gagal untuk {$settingKey}: " . $e->getMessage());
                    $this->redirect('/admin/settings');
                }
            }
        }

        // ── Simpan semua ke database ─────────────────────────────────────────
        (new SettingModel())->setMany($data);

        $this->flash('success', 'Pengaturan berhasil disimpan.');
        $this->redirect('/admin/settings');
    }

    // ════════════════════════════════════════════════════════
    //  ABSENSI
    // ════════════════════════════════════════════════════════
    public function absensi(): void
    {
        $this->requireAdmin();
        $am    = new AttendanceModel();
        $sesi  = $am->getAllSessions();
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/absensi', compact('sesi', 'flash', 'csrf'), 'admin');
    }

    public function absensiCreate(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $judul = htmlspecialchars(trim($_POST['judul'] ?? ''), ENT_QUOTES);
        $tgl   = $_POST['tanggal'] ?? date('Y-m-d');
        $ket   = htmlspecialchars(trim($_POST['keterangan'] ?? ''), ENT_QUOTES);

        if (empty($judul)) {
            $this->flash('error', 'Judul sesi wajib diisi.');
            $this->redirect('/admin/absensi');
        }

        (new AttendanceModel())->createSession($judul, $tgl, $ket, (int)$_SESSION['user_id']);
        $this->flash('success', 'Sesi absensi dibuat.');
        $this->redirect('/admin/absensi');
    }

    public function absensiPrint(string $id): void
    {
        $this->requireAdmin();
        $am   = new AttendanceModel();
        $sesi = $am->getSession((int)$id);
        if (!$sesi) { $this->flash('error', 'Sesi tidak ditemukan.'); $this->redirect('/admin/absensi'); }

        $filter    = ['kelas' => $_GET['kelas'] ?? ''];
        $records   = $am->getRecordsForPrint((int)$id, $filter);
        $kelasList = (new UserModel())->getKelasList();
        $settings  = (new SettingModel())->getAll();

        $this->view('admin/absensi_print', compact('sesi', 'records', 'kelasList', 'filter', 'settings'), 'print');
    }

    public function absensiDelete(string $id): void
    {
        $this->requireAdmin();
        (new AttendanceModel())->deleteSession((int)$id);
        $this->flash('success', 'Sesi dihapus.');
        $this->redirect('/admin/absensi');
    }
}