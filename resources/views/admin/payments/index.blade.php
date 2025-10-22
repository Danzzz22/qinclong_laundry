 <x-app-layout>
  {{-- ========= THEME TOKENS & STYLES (light/dark aware) ========= --}}
  <style>
    :root{
      --ink:#0B2D42; --ink-soft:#8aa0b0;
      --bg:#F6F9FC; --panel:#FFFFFF; --border: color-mix(in oklab, var(--panel), #000 8%);
      --shadow-sm: 0 6px 18px rgba(1,60,88,.08); --shadow-md: 0 10px 22px rgba(1,60,88,.10); --shadow-lg: 0 18px 36px rgba(1,60,88,.14);
      --amber:#F5A201; --amber2:#FFBA42; --blue:#60A5FA; --green:#22C55E; --purple:#A78BFA;
      --radius:20px; --row-py:.85rem; --cell-px:1.1rem;
    }
    [data-theme="dark"]{
      --ink:#EAF6FF; --ink-soft:#b8d0e0;
      --bg:#0E1723; --panel:#0F2231; --border:#173145;
      --shadow-sm: 0 6px 18px rgba(0,0,0,.35); --shadow-md: 0 10px 22px rgba(0,0,0,.40); --shadow-lg: 0 18px 36px rgba(0,0,0,.45);
    }
    [data-density="compact"]{ --row-py:.6rem; --cell-px:.9rem }
    :root,[data-theme="dark"]{ color-scheme: light dark }

    /* ===== Page bg (aurora) ===== */
    .page{
      background:
        radial-gradient(1100px 520px at 12% -12%, color-mix(in oklab, #A8E8F9 20%, transparent), transparent 60%),
        radial-gradient(900px 420px at 100% -10%, color-mix(in oklab, var(--amber2) 18%, transparent), transparent 60%),
        linear-gradient(#ffffff, var(--bg));
      color:var(--ink); transition:background .25s ease, color .25s ease;
    }
    [data-theme="dark"] .page{
      background:
        radial-gradient(1000px 500px at 8% -18%, color-mix(in oklab, #1a7bb8 22%, transparent), transparent 58%),
        radial-gradient(900px 380px at 92% -10%, color-mix(in oklab, var(--amber) 16%, transparent), transparent 60%),
        linear-gradient(#0B1520, var(--bg));
    }

    /* ===== Hero ===== */
    .hero{ position:relative; overflow:hidden; border-radius:1.25rem; padding:1px; isolation:isolate; box-shadow: var(--shadow-lg) }
    .hero{ background: linear-gradient(120deg, #FFF3B0, #FFDF70 50%, #F5A201) }
    [data-theme="dark"] .hero{
      background:
        radial-gradient(900px 340px at 8% 12%, rgba(26,123,184,.26), transparent 60%),
        radial-gradient(720px 300px at 92% 8%, rgba(245,162,1,.18), transparent 60%),
        linear-gradient(120deg, #0B1520, #0E2230 50%, #0B1520);
    }
    .hero-inner{
      position:relative; z-index:1; border-radius:calc(var(--radius) - 6px);
      background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.82));
      backdrop-filter:saturate(140%) blur(7px);
      padding: 1.15rem 1.25rem; border:1px solid var(--border);
      box-shadow: inset 0 1px 0 rgba(255,255,255,.6); color:var(--ink);
    }
    [data-theme="dark"] .hero-inner{ background: linear-gradient(180deg, rgba(12,30,45,.80), rgba(12,30,45,.72)); box-shadow: inset 0 1px 0 rgba(255,255,255,.06) }

    /* ===== Panel / Toolbar ===== */
    .panel{ background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-sm) }
    .filters{ display:flex; flex-wrap:wrap; gap:.7rem 1rem; align-items:center }

    .chip{
      display:inline-flex;align-items:center;gap:.5rem;padding:.55rem .9rem;border-radius:.9rem;font-weight:900;
      border:1px solid var(--border); background:color-mix(in oklab,var(--panel),#fff 6%); color:var(--ink);
      transition: background .15s ease, border-color .15s ease, transform .06s ease;
    }
    .chip:hover{ transform:translateY(-1px) }
    .chip[data-active="1"]{ background:linear-gradient(90deg,var(--amber),var(--amber2)); color:#0f2b3a; border-color:transparent; box-shadow:0 10px 26px rgba(245,162,1,.22) }

    .select,.input{
      border:1px solid var(--border); border-radius:.8rem; padding:.55rem .8rem;
      background:color-mix(in oklab,var(--panel),#fff 6%); color:var(--ink);
    }
    /* Placeholder terang saat dark */
    .input::placeholder{ color: color-mix(in oklab, var(--ink), #888 55%) }
    [data-theme="dark"] .input,
    [data-theme="dark"] .select{
      background:#0F2231; border-color:#183041; color:#EAF6FF;
    }
    [data-theme="dark"] .input::placeholder,
    [data-theme="dark"] .select::placeholder{ color:#9ec0d6; opacity:1 }
    [data-theme="dark"] .input::-webkit-input-placeholder{ color:#9ec0d6 }
    [data-theme="dark"] .input::-moz-placeholder{ color:#9ec0d6; opacity:1 }
    [data-theme="dark"] input[type="date"]::-webkit-calendar-picker-indicator{ filter: invert(1) opacity(.9) }

    .btn{border-radius:1rem; padding:.72rem 1.05rem; font-weight:900; display:inline-flex; align-items:center; gap:.55rem}
    .btn-apply{ background:linear-gradient(90deg,var(--amber),var(--amber2)); color:#0f2b3a; box-shadow:0 10px 24px rgba(245,162,1,.22) }
    .btn-reset{ background:#0b2d42; color:#fff }
    [data-theme="dark"] .btn-reset{ background:#184158 }

    .divider{ width:1px; height:26px; background: color-mix(in oklab,var(--panel),#000 7%) }
    [data-theme="dark"] .divider{ background:#183041 }

    /* ===== Table ===== */
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
    .tbl tbody tr:nth-child(odd){ background:color-mix(in oklab, var(--panel), #fff 3%) }
    .tbl tbody tr:hover{ background:color-mix(in oklab, var(--panel), #fff 8%) }
    [data-theme="dark"] .tbl tbody tr:hover{ background:#142c3b }
    .price{ color:var(--amber); font-weight:800; font-feature-settings:"tnum" on,"lnum" on }

    /* ===== Read-only order status ===== */
    .pill{display:inline-block;padding:.34rem .78rem;border-radius:999px;font-weight:800;font-size:.78rem;border:1px solid var(--border)}
    .pill--pending {background:#FEF3C7; color:#92400E; border-color:#FDE68A}
    .pill--diproses{background:#DBEAFE; color:#1E40AF; border-color:#BFDBFE}
    .pill--diantar {background:#F3E8FF; color:#6B21A8; border-color:#E9D5FF}
    .pill--selesai {background:#DCFCE7; color:#065F46; border-color:#BBF7D0}
    .pill--default {background:#F3F4F6; color:#374151; border-color:#E5E7EB}
    [data-theme="dark"] .pill--pending {background:#2b2006; color:#facc15; border-color:#7a5f0a}
    [data-theme="dark"] .pill--diproses{background:#0d223c; color:#93c5fd; border-color:#1e3a8a}
    [data-theme="dark"] .pill--diantar {background:#24123f; color:#d8b4fe; border-color:#5b21b6}
    [data-theme="dark"] .pill--selesai {background:#052e18; color:#86efac; border-color:#14532d}
    [data-theme="dark"] .pill--default {background:#0f2231; color:#cbd5e1; border-color:#183041}

    /* ===== Payment selects (chip-like) ===== */
    .pay-chip{
      appearance:none; -webkit-appearance:none; -moz-appearance:none;
      border:1px solid var(--border); border-radius:999px;
      background-color:color-mix(in oklab,var(--panel),#fff 6%); color:var(--ink);
      padding:.42rem 1.8rem .42rem .75rem; font-weight:800; font-size:.85rem; cursor:pointer;
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%230B2D42' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
      background-repeat:no-repeat; background-position:right .55rem center; background-size:16px;
      transition:box-shadow .18s ease, border-color .18s ease;
    }
    /* 🔧 FIX: pakai background-color + set ulang repeat/pos/size agar chevron tidak berulang */
    [data-theme="dark"] .pay-chip{
      background-color:#0F2231; color:#EAF6FF; border-color:#183041;
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23EAF6FF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
      background-repeat:no-repeat; background-position:right .55rem center; background-size:16px;
    }
    .pay-chip:focus{outline:0; box-shadow:0 0 0 3px rgba(245,162,1,.25)}
  </style>

  <div class="page min-h-screen py-10" id="pageRoot">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

      {{-- ============ HEADER ============ --}}
      <section class="hero">
        <div class="hero-inner">
          <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
              <h1 class="text-2xl font-extrabold flex items-center gap-2" style="color:var(--ink)">💳 Kelola Pembayaran</h1>
              <p class="mt-1" style="color:var(--ink-soft)">
                Edit <b>status pembayaran</b> & <b>metode</b> pesanan. <strong>Status pesanan</strong> tampil read-only (ubahnya di <i>Kelola Pesanan</i>).
              </p>
            </div>
            <button id="themeToggle" class="chip" type="button" title="Toggle tema"><i class="fa-solid fa-moon"></i> Theme</button>
          </div>
        </div>
      </section>

      {{-- ============ FILTER BAR ============ --}}
      <div class="panel p-4">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="filters">
          <span class="font-bold" style="color:var(--ink)">Filter:</span>

          @php $pay = $filters['pay'] ?? null; @endphp
          <input type="hidden" name="pay" id="payHidden" value="{{ $pay }}">
          <button type="button" class="chip" data-pay=""            data-active="{{ !$pay ? '1':'0' }}">Semua</button>
          <button type="button" class="chip" data-pay="sudah_bayar" data-active="{{ $pay==='sudah_bayar' ? '1':'0' }}">Sudah bayar</button>
          <button type="button" class="chip" data-pay="belum_bayar" data-active="{{ $pay==='belum_bayar' ? '1':'0' }}">Belum bayar</button>

          <span class="divider"></span>

          <select class="select" name="method" aria-label="Metode">
            <option value="">Semua metode</option>
            @foreach($methods as $key => $label)
              <option value="{{ $key }}" @selected(($filters['method'] ?? '')===$key)>{{ $label }}</option>
            @endforeach
          </select>

          <span class="divider"></span>

          <div class="flex items-center gap-2">
            <input type="date" class="input" name="from" value="{{ $filters['from'] ?? '' }}">
            <span style="opacity:.6">—</span>
            <input type="date" class="input" name="to" value="{{ $filters['to'] ?? '' }}">
          </div>

          <span class="divider"></span>

          <input type="text" name="q" class="input" placeholder="Cari nama, email, layanan…" value="{{ $filters['q'] ?? '' }}" style="min-width:260px">

          <div class="ml-auto flex items-center gap-2">
            <button class="btn btn-apply" type="submit"><i class="fa-solid fa-filter"></i> Terapkan</button>
            <a class="btn btn-reset" href="{{ route('admin.payments.index') }}"><i class="fa-solid fa-rotate-left"></i> Reset</a>
          </div>
        </form>
      </div>

      {{-- ============ TABLE ============ --}}
      <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
          <table class="tbl text-sm">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>User</th>
                <th>Layanan</th>
                <th>Total</th>
                <th>Status Pesanan</th>
                <th>Metode</th>
                <th>Status Bayar</th>
                <th class="text-left">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $order)
                @php
                  $st = $order->status;
                  $pill = match($st){
                    'pending'  => 'pill pill--pending',
                    'diproses' => 'pill pill--diproses',
                    'diantar'  => 'pill pill--diantar',
                    'selesai'  => 'pill pill--selesai',
                    default    => 'pill pill--default'
                  };
                @endphp
                <tr>
                  <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</td>

                  <td class="font-medium" style="color:var(--ink)">
                    {{ $order->user->name ?? '-' }}
                    <div class="text-xs" style="color:var(--ink-soft)">{{ $order->user->email ?? '' }}</div>
                  </td>

                  <td>
                    <div class="font-medium" style="color:var(--ink)">{{ $order->service->name ?? '-' }}</div>
                    <div class="text-xs" style="color:var(--ink-soft)">
                      Rp {{ number_format($order->service->price ?? 0,0,',','.') }}/{{ $order->service->unit ?? '-' }}
                    </div>
                  </td>

                  <td class="price">Rp {{ number_format($order->total_price ?? 0,0,',','.') }}</td>

                  <td>
                    <span class="{{ $pill }}" title="Ubah status pesanan di Kelola Pesanan">{{ ucfirst($st ?? '-') }}</span>
                  </td>

                  {{-- Metode (editable) --}}
                  <td>
                    <form action="{{ route('admin.payments.update', $order) }}" method="POST" class="inline-flex items-center gap-2" onsubmit="return true">
                      @csrf @method('PATCH')
                      <select name="payment_method" class="pay-chip">
                        <option value="">— Pilih —</option>
                        @foreach($methods as $key => $label)
                          <option value="{{ $key }}" @selected(($order->payment_method ?? '')===$key)>{{ $label }}</option>
                        @endforeach
                      </select>
                      <input type="hidden" name="payment_status" value="{{ $order->payment_status ?? 'belum_bayar' }}">
                      <button class="hidden"></button>
                    </form>
                  </td>

                  {{-- Status Bayar (editable) --}}
                  <td>
                    <form action="{{ route('admin.payments.update', $order) }}" method="POST" class="inline-flex items-center gap-2" onsubmit="return true">
                      @csrf @method('PATCH')
                      <select name="payment_status" class="pay-chip">
                        <option value="belum_bayar" @selected(($order->payment_status ?? 'belum_bayar')==='belum_bayar')>Belum Bayar</option>
                        <option value="sudah_bayar" @selected(($order->payment_status ?? '')==='sudah_bayar')>Sudah Bayar</option>
                      </select>
                      <input type="hidden" name="payment_method" value="{{ $order->payment_method }}">
                      <button class="hidden"></button>
                    </form>
                  </td>

                  <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}"
                       class="px-3 py-1.5 rounded-md bg-indigo-500 text-white hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                       title="Detail pesanan">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr><td colspan="8" class="text-center py-8" style="color:var(--ink-soft)">Tidak ada data.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  {{-- ============ TOASTS ============ --}}
  <div id="toast-stack" class="fixed top-4 right-4 z-50 space-y-3 w-[calc(100%-2rem)] max-w-sm">
    @foreach (['success'=>'Berhasil','error'=>'Gagal','warning'=>'Perhatian','info'=>'Info'] as $k=>$title)
      @if (session($k))
        <div class="toast flex items-start gap-3 rounded-xl"
             style="background:color-mix(in oklab, var(--panel), #fff 92%); color:var(--ink); border:1px solid var(--border); box-shadow:var(--shadow-sm); padding:1rem;">
          <div class="shrink-0 w-8 h-8 rounded-full
                      {{ $k==='success'?'bg-green-100 text-green-700':'' }}
                      {{ $k==='error'  ?'bg-red-100 text-red-700'    :'' }}
                      {{ $k==='warning'?'bg-yellow-100 text-yellow-700':'' }}
                      {{ $k==='info'   ?'bg-blue-100 text-blue-700'  :'' }} flex items-center justify-center">
            <i class="fa-solid
                      {{ $k==='success'?'fa-check':'' }}
                      {{ $k==='error'  ?'fa-triangle-exclamation':'' }}
                      {{ $k==='warning'?'fa-circle-exclamation':'' }}
                      {{ $k==='info'   ?'fa-circle-info':'' }}"></i>
          </div>
          <div class="text-sm">
            <p class="font-semibold">{{ $title }}</p>
            <p>{{ session($k) }}</p>
          </div>
          <button class="ml-auto text-gray-400 hover:text-gray-600" onclick="this.closest('.toast').remove()">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      @endif
    @endforeach
  </div>

  {{-- Font Awesome (CSS) --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" crossorigin="anonymous">

  <script>
    // Theme toggle persist
    (function(){
      const root=document.documentElement, KEY='ql-theme';
      const saved=localStorage.getItem(KEY);
      if(saved){ root.setAttribute('data-theme', saved) }
      else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){ root.setAttribute('data-theme','dark') }
      document.getElementById('themeToggle')?.addEventListener('click', ()=>{
        const next=root.getAttribute('data-theme')==='dark'?'light':'dark';
        root.setAttribute('data-theme', next); localStorage.setItem(KEY, next);
      });
    })();

    // Filter chips submit
    document.querySelectorAll('[data-pay]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        document.getElementById('payHidden').value = btn.dataset.pay || '';
        document.querySelectorAll('[data-pay]').forEach(b=>b.setAttribute('data-active','0'));
        btn.setAttribute('data-active','1');
        btn.closest('form').submit();
      });
    });

    // Autosubmit selects + kirim pasangan hidden
    document.querySelectorAll('form[method="POST"] select.pay-chip').forEach(sel=>{
      sel.addEventListener('change', ()=>{
        const form = sel.closest('form');
        const hidden = form.querySelector('input[type="hidden"][name="'+(sel.name==='payment_status' ? 'payment_method' : 'payment_status')+'"]');
        if(hidden){
          const siblingSelect = form.parentElement.querySelector('select[name="'+hidden.name+'"]');
          if(siblingSelect) hidden.value = siblingSelect.value;
        }
        form.submit();
      });
    });

    // Auto dismiss toasts
    document.querySelectorAll('#toast-stack .toast').forEach((t,i)=>{
      setTimeout(()=>{ t.style.transition='opacity .4s ease, transform .4s ease';
        t.style.opacity='0'; t.style.transform='translateY(-4px)'; setTimeout(()=>t.remove(),420);
      }, 3800 + i * 300);
    });
  </script>
</x-app-layout>
