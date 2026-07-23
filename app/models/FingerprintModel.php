<?php

/**
 * FingerprintModel
 *
 * Menjembatani aplikasi PHP dengan Sync Agent (Python/FastAPI/pyzk) yang
 * berkomunikasi langsung dengan mesin fingerprint GEISA X107 (protokol ZKTeco).
 *
 * Semua komunikasi HTTP memakai cURL native (tanpa library eksternal),
 * konfigurasi (URL agent, API key, dsb) diambil dari SettingModel — bukan hardcode.
 *
 * CATATAN PENTING (fitur rekap permanen):
 * Tabel fp_rekap_harian dipakai sebagai "arsip" yang independen dari tabel users.
 * Setiap baris menyimpan nia/nama_lengkap/kelas secara denormalized (bukan cuma
 * user_id) supaya data rekap TETAP ADA walau anggotanya sudah dihapus dari users.
 * Baris dengan sumber='manual' (izin/sakit/hadir yang diedit admin) SELALU
 * menang dibanding hasil hitung otomatis dari fp_scan_logs.
 */
class FingerprintModel
{
    private PDO $db;
    private SettingModel $settingModel;
    private JadwalPertemuanModel $jadwalModel;

    /** @var int Timeout koneksi ke Sync Agent (detik) */
    private const HTTP_TIMEOUT = 10;

    /** Status yang boleh diinput manual oleh admin lewat tombol Edit */
    public const STATUS_MANUAL_ALLOWED = ['hadir', 'terlambat', 'izin', 'sakit', 'alpa'];

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->settingModel = new SettingModel();
        $this->jadwalModel = new JadwalPertemuanModel();
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

    /**
     * Tanggal mulai efektif absensi (fp_tanggal_mulai_absensi).
     * Sebelum tanggal ini (atau kalau belum pernah diisi di halaman Setting),
     * sistem TIDAK BOLEH menghasilkan status 'alpa' — walaupun tanggalnya
     * cocok hari jadwal pertemuan.
     *
     * @return string|null null artinya belum diatur -> anggap "belum mulai"
     *                      untuk SEMUA tanggal (tidak pernah ada alpa).
     */
    private function getTanggalMulaiAbsensi(): ?string
    {
        $val = trim((string) $this->settingModel->get('fp_tanggal_mulai_absensi'));

        if ($val === '') {
            return null;
        }

        $d = DateTime::createFromFormat('Y-m-d', $val);
        if (!$d || $d->format('Y-m-d') !== $val) {
            return null;
        }

        return $val;
    }

    private function isSudahMelewatiTanggalMulai(string $tanggal, ?string $tanggalMulaiAbsensi): bool
    {
        if ($tanggalMulaiAbsensi === null) {
            return false;
        }
        return $tanggal >= $tanggalMulaiAbsensi;
    }

    // =====================================================================
    // HTTP CLIENT KE SYNC AGENT
    // =====================================================================

