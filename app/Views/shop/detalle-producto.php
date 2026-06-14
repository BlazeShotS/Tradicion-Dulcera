<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
     x-data="personalizacion(<?= $producto['precio'] ?>)">

  <?php // ——— BREADCRUMB ——— ?>
  <nav class="flex items-center gap-2 text-sm text-[#2A1B14]/50 mb-8" aria-label="Breadcrumb">
    <a href="<?= url('/') ?>" class="hover:text-[#C5A059] transition-colors focus:outline-none focus:text-[#C5A059]">Inicio</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="<?= url('/carta') ?>" class="hover:text-[#C5A059] transition-colors focus:outline-none focus:text-[#C5A059]">Carta</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-[#2A1B14] font-medium" aria-current="page"><?= $producto['nombre'] ?></span>
  </nav>

  <div class="flex flex-col lg:flex-row gap-8">

    <div class="w-full lg:w-3/5">

      <div class="relative rounded-2xl overflow-hidden shadow-lg mb-8"
           style="background: linear-gradient(135deg, #FDFBF7, #C5A059/10); min-height: 320px;">
        <div class="absolute top-4 left-4 z-10">
          <span class="bg-[#C5A059] text-white text-xs font-bold px-3 py-1 rounded-full">
            Sugerencia del Chef
          </span>
        </div>
        <div class="flex items-center justify-center h-80">
          <span class="text-9xl" aria-hidden="true">🎂</span>
        </div>
      </div>

      <h1 class="text-4xl font-serif font-bold text-[#2A1B14] mb-3"><?= $producto['nombre'] ?></h1>
      <p class="text-lg text-[#2A1B14]/70 mb-6"><?= $producto['descripcion'] ?></p>

      <div class="flex items-center gap-4 mb-8 flex-wrap">
        <span class="text-3xl font-bold text-[#2A1B14]">S/ <?= number_format($producto['precio'], 2) ?></span>
        <div class="flex items-center gap-2" role="group" aria-label="Selector de cantidad">
          <button @click="cantidad > 1 ? cantidad-- : null"
                  class="w-10 h-10 rounded-full border-2 border-[#2A1B14]/20 flex items-center justify-center text-lg hover:border-[#2A1B14] transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                  aria-label="Reducir cantidad">−</button>
          <span class="w-8 text-center text-xl font-bold" x-text="cantidad" aria-live="polite" role="status"></span>
          <button @click="cantidad < 99 ? cantidad++ : null"
                  class="w-10 h-10 rounded-full border-2 border-[#2A1B14]/20 flex items-center justify-center text-lg hover:border-[#2A1B14] transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                  aria-label="Aumentar cantidad">+</button>
        </div>
        <button @click="agregarSeleccion()"
                class="px-8 py-3 rounded-full font-semibold text-sm tracking-wide btn-chocolate hover:shadow-lg transition-all ml-auto focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:ring-offset-2">
          Añadir al Pedido
        </button>
      </div>

      <div class="border-t border-gray-200 pt-8">
        <h2 class="text-lg font-serif font-bold text-[#2A1B14] mb-4">Personaliza tu postre</h2>
        <div class="grid grid-cols-2 gap-4">
          <?php foreach ($ingredientesExtra as $extra): ?>
            <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:border-[#C5A059] transition-all focus-within:ring-2 focus-within:ring-[#C5A059]"
                   :class="{ 'border-[#C5A059] bg-[#C5A059]/5': extras['<?= $extra['id'] ?>'] }">
              <input type="checkbox"
                     x-model="extras['<?= $extra['id'] ?>']"
                     class="w-5 h-5 rounded border-gray-300 text-[#C5A059] focus:ring-[#C5A059]"
                     :aria-label="'Agregar <?= $extra['label'] ?>'">
              <div>
                <p class="text-sm font-medium text-[#2A1B14]"><?= $extra['label'] ?></p>
                <p class="text-xs text-[#C5A059]">+S/ <?= number_format($extra['costo'], 2) ?></p>
              </div>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

    </div>

    <div class="w-full lg:w-2/5" aria-label="Resumen del pedido">
      <div class="sticky top-24 bg-white rounded-2xl shadow-lg border border-gray-100 p-6">

        <h2 class="text-xl font-serif font-bold text-[#2A1B14] mb-6">Resumen del Pedido</h2>

        <div class="space-y-3 mb-6">
          <div class="flex items-center justify-between py-2 border-b border-gray-100">
            <span class="text-sm text-[#2A1B14]" x-text="'<?= addslashes($producto['nombre']) ?> × ' + cantidad"></span>
            <span class="text-sm font-semibold" x-text="'S/ ' + (<?= $producto['precio'] ?> * cantidad).toFixed(2)"></span>
          </div>
          <template x-for="(activo, key) in extras" :key="key">
            <div x-show="activo" class="flex items-center justify-between py-1 text-sm">
              <span class="text-[#2A1B14]/70" x-text="key.replace('extra-', '')"></span>
              <span class="text-[#C5A059]" x-text="'+S/ ' + costosExtra[key].toFixed(2)"></span>
            </div>
          </template>
        </div>

        <label for="instrucciones" class="sr-only">Instrucciones especiales</label>
        <textarea id="instrucciones" x-model="instrucciones"
                  placeholder="Instrucciones especiales (opcional)..."
                  class="w-full p-4 rounded-xl bg-gray-50 border border-gray-200 text-sm text-[#2A1B14] placeholder-[#2A1B14]/30 focus:outline-none focus:border-[#C5A059] focus:ring-2 focus:ring-[#C5A059]/20 resize-none mb-6"
                  rows="3"></textarea>

        <div class="border-t border-gray-200 pt-4 space-y-2">
          <div class="flex justify-between text-sm">
            <span class="text-[#2A1B14]/60">Subtotal</span>
            <span class="font-medium" x-text="'S/ ' + subtotal().toFixed(2)"></span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-[#2A1B14]/60">Personalización</span>
            <span class="font-medium text-[#C5A059]" x-text="'+S/ ' + costoExtras().toFixed(2)"></span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-[#2A1B14]/60">Envío</span>
            <span class="font-medium">S/ <?= number_format(COSTO_ENVIO, 2) ?></span>
          </div>
        </div>

        <div class="bg-gray-50 rounded-xl p-4 mt-4">
          <div class="flex justify-between items-center">
            <span class="text-lg font-bold text-[#2A1B14]">Total</span>
            <span class="text-2xl font-bold text-[#C5A059]" x-text="'S/ ' + totalFinal().toFixed(2)"></span>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<script>
function personalizacion(precioBase) {
  return {
    cantidad: 1,
    precioBase: precioBase,
    extras: {},
    instrucciones: '',
    costosExtra: {
      <?php foreach ($ingredientesExtra as $extra): ?>
        '<?= $extra['id'] ?>': <?= $extra['costo'] ?>,
      <?php endforeach; ?>
    },
    subtotal() {
      return this.precioBase * this.cantidad;
    },
    costoExtras() {
      let total = 0;
      for (const [key, activo] of Object.entries(this.extras)) {
        if (activo && this.costosExtra[key]) total += this.costosExtra[key];
      }
      return total;
    },
    totalFinal() {
      return this.subtotal() + this.costoExtras() + <?= COSTO_ENVIO ?>;
    },
    agregarSeleccion() {
      alert(`✓ Agregado: ${this.cantidad} unidad(es)\nTotal: S/ ${this.totalFinal().toFixed(2)}`);
    }
  }
}
</script>
