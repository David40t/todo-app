<?php
namespace App\Config;

class Database {
    private string $host = '127.0.0.1';
    private string $db_name = 'todo_app';
    private string $username = 'root';
    private string $password = '';
    private ?\PDO $conn = null;

    public function connect(): ?\PDO {
        try {
            $this->conn = new \PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch(\PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
} 