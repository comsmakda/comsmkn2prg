<?php
// core/FileUploader.php

class FileUploader
{
    /**
     * Upload foto, return nama file atau throw Exception
     */
    public static function uploadFoto(array $file, string $prefix = 'foto'): string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Upload gagal. Kode error: ' . $file['error']);
        }

        if ($file['size'] > MAX_UPLOAD_SIZE) {
            throw new RuntimeException('Ukuran file melebihi batas 2 MB.');
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ALLOWED_EXT, true)) {
            throw new RuntimeException('Format file tidak diizinkan. Gunakan JPG, PNG, atau WEBP.');
        }

        // Validasi MIME sesungguhnya
        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $validMimes = ['image/jpeg','image/png','image/webp'];
        if (!in_array($mimeType, $validMimes, true)) {
            throw new RuntimeException('File bukan gambar yang valid.');
        }

        if (!is_dir(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH, 0755, true);
        }

        $filename = $prefix . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $dest     = UPLOAD_PATH . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            throw new RuntimeException('Gagal menyimpan file.');
        }

        return $filename;
    }

    public static function deleteFoto(?string $filename): void
    {
        if ($filename && file_exists(UPLOAD_PATH . '/' . $filename)) {
            unlink(UPLOAD_PATH . '/' . $filename);
        }
    }
}