    /**
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

    public function pushUser(int $userId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT id, nia, nama_lengkap, role, status FROM users WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if ($user['role'] !== 'anggota') {
            $this->updateFpStatus($userId, 'gagal', 'Hanya akun anggota yang bisa didaftarkan ke mesin fingerprint.');
            return false;
        }

        if ($user['status'] !== 'aktif') {
            $this->updateFpStatus($userId, 'gagal', 'Anggota tidak berstatus aktif.');
            return false;
        }

        if (empty($user['nia'])) {
            $this->updateFpStatus($userId, 'gagal', 'Anggota belum memiliki NIA.');
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
    // REKAP HARIAN (dengan override manual + arsip anggota terhapus)
    // =====================================================================

    /**
     * Rekap presensi harian untuk rentang tanggal tertentu.
     *
     * Prioritas per (nia, tanggal):
     * 1. Kalau ada baris tersimpan di fp_rekap_harian (manual ATAU arsip otomatis)
     *    -> pakai itu apa adanya (jam_masuk, jam_pulang, status, keterangan).
     * 2. Kalau tidak, dan tanggal itu bukan hari pertemuan -> 'libur'.
     * 3. Kalau hari pertemuan tapi sebelum tanggal mulai efektif absensi & tidak
     *    ada scan -> 'belum_mulai'.
     * 4. Kalau hari pertemuan, sudah lewat tanggal mulai efektif, tidak ada scan
     *    -> 'alpa'.
     * 5. Ada scan -> 'hadir' / 'terlambat'.
     *
     * Anggota yang SUDAH DIHAPUS dari tabel users tetap muncul di rekap ini kalau
     * mereka punya baris arsip di fp_rekap_harian dalam rentang tanggal yang diminta
     * (ditandai is_arsip = true, tidak bisa diedit lagi lewat sini).
     *
     * @param array{kelas?:string} $filter
     */
    public function getRekapHarian(string $tanggalMulai, string $tanggalAkhir, array $filter = []): array
    {
        $batasTerlambat = $this->getBatasTerlambat();
        $tanggalMulaiAbsensi = $this->getTanggalMulaiAbsensi();
        $kelasFilter = $filter['kelas'] ?? '';

        // 1) Anggota AKTIF saat ini
        $kelasSql = '';
        $paramsUsers = [];
        if ($kelasFilter !== '') {
            $kelasSql = ' AND u.kelas = :kelas';
            $paramsUsers['kelas'] = $kelasFilter;
        }
        $stmtUsers = $this->db->prepare(
            "SELECT id, nia, nama_lengkap, kelas
             FROM users u
             WHERE role = 'anggota' AND status = 'aktif' {$kelasSql}
             ORDER BY kelas, nama_lengkap"
        );
        $stmtUsers->execute($paramsUsers);
        $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

        $niaAktifSet = array_flip(array_column($users, 'nia'));

        // 2) Scan logs dalam rentang (untuk anggota aktif)
        $scanMap = [];
        if (!empty($users)) {
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
            foreach ($stmtScan->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $scanMap[$row['user_id']][$row['tanggal']] = $row;
            }
        }

        // 3) Baris tersimpan (manual + arsip) dalam rentang tanggal, keyed by nia+tanggal
        $persistedSql = "SELECT nia, nama_lengkap, kelas, tanggal, jam_masuk, jam_pulang, status, keterangan, sumber
                          FROM fp_rekap_harian
                          WHERE tanggal BETWEEN :tgl_mulai AND :tgl_akhir";
        $paramsPersisted = ['tgl_mulai' => $tanggalMulai, 'tgl_akhir' => $tanggalAkhir];
        if ($kelasFilter !== '') {
            $persistedSql .= ' AND kelas = :kelas';
            $paramsPersisted['kelas'] = $kelasFilter;
        }
        $stmtPersisted = $this->db->prepare($persistedSql);
        $stmtPersisted->execute($paramsPersisted);

        $persistedMap = [];
        foreach ($stmtPersisted->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $persistedMap[$row['nia']][$row['tanggal']] = $row;
        }

        // 4) Daftar tanggal dalam rentang + precompute hari pertemuan
        $tanggalList = [];
        $cursor = new DateTime($tanggalMulai);
        $end = new DateTime($tanggalAkhir);
        while ($cursor <= $end) {
            $tanggalList[] = $cursor->format('Y-m-d');
            $cursor->modify('+1 day');
        }

        $isPertemuanMap = [];
        foreach ($tanggalList as $tgl) {
            $isPertemuanMap[$tgl] = $this->jadwalModel->isHariPertemuan($tgl);
        }

        $rekap = [];

        // 5) Anggota AKTIF
        foreach ($users as $user) {
            foreach ($tanggalList as $tanggal) {

                $persisted = $persistedMap[$user['nia']][$tanggal] ?? null;

                if ($persisted) {
                    $rekap[] = [
                        'user_id'      => (int) $user['id'],
                        'nama_lengkap' => $persisted['nama_lengkap'],
                        'nia'          => $user['nia'],
                        'kelas'        => $persisted['kelas'],
                        'tanggal'      => $tanggal,
                        'jam_masuk'    => $persisted['jam_masuk'] ? substr($persisted['jam_masuk'], 0, 5) : null,
                        'jam_pulang'   => $persisted['jam_pulang'] ? substr($persisted['jam_pulang'], 0, 5) : null,
                        'status'       => $persisted['status'],
                        'keterangan'   => $persisted['keterangan'],
                        'sumber'       => $persisted['sumber'],
                        'is_arsip'     => false,
                    ];
                    continue;
                }

                if (!$isPertemuanMap[$tanggal]) {
                    $rekap[] = [
                        'user_id'      => (int) $user['id'],
                        'nama_lengkap' => $user['nama_lengkap'],
                        'nia'          => $user['nia'],
                        'kelas'        => $user['kelas'],
                        'tanggal'      => $tanggal,
                        'jam_masuk'    => null,
                        'jam_pulang'   => null,
                        'status'       => 'libur',
                        'keterangan'   => null,
                        'sumber'       => 'otomatis',
                        'is_arsip'     => false,
                    ];
                    continue;
                }

                $scan = $scanMap[$user['id']][$tanggal] ?? null;
                $jamMasuk = null;
                $jamPulang = null;

                if ($scan) {
                    $jamMasuk = date('H:i', strtotime($scan['scan_pertama']));
                    $jamPulang = date('H:i', strtotime($scan['scan_terakhir']));
                    $status = ($jamMasuk . ':00' > $batasTerlambat) ? 'terlambat' : 'hadir';
                } elseif (!$this->isSudahMelewatiTanggalMulai($tanggal, $tanggalMulaiAbsensi)) {
                    $status = 'belum_mulai';
                } else {
                    $status = 'alpa';
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
                    'keterangan'   => null,
                    'sumber'       => 'otomatis',
                    'is_arsip'     => false,
                ];
            }
        }

        // 6) Anggota yang SUDAH DIHAPUS dari users tapi punya arsip di fp_rekap_harian
        foreach ($persistedMap as $nia => $tanggalRows) {
            if (isset($niaAktifSet[$nia])) {
                continue; // masih anggota aktif, sudah ditangani di atas
            }
            foreach ($tanggalRows as $tanggal => $row) {
                $rekap[] = [
                    'user_id'      => null,
                    'nama_lengkap' => $row['nama_lengkap'],
                    'nia'          => $nia,
                    'kelas'        => $row['kelas'],
                    'tanggal'      => $tanggal,
                    'jam_masuk'    => $row['jam_masuk'] ? substr($row['jam_masuk'], 0, 5) : null,
                    'jam_pulang'   => $row['jam_pulang'] ? substr($row['jam_pulang'], 0, 5) : null,
                    'status'       => $row['status'],
                    'keterangan'   => $row['keterangan'],
                    'sumber'       => $row['sumber'],
                    'is_arsip'     => true,
                ];
            }
        }

        // Urutkan supaya rapi: kelas -> nama -> tanggal
        usort($rekap, function ($a, $b) {
            return [$a['kelas'], $a['nama_lengkap'], $a['tanggal']]
                <=> [$b['kelas'], $b['nama_lengkap'], $b['tanggal']];
        });

        return $rekap;
    }

