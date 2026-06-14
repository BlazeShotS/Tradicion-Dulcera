<div class="flex min-h-[calc(100vh-5rem)]">
  <?php require __DIR__ . '/_sidebar.php'; ?>

  <div class="w-full lg:w-[80%] p-6 lg:p-10"
       x-data="panelMozoModal()">

    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
      <div>
        <h1 class="text-3xl font-serif font-bold text-[#2A1B14]">Pedidos Pendientes</h1>
        <p class="text-[#2A1B14]/60 text-sm mt-1">Gestiona las comandas de los clientes</p>
      </div>
      <div class="bg-gray-100 rounded-xl px-5 py-3 text-center" aria-live="polite">
        <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider">Tiempo Promedio</p>
        <p class="text-2xl font-bold text-[#2A1B14]">
          <?php
          $totalTiempo = array_sum(array_column($comandasPendientes, 'tiempo'));
          $promedio = count($comandasPendientes) > 0 ? round($totalTiempo / count($comandasPendientes)) : 0;
          echo $promedio . ' min';
          ?>
        </p>
      </div>
    </div>

    <?php
    $modalObservaciones = false;
    require __DIR__ . '/_modal-confirmacion.php';
    ?>

    <?php if (count($comandasPendientes) > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" role="list">
      <?php foreach ($comandasPendientes as $comanda): ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300" role="listitem">
        <form method="POST" action="<?= url('/panel-mozo/mover') ?>" id="form-<?= $comanda['id'] ?>">
          <input type="hidden" name="comanda_id" value="<?= $comanda['id'] ?>">

          <div class="flex items-center justify-between mb-4">
            <div>
              <span class="text-xs text-[#2A1B14]/50 font-medium">Mesa</span>
              <p class="text-2xl font-bold text-[#2A1B14]"><?= $comanda['mesa'] > 0 ? '#' . $comanda['mesa'] : 'Delivery' ?></p>
            </div>
            <div class="text-right">
              <span class="text-xs text-[#2A1B14]/50 font-medium">Cliente</span>
              <p class="text-sm font-semibold text-[#2A1B14]"><?= htmlspecialchars($comanda['cliente']) ?></p>
            </div>
          </div>

          <div class="p-3 rounded-xl mb-4 <?= $comanda['tiempo'] > 20 ? 'bg-red-50' : 'bg-gray-50' ?>">
            <div class="flex items-center gap-2">
              <span class="text-xs text-[#2A1B14]/50">Pedido hace</span>
              <span class="font-bold text-sm <?= $comanda['tiempo'] > 20 ? 'text-red-500' : 'text-[#2A1B14]' ?>"><?= $comanda['tiempo'] ?> min</span>
              <?php if ($comanda['tiempo'] > 20): ?>
                <span class="text-red-500 text-xs font-bold">! Retraso</span>
              <?php endif; ?>
            </div>
            <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
              <div class="h-1.5 rounded-full transition-all duration-500 <?= $comanda['tiempo'] > 20 ? 'bg-red-500' : ($comanda['tiempo'] > 10 ? 'bg-amber-400' : 'bg-green-500') ?>" style="width:<?= min(100, ($comanda['tiempo'] / 30) * 100) ?>%"></div>
            </div>
          </div>

          <div class="space-y-2 mb-6">
            <?php foreach ($comanda['items'] as $item): ?>
            <div class="p-2.5 rounded-lg bg-gray-50 border border-gray-100">
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-[#2A1B14]"><?= (int)$item['cantidad'] ?>× <?= htmlspecialchars($item['nombre']) ?></span>
                <?php if (!empty($item['variante'])): ?>
                  <span class="text-xs text-[#C5A059]"><?= htmlspecialchars($item['variante']) ?></span>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <button type="button"
                  @click="confirmar('<?= $comanda['id'] ?>', '<?= htmlspecialchars($comanda['cliente'], ENT_QUOTES) ?>', <?= count($comanda['items']) ?>)"
                  class="w-full py-3 rounded-full font-semibold text-sm tracking-wide btn-chocolate hover:shadow-lg transition-all flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:ring-offset-2">
            <span>Mover a Preparación →</span>
          </button>
        </form>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
      <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
      <p class="text-lg font-serif font-bold text-[#2A1B14]">No hay pedidos pendientes</p>
      <p class="text-sm text-[#2A1B14]/50 mt-1">Los nuevos pedidos de los clientes aparecerán aquí.</p>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
function panelMozoModal() {
  return {
    confirmacion: {
      open: false,
      titulo: '',
      mensaje: '',
      formId: '',
      btnClass: 'btn-chocolate',
      btnText: 'Sí, mover a cocina'
    },
    confirmar(id, cliente, items) {
      this.confirmacion = {
        open: true,
        titulo: '¿Mover a preparación?',
        mensaje: 'Pedido #' + id + ' — ' + cliente + ' (' + items + ' producto(s))',
        formId: 'form-' + id,
        btnClass: 'btn-chocolate',
        btnText: 'Sí, mover a cocina'
      };
    },
    confirmarAccion() {
      document.getElementById(this.confirmacion.formId).submit();
      this.confirmacion.open = false;
    }
  }
}
</script>
