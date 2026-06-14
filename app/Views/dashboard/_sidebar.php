<?php
$role = Auth::role();
$sidebarItems = [];

if ($role === 'admin') {
    $sidebarItems[] = ['label' => 'General', 'url' => url('/admin'), 'icon' => 'grid'];
    $sidebarItems[] = ['label' => 'Historial', 'url' => url('/admin/historial-entregas'), 'icon' => 'clock'];
}
if (in_array($role, ['admin', 'mozo'])) {
    $sidebarItems[] = ['label' => 'Pendientes', 'url' => url('/panel-mozo'), 'icon' => 'inbox'];
    $sidebarItems[] = ['label' => 'Entregas', 'url' => url('/entregas'), 'icon' => 'truck'];
}
if (in_array($role, ['admin', 'cocina'])) {
    $sidebarItems[] = ['label' => 'Cocina', 'url' => url('/cocina'), 'icon' => 'cook'];
}
?>
<aside class="w-[20%] bg-white border-r border-gray-200 p-6 hidden lg:block" aria-label="Navegación del panel">
  <nav class="space-y-2">
    <?php foreach ($sidebarItems as $item):
      $isActive = $currentPath === $item['url'] || strpos($currentPath, $item['url'] . '/') === 0;
    ?>
      <a href="<?= $item['url'] ?>"
         class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:ring-offset-2
         <?= $isActive ? 'bg-[#FDFBF7] border-r-2 border-[#C5A059] text-[#2A1B14]' : 'text-[#2A1B14]/60 hover:bg-gray-50 hover:text-[#2A1B14]/80' ?>"
         aria-current="<?= $isActive ? 'page' : 'false' ?>">
        <?php if ($item['icon'] === 'grid'): ?>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        <?php elseif ($item['icon'] === 'clock'): ?>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <?php elseif ($item['icon'] === 'inbox'): ?>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        <?php elseif ($item['icon'] === 'truck'): ?>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2-1m6 0l2-1m-2 1v2a1 1 0 001 1h3M7 16v2a1 1 0 001 1h3m-6-6h6m4 0h3a1 1 0 001 1h-1m-6 0a2 2 0 100 4m0-4a2 2 0 110 4"/></svg>
        <?php elseif ($item['icon'] === 'cook'): ?>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg>
        <?php endif; ?>
        <?= $item['label'] ?>
      </a>
    <?php endforeach; ?>
  </nav>
</aside>
