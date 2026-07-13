<?php
// app/controllers/MemberController.php

class MemberController extends Controller
{
    // ════════════════════════════════════════════════════════
    //  DASHBOARD
    // ════════════════════════════════════════════════════════
    public function dashboard(): void
    {
        $this->requireAnggota();
        $user     = (new UserModel())->find((int)$_SESSION['user_id']);
        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();
        $this->view('member/dashboard', compact('user', 'settings', 'flash'), 'member');
    }

    // ════════════════════════════════════════════════════════
    //  PROFIL
    // ════════════════════════════════════════════════════════
    public function profile(): void
    {
        $this->requireAnggota();
        $user  = (new UserModel())->find((int)$_SESSION['user_id']);
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->view('member/profile', compact('user', 'flash', 'csrf'), 'member');
    }

    public function profileUpdate(): void
    {
        $this->requireAnggota();
        $this->verifyCsrf();

        $d = [
            'nama_lengkap' => htmlspecialchars(trim($_POST['nama_lengkap'] ?? ''), ENT_QUOTES),
            'kelas'        => htmlspecialchars(trim($_POST['kelas'] ?? ''), ENT_QUOTES),
            'no_hp'        => preg_replace('/\D/', '', $_POST['no_hp'] ?? ''),
            'foto'         => null,
        ];

        if (!empty($_FILES['foto']['name'])) {
            try {
                $d['foto'] = FileUploader::uploadFoto($_FILES['foto'], 'member');
            } catch (RuntimeException $e) {
                $this->flash('error', $e->getMessage());
                $this->redirect('/member/profile');
            }
        }

        (new UserModel())->updateProfile((int)$_SESSION['user_id'], $d);
        $_SESSION['user_name'] = $d['nama_lengkap'];
        $this->flash('success', 'Profil berhasil diperbarui.');
        $this->redirect('/member/profile');
    }

    public function changePassword(): void
    {
        $this->requireAnggota();
        $this->verifyCsrf();

        $um      = new UserModel();
        $user    = $um->find((int)$_SESSION['user_id']);
        $old     = $_POST['password_lama'] ?? '';
        $new     = $_POST['password_baru'] ?? '';
        $confirm = $_POST['password_konfirmasi'] ?? '';

        if (!password_verify($old, $user['password_hash'])) {
            $this->flash('error', 'Password lama tidak cocok.');
            $this->redirect('/member/profile');
        }
        if (strlen($new) < 6) {
            $this->flash('error', 'Password baru minimal 6 karakter.');
            $this->redirect('/member/profile');
        }
        if ($new !== $confirm) {
            $this->flash('error', 'Konfirmasi password tidak cocok.');
            $this->redirect('/member/profile');
        }

        $um->changePassword((int)$_SESSION['user_id'], password_hash($new, PASSWORD_BCRYPT, ['cost' => 12]));
        $this->flash('success', 'Password berhasil diubah.');
        $this->redirect('/member/profile');
    }

    // ════════════════════════════════════════════════════════
    //  ABSENSI SAYA
    // ════════════════════════════════════════════════════════
    public function absensi(): void
    {
        $this->requireAnggota();

        $userId       = (int)$_SESSION['user_id'];
        $tanggalMulai = $_GET['tanggal_mulai'] ?? date('Y-m-01');
        $tanggalAkhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');

        $fpModel = new FingerprintModel();
        $riwayat = $fpModel->getRiwayatAbsensiAnggota($userId, $tanggalMulai, $tanggalAkhir);

        // Key lengkap disiapkan di awal (termasuk 'libur' & 'belum_mulai') supaya
        // tidak ada warning "Undefined array key" saat increment, dan supaya
        // status baru di masa depan tetap aman lewat fallback isset() di bawah.
        $stats = [
            'hadir'       => 0,
            'terlambat'   => 0,
            'alpa'        => 0,
            'libur'       => 0,
            'belum_mulai' => 0,
        ];
        foreach ($riwayat as $r) {
            $status = $r['status'] ?? 'alpa';
            if (!isset($stats[$status])) {
                $stats[$status] = 0; // jaga-jaga kalau ada status baru di masa depan
            }
            $stats[$status]++;
        }

        $flash = $this->getFlash();
        $this->view('member/absensi', compact('riwayat', 'tanggalMulai', 'tanggalAkhir', 'stats'), 'member');
    }

    // ════════════════════════════════════════════════════════
    //  SURAT PERNYATAAN (download/print)
    // ════════════════════════════════════════════════════════
    public function suratPernyataan(): void
    {
        $this->requireAnggota();
        $user     = (new UserModel())->find((int)$_SESSION['user_id']);
        $settings = (new SettingModel())->getAll();

        if ($user['status'] !== 'aktif' || empty($user['nia'])) {
            $this->flash('error', 'Surat hanya tersedia untuk anggota aktif.');
            $this->redirect('/member/dashboard');
        }

        // Render halaman cetak
        $this->view('/member/surat_pernyataan', compact('user', 'settings'), 'member');
    }
}