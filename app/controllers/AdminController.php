<?php
// app/controllers/AdminController.php

class AdminController extends Controller
{
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
        if (!$anggota) {
            $this->flash('error', 'Data tidak ditemukan.');
            $this->redirect('/admin/anggota');
        }
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
            catch (RuntimeException $e) {
                $this->flash('error', $e->getMessage());
                $this->redirect("/admin/anggota/{$id}/edit");
            }
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

    public function anggotaResetPassword(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $anggota = (new UserModel())->find((int)$id);
        if (!$anggota) {
            $this->flash('error', 'Data anggota tidak ditemukan.');
            $this->redirect('/admin/anggota');
        }

        $newHash = password_hash('cosmakda', PASSWORD_BCRYPT, ['cost' => 12]);
        (new UserModel())->updatePassword((int)$id, $newHash);

        $this->flash('success', 'Password <strong>' . htmlspecialchars($anggota['nama_lengkap']) . '</strong> berhasil direset ke <strong>cosmakda</strong>.');
        $this->redirect('/admin/anggota');
    }

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

        $allowed = [
            'org_name', 'org_tagline', 'org_description', 'org_vision', 'org_mission',
            'org_nilai',
            'contact_email', 'contact_phone', 'contact_address',
            'footer_text',
            'hero_badge_text', 'ticker_items',
            'stat_members', 'stat_years', 'stat_events', 'stat_awards',
            'pab_info', 'pab_deadline',
            'cta_title', 'cta_desc',
            'pembina_nama', 'pembina_jabatan', 'pembina_masa',
            'pembina_sambutan', 'sambutan_eyebrow', 'sambutan_show',
        ];

        for ($i = 1; $i <= 6; $i++) {
            $allowed[] = "feature_{$i}_title";
            $allowed[] = "feature_{$i}_desc";
        }
        for ($i = 1; $i <= 4; $i++) {
            $allowed[] = "program_{$i}_title";
            $allowed[] = "program_{$i}_desc";
            $allowed[] = "program_{$i}_tag";
        }
        for ($i = 1; $i <= 5; $i++) {
            $allowed[] = "testi_{$i}_quote";
            $allowed[] = "testi_{$i}_name";
            $allowed[] = "testi_{$i}_role";
        }
        for ($i = 1; $i <= 6; $i++) {
            $allowed[] = "gallery_label_{$i}";
        }

        $data = [];
        foreach ($allowed as $key) {
            if (array_key_exists($key, $_POST)) {
                $data[$key] = strip_tags((string)$_POST[$key]);
            }
        }

        $fileSlots = [
            'org_logo'     => 'org_logo',
            'org_photo'    => 'org_photo',
            'hero_image'   => 'hero_image',
            'pembina_foto' => 'pembina_foto',
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

        (new SettingModel())->setMany($data);
        $this->flash('success', 'Pengaturan berhasil disimpan.');
        $this->redirect('/admin/settings');
    }

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
        if (!$sesi) {
            $this->flash('error', 'Sesi tidak ditemukan.');
            $this->redirect('/admin/absensi');
        }

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

    public function profil(): void
    {
        $this->requireAdmin();
        $admin = (new UserModel())->find((int)$_SESSION['user_id']);
        if (!$admin) {
            $this->flash('error', 'Data admin tidak ditemukan.');
            $this->redirect('/admin/dashboard');
        }
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/profil', compact('admin', 'flash', 'csrf'), 'admin');
    }

