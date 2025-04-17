<?php
// Configuración de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

// Configuración de cabeceras de seguridad
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Cargar autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar rutas
$router = require_once __DIR__ . '/../src/routes/routes.php';

// Ejecutar el router
$router->run(); 