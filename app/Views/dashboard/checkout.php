<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="pago()" x-init="cargarPedido()">

  <?php require __DIR__ . '/../partials/_toast.php'; ?>

  <h1 class="text-4xl md:text-5xl font-serif font-bold text-[#2A1B14] mb-2">Finalizar Pedido</h1>
  <p class="text-[#2A1B14]/60 mb-8 md:mb-10">Completa tu pago en segundos y confirma tu pedido.</p>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 space-y-6">

      <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

          <div class="flex flex-col items-center justify-center">
            <div class="relative inline-block">
              <div class="absolute inset-0 border-2 border-[#E2C799] rounded-xl"></div>
              <div class="absolute -top-2 -left-2 w-6 h-6 border-t-4 border-l-4 border-[#E2C799] rounded-tl-lg"></div>
              <div class="absolute -top-2 -right-2 w-6 h-6 border-t-4 border-r-4 border-[#E2C799] rounded-tr-lg"></div>
              <div class="absolute -bottom-2 -left-2 w-6 h-6 border-b-4 border-l-4 border-[#E2C799] rounded-bl-lg"></div>
              <div class="absolute -bottom-2 -right-2 w-6 h-6 border-b-4 border-r-4 border-[#E2C799] rounded-br-lg"></div>
              <div class="w-56 h-56 m-4 rounded-lg bg-gray-50 flex items-center justify-center border border-[#E2C799]">
                <svg class="w-40 h-40 text-[#2A1B14]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
              </div>
            </div>
            <button class="mt-4 inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white shadow border border-gray-200 text-sm font-medium text-[#2A1B14] hover:bg-gray-50 transition-all focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
              <svg class="w-5 h-5 text-[#7B2D8E]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15.5v-9l7 4.5-7 4.5z"/></svg>
              CLICK PARA PAGAR
            </button>
          </div>

          <div class="flex flex-col gap-4">
            <h2 class="text-lg font-bold text-[#2A1B14]">Instrucciones de Pago</h2>

            <div class="flex items-start gap-4">
              <span class="bg-[#2A1B14] text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold flex-shrink-0">1</span>
              <div>
                <p class="font-semibold text-[#2A1B14]">Abre tu app Yape</p>
                <p class="text-sm text-[#2A1B14]/60">Ingresa a Yape desde tu celular</p>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <span class="bg-[#2A1B14] text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold flex-shrink-0">2</span>
              <div>
                <p class="font-semibold text-[#2A1B14]">Escanea el código QR</p>
                <p class="text-sm text-[#2A1B14]/60">Usa la opción "Pagar con QR" de Yape</p>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <span class="bg-[#2A1B14] text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold flex-shrink-0">3</span>
              <div class="flex-1">
                <p class="font-semibold text-[#2A1B14] mb-2">Ingresa el código de operación</p>
                <label for="codigo-op" class="sr-only">Código de operación</label>
                <input id="codigo-op" type="text" x-model="codigoOperacion"
                       @input="validarCodigo()"
                       placeholder="Ej: 0984521"
                       class="w-full max-w-xs px-4 py-3 rounded-xl border text-sm text-[#2A1B14] placeholder-[#2A1B14]/30 focus:outline-none focus:ring-2 transition-colors"
                       :class="codigoError ? 'border-red-300 focus:ring-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:border-[#C5A880] focus:ring-[#C5A880]/20'"
                       aria-describedby="codigo-helper">
                <p id="codigo-helper" class="text-xs text-[#2A1B14]/40 mt-1">Ingresa el código que aparece en tu comprobante Yape</p>
                <p x-show="codigoError" class="text-xs text-red-500 mt-1" x-text="codigoError" role="alert"></p>
              </div>
            </div>
          </div>
        </div>

        <button @click="confirmarPago()"
                :disabled="!codigoValido || enviando"
                class="w-full mt-8 py-4 rounded-lg font-bold text-base tracking-wide shadow-md transition-all flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-[#C5A880] focus:ring-offset-2 bg-[#C5A880] hover:bg-[#B4966E] text-[#2A1B18]"
                :class="(!codigoValido || enviando) ? 'opacity-40 cursor-not-allowed' : ''">
          <template x-if="!enviando">
            <span class="flex items-center gap-2">
              Confirmar y Finalizar Pedido →
            </span>
          </template>
          <template x-if="enviando">
            <span class="flex items-center gap-2">
              <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
              Procesando…
            </span>
          </template>
        </button>
        <p class="text-center text-xs text-[#2A1B14]/40 mt-3">Al confirmar, validaremos tu transacción en segundos.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 pt-6 border-t border-gray-200">
        <div class="flex flex-col items-center text-center gap-1">
          <svg class="w-8 h-8 text-[#2A1B14]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          <p class="text-sm font-bold text-[#2A1B14]">Pago Encriptado</p>
          <p class="text-[10px] uppercase tracking-wider text-[#2A1B14]/40">Transacciones 100% seguras</p>
        </div>
        <div class="flex flex-col items-center text-center gap-1">
          <svg class="w-8 h-8 text-[#2A1B14]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <p class="text-sm font-bold text-[#2A1B14]">Confirmación Inmediata</p>
          <p class="text-[10px] uppercase tracking-wider text-[#2A1B14]/40">Recibe tu comprobante al instante</p>
        </div>
        <div class="flex flex-col items-center text-center gap-1">
          <svg class="w-8 h-8 text-[#2A1B14]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636a9 9 0 010 12.728m-2.829-2.829a5 5 0 000-7.07m-4.243 4.243a1 1 0 010-1.414"/></svg>
          <p class="text-sm font-bold text-[#2A1B14]">Soporte Lima</p>
          <p class="text-[10px] uppercase tracking-wider text-[#2A1B14]/40">Atención local prioritaria</p>
        </div>
      </div>
    </div>

    <div class="lg:col-span-1">
      <div class="flex flex-col gap-4">
        <div class="bg-[#2A1B14] text-white p-4 rounded-t-xl">
          <p class="text-lg font-serif font-bold">Resumen del Pedido</p>
          <p class="text-xs text-[#D4AF37] font-medium mt-1">ORDEN #TD-2024-9921</p>
        </div>

        <div class="bg-white p-6 rounded-b-xl shadow-sm flex flex-col gap-6">
          <div class="space-y-4 max-h-72 overflow-y-auto" x-show="items.length > 0" role="list">
            <template x-for="item in items" :key="item.id">
              <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xl flex-shrink-0" aria-hidden="true">🍰</div>
                  <div>
                    <p class="text-sm font-semibold text-[#2A1B14]" x-text="item.nombre"></p>
                    <p class="text-xs text-[#2A1B14]/50" x-text="'x ' + item.cantidad + ' unidades'"></p>
                  </div>
                </div>
                <span class="text-sm font-semibold text-[#2A1B14] text-right whitespace-nowrap" x-text="'S/ ' + (item.precio * item.cantidad).toFixed(2)"></span>
              </div>
            </template>
          </div>
          <div x-show="items.length === 0">
            <p class="text-sm text-[#2A1B14]/50 text-center py-4">No hay artículos en este pedido</p>
          </div>

          <div class="border-t border-gray-100 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
              <span class="text-[#2A1B14]/60">Subtotal</span>
              <span class="font-medium text-[#2A1B14]" x-text="'S/ ' + subtotal.toFixed(2)"></span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-[#2A1B14]/60">Envío</span>
              <span class="font-medium text-[#2A1B14]" x-text="envio > 0 ? 'S/ ' + envio.toFixed(2) : 'Gratis'"></span>
            </div>
          </div>

          <div class="border-t border-gray-100 pt-4">
            <div class="flex justify-between items-end">
              <span class="text-sm font-semibold text-[#2A1B14]">Total a Pagar</span>
              <div class="text-right">
                <span class="text-3xl font-serif font-bold text-[#2A1B14]" x-text="'S/ ' + total.toFixed(2)"></span>
                <p class="text-[10px] text-[#2A1B14]/40 tracking-wide">IMPUESTOS INCLUIDOS</p>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-[#FAF5EF] border border-[#EFE5D8] rounded-xl p-4 flex gap-3 items-start">
          <svg class="w-8 h-8 flex-shrink-0 text-[#2A1B14]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2-1m6 0l2-1m-2 1v2a1 1 0 001 1h3M7 16v2a1 1 0 001 1h3m-6-6h6m4 0h3a1 1 0 001 1h-1m-6 0a2 2 0 100 4m0-4a2 2 0 110 4"/></svg>
          <div class="flex-1">
            <p class="text-sm font-bold text-[#2A1B14]">Entrega Programada</p>
            <p class="text-sm text-[#2A1B14]/70">Hoy, entre 4:00 PM y 6:00 PM</p>
            <p class="text-xs text-[#2A1B14]/50 mt-1">Av. La Mar 1234, Miraflores — Lima</p>
          </div>
        </div>

        <p class="text-[11px] text-center text-[#2A1B14]/30 leading-relaxed">
          Al completar el pago, aceptas nuestros <a href="#" class="underline hover:text-[#C5A880]">Términos de Servicio</a> y <a href="#" class="underline hover:text-[#C5A880]">Política de Privacidad</a>.
        </p>
      </div>
    </div>
  </div>

</div>

<script>
function pago() {
  return {
    items: [],
    subtotal: 0,
    envio: <?= COSTO_ENVIO ?>,
    total: 0,
    numeroOrden: Math.floor(1000 + Math.random() * 9000),
    codigoOperacion: '',
    codigoValido: false,
    codigoError: '',
    enviando: false,
    cargarPedido() {
      const saved = localStorage.getItem('pedido-confirmado');
      if (saved) {
        const pedido = JSON.parse(saved);
        this.items = pedido.items || [];
        this.subtotal = pedido.subtotal || 0;
        this.envio = pedido.envio || <?= COSTO_ENVIO ?>;
        this.total = pedido.total || 0;
      } else {
        const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
        if (carrito.length > 0) {
          this.items = carrito;
          this.subtotal = carrito.reduce((s, i) => s + i.precio * i.cantidad, 0);
          this.total = this.subtotal + this.envio;
        }
      }
    },
    validarCodigo() {
      if (!this.codigoOperacion) { this.codigoError = ''; this.codigoValido = false; return; }
      if (/^\d{6,10}$/.test(this.codigoOperacion)) {
        this.codigoError = '';
        this.codigoValido = true;
      } else {
        this.codigoError = 'El código debe tener entre 6 y 10 dígitos';
        this.codigoValido = false;
      }
    },
    async confirmarPago() {
      if (!this.codigoValido || this.enviando) return;
      this.enviando = true;
      try {
        const res = await fetch('<?= url('/checkout/confirmar') ?>', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            items: this.items.map(i => ({ nombre: i.nombre, cantidad: i.cantidad, variante: i.variante || null })),
            total: this.total
          })
        });
        const data = await res.json();
        if (data.success) {
          localStorage.removeItem('carrito');
          localStorage.removeItem('pedido-confirmado');
          if (typeof window.notifySuccess === 'function') {
            window.notifySuccess('¡Pedido confirmado exitosamente!');
          }
          setTimeout(() => { window.location.href = '<?= url('/mis-pedidos') ?>'; }, 800);
        } else {
          if (typeof window.notifyError === 'function') {
            window.notifyError(data.error || 'Error al confirmar el pedido');
          }
        }
      } catch {
        if (typeof window.notifyError === 'function') {
          window.notifyError('Error de conexión');
        }
      } finally {
        this.enviando = false;
      }
    }
  }
}
</script>