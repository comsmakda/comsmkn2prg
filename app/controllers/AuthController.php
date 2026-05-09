<?php
// app/controllers/AuthController.php

class AuthController extends Controller
{
    public function loginPage(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $this->redirect($_SESSION['user_role'] === 'admin' ? '/admin/dashboard' : '/member/dashboard');
        }
        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();
        $csrf     = $this->csrfToken();
        $this->view('pages/login', compact('settings', 'flash', 'csrf'), null);
    }

    public function loginPost(): void
    {
        $this->verifyCsrf();

        $loginType = trim($_POST['login_type'] ?? 'member');
        $password  = trim($_POST['password'] ?? '');

        if ($loginType === 'admin') {
            $email = trim($_POST['email'] ?? '');

            if (!$email || !$password) {
                $this->flash('error', 'Email dan password wajib diisi.');
                $this->redirect('/login');
            }

            $user = (new UserModel())->findByEmail($email);

            if (!$user || $user['role'] !== 'admin') {
                $this->flash('error', 'Email atau password salah.');
                $this->redirect('/login');
            }
        } else {
            $nia = trim($_POST['nia'] ?? '');

            if (!$nia || !$password) {
                $this->flash('error', 'NIA dan password wajib diisi.');
                $this->redirect('/login');
            }

            $user = (new UserModel())->findByNia($nia);

            if (!$user) {
                $this->flash('error', 'NIA atau password salah.');
                $this->redirect('/login');
            }
        }

        if (!password_verify($password, $user['password_hash'])) {
            $this->flash('error', $loginType === 'admin' ? 'Email atau password salah.' : 'NIA atau password salah.');
            $this->redirect('/login');
        }

        if ($user['status'] !== 'aktif') {
            $this->flash('error', 'Akun Anda belum aktif atau sedang dinonaktifkan.');
            $this->redirect('/login');
        }

        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['nama_lengkap'];
        $_SESSION['user_nia']  = $user['nia'] ?? null;

        $this->redirect($user['role'] === 'admin' ? '/admin/dashboard' : '/member/dashboard');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/');
    }
}