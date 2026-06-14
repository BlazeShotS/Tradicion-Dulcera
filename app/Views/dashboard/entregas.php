<?php
$totalTiempoListos = array_sum(array_column($comandasListas, 'tiempo'));
$promedioListos = count($comandasListas) > 0 ? round($totalTiempoListos / count($comandasListas)) : 0;
?>
<div class="flex min-h-[calc(100vh-5rem)]">
  <?php require __DIR__ . '/_sidebar.php'; ?>

  <div class="w-full lg:w-[80%] p-6 lg:p-10"
       x-data="despachoModal()">

    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-3xl font-serif font-bold text-[#2A1B14]">Órdenes para Entrega</h1>
        <p class="text-[#2A1B14]/60 text-sm mt-1">Confirma la entrega de pedidos listos</p>
      </div>
    </div>

    <?php
    $modalObservaciones = true;
    require __DIR__ . '/_modal-confirmacion.php';
    ?>

    <?php if (count($comandasListas) > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10" role="list">
      <?php foreach ($comandasListas as $comanda): ?>
      <div class="rounded-2xl shadow-sm border p-6 transition-all duration-300 <?= !empty($comanda['vip']) ? 'bg-[#2A1B14] text-white' : 'bg-white border-gray-100 text-[#2A1B14]' ?>" role="listitem">
        <form method="POST" action="<?= url('/entregas/confirmar') ?>" id="form-<?= $comanda['id'] ?>">
          <input type="hidden" name="comanda_id" value="<?= $comanda['id'] ?>">
          <input type="hidden" name="observaciones" id="obs-<?= $comanda['id'] ?>" value="">

          <div class="flex items-center justify-between mb-4">
            <div>
              <span class="text-xs opacity-50 font-medium">Mesa</span>
              <p class="text-2xl font-bold <?= !empty($comanda['vip']) ? 'text-white' : 'text-[#2A1B14]' ?>"><?= $comanda['mesa'] > 0 ? '#' . $comanda['mesa'] : 'Delivery' ?></p>
            </div>
            <div class="text-right">
              <span class="text-xs opacity-50 font-medium">Cliente</span>
              <p class="text-sm font-semibold"><?= htmlspecialchars($comanda['cliente']) ?></p>
              <?php if (!empty($comanda['vip'])): ?>
                <span class="text-xs bg-[#C5A059]/20 text-[#C5A059] px-2 py-0.5 rounded-full font-bold">VIP</span>
              <?php endif; ?>
            </div>
          </div>

          <div class="p-3 rounded-xl mb-4 <?= !empty($comanda['vip']) ? 'bg-white/10' : 'bg-gray-50' ?>">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <span class="text-xs opacity-50">Pedido hace</span>
              <span class="font-bold text-sm"><?= $comanda['tiempo'] ?> min</span>
            </div>
          </div>

          <div class="space-y-2 mb-6">
            <?php foreach ($comanda['items'] as $item): ?>
            <div class="p-2.5 rounded-lg <?= !empty($comanda['vip']) ? 'bg-white/10' : 'bg-gray-50 border border-gray-100' ?>">
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium"><?= (int)$item['cantidad'] ?>× <?= htmlspecialchars($item['nombre']) ?></span>
                <?php if (!empty($item['variante'])): ?>
                  <span class="text-xs text-[#C5A059]"><?= htmlspecialchars($item['variante']) ?></span>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <button type="button"
                  @click="confirmar('<?= $comanda['id'] ?>', <?= $comanda['mesa'] ?>, '<?= htmlspecialchars($comanda['cliente'], ENT_QUOTES) ?>', <?= count($comanda['items']) ?>, <?= !empty($comanda['vip']) ? 'true' : 'false' ?>)"
                  class="w-full py-3 rounded-full font-semibold text-sm tracking-wide transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-offset-2 <?= !empty($comanda['vip']) ? 'btn-vip' : 'btn-success' ?>">
            <span class="flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              <span><?= !empty($comanda['vip']) ? 'Confirmar Entrega VIP' : 'Confirmar Entrega' ?></span>
            </span>
          </button>

        </form>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
      <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2-1m6 0l2-1m-2 1v2a1 1 0 001 1h3M7 16v2a1 1 0 001 1h3m-6-6h6m4 0h3a1 1 0 001 1h-1m-6 0a2 2 0 100 4m0-4a2 2 0 110 4"/></svg>
      <p class="text-lg font-serif font-bold text-[#2A1B14]">No hay órdenes para entregar</p>
      <p class="text-sm text-[#2A1B14]/50 mt-1">Cuando la cocina marque pedidos como listos, aparecerán aquí.</p>
    </div>
    <?php endif; ?>

    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
        <div aria-live="polite">
          <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Listos para entregar</p>
          <p class="text-4xl font-bold text-[#2A1B14]"><?= count($comandasListas) ?></p>
        </div>
        <div aria-live="polite">
          <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Minutos promedio</p>
          <p class="text-4xl font-bold text-[#2A1B14]"><?= $promedioListos ?> min</p>
        </div>
        <div aria-live="polite">
          <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Calificación del servicio</p>
          <p class="text-4xl font-bold text-[#C5A059] flex items-center justify-center gap-1">
            <span>4.8</span>
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
          </p>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
function despachoModal() {
  return {
    confirmacion: {
      open: false,
      titulo: '',
      mensaje: '',
      formId: '',
      observaciones: '',
      btnClass: 'btn-success',
      btnText: 'Sí, entregar'
    },
    confirmar(id, mesa, cliente, items, vip) {
      this.confirmacion = {
        open: true,
        titulo: '¿Confirmar entrega?',
        mensaje: 'Pedido #' + id + ' — Mesa ' + (mesa > 0 ? '#' + mesa : 'Delivery') + ' — ' + cliente + ' (' + items + ' producto(s))',
        formId: 'form-' + id,
        observaciones: '',
        btnClass: vip ? 'btn-vip' : 'btn-success',
        btnText: vip ? 'Sí, entregar VIP' : 'Sí, entregar'
      };
    },
    confirmarAccion() {
      document.getElementById('obs-' + this.confirmacion.formId.replace('form-', '')).value = this.confirmacion.observaciones;
      document.getElementById(this.confirmacion.formId).submit();
      this.confirmacion.open = false;
    }
  }
}
</script>
