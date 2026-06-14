<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-5xl mx-auto">

    <div class="text-center lg:text-left">
      <h1 class="text-5xl lg:text-6xl font-serif font-bold text-[#2A1B14] leading-tight mb-8">
        El Legado del<br>
        <span class="text-[#C5A059]">Dulce</span> en tu Mesa
      </h1>
      <div class="w-full max-w-md mx-auto lg:mx-0 aspect-square rounded-2xl bg-gradient-to-br from-[#C5A059]/20 to-[#FECD70]/10 flex items-center justify-center">
        <div class="text-center">
          <span class="text-8xl">🍰</span>
          <p class="text-[#2A1B14]/40 text-sm mt-4 font-serif">Postres artesanales limeños</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-10">

      <h2 class="text-2xl font-serif font-bold text-[#2A1B14] mb-6">Crear Cuenta</h2>

      <?php if ($error): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-6">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form action="<?= url('/register') ?>" method="POST" class="space-y-6">

        <div class="relative">
          <input type="text" name="nombre" required
                 class="w-full py-3 bg-transparent border-b border-gray-300 text-sm text-[#2A1B14] placeholder-[#2A1B14]/30 focus:outline-none focus:border-[#A38446] transition-colors pr-8"
                 placeholder="Nombre completo">
          <svg class="absolute right-0 top-3 w-5 h-5 text-[#2A1B14]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>

        <div class="relative">
          <input type="email" name="email" required
                 class="w-full py-3 bg-transparent border-b border-gray-300 text-sm text-[#2A1B14] placeholder-[#2A1B14]/30 focus:outline-none focus:border-[#A38446] transition-colors pr-8"
                 placeholder="Correo electrónico">
          <svg class="absolute right-0 top-3 w-5 h-5 text-[#2A1B14]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
        </div>

        <div class="relative">
          <input type="tel" name="telefono" required
                 class="w-full py-3 bg-transparent border-b border-gray-300 text-sm text-[#2A1B14] placeholder-[#2A1B14]/30 focus:outline-none focus:border-[#A38446] transition-colors pr-8"
                 placeholder="Teléfono">
          <svg class="absolute right-0 top-3 w-5 h-5 text-[#2A1B14]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
          </svg>
        </div>

        <div class="relative">
          <input type="password" name="password" required
                 class="w-full py-3 bg-transparent border-b border-gray-300 text-sm text-[#2A1B14] placeholder-[#2A1B14]/30 focus:outline-none focus:border-[#A38446] transition-colors pr-8"
                 placeholder="Contraseña">
          <svg class="absolute right-0 top-3 w-5 h-5 text-[#2A1B14]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>

        <button type="submit" class="w-full py-3.5 rounded-full font-semibold text-sm tracking-wide btn-primary hover:shadow-lg transition-all flex items-center justify-center gap-2">
          Registrar Cuenta
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </button>

        <p class="text-center text-sm text-[#2A1B14]/50">
          ¿Ya tienes cuenta?
          <a href="<?= url('/login') ?>" class="text-[#4A148C] font-semibold hover:underline">Inicia sesión</a>
        </p>

      </form>
    </div>

  </div>

</div>
