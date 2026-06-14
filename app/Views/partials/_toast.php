<div x-show="toast.visible" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
     role="status" aria-live="polite"
     class="fixed top-4 right-4 z-50 px-5 py-4 rounded-2xl shadow-2xl border flex items-center gap-3 max-w-md"
     :class="toast.type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800'">
  <template x-if="toast.type === 'success'">
    <svg class="w-6 h-6 flex-shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
  </template>
  <template x-if="toast.type === 'error'">
    <svg class="w-6 h-6 flex-shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
  </template>
  <p class="text-sm font-medium flex-1" x-text="toast.message"></p>
  <button @click="toast.visible = false" class="flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity focus:outline-none focus:ring-2 focus:ring-[#C5A059] rounded-lg p-1" aria-label="Cerrar notificación">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
  </button>
</div>
