<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-5xl mx-auto">

    <div class="flex justify-center">
      <div class="bg-white p-6 rounded-2xl shadow-xl rotate-[-3deg] hover:rotate-0 transition-transform duration-500 max-w-sm">
        <div class="w-72 h-80 rounded-xl bg-gradient-to-br from-[#C5A059]/20 to-[#C5A059]/5 flex items-center justify-center">
          <div class="text-center">
            <span class="text-8xl">🧁</span>
            <p class="text-[#2A1B14]/40 text-sm mt-4 font-serif italic">Repostería artesanal</p>
          </div>
        </div>
      </div>
    </div>

    <div>
      <h1 class="text-4xl font-serif font-bold text-[#2A1B14] mb-2">Bienvenido</h1>
      <p class="text-[#2A1B14]/60 text-sm mb-8">Accede a tu cuenta para gestionar tus pedidos</p>

      <?php if ($error): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-6">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form action="<?= url('/login') ?>" method="POST" class="space-y-6">

        <?php if (!empty($redirect)): ?>
          <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
        <?php endif; ?>

        <div>
          <label class="block text-xs uppercase tracking-widest font-semibold text-[#2A1B14]/70 mb-2">Correo electrónico</label>
          <input type="email" name="email" required
                 class="w-full px-5 py-3.5 rounded-xl text-sm text-[#2A1B14] placeholder-[#2A1B14]/30 focus:outline-none focus:ring-2 focus:ring-[#C5A059]/50 transition-all"
                 style="background:#EDEDED"
                 placeholder="tu@correo.com">
        </div>

        <div>
          <label class="block text-xs uppercase tracking-widest font-semibold text-[#2A1B14]/70 mb-2">Contraseña</label>
          <input type="password" name="password" required
                 class="w-full px-5 py-3.5 rounded-xl text-sm text-[#2A1B14] placeholder-[#2A1B14]/30 focus:outline-none focus:ring-2 focus:ring-[#C5A059]/50 transition-all"
                 style="background:#EDEDED"
                 placeholder="••••••••">
        </div>

        <button type="submit" class="w-full py-3.5 rounded-full font-semibold text-sm tracking-wide btn-primary hover:shadow-lg transition-all">
          Iniciar Sesión
        </button>

        <p class="text-center text-sm text-[#2A1B14]/50">
          ¿No tienes cuenta?
          <a href="<?= url('/register') ?>" class="text-[#4A148C] font-semibold hover:underline">Regístrate aquí</a>
        </p>

      </form>
    </div>

  </div>

</div>
