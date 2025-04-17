<?php
$title = 'Crear Nueva Tarea';
ob_start();
?>

<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Crear Nueva Tarea</h1>
        <a href="/tasks" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver a la lista
        </a>
    </div>
    
    <form action="/tasks/store" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
            <input type="text" id="title" name="title" required 
                   class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                   placeholder="Título de la tarea">
        </div>
        
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea id="description" name="description" rows="4" 
                      class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                      placeholder="Descripción detallada de la tarea"></textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="/tasks" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                Guardar Tarea
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout/main.php';
?> 