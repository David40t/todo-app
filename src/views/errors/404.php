<?php
$title = 'Página no encontrada';
ob_start();
?>

<div class="flex flex-col items-center justify-center py-12">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-indigo-600">404</h1>
        <h2 class="text-4xl font-medium text-gray-800 mb-8">Página no encontrada</h2>
        <p class="text-lg text-gray-600 mb-8">Lo sentimos, la página que buscas no existe o ha sido movida.</p>
        
        <div class="flex flex-col md:flex-row justify-center gap-4">
            <a href="/" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                Ir a inicio
            </a>
            <a href="javascript:history.back()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">
                Volver atrás
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout/main.php';
?> 