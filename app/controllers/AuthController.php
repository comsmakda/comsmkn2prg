<?php
// app/controllers/AuthController.php

class AuthController extends Controller
{
    public function loginPage(): void
    {
        if (!empty($_SESSION['user_id'])) {
            // Jika sudah login, cek redirect_to dulu
            $redirectTo = $_GET['redirect_to'] ?? null;
            if ($redirectTo && str_starts_with($redirectTo, 'https://surat.comsmkn2pinrang.my.id')) {
                $this->redirect($redirectTo);
            }
            $this->redirect($_SESSION['user_role'] === 'admin' ? '/admin/dashboard' : '/member/dashboard');
        }
        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();
        $csrf     = $this->csrfToken();
        $redirectTo = $_GET['redirect_to'] ?? '';
        $this->view('pages/login', compact('settings', 'flash', 'csrf', 'redirectTo'), null);
    }

    public function loginPost(): void
    {
        $this->verifyCsrf();

        $loginType  = trim($_POST['login_type'] ?? 'member');
        $password   = trim($_POST['password'] ?? '');
        $redirectTo = trim($_POST['redirect_to'] ?? '');

        if ($loginType === 'admin') {
            $email = trim($_POST['email'] ?? '');

            if (!$email || !$password) {
                $this->flash('error', 'Email dan password wajib diisi.');
                $this->redirect('/login' . ($redirectTo ? '?redirect_to=' . urlencode($redirectTo) : ''));
            }

            $user = (new UserModel())->findByEmail($email);

            if (!$user || $user['role'] !== 'admin') {
                $this->flash('error', 'Email atau password salah.');
                $this->redirect('/login' . ($redirectTo ? '?redirect_to=' . urlencode($redirectTo) : ''));
            }
        } else {
            $nia = trim($_POST['nia'] ?? '');

            if (!$nia || !$password) {
                $this->flash('error', 'NIA dan password wajib diisi.');
                $this->redirect('/login' . ($redirectTo ? '?redirect_to=' . urlencode($redirectTo) : ''));
            }

            $user = (new UserModel())->findByNia($nia);

            if (!$user) {
                $this->flash('error', 'NIA atau password salah.');
                $this->redirect('/login' . ($redirectTo ? '?redirect_to=' . urlencode($redirectTo) : ''));
            }
        }

        if (!password_verify($password, $user['password_hash'])) {
            $this->flash('error', $loginType === 'admin' ? 'Email atau password salah.' : 'NIA atau password salah.');
            $this->redirect('/login' . ($redirectTo ? '?redirect_to=' . urlencode($redirectTo) : ''));
        }

        if ($user['status'] !== 'aktif') {
            $this->flash('error', 'Akun Anda belum aktif atau sedang dinonaktifkan.');
            $this->redirect('/login' . ($redirectTo ? '?redirect_to=' . urlencode($redirectTo) : ''));
        }

        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['nama_lengkap'];
        $_SESSION['user_nia']  = $user['nia'] ?? null;

        // Redirect ke surat-app jika ada redirect_to yang valid
        if ($redirectTo && str_starts_with($redirectTo, 'https://surat.comsmkn2pinrang.my.id')) {
            // Generate SSO token dulu sebelum redirect ke surat-app
            $token   = bin2hex(random_bytes(64));
            $expired = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $ip      = $_SERVER['REMOTE_ADDR'] ?? null;

            $pdo = db();
            $pdo->prepare("DELETE FROM surat_auth_tokens WHERE user_id = ? AND used = 0")
                ->execute([$user['id']]);
            $pdo->prepare("INSERT INTO surat_auth_tokens (user_id, token, ip_address, expired_at) VALUES (?,?,?,?)")
                ->execute([$user['id'], $token, $ip, $expired]);

            $this->redirect('https://surat.comsmkn2pinrang.my.id/?sso_token=' . $token);
        }

        $this->redirect($user['role'] === 'admin' ? '/admin/dashboard' : '/member/dashboard');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/');
    }
}