<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App - <?= $title ?? 'Gestiona tus tareas' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="description" content="Aplicación segura para gestionar tus tareas diarias">
    <meta name="csrf-token" content="<?= $csrf_token ?? '' ?>">
    <!-- Prevenir XSS en navegadores antiguos -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Evitar que el navegador almacene en caché datos sensibles -->
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link favicon rel="icon" href="/img/favicon.ico" type="image/x-icon">
    <style>
        /* Estilos adicionales que puedan ser necesarios */
        .fadeOut {
            animation: fadeOut 0.5s ease-out forwards;
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100 flex flex-col">
    <!-- Encabezado -->
    <header class="bg-indigo-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">Todo App</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="flex items-center space-x-4">
                    <span class="hidden md:inline">Hola, <?= htmlspecialchars($_SESSION['username']) ?></span>
                    <a href="/tasks" class="hover:underline">Mis Tareas</a>
                    <a href="/logout" class="px-4 py-2 bg-indigo-700 rounded-md hover:bg-indigo-800 transition">Cerrar Sesión</a>
                </div>
            <?php else: ?>
                <div class="space-x-2">
                    <a href="/login" class="px-4 py-2 bg-indigo-700 rounded-md hover:bg-indigo-800 transition">Iniciar Sesión</a>
                    <a href="/register" class="px-4 py-2 bg-white text-indigo-600 rounded-md hover:bg-gray-100 transition">Registrarse</a>
                </div>
            <?php endif; ?>
        </div>
    </header>
    
    <!-- Mensajes Flash -->
    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <div class="container mx-auto px-4 py-2">
            <?php if (isset($_SESSION['success'])): ?>
                <div id="successAlert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p><?= $_SESSION['success'] ?></p>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div id="errorAlert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><?= $_SESSION['error'] ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <!-- Contenido principal -->
    <main class="container mx-auto px-4 py-8 flex-grow">
        <?= $content ?? '' ?>
    </main>
    
    <!-- Pie de página -->
    <footer class="bg-gray-800 text-white py-4 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> Todo App - Una aplicación segura desarrollada con PHP POO</p>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        // Auto-ocultar los mensajes flash después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('#successAlert, #errorAlert');
            
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('fadeOut');
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html> 