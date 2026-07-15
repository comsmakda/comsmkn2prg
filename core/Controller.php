<?php
// core/Controller.php

class Controller
{
    // ── Render view dengan layout ────────────────────────────────────────
    protected function view(
        string $page,
        array  $data   = [],
        ?string $layout = 'default'
    ): void {
        extract($data, EXTR_SKIP);
        $contentFile = BASE_PATH . '/app/views/' . $page . '.php';

        if (!file_exists($contentFile)) {
            http_response_code(404);
            require BASE_PATH . '/app/views/errors/404.php';
            return;
        }

        // Jika layout null → render standalone tanpa layout
        if ($layout === null) {
            require $contentFile;
            return;
        }

        $layoutFile = BASE_PATH . '/app/views/layouts/' . $layout . '.php';

        // Buffer konten halaman
        ob_start();
        require $contentFile;
        $content = ob_get_clean();

        // Render ke layout
        require $layoutFile;
    }

    // ── Helpers Auth ─────────────────────────────────────────────────────
    protected function requireLogin(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    protected function requireAdmin(): void
    {
        $this->requireLogin();
        if ($_SESSION['user_role'] !== 'admin') {
            http_response_code(403);
            require BASE_PATH . '/app/views/errors/403.php';
            exit;
        }
    }

    protected function requireAnggota(): void
    {
        $this->requireLogin();
        if ($_SESSION['user_role'] !== 'anggota') {
            $this->redirect('/dashboard');
        }
    }

    /**
     * Khusus admin utama (is_super_admin = 1). Dipakai untuk fitur
     * "Kelola Admin" yang tidak boleh diketahui admin biasa.
     *
     * Sengaja pakai flash + redirect ke dashboard (bukan halaman 403),
     * supaya kalau admin biasa iseng menebak URL-nya, dia tidak mendapat
     * sinyal "kamu ditolak akses ke fitur khusus ini" — cuma diarahkan
     * balik ke dashboard seperti biasa.
     */
    protected function requireSuperAdmin(): void
    {
        $this->requireAdmin();
        $id = (int)($_SESSION['user_id'] ?? 0);

        if (!(new UserModel())->isSuperAdmin($id)) {
            $this->flash('error', 'Fitur ini khusus admin utama.');
            $this->redirect('/admin/dashboard');
        }
    }

    // ── Flash messages ───────────────────────────────────────────────────
    protected function flash(string $type, string $msg): void
    {
        $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
    }

    protected function getFlash(): array
    {
        $flash = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $flash;
    }

    // ── Redirect ─────────────────────────────────────────────────────────
    protected function redirect(string $path): never
    {
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    // ── JSON Response ────────────────────────────────────────────────────
    protected function json(mixed $data, int $code = 200): never
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // ── CSRF ─────────────────────────────────────────────────────────────
    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            die('Invalid CSRF token.');
        }
    }
}