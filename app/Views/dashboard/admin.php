<div class="flex min-h-[calc(100vh-5rem)]">
  <?php require __DIR__ . '/_sidebar.php'; ?>

  <div class="w-full lg:w-[80%] p-6 lg:p-10"
       x-data="adminPanel()"
       x-init="cargar()">

    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
      <div>
        <h1 class="text-3xl font-serif font-bold text-[#2A1B14]">Panel General</h1>
        <p class="text-[#2A1B14]/60 text-sm mt-1">Todas las órdenes del sistema</p>
      </div>
      <div class="bg-gray-100 rounded-xl px-5 py-3 text-center" aria-live="polite">
        <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider">Total Órdenes</p>
        <p class="text-2xl font-bold text-[#2A1B14]" x-text="pedidos.length">0</p>
      </div>
    </div>

    <div class="flex flex-wrap gap-2 mb-8 border-b border-gray-200 pb-4" role="tablist" aria-label="Filtrar por estado">
      <template x-for="tab in tabs" :key="tab.key">
        <button @click="filtro = tab.key"
                role="tab"
                :aria-selected="filtro === tab.key"
                :aria-controls="'panel-' + tab.key"
                class="px-5 py-2 rounded-full text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                x-bind:class="filtro === tab.key ? 'bg-[#2A1B14] text-white shadow-md' : 'bg-gray-100 text-[#2A1B14]/60 hover:bg-gray-200'">
          <span x-text="tab.label"></span>
          <span class="ml-1.5 text-xs opacity-70" x-text="'(' + tab.count + ')'"></span>
        </button>
      </template>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" role="list" :id="'panel-' + filtro">
      <template x-for="pedido in pedidosFiltrados" :key="pedido.id">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all" role="listitem">

          <div class="flex items-center justify-between mb-4">
            <div>
              <span class="text-xs text-[#2A1B14]/50 font-medium">Mesa</span>
              <p class="text-2xl font-bold text-[#2A1B14]"
                 x-text="pedido.mesa > 0 ? '#' + pedido.mesa : 'Delivery'"></p>
            </div>
            <div class="text-right">
              <span class="text-xs text-[#2A1B14]/50 font-medium">Cliente</span>
              <p class="text-sm font-semibold text-[#2A1B14]" x-text="pedido.cliente"></p>
              <template x-if="pedido.usuario_id">
                <span class="text-xs text-[#C5A059]">(registrado)</span>
              </template>
            </div>
          </div>

          <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold"
                  x-bind:class="estadoClase(pedido.estado)">
              <span class="w-1.5 h-1.5 rounded-full" :class="estadoPunto(pedido.estado)"></span>
              <span x-text="estadoLabel(pedido.estado)"></span>
            </span>
            <span class="text-sm font-bold text-[#2A1B14]/70" x-text="pedido.tiempo + ' min'"></span>
          </div>

          <div class="space-y-2 mb-4">
            <template x-for="item in pedido.items" :key="item.nombre">
              <div class="flex justify-between items-center py-1.5 px-2 rounded-lg bg-gray-50">
                <span class="text-sm text-[#2A1B14]">
                  <span class="font-semibold" x-text="item.cantidad + '×'"></span>
                  <span x-text="item.nombre"></span>
                  <template x-if="item.variante">
                    <span class="text-xs text-[#C5A059]" x-text="'(' + item.variante + ')'"></span>
                  </template>
                </span>
              </div>
            </template>
          </div>

          <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="text-xs text-[#2A1B14]/40">#<span x-text="pedido.id"></span></span>
            <span class="text-base font-bold text-[#2A1B14]">S/ <span x-text="pedido.total.toFixed(2)"></span></span>
          </div>

        </div>
      </template>
    </div>

    <template x-if="pedidosFiltrados.length === 0">
      <div class="text-center py-20">
        <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p class="text-lg font-serif font-bold text-[#2A1B14]">No hay órdenes en este estado</p>
        <p class="text-sm text-[#2A1B14]/50 mt-1">Las órdenes aparecerán aquí a medida que avancen en el flujo.</p>
      </div>
    </template>

  </div>
</div>

<script>
function adminPanel() {
  return {
    pedidos: <?= json_encode($comandas) ?>,
    filtro: 'todas',
    tabs: [],
    get pedidosFiltrados() {
      if (this.filtro === 'todas') return this.pedidos;
      return this.pedidos.filter(p => p.estado === this.filtro);
    },
    cargar() {
      this.calcularTabs();
    },
    calcularTabs() {
      const counts = { todas: this.pedidos.length };
      const estados = ['pendiente', 'preparacion', 'listo', 'entregado'];
      estados.forEach(e => {
        counts[e] = this.pedidos.filter(p => p.estado === e).length;
      });
      this.tabs = [
        { key: 'todas', label: 'Todas', count: counts.todas },
        { key: 'pendiente', label: 'Pendientes', count: counts.pendiente },
        { key: 'preparacion', label: 'En Preparación', count: counts.preparacion },
        { key: 'listo', label: 'Listos', count: counts.listo },
        { key: 'entregado', label: 'Entregados', count: counts.entregado },
      ];
    }
  }
}
</script>
