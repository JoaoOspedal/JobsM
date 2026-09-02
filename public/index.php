<?php

require __DIR__ . '/../app/Core/autoload.php';

use App\Core\Router;

$router = new Router();

$router->get('/usuarios', 'UsuarioController', 'index');
$router->get('/', 'TesteController', 'oi');
$router->get('/usuarios/novo', 'UsuarioController', 'novo');
$router->post('/usuarios/novo', 'UsuarioController', 'criar');

$router->dispatch($_GET['url'] ?? '', $_SERVER['REQUEST_METHOD']);
