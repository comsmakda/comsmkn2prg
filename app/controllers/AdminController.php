<?php
// app/controllers/AdminController.php

require_once APP_PATH . '/models/BeritaModel.php';
require_once APP_PATH . '/models/GaleriModel.php';
require_once APP_PATH . '/models/FingerprintModel.php';
require_once APP_PATH . '/models/JadwalPertemuanModel.php';

class AdminController extends Controller
{
    // ================================================================
    //  DASHBOARD
    // ================================================================
    public function dashboard(): void
    {
        $this->requireAdmin();
        $db    = Database::getInstance();
        $stats = [
            'total_anggota'  => (int)$db->query("SELECT COUNT(*) FROM users WHERE role='anggota' AND status='aktif'")->fetchColumn(),
            'pending_pab'    => (int)$db->query("SELECT COUNT(*) FROM pab_registrations WHERE status='pending'")->fetchColumn(),
            'pending_manual' => (int)$db->query("SELECT COUNT(*) FROM users WHERE role='anggota' AND status='pending'")->fetchColumn(),
            'total_sesi'     => (int)$db->query("SELECT COUNT(*) FROM attendance_sessions")->fetchColumn(),
            'total_berita'   => (int)$db->query("SELECT COUNT(*) FROM berita WHERE status='published'")->fetchColumn(),
            'pending_komentar' => (int)$db->query("SELECT COUNT(*) FROM berita_komentar WHERE status='pending'")->fetchColumn(),
            'total_album'    => (int)$db->query("SELECT COUNT(*) FROM galeri_album WHERE status='published'")->fetchColumn(),
        ];
        $flash = $this->getFlash();
        $this->view('admin/dashboard', compact('stats', 'flash'), 'admin');
    }

    // ================================================================
    //  ANGGOTA
    // ================================================================
    public function anggota(): void
    {
        $this->requireAdmin();
        $filter    = [
            'kelas'  => $_GET['kelas']  ?? '',
            'search' => $_GET['search'] ?? '',
            'sumber' => $_GET['sumber'] ?? '',
        ];
        $um        = new UserModel();
        $list      = $um->getAnggotaAktif($filter);
        $pending   = $um->getPendingAnggota();
        $kelasList = $um->getKelasList();

        $db = Database::getInstance();
        $stats = [
            'total_aktif'   => (int)$db->query("SELECT COUNT(*) FROM users WHERE role='anggota' AND status='aktif'")->fetchColumn(),
            'total_pending' => (int)$db->query("SELECT COUNT(*) FROM users WHERE role='anggota' AND status='pending'")->fetchColumn(),
            'total_pab'     => (int)$db->query("SELECT COUNT(*) FROM users WHERE role='anggota' AND status='aktif' AND sumber='pab'")->fetchColumn(),
            'total_manual'  => (int)$db->query("SELECT COUNT(*) FROM users WHERE role='anggota' AND status='aktif' AND sumber='manual'")->fetchColumn(),
        ];

        $flash     = $this->getFlash();
        $csrf      = $this->csrfToken();
        $this->view('admin/anggota', compact('list', 'pending', 'kelasList', 'filter', 'stats', 'flash', 'csrf'), 'admin');
    }

    public function anggotaCreate(): void
    {
        $this->requireAdmin();
        $this->view('admin/anggota_form', [
            'flash'       => $this->getFlash(),
            'csrf'        => $this->csrfToken(),
            'jabatanList' => UserModel::JABATAN_LIST,
        ], 'admin');
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
        $jabatan  = array_key_exists($_POST['jabatan'] ?? '', UserModel::JABATAN_LIST)
            ? $_POST['jabatan']
            : 'anggota';

        $errors = [];
        if (strlen($nama) < 3)     $errors[] = 'Nama minimal 3 karakter.';
        if (empty($kelas))          $errors[] = 'Kelas wajib diisi.';
        if (strlen($password) < 6)  $errors[] = 'Password minimal 6 karakter.';

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
            'jabatan'       => $jabatan,
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
        $this->view('admin/anggota_edit', [
            'anggota'     => $anggota,
            'flash'       => $this->getFlash(),
            'csrf'        => $this->csrfToken(),
            'jabatanList' => UserModel::JABATAN_LIST,
        ], 'admin');
    }

