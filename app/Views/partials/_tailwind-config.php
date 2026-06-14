<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        crema: '#FDFBF7',
        chocolate: '#2A1B14',
        dorado: '#C5A059',
        amarillo: '#FECD70',
        rojo: '#5B1212',
        purpura: '#4A148C',
      },
      fontFamily: {
        serif: ['Playfair Display', 'serif'],
        sans: ['Inter', 'sans-serif'],
      }
    }
  }
}
</script>
<style>
body { font-family: 'Inter', sans-serif; background: #FDFBF7; color: #2A1B14; }
h1, h2, h3, h4, .font-serif { font-family: 'Playfair Display', serif; }
.btn-primary { background: linear-gradient(135deg, #C5A059, #A38446); color: #fff; transition: all .3s; }
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(197,160,89,.4); }
.btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.btn-chocolate { background: #2A1B14; color: #FDFBF7; transition: all .3s; }
.btn-chocolate:hover { background: #3d281e; }
.btn-chocolate:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.btn-success { background: #4a7c3f; color: #fff; transition: all .3s; }
.btn-success:hover { background: #3d6b34; transform: translateY(-1px); }
.btn-success:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.btn-vip { background: #FECD70; color: #2A1B14; transition: all .3s; }
.btn-vip:hover { background: #f5c25a; transform: translateY(-1px); }
.btn-vip:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.fade-out { opacity: 0; transition: opacity .3s ease; }
.skip-link { position: absolute; top: -100%; left: 0; z-index: 100; padding: 0.5rem 1rem; background: #2A1B14; color: #FDFBF7; }
.skip-link:focus { top: 0; }
[x-cloak] { display: none !important; }
</style>
