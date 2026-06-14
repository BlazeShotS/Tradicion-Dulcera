</main>

<footer class="bg-[#2A1B14] text-[#FDFBF7] pt-16 pb-6" x-data="{ email: '', error: '', success: '' }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

      <div>
        <a href="<?= url('/') ?>" class="flex items-center gap-2 mb-4 focus:outline-none focus:ring-2 focus:ring-[#C5A059] rounded-lg p-1" aria-label="Ir al inicio">
          <span class="text-3xl" aria-hidden="true">🍰</span>
          <span class="text-xl font-serif font-bold">Pastelería</span>
        </a>
        <p class="text-sm text-[#FDFBF7]/70 mb-6 leading-relaxed">
          Endulzando Lima desde 1924. Tradición, calidad y amor en cada bocado.
        </p>
        <div class="flex gap-3">
          <?php foreach ($redesSociales as $red): ?>
            <a href="#" class="w-10 h-10 rounded-full border border-[#FDFBF7]/30 flex items-center justify-center hover:bg-[#C5A059] hover:border-[#C5A059] transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]" aria-label="<?= $red['nombre'] ?>">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="<?= $red['icono'] ?>"/>
              </svg>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div>
        <h4 class="font-semibold text-sm uppercase tracking-widest mb-4 text-[#C5A059]">Explora</h4>
        <ul class="space-y-3" aria-label="Enlaces de exploración">
          <?php foreach ($enlacesFooter['explora'] as $link): ?>
            <li>
              <a href="<?= $link['url'] ?>" class="text-sm text-[#FDFBF7]/70 hover:text-[#C5A059] transition-colors focus:outline-none focus:text-[#C5A059]">
                <?= $link['label'] ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h4 class="font-semibold text-sm uppercase tracking-widest mb-4 text-[#C5A059]">Soporte</h4>
        <ul class="space-y-3" aria-label="Enlaces de soporte">
          <?php foreach ($enlacesFooter['soporte'] as $link): ?>
            <li>
              <a href="<?= $link['url'] ?>" class="text-sm text-[#FDFBF7]/70 hover:text-[#C5A059] transition-colors focus:outline-none focus:text-[#C5A059]">
                <?= $link['label'] ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h4 class="font-semibold text-sm uppercase tracking-widest mb-4 text-[#C5A059]">Newsletter</h4>
        <p class="text-sm text-[#FDFBF7]/70 mb-4">
          Recibe nuestras novedades y ofertas exclusivas.
        </p>
        <div class="relative">
          <label for="newsletter-email" class="sr-only">Correo electrónico</label>
          <input id="newsletter-email" type="email" x-model="email"
                 placeholder="tu@email.com"
                 class="w-full bg-transparent border-b border-[#FDFBF7]/30 pb-2 pr-10 text-sm text-[#FDFBF7] placeholder-[#FDFBF7]/50 focus:outline-none focus:border-[#C5A059] transition-colors"
                 @input="error = ''; success = ''">
          <button @click.prevent="
            if(!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) { error = 'Email inválido'; return; }
            success = '¡Suscripción exitosa!'; email = '';
          " class="absolute right-0 top-0 text-[#C5A059] hover:text-[#FDFBF7] transition-colors focus:outline-none focus:ring-2 focus:ring-[#C5A059] rounded-lg p-1" aria-label="Suscribirse">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </button>
        </div>
        <template x-if="error">
          <p class="text-xs text-red-400 mt-2" x-text="error" role="alert"></p>
        </template>
        <template x-if="success">
          <p class="text-xs text-green-400 mt-2" x-text="success" role="status"></p>
        </template>
      </div>

    </div>

    <div class="border-t border-[#FDFBF7]/10 pt-6 text-center">
      <p class="text-sm text-[#FDFBF7]/50">
        &copy; <?= date('Y') ?> Pastelería Artesanal. Todos los derechos reservados.
      </p>
    </div>

  </div>
</footer>

</body>
</html>
