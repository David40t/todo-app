<?php
namespace App\Controllers;

use App\Models\User;
use App\Utils\Security;

class AuthController {
    private User $user;
    
    public function __construct() {
        $this->user = new User();
    }
    
    // Mostrar formulario de registro
    public function showRegister(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Si ya está autenticado, redirigir a tareas
        if (isset($_SESSION['user_id'])) {
            header('Location: /tasks');
            exit;
        }
        
        // Genera token CSRF
        $csrf_token = Security::generateCSRFToken();
        
        // Incluir la vista
        require_once __DIR__ . '/../views/auth/register.php';
    }
    
    // Procesar registro
    public function register(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar token CSRF
        if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Error de validación de formulario.';
            header('Location: /register');
            exit;
        }
        
        // Validar datos
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: /register');
            exit;
        }
        
        // Validar formato de email
        if (!Security::validateInput($_POST['email'], 'email')) {
            $_SESSION['error'] = 'El formato de email no es válido.';
            header('Location: /register');
            exit;
        }
        
        // Validar longitud de contraseña
        if (strlen($_POST['password']) < 8) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 8 caracteres.';
            header('Location: /register');
            exit;
        }
        
        // Configurar el usuario
        $this->user->username = $_POST['username'];
        $this->user->email = $_POST['email'];
        $this->user->password = $_POST['password'];
        
        // Registrar el usuario
        if ($this->user->register()) {
            $_SESSION['success'] = 'Registro exitoso. Ahora puedes iniciar sesión.';
            header('Location: /login');
        } else {
            $_SESSION['error'] = 'El nombre de usuario o email ya está en uso.';
            header('Location: /register');
        }
        exit;
    }
    
    // Mostrar formulario de login
    public function showLogin(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Si ya está autenticado, redirigir a tareas
        if (isset($_SESSION['user_id'])) {
            header('Location: /tasks');
            exit;
        }
        
        // Genera token CSRF
        $csrf_token = Security::generateCSRFToken();
        
        // Incluir la vista
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
    // Procesar login
    public function login(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar token CSRF
        if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Error de validación de formulario.';
            header('Location: /login');
            exit;
        }
        
        // Validar datos
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: /login');
            exit;
        }
        
        // Configurar el usuario
        $this->user->email = $_POST['email'];
        $this->user->password = $_POST['password'];
        
        // Iniciar sesión
        if ($this->user->login()) {
            // Regenerar ID de sesión para prevenir session fixation
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['username'] = $this->user->username;
            
            header('Location: /tasks');
        } else {
            $_SESSION['error'] = 'Email o contraseña incorrectos.';
            header('Location: /login');
        }
        exit;
    }
    
    // Cerrar sesión
    public function logout(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar si el usuario está autenticado
        if (isset($_SESSION['user_id'])) {
            // Limpiar todas las variables de sesión
            $_SESSION = [];
            
            // Eliminar la cookie de sesión
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            
            // Destruir la sesión
            session_destroy();
        }
        
        header('Location: /login');
        exit;
    }
} 