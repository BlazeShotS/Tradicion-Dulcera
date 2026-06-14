<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pastelería Artesanal — El Legado del Sabor Limeño</title>
  <?php require __DIR__ . '/../partials/_tailwind-config.php'; ?>
</head>
<body x-data="{ mobileMenu: false, cartCount: 0 }">

<a href="#main-content" class="skip-link rounded-br-lg focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
  Ir al contenido principal
</a>

<?php if (Auth::check() && (Auth::role() === 'cliente')): ?>
<nav class="bg-white shadow-sm border-b border-[#C5A059]/20" aria-label="Barra de navegación principal" x-data="{ mobileMenu: false }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-20">

      <div class="flex items-center gap-2">
        <a href="<?= url('/') ?>" class="flex items-center gap-2" aria-label="Ir al inicio">
          <span class="text-2xl font-serif font-bold text-[#2A1B14]" aria-hidden="true">🍰</span>
          <span class="text-2xl font-serif font-bold text-[#2A1B14]">Pastelería</span>
          <span class="hidden sm:inline text-sm text-[#C5A059] font-medium">desde 1924</span>
        </a>
      </div>

      <div class="hidden md:flex items-center gap-8">
        <a href="<?= url('/') ?>"
           class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059]">
          Inicio
        </a>
        <a href="<?= url('/carta') ?>"
           class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059]">
          Carta
        </a>
        <a href="<?= url('/mis-pedidos') ?>"
           class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059]">
          Mis Pedidos
        </a>
      </div>

      <div class="flex items-center gap-4">
        <a href="<?= url('/logout') ?>" class="text-sm text-[#2A1B14]/60 hover:text-red-500 transition-colors flex items-center gap-1 focus:outline-none focus:ring-2 focus:ring-red-300 rounded-lg px-2 py-1" aria-label="Cerrar sesión">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          <span class="hidden sm:inline">Salir</span>
        </a>
        <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-[#2A1B14] hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C5A059]" aria-label="Abrir menú de navegación" :aria-expanded="mobileMenu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        <div class="hidden md:flex items-center gap-3 pl-4 border-l border-gray-200">
          <div class="w-10 h-10 rounded-full bg-[#C5A059] flex items-center justify-center text-white font-bold text-sm" aria-hidden="true">
            <?= mb_strtoupper(mb_substr(Auth::user()['nombre'] ?? 'C', 0, 1)) ?>
          </div>
          <div class="hidden sm:block">
            <p class="text-sm font-semibold text-[#2A1B14]"><?= htmlspecialchars(Auth::user()['nombre'] ?? 'Cliente') ?></p>
            <p class="text-xs text-[#2A1B14]/60">Cliente</p>
          </div>
        </div>
      </div>

    </div>

    <div x-show="mobileMenu" x-cloak x-collapse class="md:hidden pb-4 border-t border-gray-100 pt-4">
      <a href="<?= url('/') ?>"
         class="block py-2.5 text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm focus:outline-none focus:text-[#C5A059]"
         @click="mobileMenu = false">
        Inicio
      </a>
      <a href="<?= url('/carta') ?>"
         class="block py-2.5 text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm focus:outline-none focus:text-[#C5A059]"
         @click="mobileMenu = false">
        Carta
      </a>
      <a href="<?= url('/mis-pedidos') ?>"
         class="block py-2.5 text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm focus:outline-none focus:text-[#C5A059]"
         @click="mobileMenu = false">
        Mis Pedidos
      </a>
      <div class="border-t border-gray-100 mt-3 pt-3 flex items-center gap-3 px-2">
        <div class="w-8 h-8 rounded-full bg-[#C5A059] flex items-center justify-center text-white font-bold text-xs"><?= mb_strtoupper(mb_substr(Auth::user()['nombre'] ?? 'C', 0, 1)) ?></div>
        <div>
          <p class="text-sm font-semibold text-[#2A1B14]"><?= htmlspecialchars(Auth::user()['nombre'] ?? 'Cliente') ?></p>
          <p class="text-xs text-[#2A1B14]/60">Cliente</p>
        </div>
      </div>
    </div>

  </div>
</nav>
<?php else: ?>
<nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-[#C5A059]/20 sticky top-0 z-40" aria-label="Navegación principal">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-20">

      <div class="flex items-center gap-2">
        <a href="<?= url('/') ?>" class="flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-[#C5A059] rounded-lg p-1" aria-label="Ir al inicio">
          <span class="text-2xl font-serif font-bold text-[#2A1B14]" aria-hidden="true">🍰</span>
          <span class="text-2xl font-serif font-bold text-[#2A1B14]">Pastelería</span>
          <span class="hidden sm:inline text-sm text-[#C5A059] font-medium">desde 1924</span>
        </a>
      </div>

      <div class="hidden md:flex items-center gap-8">
        <?php foreach ($menuPublic as $item): ?>
          <a href="<?= $item['url'] ?>"
             class="text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm transition-colors focus:outline-none focus:text-[#C5A059]">
            <?= $item['label'] ?>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?= url('/login') ?>" class="hidden sm:inline-block px-5 py-2.5 text-sm font-medium text-[#2A1B14] border-2 border-[#2A1B14] rounded-full hover:bg-[#2A1B14] hover:text-white transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
          Iniciar Sesión
        </a>
        <a href="<?= url('/register') ?>" class="px-5 py-2.5 text-sm font-medium text-white rounded-full transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:ring-offset-2 btn-chocolate">
          Registro
        </a>
        <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-[#2A1B14] hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C5A059]" aria-label="Abrir menú de navegación" :aria-expanded="mobileMenu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>

    </div>

    <div x-show="mobileMenu" x-cloak x-collapse class="md:hidden pb-4 border-t border-gray-100 pt-4">
      <?php foreach ($menuPublic as $item): ?>
        <a href="<?= $item['url'] ?>"
           class="block py-2.5 text-[#2A1B14]/80 hover:text-[#C5A059] font-medium text-sm focus:outline-none focus:text-[#C5A059]"
           @click="mobileMenu = false">
          <?= $item['label'] ?>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</nav>
<?php endif; ?>

<main id="main-content">
