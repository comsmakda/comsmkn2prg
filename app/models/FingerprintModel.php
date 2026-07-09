<?php

/**
 * FingerprintModel
 *
 * Menjembatani aplikasi PHP dengan Sync Agent (Python/FastAPI/pyzk) yang
 * berkomunikasi langsung dengan mesin fingerprint GEISA X107 (protokol ZKTeco).
 *
 * Semua komunikasi HTTP memakai cURL native (tanpa library eksternal),
 * konfigurasi (URL agent, API key, dsb) diambil dari SettingModel — bukan hardcode.
 */
class FingerprintModel
{
    private PDO $db;
    private SettingModel $settingModel;

    /** @var int Timeout koneksi ke Sync Agent (detik) */
    private const HTTP_TIMEOUT = 10;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->settingModel = new SettingModel();
    }

    // =====================================================================
    // KONFIGURASI
    // =====================================================================

    private function getAgentUrl(): string
    {
        $url = trim((string) $this->settingModel->get('fp_sync_agent_url'));
        return rtrim($url, '/');
    }

    private function getApiKey(): string
    {
        return (string) $this->settingModel->get('fp_sync_api_key');
    }

    private function getBatasTerlambat(): string
    {
        $val = (string) $this->settingModel->get('fp_batas_terlambat');
        return $val !== '' ? $val : '07:15:00';
    }

    // =====================================================================
    // HTTP CLIENT KE SYNC AGENT
    // =====================================================================

    /**
     * Kirim request HTTP ke Sync Agent.
     *
     * @return array{success:bool, status:int, data:array|null, error:string|null}
     */
    private function request(string $method, string $path, ?array $body = null): array
    {
        $baseUrl = $this->getAgentUrl();

        if ($baseUrl === '') {
            return [
                'success' => false,
                'status'  => 0,
                'data'    => null,
                'error'   => 'URL Sync Agent belum dikonfigurasi (fp_sync_agent_url).',
            ];
        }

        $url = $baseUrl . $path;

        $headers = [
            'X-Api-Key: ' . $this->getApiKey(),
            'Accept: application/json',
        ];

        $ch = curl_init($url);

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_TIMEOUT        => self::HTTP_TIMEOUT,
            CURLOPT_CONNECTTIMEOUT => self::HTTP_TIMEOUT,
        ];

        if ($body !== null) {
            $json = json_encode($body, JSON_UNESCAPED_UNICODE);
            $headers[] = 'Content-Type: application/json';
            $options[CURLOPT_POSTFIELDS] = $json;
        }

        $options[CURLOPT_HTTPHEADER] = $headers;
        curl_setopt_array($ch, $options);

        $raw = curl_exec($ch);

        if ($raw === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'success' => false,
                'status'  => 0,
                'data'    => null,
                'error'   => 'Gagal menghubungi Sync Agent: ' . $error,
            ];
        }

        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            $decoded = null;
        }

        if ($status < 200 || $status >= 300) {
            $errMsg = 'HTTP ' . $status;
            if (is_array($decoded) && isset($decoded['detail'])) {
                $errMsg .= ': ' . (is_string($decoded['detail']) ? $decoded['detail'] : json_encode($decoded['detail']));
            } elseif (is_array($decoded) && isset($decoded['error'])) {
                $errMsg .= ': ' . $decoded['error'];
            }
            return [
                'success' => false,
                'status'  => $status,
                'data'    => $decoded,
                'error'   => $errMsg,
            ];
        }

        return [
            'success' => true,
            'status'  => $status,
            'data'    => $decoded,
            'error'   => null,
        ];
    }

    // =====================================================================
    // PUSH / DELETE ANGGOTA KE MESIN
    // =====================================================================

    /**
     * Push satu anggota (berdasarkan users.id) ke mesin fingerprint.
     * Update fp_status/fp_synced_at/fp_last_error sesuai hasil.
     */
    public function pushUser(int $userId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT id, nia, nama_lengkap, status FROM users WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if ($user['status'] !== 'aktif') {
            $this->updateFpStatus($userId, 'gagal', 'Anggota tidak berstatus aktif.');
            return false;
        }

        $result = $this->request('POST', '/users', [
            'nia'          => $user['nia'],
            'nama_lengkap' => $user['nama_lengkap'],
            'privilege'    => 0,
        ]);

        if ($result['success']) {
            $this->updateFpStatus($userId, 'tersinkron', null, true);
            return true;
        }

        $this->updateFpStatus($userId, 'gagal', $result['error']);
        return false;
    }

    /**
     * Push banyak anggota sekaligus.
     *
     * @return array{sukses:int, gagal:int, detail:array<int,array{user_id:int, nia:string, sukses:bool, pesan:?string}>}
     */
    public function pushBulk(array $userIds): array
    {
        $summary = ['sukses' => 0, 'gagal' => 0, 'detail' => []];

        foreach ($userIds as $userId) {
            $userId = (int) $userId;

            $stmt = $this->db->prepare('SELECT nia FROM users WHERE id = ? LIMIT 1');
            $stmt->execute([$userId]);
            $nia = $stmt->fetchColumn();

            $ok = $this->pushUser($userId);

            if ($ok) {
                $summary['sukses']++;
            } else {
                $summary['gagal']++;
            }

            $summary['detail'][] = [
                'user_id' => $userId,
                'nia'     => $nia !== false ? $nia : '',
                'sukses'  => $ok,
                'pesan'   => $ok ? null : $this->getLastError($userId),
            ];
        }

        return $summary;
    }

    /**
     * Hapus anggota dari mesin fingerprint berdasarkan NIA.
     * Dipanggil saat anggota dinonaktifkan atau dihapus manual dari halaman fingerprint.
     */
    public function deleteUser(string $nia): bool
    {
        $result = $this->request('DELETE', '/users/' . rawurlencode($nia));

        $stmt = $this->db->prepare('SELECT id FROM users WHERE nia = ? LIMIT 1');
        $stmt->execute([$nia]);
        $userId = $stmt->fetchColumn();

        if ($userId === false) {
            return $result['success'];
        }

        if ($result['success']) {
            $upd = $this->db->prepare(
                'UPDATE users SET fp_status = ?, fp_synced_at = NULL, fp_last_error = NULL WHERE id = ?'
            );
            $upd->execute(['belum_sync', (int) $userId]);
        } else {
            $this->updateFpStatus((int) $userId, 'gagal', $result['error']);
        }

        return $result['success'];
    }

    private function updateFpStatus(int $userId, string $status, ?string $error, bool $touchSyncedAt = false): void
    {
        if ($touchSyncedAt) {
            $stmt = $this->db->prepare(
                'UPDATE users SET fp_status = ?, fp_synced_at = NOW(), fp_last_error = ? WHERE id = ?'
            );
        } else {
            $stmt = $this->db->prepare(
                'UPDATE users SET fp_status = ?, fp_last_error = ? WHERE id = ?'
            );
        }
        $stmt->execute([$status, $error, $userId]);
    }

    private function getLastError(int $userId): ?string
    {
        $stmt = $this->db->prepare('SELECT fp_last_error FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $val = $stmt->fetchColumn();
        return $val !== false ? $val : null;
    }

    // =====================================================================
    // STATUS MESIN
    // =====================================================================

    /**
     * @return array{success:bool, message:string, raw:array|null}
     */
    public function checkDeviceHealth(): array
    {
        $result = $this->request('GET', '/health');

        return [
            'success' => $result['success'],
            'message' => $result['success']
                ? 'Mesin terhubung.'
                : ($result['error'] ?? 'Tidak dapat terhubung ke mesin.'),
            'raw' => $result['data'],
        ];
    }

    // =====================================================================
    // TARIK & SIMPAN LOG SCAN
    // =====================================================================

    /**
     * Tarik seluruh log scan dari mesin (via Sync Agent) dan simpan ke fp_scan_logs.
     * Aman dipanggil berulang kali karena memakai INSERT IGNORE + UNIQUE KEY.
     *
     * @return array{success:bool, jumlah_baru:int, error:?string}
     */
    public function pullAndSaveLogs(): array
    {
        $result = $this->request('GET', '/logs');

        if (!$result['success']) {
            return ['success' => false, 'jumlah_baru' => 0, 'error' => $result['error']];
        }

        $logs = $result['data']['logs'] ?? [];
        if (!is_array($logs)) {
            $logs = [];
        }

        $insert = $this->db->prepare(
            'INSERT IGNORE INTO fp_scan_logs (nia, user_id, waktu_scan, tipe_scan, device_sn)
             VALUES (?, (SELECT id FROM users WHERE nia = ? LIMIT 1), ?, ?, ?)'
        );

        $jumlahBaru = 0;

        $this->db->beginTransaction();
        try {
            foreach ($logs as $log) {
                $nia = $log['nia'] ?? null;
                $waktuScan = $log['waktu_scan'] ?? null;

                if (!$nia || !$waktuScan) {
                    continue;
                }

                $insert->execute([
                    $nia,
                    $nia,
                    $waktuScan,
                    $log['tipe_scan'] ?? null,
                    $log['device_sn'] ?? null,
                ]);

                if ($insert->rowCount() > 0) {
                    $jumlahBaru++;
                }
            }
            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollBack();
            return ['success' => false, 'jumlah_baru' => 0, 'error' => $e->getMessage()];
        }

        return ['success' => true, 'jumlah_baru' => $jumlahBaru, 'error' => null];
    }

    // =====================================================================
    // REKAP HARIAN
    // =====================================================================

    /**
     * Rekap presensi harian dari fp_scan_logs untuk rentang tanggal tertentu.
     * Anggota aktif tanpa scan pada tanggal tsb dihitung 'alpa'.
     *
     * @param array{kelas?:string} $filter
     * @return array<int, array{
     *   user_id:int, nama_lengkap:string, nia:string, kelas:string,
     *   tanggal:string, jam_masuk:?string, jam_pulang:?string, status:string
     * }>
     */
    public function getRekapHarian(string $tanggalMulai, string $tanggalAkhir, array $filter = []): array
    {
        $batasTerlambat = $this->getBatasTerlambat();

        $params = [
            'tgl_mulai' => $tanggalMulai,
            'tgl_akhir' => $tanggalAkhir,
        ];

        $kelasSql = '';
        if (!empty($filter['kelas'])) {
            $kelasSql = ' AND u.kelas = :kelas';
            $params['kelas'] = $filter['kelas'];
        }

        // Ambil semua anggota aktif yang relevan
        $stmtUsers = $this->db->prepare(
            "SELECT id, nia, nama_lengkap, kelas
             FROM users
             WHERE status = 'aktif' {$kelasSql}
             ORDER BY kelas, nama_lengkap"
        );
        $stmtUsers->execute($this->onlyKeys($params, ['kelas']));
        $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

        if (empty($users)) {
            return [];
        }

        // Ambil rekap scan per user per tanggal dalam rentang
        $stmtScan = $this->db->prepare(
            "SELECT
                user_id,
                DATE(waktu_scan) AS tanggal,
                MIN(waktu_scan) AS scan_pertama,
                MAX(waktu_scan) AS scan_terakhir
             FROM fp_scan_logs
             WHERE user_id IS NOT NULL
               AND DATE(waktu_scan) BETWEEN :tgl_mulai AND :tgl_akhir
             GROUP BY user_id, DATE(waktu_scan)"
        );
        $stmtScan->execute([
            'tgl_mulai' => $tanggalMulai,
            'tgl_akhir' => $tanggalAkhir,
        ]);

        $scanMap = [];
        foreach ($stmtScan->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $scanMap[$row['user_id']][$row['tanggal']] = $row;
        }

        // Bangun daftar tanggal dalam rentang
        $tanggalList = [];
        $cursor = new DateTime($tanggalMulai);
        $end = new DateTime($tanggalAkhir);
        while ($cursor <= $end) {
            $tanggalList[] = $cursor->format('Y-m-d');
            $cursor->modify('+1 day');
        }

        $rekap = [];
        foreach ($users as $user) {
            foreach ($tanggalList as $tanggal) {
                $scan = $scanMap[$user['id']][$tanggal] ?? null;

                $jamMasuk = null;
                $jamPulang = null;
                $status = 'alpa';

                if ($scan) {
                    $jamMasuk = date('H:i:s', strtotime($scan['scan_pertama']));
                    $jamPulang = date('H:i:s', strtotime($scan['scan_terakhir']));
                    $status = ($jamMasuk > $batasTerlambat) ? 'terlambat' : 'hadir';
                }

                $rekap[] = [
                    'user_id'      => (int) $user['id'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'nia'          => $user['nia'],
                    'kelas'        => $user['kelas'],
                    'tanggal'      => $tanggal,
                    'jam_masuk'    => $jamMasuk,
                    'jam_pulang'   => $jamPulang,
                    'status'       => $status,
                ];
            }
        }

        return $rekap;
    }

    /**
     * Simpan/update satu baris fp_rekap_harian (opsional dipakai oleh job terjadwal
     * agar rekap tersimpan permanen, bukan cuma dihitung on-the-fly saat halaman dibuka).
     */
    public function simpanRekapHarian(int $userId, string $tanggal, ?string $jamMasuk, ?string $jamPulang, string $status): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO fp_rekap_harian (user_id, tanggal, jam_masuk, jam_pulang, status)
             VALUES (?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                jam_masuk = VALUES(jam_masuk),
                jam_pulang = VALUES(jam_pulang),
                status = VALUES(status)'
        );
        $stmt->execute([$userId, $tanggal, $jamMasuk, $jamPulang, $status]);
    }

    // =====================================================================
    // HELPER LIST ANGGOTA (untuk halaman /admin/fingerprint)
    // =====================================================================

    /**
     * Daftar anggota aktif beserta status sinkronisasi ke mesin.
     */
    public function getAnggotaAktifDenganStatus(): array
    {
        $stmt = $this->db->query(
            "SELECT id, nia, nama_lengkap, kelas, fp_status, fp_synced_at, fp_last_error
             FROM users
             WHERE status = 'aktif'
             ORDER BY kelas, nama_lengkap"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserIdsBelumSyncAtauGagal(): array
    {
        $stmt = $this->db->query(
            "SELECT id FROM users
             WHERE status = 'aktif' AND fp_status IN ('belum_sync', 'gagal')"
        );
        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }

    private function onlyKeys(array $arr, array $optionalKeys): array
    {
        // Selalu sertakan tgl_mulai/tgl_akhir, plus optional keys jika ada di $arr
        $out = [];
        foreach ($optionalKeys as $k) {
            if (array_key_exists($k, $arr)) {
                $out[$k] = $arr[$k];
            }
        }
        return $out;
    }
}