    /**
     * Riwayat absensi milik SATU anggota (dipakai halaman member/absensi).
     * Ikut menghormati baris manual di fp_rekap_harian.
     */
    public function getRiwayatAbsensiAnggota(int $userId, string $tanggalMulai, string $tanggalAkhir): array
    {
        $stmtUser = $this->db->prepare('SELECT nia FROM users WHERE id = ? LIMIT 1');
        $stmtUser->execute([$userId]);
        $nia = $stmtUser->fetchColumn();
        if ($nia === false) {
            return [];
        }

        $batasTerlambat = $this->getBatasTerlambat();
        $tanggalMulaiAbsensi = $this->getTanggalMulaiAbsensi();

        $stmtScan = $this->db->prepare(
            "SELECT
                DATE(waktu_scan) AS tanggal,
                MIN(waktu_scan) AS scan_pertama,
                MAX(waktu_scan) AS scan_terakhir
             FROM fp_scan_logs
             WHERE user_id = :user_id
               AND DATE(waktu_scan) BETWEEN :tgl_mulai AND :tgl_akhir
             GROUP BY DATE(waktu_scan)"
        );
        $stmtScan->execute([
            'user_id'   => $userId,
            'tgl_mulai' => $tanggalMulai,
            'tgl_akhir' => $tanggalAkhir,
        ]);

        $scanMap = [];
        foreach ($stmtScan->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $scanMap[$row['tanggal']] = $row;
        }

        $stmtPersisted = $this->db->prepare(
            "SELECT tanggal, jam_masuk, jam_pulang, status, keterangan, sumber
             FROM fp_rekap_harian
             WHERE nia = :nia AND tanggal BETWEEN :tgl_mulai AND :tgl_akhir"
        );
        $stmtPersisted->execute([
            'nia'       => $nia,
            'tgl_mulai' => $tanggalMulai,
            'tgl_akhir' => $tanggalAkhir,
        ]);
        $persistedMap = [];
        foreach ($stmtPersisted->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $persistedMap[$row['tanggal']] = $row;
        }

        $tanggalList = [];
        $cursor = new DateTime($tanggalMulai);
        $end    = new DateTime($tanggalAkhir);
        while ($cursor <= $end) {
            $tanggalList[] = $cursor->format('Y-m-d');
            $cursor->modify('+1 day');
        }

        $rekap = [];
        foreach ($tanggalList as $tanggal) {

            $persisted = $persistedMap[$tanggal] ?? null;
            if ($persisted) {
                $rekap[] = [
                    'tanggal'    => $tanggal,
                    'jam_masuk'  => $persisted['jam_masuk'] ? substr($persisted['jam_masuk'], 0, 5) : null,
                    'jam_pulang' => $persisted['jam_pulang'] ? substr($persisted['jam_pulang'], 0, 5) : null,
                    'status'     => $persisted['status'],
                    'keterangan' => $persisted['keterangan'],
                ];
                continue;
            }

            if (!$this->jadwalModel->isHariPertemuan($tanggal)) {
                $rekap[] = [
                    'tanggal'    => $tanggal,
                    'jam_masuk'  => null,
                    'jam_pulang' => null,
                    'status'     => 'libur',
                    'keterangan' => null,
                ];
                continue;
            }

            $scan = $scanMap[$tanggal] ?? null;
            $jamMasuk  = null;
            $jamPulang = null;

            if ($scan) {
                $jamMasuk  = date('H:i:s', strtotime($scan['scan_pertama']));
                $jamPulang = date('H:i:s', strtotime($scan['scan_terakhir']));
                $status    = ($jamMasuk > $batasTerlambat) ? 'terlambat' : 'hadir';
            } elseif (!$this->isSudahMelewatiTanggalMulai($tanggal, $tanggalMulaiAbsensi)) {
                $status = 'belum_mulai';
            } else {
                $status = 'alpa';
            }

            $rekap[] = [
                'tanggal'    => $tanggal,
                'jam_masuk'  => $jamMasuk,
                'jam_pulang' => $jamPulang,
                'status'     => $status,
                'keterangan' => null,
            ];
        }

        return array_reverse($rekap);
    }

