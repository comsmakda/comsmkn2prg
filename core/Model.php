<?php
// core/Model.php

class Model
{
    protected PDO    $db;
    protected string $table = '';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    protected function fetch(string $sql, array $params = []): array|false
    {
        return $this->query($sql, $params)->fetch();
    }

    protected function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    protected function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    protected function lastId(): string
    {
        return $this->db->lastInsertId();
    }

    // Generic find by id
    public function find(int $id): array|false
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    // Generic findAll
    public function all(string $orderBy = 'id DESC'): array
    {
        return $this->fetchAll("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
    }
}
