<?php
namespace App\Models;

use App\Config\Database;
use App\Utils\Security;

class User {
    private ?\PDO $conn;
    private string $table = 'users';
    
    // Propiedades del usuario
    public ?int $id = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $created_at = null;
    
    // Constructor
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    // Registrar usuario
    public function register(): bool {
        // Verificar si el usuario ya existe
        if ($this->emailExists() || $this->usernameExists()) {
            return false;
        }
        
        $query = "INSERT INTO {$this->table} (username, email, password, created_at) 
                  VALUES (:username, :email, :password, NOW())";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitiza los datos
        $this->username = Security::sanitizeInput($this->username);
        $this->email = Security::sanitizeInput($this->email);
        
        // Hash de la contraseña
        $hashedPassword = Security::hashPassword($this->password);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':username', $this->username, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Iniciar sesión
    public function login(): bool {
        $query = "SELECT id, username, email, password FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        
        // Sanitiza los datos
        $this->email = Security::sanitizeInput($this->email);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':email', $this->email, \PDO::PARAM_STR);
        
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (Security::verifyPassword($this->password, $row['password'])) {
                // Verifica la contraseña
                $this->id = $row['id'];
                $this->username = $row['username'];
                return true;
            }
        }
        
        return false;
    }
    
    // Verificar si el email existe
    private function emailExists(): bool {
        $query = "SELECT id FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        
        // Sanitiza los datos
        $this->email = Security::sanitizeInput($this->email);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':email', $this->email, \PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    // Verificar si el nombre de usuario existe
    private function usernameExists(): bool {
        $query = "SELECT id FROM {$this->table} WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        
        // Sanitiza los datos
        $this->username = Security::sanitizeInput($this->username);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':username', $this->username, \PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    // Obtener usuario por ID
    public function getById(int $id): \PDOStatement {
        $query = "SELECT id, username, email, created_at FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt;
    }
} 