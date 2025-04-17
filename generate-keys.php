<?php
/**
 * Este script genera claves aleatorias seguras para la aplicación.
 * Ejecuta: php generate-keys.php
 */

// Generar APP_KEY (para encriptación general)
$appKey = 'base64:' . base64_encode(random_bytes(32));

// Generar JWT_SECRET (para tokens JWT)
$jwtSecret = bin2hex(random_bytes(32));

echo "===================================================\n";
echo "Claves seguras generadas para el archivo .env\n";
echo "===================================================\n\n";
echo "APP_KEY={$appKey}\n";
echo "JWT_SECRET={$jwtSecret}\n\n";
echo "Por favor, copia estas claves en tu archivo .env\n";
echo "===================================================\n"; 