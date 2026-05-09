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

            $seq = (int)$this->db->query(
                "SELECT last_seq FROM nia_sequence WHERE tahun = {$tahun} FOR UPDATE"
            )->fetchColumn();

            $this->db->commit();

            $padded = str_pad((string)($seq + 1), NIA_SEQ_DIGITS, '0', STR_PAD_LEFT);
            return $tahun . ORG_CODE . $padded;
        } catch (Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
