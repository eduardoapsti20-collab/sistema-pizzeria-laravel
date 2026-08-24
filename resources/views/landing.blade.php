@php
    $telefonoWa = $setting && $setting->company_phone
        ? preg_replace('/[^0-9]/', '', $setting->company_phone)
        : '51987654321';
    $redesSociales = $setting->social_networks ?? [];
    $iconosMarca = ['facebook', 'instagram', 'whatsapp', 'twitter', 'linkedin', 'youtube', 'tiktok'];
@endphp
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pizzería Zuñiga · El auténtico sabor de la tradición italiana</title>
<meta name="description" content="Pizzería Zuñiga: masa artesanal, horno de leña y sazón de familia. Pide por WhatsApp, revisa el menú completo y reserva tu mesa.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink: '#0B0B0B', panel: '#141414', card: '#1a1a1a',
          rust: '#C41E1E', 'rust-2': '#961616', gold: '#D4AF37',
        },
        fontFamily: {
          script: ['"Great Vibes"', 'cursive'],
          sans: ['"Poppins"', 'sans-serif'],
          mono: ['"JetBrains Mono"', 'monospace'],
        },
      }
    }
  }
</script>

<style>
  html { background:#0B0B0B; }
  body { font-family:'Poppins',sans-serif; background:#0B0B0B; color:#f2ede6; }
  .font-script { font-family:'Great Vibes', cursive; }

  .menu-card, .why-card, .loc-card { transition: transform .3s cubic-bezier(.2,.8,.2,1), box-shadow .3s ease, border-color .3s ease; }
  .menu-card:hover, .why-card:hover, .loc-card:hover { transform: translateY(-6px); border-color: rgba(196,30,30,.5); box-shadow: 0 20px 34px -16px rgba(0,0,0,.5); }

  .gal-item { position:relative; overflow:hidden; border-radius:1rem; }
  .gal-item img { transition: transform .5s ease; }
  .gal-item:hover img { transform: scale(1.08); }
  .gal-overlay { position:absolute; inset:0; background:linear-gradient(to top, rgba(11,11,11,.9), rgba(11,11,11,.1) 60%); opacity:0; transition:opacity .3s ease; display:flex; align-items:flex-end; padding:14px; }
  .gal-item:hover .gal-overlay { opacity:1; }

  .steam { animation: steamRise 4s ease-in-out infinite; }
  @keyframes steamRise { 0% { transform: translateY(0) scaleX(1); opacity:.55; } 50% { transform: translateY(-22px) scaleX(1.15); opacity:.85; } 100% { transform: translateY(-44px) scaleX(1); opacity:0; } }

  .grid-bg {
    background-size: 42px 42px;
    background-image:
      linear-gradient(to right, rgba(255,255,255,.05) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(255,255,255,.05) 1px, transparent 1px);
  }

  .glow-pulse { animation: glowPulse 5s ease-in-out infinite; }
  @keyframes glowPulse { 0%,100% { opacity:.55; transform:scale(1); } 50% { opacity:.85; transform:scale(1.08); } }

  .float-slow { animation: floatSlow 6s ease-in-out infinite; }
  @keyframes floatSlow { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }

  .spin-slow { animation: spin 22s linear infinite; }
  @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

  .reveal { opacity:0; transform: translateY(24px); transition: opacity .65s ease, transform .65s ease; }
  .reveal.in { opacity:1; transform: translateY(0); }

  .nav-link { color: rgba(255,255,255,.6); border-bottom: 2px solid transparent; padding-bottom: 4px; transition: color .2s ease, border-color .2s ease; }
  .nav-link.active { color: #C41E1E; border-color: #C41E1E; }
  .nav-link:hover { color: #ffffff; }

  /* testimonial carousel */
  .testi-slide { display:none; }
  .testi-slide.active { display:block; animation: fadeIn .5s ease; }
  @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

  ::selection { background:#C41E1E; color:#fff; }
  input:focus, textarea:focus { outline:none; box-shadow: 0 0 0 3px rgba(196,30,30,.35); }
</style>
</head>
<body class="antialiased">

<!-- ============ NAVBAR ============ -->
<header id="navbar" class="fixed top-0 inset-x-0 z-40 bg-ink/80 backdrop-blur-md border-b border-white/10">
  <nav class="max-w-[1400px] mx-auto px-6 py-3.5 flex items-center justify-between" aria-label="Navegación principal">
    <a href="#inicio" class="flex items-center gap-3">
      <span class="relative"><i class="fa-solid fa-pizza-slice text-rust text-2xl"></i></span>
      <span class="leading-none">
        <span class="block text-[10px] tracking-[0.3em] text-white/60 font-bold">PIZZERÍA</span>
        <span class="block font-script text-3xl text-white -mt-1">Zuñiga</span>
        <span class="block text-[8px] tracking-[0.25em] text-gold/70 font-semibold">DESDE 2015</span>
      </span>
    </a>

    <ul class="hidden lg:flex items-center gap-9 text-xs font-bold tracking-wide">
      <li><a href="#inicio" data-nav class="nav-link active">INICIO</a></li>
      <li><a href="#nosotros" data-nav class="nav-link">NOSOTROS</a></li>
      <li><a href="#menu" data-nav class="nav-link">MENÚ</a></li>
      <li><a href="#galeria" data-nav class="nav-link">GALERÍA</a></li>
      <li><a href="#contacto" data-nav class="nav-link">CONTACTO</a></li>
    </ul>

    <div class="flex items-center gap-3">
      <a href="{{ route('login') }}" title="Acceso del personal" class="w-10 h-10 rounded-full border border-white/15 text-white/40 hover:text-rust hover:border-rust flex items-center justify-center transition-colors">
        <i class="fa-solid fa-user-lock text-sm"></i>
      </a>
      <a href="#reservas" class="hidden sm:inline-flex items-center gap-2 border-2 border-gold text-gold hover:bg-gold hover:text-ink text-xs font-black uppercase tracking-wider px-5 py-2.5 rounded-full transition-all">
        Reservar mesa <i class="fa-solid fa-calendar-check"></i>
      </a>
      <a href="https://wa.me/{{ $telefonoWa }}" class="inline-flex items-center gap-2 bg-rust hover:bg-rust-2 text-white text-xs font-black uppercase tracking-wider px-5 py-3 rounded-full transition-all hover:-translate-y-0.5">
        Pedir ahora <i class="fa-solid fa-cart-shopping"></i>
      </a>
    </div>
  </nav>
</header>

<!-- ============ HERO-5: título + pizza + ola ============ -->
<section id="inicio" class="relative min-h-screen flex flex-col justify-center pt-28 pb-24 overflow-hidden scroll-mt-20" style="background: linear-gradient(135deg, #FF7A3D 0%, #E8590C 55%, #C4450A 100%);">
  <div class="grid-bg absolute inset-0 -z-10 opacity-20 mix-blend-overlay"></div>
  <div class="absolute -left-24 top-1/4 w-[420px] h-[420px] rounded-full bg-white/15 blur-[110px] glow-pulse -z-10"></div>
  <div class="absolute -right-16 bottom-10 w-[380px] h-[380px] rounded-full bg-gold/30 blur-[110px] glow-pulse -z-10" style="animation-delay:1.5s"></div>

  <div class="max-w-[1400px] mx-auto px-6 grid lg:grid-cols-2 items-center gap-10 relative z-10">
    <div class="reveal in">
      <p class="font-script text-white/80 text-4xl mb-1">Pizzeria</p>
      <h1 class="font-script text-white text-7xl sm:text-8xl leading-[0.9] mb-3 drop-shadow-[0_8px_20px_rgba(0,0,0,.35)]">Zuñiga</h1>
      <div class="flex gap-1 text-gold text-sm mb-6">
        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
      </div>
      <p class="text-white/85 text-base sm:text-lg max-w-md mb-9 leading-relaxed">
        El auténtico sabor de la tradición italiana, preparado con ingredientes frescos y horneado a la perfección.
      </p>
      <div class="flex flex-wrap gap-4 mb-10">
        <a href="#menu" class="inline-flex items-center gap-2 bg-white hover:bg-cream text-[#E8590C] font-black text-sm uppercase tracking-wider px-7 py-4 rounded-full shadow-[0_15px_30px_-10px_rgba(0,0,0,.4)] transition-all hover:-translate-y-1">
          <i class="fa-solid fa-pizza-slice text-xs"></i> Ver menú
        </a>
        <a href="https://wa.me/{{ $telefonoWa }}" class="inline-flex items-center gap-2 border-2 border-white/70 text-white font-black text-sm uppercase tracking-wider px-7 py-4 rounded-full hover:bg-white/10 transition-all">
          <i class="fa-solid fa-phone text-xs"></i> Pedir ahora
        </a>
      </div>
      <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-white/80 text-sm font-semibold">
        <span class="flex items-center gap-2"><i class="fa-solid fa-star text-gold"></i> 4.9/5 en reseñas</span>
        <span class="w-1 h-1 rounded-full bg-white/30"></span>
        <span class="flex items-center gap-2"><i class="fa-solid fa-motorcycle text-gold"></i> Delivery 25-35 min</span>
        <span class="w-1 h-1 rounded-full bg-white/30"></span>
        <span class="flex items-center gap-2"><i class="fa-solid fa-fire text-gold"></i> Horno de leña</span>
      </div>
    </div>

    <div class="relative reveal in flex justify-center items-end pb-4 sm:pb-8" style="transition-delay:.15s">
      <div class="relative w-full max-w-lg aspect-square float-slow">
        <div class="absolute -top-6 left-1/3 w-16 h-24 bg-white/20 rounded-full blur-2xl steam"></div>
        <div class="absolute -top-4 right-1/3 w-14 h-20 bg-white/20 rounded-full blur-2xl steam" style="animation-delay:1.3s"></div>
        <div class="absolute inset-0 rounded-full bg-white shadow-[0_30px_60px_-15px_rgba(0,0,0,.45)]"></div>
        <img src="https://images.unsplash.com/photo-1628840042765-356cda07504e?q=80&w=1200&auto=format&fit=crop" alt="Pizza Zuñiga recién horneada" class="absolute inset-[4%] w-[92%] h-[92%] object-cover rounded-full">
        <div class="absolute inset-0 rounded-full border-2 border-dashed border-gold/70 m-2 spin-slow"></div>
        <span class="absolute top-4 -right-2 bg-gold text-ink text-[10px] font-black uppercase tracking-wide px-3 py-2 rounded-full shadow-xl">100% Artesanal</span>
      </div>
      <div class="absolute -bottom-4 left-2 sm:left-8 bg-white border border-black/5 rounded-2xl px-6 py-5 shadow-xl">
        <p class="font-script text-[#E8590C] text-2xl leading-none">2 estaciones</p>
        <p class="text-ink/50 text-xs mt-1.5">arma tu propia pizza</p>
      </div>
    </div>
  </div>

  <div class="absolute bottom-0 inset-x-0 -z-0 leading-[0]">
    <svg viewBox="0 0 1440 110" class="w-full h-[70px] sm:h-[100px]" preserveAspectRatio="none">
      <path fill="#0B0B0B" d="M0,64 C240,110 480,10 720,32 C960,54 1200,110 1440,48 L1440,110 L0,110 Z"></path>
    </svg>
  </div>
</section>

<!-- ============ ABOUT-7: 3 cajas con íconos ============ -->
<section class="py-16 bg-ink">
  <div class="max-w-[1400px] mx-auto px-6 grid sm:grid-cols-3 gap-6">
    <div class="why-card bg-card border border-white/10 rounded-2xl py-9 px-6 text-center reveal">
      <div class="w-14 h-14 rounded-full bg-rust/15 border border-rust flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-scroll text-rust text-xl"></i>
      </div>
      <p class="text-white font-bold text-base mb-2">Recetas originales</p>
      <p class="text-white/45 text-sm leading-relaxed">Masa artesanal fermentada 24 horas y salsa casera, sin atajos.</p>
    </div>
    <div class="why-card bg-card border border-white/10 rounded-2xl py-9 px-6 text-center reveal" style="transition-delay:.06s">
      <div class="w-14 h-14 rounded-full bg-rust/15 border border-rust flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-leaf text-rust text-xl"></i>
      </div>
      <p class="text-white font-bold text-base mb-2">Ingredientes de calidad</p>
      <p class="text-white/45 text-sm leading-relaxed">Seleccionamos proveedores locales frescos todos los días.</p>
    </div>
    <div class="why-card bg-card border border-white/10 rounded-2xl py-9 px-6 text-center reveal" style="transition-delay:.12s">
      <div class="w-14 h-14 rounded-full bg-rust/15 border border-rust flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-motorcycle text-rust text-xl"></i>
      </div>
      <p class="text-white font-bold text-base mb-2">Delivery más rápido</p>
      <p class="text-white/45 text-sm leading-relaxed">Tu pizza caliente en 25-35 minutos, o te avisamos por qué no.</p>
    </div>
  </div>
</section>

<!-- ============ ABOUT-3: imagen + texto + íconos ============ -->
<section id="nosotros" class="py-20 bg-panel scroll-mt-20">
  <div class="max-w-[1400px] mx-auto px-6 grid lg:grid-cols-2 gap-14 items-center">
    <div class="reveal">
      <img src="https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=1100&auto=format&fit=crop" alt="Interior de Pizzería Zuñiga" class="rounded-2xl w-full h-[340px] object-cover border border-white/10">
    </div>
    <div class="reveal" style="transition-delay:.06s">
      <p class="text-rust text-xs font-black tracking-[0.2em] mb-2">SOBRE NOSOTROS</p>
      <h2 class="text-3xl text-white leading-tight font-bold mb-5">Nada une más a la gente que una buena pizza</h2>
      <p class="text-white/55 leading-relaxed mb-8">En Pizzería Zuñiga combinamos recetas tradicionales italianas con un toque único que nos distingue. Utilizamos ingredientes 100% frescos, seleccionados cuidadosamente para ofrecerte la mejor experiencia en cada bocado.</p>

      <div class="grid grid-cols-4 gap-4 text-center">
        <div>
          <div class="w-12 h-12 rounded-full bg-rust/15 border border-rust flex items-center justify-center mx-auto mb-2"><i class="fa-solid fa-pizza-slice text-rust"></i></div>
          <p class="text-white/60 text-xs font-semibold">Pizzas</p>
        </div>
        <div>
          <div class="w-12 h-12 rounded-full bg-rust/15 border border-rust flex items-center justify-center mx-auto mb-2"><i class="fa-solid fa-mug-hot text-rust"></i></div>
          <p class="text-white/60 text-xs font-semibold">Bebidas</p>
        </div>
        <div>
          <div class="w-12 h-12 rounded-full bg-rust/15 border border-rust flex items-center justify-center mx-auto mb-2"><i class="fa-solid fa-martini-glass-citrus text-rust"></i></div>
          <p class="text-white/60 text-xs font-semibold">Tragos</p>
        </div>
        <div>
          <div class="w-12 h-12 rounded-full bg-rust/15 border border-rust flex items-center justify-center mx-auto mb-2"><i class="fa-solid fa-fire text-rust"></i></div>
          <p class="text-white/60 text-xs font-semibold">Horno de leña</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ MENU-6: clásicas con rating ============ -->
<section id="menu" class="py-20 bg-ink scroll-mt-20">
  <div class="max-w-[1400px] mx-auto px-6">
    <div class="text-center mb-12 reveal">
      <p class="font-script text-gold text-3xl mb-1">Nuestras pizzas</p>
      <h2 class="text-2xl md:text-3xl font-black text-white tracking-wide">SABOR ITALIANO AUTÉNTICO</h2>
      <p class="text-white/40 text-sm mt-2">Elige 2 sabores y arma tu propia combinación (2 Estaciones)</p>
    </div>
    <div id="clasicas-grid" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5"></div>
  </div>
</section>

<!-- ============ PROMO-5: especiales destacados con badge de precio ============ -->
<section class="py-20 bg-panel">
  <div class="max-w-[1400px] mx-auto px-6">
    <div class="text-center mb-12 reveal">
      <p class="font-script text-gold text-3xl mb-1">Para los más hambrientos</p>
      <h2 class="text-2xl md:text-3xl font-black text-white tracking-wide">ESPECIALES DESTACADOS</h2>
    </div>
    <div id="especiales-grid" class="grid lg:grid-cols-2 gap-5 mb-8"></div>
    <div class="bg-card border border-white/10 rounded-2xl px-6 py-5 flex flex-wrap items-center justify-center gap-x-8 gap-y-2 text-sm font-semibold text-center reveal">
      <span class="font-script text-gold text-lg">Extra: doble mozzarella</span>
      <span class="text-white/70">Familiar S/ 6.00</span>
      <span class="text-white/70">Grande S/ 8.00</span>
      <span class="text-white/70">XL S/ 12.00</span>
    </div>
  </div>
</section>

<!-- ============ MENU-9: bebidas ============ -->
<section id="bebidas" class="py-20 bg-ink">
  <div class="max-w-[1400px] mx-auto px-6">
    <div class="text-center mb-12 reveal">
      <p class="font-script text-gold text-3xl mb-1">Para acompañar</p>
      <h2 class="text-2xl md:text-3xl font-black text-white tracking-wide">BEBIDAS</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-card border border-white/10 rounded-2xl p-6 reveal">
        <h3 class="text-gold font-black text-sm uppercase tracking-wide mb-4 flex items-center gap-2"><i class="fa-solid fa-mug-hot"></i> Bebidas calientes</h3>
        <ul class="space-y-2 text-sm text-white/60"><li>Café</li><li>Capuchino</li><li>Café c/ leche</li><li>Té</li><li>Anís</li><li>Manzanilla</li></ul>
      </div>
      <div class="bg-card border border-white/10 rounded-2xl p-6 reveal" style="transition-delay:.06s">
        <h3 class="text-gold font-black text-sm uppercase tracking-wide mb-4 flex items-center gap-2"><i class="fa-solid fa-glass-water"></i> Jugos</h3>
        <ul class="space-y-2 text-sm text-white/60"><li>Piña</li><li>Papaya</li><li>Fresa</li></ul>
      </div>
      <div class="bg-card border border-white/10 rounded-2xl p-6 reveal" style="transition-delay:.12s">
        <h3 class="text-gold font-black text-sm uppercase tracking-wide mb-4 flex items-center gap-2"><i class="fa-solid fa-blender"></i> Heladas y frozen</h3>
        <ul class="space-y-2 text-sm text-white/60"><li>Camu camu</li><li>Limonada</li><li>Maracuyá</li><li>Quito quito</li><li>Guanábana</li></ul>
      </div>
      <div class="bg-card border border-white/10 rounded-2xl p-6 reveal" style="transition-delay:.18s">
        <h3 class="text-gold font-black text-sm uppercase tracking-wide mb-4 flex items-center gap-2"><i class="fa-solid fa-martini-glass-citrus"></i> Tragos</h3>
        <ul class="space-y-2 text-sm text-white/60"><li>Pisco sour</li><li>Mojito</li><li>Piña colada</li><li>Machupichu</li></ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ TESTIMONIOS: carrusel ============ -->
<section class="py-20 bg-panel">
  <div class="max-w-3xl mx-auto px-6 text-center reveal">
    <i class="fa-solid fa-quote-left text-rust/30 text-4xl mb-6"></i>
    <div id="testi-wrap" class="relative min-h-[160px]">
      <div class="testi-slide active">
        <p class="text-xl text-white/80 leading-relaxed mb-6">"La mejor pizza que he probado, ingredientes frescos y masa perfecta. ¡100% recomendado!"</p>
        <div class="flex justify-center text-gold text-sm mb-3"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
        <p class="text-white/50 text-sm font-semibold">— Carlos M.</p>
      </div>
      <div class="testi-slide">
        <p class="text-xl text-white/80 leading-relaxed mb-6">"Excelente servicio y delivery muy rápido. La pizza llegó caliente y deliciosa."</p>
        <div class="flex justify-center text-gold text-sm mb-3"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
        <p class="text-white/50 text-sm font-semibold">— María G.</p>
      </div>
      <div class="testi-slide">
        <p class="text-xl text-white/80 leading-relaxed mb-6">"Zuñiga siempre es mi primera opción. Calidad, sabor y buen precio."</p>
        <div class="flex justify-center text-gold text-sm mb-3"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
        <p class="text-white/50 text-sm font-semibold">— Luis R.</p>
      </div>
    </div>
    <div id="testi-dots" class="flex justify-center gap-2 mt-6"></div>
  </div>
</section>

<!-- ============ BANNER-4: garantía de delivery ============ -->
<section class="py-16 bg-rust text-center">
  <div class="max-w-2xl mx-auto px-6 reveal">
    <p class="text-white/80 text-sm font-bold uppercase tracking-wide mb-2">Te lo garantizamos</p>
    <h2 class="text-3xl md:text-4xl font-black text-white mb-4">¡Delivery en 25-35 minutos!</h2>
    <p class="text-white/85 mb-8">Si tu pedido demora más de lo prometido, escríbenos y lo resolvemos al toque.</p>
    <a href="https://wa.me/{{ $telefonoWa }}" class="inline-flex items-center gap-2 bg-white hover:bg-cream text-rust font-black text-sm uppercase tracking-wider px-8 py-4 rounded-full transition-all hover:-translate-y-1">
      <i class="fa-brands fa-whatsapp"></i> Pedir ahora
    </a>
  </div>
</section>

<!-- ============ GALERÍA con overlay ============ -->
<section id="galeria" class="py-20 bg-ink scroll-mt-20">
  <div class="max-w-[1400px] mx-auto px-6">
    <div class="text-center mb-12 reveal">
      <p class="font-script text-gold text-3xl mb-1">Un vistazo</p>
      <h2 class="text-2xl md:text-3xl font-black text-white tracking-wide">GALERÍA</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <div class="gal-item reveal"><img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=600&auto=format&fit=crop" class="h-56 w-full object-cover" alt="Pizza Suprema"><div class="gal-overlay"><div><p class="text-white text-sm font-bold">Pizza Suprema</p><p class="text-gold text-xs"><i class="fa-solid fa-star"></i> 4.8</p></div></div></div>
      <div class="gal-item reveal" style="transition-delay:.06s"><img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=600&auto=format&fit=crop" class="h-56 w-full object-cover" alt="Ambiente"><div class="gal-overlay"><div><p class="text-white text-sm font-bold">Nuestro local</p><p class="text-gold text-xs"><i class="fa-solid fa-star"></i> 4.9</p></div></div></div>
      <div class="gal-item reveal" style="transition-delay:.12s"><img src="https://images.unsplash.com/photo-1628840042765-356cda07504e?q=80&w=600&auto=format&fit=crop" class="h-56 w-full object-cover" alt="Pepperoni"><div class="gal-overlay"><div><p class="text-white text-sm font-bold">Peperoni</p><p class="text-gold text-xs"><i class="fa-solid fa-star"></i> 4.7</p></div></div></div>
      <div class="gal-item reveal" style="transition-delay:.18s"><img src="https://images.unsplash.com/photo-1571407970349-bc81e7e96d47?q=80&w=600&auto=format&fit=crop" class="h-56 w-full object-cover" alt="Oriental"><div class="gal-overlay"><div><p class="text-white text-sm font-bold">Oriental</p><p class="text-gold text-xs"><i class="fa-solid fa-star"></i> 4.6</p></div></div></div>
    </div>
  </div>
</section>

<!-- ============ CONTACTS-3: ubicación tipo tarjeta + formulario ============ -->
<section id="contacto" class="py-20 bg-panel scroll-mt-20">
  <div class="max-w-[1400px] mx-auto px-6">
    <div class="text-center mb-12 reveal">
      <p class="font-script text-gold text-3xl mb-1">Encuéntranos</p>
      <h2 class="text-2xl md:text-3xl font-black text-white tracking-wide">NUESTRA UBICACIÓN</h2>
    </div>

    <div class="grid lg:grid-cols-2 gap-10">
      <div class="loc-card bg-card border border-white/10 rounded-2xl overflow-hidden reveal">
        <img src="https://images.unsplash.com/photo-1544145945-f90425340c7e?q=80&w=1000&auto=format&fit=crop" alt="Pizzería Zuñiga San Miguel" class="h-52 w-full object-cover">
        <div class="p-7 text-center">
          <h3 class="text-rust font-black text-lg mb-3">San Miguel</h3>
          <p class="text-white font-bold text-sm mb-4"><i class="fa-solid fa-phone text-rust mr-2"></i>{{ $setting->company_phone ?? '(01) 123 4567' }}</p>
          <p class="text-white/50 text-sm mb-4">{{ $setting->company_address ?? 'Av. Los Pinos 1234, San Miguel, Lima, Perú' }}</p>
          <p class="text-white/50 text-sm"><i class="fa-solid fa-clock text-rust mr-1"></i> Todos los días 12:00 p.m. – 10:30 p.m.</p>
        </div>
      </div>

      <div class="reveal" style="transition-delay:.1s">
        <p class="text-rust text-xs font-black tracking-[0.2em] mb-3">ESCRÍBENOS</p>
        <form id="contacto-form" class="grid grid-cols-2 gap-3">
          <input required type="text" placeholder="Nombre" class="col-span-2 sm:col-span-1 w-full px-4 py-3 rounded-xl bg-card text-white text-sm placeholder:text-white/30 border border-white/10">
          <input required type="email" placeholder="Correo electrónico" class="col-span-2 sm:col-span-1 w-full px-4 py-3 rounded-xl bg-card text-white text-sm placeholder:text-white/30 border border-white/10">
          <input required type="tel" placeholder="Teléfono" class="col-span-2 w-full px-4 py-3 rounded-xl bg-card text-white text-sm placeholder:text-white/30 border border-white/10">
          <textarea required placeholder="Mensaje" rows="4" class="col-span-2 w-full px-4 py-3 rounded-xl bg-card text-white text-sm placeholder:text-white/30 border border-white/10"></textarea>
          <button type="submit" class="col-span-2 bg-rust hover:bg-rust-2 text-white font-black uppercase tracking-wider text-xs py-3.5 rounded-xl transition-colors">
            Enviar mensaje <i class="fa-solid fa-paper-plane ml-1"></i>
          </button>
          <p id="contacto-msg" class="col-span-2 hidden text-white text-xs font-semibold bg-white/10 rounded-xl px-4 py-3">¡Gracias por escribirnos! Te responderemos muy pronto.</p>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ============ RESERVAS ============ -->
<section id="reservas" class="py-20 bg-rust scroll-mt-20">
  <div class="max-w-[1400px] mx-auto px-6">
    <div class="text-center mb-10 reveal">
      <p class="font-script text-white/80 text-3xl mb-1">Guárdate un lugar</p>
      <h2 class="text-2xl md:text-3xl font-black text-white tracking-wide">RESERVA TU MESA</h2>
    </div>
    <form id="reserva-form" class="max-w-3xl mx-auto grid sm:grid-cols-2 gap-4 reveal" style="transition-delay:.08s">
      <input required type="text" placeholder="Nombre completo" class="w-full px-4 py-3.5 rounded-xl bg-ink text-white text-sm placeholder:text-white/40 border-0">
      <input required type="tel" placeholder="Teléfono" class="w-full px-4 py-3.5 rounded-xl bg-ink text-white text-sm placeholder:text-white/40 border-0">
      <input required type="date" class="w-full px-4 py-3.5 rounded-xl bg-ink text-white text-sm border-0">
      <input required type="time" class="w-full px-4 py-3.5 rounded-xl bg-ink text-white text-sm border-0">
      <select required class="sm:col-span-2 w-full px-4 py-3.5 rounded-xl bg-ink text-white text-sm border-0">
        <option value="">Número de personas</option>
        <option>1 - 2 personas</option><option>3 - 4 personas</option><option>5 - 6 personas</option><option>7 o más</option>
      </select>
      <button type="submit" class="sm:col-span-2 bg-ink hover:bg-black text-white font-black uppercase tracking-wider text-sm py-4 rounded-xl transition-colors">Reservar ahora</button>
      <p id="reserva-msg" class="sm:col-span-2 hidden text-white text-sm font-semibold bg-black/20 rounded-xl px-4 py-3 text-center">¡Gracias! Se abrió WhatsApp con tu reserva, solo dale enviar y te confirmamos.</p>
    </form>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="bg-ink pt-14 pb-8 border-t border-white/10">
  <div class="max-w-[1400px] mx-auto px-6 text-center">
    <span class="font-script text-3xl text-white block mb-3">Zuñiga</span>
    <p class="text-white/40 text-sm mb-8">El auténtico sabor italiano. Hecho con pasión desde 2015.</p>

    <div class="flex justify-center gap-3 mb-8">
      @forelse ($redesSociales as $red => $url)
        @continue(empty($url))
        <a href="{{ $url }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-gold/40 text-gold hover:bg-gold hover:text-ink flex items-center justify-center transition-colors">
          <i class="{{ in_array($red, $iconosMarca) ? 'fa-brands fa-' . $red : 'fa-solid fa-link' }}"></i>
        </a>
      @empty
        <a href="https://wa.me/{{ $telefonoWa }}" class="w-10 h-10 rounded-full border border-gold/40 text-gold hover:bg-gold hover:text-ink flex items-center justify-center transition-colors"><i class="fa-brands fa-whatsapp"></i></a>
      @endforelse
    </div>

    <ul class="flex flex-wrap justify-center gap-x-8 gap-y-2 text-sm text-white/40 mb-8">
      <li><a href="#inicio" class="hover:text-rust transition-colors">Inicio</a></li>
      <li><a href="#nosotros" class="hover:text-rust transition-colors">Nosotros</a></li>
      <li><a href="#menu" class="hover:text-rust transition-colors">Menú</a></li>
      <li><a href="#galeria" class="hover:text-rust transition-colors">Galería</a></li>
      <li><a href="#contacto" class="hover:text-rust transition-colors">Contacto</a></li>
      <li><a href="#reservas" class="hover:text-rust transition-colors">Reservas</a></li>
    </ul>

    <div class="pt-6 border-t border-white/10">
      <p class="text-white/30 text-xs">&copy; <span id="year"></span> Pizzería Zuñiga. Todos los derechos reservados.</p>
    </div>
  </div>
</footer>

<script>
  const telefonoNegocio = "{{ $telefonoWa }}";

  const clasicas = [
    ['Americana', 'Mozzarella, jamón y salame', 30, 40, 62, 4.8, 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=600&auto=format&fit=crop'],
    ['Oriental', 'Mozzarella, jamón, champiñón y cebolla', 32, 40, 62, 4.6, 'https://images.unsplash.com/photo-1571407970349-bc81e7e96d47?q=80&w=600&auto=format&fit=crop'],
    ['Hawaiana', 'Mozzarella, jamón y piña', 32, 44, 67, 4.5, 'https://images.unsplash.com/photo-1594007654729-407eedc4be65?q=80&w=600&auto=format&fit=crop'],
    ['Vegetariana', 'Champiñón, cebolla, aceituna y pimiento', 32, 40, 62, 4.7, 'https://images.unsplash.com/photo-1601924582970-9238bcb495d9?q=80&w=600&auto=format&fit=crop'],
    ['Francesa', 'Mozzarella, champiñón, pimiento y cebolla', 32, 40, 62, 4.6, 'https://images.unsplash.com/photo-1548369937-47519962c11a?q=80&w=600&auto=format&fit=crop'],
    ['Delicia', 'Champiñón, pimiento, aceitunas y salame', 32, 40, 62, 4.9, 'https://images.unsplash.com/photo-1552539618-7eec9b4d1796?q=80&w=600&auto=format&fit=crop'],
    ['Jamón', 'Jamón, pimiento y aceitunas', 32, 40, 62, 4.5, 'https://images.unsplash.com/photo-1600628421066-f6bda6a7b976?q=80&w=600&auto=format&fit=crop'],
    ['Salame', 'Mozzarella, salame, pimiento y aceituna', 32, 40, 62, 4.7, 'https://images.unsplash.com/photo-1541745537411-b8046dc6d66c?q=80&w=600&auto=format&fit=crop'],
  ];

  const especiales = [
    ['Pizza Zuñiga Especial', 'Jamón, tocino, salame, chorizo, carne, champiñones, aceitunas, pimiento, mozzarella', 50, 60, 85, 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop'],
    ['Full Carne', 'Tocino, chorizo, carne lomo fino, mozzarella, cebolla', 50, 60, 85, 'https://images.unsplash.com/photo-1628840042765-356cda07504e?q=80&w=1200&auto=format&fit=crop'],
    ['California', 'Jamón, tocino, chorizo, salame, cabanossi, aceituna, piña, mozzarella', 45, 55, 75, 'https://images.unsplash.com/photo-1541745537411-b8046dc6d66c?q=80&w=1200&auto=format&fit=crop'],
    ['Continental', 'Jamón, tocino, chorizo, salame, mozzarella', 40, 50, 77, 'https://images.unsplash.com/photo-1548369937-47519962c11a?q=80&w=1200&auto=format&fit=crop'],
  ];

  function starRow(rating) {
    let out = '';
    for (let i = 1; i <= 5; i++) {
      out += `<i class="fa-solid fa-star ${i <= Math.round(rating) ? 'text-gold' : 'text-white/15'}"></i>`;
    }
    return out;
  }

  const clasicasGrid = document.getElementById('clasicas-grid');
  clasicas.forEach((p, i) => {
    const [nombre, desc, familiar, grande, xl, rating, img] = p;
    const card = document.createElement('article');
    card.className = 'menu-card bg-card rounded-2xl overflow-hidden border border-white/10 reveal';
    card.style.transitionDelay = (i % 4) * 0.05 + 's';
    card.innerHTML = `
      <div class="h-36 overflow-hidden"><img src="${img}" alt="${nombre}" class="w-full h-full object-cover" loading="lazy"></div>
      <div class="p-4">
        <div class="text-xs mb-2">${starRow(rating)}</div>
        <h3 class="text-white font-bold text-sm mb-1">${nombre}</h3>
        <p class="text-white/40 text-[11px] mb-3 leading-relaxed min-h-[28px]">${desc}</p>
        <div class="grid grid-cols-3 gap-1.5 mb-3 text-center">
          <div class="bg-ink rounded-lg py-1.5"><p class="text-[8px] text-white/40 font-bold uppercase">Fam</p><p class="text-gold font-black text-xs">S/${familiar}</p></div>
          <div class="bg-ink rounded-lg py-1.5"><p class="text-[8px] text-white/40 font-bold uppercase">Gde</p><p class="text-gold font-black text-xs">S/${grande}</p></div>
          <div class="bg-ink rounded-lg py-1.5"><p class="text-[8px] text-white/40 font-bold uppercase">XL</p><p class="text-gold font-black text-xs">S/${xl}</p></div>
        </div>
        <a href="https://wa.me/${telefonoNegocio}?text=Quiero%20una%20pizza%20${encodeURIComponent(nombre)}" class="w-full inline-flex items-center justify-center gap-1.5 bg-rust hover:bg-rust-2 text-white text-[10px] font-black uppercase px-3 py-2 rounded-full transition-colors">
          Pedir <i class="fa-brands fa-whatsapp"></i>
        </a>
      </div>`;
    clasicasGrid.appendChild(card);
  });

  const especialesGrid = document.getElementById('especiales-grid');
  especiales.forEach((p, i) => {
    const [nombre, desc, familiar, grande, xl, img] = p;
    const card = document.createElement('article');
    card.className = 'menu-card relative rounded-2xl overflow-hidden border border-gold/30 reveal h-64';
    card.style.transitionDelay = (i % 2) * 0.08 + 's';
    card.innerHTML = `
      <img src="${img}" alt="${nombre}" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
      <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/60 to-transparent"></div>
      <div class="absolute top-4 right-4 bg-gold text-ink text-center rounded-xl px-3 py-2 shadow-lg">
        <p class="text-[9px] font-bold uppercase leading-none">Desde</p>
        <p class="font-black text-lg leading-none">S/${familiar}</p>
      </div>
      <div class="absolute bottom-0 left-0 right-0 p-5">
        <h3 class="text-white font-bold text-lg mb-1">${nombre}</h3>
        <p class="text-white/60 text-xs mb-3 leading-relaxed">${desc}</p>
        <a href="https://wa.me/${telefonoNegocio}?text=Quiero%20una%20pizza%20${encodeURIComponent(nombre)}" class="inline-flex items-center gap-1.5 bg-rust hover:bg-rust-2 text-white text-[10px] font-black uppercase px-3 py-2 rounded-full transition-colors">
          Pedir por WhatsApp <i class="fa-brands fa-whatsapp"></i>
        </a>
      </div>`;
    especialesGrid.appendChild(card);
  });

  // testimonial carousel
  const testiSlides = document.querySelectorAll('.testi-slide');
  const testiDots = document.getElementById('testi-dots');
  let testiIndex = 0;
  testiSlides.forEach((_, i) => {
    const dot = document.createElement('button');
    dot.className = `w-2 h-2 rounded-full transition-colors ${i === 0 ? 'bg-rust' : 'bg-white/20'}`;
    dot.addEventListener('click', () => showTesti(i));
    testiDots.appendChild(dot);
  });
  function showTesti(i) {
    testiSlides.forEach(s => s.classList.remove('active'));
    testiDots.querySelectorAll('button').forEach(d => d.className = 'w-2 h-2 rounded-full transition-colors bg-white/20');
    testiSlides[i].classList.add('active');
    testiDots.children[i].className = 'w-2 h-2 rounded-full transition-colors bg-rust';
    testiIndex = i;
  }
  setInterval(() => showTesti((testiIndex + 1) % testiSlides.length), 5000);

  // reveal on scroll
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
  }, { threshold: 0.12 });
  document.querySelectorAll('.reveal').forEach(el => io.observe(el));

  // reserva form -> WhatsApp
  document.getElementById('reserva-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const inputs = this.querySelectorAll('input, select');
    const nombre = inputs[0].value, telefono = inputs[1].value, fecha = inputs[2].value, hora = inputs[3].value, personas = inputs[4].value;
    let fechaLegible = fecha;
    if (fecha) { const [y, m, d] = fecha.split('-'); fechaLegible = `${d}/${m}/${y}`; }
    const mensaje = `🍕 *Nueva reserva de mesa*%0A------------------------%0A*Nombre:* ${encodeURIComponent(nombre)}%0A*Teléfono:* ${encodeURIComponent(telefono)}%0A*Fecha:* ${encodeURIComponent(fechaLegible)}%0A*Hora:* ${encodeURIComponent(hora)}%0A*Personas:* ${encodeURIComponent(personas)}`;
    window.open(`https://wa.me/${telefonoNegocio}?text=${mensaje}`, '_blank');
    document.getElementById('reserva-msg').classList.remove('hidden');
    this.reset();
  });

  document.getElementById('contacto-form').addEventListener('submit', function (e) {
    e.preventDefault();
    document.getElementById('contacto-msg').classList.remove('hidden');
    this.reset();
  });

  document.getElementById('year').textContent = new Date().getFullYear();

  // navbar active state
  const navLinks = Array.from(document.querySelectorAll('[data-nav]'));
  const sections = navLinks.map(link => document.querySelector(link.getAttribute('href'))).filter(Boolean);
  function setActive(id) { navLinks.forEach(link => link.classList.toggle('active', link.getAttribute('href') === `#${id}`)); }
  navLinks.forEach(link => link.addEventListener('click', () => setActive(link.getAttribute('href').slice(1))));
  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => { if (entry.isIntersecting) setActive(entry.target.id); });
  }, { rootMargin: '-45% 0px -45% 0px', threshold: 0 });
  sections.forEach(section => sectionObserver.observe(section));
</script>
</body>
</html>