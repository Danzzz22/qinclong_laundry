<x-app-layout>
  {{-- ===================== THEME & TOKENS ===================== --}}
  <style>
    :root{
      --ink:#0B2D42; --ink-soft:#3d5667;
      --bg:#F6F9FC; --panel:#FFFFFF; --navy:#013C58;
      --sky:#A8E8F9; --amber:#F5A201; --amber2:#FFBA42;
      --ok:#22C55E; --warn:#F59E0B; --info:#60A5FA;

      --fs-xs:.75rem; --fs-sm:.875rem; --fs-md:1rem; --fs-lg:1.125rem; --fs-xl:1.375rem; --fs-2xl:1.75rem;

      --border: color-mix(in oklab, var(--panel), #000 8%);
      --shadow-sm: 0 6px 18px rgba(1,60,88,.08);
      --shadow-md: 0 10px 22px rgba(1,60,88,.08);
      --shadow-lg: 0 18px 36px rgba(1,60,88,.12);

      --table-stripe:#F7FAFF; --table-border:#E3EDF5; --grid:#021f3010;
      --radius:18px;

      --chart-line:#F5A201;
      --chart-area:rgba(245,162,1,.22);
      --chart-grid:#d6e3ed;
      --chart-tick:#5b7385;
      --chart-donut-paid:#22C55E;
      --chart-donut-unpaid:#F59E0B;
      /* warna mix default tetap, tapi nanti dipakai palet JS 15+ warna */
      --chart-mix-1:#60A5FA; --chart-mix-2:#34D399; --chart-mix-3:#F59E0B; --chart-mix-4:#F472B6;

      --space:18px;
    }
    [data-theme="dark"]{
      --ink:#EAF6FF; --ink-soft:#a9c7db;
      --bg:#0E1723; --panel:#0F2231;

      --border:#173145;
      --shadow-sm: 0 6px 14px rgba(0,0,0,.35);
      --shadow-md: 0 12px 28px rgba(0,0,0,.40);
      --shadow-lg: 0 18px 42px rgba(0,0,0,.45);

      --table-stripe:#0f2432; --table-border:#183041; --grid:#ffffff12;

      --chart-line:#FFBA42;
      --chart-area:rgba(255,186,66,.18);
      --chart-grid:#254158;
      --chart-tick:#b8d0e0;
      --chart-donut-paid:#2dd4bf;
      --chart-donut-unpaid:#F59E0B;
    }
    [data-density="compact"]{ --space:14px }
    [data-density="compact"] .chip{ padding:.45rem .8rem; font-size:var(--fs-sm) }
    [data-density="compact"] .qa .btn{ padding:.62rem .9rem }
    [data-density="compact"] .tbl td, [data-density="compact"] .tbl th{ padding:.55rem .75rem !important }

    :root,[data-theme="dark"]{ color-scheme: light dark }
    .page{ color:var(--ink); font-size:var(--fs-md) }
    .muted{ color:var(--ink-soft) }

    .page{
      background:
        radial-gradient(1100px 520px at 12% -12%, color-mix(in oklab, var(--sky) 20%, transparent), transparent 60%),
        radial-gradient(900px 420px at 100% -10%, color-mix(in oklab, var(--amber2) 18%, transparent), transparent 60%),
        linear-gradient(#ffffff, var(--bg));
      transition: background .25s ease, color .25s ease;
      position:relative;
    }
    .page::after{
      content:""; position:fixed; inset:0; pointer-events:none; opacity:.04;
      background-image:
        radial-gradient(2px 2px at 20% 10%, #000 35%, transparent 35%),
        radial-gradient(1.5px 1.5px at 60% 30%, #000 35%, transparent 35%),
        radial-gradient(2px 2px at 80% 70%, #000 35%, transparent 35%);
      background-size: 140px 140px, 180px 180px, 160px 160px;
      mix-blend-mode:multiply;
    }
    [data-theme="dark"] .page{
      background:
        radial-gradient(1000px 500px at 8% -18%, color-mix(in oklab, #1a7bb8 22%, transparent), transparent 58%),
        radial-gradient(900px 380px at 92% -10%, color-mix(in oklab, #f5a201 16%, transparent), transparent 60%),
        linear-gradient(#0B1520, var(--bg));
    }
    [data-theme="dark"] .page::after{ opacity:.06 }

    .grid-deco{
      position:absolute; inset:0; pointer-events:none; opacity:.16; mix-blend:multiply;
      background-image:
        linear-gradient(transparent 31px, var(--grid) 32px),
        linear-gradient(90deg, transparent 31px, var(--grid) 32px);
      background-size:32px 32px;
      mask-image: radial-gradient(1200px 600px at 40% 0%, #000, transparent 70%);
    }
    [data-theme="dark"] .grid-deco{ opacity:.14; mix-blend:normal }

    .section-title{ display:flex; align-items:center; gap:.75rem; font-weight:800; font-size:var(--fs-xl) }
    .section-title::before{
      content:""; width:6px; height:18px; border-radius:6px;
      background: linear-gradient(180deg, var(--amber), var(--amber2));
      box-shadow:0 6px 14px rgba(245,162,1,.25);
    }

    .hero{ position:relative; overflow:hidden; border-radius:1.1rem;
      background: linear-gradient(120deg, color-mix(in oklab, var(--navy) 12%, #0b2d42 88%), #10384d);
      box-shadow: var(--shadow-lg); isolation:isolate; padding:1px;
    }
    .hero-glass{
      position:relative; z-index:1; border-radius:.9rem; padding:.95rem 1.1rem;
      background: linear-gradient(180deg, rgba(255,255,255,.86), rgba(255,255,255,.78));
      backdrop-filter:saturate(140%) blur(8px);
      color:var(--ink); border:1px solid var(--border);
    }
    .hero-glass::after{
      content:""; position:absolute; inset:0; border-radius:inherit; padding:1px; pointer-events:none; opacity:.75;
      background: linear-gradient(90deg, var(--sky), var(--amber2), var(--amber));
      -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
      -webkit-mask-composite: xor; mask-composite: exclude;
    }
    [data-theme="dark"] .hero-glass{
      background: linear-gradient(180deg, rgba(12,30,45,.78), rgba(12,30,45,.72));
      box-shadow: inset 0 1px 0 rgba(255,255,255,.06);
    }
    .hero h1{ font-size: clamp(1.4rem, 1.05rem + 1.2vw, 2rem); font-weight:900 }

    .card{ position:relative; background:var(--panel); border-radius:var(--radius);
      box-shadow: var(--shadow-sm);
      transition: transform .18s ease, box-shadow .18s ease, background .25s ease, color .25s ease, border-color .25s ease;
      border:1px solid var(--border);
    }
    .card:hover{ transform: translateY(-2px); box-shadow: var(--shadow-md) }
    .card::before{
      content:""; position:absolute; inset:0 0 auto 0; height:3px; border-top-left-radius:inherit; border-top-right-radius:inherit;
      background: linear-gradient(90deg, color-mix(in oklab, var(--amber) 78%, transparent), color-mix(in oklab, var(--sky) 70%, transparent));
      opacity:.55;
    }
    .card-header{ display:flex; align-items:center; justify-content:space-between; gap:.75rem; margin-bottom:.5rem }
    .card-header .title{ font-weight:800; font-size:var(--fs-lg) }

    .kpi .icon{ width:44px;height:44px; border-radius:12px; display:grid; place-items:center;
      color:#0B2D42; background:linear-gradient(135deg, var(--amber), var(--amber2)); box-shadow:0 10px 22px rgba(245,162,1,.25)
    }
    .kpi .num{ font-feature-settings:"tnum" on,"lnum" on; letter-spacing:.2px }

    .ring{ position:relative; width:70px; height:70px; border-radius:999px;
      background: conic-gradient(var(--ring-clr) calc(var(--pct)*1%), rgba(2,32,48,.08) 0);
      box-shadow: 0 8px 18px rgba(1,60,88,.10);
    }
    .ring::after{ content:""; position:absolute; inset:9px; border-radius:999px; background:var(--panel);
      box-shadow: inset 0 1px 0 rgba(255,255,255,.35) }
    [data-theme="dark"] .ring{ background: conic-gradient(var(--ring-clr) calc(var(--pct)*1%), rgba(255,255,255,.08) 0) }
    [data-theme="dark"] .ring::after{ background:var(--panel); box-shadow: inset 0 1px 0 rgba(255,255,255,.06) }
    .ring-icon{ position:absolute; inset:0; display:grid; place-items:center; z-index:1; font-size:19px; color:var(--ink) }

    .chip{
      display:inline-flex;align-items:center;gap:.55rem;padding:.55rem .95rem;border-radius:.85rem;font-weight:800;
      border:1px solid var(--table-border); background:#F8FAFC;color:var(--ink);
      transition:background .15s ease, border-color .15s ease, transform .08s ease, color .15s ease
    }
    .chip:hover{ background:#F3F7FB } .chip:active{ transform:translateY(1px) }
    .chip:focus-visible{ outline:2px solid color-mix(in oklab, var(--amber) 50%, #fff 0%); outline-offset:2px }
    [data-theme="dark"] .chip{ background:#0b2130; border-color:#183041; color:#d6e8f6 }
    [data-theme="dark"] .chip:hover{ background:#0e2736 }

    .qa .btn{
      display:flex;align-items:center;gap:.55rem;border-radius:1rem;padding:.72rem 1.05rem;font-weight:900;color:#0f2b3a;
      background:linear-gradient(90deg,var(--amber),var(--amber2)); box-shadow:0 12px 26px rgba(245,162,1,.28);
      transition: transform .12s ease, box-shadow .12s ease, filter .12s ease;
    }
    .qa .btn:hover{ transform:translateY(-1px) }
    .qa .btn:focus-visible{ outline:2px solid #ffffff; outline-offset:2px; filter:saturate(1.05) }

    .legend{ display:grid; grid-template-columns:1fr 1fr; gap:.5rem; font-size:var(--fs-sm) }
    .legend .pill{
      display:flex; align-items:center; gap:.5rem; padding:.6rem .75rem; border-radius:.7rem;
      border:1px solid var(--table-border); background:color-mix(in oklab, var(--panel), #0ea5e900);
    }
    .legend .dot{ width:.6rem; height:.6rem; border-radius:999px }
    .legend .paid  { background: color-mix(in oklab, var(--panel), var(--chart-donut-paid) 10%) }
    .legend .unpaid{ background: color-mix(in oklab, var(--panel), var(--chart-donut-unpaid) 10%) }

    .tbl{ width:100%; border-collapse:separate; border-spacing:0 }
    .tbl thead th{
      position:sticky; top:0; z-index:1; background:#F3F6FA; color:var(--ink); font-size:.74rem;
      text-transform:uppercase; letter-spacing:.02em; font-weight:800; border-bottom:1px solid var(--table-border)
    }
    .tbl td,.tbl th{ vertical-align:middle; color:var(--ink) }
    .tbl tbody tr:nth-child(odd){ background:var(--table-stripe) }
    .tbl tbody tr:hover{ background:#FFF8EB; box-shadow: inset 3px 0 0 0 var(--amber) }
    .td-ellipsis{ max-width:240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis }
    .price{ color:var(--amber); font-weight:900 }

    .softbar{ height:8px; border-radius:999px; background:#EEF2F7; overflow:hidden }
    .softbar>span{ display:block; height:100%; background:linear-gradient(90deg,var(--amber),var(--amber2)) }

    .skeleton{ position:absolute; inset:0; border-radius:12px; overflow:hidden;
      background: linear-gradient(90deg, rgba(0,0,0,.06), rgba(255,255,255,.18), rgba(0,0,0,.06));
      animation: shimmer 1.5s infinite linear;
    }

    /* ===== Service Mix legend rapi ===== */
    .mix-legend{
      display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap:.45rem; max-height:130px; overflow:auto; padding-top:.35rem;
    }
    .mix-legend .item{
      display:flex; align-items:center; gap:.5rem;
      font-size: var(--fs-sm); padding:.35rem .5rem;
      border:1px solid var(--table-border); border-radius:.6rem;
    }
    .mix-legend .dot{ width:.6rem; height:.6rem; border-radius:999px; flex:0 0 .6rem }
    .mix-legend .label{ white-space:nowrap; overflow:hidden; text-overflow:ellipsis }
    .mix-legend .count{ color:var(--ink-soft); margin-left:auto }
  </style>

  <div class="relative page min-h-screen py-10">
    <span class="grid-deco"></span>

    <div class="max-w-7xl mx-auto px-6 space-y-8">

      {{-- ================= HERO ================= --}}
      <section class="hero">
        <div class="hero-glass">
          <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
              <div class="section-title"><h1>Dashboard Admin — Qinclong Laundry</h1></div>
              <p class="mt-1 muted">Pantau performa operasional, pembayaran, dan aktivitas terbaru.</p>
              @isset($paidOrders)
                <div class="mt-3 flex flex-wrap gap-2">
                  <span class="chip"><i class="fa-solid fa-circle-check"></i> Paid: {{ number_format((int)$paidOrders) }}</span>
                  <span class="chip"><i class="fa-solid fa-clock"></i> Unpaid: {{ number_format(max(0,(int)($unpaidOrders ?? 0))) }}</span>
                </div>
              @endisset
            </div>

            <div class="flex items-center gap-2 flex-wrap qa">
              <a href="{{ route('admin.orders.index') }}" class="btn"><i class="fa-solid fa-plus"></i>Buat Pesanan</a>
              <button id="celebrateBtn" class="chip" type="button"><i class="fa-solid fa-wand-magic-sparkles"></i> Celebrate</button>
              <button id="themeToggle" class="chip" type="button"><i class="fa-solid fa-moon"></i> Theme</button>
              <button id="densityComfort" class="chip" type="button">Comfort</button>
              <button id="densityCompact" class="chip" type="button">Compact</button>
            </div>
          </div>
        </div>
      </section>

      {{-- ================= KPI ================= --}}
      @php
        $goal = max(1, (int) ($targetMonthly ?? 5000000));
        $ach  = (int) ($thisMonthRevenue ?? 0);
        $pct  = min(100, round($ach * 100 / $goal));
      @endphp
      <section class="grid md:grid-cols-3 gap-6">
        <div class="card p-5 kpi">
          <div class="flex items-center gap-4">
            <div class="ring" style="--pct:100;--ring-clr:var(--amber)">
              <span class="ring-icon"><i class="fa-solid fa-box-open"></i></span>
            </div>
            <div>
              <div class="text-sm muted">Total Pesanan</div>
              <div class="num text-3xl font-extrabold"><span class="counter" data-target="{{ (int) ($totalOrders ?? 0) }}">0</span></div>
            </div>
            <div class="icon ml-auto"><i class="fa-solid fa-box-archive"></i></div>
          </div>
          <div class="mt-4 softbar"><span style="width:100%"></span></div>
        </div>

        <div class="card p-5 kpi">
          <div class="flex items-center gap-4">
            <div class="ring" style="--pct:80;--ring-clr:var(--info)">
              <span class="ring-icon"><i class="fa-solid fa-tags"></i></span>
            </div>
            <div>
              <div class="text-sm muted">Layanan Aktif</div>
              <div class="num text-3xl font-extrabold"><span class="counter" data-target="{{ (int) ($activeServices ?? 0) }}">0</span></div>
            </div>
            <div class="icon ml-auto" style="background:linear-gradient(135deg,var(--info),#34D399)"><i class="fa-solid fa-tags"></i></div>
          </div>
          <div class="mt-4 softbar"><span style="width:80%"></span></div>
        </div>

        <div class="card p-5 kpi">
          <div class="flex items-center gap-4">
            <div class="ring" style="--pct:{{ $pct }};--ring-clr:var(--ok)">
              <span class="ring-icon"><i class="fa-solid fa-coins"></i></span>
            </div>
            <div>
              <div class="text-sm muted">Pendapatan Bulan Ini</div>
              <div class="num text-3xl font-extrabold"><span class="counter" data-currency="rp" data-target="{{ (int) ($thisMonthRevenue ?? 0) }}">0</span></div>
              <div class="text-xs mt-1 muted">Target: Rp {{ number_format($goal,0,',','.') }} • <span class="font-semibold" style="color:var(--ink)">{{ $pct }}%</span></div>
            </div>
            <div class="icon ml-auto"><i class="fa-solid fa-sack-dollar"></i></div>
          </div>
          <div class="mt-4 softbar"><span style="width:{{ $pct }}%"></span></div>
        </div>
      </section>

      {{-- ================= CHARTS ================= --}}
      <section class="grid lg:grid-cols-3 gap-6">
        <div class="card p-6 lg:col-span-2">
          <div class="card-header">
            <h3 class="title">Pendapatan 12 Bulan</h3>
            <span class="chip"><i class="fa-solid fa-circle"></i> Bulanan</span>
          </div>
          <div class="h-[340px] relative">
            <div class="skeleton" id="incomeSkel"></div>
            <canvas id="incomeChart" class="w-full h-full" aria-label="Grafik Pendapatan" role="img"></canvas>
          </div>
        </div>

        <div class="card p-6">
          <div class="card-header"><h3 class="title">Paid vs Unpaid</h3></div>
          <div class="h-[280px] my-1 relative">
            <div class="skeleton" id="ratioSkel"></div>
            <canvas id="ratioChart" class="w-full h-full" aria-label="Rasio Pembayaran" role="img"></canvas>
          </div>
          <div class="legend mt-3">
            <div class="pill paid"><span class="dot" style="background:var(--chart-donut-paid)"></span><span>Paid</span><span class="muted ml-auto">{{ number_format((int) ($paidOrders ?? 0)) }} order</span></div>
            <div class="pill unpaid"><span class="dot" style="background:var(--chart-donut-unpaid)"></span><span>Unpaid</span><span class="muted ml-auto">{{ number_format((int) ($unpaidOrders ?? 0)) }} order</span></div>
          </div>
        </div>
      </section>

      {{-- ================= SERVICE MIX & RECENT ================= --}}
      @php
        $mixServer = $serviceMix ?? null;
        if(!$mixServer){
          $mixServer = isset($orders)
            ? collect($orders)
                ->filter(fn($o) => isset($o->service) && $o->service)
                ->groupBy(fn($o) => $o->service->name)
                ->map(fn($g) => ['name' => (string)$g->first()->service->name, 'count' => $g->count()])
                ->values()
                ->all()
            : [];
        }

        $recentPending = collect($recentOrders ?? ($orders ?? []))
          ->filter(fn($o) => ($o->status ?? '') === 'pending')
          ->sortByDesc(fn($o) => $o->created_at)
          ->take(10);
      @endphp

      <section class="grid lg:grid-cols-3 gap-6">
        <div class="card p-6">
          <div class="card-header"><h3 class="title">Service Mix</h3></div>
          <div class="h-[280px] my-1 relative">
            <div class="skeleton" id="mixSkel"></div>
            <canvas id="serviceMixChart" aria-label="Komposisi Layanan" role="img"></canvas>
          </div>
          <div id="mixLegend" class="mix-legend"></div>
          @if(empty($mixServer))
            <p class="text-xs mt-2 muted">Tambahkan variabel <code>$serviceMix</code> di controller untuk komposisi layanan.</p>
          @endif
        </div>

        <div class="card p-6 lg:col-span-2">
          <div class="card-header">
            <h3 class="title">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="chip">Lihat semua</a>
          </div>

          <div class="overflow-x-auto">
            <table class="tbl text-sm">
              <thead>
                <tr>
                  <th class="px-4 py-2 text-left">Tanggal</th>
                  <th class="px-4 py-2 text-left">Customer</th>
                  <th class="px-4 py-2 text-left">Layanan</th>
                  <th class="px-4 py-2 text-left">Total</th>
                  <th class="px-4 py-2 text-left">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($recentPending as $o)
                  <tr class="hover:bg-[#FFF8EB] dark:hover:bg-white/5">
                    <td class="px-4 py-2 whitespace-nowrap muted">{{ optional($o->created_at)->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2">
                      <div class="font-semibold td-ellipsis" title="{{ $o->user->name ?? '-' }}">{{ $o->user->name ?? '-' }}</div>
                      <div class="text-xs muted td-ellipsis" title="{{ $o->user->email ?? '' }}">{{ $o->user->email ?? '' }}</div>
                    </td>
                    <td class="px-4 py-2 td-ellipsis" title="{{ $o->service->name ?? '-' }}">{{ $o->service->name ?? '-' }}</td>
                    <td class="px-4 py-2 price">Rp {{ number_format((int)($o->total_price ?? 0),0,',','.') }}</td>
                    <td class="px-4 py-2">
                      <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-950/40 dark:text-yellow-300">Pending</span>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="px-4 py-6 text-center muted">Belum ada pesanan berstatus pending.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </section>

    </div>
  </div>

  {{-- ================= TOASTS ================= --}}
  <div id="toast-stack" class="fixed top-4 right-4 z-50 space-y-3 w-[calc(100%-2rem)] max-w-sm">
    @foreach (['success'=>'Berhasil','error'=>'Gagal','warning'=>'Perhatian','info'=>'Info'] as $key=>$title)
      @if (session($key))
        <div class="toast flex items-start gap-3 rounded-xl bg-white/95 backdrop-blur shadow-lg ring-1
                    {{ $key==='success'?'ring-green-200':'' }}
                    {{ $key==='error'  ?'ring-red-200'  :'' }}
                    {{ $key==='warning'?'ring-yellow-200':'' }}
                    {{ $key==='info'   ?'ring-blue-200' :'' }} p-4 dark:bg-[#112637]/95 dark:ring-white/10">
          <div class="shrink-0 w-8 h-8 rounded-full
                      {{ $key==='success'?'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300':'' }}
                      {{ $key==='error'  ?'bg-red-100 text-red-700   dark:bg-red-900/40   dark:text-red-300'    :'' }}
                      {{ $key==='warning'?'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300':'' }}
                      {{ $key==='info'   ?'bg-blue-100 text-blue-700 dark:bg-blue-900/40  dark:text-blue-300'  :'' }} flex items-center justify-center">
            <i class="fa-solid
                      {{ $key==='success'?'fa-check':'' }}
                      {{ $key==='error'  ?'fa-triangle-exclamation':'' }}
                      {{ $key==='warning'?'fa-circle-exclamation':'' }}
                      {{ $key==='info'   ?'fa-circle-info':'' }}"></i>
          </div>
          <div class="text-sm">
            <p class="font-semibold">{{ $title }}</p>
            <p>{{ session($key) }}</p>
          </div>
          <button class="ml-auto text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" onclick="this.closest('.toast').remove()" aria-label="Tutup notifikasi">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      @endif
    @endforeach
  </div>

  {{-- ========== FA fallback (emoji) kalau CDN diblok) ========== --}}
  <style>
    i.fa-box-open::before{content:"📦";}
    i.fa-tags::before{content:"🏷️";}
    i.fa-coins::before{content:"💰";}
    i.fa-circle-check::before{content:"✅";}
    i.fa-clock::before{content:"⏰";}
    i.fa-plus::before{content:"＋";}
    i.fa-wand-magic-sparkles::before{content:"✨";}
    i.fa-moon::before{content:"🌙";}
    i.fa-box-archive::before{content:"📦";}
    i.fa-circle::before{content:"●";}
    i.fa-chart-line::before{content:"📈";}
    i.fa-triangle-exclamation::before{content:"⚠️";}
    i.fa-circle-exclamation::before{content:"⚠️";}
    i.fa-circle-info::before{content:"ℹ️";}
    i.fa-xmark::before{content:"✖";}
  </style>

  {{-- ================= ASSETS ================= --}}
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // ===== Theme & Density
    (function(){
      const KEY='ql-theme', DENS='ql-density', root=document.documentElement;
      const t=localStorage.getItem(KEY), d=localStorage.getItem(DENS);
      if(t){ root.setAttribute('data-theme', t) } else if (matchMedia('(prefers-color-scheme: dark)').matches){ root.setAttribute('data-theme','dark') }
      if(d){ root.setAttribute('data-density', d) }
      document.getElementById('themeToggle')?.addEventListener('click', ()=>{
        const now=root.getAttribute('data-theme')==='dark'?'light':'dark';
        root.setAttribute('data-theme',now); localStorage.setItem(KEY,now); refreshChartTheme();
      });
      document.getElementById('densityComfort')?.addEventListener('click', ()=>{
        root.setAttribute('data-density','comfort'); localStorage.setItem(DENS,'comfort');
      });
      document.getElementById('densityCompact')?.addEventListener('click', ()=>{
        root.setAttribute('data-density','compact'); localStorage.setItem(DENS,'compact');
      });
    })();

    // ===== Counter
    document.querySelectorAll('.counter').forEach(el=>{
      const target=Number(el.dataset.target||0), isRp=el.dataset.currency==='rp', frames=60; let f=0;
      const tick=()=>{ f++; const p=Math.min(1,f/frames), eased=1-Math.pow(1-p,3), val=Math.round(target*eased);
        el.textContent = isRp ? 'Rp ' + val.toLocaleString('id-ID') : val.toLocaleString('id-ID');
        if(p<1) requestAnimationFrame(tick);
      }; tick();
    });

    // ===== Server data
    const months=@json($months ?? []), revenues=@json($revenues ?? []),
          paidCnt=Number(@json($paidOrders ?? 0)), unpCnt=Number(@json($unpaidOrders ?? 0)),
          mixData=@json($mixServer ?? []);

    // ===== CSS var helper
    function cssVar(n){ return getComputedStyle(document.documentElement).getPropertyValue(n).trim() }

    // ===== Chart defaults
    if(window.Chart){
      Chart.defaults.font.family='Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, "Apple Color Emoji","Segoe UI Emoji"';
      Chart.defaults.color=cssVar('--chart-tick');
      Chart.defaults.plugins.legend.labels.boxWidth=10;
      Chart.defaults.plugins.legend.labels.boxHeight=10;
    }

    let incomeChart, ratioChart, mixChart;

    // ===== Build charts
    (function(){
      const lineCtx=document.getElementById('incomeChart')?.getContext('2d');
      const ratioCtx=document.getElementById('ratioChart')?.getContext('2d');
      const mixCtx=document.getElementById('serviceMixChart')?.getContext('2d');

      if(lineCtx){
        const grad=lineCtx.createLinearGradient(0,0,0,320);
        grad.addColorStop(0, cssVar('--chart-area')); grad.addColorStop(1,'rgba(0,0,0,0)');
        incomeChart=new Chart(lineCtx,{
          type:'line',
          data:{ labels:months, datasets:[{ label:'Pendapatan', data:revenues,
            borderColor:cssVar('--chart-line'), backgroundColor:grad, pointBackgroundColor:cssVar('--chart-line'),
            pointRadius:3, pointHoverRadius:5, borderWidth:2, fill:true, tension:.35 }]},
          options:{ responsive:true, maintainAspectRatio:false, animation:{ duration:650, easing:'easeOutCubic' },
            plugins:{ legend:{ display:false }, tooltip:{ callbacks:{ label:c=>'Rp '+Number(c.raw||0).toLocaleString('id-ID') } } },
            scales:{ x:{ grid:{ display:false }}, y:{ grid:{ color:cssVar('--chart-grid') }, ticks:{ callback:v=>'Rp '+Number(v).toLocaleString('id-ID') } } } }
        });
        document.getElementById('incomeSkel')?.remove();
      }

      if(ratioCtx){
        ratioChart=new Chart(ratioCtx,{
          type:'doughnut',
          data:{ labels:['Paid','Unpaid'], datasets:[{ data:[paidCnt,unpCnt],
            backgroundColor:[cssVar('--chart-donut-paid'), cssVar('--chart-donut-unpaid')], borderWidth:0 }]},
          options:{ responsive:true, maintainAspectRatio:false, cutout:'65%', plugins:{ legend:{ display:false }}, animation:{ duration:550 } }
        });
        document.getElementById('ratioSkel')?.remove();
      }

      // ===== Service mix (UNIQUE COLORS up to 24+)
      // Palet warna kontras untuk 24 kategori (lebih dari 15 aman)
      function getMixPalette(n){
        const base = [
          '#3B82F6','#22C55E','#F59E0B','#F472B6','#A78BFA',
          '#10B981','#EF4444','#F97316','#06B6D4','#84CC16',
          '#EAB308','#8B5CF6','#0EA5E9','#D946EF','#14B8A6',
          '#F43F5E','#6366F1','#059669','#DC2626','#FB923C',
          '#0891B2','#65A30D','#CA8A04','#7C3AED'
        ];
        if(n <= base.length) return base.slice(0,n);
        const arr = base.slice();
        for(let i=arr.length;i<n;i++){ // fallback HSL jika > 24
          const hue = Math.round((i*137.508)%360);
          arr.push(`hsl(${hue} 75% 55%)`);
        }
        return arr;
      }

      // Plugin legend HTML dgn jumlah & warna yang konsisten
      const htmlLegendPlugin = {
        id: 'htmlLegend',
        afterUpdate(chart, args, opts){
          const container = document.getElementById(opts.containerID);
          if(!container) return;
          container.innerHTML = '';
          const data = chart.data.datasets[0]?.data || [];
          const items = chart.options.plugins.legend.labels.generateLabels(chart);
          items.forEach((item) => {
            const wrap = document.createElement('div');
            wrap.className = 'item'; wrap.title = item.text;

            const dot = document.createElement('span');
            dot.className = 'dot'; dot.style.background = item.fillStyle; wrap.appendChild(dot);

            const label = document.createElement('span');
            label.className = 'label'; label.textContent = item.text; wrap.appendChild(label);

            const cnt = document.createElement('span');
            cnt.className = 'count'; cnt.textContent = (Number(data[item.index])||0).toLocaleString('id-ID');
            wrap.appendChild(cnt);

            wrap.onclick = ()=>{ chart.toggleDataVisibility(item.index); chart.update(); };
            container.appendChild(wrap);
          });
        }
      };

      if(mixCtx){
        const dataArr = (mixData && mixData.length)
          ? [...mixData]  // [{name,count}]
          : [
              {name:'Cuci Strika (3Kg)', count:9},
              {name:'Cuci Lipat (3Kg)', count:7},
              {name:'Strika (3Kg)', count:7},
              {name:'Express 6 Jam (3Kg)', count:5},
              {name:'Super Express 3 Jam (3Kg)', count:3},
              {name:'Sprei 1 set', count:2},
              {name:'Sprei saja', count:2},
              {name:'Selimut bulu tipis', count:1},
            ];

        // urutkan biar warna/legend konsisten
        dataArr.sort((a,b)=> Number(b.count||0) - Number(a.count||0));

        const labels = dataArr.map(x=>x.name);
        const vals   = dataArr.map(x=>Number(x.count||0));
        const colors = getMixPalette(labels.length);

        mixChart=new Chart(mixCtx,{
          type:'doughnut',
          data:{ labels, datasets:[{ data:vals, borderWidth:0, backgroundColor:colors }]},
          options:{ responsive:true, maintainAspectRatio:false, cutout:'60%',
            plugins:{ legend:{ display:false }, htmlLegend:{ containerID:'mixLegend' } } },
          plugins:[htmlLegendPlugin]
        });
        document.getElementById('mixSkel')?.remove();
      }
    })();

    // ===== Update theme (line/ratio update; mix tetap vibrant)
    function refreshChartTheme(){
      if(incomeChart){
        const ctx=incomeChart.ctx, grad=ctx.createLinearGradient(0,0,0,320);
        grad.addColorStop(0, cssVar('--chart-area')); grad.addColorStop(1,'rgba(0,0,0,0)');
        Object.assign(incomeChart.data.datasets[0],{
          borderColor:cssVar('--chart-line'),
          pointBackgroundColor:cssVar('--chart-line'),
          backgroundColor:grad
        });
        incomeChart.options.scales.y.grid.color = cssVar('--chart-grid');
        incomeChart.update('none');
      }
      if(ratioChart){
        ratioChart.data.datasets[0].backgroundColor=[cssVar('--chart-donut-paid'), cssVar('--chart-donut-unpaid')];
        ratioChart.update('none');
      }
      // mixChart warna dibiarkan — sudah kontras untuk light & dark
    }

    // ===== Confetti & auto-dismiss toast (sama seperti sebelumnya)
    document.getElementById('celebrateBtn')?.addEventListener('click', ()=>{
      const count=60, colors=['var(--amber)','var(--amber2)','var(--sky)','rgba(52,211,153,.9)','rgba(96,165,250,.9)'];
      for(let i=0;i<count;i++){
        const s=document.createElement('span');
        s.style.position='fixed'; s.style.left=(Math.random()*100)+'%'; s.style.top='-12px';
        const size=(5+Math.random()*6); s.style.width=s.style.height=size+'px';
        s.style.background=colors[Math.floor(Math.random()*colors.length)];
        s.style.borderRadius=Math.random()>.5?'2px':'999px';
        s.style.opacity=.95; s.style.transform=`rotate(${Math.random()*360}deg)`; s.style.zIndex=60; s.style.pointerEvents='none';
        document.body.appendChild(s);
        const fall=s.animate(
          [{ transform:`translateY(0) rotate(0deg)`, opacity:1 },
           { transform:`translateY(${innerHeight+40}px) rotate(${360+Math.random()*360}deg)`, opacity:.85 }],
          { duration:1200+Math.random()*1200, easing:'cubic-bezier(.22,.8,.26,.99)' }
        ); fall.onfinish=()=>s.remove();
      }
    });

    document.querySelectorAll('#toast-stack .toast').forEach((t,i)=>{
      setTimeout(()=>{ t.style.transition='opacity .4s ease, transform .4s ease';
        t.style.opacity='0'; t.style.transform='translateY(-4px)';
        setTimeout(()=>t.remove(),420)
      }, 4200+i*400);
    });
  </script>
</x-app-layout>
