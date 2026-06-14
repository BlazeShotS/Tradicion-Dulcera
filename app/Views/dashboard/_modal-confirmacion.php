<div x-show="confirmacion.open" x-cloak
     @keydown.window.escape="confirmacion.open = false"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
     role="dialog" aria-modal="true" aria-label="Confirmar acción">
  <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6" @click.outside="confirmacion.open = false">
    <h3 class="text-lg font-serif font-bold text-[#2A1B14] mb-2" x-text="confirmacion.titulo"></h3>
    <p class="text-sm text-[#2A1B14]/70 mb-6" x-text="confirmacion.mensaje"></p>
    <?php if ($modalObservaciones ?? false): ?>
    <div class="mb-4">
      <label for="obs-entrega-modal" class="block text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Observaciones (opcional)</label>
      <input id="obs-entrega-modal" type="text" x-model="confirmacion.observaciones" placeholder="Ej: Sin cubiertos extra"
             class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:border-transparent bg-gray-50">
    </div>
    <?php endif; ?>
    <div class="flex gap-3 justify-end">
      <button @click="confirmacion.open = false" class="px-5 py-2.5 rounded-full text-sm font-medium border border-gray-200 text-[#2A1B14]/70 hover:bg-gray-50 transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]">Cancelar</button>
      <button @click="confirmarAccion()"
              class="px-5 py-2.5 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2"
              :class="confirmacion.btnClass || 'btn-chocolate'">
        <span x-text="confirmacion.btnText || 'Sí, continuar'"></span>
      </button>
    </div>
  </div>
</div>
