<?php
use App\Routes\Router;
use App\Controllers\AuthController;
use App\Controllers\TaskController;

$router = new Router();

// Rutas de autenticación
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Rutas de tareas
$router->get('/', function() {
    header('Location: /tasks');
    exit;
});
$router->get('/tasks', 'TaskController@index');
$router->get('/tasks/create', 'TaskController@create');
$router->post('/tasks/store', 'TaskController@store');
$router->get('/tasks/edit/{id}', 'TaskController@edit');
$router->post('/tasks/update/{id}', 'TaskController@update');
$router->post('/tasks/delete/{id}', 'TaskController@delete');

return $router; 