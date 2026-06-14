<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/app/autoload.php';

$redirectMap = [
    '/login.php'             => '/login',
    '/register.php'          => '/register',
    '/carta.php'             => '/carta',
    '/checkout.php'          => '/checkout',
    '/cocina-kds.php'        => '/cocina',
    '/detalle-producto.php'  => '/detalle-producto',
    '/entregas.php'          => '/entregas',
    '/panel-mozo.php'        => '/panel-mozo',
];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = '/' . trim(str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $uri), '/');

if (isset($redirectMap[$path])) {
    $qs = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
    header('Location: ' . url($redirectMap[$path]) . $qs);
    exit;
}

$router = new Router();

$router->get('/', ['HomeController', 'index']);
$router->get('/carta', ['CartaController', 'index']);
$router->get('/login', ['AuthController', 'login']);
$router->post('/login', ['AuthController', 'login']);
$router->get('/register', ['AuthController', 'register']);
$router->post('/register', ['AuthController', 'register']);
$router->get('/logout', ['AuthController', 'logout']);
$router->get('/checkout', ['CheckoutController', 'index']);
$router->get('/detalle-producto', ['DetalleProductoController', 'show']);

$router->get('/panel-mozo', ['PanelMozoController', 'index']);
$router->post('/panel-mozo/mover', ['PanelMozoController', 'moverPreparacion']);
$router->get('/cocina', ['CocinaController', 'index']);
$router->post('/cocina/marcar-listo', ['CocinaController', 'marcarListo']);
$router->get('/entregas', ['EntregasController', 'index']);
$router->post('/entregas/confirmar', ['EntregasController', 'confirmarEntrega']);
$router->get('/entregas/confirmar', ['EntregasController', 'confirmarEntrega']);
$router->get('/mis-pedidos', ['MisPedidosController', 'index']);
$router->post('/checkout/confirmar', ['CheckoutController', 'confirmar']);
$router->get('/admin', ['AdminController', 'index']);
$router->get('/admin/historial-entregas', ['HistorialEntregasController', 'index']);
$router->get('/admin/api/historial-entregas', ['HistorialEntregasController', 'api']);
$router->get('/admin/api/historial-entregas/detalle', ['HistorialEntregasController', 'detalle']);

$router->dispatch();
