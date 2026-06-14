<?php
$totalTiempoCocina = array_sum(array_column($comandasCocina, 'tiempo'));
$promedioCocina = count($comandasCocina) > 0 ? round($totalTiempoCocina / count($comandasCocina)) : 0;
$ocupacion = min(100, round((count($comandasCocina) / 8) * 100));
?>
<div class="flex min-h-[calc(100vh-5rem)]">
  <?php require __DIR__ . '/_sidebar.php'; ?>

  <div class="w-full lg:w-[80%] p-6 lg:p-10"
       x-data="cocinaModal()">

    <div class="flex items-center justify-between mb-8">
      <div class="flex items-center gap-4">
        <h1 class="text-3xl font-serif font-bold text-[#2A1B14]">Cocina</h1>
        <span class="bg-[#C5A059]/10 text-[#C5A059] text-sm font-bold px-4 py-1.5 rounded-full"><?= count($comandasCocina) ?> PEDIDOS ACTIVOS</span>
      </div>
    </div>

    <?php
    $modalObservaciones = false;
    require __DIR__ . '/_modal-confirmacion.php';
    ?>

    <?php if (count($comandasCocina) > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10" role="list">
      <?php foreach ($comandasCocina as $comanda): ?>
      <div class="rounded-2xl shadow-sm border p-6 transition-all duration-300 <?= $comanda['tiempo'] > 20 ? 'bg-red-50 border-red-200' : 'bg-white border-gray-100' ?>" role="listitem">
        <form method="POST" action="<?= url('/cocina/marcar-listo') ?>" id="form-<?= $comanda['id'] ?>">
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

          <div class="p-3 rounded-xl mb-4 font-bold text-sm flex items-center gap-2 <?= $comanda['tiempo'] > 20 ? 'bg-red-100 text-red-600' : 'bg-amber-50 text-amber-600' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span><?= $comanda['tiempo'] ?> min</span>
            <?php if ($comanda['tiempo'] > 20): ?>
              <span class="text-red-600 font-bold">! RETRASO</span>
            <?php endif; ?>
          </div>

          <div class="space-y-2 mb-6">
            <?php foreach ($comanda['items'] as $item): ?>
            <div class="p-3 rounded-lg <?= $comanda['tiempo'] > 20 ? 'bg-red-100/50 border border-red-200' : 'bg-gray-50 border border-gray-100' ?>">
              <div class="flex justify-between items-center">
                <span class="font-bold text-sm text-[#2A1B14]"><?= (int)$item['cantidad'] ?></span>
                <span class="text-sm text-[#2A1B14]"><?= htmlspecialchars($item['nombre']) ?></span>
                <?php if (!empty($item['variante'])): ?>
                  <span class="text-xs text-[#C5A059]"><?= htmlspecialchars($item['variante']) ?></span>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <button type="button"
                  @click="confirmar('<?= $comanda['id'] ?>', '<?= htmlspecialchars($comanda['cliente'], ENT_QUOTES) ?>', <?= count($comanda['items']) ?>, <?= $comanda['tiempo'] ?>)"
                  class="w-full py-3 rounded-full font-semibold text-sm tracking-wide transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-offset-2 btn-success">
            <span class="flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              Marcar como Listo → Entregas
            </span>
          </button>
        </form>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
      <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
      <p class="text-lg font-serif font-bold text-[#2A1B14]">Cocina despejada</p>
      <p class="text-sm text-[#2A1B14]/50 mt-1">No hay pedidos en preparación. ¡Buen trabajo!</p>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
      <div class="grid grid-cols-2 gap-8 mb-6">
        <div>
          <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Tiempo promedio</p>
          <p class="text-3xl font-bold text-[#2A1B14]"><?= $promedioCocina ?> min</p>
        </div>
        <div>
          <p class="text-xs text-[#2A1B14]/50 uppercase tracking-wider mb-1">Ocupación</p>
          <div class="w-full bg-gray-100 rounded-full h-4 mt-2" role="progressbar" aria-valuenow="<?= $ocupacion ?>" aria-valuemin="0" aria-valuemax="100">
            <div class="h-4 rounded-full transition-all duration-500 <?= $ocupacion > 70 ? 'bg-red-500' : ($ocupacion > 40 ? 'bg-amber-400' : 'bg-green-500') ?>" style="width:<?= $ocupacion ?>%"></div>
          </div>
          <p class="text-sm font-bold text-[#2A1B14] mt-1"><?= $ocupacion ?>%</p>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
function cocinaModal() {
  return {
    confirmacion: {
      open: false,
      titulo: '',
      mensaje: '',
      formId: '',
      btnClass: 'btn-success',
      btnText: 'Sí, marcar listo'
    },
    confirmar(id, cliente, items, tiempo) {
      this.confirmacion = {
        open: true,
        titulo: '¿Marcar como listo?',
        mensaje: 'Pedido #' + id + ' — ' + cliente + ' (' + items + ' producto(s)) — ' + tiempo + ' min',
        formId: 'form-' + id,
        btnClass: 'btn-success',
        btnText: 'Sí, marcar listo'
      };
    },
    confirmarAccion() {
      document.getElementById(this.confirmacion.formId).submit();
      this.confirmacion.open = false;
    }
  }
}
</script>