    public function profilSimpan(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $id      = (int)$_SESSION['user_id'];
        $um      = new UserModel();
        $current = $um->find($id);

        if (!$current) {
            $this->flash('error', 'Data admin tidak ditemukan.');
            $this->redirect('/admin/profil');
        }

        $nama  = htmlspecialchars(trim($_POST['nama_lengkap'] ?? ''), ENT_QUOTES);
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $noHp  = preg_replace('/\D/', '', $_POST['no_hp'] ?? '');

        $errors = [];
        if (strlen($nama) < 3) $errors[] = 'Nama minimal 3 karakter.';
        if (!$email)            $errors[] = 'Email tidak valid.';

        if ($errors) {
            $this->flash('error', implode('<br>', $errors));
            $this->redirect('/admin/profil');
        }

        $foto = $current['foto'];

        if (!empty($_POST['hapus_foto']) && $foto) {
            $fotoPath = ROOT . '/public/uploads/' . $foto;
            if (file_exists($fotoPath)) @unlink($fotoPath);
            $foto = null;
        }

        if (!empty($_FILES['foto']['name'])) {
            try {
                if ($foto) {
                    $fotoPath = ROOT . '/public/uploads/' . $foto;
                    if (file_exists($fotoPath)) @unlink($fotoPath);
                }
                $foto = FileUploader::uploadFoto($_FILES['foto'], 'admin-profil');
            } catch (RuntimeException $e) {
                $this->flash('error', $e->getMessage());
                $this->redirect('/admin/profil');
            }
        }

        $um->updateProfile($id, [
            'nama_lengkap' => $nama,
            'email'        => $email,
            'no_hp'        => $noHp,
            'foto'         => $foto,
        ]);

        $pwLama = $_POST['password_lama']       ?? '';
        $pwBaru = $_POST['password_baru']       ?? '';
        $pwKonf = $_POST['password_konfirmasi'] ?? '';

        if ($pwBaru !== '' || $pwKonf !== '') {
            if (!password_verify($pwLama, $current['password_hash'])) {
                $this->flash('error', 'Password saat ini salah.');
                $this->redirect('/admin/profil');
            }
            if (strlen($pwBaru) < 8) {
                $this->flash('error', 'Password baru minimal 8 karakter.');
                $this->redirect('/admin/profil');
            }
            if ($pwBaru !== $pwKonf) {
                $this->flash('error', 'Konfirmasi password tidak cocok.');
                $this->redirect('/admin/profil');
            }
            $um->updatePassword($id, password_hash($pwBaru, PASSWORD_BCRYPT, ['cost' => 12]));
        }

        $_SESSION['user_name'] = $nama;

        $this->flash('success', 'Profil berhasil diperbarui.');
        $this->redirect('/admin/profil');
    }

    public function profilLogoutAll(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $id = (int)$_SESSION['user_id'];
        (new UserModel())->invalidateAllSessions($id);

        session_destroy();
        $this->redirect('/login');
    }

    public function riwayat(): void
    {
        $this->requireAdmin();
        $rpm      = new RiwayatPengurusModel();
        $list     = $rpm->getAll();
        $editData = null;
        $flash    = $this->getFlash();
        $csrf     = $this->csrfToken();
        $this->view('admin/riwayat', compact('list', 'editData', 'flash', 'csrf'), 'admin');
    }

    public function riwayatStore(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $nama        = htmlspecialchars(trim($_POST['nama']    ?? ''), ENT_QUOTES);
        $tipe        = in_array($_POST['tipe'] ?? '', ['ketua', 'pembina']) ? $_POST['tipe'] : 'ketua';
        $jabatan     = htmlspecialchars(trim($_POST['jabatan']  ?? 'Ketua Umum'), ENT_QUOTES);
        $periode     = htmlspecialchars(trim($_POST['periode']  ?? ''), ENT_QUOTES);
        $tahunDari   = (int)($_POST['tahun_dari']   ?? 0) ?: null;
        $tahunSampai = (int)($_POST['tahun_sampai'] ?? 0) ?: null;
        $urutan      = max(0, (int)($_POST['urutan'] ?? 0));
        $catatan     = htmlspecialchars(trim($_POST['catatan'] ?? ''), ENT_QUOTES);

        if (strlen($nama) < 2 || empty($periode)) {
            $this->flash('error', 'Nama dan periode wajib diisi.');
            $this->redirect('/admin/riwayat#form-tambah');
        }

        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            try   { $foto = FileUploader::uploadFoto($_FILES['foto'], 'riwayat'); }
            catch (RuntimeException $e) {
                $this->flash('error', 'Upload foto gagal: ' . $e->getMessage());
                $this->redirect('/admin/riwayat#form-tambah');
            }
        }

