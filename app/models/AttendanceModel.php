<?php
// app/models/AttendanceModel.php

class AttendanceModel extends Model
{
    protected string $table = 'attendance_sessions';

    // ── Sesi ─────────────────────────────────────────────────────────────
    public function createSession(string $judul, string $tanggal, string $ket, int $adminId): int
    {
        $this->execute(
            "INSERT INTO attendance_sessions (judul, tanggal, keterangan, created_by)
             VALUES (?, ?, ?, ?)",
            [$judul, $tanggal, $ket, $adminId]
        );
        return (int)$this->lastId();
    }

    public function getAllSessions(): array
    {
        return $this->fetchAll(
            "SELECT s.*, u.nama_lengkap AS created_by_name
             FROM attendance_sessions s
             LEFT JOIN users u ON u.id = s.created_by
             ORDER BY s.tanggal DESC"
        );
    }

    public function getSession(int $id): array|false
    {
        return $this->fetch(
            "SELECT * FROM attendance_sessions WHERE id = ?", [$id]
        );
    }

    // ── Records ──────────────────────────────────────────────────────────
    public function getRecordsForPrint(int $sessionId, array $filter = []): array
    {
        $where  = ["u.role = 'anggota'", "u.status = 'aktif'"];
        $params = [$sessionId];

        if (!empty($filter['kelas'])) {
            $where[]  = "u.kelas = ?";
            $params[] = $filter['kelas'];
        }

        $whereSql = implode(' AND ', $where);

        return $this->fetchAll(
            "SELECT u.id, u.nia, u.nama_lengkap, u.kelas,
                    COALESCE(r.status, 'alpa') AS status,
                    r.keterangan
             FROM users u
             LEFT JOIN attendance_records r
               ON r.user_id = u.id AND r.session_id = ?
             WHERE {$whereSql}
             ORDER BY u.kelas, u.nia",
            $params
        );
    }

    public function upsertRecord(int $sessionId, int $userId, string $status, string $ket = ''): void
    {
        $this->execute(
            "INSERT INTO attendance_records (session_id, user_id, status, keterangan)
             VALUES (?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE status = VALUES(status), keterangan = VALUES(keterangan)",
            [$sessionId, $userId, $status, $ket]
        );
    }

    public function deleteSession(int $id): void
    {
        $this->execute("DELETE FROM attendance_sessions WHERE id = ?", [$id]);
    }
}