    public function anggotaUpdate(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();
        $d = [
            'nama_lengkap' => htmlspecialchars(trim($_POST['nama_lengkap'] ?? ''), ENT_QUOTES),
            'kelas'        => htmlspecialchars(trim($_POST['kelas'] ?? ''), ENT_QUOTES),
            'no_hp'        => preg_replace('/\D/', '', $_POST['no_hp'] ?? ''),
            'jabatan'      => array_key_exists($_POST['jabatan'] ?? '', UserModel::JABATAN_LIST)
                                ? $_POST['jabatan']
                                : 'anggota',
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
        $this->verifyCsrf();

        $um   = new UserModel();
        $user = $um->find((int)$id);

        if (!$user) {
            $this->flash('error', 'Anggota tidak ditemukan.');
            $this->redirect('/admin/anggota');
        }

        // Best-effort: hapus dari mesin fingerprint dulu (kalau anggota punya NIA)
        if (!empty($user['nia'])) {
            try {
                (new FingerprintModel())->deleteUser($user['nia']);
            } catch (\Throwable $e) {
                error_log('Gagal hapus dari fingerprint saat hardDelete: ' . $e->getMessage());
            }
        }

        // Hapus foto fisik anggota
        if (!empty($user['foto'])) {
            $fotoPath = ROOT . '/public/uploads/' . $user['foto'];
            if (file_exists($fotoPath)) @unlink($fotoPath);
        }

        if ($um->hardDelete((int)$id)) {
            $this->flash('success', 'Anggota berhasil dihapus permanen dari database.');
        } else {
            $this->flash('error', 'Gagal menghapus anggota. Cek log server.');
        }

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

        $newHash = password_hash('comsmakda', PASSWORD_BCRYPT, ['cost' => 12]);
        (new UserModel())->updatePassword((int)$id, $newHash);

        $this->flash('success', 'Password <strong>' . htmlspecialchars($anggota['nama_lengkap']) . '</strong> berhasil direset ke <strong>comsmakda</strong>.');
        $this->redirect('/admin/anggota');
    }

    // ================================================================
    //  PAB
    // ================================================================
public function pab(): void
    {
        $this->requireAdmin();
        $pm = new PabModel();
        $sm = new SettingModel();

        $filter = [
            'status' => $_GET['status'] ?? '',
            'kelas'  => $_GET['kelas']  ?? '',
            'search' => trim($_GET['search'] ?? ''),
        ];

        $list      = $pm->getAll($filter);
        $kelasList = $pm->getKelasList();
        $pabOpen   = $sm->isPabOpen();
        $flash     = $this->getFlash();
        $csrf      = $this->csrfToken();

        $this->view('admin/pab', compact('list', 'pabOpen', 'flash', 'csrf', 'filter', 'kelasList'), 'admin');
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

    public function pabDelete(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $pm  = new PabModel();
        $reg = $pm->find((int)$id);

        if (!$reg) {
            $this->flash('error', 'Data pendaftar tidak ditemukan.');
            $this->redirect('/admin/pab');
        }

        // Tidak boleh menghapus data yang statusnya sudah approved,
        // karena sudah terhubung dengan akun anggota aktif (users).
        // Kelola anggota tsb lewat halaman Anggota, bukan dari sini.
        if ($reg['status'] === 'approved') {
            $this->flash('error', 'Pendaftar yang sudah disetujui tidak bisa dihapus dari sini. Kelola akunnya lewat halaman Anggota.');
            $this->redirect('/admin/pab');
        }

        // Hapus foto fisik kalau ada
        if (!empty($reg['foto'])) {
            $fotoPath = ROOT . '/public/uploads/' . $reg['foto'];
            if (file_exists($fotoPath)) @unlink($fotoPath);
        }

        if ($pm->delete((int)$id)) {
            $this->flash('success', 'Data pendaftar PAB berhasil dihapus.');
        } else {
            $this->flash('error', 'Gagal menghapus data pendaftar.');
        }

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

    // ================================================================
    //  SETTINGS
    // ================================================================
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
            'contact_email', 'contact_phone', 'contact_address', 'contact_instagram',
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
                    $this->redirect('/admin/settings#hero');
                }
            }
        }

        // ── Hero Carousel (3 slot gambar) ──────────────────────────────
        $sm = new SettingModel();
        for ($hi = 1; $hi <= 3; $hi++) {
            $slotKey    = "hero_image_{$hi}";
            $fieldName  = "hero_image_{$hi}";
            $deleteFlag = ($_POST["{$slotKey}_delete"] ?? '0') === '1';
            $hasNewFile = !empty($_FILES[$fieldName]['name']);

            if ($hasNewFile) {
                $existing = $sm->get($slotKey);
                if ($existing) {
                    $oldPath = ROOT . '/public/uploads/' . $existing;
                    if (file_exists($oldPath)) @unlink($oldPath);
                }
                try {
                    $data[$slotKey] = FileUploader::uploadFoto($_FILES[$fieldName], $slotKey);
                } catch (RuntimeException $e) {
                    $this->flash('error', "Upload gambar hero slide {$hi} gagal: " . $e->getMessage());
                    $this->redirect('/admin/settings#hero');
                }
            } elseif ($deleteFlag) {
                $existing = $sm->get($slotKey);
                if ($existing) {
                    $oldPath = ROOT . '/public/uploads/' . $existing;
                    if (file_exists($oldPath)) @unlink($oldPath);
                }
                $data[$slotKey] = '';
            }
        }

