<?php
// app/models/SettingModel.php

class SettingModel extends Model
{
    protected string $table = 'settings';

    private array $cache = [];

    public function get(string $key, string $default = ''): string
    {
        if (!isset($this->cache[$key])) {
            $row = $this->fetch("SELECT value FROM settings WHERE `key` = ?", [$key]);
            $this->cache[$key] = $row ? (string)$row['value'] : $default;
        }
        return $this->cache[$key];
    }

    public function getAll(): array
    {
        $rows   = $this->fetchAll("SELECT * FROM settings ORDER BY id");
        $result = [];
        foreach ($rows as $r) {
            $result[$r['key']] = $r;
        }
        return $result;
    }

    public function set(string $key, string $value): void
    {
        $this->execute(
            "INSERT INTO settings (`key`, value) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE value = VALUES(value)",
            [$key, $value]
        );
        $this->cache[$key] = $value;
    }

    public function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->set((string)$key, (string)$value);
        }
    }

    public function isPabOpen(): bool
    {
        return $this->get('pab_status') === '1';
    }
}