    // =====================================================================
    // EDIT MANUAL (izin / sakit / hadir manual) — dipakai tombol "Edit" di rekap
    // =====================================================================

    /**
     * Simpan/timpa satu baris rekap secara manual untuk SATU anggota AKTIF.
     * Dipakai untuk kasus: siswa izin/sakit, atau lupa absen tapi sebenarnya hadir.
     */
    public function setManualEntry(
        int $userId,
        string $tanggal,
        string $status,
        ?string $jamMasuk,
        ?string $jamPulang,
        ?string $keterangan
    ): bool {
        if (!in_array($status, self::STATUS_MANUAL_ALLOWED, true)) {
            return false;
        }

        $d = DateTime::createFromFormat('Y-m-d', $tanggal);
        if (!$d || $d->format('Y-m-d') !== $tanggal) {
            return false;
        }

        $stmt = $this->db->prepare('SELECT nia, nama_lengkap, kelas FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return false;
        }

        // Jam masuk/pulang cuma relevan kalau statusnya hadir/terlambat
        if (!in_array($status, ['hadir', 'terlambat'], true)) {
            $jamMasuk = null;
            $jamPulang = null;
        }

        $this->upsertRekap(
            $user['nia'],
            $user['nama_lengkap'],
            $user['kelas'],
            $tanggal,
            $jamMasuk,
            $jamPulang,
            $status,
            $keterangan,
            'manual'
        );

        return true;
    }

