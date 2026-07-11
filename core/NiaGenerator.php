<?php
// core/NiaGenerator.php

class NiaGenerator
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Generate NIA unik dengan format [TahunDaftar][KodeOrg][NomorUrut3digit]
     * Contoh: 202624001
     *
     * (TIDAK DIUBAH dari versi asli — logic & perilaku persis sama)
     */
    public function generate(int $tahun): string
    {
        $this->db->beginTransaction();
        try {
            // Upsert & lock row sequence untuk tahun ini
            $this->db->prepare(
                "INSERT INTO nia_sequence (tahun, last_seq)
                 VALUES (?, 0)
                 ON DUPLICATE KEY UPDATE last_seq = last_seq + 1"
            )->execute([$tahun]);

            $stmt = $this->db->prepare(
                "SELECT last_seq FROM nia_sequence WHERE tahun = ? FOR UPDATE"
            );
            $stmt->execute([$tahun]);
            $seq = (int)$stmt->fetchColumn();

            $this->db->commit();

            $padded = str_pad((string)($seq + 1), NIA_SEQ_DIGITS, '0', STR_PAD_LEFT);
            return $tahun . ORG_CODE . $padded;
        } catch (Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // ================================================================
    //  RESET / SINKRONISASI SEQUENCE
    // ================================================================

    /**
     * Cari urut NIA tertinggi yang BENAR-BENAR masih dipakai di tabel users
     * untuk tahun tertentu (bukan dari nia_sequence, tapi dari data nyata).
     * Dipakai supaya sequence bisa "mundur" lagi kalau anggota terakhir
     * sudah dihapus.
     */
    private function maxUrutReal(int $tahun): int
    {
        $prefix = $tahun . ORG_CODE;
        $stmt = $this->db->prepare(
            "SELECT MAX(CAST(RIGHT(nia, ?) AS UNSIGNED))
             FROM users
             WHERE nia LIKE CONCAT(?, '%')"
        );
        $stmt->execute([NIA_SEQ_DIGITS, $prefix]);
        return (int)($stmt->fetchColumn() ?? 0);
    }

    /**
     * Ambil daftar semua tahun yang punya row di nia_sequence ATAU
     * punya anggota ber-NIA, lengkap dengan info urut berikutnya &
     * urut tertinggi yang benar-benar masih ada.
     *
     * Dipakai untuk menampilkan panel "Reset NIA" di admin.
     */
    public function getAllSequenceInfo(): array
    {
        $rows = $this->db->query(
            "SELECT tahun, last_seq FROM nia_sequence ORDER BY tahun DESC"
        )->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $r) {
            $tahun = (int)$r['tahun'];
            $result[$tahun] = [
                'tahun'         => $tahun,
                'last_seq'      => (int)$r['last_seq'],
                // lihat catatan formula di resetManual()
                'next_urut'     => (int)$r['last_seq'] + 2,
                'max_urut_real' => $this->maxUrutReal($tahun),
            ];
        }

        // Tahun yang punya anggota ber-NIA tapi row nia_sequence-nya
        // belum/tidak ada (misal baru habis di-reset total)
        $tahunUsers = $this->db->query(
            "SELECT DISTINCT LEFT(nia, 4) AS tahun FROM users WHERE nia IS NOT NULL"
        )->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tahunUsers as $ty) {
            $ty = (int)$ty;
            if (!isset($result[$ty])) {
                $result[$ty] = [
                    'tahun'         => $ty,
                    'last_seq'      => null,
                    'next_urut'     => 1,
                    'max_urut_real' => $this->maxUrutReal($ty),
                ];
            }
        }

        krsort($result);
        return array_values($result);
    }

    /**
     * Set urut NIA berikutnya secara manual.
     *
     * PENTING soal formula: generate() nge-increment last_seq DULU baru
     * +1 lagi untuk angka yang dipakai. Jadi kalau kamu mau NIA
     * berikutnya = urut #$nextUrut, maka last_seq yang harus disimpan
     * adalah ($nextUrut - 2).
     *
     * Kalau $nextUrut <= 1 (mau mulai dari 001 lagi), row di
     * nia_sequence untuk tahun itu dihapus total — supaya generate()
     * jalan lewat path INSERT (last_seq=0) dan hasil pertama = 001.
     *
     * Hati-hati: kalau kamu set nextUrut lebih kecil/sama dengan urut
     * yang masih dipakai anggota aktif, NIA baru bisa nabrak (duplicate).
     */
    public function resetManual(int $tahun, int $nextUrut): void
    {
        $nextUrut = max(1, $nextUrut);

        if ($nextUrut <= 1) {
            $this->db->prepare(
                "DELETE FROM nia_sequence WHERE tahun = ?"
            )->execute([$tahun]);
            return;
        }

        $lastSeq = $nextUrut - 2;
        $this->db->prepare(
            "INSERT INTO nia_sequence (tahun, last_seq) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE last_seq = VALUES(last_seq)"
        )->execute([$tahun, $lastSeq]);
    }

    /**
     * Selaraskan otomatis: cari urut tertinggi yang benar-benar masih
     * dipakai anggota aktif tahun ini, lalu set NIA berikutnya = urut
     * tertinggi itu + 1. Kalau tidak ada anggota sama sekali tahun itu,
     * otomatis balik ke 001.
     *
     * Return: urut berikutnya setelah disinkronkan (buat pesan flash).
     */
    public function resetToActual(int $tahun): int
    {
        $max      = $this->maxUrutReal($tahun);
        $nextUrut = $max + 1;
        $this->resetManual($tahun, $nextUrut);
        return $nextUrut;
    }
}