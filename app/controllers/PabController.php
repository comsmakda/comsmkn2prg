<?php
// app/controllers/PabController.php

class PabController extends Controller
{
    public function index(): void
    {
        $sm       = new SettingModel();
        $isOpen   = $sm->isPabOpen();
        $settings = $sm->getAll();
        $flash    = $this->getFlash();
        $csrf     = $this->csrfToken();

        // Ambil input lama (jika ada dari percobaan submit sebelumnya), lalu bersihkan
        $old = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);

        $this->view('pages/pab', compact('isOpen', 'settings', 'flash', 'csrf', 'old'), 'main');
    }

    public function register(): void
    {
        $this->verifyCsrf();

        $sm = new SettingModel();
        if (!$sm->isPabOpen()) {
            $this->flashMessages('error', ['Pendaftaran PAB sedang ditutup.']);
            $this->redirect('/pab');
        }

        // Sanitize input
        $nisn     = preg_replace('/\D/', '', $_POST['nisn'] ?? '');
        $nama     = htmlspecialchars(trim($_POST['nama_lengkap'] ?? ''), ENT_QUOTES);
        $kelas    = htmlspecialchars(trim($_POST['kelas'] ?? ''), ENT_QUOTES);
        $no_hp    = preg_replace('/\D/', '', $_POST['no_hp'] ?? '');
        $password = $_POST['password'] ?? '';
        $passConf = $_POST['password_confirmation'] ?? '';

        $errors = [];
        if (strlen($nisn) !== 10)           $errors[] = 'NISN harus terdiri dari 10 digit angka.';
        if (strlen($nama) < 3)              $errors[] = 'Nama lengkap minimal 3 karakter.';
        if (empty($kelas))                  $errors[] = 'Kelas wajib diisi.';
        if (strlen($no_hp) < 10)            $errors[] = 'Nomor HP tidak valid (minimal 10 digit).';
        if (strlen($password) < 6)          $errors[] = 'Password minimal 6 karakter.';
        if ($password !== $passConf)        $errors[] = 'Konfirmasi password tidak cocok.';
        if (empty($_FILES['foto']['name'])) $errors[] = 'Pas foto wajib diunggah.';

        // Data yang selalu disiapkan untuk dikembalikan ke form (password sengaja TIDAK disimpan)
        $oldInput = [
            'nisn'         => $nisn,
            'nama_lengkap' => $nama,
            'kelas'        => $kelas,
            'no_hp'        => $no_hp,
        ];

        if ($errors) {
            $_SESSION['old_input'] = $oldInput;
            $this->flashMessages('error', $errors);
            $this->redirect('/pab');
        }

        $pm = new PabModel();
        $um = new UserModel();

        // ── Cek duplikasi NISN ke tabel users ──
        // Menangani kasus: NISN sudah diisi/di-backfill lewat edit profil anggota
        // (member/profile), atau anggota lama yang sudah aktif tapi belum pernah
        // melalui alur PAB sama sekali. Tanpa cek ini, NISN yang sudah tercatat
        // di `users` masih bisa lolos daftar PAB karena PabModel::findByNisn()
        // hanya melihat tabel pab_registrations.
        $existingUser = $um->findByNisn($nisn);
        if ($existingUser) {
            $_SESSION['old_input'] = $oldInput;
            $this->flashMessages('error', [
                'NISN ' . $nisn . ' sudah terdaftar sebagai anggota. Data tidak boleh ganda.'
            ]);
            $this->redirect('/pab');
        }

        // ── Cek duplikasi NISN ke tabel pab_registrations ──
        $existing = $pm->findByNisn($nisn);
        if ($existing && in_array($existing['status'], ['pending', 'approved'], true)) {
            $_SESSION['old_input'] = $oldInput;
            $this->flashMessages('error', [
                'NISN ' . $nisn . ' sudah terdaftar dengan status "' . $existing['status'] . '". Data tidak boleh ganda.'
            ]);
            $this->redirect('/pab');
        }
        // Kalau $existing status-nya 'rejected', boleh daftar ulang (akan menimpa baris lama)

        // Upload foto
        try {
            $fotoName = FileUploader::uploadFoto($_FILES['foto'], 'pab');
        } catch (RuntimeException $e) {
            $_SESSION['old_input'] = $oldInput;
            $this->flashMessages('error', [$e->getMessage()]);
            $this->redirect('/pab');
        }

        $data = [
            'nisn'          => $nisn,
            'nama_lengkap'  => $nama,
            'kelas'         => $kelas,
            'no_hp'         => $no_hp,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
            'foto'          => $fotoName,
        ];

        try {
            if ($existing && $existing['status'] === 'rejected') {
                $pm->resubmit($existing['id'], $data);
            } else {
                $pm->create($data);
            }
        } catch (PDOException $e) {
            // Jaring pengaman terakhir kalau ada race condition (dua submit bersamaan)
            if ((int)$e->getCode() === 23000 || $e->getCode() === '23000') {
                $_SESSION['old_input'] = $oldInput;
                $this->flashMessages('error', ['NISN ' . $nisn . ' sudah terdaftar. Silakan cek kembali data Anda.']);
                $this->redirect('/pab');
            }
            throw $e;
        }

        $this->flashMessages('success', ['Pendaftaran berhasil! Tunggu verifikasi Admin.']);
        $this->redirect('/pab');
    }

    /**
     * Halaman cek status pendaftaran PAB berdasarkan NISN.
     * Publik, tanpa login — jadi hanya field yang aman ditampilkan
     * (nama, kelas, status, catatan admin, NIA jika approved).
     * no_hp dan password_hash sengaja TIDAK diikutkan ke view.
     */
    public function cekStatus(): void
    {
        $nisnRaw = isset($_GET['nisn']) ? trim($_GET['nisn']) : '';
        $nisn    = preg_replace('/\D/', '', $nisnRaw);

        $result   = null;
        $errorMsg = null;

        if ($nisnRaw !== '') {
            if (strlen($nisn) !== 10) {
                $errorMsg = 'NISN harus terdiri dari 10 digit angka.';
            } else {
                $pm  = new PabModel();
                $reg = $pm->findByNisnWithNia($nisn);

                if (!$reg) {
                    $errorMsg = 'NISN tidak ditemukan. Pastikan kamu sudah mendaftar lewat halaman PAB.';
                } else {
                    $result = $reg;
                }
            }
        }

        $this->view('pages/pab_status', compact('nisn', 'nisnRaw', 'result', 'errorMsg'), 'main');
    }

    /**
     * Helper: kirim beberapa pesan sekaligus ke flash() milik Controller dasar,
     * yang hanya menerima string. Di-encode jadi JSON supaya bisa dibaca
     * kembali sebagai array di view (lihat $flashMsgs di pab.php).
     */
    private function flashMessages(string $type, array $messages): void
    {
        $this->flash($type, json_encode($messages, JSON_UNESCAPED_UNICODE));
    }
}