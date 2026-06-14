<?php // ——————————————— HERO ——————————————— ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

    <div class="relative">
      <span class="inline-block bg-[#C5A059]/10 text-[#C5A059] text-xs font-semibold tracking-[.2em] uppercase px-4 py-2 rounded-full mb-6">
        ✦ Desde 1924
      </span>
      <h1 class="text-5xl sm:text-6xl lg:text-7xl font-serif font-bold text-[#2A1B14] leading-[1.1] mb-6">
        El Legado del<br>
        <span class="text-[#C5A059]">Sabor Limeño</span>
      </h1>
      <p class="text-lg text-[#2A1B14]/70 leading-relaxed mb-8 max-w-lg">
        Desde hace cuatro generaciones endulzamos los paladares más exigentes con recetas tradicionales que son patrimonio del Perú.
      </p>
      <div class="flex flex-wrap gap-4">
        <a href="<?= url('/carta') ?>" class="px-8 py-3.5 rounded-full font-medium text-sm tracking-wide btn-primary">
          Ver nuestra carta
        </a>
        <a href="#nosotros" class="px-8 py-3.5 rounded-full font-medium text-sm tracking-wide text-[#2A1B14] border-2 border-[#2A1B14]/20 hover:border-[#2A1B14] transition-all">
          Conócenos
        </a>
      </div>

      <div class="mt-10 bg-white p-6 rounded-xl shadow-xl max-w-sm">
        <p class="text-[#C5A059] text-sm italic font-medium">
          "Cada bocado cuenta una historia de tradición y amor por la pastelería artesanal."
        </p>
        <p class="text-[#2A1B14]/60 text-xs mt-2 font-medium">— Familia Pastelera</p>
      </div>
    </div>

    <div class="relative flex justify-center">
      <div class="w-full max-w-md aspect-square rounded-2xl bg-gradient-to-br from-[#C5A059]/20 to-[#C5A059]/5 flex items-center justify-center overflow-hidden shadow-2xl">
        <div class="text-center p-8">
          <span class="text-9xl">🍫</span>
          <p class="text-[#2A1B14]/40 font-serif text-lg mt-4">Torta de Chocolate Gourmet</p>
        </div>
      </div>
    </div>

  </div>
</section>

<?php // ——————————————— NOSOTROS ——————————————— ?>
<section id="nosotros" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    <div class="lg:col-span-2 bg-white rounded-2xl p-8 lg:p-10 shadow-sm border border-gray-100">
      <div class="flex items-center gap-3 mb-4">
        <svg class="w-6 h-6 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
        </svg>
        <h2 class="text-2xl font-serif font-bold text-[#2A1B14]">Nuestra Misión</h2>
      </div>
      <p class="text-[#2A1B14]/70 leading-relaxed text-lg">
        Preservar y compartir el arte de la repostería tradicional limeña, utilizando ingredientes frescos y técnicas artesanales que realzan los sabores auténticos del Perú. Queremos que cada cliente experimente el placer de un postre hecho con dedicación.
      </p>
    </div>

    <div class="bg-[#FECD70]/30 rounded-2xl overflow-hidden flex items-center justify-center min-h-[200px] shadow-sm">
      <div class="text-center p-6">
        <span class="text-6xl">🧁</span>
        <p class="text-[#2A1B14]/60 text-sm mt-2 font-medium">Vitrina de dulces artesanales</p>
      </div>
    </div>

  </div>

  <div class="bg-white rounded-2xl p-8 lg:p-10 shadow-sm border border-gray-100 flex flex-col lg:flex-row items-center gap-8">
    <div class="flex-1">
      <div class="flex items-center gap-3 mb-4">
        <svg class="w-6 h-6 text-[#4A148C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        <h2 class="text-2xl font-serif font-bold text-[#2A1B14]">Nuestra Visión</h2>
      </div>
      <p class="text-[#2A1B14]/70 leading-relaxed text-lg">
        Ser la pastelería artesanal de referencia en Lima Metropolitana, reconocida por nuestra calidad excepcional, innovación en sabores peruanos y el compromiso con mantener viva la tradición pastelera que heredamos de nuestros abuelos.
      </p>
    </div>
    <div class="flex-shrink-0 w-full lg:w-64 h-48 rounded-xl bg-gradient-to-br from-[#2A1B14]/10 to-[#C5A059]/20 flex items-center justify-center">
      <div class="text-center">
        <span class="text-5xl">👨‍🍳</span>
        <p class="text-[#2A1B14]/50 text-xs mt-2">Chef pastelero</p>
      </div>
    </div>
  </div>

</section>

<?php // ——————————————— PILARES ——————————————— ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div>
      <h2 class="text-4xl font-serif font-bold text-[#2A1B14] leading-tight">
        Artesanía en<br>cada detalle.
      </h2>
      <p class="text-[#2A1B14]/50 text-sm mt-4">
        Cuatro pilares que sostienen nuestra tradición.
      </p>
    </div>

    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
      <?php foreach ($pilares as $pilar): ?>
        <div class="border-t-2 border-[#C5A059]/30 pt-6">
          <h3 class="font-serif font-bold text-xl text-[#2A1B14] mb-2"><?= $pilar['titulo'] ?></h3>
          <p class="text-sm text-[#2A1B14]/60 leading-relaxed"><?= $pilar['descripcion'] ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
