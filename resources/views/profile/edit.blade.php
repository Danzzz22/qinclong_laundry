{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>
  {{-- =====================  STYLES  ===================== --}}
  <style>
    :root{
      --ink:#0B2D42; --sea:#013C58;
      --amber:#F5A201; --amber2:#FFBA42;
      --mint:#16a34a; --rose:#ef4444; --sky:#A8E8F9
    }

    /* Sembunyikan bottom nav global (kalau ada) khusus di halaman ini */
    .account-hub nav.fixed.bottom-0.inset-x-0{ display:none !important }

    /* ---------- HERO ---------- */
    .account-hub .hero{
      position:relative; overflow:hidden; border-radius:18px;
      background:
        radial-gradient(1200px 400px at -20% -30%, rgba(168,232,249,.45), transparent 60%),
        radial-gradient(1000px 380px at 130% -35%, rgba(255,186,66,.35), transparent 60%),
        linear-gradient(90deg, #FDF7E6, #EAF9FF);
      border:1px solid #edf2f7; box-shadow:0 20px 50px rgba(1,60,88,.06);
    }
    .account-hub .hero h1{ color:var(--sea) }
    .account-hub .hero .sub{ color:#3b5568 }

    /* ---------- LAYOUT ---------- */
    .account-hub .hub-grid{
      display:grid; gap:18px;
      grid-template-columns: 1fr;
    }
    @media (min-width: 1024px){
      .account-hub .hub-grid{ grid-template-columns: 280px minmax(0,1fr) }
    }

    /* ---------- SIDEBAR CARD ---------- */
    .account-hub .card{
      background:#fff; border:1px solid #edf2f7; border-radius:16px;
      box-shadow:0 12px 34px rgba(1,60,88,.06)
    }
    .account-hub .card .hd{ padding:16px 16px 0; }
    .account-hub .card .bd{ padding:16px }
    .account-hub .pill{
      font-weight:800; font-size:.72rem; padding:.28rem .5rem; border-radius:999px; display:inline-flex; align-items:center; gap:.35rem
    }
    .account-hub .pill-ok{ background:#dcfce7; color:#166534 }
    .account-hub .pill-warn{ background:#fef3c7; color:#92400e }
    .account-hub .pill-badge{ background:linear-gradient(90deg,var(--amber),var(--amber2)); color:#102b3a }

    .account-hub .avatar{
      width:84px; height:84px; border-radius:22px; display:grid; place-items:center;
      background:linear-gradient(135deg,#fdf2c7,#e8f6ff); color:var(--sea);
      font-weight:900; font-size:32px; box-shadow:0 12px 30px rgba(1,60,88,.12);
      border:1px solid #e9eef5
    }

    .account-hub .quick button,
    .account-hub .quick a{
      display:flex; align-items:center; gap:.5rem; width:100%;
      padding:.64rem .8rem; border-radius:12px; border:1px solid #edf2f7;
      background:#fff; font-weight:700; color:#27485a;
      transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease;
    }
    .account-hub .quick button:hover,
    .account-hub .quick a:hover{
      transform:translateY(-1px);
      box-shadow:0 10px 24px rgba(1,60,88,.08);
      border-color:#e6eef5
    }

    /* Checklist */
    .account-hub .checklist li{
      display:flex; align-items:flex-start; gap:.6rem; font-size:.9rem; color:#446173
    }
    .account-hub .checklist i{ margin-top:.15rem }

    /* ---------- TABS ---------- */
    .account-hub .tabs{
      position:sticky; top:12px; z-index:1;
      background:#fff; padding:6px; border-radius:14px; border:1px solid #edf2f7;
      display:flex; gap:6px; box-shadow:0 10px 26px rgba(1,60,88,.05)
    }
    .account-hub .tab-btn{
      flex:1 1 auto; text-align:center; padding:.65rem .8rem; border-radius:10px;
      font-weight:900; color:#27485a; border:1px solid transparent; background:transparent;
      transition:all .15s ease
    }
    .account-hub .tab-btn[aria-selected="true"]{
      background:linear-gradient(90deg, #fff8e1, #eaf9ff);
      border-color:#e9eef5; color:#0b2d42; box-shadow:0 10px 24px rgba(1,60,88,.06)
    }

    /* ---------- PANEL ---------- */
    .account-hub .panel{
      margin-top:14px; background:#fff; border:1px solid #edf2f7; border-radius:16px;
      box-shadow:0 14px 34px rgba(1,60,88,.06)
    }
    .account-hub .panel .head{ padding:18px 18px 0 }
    .account-hub .panel .body{ padding:18px }

    /* ---------- FORM OVERRIDES (partial Jetstream) ---------- */
    .account-hub .form-modern input[type="text"],
    .account-hub .form-modern input[type="email"],
    .account-hub .form-modern input[type="password"],
    .account-hub .form-modern input[type="number"],
    .account-hub .form-modern textarea,
    .account-hub .form-modern select{
      border-radius:12px !important; border:1px solid #e5e7eb !important; background:#fff !important;
      padding:.75rem .9rem !important; transition:box-shadow .15s ease,border-color .15s ease
    }
    .account-hub .form-modern input:focus,
    .account-hub .form-modern textarea:focus,
    .account-hub .form-modern select:focus{
      outline:none !important; border-color:var(--amber) !important; box-shadow:0 0 0 4px rgba(245,162,1,.18) !important
    }
    .account-hub .form-modern [type="submit"],
    .account-hub .form-modern button.inline-flex{
      border-radius:12px !important; font-weight:900 !important;
      background-image:linear-gradient(90deg,var(--amber),var(--amber2)) !important;
      color:#102b3a !important; border:none !important;
      box-shadow:0 12px 28px rgba(245,162,1,.25) !important
    }
    .account-hub .form-modern [type="submit"]:hover,
    .account-hub .form-modern button.inline-flex:hover{
      transform:translateY(-1px); box-shadow:0 16px 36px rgba(245,162,1,.32) !important
    }

    /* Danger overrides */
    .account-hub .danger-zone .panel{ border-color:#fee2e2; box-shadow:0 14px 34px rgba(239,68,68,.06) }
    .account-hub .danger-zone .panel .head h3{ color:#991b1b }
    .account-hub .danger-zone .form-modern [type="submit"],
    .account-hub .danger-zone .form-modern button.inline-flex{
      background:#ef4444 !important; color:#fff !important; box-shadow:0 14px 34px rgba(239,68,68,.22) !important
    }

    /* Toast anim (boleh global, ringan) */
    @keyframes toast-in{from{opacity:0; transform:translateY(-8px)}to{opacity:1; transform:translateY(0)}}
    .toast{ animation:toast-in .25s ease both }
  </style>

  @php
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $initial = mb_strtoupper(mb_substr($user->name ?? 'U', 0, 1, 'UTF-8'));
    $memberSince = optional($user->created_at)->format('d M Y');
    $needsVerify = method_exists($user,'hasVerifiedEmail') ? ! $user->hasVerifiedEmail() : false;

    // Skor completeness sederhana
    $score = 0;
    if(!empty($user->name)) $score += 40;
    if(!empty($user->email)) $score += 40;
    if(!$needsVerify) $score += 20;
  @endphp

  <div class="account-hub min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 lg:px-6 space-y-6">

      {{-- ===================== HERO ===================== --}}
      <section class="hero p-4 lg:p-5">
        <div class="flex items-center justify-between gap-4">
          <div>
            <h1 class="text-2xl lg:text-3xl font-black">Account Hub</h1>
            <p class="sub mt-1 text-sm">
              Kelola identitas, keamanan, dan tindakan sensitif akunmu di satu tempat.
            </p>
          </div>
          <div class="hidden md:flex items-center gap-3">
            <span class="pill pill-badge">Completion {{ $score }}%</span>
            @if($needsVerify)
              <span class="pill pill-warn"><i class="fa-solid fa-triangle-exclamation"></i> Email belum terverifikasi</span>
            @else
              <span class="pill pill-ok"><i class="fa-solid fa-check"></i> Terverifikasi</span>
            @endif
          </div>
        </div>
      </section>

      {{-- ===================== BODY GRID ===================== --}}
      <div class="hub-grid">

        {{-- ============ SIDEBAR ============ --}}
        <aside class="card">
          <div class="hd">
            <div class="flex items-center gap-3">
              <div class="avatar">{{ $initial }}</div>
              <div>
                <div class="text-lg font-extrabold text-[var(--sea)] leading-tight">
                  {{ $user->name }}
                </div>
                <div class="text-sm text-[#5c7283]">{{ $user->email }}</div>
                <div class="mt-1 text-[11px] text-[#8ba0af]">Member sejak {{ $memberSince }}</div>
              </div>
            </div>
          </div>

          <div class="bd">
            {{-- quick actions --}}
            <div class="quick grid gap-2">
              <button type="button" data-tab-btn="profile"><i class="fa-solid fa-id-card"></i> Profil</button>
              <button type="button" data-tab-btn="security"><i class="fa-solid fa-shield-halved"></i> Keamanan</button>
              <button type="button" data-tab-btn="danger"><i class="fa-solid fa-user-slash"></i> Danger Zone</button>
            </div>

            {{-- checklist kecil --}}
            <div class="mt-5 p-3 rounded-xl border border-slate-100 bg-slate-50/70">
              <div class="font-black text-[var(--sea)] mb-2 text-sm">Checklist Akun</div>
              <ul class="checklist space-y-2">
                <li>
                  <i class="fa-regular fa-circle-check {{ !empty($user->name) ? 'text-green-600' : 'text-gray-400' }}"></i>
                  Lengkapi nama lengkap
                </li>
                <li>
                  <i class="fa-regular fa-circle-check {{ $needsVerify ? 'text-gray-400' : 'text-green-600' }}"></i>
                  Verifikasi email
                </li>
                <li>
                  <i class="fa-regular fa-circle-check text-gray-400"></i>
                  Gunakan kata sandi kuat (8+ karakter, kombinasi)
                </li>
              </ul>
            </div>
          </div>
        </aside>

        {{-- ============ MAIN ============ --}}
        <main>
          {{-- Tabs --}}
          <div class="tabs">
            <button class="tab-btn" data-tab="profile" aria-selected="true"><i class="fa-solid fa-id-card mr-1.5"></i> Profil</button>
            <button class="tab-btn" data-tab="security"><i class="fa-solid fa-lock mr-1.5"></i> Keamanan</button>
            <button class="tab-btn" data-tab="danger"><i class="fa-solid fa-skull mr-1.5"></i> Danger Zone</button>
          </div>

          {{-- Profile panel --}}
          <section class="panel" data-panel="profile">
            <div class="head">
              <h3 class="text-xl font-black text-[var(--sea)]">Informasi Akun</h3>
              <p class="text-sm text-[#5c7283]">Perbarui nama, email, dan informasi dasar.</p>
            </div>
            <div class="body form-modern">
              @include('profile.partials.update-profile-information-form')
            </div>
          </section>

          {{-- Security panel --}}
          <section class="panel" data-panel="security" hidden>
            <div class="head">
              <h3 class="text-xl font-black text-[var(--sea)]">Keamanan</h3>
              <p class="text-sm text-[#5c7283]">Ganti kata sandi dan jaga keamanan akunmu.</p>
            </div>
            <div class="body form-modern">
              @include('profile.partials.update-password-form')
            </div>
          </section>

          {{-- Danger panel --}}
          <section class="panel danger-zone" data-panel="danger" hidden>
            <div class="head">
              <h3 class="text-xl font-black">Hapus Akun</h3>
              <p class="text-sm text-[#7f1d1d]">Tindakan ini permanen. Semua data akan terhapus.</p>
            </div>
            <div class="body form-modern">
              @include('profile.partials.delete-user-form')
            </div>
          </section>
        </main>
      </div>
    </div>
  </div>

  {{-- ===================== TOAST (opsional) ===================== --}}
  @if (session('status') || session('success') || session('error'))
    <div class="fixed top-4 right-4 z-50 space-y-3 w-[calc(100%-2rem)] max-w-sm">
      @if (session('success') || session('status')==='profile-updated')
        <div class="toast flex items-start gap-3 rounded-xl bg-white/95 backdrop-blur shadow-lg ring-1 ring-green-200 p-4">
          <div class="shrink-0 w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center">
            <i class="fa-solid fa-check"></i>
          </div>
          <div class="text-sm text-gray-700">
            <p class="font-semibold text-green-700">Berhasil</p>
            <p>{{ session('success') ?? 'Profil berhasil diperbarui.' }}</p>
          </div>
          <button class="ml-auto text-gray-400 hover:text-gray-600" onclick="this.closest('.toast').remove()">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      @endif

      @if (session('error'))
        <div class="toast flex items-start gap-3 rounded-xl bg-white/95 backdrop-blur shadow-lg ring-1 ring-red-200 p-4">
          <div class="shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-700 flex items-center justify-center">
            <i class="fa-solid fa-triangle-exclamation"></i>
          </div>
          <div class="text-sm text-gray-700">
            <p class="font-semibold text-red-700">Gagal</p>
            <p>{{ session('error') }}</p>
          </div>
          <button class="ml-auto text-gray-400 hover:text-gray-600" onclick="this.closest('.toast').remove()">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      @endif
    </div>
  @endif

  {{-- ===================== SCRIPTS ===================== --}}
  <script>
    // Tabs minimal (tanpa lib)
    (function(){
      const key = 'profileTab';
      const buttons = document.querySelectorAll('.account-hub .tab-btn');
      const panels  = document.querySelectorAll('.account-hub [data-panel]');
      const quicks  = document.querySelectorAll('.account-hub [data-tab-btn]');
      const select = (name)=>{
        panels.forEach(p=>p.hidden = p.dataset.panel !== name);
        buttons.forEach(b=> b.setAttribute('aria-selected', String(b.dataset.tab === name)));
        localStorage.setItem(key, name);
        const active = document.querySelector(`.account-hub [data-panel="${name}"]`);
        if(active){ active.scrollIntoView({behavior:'smooth', block:'start'}); }
      };
      buttons.forEach(b=> b.addEventListener('click', ()=>select(b.dataset.tab)));
      quicks.forEach(q=> q.addEventListener('click', ()=>select(q.dataset.tabBtn)));
      const saved = localStorage.getItem(key) || 'profile';
      select(saved);
    })();
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
</x-app-layout>
