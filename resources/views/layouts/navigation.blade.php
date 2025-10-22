{{-- resources/views/partials/navbar.blade.php --}}
<nav
  x-data="{ open:false, userMenu:false }"
  class="fixed inset-x-0 top-0 z-50 nav-wrap"
  x-on:keydown.escape.window="open=false; userMenu=false"
>
  <style>
    :root{
      /* Theme */
      --ink:#013C58; --ink2:#0B2D42;
      --sky:#A8E8F9; --amber:#F5A201; --amber2:#FFBA42;

      /* Size */
      --nav-h: 58px;      /* base height */
      --nav-h-md: 68px;   /* desktop height */
      --avatar: 36px;     /* avatar size */
      --radius: 14px;
    }

    /* ===== NAV WRAP ===== */
    .nav-wrap{
      height: var(--nav-h);
      backdrop-filter: saturate(160%) blur(8px);
      background:
        radial-gradient(900px 280px at -10% -20%, rgba(168,232,249,.18), transparent 55%),
        radial-gradient(800px 260px at 110% -10%, rgba(255,211,91,.16), transparent 55%),
        linear-gradient(180deg, rgba(1,60,88,.94), rgba(1,60,88,.88));
      border-bottom: 1px solid rgba(168,232,249,.15);
      transition: background .25s ease, box-shadow .25s ease, height .2s ease;
    }
    @media (min-width: 768px){
      .nav-wrap{ height: var(--nav-h-md); }
    }
    /* shrink on scroll */
    .nav-wrap.shrink{
      background:
        radial-gradient(900px 260px at -10% -40%, rgba(168,232,249,.14), transparent 55%),
        radial-gradient(800px 240px at 110% -30%, rgba(255,211,91,.14), transparent 55%),
        linear-gradient(180deg, rgba(1,60,88,.98), rgba(1,60,88,.94));
      box-shadow: 0 10px 26px rgba(1,60,88,.25);
      height: calc(var(--nav-h) - 6px);
    }
    @media (min-width: 768px){
      .nav-wrap.shrink{ height: calc(var(--nav-h-md) - 8px); }
    }

    /* Container height keeper */
    .nav-inner{ height: 100%; }

    /* ===== BRAND ===== */
    .brand{
      position: relative;
      color:#FFD35B; font-weight:900; letter-spacing:.2px;
      text-shadow:0 1px 0 rgba(0,0,0,.18);
      display:inline-flex; align-items:center; gap:.55rem;
    }
    .brand::before{
      content:"";
      width:28px;height:28px;border-radius:8px;
      background:linear-gradient(135deg,var(--amber2),var(--sky));
      box-shadow:0 6px 16px rgba(245,162,1,.25), inset 0 1px 0 #fff8;
    }

    /* ===== LINKS ===== */
    .nav-link{
      position:relative; display:inline-flex; align-items:center; gap:.45rem;
      font-weight:800; color:rgba(168,232,249,.92);
      padding:.40rem .70rem; border-radius:.7rem; line-height:1; font-size:.95rem;
      transition: color .16s ease, background .16s ease, transform .12s ease, box-shadow .16s ease;
    }
    .nav-link:hover{ color:#FFBA42; background:rgba(168,232,249,.10) }
    .nav-link:active{ transform:translateY(1px) }
    .nav-link.active{
      color:#102b3a;
      background:linear-gradient(90deg,var(--amber),var(--amber2));
      box-shadow:0 10px 22px rgba(245,162,1,.28);
    }
    /* subtle underline for non-active */
    .nav-link:not(.active)::after{
      content:""; position:absolute; left:.55rem; right:.55rem; bottom:.14rem; height:2px;
      background:linear-gradient(90deg,transparent,rgba(255,211,91,.75),transparent);
      transform:scaleX(0); transform-origin:center; transition:transform .18s ease;
    }
    .nav-link:hover::after{ transform:scaleX(1) }

    /* CTA (guest) */
    .btn-cta{
      background:linear-gradient(90deg,var(--amber),var(--amber2));
      color:#102b3a; font-weight:900; border-radius:.8rem;
      padding:.50rem .9rem; font-size:.92rem;
      box-shadow:0 10px 22px rgba(245,162,1,.26);
      transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-cta:hover{ transform:translateY(-1px) }

    /* Avatar */
    .avatar{
      width:var(--avatar); height:var(--avatar); border-radius:999px;
      background:#FFBA42; color:var(--ink);
      display:grid; place-items:center; font-weight:900; font-size:.95rem;
      box-shadow:0 6px 16px rgba(245,162,1,.32), inset 0 1px 0 #fff7;
      transition: transform .12s ease;
    }
    .avatar:hover{ transform: translateY(-1px) }

    /* Dropdown */
    .dropdown{
      background:#fff; border:1px solid #E5E7EB; border-radius:var(--radius);
      overflow:hidden; box-shadow:0 18px 40px rgba(1,60,88,.20);
    }
    .drop-item{
      display:flex; align-items:center; gap:.6rem; padding:.70rem .95rem;
      font-weight:800; color:#0B2D42; font-size:.95rem;
      transition: background .15s ease;
    }
    .drop-item:hover{ background:#F8FAFC }

    /* Mobile links */
    .mobile-link{
      display:block; padding:.70rem 1rem; border-radius:.7rem;
      font-weight:900; color:rgba(168,232,249,.98); font-size:1rem;
    }
    .mobile-link.active{
      color:#102b3a; background:linear-gradient(90deg,var(--amber),var(--amber2));
    }

    /* Mobile panel animation */
    .mobile-panel{ overflow:hidden; max-height:0; opacity:0; transition:max-height .3s ease, opacity .25s ease }
    .mobile-panel[aria-expanded="true"]{ max-height:420px; opacity:1 }

    /* Prefers reduced motion */
    @media (prefers-reduced-motion: reduce){
      *{ animation-duration:.01ms !important; transition-duration:.01ms !important }
    }
  </style>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 nav-inner">
    <div class="h-full flex items-center justify-between gap-3">
      {{-- Brand --}}
      <a href="{{ route('home') }}" class="brand text-lg md:text-xl">Qinclong Laundry</a>

      {{-- Desktop links --}}
      <div class="hidden md:flex items-center gap-2">
        @guest
          <a href="#home" class="nav-link">Home</a>
          <a href="#about" class="nav-link">About</a>
          <a href="#layanan" class="nav-link">Services</a>
          <a href="#choose" class="nav-link">Why Us</a>
          <a href="#testimoni" class="nav-link">Testimonials</a>
          <a href="#lokasi" class="nav-link">Location</a>
        @endguest

        @auth
          @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">Kelola Pesanan</a>
            <a href="{{ route('admin.services') }}" class="nav-link {{ request()->routeIs('admin.services') ? 'active' : '' }}">Kelola Layanan</a>
            <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}">Kelola Pembayaran</a>
            <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">Laporan</a>
          @else
            <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('user.orders.create') }}" class="nav-link {{ request()->routeIs('user.orders.create') ? 'active' : '' }}">Pesan</a>
            <a href="{{ route('user.orders.history') }}" class="nav-link {{ request()->routeIs('user.orders.history') ? 'active' : '' }}">Riwayat</a>
          @endif
        @endauth
      </div>

      {{-- Right: auth / avatar --}}
      <div class="hidden md:flex items-center gap-2">
        @guest
          <a href="{{ route('login') }}" class="btn-cta">Masuk / Daftar</a>
        @endguest

        @auth
          <div class="relative" @click.away="userMenu=false">
            <button aria-haspopup="true" :aria-expanded="userMenu" @click="userMenu=!userMenu" class="avatar">
              {{ strtoupper(mb_substr(Auth::user()->name,0,1)) }}
            </button>
            <div x-show="userMenu" x-transition
                 class="dropdown absolute right-0 mt-2 w-56">
              <div class="p-3 border-b">
                <div class="text-sm font-extrabold text-[var(--ink2)]">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
              </div>

              <a href="{{ route('profile.edit') }}" class="drop-item">
                <i class="fa-solid fa-user-gear text-[var(--ink)]"></i> Kelola Profil
              </a>

              @if(Auth::user()->role !== 'admin')
              <a href="{{ route('user.notifications.index') }}" class="drop-item">
                <i class="fa-solid fa-bell text-[var(--ink)]"></i> Notifikasi
              </a>
              @endif

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="drop-item w-full text-left">
                  <i class="fa-solid fa-right-from-bracket text-red-600"></i> Keluar
                </button>
              </form>
            </div>
          </div>
        @endauth
      </div>

      {{-- Mobile toggler --}}
      <button @click="open=!open"
              class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white/10 text-white hover:bg-white/15"
              :aria-expanded="open" aria-controls="mobile-panel" aria-label="Toggle navigation">
        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </div>

  {{-- Mobile panel --}}
  <div id="mobile-panel"
       x-show="open"
       x-transition
       class="md:hidden border-t border-white/10 bg-[rgba(1,60,88,.96)] backdrop-blur mobile-panel"
       :aria-expanded="open ? 'true' : 'false'">
    <div class="max-w-7xl mx-auto px-4 py-2 space-y-1">
      @guest
        <a href="#home" class="mobile-link">Home</a>
        <a href="#about" class="mobile-link">About</a>
        <a href="#layanan" class="mobile-link">Services</a>
        <a href="#choose" class="mobile-link">Why Us</a>
        <a href="#testimoni" class="mobile-link">Testimonials</a>
        <a href="#lokasi" class="mobile-link">Location</a>
        <div class="pt-1"><a href="{{ route('login') }}" class="btn-cta block text-center">Masuk / Daftar</a></div>
      @endguest

      @auth
        @if(Auth::user()->role === 'admin')
          <a href="{{ route('admin.dashboard') }}" class="mobile-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('admin.orders.index') }}" class="mobile-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">Kelola Pesanan</a>
          <a href="{{ route('admin.services') }}" class="mobile-link {{ request()->routeIs('admin.services') ? 'active' : '' }}">Kelola Layanan</a>
          <a href="{{ route('admin.payments.index') }}" class="mobile-link {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}">Kelola Pembayaran</a>
          <a href="{{ route('admin.reports') }}" class="mobile-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">Laporan</a>
        @else
          <a href="{{ route('user.dashboard') }}" class="mobile-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('user.orders.create') }}" class="mobile-link {{ request()->routeIs('user.orders.create') ? 'active' : '' }}">Pesan</a>
          <a href="{{ route('user.orders.history') }}" class="mobile-link {{ request()->routeIs('user.orders.history') ? 'active' : '' }}">Riwayat</a>
          <a href="{{ route('user.notifications.index') }}" class="mobile-link">Notifikasi</a>
        @endif

        <div class="grid grid-cols-2 gap-2 pt-1">
          <a href="{{ route('profile.edit') }}" class="btn-cta text-center">Profil</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-cta w-full text-center">Keluar</button>
          </form>
        </div>
      @endauth
    </div>
  </div>

  {{-- Font Awesome (jika belum dimuat di layout) --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>

  {{-- Shrink-on-scroll + close mobile saat route berubah (HTMX/Livewire friendly) --}}
  <script>
    const onScroll = () => {
      const nav = document.querySelector('.nav-wrap');
      if (!nav) return;
      if (window.scrollY > 6) nav.classList.add('shrink'); else nav.classList.remove('shrink');
    };
    document.addEventListener('scroll', onScroll, {passive:true});
    document.addEventListener('DOMContentLoaded', onScroll);

    // Optional: auto-close mobile menu ketika klik link
    document.querySelectorAll('#mobile-panel a').forEach(a=>{
      a.addEventListener('click', ()=>{ const root=document.querySelector('[x-data]'); if(root){ root.__x.$data.open=false; }});
    });
  </script>
</nav>

{{-- Spacer: sesuaikan dengan tinggi nav (ikuti shrink otomatis) --}}
<div class="h-[58px] md:h-[68px]"></div>
