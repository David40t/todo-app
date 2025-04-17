<?php
namespace App\Utils;

class Security {
    // Token CSRF
    private static ?string $token = null;
    
    // Generar token CSRF
    public static function generateCSRFToken(): string {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        self::$token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = self::$token;
        
        return self::$token;
    }
    
    // Validar token CSRF
    public static function validateCSRFToken(string $token): bool {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        
        return false;
    }
    
    // Limpiar datos de entrada
    public static function sanitizeInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitizeInput($value);
            }
            return $data;
        }
        
        // Eliminar espacios en blanco al principio y al final
        $data = trim($data);
        // Eliminar barras invertidas
        $data = stripslashes($data);
        // Convertir caracteres especiales en entidades HTML
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        
        return $data;
    }
    
    // Validar datos de entrada según tipo
    public static function validateInput(string $data, string $type): bool {
        switch ($type) {
            case 'email':
                return filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
            case 'int':
                return filter_var($data, FILTER_VALIDATE_INT) !== false;
            case 'float':
                return filter_var($data, FILTER_VALIDATE_FLOAT) !== false;
            case 'url':
                return filter_var($data, FILTER_VALIDATE_URL) !== false;
            default:
                return true;
        }
    }
    
    // Generar hash seguro para contraseñas
    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 1024, 'time_cost' => 2, 'threads' => 2]);
    }
    
    // Verificar contraseña
    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
} 