<?php

$title = 'Mis Tareas';
ob_start();
?>

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Mis Tareas</h1>
    <a href="/tasks/create" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Nueva Tarea
    </a>
</div>

<?php if (empty($tasks)): ?>
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <h2 class="text-xl text-gray-600 mb-2">No tienes tareas pendientes</h2>
        <p class="text-gray-500 mb-4">¡Comienza creando tu primera tarea!</p>
        <a href="/tasks/create" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Crear Tarea
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($tasks as $task): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h2 class="text-xl font-semibold text-gray-800 break-words"><?= htmlspecialchars($task['title']) ?></h2>
                        <span class="<?= $task['status'] === 'completada' ? 'bg-green-100 text-green-800' : ($task['status'] === 'en_progreso' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') ?> px-2 py-1 text-xs font-semibold rounded-full">
                            <?= ucfirst(str_replace('_', ' ', $task['status'])) ?>
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4 break-words">
                        <?= empty($task['description']) ? 'Sin descripción' : nl2br(htmlspecialchars($task['description'])) ?>
                    </p>
                    
                    <div class="text-gray-500 text-sm mb-4">
                        <p>Creada: <?= date('d/m/Y H:i', strtotime($task['created_at'])) ?></p>
                        <?php if ($task['updated_at']): ?>
                            <p>Actualizada: <?= date('d/m/Y H:i', strtotime($task['updated_at'])) ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <a href="/tasks/edit/<?= $task['id'] ?>" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Editar
                        </a>
                        
                        <form action="/tasks/delete/<?= $task['id'] ?>" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta tarea?');">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout/main.php';
?> 