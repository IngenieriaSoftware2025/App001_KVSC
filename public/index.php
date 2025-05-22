<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\ProductosController;
use Controllers\CategoriaController;
use Controllers\TestController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

// Ruta principal
$router->get('/', [AppController::class, 'index']);

// Rutas para productos - VERSION SIMPLIFICADA
$router->get('/productos', [ProductosController::class, 'renderizarPagina']);
$router->post('/productos/guardarAPI', [ProductosController::class, 'guardarAPI']);
$router->get('/productos/buscarAPI', [ProductosController::class, 'buscarAPI']);
$router->post('/productos/modificarAPI', [ProductosController::class, 'modificarAPI']);
$router->post('/productos/comprarAPI', [ProductosController::class, 'comprarAPI']);
$router->post('/productos/eliminarAPI', [ProductosController::class, 'eliminarAPI']);

// Rutas para categorías
$router->get('/categoria', [CategoriaController::class, 'renderizarPagina']);
$router->post('/categoria/guardarAPI', [CategoriaController::class, 'guardarAPI']);
$router->get('/categoria/buscarAPI', [CategoriaController::class, 'buscarAPI']);
$router->post('/categoria/modificarAPI', [CategoriaController::class, 'modificarAPI']);
$router->post('/categoria/eliminarAPI', [CategoriaController::class, 'eliminarAPI']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();