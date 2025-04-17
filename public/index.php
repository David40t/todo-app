<?php
// Cargar autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configuración de errores según el entorno
if ($_ENV['APP_ENV'] === 'development' && $_ENV['APP_DEBUG'] === 'true') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Configuración de cookies según variables de entorno
session_set_cookie_params([
    'secure' => filter_var($_ENV['SESSION_SECURE'], FILTER_VALIDATE_BOOLEAN),
    'httponly' => filter_var($_ENV['SESSION_HTTP_ONLY'], FILTER_VALIDATE_BOOLEAN),
    'samesite' => 'Lax'
]);

// Iniciar sesión
session_start();

// Configuración de cabeceras de seguridad
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Cargar rutas
$router = require_once __DIR__ . '/../src/routes/routes.php';

// Ejecutar el router
$router->run(); 