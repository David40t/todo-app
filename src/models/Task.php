<?php
namespace App\Models;

use App\Config\Database;
use App\Utils\Security;

class Task {
    private ?\PDO $conn;
    private string $table = 'tasks';
    
    // Propiedades de la tarea
    public ?int $id = null;
    public string $title = '';
    public ?string $description = null;
    public string $status = 'pendiente';
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?int $user_id = null;
    
    // Constructor
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    // Obtener todas las tareas de un usuario
    public function getAllByUser(int $userId): \PDOStatement {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt;
    }
    
    // Obtener una tarea específica
    public function getById(int $id, int $userId): \PDOStatement {
        $query = "SELECT * FROM {$this->table} WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt;
    }
    
    // Crear una nueva tarea
    public function create(): bool {
        $query = "INSERT INTO {$this->table} (title, description, status, user_id, created_at) 
                  VALUES (:title, :description, :status, :user_id, NOW())";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitiza los datos
        $this->title = Security::sanitizeInput($this->title);
        $this->description = Security::sanitizeInput($this->description);
        $this->status = Security::sanitizeInput($this->status);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, \PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, \PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $this->user_id, \PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Actualizar una tarea
    public function update(): bool {
        $query = "UPDATE {$this->table} 
                  SET title = :title, description = :description, status = :status, updated_at = NOW() 
                  WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitiza los datos
        $this->title = Security::sanitizeInput($this->title);
        $this->description = Security::sanitizeInput($this->description);
        $this->status = Security::sanitizeInput($this->status);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, \PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->user_id, \PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Eliminar una tarea
    public function delete(): bool {
        $query = "DELETE FROM {$this->table} WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        
        // Vincula parámetros de forma segura
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->user_id, \PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
} 