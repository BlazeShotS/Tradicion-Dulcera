<?php

// ─── Base de datos ───
define('DB_HOST', 'localhost');
define('DB_NAME', 'pasteleria');
define('DB_USER', 'root');
define('DB_PASS', '');

// ─── URL base (se detecta automáticamente: /APF3 o vacío en raíz) ───
define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

define('COSTO_ENVIO', 8);

function url(string $path = ''): string
{
    return BASE_URL . $path;
}

// ─── Menú público ───
$menuPublic = [
    ['label' => 'Inicio', 'url' => url('/')],
    ['label' => 'Carta', 'url' => url('/carta')],
];

// ─── Menú interno ───
$menuInternal = [
    ['label' => 'Catálogo', 'url' => url('/carta')],
    ['label' => 'Seguimiento', 'url' => url('/panel-mozo')],
    ['label' => 'Gestión', 'url' => url('/cocina')],
    ['label' => 'Entregas', 'url' => url('/entregas')],
];

// ─── Redes sociales ───
$redesSociales = [
    ['nombre' => 'Facebook', 'icono' => 'M18 2h-3a5 6 0 0 0-6 6v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z'],
    ['nombre' => 'Instagram', 'icono' => 'M16 4H8a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V8a4 4 0 0 0-4-4zm-4 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm3.5-6.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'],
    ['nombre' => 'WhatsApp', 'icono' => 'M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z'],
];

// ─── Footer ───
$enlacesFooter = [
    'explora' => [
        ['label' => 'Inicio', 'url' => url('/')],
        ['label' => 'Carta', 'url' => url('/carta')],
        ['label' => 'Galería', 'url' => url('/#galeria')],
        ['label' => 'Nosotros', 'url' => url('/#nosotros')],
    ],
    'soporte' => [
        ['label' => 'Contacto', 'url' => '#'],
        ['label' => 'FAQ', 'url' => '#'],
        ['label' => 'Términos', 'url' => '#'],
        ['label' => 'Privacidad', 'url' => '#'],
    ],
];

// ─── Pilares (migrado a BD: Model/Pilar.php) ───
// ─── Productos (migrado a BD: Model/Producto.php) ───
// ─── Ingredientes extra (migrado a BD: Model/IngredienteExtra.php) ───
// ─── Comandas (migrado a BD: Model/Comanda.php) ───
