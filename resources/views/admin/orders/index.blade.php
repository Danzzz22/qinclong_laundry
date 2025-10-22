<x-app-layout>
  {{-- ========= TOKENS & GLOBAL STYLES (tema-aware, clean) ========= --}}
  <style>
    :root{
      --ink:#0B2D42; --ink-soft:#5b7385;
      --bg:#F6F9FC; --panel:#FFFFFF; --border: color-mix(in oklab, var(--panel), #000 8%);
      --shadow-sm: 0 6px 18px rgba(1,60,88,.08); --shadow-md: 0 10px 22px rgba(1,60,88,.10); --shadow-lg: 0 18px 36px rgba(1,60,88,.14);
      --amber:#F5A201; --amber2:#FFBA42; --blue:#60A5FA; --green:#22C55E; --purple:#A78BFA;
      --table-stripe:#F7FAFF; --grid:#021f3010; --radius:20px;

      /* density */
      --row-py:.85rem; --cell-px:1.1rem;
    }
    [data-theme="dark"]{
      --ink:#EAF6FF; --ink-soft:#b8d0e0;
      --bg:#0E1723; --panel:#0F2231; --border:#173145;
      --shadow-sm: 0 6px 16px rgba(0,0,0,.35); --shadow-md: 0 12px 26px rgba(0,0,0,.40); --shadow-lg: 0 18px 42px rgba(0,0,0,.45);
      --table-stripe:#0f2432; --grid:#ffffff12;
    }
    [data-density="compact"]{ --row-py:.6rem; --cell-px:.9rem }
    :root,[data-theme="dark"]{ color-scheme: light dark }

    /* Page bg: aurora + grid tipis */
    .page{
      background:
        radial-gradient(1100px 520px at 12% -12%, color-mix(in oklab, #A8E8F9 20%, transparent), transparent 60%),
        radial-gradient(900px 420px at 100% -10%, color-mix(in oklab, var(--amber2) 18%, transparent), transparent 60%),
        linear-gradient(#ffffff, var(--bg));
      transition: background .25s ease, color .25s ease;
      color: var(--ink);
    }
    [data-theme="dark"] .page{
      background:
        radial-gradient(1000px 500px at 8% -18%, color-mix(in oklab, #1a7bb8 22%, transparent), transparent 58%),
        radial-gradient(900px 380px at 92% -10%, color-mix(in oklab, var(--amber) 16%, transparent), transparent 60%),
        linear-gradient(#0B1520, var(--bg));
    }
    .grid-deco{
      position:absolute; inset:0; pointer-events:none; opacity:.16; mix-blend:multiply;
      background-image:
        linear-gradient(transparent 31px, var(--grid) 32px),
        linear-gradient(90deg, transparent 31px, var(--grid) 32px);
      background-size:32px 32px;
      mask-image: radial-gradient(1200px 600px at 40% 0%, #000, transparent 70%);
    }
    [data-theme="dark"] .grid-deco{ opacity:.14; mix-blend:normal }

    /* ================= HERO ================= */
    .hero{
      position:relative; overflow:hidden; border-radius:1.25rem; padding:1px; isolation:isolate;
      background:
        radial-gradient(800px 320px at 8% 12%, rgba(168,232,249,.30), transparent 60%),
        radial-gradient(720px 300px at 92% 8%, rgba(255,211,91,.22), transparent 60%),
        linear-gradient(120deg, #A8E8F9, #FFBA42 50%, #F5A201);
      background-size: 100% 100%, 100% 100%, 180% 180%;
      animation: heroGradMove 16s ease-in-out infinite;
      box-shadow: var(--shadow-lg);
    }
    @keyframes heroGradMove{ 0%{background-position:0% 0%,100% 0%,0% 50%} 50%{background-position:0% 0%,100% 0%,100% 50%} 100%{background-position:0% 0%,100% 0%,0% 50%} }
    .hero::after{ content:""; position:absolute; inset:0; border-radius:inherit; z-index:0;
      background: conic-gradient(from 180deg,#FFD35B,#A8E8F9,#F5A201,#FFD35B); filter: blur(16px); opacity:.32 }
    .hero-inner{
      position:relative; z-index:1; border-radius:calc(var(--radius) - 6px);
      background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.82));
      backdrop-filter:saturate(140%) blur(7px);
      padding: 1.15rem 1.25rem; border:1px solid var(--border);
      box-shadow: inset 0 1px 0 rgba(255,255,255,.6);
      color:var(--ink); overflow:hidden;
    }
    [data-theme="dark"] .hero-inner{
      background: linear-gradient(180deg, rgba(12,30,45,.80), rgba(12,30,45,.72));
      box-shadow: inset 0 1px 0 rgba(255,255,255,.06);
    }
    .hero-inner::before{
      content:""; position:absolute; inset:-40% -60% auto; height:220%;
      background: linear-gradient(120deg, transparent 48%, rgba(255,255,255,.26) 50%, transparent 52%);
      transform: translateX(-120%); transition: transform .9s ease; pointer-events:none;
    }
    .hero-inner:hover::before{ transform: translateX(120%) }

    /* Toolbar chips (theme/density) */
    .chip{
      display:inline-flex;align-items:center;gap:.55rem;padding:.55rem .95rem;border-radius:.85rem;font-weight:800;
      border:1px solid var(--border);
      background: color-mix(in oklab, var(--panel), #fff 6%); color:var(--ink);
      transition:background .15s ease, transform .08s ease, border-color .15s ease;
    }
    .chip:hover{ background: color-mix(in oklab, var(--panel), #000 2%) }
    .chip:active{ transform:translateY(1px) }
    .chip[data-active="1"]{ box-shadow: inset 0 0 0 2px color-mix(in oklab, var(--amber) 60%, #fff 0%) }

    /* ================= FILTER BAR ================= */
    .panel{ background:var(--panel); border-radius:var(--radius); box-shadow:var(--shadow-sm); border:1px solid var(--border) }
    .filters{ display:flex; flex-wrap:wrap; gap:.7rem 1rem; align-items:center }
    .filters .label{ font-weight:900; color:var(--ink) }

    /* Segmented control – clean, no double border */
    .seg-wrap{ position:relative; display:inline-block; padding:6px; border-radius:999px;
      border:1px solid var(--border); background:color-mix(in oklab,var(--panel),#fff 6%); box-shadow:none; }
    .seg-scroll{ display:flex; gap:.5rem; align-items:center; overflow:auto hidden; scrollbar-width:none }
    .seg-scroll::-webkit-scrollbar{ display:none }
    .seg-item{
      position:relative; z-index:1;
      display:inline-flex; align-items:center; gap:.5rem; padding:.55rem .95rem; border-radius:999px;
      font-weight:900; border:0; background:transparent; color:var(--ink);
      transition: transform .08s ease, color .15s ease;
      cursor:pointer; white-space:nowrap;
    }
    .seg-item:hover{ transform:translateY(-1px) }
    .seg-thumb{
      position:absolute; z-index:0; height:36px; width:var(--seg-w,0); border-radius:999px;
      left:6px; top:6px; transform:translateX(var(--seg-x,0));
      background:linear-gradient(90deg,var(--amber),var(--amber2)); box-shadow:0 12px 22px rgba(245,162,1,.18);
      transition:transform .18s ease, width .18s ease;
    }
    .vh{ position:absolute; opacity:0; width:1px; height:1px; pointer-events:none }
    .seg input:checked + .seg-item{ color:#0f2b3a } /* text kontras di atas thumb */

    .mask-fade{
      -webkit-mask-image: linear-gradient(90deg, transparent, #000 16px, #000 calc(100% - 16px), transparent);
      mask-image: linear-gradient(90deg, transparent, #000 16px, #000 calc(100% - 16px), transparent);
    }

    .divider{ width:1px; height:26px; background: color-mix(in oklab,var(--panel),#000 7%) }
    [data-theme="dark"] .divider{ background:#183041 }

    /* Date range capsule – satu border saja */
    .range{ display:flex; align-items:center; gap:10px; padding:8px; border-radius:14px;
            border:1px solid var(--border); background:color-mix(in oklab,var(--panel),#fff 4%); box-shadow:none }
    .range .in{ display:flex; align-items:center; gap:.55rem; padding:.45rem .6rem; border-radius:10px; background:transparent; min-width:200px }
    .range input{ border:0; outline:0; background:transparent; color:var(--ink); padding:0; font:inherit }
    .range input:focus-visible{ outline:2px solid color-mix(in oklab,var(--amber) 45%,#fff 0%); outline-offset:2px; border-radius:8px }

    /* Search – soft & bersih */
    .input{ display:flex; align-items:center; gap:.5rem; padding:.7rem 1rem; border-radius:14px;
            border:1px solid var(--border); background: color-mix(in oklab, var(--panel), #fff 4%); color:var(--ink); flex:1 1 320px }
    .input:focus-within{ border-color:color-mix(in oklab,var(--amber) 38%,#fff 0%); box-shadow:0 10px 24px rgba(1,60,88,.06) }
    .input input{ width:100%; outline:0; background:transparent; color:inherit; border:0 }
    .clear-btn{ background:transparent; border:0; color:var(--ink-soft); visibility:hidden }
    .clear-btn:hover{ color:var(--ink) }

    /* Actions (Terapkan disembunyi – auto-apply) */
    .btn-apply, .btn-reset{
      display:inline-flex; align-items:center; gap:.55rem; padding:.72rem 1.05rem; border-radius:1rem; font-weight:900;
      transition: transform .12s ease, box-shadow .12s ease, filter .12s ease;
    }
    .btn-apply{ display:none }
    .btn-reset{ background:#0b2d42; color:#fff } .btn-reset:hover{ filter:brightness(1.04) }

    /* ================= STATUS PILL ================= */
    .status-pill{
      appearance:none; -webkit-appearance:none; -moz-appearance:none; cursor:pointer;
      border:1px solid transparent; border-radius:999px; font-weight:800; font-size:.85rem;
      padding:.42rem 1.8rem .42rem .85rem; line-height:1;
      background-repeat:no-repeat; background-position:right .6rem center; background-size:16px;
      transition:box-shadow .18s ease, border-color .18s ease, transform .12s ease, filter .18s ease;
      color: var(--ink);
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    }
    .status-pill:hover{ transform:translateY(-1px) }
    .status-pill:focus{ outline:0; box-shadow:0 0 0 3px rgba(245,162,1,.25) }
    .status-default{ background:#F3F4F6; color:#374151; border-color:#E5E7EB }
    .status-pending{ background:#FEF3C7; color:#92400E; border-color:#FDE68A; filter:saturate(105%) }
    .status-diproses{ background:#DBEAFE; color:#1E40AF; border-color:#BFDBFE }
    .status-diantar{ background:#F3E8FF; color:#6B21A8; border-color:#E9D5FF }
    .status-selesai{ background:#DCFCE7; color:#065F46; border-color:#BBF7D0 }
    [data-theme="dark"] .status-default{ background:#0f2231; color:#cbd5e1; border-color:#183041 }
    [data-theme="dark"] .status-pending{ background:#2b2006; color:#facc15; border-color:#7a5f0a }
    [data-theme="dark"] .status-diproses{ background:#0d223c; color:#93c5fd; border-color:#1e3a8a }
    [data-theme="dark"] .status-diantar{ background:#24123f; color:#d8b4fe; border-color:#5b21b6 }
    [data-theme="dark"] .status-selesai{ background:#052e18; color:#86efac; border-color:#14532d }

    /* ================= TABEL ================= */
    .tbl{ width:100%; border-collapse:separate; border-spacing:0 }
    .tbl thead{ position:sticky; top:0; z-index:5; backdrop-filter: blur(6px) saturate(140%) }
    .tbl thead th{
      background: color-mix(in oklab, var(--panel), #fff 88%);
      color:var(--ink); text-transform:uppercase; font-size:.73rem; letter-spacing:.02em; text-align:left;
      box-shadow:inset 0 -1px 0 color-mix(in oklab, var(--panel), #000 10%);
      padding: var(--row-py) var(--cell-px);
    }
    [data-theme="dark"] .tbl thead th{ background: color-mix(in oklab, var(--panel), #000 6%); box-shadow:inset 0 -1px 0 #183041; color:#d6e8f6 }
    .tbl td{ padding: var(--row-py) var(--cell-px); vertical-align:middle }
    .tbl tbody tr:nth-child(odd){ background:var(--table-stripe) }
    .tbl tbody tr{ transition: background-color .15s ease, box-shadow .15s ease, transform .04s ease }
    .tbl tbody tr:hover{ background:#F9FAFB }
    [data-theme="dark"] .tbl tbody tr:hover{ background:#142c3b }
    .price{ color:var(--amber); font-weight:800; font-feature-settings:"tnum" on,"lnum" on }

    /* Ambient spotlight following cursor (subtle) */
    .table-ambient{ position:relative }
    .table-ambient::before{
      content:""; position:absolute; inset:0; pointer-events:none; opacity:0;
      background: radial-gradient(260px 130px at var(--mx,50%) var(--my,0%), color-mix(in oklab, var(--blue) 12%, transparent), transparent 70%);
      transition: opacity .25s ease;
    }
    .table-ambient.is-hovering::before{ opacity:.9 }
    [data-theme="dark"] .table-ambient::before{
      background: radial-gradient(260px 130px at var(--mx,50%) var(--my,0%), color-mix(in oklab, #1a7bb8 22%, transparent), transparent 72%);
      opacity:.6;
    }

    /* Tooltips (aksi) */
    .tooltipped{ position:relative }
    .tooltipped:hover::after{
      content:attr(aria-label); position:absolute; bottom:calc(100% + 6px); left:50%; transform:translateX(-50%);
      white-space:nowrap; font-size:.75rem; font-weight:700; padding:.28rem .5rem; border-radius:.5rem;
      background: color-mix(in oklab, var(--panel), #000 6%); color:var(--ink); border:1px solid var(--border);
      box-shadow: var(--shadow-sm);
    }

    /* Scrollbar halus */
    *::-webkit-scrollbar{ width:10px; height:10px }
    *::-webkit-scrollbar-thumb{ background: color-mix(in oklab, #013C58 10%, #94a3b8 90%); border-radius:999px; border:2px solid transparent; background-clip:padding-box }
    *::-webkit-scrollbar-track{ background: transparent }

    /* Toasts */
    @keyframes toast-in{from{opacity:0;transform:translateY(-6px) translateX(8px)}to{opacity:1;transform:translateY(0) translateX(0)}}
    .toast{animation:toast-in .35s ease both}
    .toast-panel{
      background: color-mix(in oklab, var(--panel), #fff 90%); color: var(--ink);
      border:1px solid var(--border); backdrop-filter: blur(6px) saturate(120%);
      box-shadow: var(--shadow-sm); border-radius:14px;
    }
    [data-theme="dark"] .toast-panel{ background: color-mix(in oklab, var(--panel), #000 0%); box-shadow: 0 10px 24px rgba(0,0,0,.45) }

    @media (prefers-reduced-motion: reduce){
      *{animation-duration:.01ms!important; animation-iteration-count:1!important; transition-duration:.01ms!important}
    }
    @media print{ .page{background:#fff!important} .hero,.grid-deco,#toast-stack{display:none!important} .panel{box-shadow:none;border-color:#ddd} }
  </style>

  <div class="relative page min-h-screen py-10" id="pageRoot">
    <span class="grid-deco"></span>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

      {{-- ================= HEADER ================= --}}
      <section class="hero">
        <div class="hero-inner">
          <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
              <h1 class="text-2xl font-extrabold flex items-center gap-2" style="color:var(--ink)">📦 Kelola Pesanan</h1>
              <p class="mt-1" style="color:var(--ink-soft)">Lihat, update, dan kelola semua pesanan pelanggan (tanpa pagination)</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
              <button id="themeToggle" class="chip" type="button" title="Toggle tema"><i class="fa-solid fa-moon"></i> Theme</button>
              <button id="densityComfort" class="chip" type="button" data-active="1"><i class="fa-solid fa-couch"></i> Comfort</button>
              <button id="densityCompact" class="chip" type="button"><i class="fa-solid fa-compress"></i> Compact</button>
            </div>
          </div>
        </div>
      </section>

      {{-- ================= FILTER BAR (clean + auto-apply) ================= --}}
      @php
        $statusFilter = request('status','');
        $qFilter      = request('q','');
        $fromFilter   = request('from','');
        $toFilter     = request('to','');
      @endphp

      <form id="filterForm" method="GET" action="{{ route('admin.orders.index') }}" class="panel p-4">
        <div class="filters">
          <span class="label">Filter:</span>

          {{-- Segmented status with sliding thumb --}}
          <div class="seg-wrap mask-fade" id="segWrap">
            <span class="seg-thumb" id="segThumb"></span>
            <div class="seg-scroll" id="segScroll">
              <input class="vh" type="radio" id="st-all"      name="status" value=""          @checked($statusFilter==='')>
              <label class="seg-item" for="st-all">Semua</label>

              <input class="vh" type="radio" id="st-pending"  name="status" value="pending"   @checked($statusFilter==='pending')>
              <label class="seg-item" for="st-pending">Pending</label>

              <input class="vh" type="radio" id="st-proses"   name="status" value="diproses"  @checked($statusFilter==='diproses')>
              <label class="seg-item" for="st-proses">Diproses</label>

              <input class="vh" type="radio" id="st-diantar"  name="status" value="diantar"   @checked($statusFilter==='diantar')>
              <label class="seg-item" for="st-diantar">Diantar</label>

              <input class="vh" type="radio" id="st-selesai"  name="status" value="selesai"   @checked($statusFilter==='selesai')>
              <label class="seg-item" for="st-selesai">Selesai</label>
            </div>
          </div>

          <span class="divider"></span>

          {{-- Date range capsule (auto-submit on change) --}}
          <div class="range">
            <div class="in">
              <i class="fa-regular fa-calendar"></i>
              <input type="date" name="from" value="{{ $fromFilter }}" aria-label="Dari tanggal">
            </div>
            <span style="opacity:.6">—</span>
            <div class="in">
              <i class="fa-regular fa-calendar"></i>
              <input type="date" name="to" value="{{ $toFilter }}" aria-label="Sampai tanggal">
            </div>
          </div>

          {{-- Search (enter apply; clear × auto-apply) --}}
          <div class="input">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input id="qInput" type="text" name="q" placeholder="Cari nama, email, layanan…" value="{{ $qFilter }}" autocomplete="off">
            <button type="button" id="clearQ" class="clear-btn" title="Bersihkan" aria-label="Bersihkan">
              <i class="fa-solid fa-circle-xmark"></i>
            </button>
          </div>

          {{-- Reset as fallback --}}
          <a href="{{ route('admin.orders.index') }}" class="btn-reset"><i class="fa-solid fa-rotate-left"></i> Reset</a>
        </div>
      </form>

      @php
        $accent = [
          'pending'  => '#F59E0B',
          'diproses' => '#60A5FA',
          'diantar'  => '#A78BFA',
          'selesai'  => '#22C55E',
        ];
      @endphp

      {{-- ================= DESKTOP TABLE ================= --}}
      <div class="panel overflow-hidden hidden md:block table-ambient" id="tableAmbient">
        <div class="overflow-x-auto">
          <table class="tbl text-sm">
            <thead>
              <tr>
                <th>#</th><th>User</th><th>Layanan</th><th>Jumlah</th><th>Total</th><th>Jemput</th><th>Antar</th><th>Status</th><th class="text-left">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $order)
                @php
                  $st=$order->status;
                  $cls=['pending'=>'status-pending','diproses'=>'status-diproses','diantar'=>'status-diantar','selesai'=>'status-selesai'][$st] ?? 'status-default';
                  $rowAccent=$accent[$st] ?? 'transparent';
                @endphp
                <tr style="box-shadow: inset 3px 0 0 0 {{ $rowAccent }};">
                  <td style="padding-top:var(--row-py);padding-bottom:var(--row-py)">{{ $loop->iteration }}</td>

                  <td class="font-medium" style="color:var(--ink)">
                    {{ $order->user->name ?? '-' }}
                    <div class="text-xs" style="color:var(--ink-soft)">{{ $order->user->email ?? '' }}</div>
                  </td>

                  <td>
                    <div class="font-medium" style="color:var(--ink)">{{ $order->service->name ?? '-' }}</div>
                    <div class="text-xs" style="color:var(--ink-soft)">Rp {{ number_format($order->service->price ?? 0,0,',','.') }}/{{ $order->service->unit ?? '-' }}</div>
                  </td>

                  <td>{{ rtrim(rtrim(number_format($order->quantity,2,',','.'), '0'), ',') }}</td>
                  <td class="price">Rp {{ number_format($order->total_price ?? 0,0,',','.') }}</td>
                  <td>{{ $order->pickup_date ? \Carbon\Carbon::parse($order->pickup_date)->format('d M Y H:i') : '-' }}</td>
                  <td>{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d M Y H:i') : '-' }}</td>

                  <td>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                      @csrf @method('PATCH')
                      <select name="status" onchange="this.form.submit()" class="status-pill {{ $cls }}">
                        <option value="pending"  @selected($st=='pending')>Pending</option>
                        <option value="diproses" @selected($st=='diproses')>Diproses</option>
                        <option value="diantar"  @selected($st=='diantar')>Diantar</option>
                        <option value="selesai"  @selected($st=='selesai')>Selesai</option>
                      </select>
                    </form>
                  </td>

                  <td>
                    <div class="inline-flex items-center gap-2">
                      <a href="{{ route('admin.orders.show', $order->id) }}"
                         class="tooltipped px-3 py-1.5 rounded-md bg-indigo-500 text-white hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                         aria-label="Detail">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus pesanan ini?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="tooltipped px-3 py-1.5 rounded-md bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300"
                                aria-label="Hapus">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="9" class="text-center py-8" style="color:var(--ink-soft)">Belum ada pesanan.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- ================= MOBILE CARDS ================= --}}
      <div class="grid gap-4 md:hidden">
        @forelse($orders as $order)
          @php
            $st=$order->status;
            $cls=['pending'=>'status-pending','diproses'=>'status-diproses','diantar'=>'status-diantar','selesai'=>'status-selesai'][$st] ?? 'status-default';
            $rowAccent=$accent[$st] ?? 'transparent';
          @endphp

          <div class="panel p-4" style="box-shadow: var(--shadow-sm), inset 3px 0 0 0 {{ $rowAccent }}">
            <div class="flex items-start justify-between gap-3">
              <div>
                <div class="font-bold" style="color:var(--ink)">{{ $order->user->name ?? '-' }}</div>
                <div class="text-xs" style="color:var(--ink-soft)">{{ $order->user->email ?? '' }}</div>
              </div>

              <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="status-pill {{ $cls }}">
                  <option value="pending"  @selected($st=='pending')>Pending</option>
                  <option value="diproses" @selected($st=='diproses')>Diproses</option>
                  <option value="diantar"  @selected($st=='diantar')>Diantar</option>
                  <option value="selesai"  @selected($st=='selesai')>Selesai</option>
                </select>
              </form>
            </div>

            <div class="mt-3 text-sm">
              <div class="font-medium" style="color:var(--ink)">{{ $order->service->name ?? '-' }}</div>
              <div style="color:var(--ink-soft)">{{ rtrim(rtrim(number_format($order->quantity,2,',','.'), '0'), ',') }} × Rp {{ number_format($order->service->price ?? 0,0,',','.') }}/{{ $order->service->unit ?? '-' }}</div>
              <div class="mt-1 font-extrabold" style="color:var(--amber)">Rp {{ number_format($order->total_price ?? 0,0,',','.') }}</div>

              <div class="mt-3 grid grid-cols-2 gap-3 text-xs" style="color:var(--ink-soft)">
                <div><div class="opacity-70">Jemput</div><div>{{ $order->pickup_date ? \Carbon\Carbon::parse($order->pickup_date)->format('d M Y H:i') : '-' }}</div></div>
                <div><div class="opacity-70">Antar</div><div>{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d M Y H:i') : '-' }}</div></div>
              </div>
            </div>

            <div class="mt-4 flex items-center justify-between">
              <a href="{{ route('admin.orders.show', $order->id) }}" class="tooltipped px-3 py-2 rounded bg-indigo-500 text-white text-sm hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300" aria-label="Detail">
                <i class="fa-solid fa-eye mr-1"></i> Detail
              </a>
              <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pesanan ini?')">
                @csrf @method('DELETE')
                <button class="tooltipped px-3 py-2 rounded bg-red-500 text-white text-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300" aria-label="Hapus">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-center py-8" style="color:var(--ink-soft)">Belum ada pesanan.</div>
        @endforelse
      </div>

    </div>
  </div>

  {{-- ================= TOASTS ================= --}}
  <div id="toast-stack" class="fixed top-4 right-4 z-50 space-y-3 w-[calc(100%-2rem)] max-w-sm">
    @if (session('success'))
      <div class="toast toast-panel flex items-start gap-3 p-4">
        <div class="shrink-0 w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center"><i class="fa-solid fa-check"></i></div>
        <div class="text-sm"><p class="font-semibold" style="color:#16a34a">Berhasil</p><p style="color:var(--ink)">{{ session('success') }}</p></div>
        <button class="ml-auto text-gray-400 hover:text-gray-600" onclick="this.closest('.toast').remove()" aria-label="Tutup notifikasi"><i class="fa-solid fa-xmark"></i></button>
      </div>
    @endif
    @if (session('error'))
      <div class="toast toast-panel flex items-start gap-3 p-4">
        <div class="shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-700 flex items-center justify-center"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div class="text-sm"><p class="font-semibold" style="color:#dc2626">Gagal</p><p style="color:var(--ink)">{{ session('error') }}</p></div>
        <button class="ml-auto text-gray-400 hover:text-gray-600" onclick="this.closest('.toast').remove()" aria-label="Tutup notifikasi"><i class="fa-solid fa-xmark"></i></button>
      </div>
    @endif
  </div>

  {{-- ================= JS (tema, density, ambient, filter auto-apply) ================= --}}
  <script>
    (function(){
      const root=document.documentElement, KEY='ql-theme', DKEY='ql-density';

      // Theme persist
      const saved=localStorage.getItem(KEY);
      if(saved){ root.setAttribute('data-theme', saved) }
      else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){ root.setAttribute('data-theme','dark') }
      document.getElementById('themeToggle')?.addEventListener('click', ()=>{
        const next=root.getAttribute('data-theme')==='dark'?'light':'dark';
        root.setAttribute('data-theme',next); localStorage.setItem(KEY,next);
      });

      // Density toggle
      const comfort=document.getElementById('densityComfort');
      const compact=document.getElementById('densityCompact');
      function setDensity(mode){
        root.setAttribute('data-density', mode);
        localStorage.setItem(DKEY, mode);
        comfort?.setAttribute('data-active', mode==='compact'?'0':'1');
        compact?.setAttribute('data-active', mode==='compact'?'1':'0');
      }
      const savedD = localStorage.getItem(DKEY);
      if(savedD){ setDensity(savedD) }
      comfort?.addEventListener('click', ()=>setDensity('comfort'));
      compact?.addEventListener('click', ()=>setDensity('compact'));

      // Ambient spotlight follow cursor (subtle)
      const ambient=document.getElementById('tableAmbient');
      if(ambient){
        ambient.addEventListener('mousemove',(e)=>{
          const r=ambient.getBoundingClientRect();
          ambient.style.setProperty('--mx', (e.clientX - r.left)+'px');
          ambient.style.setProperty('--my', (e.clientY - r.top)+'px');
          ambient.classList.add('is-hovering');
        });
        ambient.addEventListener('mouseleave',()=>ambient.classList.remove('is-hovering'));
      }

      // Auto dismiss toasts
      document.querySelectorAll('#toast-stack .toast').forEach((t,i)=>{
        setTimeout(()=>{ t.style.transition='opacity .4s ease, transform .4s ease';
          t.style.opacity='0'; t.style.transform='translateY(-4px)'; setTimeout(()=>t.remove(),420);
        }, 4200 + i * 300);
      });

      // ====== FILTER BAR AUTO-APPLY ======
      const form = document.getElementById('filterForm');
      const go = ()=> form?.requestSubmit();

      // Radio status auto-apply
      const radios = [...document.querySelectorAll('#segScroll input[type="radio"]')];
      radios.forEach(r => r.addEventListener('change', go));

      // Date inputs auto-apply
      ['from','to'].forEach(n=>{
        form?.querySelector(`input[name="${n}"]`)?.addEventListener('change', go);
      });

      // Search: Enter to apply, clear to reset + apply
      const q = document.getElementById('qInput');
      const clear = document.getElementById('clearQ');
      function toggleClear(){ if(clear){ clear.style.visibility = q && q.value ? 'visible' : 'hidden'; } }
      q?.addEventListener('keydown', e => { if(e.key === 'Enter'){ e.preventDefault(); go(); } });
      clear?.addEventListener('click', ()=>{ q.value=''; toggleClear(); go(); });
      toggleClear();

      // Segmented thumb placement
      const segWrap = document.getElementById('segWrap');
      const segThumb = document.getElementById('segThumb');
      const segScroll = document.getElementById('segScroll');
      const labels = [...segScroll.querySelectorAll('.seg-item')];
      function updateSeg(){
        const checked = radios.find(r=>r.checked) || radios[0];
        const label = checked ? checked.nextElementSibling : null;
        labels.forEach(l=>l.dataset.active='0');
        if(label){
          const wRect = segWrap.getBoundingClientRect();
          const r = label.getBoundingClientRect();
          segWrap.style.setProperty('--seg-x', (r.left - wRect.left - 6) + 'px');
          segWrap.style.setProperty('--seg-w', r.width + 'px');
          label.dataset.active='1';
          // keep centered in scroll
          const center = r.left + r.width/2 - segScroll.getBoundingClientRect().left;
          segScroll.scrollLeft = Math.max(0, center - segScroll.clientWidth/2);
        }
      }
      radios.forEach(r=>r.addEventListener('change', updateSeg));
      window.addEventListener('resize', updateSeg);
      updateSeg();
    })();
  </script>

  {{-- Font Awesome: CSS only --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" crossorigin="anonymous">
</x-app-layout>
