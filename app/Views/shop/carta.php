<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
     x-data="carrito()"
     x-init="cargarCarrito()">

  <div class="flex flex-col lg:flex-row gap-8">

    <div class="w-full lg:w-3/4">

      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-4xl font-serif font-bold text-[#2A1B14]">Nuestra Carta</h1>
          <p class="text-[#2A1B14]/60 text-sm mt-1">Selecciona tus favoritos y arma tu pedido</p>
        </div>
      </div>

      <div class="flex flex-wrap gap-2 mb-8" role="tablist" aria-label="Filtrar por categoría">
        <button @click="categoria = 'todas'"
                class="px-5 py-2 rounded-full text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                :class="categoria === 'todas' ? 'bg-[#2A1B14] text-white shadow-md' : 'bg-gray-100 text-[#2A1B14]/60 hover:bg-gray-200'"
                role="tab" :aria-selected="categoria === 'todas'">Todas</button>
        <?php
        $categorias = array_unique(array_map(fn($p) => $p['categoria'], $productos));
        sort($categorias);
        foreach ($categorias as $cat):
        ?>
          <button @click="categoria = '<?= $cat ?>'"
                  class="px-5 py-2 rounded-full text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                  :class="categoria === '<?= $cat ?>' ? 'bg-[#2A1B14] text-white shadow-md' : 'bg-gray-100 text-[#2A1B14]/60 hover:bg-gray-200'"
                  role="tab" :aria-selected="categoria === '<?= $cat ?>'"><?= ucfirst($cat) ?></button>
        <?php endforeach; ?>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6" role="list" aria-label="Lista de productos">
        <?php foreach ($productos as $p): ?>
          <div class="relative rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all group"
               role="listitem"
               x-show="categoria === 'todas' || categoria === '<?= $p['categoria'] ?>'">
            <div class="h-48 bg-gradient-to-br from-[#FDFBF7] to-[#FECD70]/20 flex items-center justify-center"
                 x-bind:class="<?= $p['destacado'] ? "'bg-gradient-to-br from-[#2A1B14] to-[#3d281e]'" : "''" ?>">
              <span class="text-6xl" aria-hidden="true">🍰</span>
            </div>
            <div class="p-5">
              <div class="flex items-center gap-2 mb-2 flex-wrap">
                <h3 class="text-xl font-serif font-bold text-[#2A1B14]"><?= $p['nombre'] ?></h3>
                <?php if ($p['etiqueta']): ?>
                  <span class="bg-[#4A148C]/10 text-[#4A148C] text-[10px] font-bold px-2 py-0.5 rounded-full"><?= $p['etiqueta'] ?></span>
                <?php endif; ?>
                <?php if ($p['destacado']): ?>
                  <span class="bg-[#C5A059] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">Destacado</span>
                <?php endif; ?>
              </div>
              <p class="text-[#2A1B14]/60 text-sm mb-4 line-clamp-2"><?= $p['descripcion'] ?></p>
              <div class="flex items-center justify-between">
                <span class="text-xl font-bold text-[#2A1B14]">S/ <?= number_format($p['precio'], 2) ?></span>
                <button @click="agregarItem(<?= $p['id'] ?>, '<?= addslashes($p['nombre']) ?>', <?= $p['precio'] ?>)"
                        class="bg-[#FECD70] text-[#2A1B14] px-4 py-2 rounded-full text-xs font-semibold hover:bg-[#f5c260] transition-all focus:outline-none focus:ring-2 focus:ring-[#FECD70] focus:ring-offset-2"
                        aria-label="Añadir <?= addslashes($p['nombre']) ?> al pedido">
                  Añadir al Pedido
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div x-show="productosVisibles === 0" class="text-center py-16" role="status">
        <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <p class="text-lg font-serif font-bold text-[#2A1B14]">No hay productos en esta categoría</p>
      </div>
    </div>

    <div class="w-full lg:w-1/4" aria-label="Carrito de compras">
      <div class="sticky top-24 bg-white rounded-2xl shadow-lg border border-gray-100 p-6">

        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl font-serif font-bold text-[#2A1B14]">Tu Pedido</h2>
          <span class="bg-[#C5A059]/10 text-[#C5A059] text-xs font-bold px-2.5 py-1 rounded-full" x-text="items.length + ' items'" aria-live="polite">0 items</span>
        </div>

        <div class="space-y-4 mb-6 max-h-[400px] overflow-y-auto" x-show="items.length > 0" role="list" aria-label="Items en tu pedido">
          <template x-for="(item, idx) in items" :key="item.id">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100" role="listitem">
              <div class="w-12 h-12 rounded-lg bg-[#FDFBF7] flex items-center justify-center flex-shrink-0" aria-hidden="true">
                <span class="text-2xl">🍪</span>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-[#2A1B14] truncate" x-text="item.nombre"></p>
                <p class="text-xs text-[#C5A059] font-medium" x-text="'S/ ' + item.precio.toFixed(2)"></p>
              </div>
              <div class="flex items-center gap-1">
                <button @click="cambiarCantidad(idx, -1)"
                        class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-sm hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                        aria-label="Reducir cantidad">−</button>
                <span class="w-6 text-center text-sm font-semibold" x-text="item.cantidad" aria-live="polite"></span>
                <button @click="cambiarCantidad(idx, 1)"
                        class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-sm hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                        aria-label="Aumentar cantidad">+</button>
              </div>
              <button @click="eliminarItem(idx)" class="text-red-300 hover:text-red-500 transition-colors focus:outline-none focus:ring-2 focus:ring-red-300 rounded-lg p-1" aria-label="Eliminar item del pedido">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
              </button>
            </div>
          </template>
        </div>

        <div x-show="items.length === 0" class="text-center py-8" role="status">
          <svg class="w-12 h-12 mx-auto text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
          <p class="text-[#2A1B14]/40 text-sm mt-2">Tu pedido está vacío</p>
        </div>

        <div class="border-t border-gray-200 pt-4 space-y-2" x-show="items.length > 0">
          <div class="flex justify-between text-sm">
            <span class="text-[#2A1B14]/60">Subtotal</span>
            <span class="font-medium" x-text="'S/ ' + subtotal().toFixed(2)"></span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-[#2A1B14]/60">Envío</span>
            <span class="font-medium" x-text="'S/ ' + envio().toFixed(2)"></span>
          </div>
          <div class="flex justify-between text-lg font-bold text-[#2A1B14] pt-2 border-t border-gray-200">
            <span>Total</span>
            <span x-text="'S/ ' + total().toFixed(2)"></span>
          </div>
        </div>

        <button @click="confirmarPedido()"
                x-bind:disabled="items.length === 0"
                class="w-full mt-6 py-3.5 rounded-full font-semibold text-sm tracking-wide transition-all btn-chocolate focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:ring-offset-2"
                x-bind:class="items.length === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:shadow-lg'"
                :aria-label="items.length === 0 ? 'Agrega productos para confirmar' : 'Confirmar pedido'">
          CONFIRMAR PEDIDO
        </button>

        <p class="text-center text-xs text-[#2A1B14]/40 mt-3" x-show="items.length > 0">
          🕐 Tiempo estimado: 45 min
        </p>

      </div>
    </div>

  </div>
</div>

<script>
function carrito() {
  return {
    items: [],
    categoria: 'todas',
    get productosVisibles() {
      return document.querySelectorAll('[role="listitem"]:not([style*="display: none"])').length;
    },
    cargarCarrito() {
      const saved = localStorage.getItem('carrito');
      if (saved) this.items = JSON.parse(saved);
    },
    guardar() {
      localStorage.setItem('carrito', JSON.stringify(this.items));
    },
    agregarItem(id, nombre, precio) {
      const existente = this.items.find(i => i.id === id);
      if (existente) {
        existente.cantidad++;
      } else {
        this.items.push({ id, nombre, precio, cantidad: 1 });
      }
      this.guardar();
    },
    cambiarCantidad(idx, delta) {
      const nuevo = this.items[idx].cantidad + delta;
      if (nuevo < 1) return;
      this.items[idx].cantidad = nuevo;
      this.guardar();
    },
    eliminarItem(idx) {
      this.items.splice(idx, 1);
      this.guardar();
    },
    subtotal() {
      return this.items.reduce((sum, i) => sum + i.precio * i.cantidad, 0);
    },
    envio() {
      return this.items.length > 0 ? <?= COSTO_ENVIO ?> : 0;
    },
    total() {
      return this.subtotal() + this.envio();
    },
    confirmarPedido() {
      if (this.items.length === 0) return;
      localStorage.setItem('pedido-confirmado', JSON.stringify({
        items: this.items,
        subtotal: this.subtotal(),
        envio: this.envio(),
        total: this.total(),
        fecha: new Date().toISOString()
      }));
      window.location.href = '<?= url('/checkout') ?>';
    }
  }
}
</script>
