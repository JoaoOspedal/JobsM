<?php

session_start();

require __DIR__ . '/../app/Core/autoload.php';

use App\Core\Router;

$router = new Router();

$router->get('/usuarios', 'UsuarioController', 'index');
$router->get('/', 'TesteController', 'oi');
$router->get('/usuarios/novo', 'UsuarioController', 'novo');
$router->post('/usuarios/novo', 'UsuarioController', 'criar');

$router->get('/login', 'AuthController', 'tela');
$router->post('/login', 'AuthController', 'autenticar');
$router->get('/logout', 'AuthController', 'sair');
$router->get('/dashboard', 'DashboardController', 'index');

$router->get('/servicos/novo', 'ServicoController', 'novo');
$router->post('/servicos/novo', 'ServicoController', 'criar');

$router->get('/servicos/editar', 'ServicoController', 'editar');
$router->post('/servicos/editar', 'ServicoController', 'atualizar');
$router->get('/servicos/excluir', 'ServicoController', 'excluir');

$router->dispatch($_GET['url'] ?? '', $_SERVER['REQUEST_METHOD']);
