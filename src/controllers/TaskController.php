<?php
namespace App\Controllers;

// Incluir dependencias
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../utils/Security.php';

use App\Models\Task;
use App\Utils\Security;

class TaskController {
    private Task $task;
    
    public function __construct() {
        $this->task = new Task();
    }
    
    // Obtener todas las tareas del usuario actual
    public function index(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $result = $this->task->getAllByUser($_SESSION['user_id']);
        $tasks = [];
        
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $tasks[] = $row;
        }
        
        // Incluir la vista
        require_once __DIR__ . '/../views/tasks/index.php';
    }
    
    // Mostrar formulario para crear nueva tarea
    public function create(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        // Genera token CSRF
        $csrf_token = Security::generateCSRFToken();
        
        // Incluir la vista
        require_once __DIR__ . '/../views/tasks/create.php';
    }
    
    // Guardar nueva tarea
    public function store(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        // Verificar token CSRF
        if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Error de validación de formulario.';
            header('Location: /tasks/create');
            exit;
        }
        
        // Validar datos
        if (empty($_POST['title'])) {
            $_SESSION['error'] = 'El título es obligatorio.';
            header('Location: /tasks/create');
            exit;
        }
        
        // Configurar la tarea
        $this->task->title = $_POST['title'];
        $this->task->description = $_POST['description'] ?? '';
        $this->task->status = 'pendiente';
        $this->task->user_id = $_SESSION['user_id'];
        
        // Crear la tarea
        if ($this->task->create()) {
            $_SESSION['success'] = 'Tarea creada correctamente.';
            header('Location: /tasks');
        } else {
            $_SESSION['error'] = 'No se pudo crear la tarea.';
            header('Location: /tasks/create');
        }
        exit;
    }
    
    // Mostrar formulario para editar tarea
    public function edit(int $id): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $result = $this->task->getById($id, $_SESSION['user_id']);
        
        if ($result->rowCount() === 0) {
            $_SESSION['error'] = 'Tarea no encontrada.';
            header('Location: /tasks');
            exit;
        }
        
        $task = $result->fetch(\PDO::FETCH_ASSOC);
        
        // Genera token CSRF
        $csrf_token = Security::generateCSRFToken();
        
        // Incluir la vista
        require_once __DIR__ . '/../views/tasks/edit.php';
    }
    
    // Actualizar tarea
    public function update(int $id): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        // Verificar token CSRF
        if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Error de validación de formulario.';
            header('Location: /tasks');
            exit;
        }
        
        // Validar datos
        if (empty($_POST['title'])) {
            $_SESSION['error'] = 'El título es obligatorio.';
            header('Location: /tasks/edit/' . $id);
            exit;
        }
        
        // Verificar que la tarea pertenece al usuario
        $result = $this->task->getById($id, $_SESSION['user_id']);
        
        if ($result->rowCount() === 0) {
            $_SESSION['error'] = 'Tarea no encontrada.';
            header('Location: /tasks');
            exit;
        }
        
        // Configurar la tarea
        $this->task->id = $id;
        $this->task->title = $_POST['title'];
        $this->task->description = $_POST['description'] ?? '';
        $this->task->status = $_POST['status'] ?? 'pendiente';
        $this->task->user_id = $_SESSION['user_id'];
        
        // Actualizar la tarea
        if ($this->task->update()) {
            $_SESSION['success'] = 'Tarea actualizada correctamente.';
            header('Location: /tasks');
        } else {
            $_SESSION['error'] = 'No se pudo actualizar la tarea.';
            header('Location: /tasks/edit/' . $id);
        }
        exit;
    }
    
    // Eliminar tarea
    public function delete(int $id): void {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        // Verificar token CSRF
        if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Error de validación de formulario.';
            header('Location: /tasks');
            exit;
        }
        
        // Verificar que la tarea pertenece al usuario
        $result = $this->task->getById($id, $_SESSION['user_id']);
        
        if ($result->rowCount() === 0) {
            $_SESSION['error'] = 'Tarea no encontrada.';
            header('Location: /tasks');
            exit;
        }
        
        // Configurar la tarea
        $this->task->id = $id;
        $this->task->user_id = $_SESSION['user_id'];
        
        // Eliminar la tarea
        if ($this->task->delete()) {
            $_SESSION['success'] = 'Tarea eliminada correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar la tarea.';
        }
        
        header('Location: /tasks');
        exit;
    }
} 