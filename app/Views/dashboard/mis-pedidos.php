<div class="bg-[#FDFBF7] min-h-screen p-8 md:p-12"
     x-data="misPedidos()">

  <!-- BLOQUE A: ENCABEZADO -->
  <div class="flex flex-col gap-1 mb-8 text-left max-w-7xl mx-auto w-full px-4">
    <h1 class="font-serif text-3xl font-semibold text-[#2C1A14]">Mis Pedidos</h1>
    <p class="font-sans text-sm text-gray-500 tracking-wide">Sigue el rastro de tus dulces momentos y el legado de nuestra tradición.</p>
  </div>

  <template x-if="pedidos.length === 0">
    <div class="max-w-7xl mx-auto w-full px-4">
      <div class="text-center bg-white rounded-2xl shadow-sm py-20 px-8">
        <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p class="text-xl font-serif font-bold text-[#2C1A14] mt-4">No hay pedidos</p>
        <p class="text-[#2C1A14]/50 text-sm mt-2">Aún no has realizado ningún pedido</p>
        <a href="<?= url('/carta') ?>" class="inline-block mt-6 px-8 py-3 rounded-full font-semibold text-sm btn-primary hover:shadow-lg transition-all">Ir a la Carta</a>
      </div>
    </div>
  </template>

  <template x-if="pedidos.length > 0">
    <div>

      <!-- BLOQUE B: PEDIDOS EN CURSO -->
      <div class="flex flex-col gap-4 mb-10 max-w-7xl mx-auto w-full px-4" x-show="activos.length > 0">
        <div class="flex items-center justify-between">
          <h2 class="font-sans text-base font-semibold text-[#2C1A14]">Pedidos en curso</h2>
          <span class="rounded-full bg-orange-100 text-orange-600 text-[10px] font-bold tracking-wider px-2.5 py-0.5 uppercase" x-text="activos.length + ' ACTIVOS'"></span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full items-stretch">

          <!-- TARJETA 1: Primer pedido activo (2 columnas) -->
          <template x-if="activos[0]">
            <div class="md:col-span-2 bg-white rounded-xl shadow-sm p-6 flex flex-col sm:flex-row gap-6 items-center sm:items-stretch">
              <div class="w-full sm:w-1/3 aspect-[4/3] sm:aspect-square rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 flex items-center justify-center">
                <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
              </div>
              <div class="w-full sm:w-2/3 flex flex-col justify-between">
                <div>
                  <div class="flex items-center justify-between w-full">
                    <span class="text-xs text-gray-400 tracking-wider font-mono" x-text="'ORDEN #TD-' + activos[0].id"></span>
                    <span class="rounded-full text-[10px] font-semibold px-2 py-0.5 flex items-center gap-1 uppercase tracking-wider"
                          :class="estadoBadgeClass(activos[0].estado)">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                      <span x-text="estadoLabel(activos[0].estado)"></span>
                    </span>
                  </div>
                  <h3 class="font-sans text-xl font-bold text-[#2C1A14] mt-2" x-text="primerItem(activos[0])"></h3>
                  <ul class="mt-2 space-y-1 text-sm text-gray-500 font-sans list-none pl-0">
                    <template x-for="item in activos[0].items" :key="item.nombre + item.id">
                      <li x-text="'• ' + item.cantidad + 'x ' + item.nombre"></li>
                    </template>
                  </ul>
                </div>
                <div class="flex items-end justify-between mt-6 w-full">
                  <div class="flex flex-col">
                    <span class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Entrega Estimada</span>
                    <span class="text-xl font-extrabold text-[#2C1A14]" x-text="formatTime(activos[0].created_at, activos[0].tiempo)"></span>
                  </div>
                  <button @click="abrirDetalle(activos[0])" class="px-5 py-2.5 bg-[#2C1A14] hover:bg-opacity-95 text-white text-xs font-semibold rounded-md transition-colors duration-200 shadow-sm">Ver Detalles</button>
                </div>
              </div>
            </div>
          </template>

          <!-- TARJETA 2: Segundo pedido activo (1 columna) -->
          <template x-if="activos[1]">
            <div class="md:col-span-1 bg-white rounded-xl shadow-sm p-6 flex flex-col justify-between items-start">
              <span class="rounded-full text-[10px] font-bold px-3 py-0.5 mb-3 uppercase tracking-wider"
                    :class="estadoBadgeClass(activos[1].estado)"
                    x-text="estadoLabel(activos[1].estado)"></span>
              <div>
                <h3 class="font-sans text-base font-bold text-[#2C1A14] leading-snug mb-1" x-text="primerItem(activos[1])"></h3>
                <p class="text-xs text-gray-400 font-sans font-normal leading-relaxed" x-text="descripcionItem(activos[1])"></p>
              </div>
              <div class="w-full bg-gray-50 rounded-lg p-3 flex flex-col gap-1 mt-6">
                <span class="text-[9px] text-gray-400 font-bold tracking-wider uppercase">Punto de Recojo</span>
                <div class="flex items-center gap-2">
                  <svg class="w-4 h-4 text-orange-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                  <span class="text-xs font-bold text-gray-700 font-sans" x-text="ubicacionMesa(activos[1])"></span>
                </div>
              </div>
            </div>
          </template>

        </div>
      </div>

      <!-- BLOQUE C: HISTORIAL DE PEDIDOS -->
      <div class="flex flex-col gap-4 max-w-7xl mx-auto w-full px-4" x-show="historial.length > 0">
        <div class="flex items-center justify-between">
          <h2 class="font-sans text-base font-semibold text-[#2C1A14]">Historial de Pedidos</h2>
          <div class="relative" @click.outside="mesOpen = false">
            <button @click="toggleMesDropdown()" class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-md text-xs font-medium font-sans transition-colors">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
              <span x-text="mesSeleccionado === 'todos' ? 'Filtrar por Mes' : mesesLabel"></span>
              <svg class="w-3 h-3 transition-transform" :class="mesOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="mesOpen" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-20">
              <button @click="seleccionarMes('todos')" class="w-full text-left px-4 py-2 text-xs font-sans transition-colors"
                      :class="mesSeleccionado === 'todos' ? 'text-[#2C1A14] font-bold bg-gray-50' : 'text-gray-600 hover:bg-gray-50'">
                Todos los meses
              </button>
              <template x-for="m in mesesUnicos" :key="m.key">
                <button @click="seleccionarMes(m.key)" class="w-full text-left px-4 py-2 text-xs font-sans transition-colors"
                        :class="mesSeleccionado === m.key ? 'text-[#2C1A14] font-bold bg-gray-50' : 'text-gray-600 hover:bg-gray-50'"
                        x-text="m.label"></button>
              </template>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden p-6 flex flex-col gap-0">
          <template x-for="(pedido, index) in historialFiltrado" :key="pedido.id">
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between py-5 border-b border-gray-100 last:border-0 last:pb-0 first:pt-0 gap-4">
              <div class="md:grid md:grid-cols-12 md:gap-4 w-full items-center">
                <div class="md:col-span-1 hidden md:block">
                  <div class="w-12 h-12 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center">
                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                  </div>
                </div>
                <div class="md:col-span-2 flex flex-col md:block">
                  <span class="text-[10px] text-gray-400 font-bold tracking-wider font-sans md:hidden">FECHA</span>
                  <div class="flex items-center gap-2 md:block">
                    <div class="md:hidden w-8 h-8 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center">
                      <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-800 font-sans" x-text="formatDateShort(pedido.created_at)"></span>
                  </div>
                </div>
                <div class="md:col-span-3 flex flex-col">
                  <span class="text-[10px] text-gray-400 font-bold tracking-wider font-sans">PEDIDO</span>
                  <span class="text-xs font-medium text-gray-700 font-sans" x-text="nombresItems(pedido.items)"></span>
                </div>
                <div class="md:col-span-2 flex flex-col">
                  <span class="text-[10px] text-gray-400 font-bold tracking-wider font-sans">TOTAL</span>
                  <span class="text-xs font-bold text-[#2C1A14] font-sans" x-text="'S/ ' + pedido.total.toFixed(2)"></span>
                </div>
                <div class="md:col-span-2 flex flex-col">
                  <span class="text-[10px] text-gray-400 font-bold tracking-wider font-sans">ESTADO</span>
                  <span class="text-xs font-medium text-gray-600 font-sans" x-text="estadoLabel(pedido.estado)"></span>
                </div>
                <div class="md:col-span-2 text-right">
                  <a href="<?= url('/carta') ?>"
                     class="text-xs font-bold text-[#2C1A14] font-sans tracking-wider border-b border-[#2C1A14] pb-0.5 uppercase hover:text-opacity-80 hover:border-opacity-80 transition-all inline-block md:ml-auto w-max">
                    Pedir de Nuevo
                  </a>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>

    </div>
  </template>

  <!-- MODAL: DETALLE DEL PEDIDO -->
  <div x-show="detalle !== null" x-cloak
       @keydown.window.escape="cerrarDetalle()"
       class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
       role="dialog" aria-modal="true" aria-label="Detalle del pedido">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto" @click.outside="cerrarDetalle()">
      <div class="p-6 md:p-8">
        <div class="flex items-center justify-between mb-6">
          <span class="text-xs text-gray-400 tracking-wider font-mono" x-text="'ORDEN #TD-' + detalle?.id"></span>
          <button @click="cerrarDetalle()" class="p-1 hover:bg-gray-100 rounded-full transition-colors" aria-label="Cerrar">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="flex items-center gap-2 mb-6">
          <span class="rounded-full text-[10px] font-semibold px-2.5 py-1 uppercase tracking-wider"
                :class="estadoBadgeClass(detalle?.estado)"
                x-text="estadoLabel(detalle?.estado)"></span>
          <span class="text-xs text-gray-400 font-sans" x-text="formatDateShort(detalle?.created_at)"></span>
        </div>

        <div class="border-t border-gray-100 pt-4">
          <h4 class="text-xs text-gray-400 font-bold tracking-wider uppercase mb-3 font-sans">Artículos</h4>
          <template x-for="item in detalle?.items || []" :key="item.nombre + item.id">
            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
              <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-md bg-gray-100 flex items-center justify-center text-xs text-gray-500 font-bold" x-text="item.cantidad"></span>
                <div>
                  <p class="text-sm font-medium text-[#2C1A14] font-sans" x-text="item.nombre"></p>
                  <template x-if="item.variante">
                    <p class="text-xs text-gray-400 font-sans" x-text="item.variante"></p>
                  </template>
                </div>
              </div>
            </div>
          </template>
        </div>

        <div class="border-t border-gray-100 pt-4 mt-4">
          <div class="flex justify-between items-center">
            <span class="text-sm font-semibold text-[#2C1A14] font-sans">Total</span>
            <span class="text-xl font-extrabold text-[#2C1A14]" x-text="'S/ ' + (detalle?.total || 0).toFixed(2)"></span>
          </div>
        </div>

        <div class="bg-gray-50 rounded-xl p-4 flex flex-col gap-2 mt-6">
          <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-[#2C1A14]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
              <span class="text-[9px] text-gray-400 font-bold tracking-wider uppercase font-sans">Entrega Estimada</span>
              <p class="text-sm font-bold text-[#2C1A14] font-sans" x-text="formatTime(detalle?.created_at, detalle?.tiempo)"></p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <div>
              <span class="text-[9px] text-gray-400 font-bold tracking-wider uppercase font-sans">Punto de Recojo</span>
              <p class="text-sm font-bold text-gray-700 font-sans" x-text="ubicacionMesa(detalle)"></p>
            </div>
          </div>
        </div>

        <button @click="cerrarDetalle()"
                class="w-full mt-6 py-3 bg-[#2C1A14] hover:bg-opacity-95 text-white text-sm font-semibold rounded-lg transition-colors duration-200 shadow-sm">
          Cerrar
        </button>
      </div>
    </div>
  </div>

</div>

<script>
function misPedidos() {
  return {
    pedidos: <?= json_encode($comandas) ?>,
    detalle: null,
    mesSeleccionado: 'todos',
    mesOpen: false,
    get activos() {
      return this.pedidos.filter(p => ['pendiente', 'preparacion', 'listo'].includes(p.estado));
    },
    get historial() {
      return this.pedidos.filter(p => p.estado === 'entregado');
    },
    get mesesUnicos() {
      const map = new Map();
      this.historial.forEach(p => {
        if (!p.created_at) return;
        const d = new Date(p.created_at);
        const key = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0');
        if (!map.has(key)) {
          map.set(key, d.toLocaleDateString('es-PE', { month: 'long', year: 'numeric' }));
        }
      });
      return Array.from(map.entries())
        .map(([key, label]) => ({ key, label }))
        .sort((a, b) => b.key.localeCompare(a.key));
    },
    get mesesLabel() {
      const m = this.mesesUnicos.find(m => m.key === this.mesSeleccionado);
      return m ? m.label : '';
    },
    get historialFiltrado() {
      if (this.mesSeleccionado === 'todos') return this.historial;
      return this.historial.filter(p => {
        if (!p.created_at) return false;
        const d = new Date(p.created_at);
        const key = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0');
        return key === this.mesSeleccionado;
      });
    },
    estadoLabel(estado) {
      const labels = { pendiente: 'Pendiente', preparacion: 'En Preparación', listo: 'Listo', entregado: 'Entregado' };
      return labels[estado] || estado;
    },
    estadoBadgeClass(estado) {
      const map = {
        pendiente: 'bg-amber-50 text-amber-600',
        preparacion: 'bg-green-50 text-green-600',
        listo: 'bg-purple-50 text-purple-600',
        entregado: 'bg-gray-50 text-gray-500'
      };
      return map[estado] || 'bg-gray-100 text-gray-600';
    },
    abrirDetalle(pedido) {
      this.detalle = pedido;
    },
    cerrarDetalle() {
      this.detalle = null;
    },
    toggleMesDropdown() {
      this.mesOpen = !this.mesOpen;
    },
    seleccionarMes(key) {
      this.mesSeleccionado = key;
      this.mesOpen = false;
    },
    primerItem(pedido) {
      if (!pedido.items || pedido.items.length === 0) return 'Producto';
      return pedido.items[0].nombre;
    },
    descripcionItem(pedido) {
      if (!pedido.items || pedido.items.length === 0) return '';
      const item = pedido.items[0];
      return item.variante || item.nombre;
    },
    nombresItems(items) {
      if (!items || items.length === 0) return 'Producto';
      return items.map(i => i.cantidad + 'x ' + i.nombre).join(', ');
    },
    ubicacionMesa(pedido) {
      const mesa = parseInt(pedido.mesa);
      if (mesa > 0) return 'Mesa #' + mesa;
      return 'Local Principal';
    },
    formatDateShort(dateStr) {
      if (!dateStr) return '';
      const d = new Date(dateStr);
      return d.toLocaleDateString('es-PE', { day: 'numeric', month: 'long', year: 'numeric' }) +
             ' - ' + d.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });
    },
    formatTime(dateStr, extraMin) {
      if (!dateStr) return '--:--';
      const d = new Date(dateStr);
      d.setMinutes(d.getMinutes() + (extraMin || 0));
      return d.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });
    }
  }
}
</script>