        $sm->setMany($data);
        $this->flash('success', 'Pengaturan berhasil disimpan.');
        $this->redirect('/admin/settings');
    }

    // ================================================================
    //  ABSENSI
    // ================================================================
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

    // ================================================================
    //  FINGERPRINT (GEISA X107)
    // ================================================================
    public function fingerprint(): void
    {
        $this->requireAdmin();
        $title     = 'Perangkat Fingerprint';
        $fpModel   = new FingerprintModel();
        $health    = $fpModel->checkDeviceHealth();
        $anggota   = $fpModel->getAnggotaAktifDenganStatus();
        $flash     = $this->getFlash();
        $csrfToken = $this->csrfToken();
        $this->view('admin/fingerprint', compact('title', 'health', 'anggota', 'flash', 'csrfToken'), 'admin');
    }

    public function fingerprintPush(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $ok = (new FingerprintModel())->pushUser((int)$id);

        if ($ok) {
            $this->flash('success', 'Anggota berhasil disinkronkan ke mesin fingerprint.');
        } else {
            $this->flash('error', 'Gagal menyinkronkan anggota ke mesin fingerprint. Cek status koneksi mesin.');
        }

        $this->redirect('/admin/fingerprint');
    }

    public function fingerprintPushBulk(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $fpModel = new FingerprintModel();
        $userIds = $fpModel->getUserIdsBelumSyncAtauGagal();

        if (empty($userIds)) {
            $this->flash('info', 'Tidak ada anggota yang perlu disinkronkan.');
            $this->redirect('/admin/fingerprint');
        }

        $summary = $fpModel->pushBulk($userIds);

        $this->flash(
            $summary['gagal'] === 0 ? 'success' : 'warning',
            sprintf(
                'Push selesai: %d berhasil, %d gagal dari %d anggota.',
                $summary['sukses'],
                $summary['gagal'],
                count($userIds)
            )
        );

        $this->redirect('/admin/fingerprint');
    }

    public function fingerprintDelete(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $user = (new UserModel())->find((int)$id);
        if (!$user) {
            $this->flash('error', 'Anggota tidak ditemukan.');
            $this->redirect('/admin/fingerprint');
        }

        $ok = (new FingerprintModel())->deleteUser($user['nia']);

        if ($ok) {
            $this->flash('success', 'Anggota berhasil dihapus dari mesin fingerprint.');
        } else {
            $this->flash('error', 'Gagal menghapus anggota dari mesin fingerprint.');
        }

        $this->redirect('/admin/fingerprint');
    }

    public function fingerprintSyncLogs(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $result = (new FingerprintModel())->pullAndSaveLogs();

        if ($result['success']) {
            $this->flash('success', sprintf('%d log scan baru berhasil ditarik dari mesin.', $result['jumlah_baru']));
        } else {
            $this->flash('error', 'Gagal menarik log dari mesin: ' . $result['error']);
        }

        $this->redirect('/admin/fingerprint');
    }

    public function fingerprintRekap(): void
    {
        $this->requireAdmin();

        $tanggalMulai = $_GET['tanggal_mulai'] ?? date('Y-m-d');
        $tanggalAkhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');
        $kelas        = $_GET['kelas'] ?? '';
        $filter       = ['kelas' => $kelas];

        $rekap     = (new FingerprintModel())->getRekapHarian($tanggalMulai, $tanggalAkhir, $filter);
        $kelasList = array_column((new UserModel())->getKelasList(), 'kelas');
        $flash     = $this->getFlash();
        $csrf      = $this->csrfToken();

        $this->view('admin/fingerprint_rekap', compact('rekap', 'tanggalMulai', 'tanggalAkhir', 'kelas', 'kelasList', 'flash', 'csrf'), 'admin');
    }

    public function fingerprintRekapPrint(): void
    {
        $this->requireAdmin();

        $tanggalMulai = $_GET['tanggal_mulai'] ?? date('Y-m-d');
        $tanggalAkhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');
        $kelas        = $_GET['kelas'] ?? '';
        $filter       = ['kelas' => $kelas];

        $rekap    = (new FingerprintModel())->getRekapHarian($tanggalMulai, $tanggalAkhir, $filter);
        $settings = (new SettingModel())->getAll();

        $this->view('admin/fingerprint_rekap_print', compact('rekap', 'tanggalMulai', 'tanggalAkhir', 'kelas', 'settings'), 'print');
    }

    public function fingerprintRekapExport(): void
    {
        $this->requireAdmin();
        $tanggalMulai = $_GET['tanggal_mulai'] ?? date('Y-m-d');
        $tanggalAkhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');
        $kelas        = $_GET['kelas'] ?? '';
        $filter       = ['kelas' => $kelas];
        $rekap = (new FingerprintModel())->getRekapHarian($tanggalMulai, $tanggalAkhir, $filter);
        $headers = ['Nama', 'NIA', 'Kelas', 'Tanggal', 'Jam Masuk', 'Jam Pulang', 'Status'];
        $data = [];
        foreach ($rekap as $r) {
            $data[] = [
                $r['nama_lengkap'] ?? '',
                $r['nia']          ?? '',
                $r['kelas']        ?? '',
                $r['tanggal']      ?? '',
                $r['jam_masuk']    ?? '',
                $r['jam_pulang']   ?? '',
                $r['status']       ?? '',
            ];
        }
        $filename = 'rekap_absensi_' . $tanggalMulai . '_sd_' . $tanggalAkhir;
        $content = Xlsx::write($headers, $data);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        header('Content-Length: ' . strlen($content));
        header('Cache-Control: max-age=0');
        echo $content;
        exit;
    }

    // ================================================================
    //  JADWAL PERTEMUAN
    // ================================================================
    public function jadwalPertemuan(): void
    {
        $this->requireAdmin();

        $jpm = new JadwalPertemuanModel();

        $jadwalMap = [];
        foreach ($jpm->getAllJadwal() as $j) {
            $jadwalMap[$j['hari']] = $j;
        }

        $liburList = $jpm->getAllLibur();
        $flash     = $this->getFlash();
        $csrf      = $this->csrfToken();

        $this->view('admin/jadwal_pertemuan', compact('jadwalMap', 'liburList', 'flash', 'csrf'), 'admin');
    }

    public function jadwalPertemuanSimpan(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $jpm = new JadwalPertemuanModel();

        foreach (JadwalPertemuanModel::HARI_URUT as $hari) {
            $aktif      = isset($_POST['aktif'][$hari]);
            $jamMulai   = trim($_POST['jam_mulai'][$hari] ?? '');
            $jamSelesai = trim($_POST['jam_selesai'][$hari] ?? '');
            $keterangan = htmlspecialchars(trim($_POST['keterangan'][$hari] ?? ''), ENT_QUOTES);

            if ($jamMulai === '')   $jamMulai = '00:00';
            if ($jamSelesai === '') $jamSelesai = '00:00';

            $jpm->upsertJadwal($hari, $jamMulai, $jamSelesai, $aktif, $keterangan ?: null);
        }

        $this->flash('success', 'Jadwal pertemuan berhasil disimpan.');
        $this->redirect('/admin/jadwal-pertemuan');
    }

    public function jadwalPertemuanLiburStore(): void
{
    $this->requireAdmin();
    $this->verifyCsrf();

    $tglMulai   = $_POST['tanggal_mulai'] ?? '';
    $tglAkhir   = trim($_POST['tanggal_akhir'] ?? '') ?: $tglMulai;
    $keterangan = htmlspecialchars(trim($_POST['keterangan'] ?? ''), ENT_QUOTES);

    $dMulai = DateTime::createFromFormat('Y-m-d', $tglMulai);
    $dAkhir = DateTime::createFromFormat('Y-m-d', $tglAkhir);

    if (!$tglMulai || !$dMulai || !$dAkhir) {
        $this->flash('error', 'Tanggal tidak valid.');
        $this->redirect('/admin/jadwal-pertemuan');
    }

    if ($dAkhir < $dMulai) {
        $this->flash('error', 'Tanggal akhir tidak boleh sebelum tanggal mulai.');
        $this->redirect('/admin/jadwal-pertemuan');
    }

    // Batas wajar supaya tidak disalahgunakan untuk generate ribuan baris sekaligus
    $maxHari = 366;
    $selisihHari = (int)$dMulai->diff($dAkhir)->format('%a') + 1;
    if ($selisihHari > $maxHari) {
        $this->flash('error', "Rentang tanggal terlalu panjang (maksimal {$maxHari} hari).");
        $this->redirect('/admin/jadwal-pertemuan');
    }

    $jpm = new JadwalPertemuanModel();

    $sukses  = 0;
    $dilewati = 0;

    $periode = new DatePeriod($dMulai, new DateInterval('P1D'), (clone $dAkhir)->modify('+1 day'));
    foreach ($periode as $tgl) {
        $ok = $jpm->tambahLibur($tgl->format('Y-m-d'), $keterangan ?: null);
        $ok ? $sukses++ : $dilewati++;
    }

    if ($sukses > 0 && $dilewati === 0) {
        $msg = $sukses === 1
            ? 'Tanggal libur berhasil ditambahkan. Anggota tidak akan dihitung alpa pada tanggal tsb.'
            : "{$sukses} tanggal libur berhasil ditambahkan.";
        $this->flash('success', $msg);
    } elseif ($sukses > 0 && $dilewati > 0) {
        $this->flash('warning', "{$sukses} tanggal ditambahkan, {$dilewati} tanggal dilewati (sudah ada di daftar libur).");
    } else {
        $this->flash('warning', 'Semua tanggal pada rentang ini sudah ada di daftar libur.');
    }

    $this->redirect('/admin/jadwal-pertemuan');
}

    public function jadwalPertemuanLiburDelete(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        (new JadwalPertemuanModel())->hapusLibur((int) $id);
        $this->flash('success', 'Tanggal libur berhasil dihapus.');
        $this->redirect('/admin/jadwal-pertemuan');
    }

    // ================================================================
    //  PROFIL ADMIN
    // ================================================================
    public function profil(): void
    {
        $this->requireAdmin();
        $um    = new UserModel();
        $admin = $um->find((int)$_SESSION['user_id']);
        if (!$admin) {
            $this->flash('error', 'Data admin tidak ditemukan.');
            $this->redirect('/admin/dashboard');
        }
        $isSuperAdmin = (bool)($admin['is_super_admin'] ?? false);
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/profil', compact('admin', 'flash', 'csrf', 'isSuperAdmin'), 'admin');
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

    // ================================================================
    //  KELOLA ADMIN (khusus admin utama)
    // ================================================================
    public function kelolaAdmin(): void
    {
        $this->requireSuperAdmin();
        $um        = new UserModel();
        $adminList = $um->getAdminList(true); // admin utama disembunyikan dari daftar ini juga
        $eligible  = $um->getEligibleForAdmin();
        $flash     = $this->getFlash();
        $csrf      = $this->csrfToken();
        $this->view('admin/kelola_admin', compact('adminList', 'eligible', 'flash', 'csrf'), 'admin');
    }

    public function kelolaAdminPromote(): void
    {
        $this->requireSuperAdmin();
        $this->verifyCsrf();

        $id = (int)($_POST['user_id'] ?? 0);
        $um = new UserModel();
        $target = $um->find($id);

        if (!$target || $target['role'] !== 'anggota' || $target['status'] !== 'aktif') {
            $this->flash('error', 'Anggota tidak valid untuk dijadikan admin.');
            $this->redirect('/admin/kelola-admin');
        }

        $um->promoteToAdmin($id);
        $this->flash('success', htmlspecialchars($target['nama_lengkap']) . ' berhasil dijadikan admin.');
        $this->redirect('/admin/kelola-admin');
    }

    public function kelolaAdminDemote(string $id): void
    {
        $this->requireSuperAdmin();
        $this->verifyCsrf();

        $um     = new UserModel();
        $target = $um->find((int)$id);

        if (!$target || $target['role'] !== 'admin' || !empty($target['is_super_admin'])) {
            $this->flash('error', 'Aksi tidak valid.');
            $this->redirect('/admin/kelola-admin');
        }

        $um->demoteToAnggota((int)$id);
        $this->flash('success', htmlspecialchars($target['nama_lengkap']) . ' diturunkan kembali menjadi anggota.');
        $this->redirect('/admin/kelola-admin');
    }

    // Admin (bukan admin utama) berhenti dari jabatan admin sendiri
    public function berhentiAdmin(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $id = (int)$_SESSION['user_id'];
        $um = new UserModel();

        if ($um->isSuperAdmin($id)) {
            $this->flash('error', 'Admin utama tidak bisa berhenti lewat fitur ini.');
            $this->redirect('/admin/profil');
        }

        $um->demoteToAnggota($id);
        session_destroy();
        $this->redirect('/login');
    }

    // ================================================================
    //  RIWAYAT PENGURUS
    // ================================================================
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

    // ================================================================
    //  BERITA
    // ================================================================
    public function berita(): void
    {
        $this->requireAdmin();
        $bm     = new BeritaModel();
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $search = trim($_GET['q'] ?? '');
        $limit  = 15;
        $total  = $bm->countAll($search);
        $pages  = max(1, (int)ceil($total / $limit));
        $page   = min($page, $pages);
        $items  = $bm->getAll($page, $limit, $search);
        $pendingKomen = $bm->countKomentar('pending');
        $flash  = $this->getFlash();
        $csrf   = $this->csrfToken();
        $this->view('admin/berita', compact('items', 'page', 'pages', 'total', 'search', 'pendingKomen', 'flash', 'csrf'), 'admin');
    }

    public function beritaCreate(): void
    {
        $this->requireAdmin();
        $bm           = new BeritaModel();
        $kategoriList = $bm->getKategori();
        $flash        = $this->getFlash();
        $csrf         = $this->csrfToken();
        $this->view('admin/berita_form', compact('kategoriList', 'flash', 'csrf'), 'admin');
    }

    public function beritaStore(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $bm   = new BeritaModel();
        $data = $this->_beritaProcessForm();
        if ($data === null) {
            $this->redirect('/admin/berita/create');
        }

        $bm->create($data);
        $this->flash('success', 'Berita berhasil disimpan.');
        $this->redirect('/admin/berita');
    }

    public function beritaEdit(string $id): void
    {
        $this->requireAdmin();
        $bm     = new BeritaModel();
        $berita = $bm->findById((int)$id);
        if (!$berita) {
            $this->flash('error', 'Berita tidak ditemukan.');
            $this->redirect('/admin/berita');
        }
        $kategoriList = $bm->getKategori();
        $flash        = $this->getFlash();
        $csrf         = $this->csrfToken();
        $this->view('admin/berita_form', compact('berita', 'kategoriList', 'flash', 'csrf'), 'admin');
    }

    public function beritaUpdate(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $bm   = new BeritaModel();
        $data = $this->_beritaProcessForm((int)$id);
        if ($data === null) {
            $this->redirect('/admin/berita/' . $id . '/edit');
        }

        $bm->update((int)$id, $data);
        $this->flash('success', 'Berita berhasil diperbarui.');
        $this->redirect('/admin/berita');
    }

    public function beritaDelete(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $bm     = new BeritaModel();
        $berita = $bm->findById((int)$id);
        if ($berita && $berita['thumbnail']) {
            $path = UPLOAD_PATH . '/' . $berita['thumbnail'];
            if (file_exists($path)) @unlink($path);
        }
        $bm->delete((int)$id);
        $this->flash('success', 'Berita berhasil dihapus.');
        $this->redirect('/admin/berita');
    }

    // ── Komentar Berita ──────────────────────────────────────────────
    public function beritaKomentar(): void
    {
        $this->requireAdmin();
        $bm      = new BeritaModel();
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $items   = $bm->getAllKomentar($page, 20);
        $pending = $bm->countKomentar('pending');
        $flash   = $this->getFlash();
        $csrf    = $this->csrfToken();
        $this->view('admin/berita_komentar', compact('items', 'page', 'pending', 'flash', 'csrf'), 'admin');
    }

    public function beritaKomentarApprove(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();
        (new BeritaModel())->updateKomentarStatus((int)$id, 'approved');
        $this->flash('success', 'Komentar disetujui.');
        $this->redirect('/admin/berita/komentar');
    }

    public function beritaKomentarReject(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();
        (new BeritaModel())->updateKomentarStatus((int)$id, 'rejected');
        $this->flash('success', 'Komentar ditolak.');
        $this->redirect('/admin/berita/komentar');
    }

    public function beritaKomentarDelete(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();
        (new BeritaModel())->deleteKomentar((int)$id);
        $this->flash('success', 'Komentar dihapus.');
        $this->redirect('/admin/berita/komentar');
    }

    // ── Helper privat: proses form berita ───────────────────────────
    private function _beritaProcessForm(?int $id = null): ?array
    {
        $bm        = new BeritaModel();
        $judul     = htmlspecialchars(trim($_POST['judul'] ?? ''), ENT_QUOTES);
        $konten    = $_POST['konten'] ?? '';
        $ringkasan = htmlspecialchars(trim($_POST['ringkasan'] ?? ''), ENT_QUOTES);
        $katId     = (int)($_POST['kategori_id'] ?? 0);
        $status    = in_array($_POST['status'] ?? '', ['draft', 'published']) ? $_POST['status'] : 'draft';

        if (!$judul || !$konten) {
            $this->flash('error', 'Judul dan konten wajib diisi.');
            return null;
        }

        $thumbnail = null;
        if (!empty($_FILES['thumbnail']['name'])) {
            try {
                if ($id) {
                    $old = $bm->findById($id);
                    if ($old && $old['thumbnail'] && file_exists(UPLOAD_PATH . '/' . $old['thumbnail'])) {
                        @unlink(UPLOAD_PATH . '/' . $old['thumbnail']);
                    }
                }
                $thumbnail = FileUploader::uploadFoto($_FILES['thumbnail'], 'berita');
            } catch (RuntimeException $e) {
                $this->flash('error', 'Upload thumbnail gagal: ' . $e->getMessage());
                return null;
            }
        } elseif ($id) {
            $old       = $bm->findById($id);
            $thumbnail = $old['thumbnail'] ?? null;
        }

        return [
            'judul'       => $judul,
            'konten'      => $konten,
            'ringkasan'   => $ringkasan,
            'kategori_id' => $katId ?: null,
            'status'      => $status,
            'thumbnail'   => $thumbnail,
            'penulis_id'  => (int)$_SESSION['user_id'],
        ];
    }

    // ================================================================
    //  GALERI
    // ================================================================
    public function galeri(): void
    {
        $this->requireAdmin();
        $gm    = new GaleriModel();
        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = 15;
        $total = $gm->countAllAlbums();
        $pages = max(1, (int)ceil($total / $limit));
        $albums = $gm->getAllAlbums($page, $limit);
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/galeri', compact('albums', 'page', 'pages', 'total', 'flash', 'csrf'), 'admin');
    }

    public function galeriCreate(): void
    {
        $this->requireAdmin();
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/galeri_form', compact('flash', 'csrf'), 'admin');
    }

    public function galeriStore(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $judul     = htmlspecialchars(trim($_POST['judul'] ?? ''), ENT_QUOTES);
        $deskripsi = htmlspecialchars(trim($_POST['deskripsi'] ?? ''), ENT_QUOTES);
        $status    = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'published';
        $urutan    = max(0, (int)($_POST['urutan'] ?? 0));

        if (strlen($judul) < 2) {
            $this->flash('error', 'Judul album wajib diisi.');
            $this->redirect('/admin/galeri/create');
        }

        $cover = null;
        if (!empty($_FILES['cover']['name'])) {
            try {
                $cover = FileUploader::uploadFoto($_FILES['cover'], 'galeri_cover');
            } catch (RuntimeException $e) {
                $this->flash('error', $e->getMessage());
                $this->redirect('/admin/galeri/create');
            }
        }

        $gm      = new GaleriModel();
        $albumId = $gm->createAlbum([
            'judul'      => $judul,
            'deskripsi'  => $deskripsi,
            'cover'      => $cover,
            'status'     => $status,
            'urutan'     => $urutan,
            'created_by' => (int)$_SESSION['user_id'],
        ]);

        $this->flash('success', 'Album berhasil dibuat. Silakan tambahkan foto.');
        $this->redirect('/admin/galeri/' . $albumId . '/foto');
    }

    public function galeriEdit(string $id): void
    {
        $this->requireAdmin();
        $gm    = new GaleriModel();
        $album = $gm->findAlbumById((int)$id);
        if (!$album) {
            $this->flash('error', 'Album tidak ditemukan.');
            $this->redirect('/admin/galeri');
        }
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/galeri_form', compact('album', 'flash', 'csrf'), 'admin');
    }

    public function galeriUpdate(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $gm    = new GaleriModel();
        $album = $gm->findAlbumById((int)$id);
        if (!$album) {
            $this->flash('error', 'Album tidak ditemukan.');
            $this->redirect('/admin/galeri');
        }

        $judul     = htmlspecialchars(trim($_POST['judul'] ?? ''), ENT_QUOTES);
        $deskripsi = htmlspecialchars(trim($_POST['deskripsi'] ?? ''), ENT_QUOTES);
        $status    = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'published';
        $urutan    = max(0, (int)($_POST['urutan'] ?? 0));

        if (strlen($judul) < 2) {
            $this->flash('error', 'Judul album wajib diisi.');
            $this->redirect('/admin/galeri/' . $id . '/edit');
        }

        $cover = $album['cover'];
        if (!empty($_FILES['cover']['name'])) {
            try {
                if ($cover && file_exists(UPLOAD_PATH . '/' . $cover)) @unlink(UPLOAD_PATH . '/' . $cover);
                $cover = FileUploader::uploadFoto($_FILES['cover'], 'galeri_cover');
            } catch (RuntimeException $e) {
                $this->flash('error', $e->getMessage());
                $this->redirect('/admin/galeri/' . $id . '/edit');
            }
        }

        $gm->updateAlbum((int)$id, [
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'cover'     => $cover,
            'status'    => $status,
            'urutan'    => $urutan,
        ]);

        $this->flash('success', 'Album berhasil diperbarui.');
        $this->redirect('/admin/galeri');
    }

    public function galeriDelete(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $gm    = new GaleriModel();
        $album = $gm->findAlbumById((int)$id);
        if ($album) {
            $fotos = $gm->getFotoByAlbum((int)$id);
            foreach ($fotos as $f) {
                $p = UPLOAD_PATH . '/' . $f['file'];
                if (file_exists($p)) @unlink($p);
            }
            if ($album['cover'] && file_exists(UPLOAD_PATH . '/' . $album['cover'])) {
                @unlink(UPLOAD_PATH . '/' . $album['cover']);
            }
            $gm->deleteAlbum((int)$id);
        }

        $this->flash('success', 'Album dan semua foto berhasil dihapus.');
        $this->redirect('/admin/galeri');
    }

    // ── Foto Album ───────────────────────────────────────────────────
    public function galeriFoto(string $id): void
    {
        $this->requireAdmin();
        $gm    = new GaleriModel();
        $album = $gm->findAlbumById((int)$id);
        if (!$album) {
            $this->flash('error', 'Album tidak ditemukan.');
            $this->redirect('/admin/galeri');
        }
        $fotos = $gm->getFotoByAlbum((int)$id);
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/galeri_foto', compact('album', 'fotos', 'flash', 'csrf'), 'admin');
    }

    public function galeriUploadFoto(string $id): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $gm    = new GaleriModel();
        $album = $gm->findAlbumById((int)$id);
        if (!$album) {
            $this->flash('error', 'Album tidak ditemukan.');
            $this->redirect('/admin/galeri');
        }

        $files  = $_FILES['fotos'] ?? [];
        $count  = 0;
        $errors = [];

        if (!empty($files['name']) && is_array($files['name'])) {
            foreach ($files['name'] as $i => $name) {
                if (empty($name) || $files['error'][$i] !== UPLOAD_ERR_OK) continue;
                $single = [
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i],
                ];
                try {
                    $filename = FileUploader::uploadFoto($single, 'galeri_foto');
                    $judul    = htmlspecialchars(trim($_POST['judul_foto'][$i] ?? ''), ENT_QUOTES);
                    $gm->addFoto((int)$id, $filename, $judul ?: null, $i);
                    $count++;
                } catch (RuntimeException $e) {
                    $errors[] = $e->getMessage();
                }
            }
        }

        if ($errors) {
            $this->flash('warning', $count . ' foto berhasil. Gagal: ' . implode(', ', $errors));
        } else {
            $this->flash('success', "{$count} foto berhasil diupload.");
        }

        $this->redirect('/admin/galeri/' . $id . '/foto');
    }

    public function galeriDeleteFoto(string $fotoId): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $gm      = new GaleriModel();
        $foto    = $gm->getFotoById((int)$fotoId);
        $albumId = $foto['album_id'] ?? null;

        $file = $gm->deleteFoto((int)$fotoId);
        if ($file && file_exists(UPLOAD_PATH . '/' . $file)) {
            @unlink(UPLOAD_PATH . '/' . $file);
        }

        $this->flash('success', 'Foto berhasil dihapus.');
        $this->redirect('/admin/galeri/' . $albumId . '/foto');
    }

    // ================================================================
    //  ANGGOTA — EXPORT
    // ================================================================
    public function anggotaExport(): void
    {
        $this->requireAdmin();

        $format = ($_GET['format'] ?? 'csv') === 'xlsx' ? 'xlsx' : 'csv';
        $filter = [
            'kelas'  => $_GET['kelas']  ?? '',
            'search' => $_GET['search'] ?? '',
            'sumber' => $_GET['sumber'] ?? '',
        ];

        $um   = new UserModel();
        $rows = $um->getAnggotaForExport($filter);

        $headers = ['NIA', 'Nama Lengkap', 'Kelas', 'No HP', 'Email', 'Sumber', 'Status', 'Tahun Daftar'];
        $data = [];
        foreach ($rows as $r) {
            $data[] = [
                $r['nia']          ?? '',
                $r['nama_lengkap'] ?? '',
                $r['kelas']        ?? '',
                $r['no_hp']        ?? '',
                $r['email']        ?? '',
                $r['sumber']       ?? '',
                $r['status']       ?? '',
                $r['tahun_daftar'] ?? '',
            ];
        }

        $filename = 'anggota_' . date('Ymd_His');

        if ($format === 'xlsx') {
            $content = Xlsx::write($headers, $data);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
            header('Content-Length: ' . strlen($content));
            header('Cache-Control: max-age=0');
            echo $content;
            exit;
        }

        // default: CSV
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $out = fopen('php://output', 'w');
        fputs($out, "\xEF\xBB\xBF"); // BOM supaya Excel baca UTF-8 (é, ñ, dll) dgn benar
        fputcsv($out, $headers);
        foreach ($data as $row) {
            fputcsv($out, $row);
        }
        fclose($out);
        exit;
    }

    // ================================================================
    //  ANGGOTA — IMPORT
    // ================================================================
    public function anggotaImport(): void
    {
        $this->requireAdmin();
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();

        $importErrors = $_SESSION['import_errors'] ?? [];
        unset($_SESSION['import_errors']);

        $jabatanList = UserModel::JABATAN_LIST;

        $this->view('admin/anggota_import', compact('flash', 'csrf', 'importErrors', 'jabatanList'), 'admin');
    }

    public function anggotaImportTemplate(): void
    {
        $this->requireAdmin();

        $headers = ['Nama Lengkap', 'Kelas', 'No HP', 'Email', 'Tahun Daftar', 'Jabatan'];
        $example = ['Contoh Nama Siswa', 'XII RPL 1', '081234567890', 'contoh@email.com', date('Y'), 'anggota'];

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="template_import_anggota.csv"');

        $out = fopen('php://output', 'w');
        fputs($out, "\xEF\xBB\xBF");
        fputcsv($out, $headers);
        fputcsv($out, $example);
        fclose($out);
        exit;
    }

    public function anggotaImportProcess(): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        if (empty($_FILES['file']['name']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $this->flash('error', 'File tidak ditemukan atau gagal diupload.');
            $this->redirect('/admin/anggota/import');
        }

        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['csv', 'xlsx'], true)) {
            $this->flash('error', 'Format file harus .csv atau .xlsx.');
            $this->redirect('/admin/anggota/import');
        }

        $rows = [];

        if ($ext === 'csv') {
            $handle = fopen($_FILES['file']['tmp_name'], 'r');
            if ($handle === false) {
                $this->flash('error', 'Gagal membaca file CSV.');
                $this->redirect('/admin/anggota/import');
            }
            $first = fread($handle, 3);
            if ($first !== "\xEF\xBB\xBF") {
                rewind($handle);
            }
            while (($r = fgetcsv($handle)) !== false) {
                $rows[] = $r;
            }
            fclose($handle);
        } else {
            try {
                $rows = Xlsx::read($_FILES['file']['tmp_name']);
            } catch (RuntimeException $e) {
                $this->flash('error', $e->getMessage());
                $this->redirect('/admin/anggota/import');
            }
        }

        if (empty($rows)) {
            $this->flash('error', 'File kosong atau tidak berisi data.');
            $this->redirect('/admin/anggota/import');
        }

        array_shift($rows);

        $um = new UserModel();
        $defaultPasswordHash = password_hash('comsmakda', PASSWORD_BCRYPT, ['cost' => 12]);

        $sukses   = 0;
        $dilewati = 0;
        $errors   = [];

        foreach ($rows as $i => $row) {
            $lineNum = $i + 2;

            $nama  = trim((string)($row[0] ?? ''));
            $kelas = trim((string)($row[1] ?? ''));
            $noHp  = preg_replace('/\D/', '', (string)($row[2] ?? ''));
            $email = trim((string)($row[3] ?? ''));
            $email = filter_var($email, FILTER_VALIDATE_EMAIL) ?: null;

            $tahunRaw = trim((string)($row[4] ?? ''));
            $tahunMax = (int)date('Y') + 1;
            $tahun = (ctype_digit($tahunRaw) && (int)$tahunRaw >= 2000 && (int)$tahunRaw <= $tahunMax)
                ? (int)$tahunRaw
                : (int)date('Y');

            $jabatanRaw = trim((string)($row[5] ?? ''));
            $jabatan    = array_key_exists($jabatanRaw, UserModel::JABATAN_LIST) ? $jabatanRaw : 'anggota';

            if ($nama === '' && $kelas === '' && $noHp === '' && !$email) {
                continue;
            }

            if ($nama === '' || $kelas === '') {
                $errors[] = "Baris {$lineNum}: nama/kelas kosong — dilewati.";
                $dilewati++;
                continue;
            }

            if (($email && $um->existsByEmail($email)) || ($noHp && $um->existsByPhone($noHp))) {
                $errors[] = "Baris {$lineNum}: {$nama} — email/No HP sudah terdaftar, dilewati.";
                $dilewati++;
                continue;
            }

            $userId = $um->createAnggota([
                'nama_lengkap'  => htmlspecialchars($nama, ENT_QUOTES),
                'kelas'         => htmlspecialchars($kelas, ENT_QUOTES),
                'no_hp'         => $noHp,
                'email'         => $email,
                'password_hash' => $defaultPasswordHash,
                'foto'          => null,
                'jabatan'       => $jabatan,
                'sumber'        => 'manual',
                'tahun_daftar'  => $tahun,
            ]);

            $um->aktivasi($userId);
            $sukses++;
        }

        $msg = "{$sukses} anggota berhasil diimpor";
        $msg .= $dilewati > 0 ? ", {$dilewati} baris dilewati (kosong/duplikat)." : '.';
        $msg .= ' Password default: <strong>comsmakda</strong> (wajib diganti anggota setelah login).';

        $this->flash($dilewati > 0 && $sukses === 0 ? 'error' : ($dilewati > 0 ? 'warning' : 'success'), $msg);

        if (!empty($errors)) {
            $_SESSION['import_errors'] = array_slice($errors, 0, 50);
        }

        $this->redirect($sukses > 0 || $dilewati > 0 ? '/admin/anggota' : '/admin/anggota/import');
    }

    // ================================================================
    //  ANGGOTA — RESET SEQUENCE NIA
    // ================================================================
    public function niaSequence(): void
    {
        $this->requireAdmin();
        $gen   = new NiaGenerator();
        $rows  = $gen->getAllSequenceInfo();
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('admin/nia_sequence', compact('rows', 'flash', 'csrf'), 'admin');
    }

    public function niaSequenceSync(string $tahun): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $next = (new NiaGenerator())->resetToActual((int)$tahun);
        $this->flash('success', "Sequence NIA tahun {$tahun} disinkronkan dengan data real. NIA berikutnya urut #{$next}.");
        $this->redirect('/admin/nia-sequence');
    }

    public function niaSequenceManual(string $tahun): void
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $nextUrut = max(1, (int)($_POST['next_urut'] ?? 1));
        (new NiaGenerator())->resetManual((int)$tahun, $nextUrut);
        $this->flash('success', "Sequence NIA tahun {$tahun} diset manual. NIA berikutnya urut #{$nextUrut}.");
        $this->redirect('/admin/nia-sequence');
    }
}