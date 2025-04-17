<?php
// Función de autoloading manual
spl_autoload_register(function($class) {
    // Namespace base de la aplicación
    $prefix = 'App\\';
    
    // Directorio base para las clases
    $base_dir = __DIR__ . '/';
    
    // Verificar si la clase utiliza el namespace predefinido
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Si la clase no utiliza el namespace, dejar que otros autoloaders se encarguen
        return;
    }
    
    // Obtener el nombre relativo de la clase
    $relative_class = substr($class, $len);
    
    // Reemplazar el namespace separador con directorio separador
    // Añadir .php al final
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // Si el archivo existe, cargarlo
    if (file_exists($file)) {
        require $file;
    }
}); 