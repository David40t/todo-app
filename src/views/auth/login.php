<?php
$title = 'Iniciar Sesión';
ob_start();
?>

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-center text-indigo-600 mb-6">Iniciar Sesión</h1>
    
    <form action="/login" method="POST" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
            <input type="email" id="email" name="email" required 
                   class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                   placeholder="tu@email.com" autocomplete="email">
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
            <input type="password" id="password" name="password" required 
                   class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                   placeholder="Tu contraseña" autocomplete="current-password">
        </div>
        
        <div>
            <button type="submit" 
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                Iniciar Sesión
            </button>
        </div>
    </form>
    
    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">
            ¿No tienes una cuenta? 
            <a href="/register" class="text-indigo-600 hover:underline">Registrarse</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout/main.php';
?> 