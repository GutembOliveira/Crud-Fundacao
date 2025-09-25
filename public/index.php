<?php
require_once __DIR__ . '/../config/bootstrap.php';

use app\Router\Router;

$router = new Router();

// Carrega o arquivo de rotas
require __DIR__ . '/../config/routes.php';

// Dispara a requisição
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