    /**
     * Batalkan override manual pada satu tanggal (kembalikan ke hitungan otomatis).
     */
    public function hapusManualEntry(int $userId, string $tanggal): bool
    {
        $stmt = $this->db->prepare('SELECT nia FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $nia = $stmt->fetchColumn();
        if ($nia === false) {
            return false;
        }

        $del = $this->db->prepare(
            "DELETE FROM fp_rekap_harian WHERE nia = ? AND tanggal = ? AND sumber = 'manual'"
        );
        $del->execute([$nia, $tanggal]);

        return $del->rowCount() > 0;
    }

    /**
     * Ambil satu baris manual (untuk mengisi form edit dengan data sebelumnya).
     */
    public function getManualEntry(int $userId, string $tanggal): ?array
    {
        $stmt = $this->db->prepare('SELECT nia FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $nia = $stmt->fetchColumn();
        if ($nia === false) {
            return null;
        }

        $stmt = $this->db->prepare(
            "SELECT tanggal, jam_masuk, jam_pulang, status, keterangan, sumber
             FROM fp_rekap_harian WHERE nia = ? AND tanggal = ? LIMIT 1"
        );
        $stmt->execute([$nia, $tanggal]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    private function upsertRekap(
        string $nia,
        string $namaLengkap,
        ?string $kelas,
        string $tanggal,
        ?string $jamMasuk,
        ?string $jamPulang,
        string $status,
        ?string $keterangan,
        string $sumber
    ): void {
        $stmt = $this->db->prepare(
            'INSERT INTO fp_rekap_harian (nia, nama_lengkap, kelas, tanggal, jam_masuk, jam_pulang, status, keterangan, sumber)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                nama_lengkap = VALUES(nama_lengkap),
                kelas        = VALUES(kelas),
                jam_masuk    = VALUES(jam_masuk),
                jam_pulang   = VALUES(jam_pulang),
                status       = VALUES(status),
                keterangan   = VALUES(keterangan),
                sumber       = VALUES(sumber)'
        );
        $stmt->execute([$nia, $namaLengkap, $kelas, $tanggal, $jamMasuk, $jamPulang, $status, $keterangan, $sumber]);
    }

    private function getPersistedEntry(string $nia, string $tanggal): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM fp_rekap_harian WHERE nia = ? AND tanggal = ? LIMIT 1');
        $stmt->execute([$nia, $tanggal]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    // =====================================================================
    // ARSIP SEBELUM HAPUS ANGGOTA — WAJIB DIPANGGIL SEBELUM DELETE users
    // =====================================================================

    /**
     * Bekukan seluruh riwayat kehadiran seorang anggota ke fp_rekap_harian
     * SEBELUM baris users-nya benar-benar dihapus, supaya rekap untuk LPJ
     * tetap tersedia selamanya walau akunnya sudah tidak ada.
     *
     * PENTING: panggil method ini di controller/model yang menghapus anggota,
     * TEPAT SEBELUM query DELETE FROM users dijalankan. Baris dengan sumber
     * 'manual' yang sudah ada (izin/sakit yang pernah diinput admin) tidak
     * akan ditimpa.
     */
    public function arsipkanSebelumHapus(int $userId): void
    {
        $stmt = $this->db->prepare('SELECT nia, nama_lengkap, kelas FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return;
        }

        $tanggalMulai = $this->getTanggalMulaiAbsensi();
        if ($tanggalMulai === null) {
            $stmtMin = $this->db->prepare(
                'SELECT MIN(DATE(waktu_scan)) FROM fp_scan_logs WHERE user_id = ?'
            );
            $stmtMin->execute([$userId]);
            $tanggalMulai = $stmtMin->fetchColumn() ?: null;
        }

        if (!$tanggalMulai) {
            // Tidak ada riwayat sama sekali (siswa belum pernah absen) -> tidak perlu diarsipkan
            return;
        }

        $tanggalAkhir = date('Y-m-d');
        if ($tanggalMulai > $tanggalAkhir) {
            return;
        }

        $riwayat = $this->getRiwayatAbsensiAnggota($userId, $tanggalMulai, $tanggalAkhir);

        foreach ($riwayat as $r) {
            // Cukup arsipkan hari-hari yang benar-benar berarti untuk LPJ.
            // 'libur' dan 'belum_mulai' tidak perlu disimpan permanen.
            if (!in_array($r['status'], ['hadir', 'terlambat', 'alpa', 'izin', 'sakit'], true)) {
                continue;
            }

            $existing = $this->getPersistedEntry($user['nia'], $r['tanggal']);
            if ($existing && $existing['sumber'] === 'manual') {
                continue; // jangan timpa yang sudah diedit manual sebelumnya
            }

            $jamMasuk = $r['jam_masuk'] ? substr($r['jam_masuk'], 0, 5) : null;
            $jamPulang = $r['jam_pulang'] ? substr($r['jam_pulang'], 0, 5) : null;

            $this->upsertRekap(
                $user['nia'],
                $user['nama_lengkap'],
                $user['kelas'],
                $r['tanggal'],
                $jamMasuk,
                $jamPulang,
                $r['status'],
                $r['keterangan'] ?? null,
                'otomatis'
            );
        }
    }

    // =====================================================================
    // HELPER LIST ANGGOTA (untuk halaman /admin/fingerprint)
    // =====================================================================

    public function getAnggotaAktifDenganStatus(): array
    {
        $stmt = $this->db->query(
            "SELECT id, nia, nama_lengkap, kelas, fp_status, fp_synced_at, fp_last_error
             FROM users
             WHERE role = 'anggota' AND status = 'aktif'
             ORDER BY kelas, nama_lengkap"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserIdsBelumSyncAtauGagal(): array
    {
        $stmt = $this->db->query(
            "SELECT id FROM users
             WHERE role = 'anggota' AND status = 'aktif' AND fp_status IN ('belum_sync', 'gagal')"
        );
        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }
}