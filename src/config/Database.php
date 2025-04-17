<?php
namespace App\Config;

class Database {
    private string $host;
    private string $db_name;
    private string $username;
    private string $password;
    private ?\PDO $conn = null;
    
    public function __construct() {
        $this->host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $this->db_name = $_ENV['DB_NAME'] ?? 'todo_app';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? '';
    }

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
            // En producción, no mostrar el mensaje de error directamente
            if ($_ENV['APP_ENV'] === 'development' && $_ENV['APP_DEBUG'] === 'true') {
                echo "Error de conexión: " . $e->getMessage();
            } else {
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                echo "Error de conexión a la base de datos. Por favor, contacte al administrador.";
            }
        }

        return $this->conn;
    }
} 