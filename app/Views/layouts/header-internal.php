<?php
$user = Auth::user();
$nombre = $user['nombre'] ?? 'Usuario';
$iniciales = mb_strtoupper(mb_substr($nombre, 0, 1));
$rolLabel = match ($user['rol'] ?? '') {
    'admin' => 'Administrador',
    'cocina' => 'Cocina',
    'mozo' => 'Mozo',
    'cliente' => 'Cliente',
    default => 'Usuario',
};
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$relativePath = '/' . trim(str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $currentPath), '/');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pastelería Artesanal — Intranet</title>
  <?php require __DIR__ . '/../partials/_tailwind-config.php'; ?>
</head>
<body>

<a href="#main-content" class="skip-link rounded-br-lg focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
  Ir al contenido principal
</a>

<div x-data="app()">

  <?php require __DIR__ . '/../partials/_toast.php'; ?>

  <nav class="bg-white shadow-sm border-b border-[#C5A059]/20" aria-label="Barra de navegación principal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">

        <div class="flex items-center gap-2">
          <a href="<?= url('/') ?>" class="flex items-center gap-2" aria-label="Ir al inicio">
            <span class="text-2xl font-serif font-bold text-[#2A1B14]" aria-hidden="true">🍰</span>
            <span class="text-2xl font-serif font-bold text-[#2A1B14]">Pastelería</span>
            <span class="hidden sm:inline text-sm text-[#C5A059] font-medium">Intranet</span>
          </a>
        </div>

        <div class="hidden md:flex items-center gap-8">
          <?php if (Auth::role() === 'cliente'): ?>
            <a href="<?= url('/') ?>"
               class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059] <?= $relativePath === '/' ? 'text-[#C5A059] border-b-2 border-[#C5A059]' : '' ?>">
              Inicio
            </a>
            <a href="<?= url('/carta') ?>"
               class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059] <?= $relativePath === '/carta' ? 'text-[#C5A059] border-b-2 border-[#C5A059]' : '' ?>">
              Carta
            </a>
            <a href="<?= url('/mis-pedidos') ?>"
               class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059] <?= $relativePath === '/mis-pedidos' ? 'text-[#C5A059] border-b-2 border-[#C5A059]' : '' ?>">
              Mis Pedidos
            </a>
          <?php endif; ?>
          <?php if (Auth::role() === 'admin'): ?>
            <a href="<?= url('/admin') ?>"
               class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059] <?= $relativePath === '/admin' ? 'text-[#C5A059] border-b-2 border-[#C5A059]' : '' ?>">
              General
            </a>
            <a href="<?= url('/admin/historial-entregas') ?>"
               class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059] <?= strpos($relativePath, '/admin/historial') === 0 ? 'text-[#C5A059] border-b-2 border-[#C5A059]' : '' ?>">
              Historial
            </a>
          <?php endif; ?>
        </div>

        <div class="flex items-center gap-4">
          <a href="<?= url('/logout') ?>" class="text-sm text-[#2A1B14]/60 hover:text-red-500 transition-colors flex items-center gap-1 focus:outline-none focus:ring-2 focus:ring-red-300 rounded-lg px-2 py-1" aria-label="Cerrar sesión">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span class="hidden sm:inline">Salir</span>
          </a>
          <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
            <div class="w-10 h-10 rounded-full bg-[#C5A059] flex items-center justify-center text-white font-bold text-sm" aria-hidden="true">
              <?= $iniciales ?>
            </div>
            <div class="hidden sm:block">
              <p class="text-sm font-semibold text-[#2A1B14]"><?= htmlspecialchars($nombre) ?></p>
              <p class="text-xs text-[#2A1B14]/60"><?= $rolLabel ?></p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </nav>

  <div x-data="{ mobileOpen: false }" class="lg:hidden border-b border-gray-200 bg-white">
    <button @click="mobileOpen = !mobileOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-[#2A1B14] focus:outline-none focus:ring-2 focus:ring-[#C5A059]" aria-expanded="false" :aria-expanded="mobileOpen">
      <span>Menú</span>
      <svg class="w-5 h-5 transition-transform" :class="mobileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>
    <div x-show="mobileOpen" x-collapse class="border-t border-gray-100">
      <div class="px-4 py-3 space-y-1">
        <?php if (Auth::role() === 'cliente'): ?>
          <a href="<?= url('/') ?>" class="block px-3 py-2 rounded-lg text-sm <?= $relativePath === '/' ? 'bg-[#FDFBF7] text-[#C5A059] font-semibold' : 'text-[#2A1B14]/70' ?>">Inicio</a>
          <a href="<?= url('/carta') ?>" class="block px-3 py-2 rounded-lg text-sm <?= $relativePath === '/carta' ? 'bg-[#FDFBF7] text-[#C5A059] font-semibold' : 'text-[#2A1B14]/70' ?>">Carta</a>
          <a href="<?= url('/mis-pedidos') ?>" class="block px-3 py-2 rounded-lg text-sm <?= $relativePath === '/mis-pedidos' ? 'bg-[#FDFBF7] text-[#C5A059] font-semibold' : 'text-[#2A1B14]/70' ?>">Mis Pedidos</a>
        <?php endif; ?>
        <?php if (Auth::role() === 'admin'): ?>
          <a href="<?= url('/admin') ?>" class="block px-3 py-2 rounded-lg text-sm <?= $relativePath === '/admin' ? 'bg-[#FDFBF7] text-[#C5A059] font-semibold' : 'text-[#2A1B14]/70' ?>">General</a>
          <a href="<?= url('/admin/historial-entregas') ?>" class="block px-3 py-2 rounded-lg text-sm <?= strpos($relativePath, '/admin/historial') === 0 ? 'bg-[#FDFBF7] text-[#C5A059] font-semibold' : 'text-[#2A1B14]/70' ?>">Historial</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <main id="main-content">
</div>

<script src="<?= url('/assets/js/estados.js') ?>"></script>
<script>
function app() {
  return {
    toast: { visible: false, type: 'success', message: '' }
  }
}
</script>
<script>
window.notify = function(type, message) {
  const el = document.querySelector('[x-data="app()"]');
  if (el && el.__x) {
    el.__x.$data.toast = { visible: true, type, message };
    clearTimeout(el.__x.$data.toast._timer);
    el.__x.$data.toast._timer = setTimeout(() => { el.__x.$data.toast.visible = false; }, 4000);
  }
};
window.notifySuccess = (msg) => window.notify('success', msg);
window.notifyError = (msg) => window.notify('error', msg);
</script>