        (new RiwayatPengurusModel())->create([
            'tipe'         => $tipe,
            'nama'         => $nama,
            'jabatan'      => $jabatan,
            'periode'      => $periode,
            'tahun_dari'   => $tahunDari,
            'tahun_sampai' => $tahunSampai,
            'foto'         => $foto,
            'catatan'      => $catatan,
            'urutan'       => $urutan,
        ]);

        $this->flash('success', 'Data pengurus berhasil ditambahkan.');
        $this->redirect('/admin/riwayat');
    }

    public function riwayatEdit(string $id): void
    {
        $this->requireAdmin();
        $rpm      = new RiwayatPengurusModel();
        $editData = $rpm->find((int)$id);
        if (!$editData) {
            $this->flash('error', 'Data tidak ditemukan.');
            $this->redirect('/admin/riwayat');
        }
        $list  = $rpm->getAll();
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/riwayat', compact('list', 'editData', 'flash', 'csrf'), 'admin');
    }

    public function riwayatUpdate(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $rpm     = new RiwayatPengurusModel();
        $current = $rpm->find((int)$id);
        if (!$current) {
            $this->flash('error', 'Data tidak ditemukan.');
            $this->redirect('/admin/riwayat');
        }

        $nama        = htmlspecialchars(trim($_POST['nama']    ?? ''), ENT_QUOTES);
        $tipe        = in_array($_POST['tipe'] ?? '', ['ketua', 'pembina']) ? $_POST['tipe'] : 'ketua';
        $jabatan     = htmlspecialchars(trim($_POST['jabatan']  ?? 'Ketua Umum'), ENT_QUOTES);
        $periode     = htmlspecialchars(trim($_POST['periode']  ?? ''), ENT_QUOTES);
        $tahunDari   = (int)($_POST['tahun_dari']   ?? 0) ?: null;
        $tahunSampai = (int)($_POST['tahun_sampai'] ?? 0) ?: null;
        $urutan      = max(0, (int)($_POST['urutan'] ?? 0));
        $catatan     = htmlspecialchars(trim($_POST['catatan'] ?? ''), ENT_QUOTES);

        if (strlen($nama) < 2 || empty($periode)) {
            $this->flash('error', 'Nama dan periode wajib diisi.');
            $this->redirect('/admin/riwayat/' . $id . '/edit#form-tambah');
        }

        $foto = $current['foto'];
        if (!empty($_FILES['foto']['name'])) {
            try {
                if ($foto) {
                    $fotoPath = ROOT . '/public/uploads/' . $foto;
                    if (file_exists($fotoPath)) @unlink($fotoPath);
                }
                $foto = FileUploader::uploadFoto($_FILES['foto'], 'riwayat');
            } catch (RuntimeException $e) {
                $this->flash('error', 'Upload foto gagal: ' . $e->getMessage());
                $this->redirect('/admin/riwayat/' . $id . '/edit#form-tambah');
            }
        }

        $rpm->update((int)$id, [
            'tipe'         => $tipe,
            'nama'         => $nama,
            'jabatan'      => $jabatan,
            'periode'      => $periode,
            'tahun_dari'   => $tahunDari,
            'tahun_sampai' => $tahunSampai,
            'foto'         => $foto,
            'catatan'      => $catatan,
            'urutan'       => $urutan,
        ]);

        $this->flash('success', 'Data pengurus berhasil diperbarui.');
        $this->redirect('/admin/riwayat');
    }

    public function riwayatDelete(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $rpm     = new RiwayatPengurusModel();
        $current = $rpm->find((int)$id);
        if ($current && !empty($current['foto'])) {
            $fotoPath = ROOT . '/public/uploads/' . $current['foto'];
            if (file_exists($fotoPath)) @unlink($fotoPath);
        }
        $rpm->delete((int)$id);

        $this->flash('success', 'Data pengurus berhasil dihapus.');
        $this->redirect('/admin/riwayat');
    }
}