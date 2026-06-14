<div class="flex min-h-[calc(100vh-5rem)]">
  <?php require __DIR__ . '/../_sidebar.php'; ?>

  <div class="w-full lg:w-[80%] p-6 lg:p-10"
       x-data="historialEntregas()">

    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
      <div>
        <h1 class="text-3xl font-serif font-bold text-[#2A1B14]">Historial de Entregas</h1>
        <p class="text-[#2A1B14]/60 text-sm mt-1">Consulta y exporta el registro de todas las entregas realizadas</p>
      </div>
      <div class="flex items-center gap-3">
        <button @click="exportCSV()" class="px-4 py-2 rounded-full text-sm font-medium border border-gray-200 text-[#2A1B14]/70 hover:bg-gray-50 transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059] flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          Exportar CSV
        </button>
      </div>
    </div>

    <?php // ——— KPI CARDS ——— ?>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8" aria-live="polite">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Entregas hoy</p>
        <p class="text-3xl font-bold text-[#2A1B14]" x-text="stats.hoy.total">0</p>
      </div>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Esta semana</p>
        <p class="text-3xl font-bold text-[#2A1B14]" x-text="stats.semana">0</p>
      </div>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Mejor mozo</p>
        <p class="text-lg font-bold text-[#2A1B14]" x-text="stats.topMozo ? stats.topMozo.nombre + ' (' + stats.topMozo.total + ')' : '—'"></p>
      </div>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Tiempo promedio</p>
        <p class="text-3xl font-bold text-[#2A1B14]" x-text="stats.tiempoPromedio + ' min'">0 min</p>
      </div>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Ingresos hoy</p>
        <p class="text-3xl font-bold text-[#2A1B14]">S/ <span x-text="stats.hoy.ingresos.toFixed(2)">0.00</span></p>
      </div>
    </div>

    <?php // ——— FILTROS ——— ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
          <label for="filtro-q" class="block text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Buscar</label>
          <input id="filtro-q" type="text" x-model="filtros.q" @input.debounce="buscar()" placeholder="Cliente o # pedido"
                 class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:border-transparent bg-gray-50"
                 aria-label="Buscar por cliente o número de pedido">
        </div>
        <div>
          <label for="filtro-desde" class="block text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Desde</label>
          <input id="filtro-desde" type="date" x-model="filtros.desde" @change="buscar()"
                 class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:border-transparent bg-gray-50">
        </div>
        <div>
          <label for="filtro-hasta" class="block text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Hasta</label>
          <input id="filtro-hasta" type="date" x-model="filtros.hasta" @change="buscar()"
                 class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:border-transparent bg-gray-50">
        </div>
        <div>
          <label for="filtro-mozo" class="block text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Mozo</label>
          <select id="filtro-mozo" x-model="filtros.entregado_por" @change="buscar()"
                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:border-transparent bg-gray-50">
            <option value="">Todos</option>
            <?php foreach ($usuarios as $u): ?>
              <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?> (<?= htmlspecialchars($u['rol']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="flex justify-end mt-3">
        <button @click="limpiarFiltros()" class="text-sm text-[#2A1B14]/50 hover:text-[#C5A059] transition-colors focus:outline-none focus:ring-2 focus:ring-[#C5A059] rounded-lg px-3 py-1">
          Limpiar filtros
        </button>
      </div>
    </div>

    <?php // ——— TABLA ——— ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm" role="table" aria-label="Lista de entregas realizadas">
          <thead>
            <tr class="border-b border-gray-100 bg-gray-50/50">
              <th class="text-left px-5 py-4 text-xs text-[#2A1B14]/50 uppercase tracking-wider font-medium" scope="col">#</th>
              <th class="text-left px-5 py-4 text-xs text-[#2A1B14]/50 uppercase tracking-wider font-medium" scope="col">Mesa</th>
              <th class="text-left px-5 py-4 text-xs text-[#2A1B14]/50 uppercase tracking-wider font-medium" scope="col">Cliente</th>
              <th class="text-left px-5 py-4 text-xs text-[#2A1B14]/50 uppercase tracking-wider font-medium" scope="col">Items</th>
              <th class="text-right px-5 py-4 text-xs text-[#2A1B14]/50 uppercase tracking-wider font-medium" scope="col">Total</th>
              <th class="text-left px-5 py-4 text-xs text-[#2A1B14]/50 uppercase tracking-wider font-medium" scope="col">Entregado por</th>
              <th class="text-left px-5 py-4 text-xs text-[#2A1B14]/50 uppercase tracking-wider font-medium" scope="col">Fecha / Hora</th>
              <th class="text-left px-5 py-4 text-xs text-[#2A1B14]/50 uppercase tracking-wider font-medium" scope="col">Obs.</th>
            </tr>
          </thead>
          <tbody>
            <template x-for="(item, idx) in items" :key="item.id">
              <tr @click="verDetalle(item.id)" tabindex="0" @keydown.enter="verDetalle(item.id)"
                  class="border-b border-gray-50 hover:bg-[#FDFBF7] cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#C5A059]"
                  :class="idx % 2 === 0 ? 'bg-white' : 'bg-gray-50/30'"
                  role="row">
                <td class="px-5 py-4 font-medium text-[#2A1B14]/40" x-text="item.id"></td>
                <td class="px-5 py-4 font-semibold text-[#2A1B14]">
                  <span x-text="item.mesa > 0 ? '#' + item.mesa : 'Delivery'"></span>
                  <template x-if="item.vip">
                    <span class="ml-1 text-[10px] bg-[#C5A059]/10 text-[#C5A059] px-1.5 py-0.5 rounded-full font-bold">VIP</span>
                  </template>
                </td>
                <td class="px-5 py-4 text-[#2A1B14]" x-text="item.cliente"></td>
                <td class="px-5 py-4">
                  <span class="text-[#2A1B14]/70 text-xs" x-text="(item.items || []).map(i => i.cantidad + '× ' + i.nombre).join(', ').substring(0, 40) + ((item.items || []).map(i => i.cantidad + '× ' + i.nombre).join(', ').length > 40 ? '…' : '')"></span>
                </td>
                <td class="px-5 py-4 text-right font-semibold text-[#2A1B14]">S/ <span x-text="parseFloat(item.total).toFixed(2)"></span></td>
                <td class="px-5 py-4">
                  <span class="inline-flex items-center gap-1.5">
                    <span class="w-6 h-6 rounded-full bg-[#C5A059]/20 text-[#C5A059] flex items-center justify-center text-[10px] font-bold" x-text="(item.entregado_por_nombre || '—').charAt(0).toUpperCase()"></span>
                    <span x-text="item.entregado_por_nombre || '—'"></span>
                  </span>
                </td>
                <td class="px-5 py-4 text-[#2A1B14]/70 text-xs whitespace-nowrap" x-text="formatearFecha(item.entregado_at)"></td>
                <td class="px-5 py-4 text-[#2A1B14]/40 text-xs italic" x-text="item.observaciones || '—'"></td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>

      <template x-if="items.length === 0 && !cargando">
        <div class="text-center py-16">
          <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <p class="text-lg font-serif font-bold text-[#2A1B14]">No se encontraron entregas</p>
          <p class="text-sm text-[#2A1B14]/50 mt-1">Intenta ajustar los filtros o confirma una entrega para verla aquí.</p>
        </div>
      </template>

      <template x-if="cargando">
        <div class="text-center py-16">
          <svg class="w-8 h-8 mx-auto animate-spin text-[#C5A059]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
          <p class="text-sm text-[#2A1B14]/50 mt-2">Cargando historial…</p>
        </div>
      </template>

      <?php // ——— PAGINACIÓN ——— ?>
      <div class="flex items-center justify-between px-5 py-4 border-t border-gray-100" x-show="totalPages > 1">
        <p class="text-xs text-[#2A1B14]/50">
          Página <span x-text="page"></span> de <span x-text="totalPages"></span> · <span x-text="total"></span> resultados
        </p>
        <nav class="flex items-center gap-1" aria-label="Paginación del historial">
          <button @click="irPagina(1)" :disabled="page <= 1"
                  class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                  aria-label="Primera página">«</button>
          <button @click="irPagina(page - 1)" :disabled="page <= 1"
                  class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                  aria-label="Página anterior">‹</button>
          <template x-for="p in paginasVisibles" :key="p">
            <button @click="irPagina(p)"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                    :class="p === page ? 'bg-[#2A1B14] text-white' : 'hover:bg-gray-100 text-[#2A1B14]/70'"
                    x-text="p"
                    :aria-label="'Ir a página ' + p"
                    :aria-current="p === page ? 'page' : false"></button>
          </template>
          <button @click="irPagina(page + 1)" :disabled="page >= totalPages"
                  class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                  aria-label="Página siguiente">›</button>
          <button @click="irPagina(totalPages)" :disabled="page >= totalPages"
                  class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#C5A059]"
                  aria-label="Última página">»</button>
        </nav>
      </div>
    </div>

    <?php // ——— MODAL DE DETALLE ——— ?>
    <div x-show="detalle.open" x-cloak
         @keydown.window.escape="detalle.open = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
         role="dialog" aria-modal="true" aria-label="Detalle de entrega">
      <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto" @click.outside="detalle.open = false">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
          <h2 class="text-xl font-serif font-bold text-[#2A1B14]">Entrega #<span x-text="detalle.id"></span></h2>
          <button @click="detalle.open = false" class="text-[#2A1B14]/60 hover:text-[#2A1B14] focus:outline-none focus:ring-2 focus:ring-[#C5A059] rounded-lg p-1" aria-label="Cerrar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
        <div class="p-6 space-y-5">
          <div class="flex items-center gap-4">
            <div class="flex-1">
              <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider">Mesa</p>
              <p class="text-2xl font-bold text-[#2A1B14]" x-text="detalle.mesa > 0 ? '#' + detalle.mesa : 'Delivery'"></p>
            </div>
            <div class="flex-1 text-right">
              <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider">Cliente</p>
              <p class="text-lg font-semibold text-[#2A1B14]" x-text="detalle.cliente"></p>
              <template x-if="detalle.vip">
                <span class="text-xs bg-[#C5A059]/10 text-[#C5A059] px-2 py-0.5 rounded-full font-bold">VIP</span>
              </template>
            </div>
          </div>
          <div>
            <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-2">Items</p>
            <div class="space-y-2">
              <template x-for="item in (detalle.items || [])" :key="item.nombre">
                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-gray-50">
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
          </div>
          <div class="border-t border-gray-100 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
              <span class="text-[#2A1B14]/60">Total</span>
              <span class="font-bold text-[#2A1B14]">S/ <span x-text="parseFloat(detalle.total).toFixed(2)"></span></span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-[#2A1B14]/60">Entregado por</span>
              <span class="font-medium text-[#2A1B14]" x-text="detalle.entregado_por_nombre || '—'"></span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-[#2A1B14]/60">Fecha y hora</span>
              <span class="font-medium text-[#2A1B14]" x-text="formatearFecha(detalle.entregado_at)"></span>
            </div>
            <div class="flex justify-between text-sm" x-show="detalle.observaciones">
              <span class="text-[#2A1B14]/60">Observaciones</span>
              <span class="font-medium text-[#2A1B14] italic" x-text="detalle.observaciones"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function historialEntregas() {
  return {
    items: [],
    total: 0,
    page: 1,
    totalPages: 1,
    cargando: true,
    stats: <?= json_encode($stats) ?>,
    filtros: { q: '', desde: '', hasta: '', entregado_por: '' },
    detalle: { open: false, id: null, mesa: 0, cliente: '', items: [], total: 0, entregado_por_nombre: '', entregado_at: '', observaciones: '', vip: false },
    init() {
      this.cargarPagina(1);
    },
    async cargarPagina(p) {
      this.cargando = true;
      this.page = p;
      const params = new URLSearchParams({ page: p, q: this.filtros.q });
      if (this.filtros.desde) params.set('desde', this.filtros.desde);
      if (this.filtros.hasta) params.set('hasta', this.filtros.hasta);
      if (this.filtros.entregado_por) params.set('entregado_por', this.filtros.entregado_por);
      try {
        const res = await fetch('<?= url('/admin/api/historial-entregas') ?>?' + params.toString());
        const data = await res.json();
        this.items = data.data || [];
        this.total = data.total || 0;
        this.totalPages = data.lastPage || 1;
      } catch {
        window.notifyError('Error al cargar el historial');
      } finally {
        this.cargando = false;
      }
    },
    buscar() { this.cargarPagina(1); },
    limpiarFiltros() {
      this.filtros = { q: '', desde: '', hasta: '', entregado_por: '' };
      this.cargarPagina(1);
    },
    irPagina(p) {
      if (p < 1 || p > this.totalPages) return;
      this.cargarPagina(p);
    },
    get paginasVisibles() {
      const pages = [];
      let start = Math.max(1, this.page - 2);
      let end = Math.min(this.totalPages, this.page + 2);
      for (let i = start; i <= end; i++) pages.push(i);
      return pages;
    },
    async verDetalle(id) {
      try {
        const res = await fetch('<?= url('/admin/api/historial-entregas/detalle') ?>?id=' + id);
        const data = await res.json();
        if (data && data.id) {
          this.detalle = { open: true, ...data };
        } else {
          window.notifyError('No se encontró el detalle');
        }
      } catch {
        window.notifyError('Error al cargar detalle');
      }
    },
    formatearFecha(fecha) {
      if (!fecha) return '—';
      const d = new Date(fecha);
      return d.toLocaleDateString('es-PE', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    },
    exportCSV() {
      if (!this.items.length) { window.notifyError('No hay datos para exportar'); return; }
      let csv = "ID,Mesa,Cliente,Items,Total,Entregado por,Fecha,Observaciones\n";
      this.items.forEach(i => {
        const itemsStr = (i.items || []).map(it => it.cantidad + 'x ' + it.nombre).join('; ');
        csv += `${i.id},${i.mesa > 0 ? '#' + i.mesa : 'Delivery'},"${i.cliente}","${itemsStr}",S/${parseFloat(i.total).toFixed(2)},"${i.entregado_por_nombre || '—'}","${this.formatearFecha(i.entregado_at)}","${i.observaciones || ''}"\n`;
      });
      const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
      const link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = 'historial-entregas.csv';
      link.click();
      URL.revokeObjectURL(link.href);
      window.notifySuccess('CSV exportado correctamente');
    }
  }
}
</script>
