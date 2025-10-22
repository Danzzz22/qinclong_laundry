<x-app-layout>
  <style>
    /* ===== THEME TOKENS (light/dark aware) ===== */
    :root{
      --ink:#0B2D42; --ink-soft:#5c7283;
      --bg:#F7FAFC; --panel:#FFFFFF; --border: color-mix(in oklab, var(--panel), #000 8%);
      --shadow: 0 14px 34px rgba(1,60,88,.08);
      --amber:#F5A201; --amber2:#FFBA42; --sky:#A8E8F9;
    }
    [data-theme="dark"]{
      --ink:#EAF6FF; --ink-soft:#b8d0e0;
      --bg:#0E1723; --panel:#0F2231; --border:#183041;
      --shadow: 0 16px 40px rgba(0,0,0,.48);
    }
    :root,[data-theme="dark"]{ color-scheme: light dark }

    html.admin-report { scroll-behavior: auto !important; }
    body.admin-report { overscroll-behavior: contain; }
    .admin-wrap{ background:var(--bg); color:var(--ink) }

    /* ===== HERO ===== */
    .hero{ border-radius:1.25rem; padding:1px; box-shadow:var(--shadow); overflow:hidden }
    .hero-bg{
      border-radius:inherit;
      background:linear-gradient(135deg,#A8E8F9 0%,#FFBA42 55%,#F5A201 100%);
    }
    [data-theme="dark"] .hero-bg{
      background:
        radial-gradient(900px 340px at 8% 12%, rgba(26,123,184,.26), transparent 60%),
        radial-gradient(720px 300px at 92% 8%, rgba(245,162,1,.18), transparent 60%),
        linear-gradient(135deg,#0B1520,#0E2230 60%,#0B1520);
    }
    .hero-inner{
      background: color-mix(in oklab, var(--panel), #fff 92%);
      backdrop-filter:saturate(140%) blur(6px);
      border:1px solid var(--border);
      border-radius:calc(1.25rem - 6px);
      padding:1.25rem 1.5rem;
      color:var(--ink);
    }
    [data-theme="dark"] .hero-inner{
      background: color-mix(in oklab, var(--panel), #000 0%);
      box-shadow: inset 0 1px 0 rgba(255,255,255,.06);
    }
    .chip{
      display:inline-flex;align-items:center;gap:.45rem;padding:.5rem .8rem;border-radius:.9rem;font-weight:900;
      border:1px solid var(--border); background:color-mix(in oklab,var(--panel),#fff 6%); color:var(--ink);
    }

    /* ===== KPI CARDS ===== */
    .kpi{ border-radius:1rem; background:var(--panel); box-shadow:var(--shadow); border:1px solid var(--border) }
    .kpi .icon{
      width:48px;height:48px;border-radius:12px;display:grid;place-items:center;
      background:linear-gradient(135deg,var(--amber),var(--amber2)); color:#0B2D42;
      box-shadow:0 8px 20px rgba(245,162,1,.25)
    }
    .soft-bar{height:8px;border-radius:999px;background: color-mix(in oklab, var(--panel), #000 8%); overflow:hidden}
    .soft-bar>span{display:block;height:100%;background:linear-gradient(90deg, var(--amber), var(--amber2))}

    /* ===== TOOLBAR ===== */
    .toolbar{background:var(--panel); border:1px solid var(--border); border-radius:1rem; box-shadow:var(--shadow)}
    .chip--ghost{background:color-mix(in oklab,var(--panel),#fff 6%);border:1px solid var(--border)}
    .chip--on{background:linear-gradient(90deg,var(--amber),var(--amber2));color:#0f2b3a;box-shadow:0 10px 26px rgba(245,162,1,.25)}
    .input{ border:1px solid var(--border); border-radius:.7rem; padding:.5rem .7rem; background:color-mix(in oklab,var(--panel),#fff 6%); color:var(--ink) }
    .input::placeholder{ color: color-mix(in oklab, var(--ink), #888 55%) }

    /* Select (chevron ikut tema) */
    .select{
      appearance:none; -webkit-appearance:none; -moz-appearance:none;
      border:1px solid var(--border); border-radius:9999px; background:color-mix(in oklab,var(--panel),#fff 6%);
      padding:.6rem 2rem .6rem .9rem; line-height:1.4; font-weight:800; color:var(--ink);
      background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' width='20' height='20' fill='%230B2D42'><path d='M5.5 7.5l4.5 4.5 4.5-4.5'/></svg>");
      background-repeat:no-repeat; background-position:right .65rem center; background-size:14px;
      white-space:nowrap;
    }
    [data-theme="dark"] .input,
    [data-theme="dark"] .select{ background:#0F2231; border-color:#183041; color:#EAF6FF }
    [data-theme="dark"] .input::placeholder{ color:#9ec0d6 }
    [data-theme="dark"] .select{
      background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' width='20' height='20' fill='%23EAF6FF'><path d='M5.5 7.5l4.5 4.5 4.5-4.5'/></svg>");
    }

    .btn{ border-radius:.7rem; padding:.6rem .9rem; font-weight:800; background:#0B2D42; color:#fff; transition:transform .12s ease, box-shadow .12s ease }
    .btn:hover{ transform:translateY(-1px); box-shadow:0 10px 22px rgba(1,60,88,.2) }
    .btn-alt{ background:linear-gradient(90deg,var(--amber),var(--amber2)); color:#102b3a }

    /* ===== TABLE ===== */
    .tbl-wrap{ border-radius:1rem; background:var(--panel); box-shadow:var(--shadow); border:1px solid var(--border) }
    .tbl thead th{ background: color-mix(in oklab, var(--panel), #fff 88%); color:var(--ink) }
    [data-theme="dark"] .tbl thead th{ background: color-mix(in oklab, var(--panel), #000 6%); color:#d6e8f6 }
    .tbl th, .tbl td{ vertical-align: middle; padding:.9rem 1.1rem }
    .tbl tbody tr:nth-child(odd){ background:color-mix(in oklab, var(--panel), #fff 3%) }
    .tbl tbody tr:hover{ background:color-mix(in oklab, var(--panel), #fff 8%) }
    [data-theme="dark"] .tbl tbody tr:hover{ background:#142c3b }

    .pill{display:inline-block;padding:.22rem .6rem;border-radius:999px;font-weight:800;font-size:.72rem;white-space:nowrap;border:1px solid transparent}
    .pill--paid{background:#DCFCE7;color:#166534;border-color:#BBF7D0}
    .pill--unpaid{background:#FEF3C7;color:#B45309;border-color:#FDE68A}
    .pill--method{background:color-mix(in oklab, var(--panel), #fff 6%); color:var(--ink); border-color:var(--border)}

    /* ===== CHART WRAPPERS ===== */
    .chart-box{height:320px}
    .chart-box--small{height:300px}
  </style>

  @php
    $paidRate = $totalOrders ? round($paidOrders * 100 / $totalOrders) : 0;
    $aov = $paidOrders ? floor($revenue / $paidOrders) : 0;
  @endphp

  <div class="admin-report admin-wrap py-10 min-h-screen" id="pageRoot">
    <div class="max-w-7xl mx-auto px-6 space-y-8">

      {{-- HERO --}}
      <div class="hero">
        <div class="hero-bg p-1">
          <div class="hero-inner">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-2xl font-extrabold" style="color:var(--ink)">📊 Laporan Transaksi</h1>
                <p class="mt-1" style="color:var(--ink-soft)">Ringkasan transaksi & pembayaran pelanggan.</p>
              </div>
              <button id="themeToggle" class="chip" type="button" title="Toggle tema">
                <i class="fa-solid fa-moon"></i> Theme
              </button>
            </div>
          </div>
        </div>
      </div>

      {{-- KPI --}}
      <div class="grid grid-cols-4 gap-6">
        <div class="kpi p-5"><div class="flex items-start gap-3">
          <div class="icon"><i class="fa-solid fa-list-check"></i></div>
          <div class="flex-1">
            <p style="color:var(--ink-soft)">Total Pesanan</p>
            <div class="text-3xl font-extrabold" style="color:var(--ink)">{{ number_format($totalOrders) }}</div>
            <div class="soft-bar mt-2"><span style="width: 100%"></span></div>
          </div>
        </div></div>

        <div class="kpi p-5"><div class="flex items-start gap-3">
          <div class="icon"><i class="fa-solid fa-circle-check"></i></div>
          <div class="flex-1">
            <p style="color:var(--ink-soft)">Sudah Dibayar</p>
            <div class="text-3xl font-extrabold text-green-500">{{ number_format($paidOrders) }}</div>
            <div class="soft-bar mt-2"><span style="width: {{ $paidRate }}%"></span></div>
            <div class="mt-2 text-xs" style="color:var(--ink-soft)">Paid rate: <b style="color:var(--ink)">{{ $paidRate }}%</b></div>
          </div>
        </div></div>

        <div class="kpi p-5"><div class="flex items-start gap-3">
          <div class="icon"><i class="fa-solid fa-wallet"></i></div>
          <div class="flex-1">
            <p style="color:var(--ink-soft)">Belum Dibayar</p>
            <div class="text-3xl font-extrabold text-yellow-500">{{ number_format($unpaidOrders) }}</div>
            <div class="soft-bar mt-2"><span style="width: {{ 100 - $paidRate }}%"></span></div>
          </div>
        </div></div>

        <div class="kpi p-5"><div class="flex items-start gap-3">
          <div class="icon"><i class="fa-solid fa-coins"></i></div>
          <div class="flex-1">
            <p style="color:var(--ink-soft)">Pendapatan (paid)</p>
            <div class="text-3xl font-extrabold" style="color:#F5A201">Rp {{ number_format($revenue,0,',','.') }}</div>
            <div class="mt-2 text-xs" style="color:var(--ink-soft)">AOV: <b style="color:var(--ink)">Rp {{ number_format($aov,0,',','.') }}</b></div>
          </div>
        </div></div>
      </div>

      {{-- CHARTS --}}
      <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 rounded-2xl p-6" style="background:var(--panel); box-shadow:var(--shadow); border:1px solid var(--border)">
          <h2 class="text-lg font-bold mb-3" style="color:var(--ink)">📈 Pendapatan Bulanan</h2>
          <div class="chart-box"><canvas id="revenueChart" class="w-full h-full"></canvas></div>
        </div>
        <div class="rounded-2xl p-6" style="background:var(--panel); box-shadow:var(--shadow); border:1px solid var(--border)">
          <h2 class="text-lg font-bold mb-3" style="color:var(--ink)">💳 Paid vs Unpaid</h2>
          <div class="chart-box--small"><canvas id="ratioChart" class="w-full h-full"></canvas></div>
          <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
            <div class="p-3 rounded border border-green-200" style="background:color-mix(in oklab, var(--panel), #22c55e 12%)">
              <div class="font-bold text-green-700">Paid</div>
              <div style="color:var(--ink)">{{ number_format($paidOrders) }} order</div>
            </div>
            <div class="p-3 rounded border border-yellow-200" style="background:color-mix(in oklab, var(--panel), #f59e0b 12%)">
              <div class="font-bold text-yellow-700">Unpaid</div>
              <div style="color:var(--ink)">{{ number_format($unpaidOrders) }} order</div>
            </div>
          </div>
        </div>
      </div>

      {{-- TOOLBAR (client-side helper) --}}
      <div class="toolbar p-4">
        <div class="flex items-center flex-wrap gap-3">
          <span class="text-sm font-bold mr-2" style="color:var(--ink)">Filter:</span>

          <button class="chip chip--ghost" data-filter-status="all">Semua</button>
          <button class="chip chip--ghost" data-filter-status="paid">Sudah bayar</button>
          <button class="chip chip--ghost" data-filter-status="unpaid">Belum bayar</button>

          <span class="h-6 w-px mx-1" style="background:var(--border)"></span>

          <select class="select select-sm" id="methodFilter">
            <option value="">Semua metode</option>
            @foreach($methods as $m)
              <option value="{{ strtolower($m) }}">{{ ucfirst($m) }}</option>
            @endforeach
          </select>

          <span class="h-6 w-px mx-1" style="background:var(--border)"></span>

          <div class="flex items-center gap-2">
            <input type="date" class="input" id="dateFrom" placeholder="Dari">
            <span style="color:var(--ink-soft)">—</span>
            <input type="date" class="input" id="dateTo" placeholder="Sampai">
          </div>

          <div class="ml-auto flex items-center gap-2">
            <button id="exportCsv" class="btn btn-alt"><i class="fa-solid fa-file-arrow-down mr-2"></i>Export CSV</button>
            <button id="printTable" class="btn"><i class="fa-solid fa-print mr-2"></i>Print</button>
          </div>
        </div>
      </div>

      {{-- TABLE (READ-ONLY) --}}
      <div class="tbl-wrap">
        <div class="overflow-x-auto">
          <table class="tbl w-full text-sm">
            <thead class="uppercase text-xs">
              <tr>
                <th class="text-left">Tanggal</th>
                <th class="text-left">User</th>
                <th class="text-left">Layanan</th>
                <th class="text-left">Total</th>
                <th class="text-left w-40">Metode</th>
                <th class="text-left w-40">Status Bayar</th>
                <th class="text-left w-40">Status Pesanan</th>
              </tr>
            </thead>
            <tbody id="ordersBody" class="divide-y" style="border-color:var(--border)">
              @forelse($orders as $order)
                @php
                  $isPaid = in_array($order->payment_status, ['paid','sudah_bayar']);
                  $methodVal = strtolower($order->payment_method ?? '');
                  $st = $order->status;
                  $orderPillClass = match($st){
                    'pending'  => 'bg-yellow-100 text-yellow-800',
                    'diproses' => 'bg-blue-100 text-blue-800',
                    'diantar'  => 'bg-purple-100 text-purple-800',
                    'selesai'  => 'bg-green-100 text-green-800',
                    default    => 'bg-gray-100 text-gray-700',
                  };
                @endphp
                <tr class="hover:bg-[#FFF8EB]"
                    data-status="{{ $isPaid ? 'paid' : 'unpaid' }}"
                    data-method="{{ $methodVal }}"
                    data-date="{{ optional($order->created_at)->format('Y-m-d') }}">
                  <td class="whitespace-nowrap">{{ $order->created_at?->format('d M Y H:i') }}</td>
                  <td>
                    <div class="font-semibold" style="color:var(--ink)">{{ $order->user->name ?? '-' }}</div>
                    <div class="text-xs" style="color:var(--ink-soft)">{{ $order->user->email ?? '' }}</div>
                  </td>
                  <td>{{ $order->service->name ?? '-' }}</td>
                  <td>
                    <span class="inline-flex items-baseline gap-1.5 whitespace-nowrap" style="color:#F5A201">
                      <span class="font-extrabold">Rp</span>
                      <span class="font-black">{{ number_format($order->total_price,0,',','.') }}</span>
                    </span>
                  </td>
                  <td><span class="pill pill--method">{{ $order->payment_method ? ucfirst($order->payment_method) : '—' }}</span></td>
                  <td><span class="pill {{ $isPaid ? 'pill--paid' : 'pill--unpaid' }}">{{ $isPaid ? 'Sudah Bayar' : 'Belum Bayar' }}</span></td>
                  <td><span class="pill {{ $orderPillClass }}">{{ $st ? ucfirst($st) : '—' }}</span></td>
                </tr>
              @empty
                <tr><td colspan="7" class="text-center py-8" style="color:var(--ink-soft)">Tidak ada data.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="px-6 py-4 rounded-b-2xl text-sm" style="background:var(--panel); border-top:1px solid var(--border); color:var(--ink-soft)">
          @if(method_exists($orders,'firstItem'))
            Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} hasil
          @else
            Menampilkan {{ count($orders ?? []) }} hasil
          @endif
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // ===== THEME TOGGLE (persist) =====
    (function(){
      const root=document.documentElement, KEY='ql-theme';
      const saved=localStorage.getItem(KEY);
      if(saved){ root.setAttribute('data-theme', saved) }
      else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){ root.setAttribute('data-theme','dark') }
      document.getElementById('themeToggle')?.addEventListener('click', ()=>{
        const next=root.getAttribute('data-theme')==='dark'?'light':'dark';
        root.setAttribute('data-theme', next); localStorage.setItem(KEY, next);
        applyChartTheme(next);
      });
    })();

    // ===== Charts
    const months   = @json($months);
    const revenues = @json($revenues);

    const revCtx = document.getElementById('revenueChart').getContext('2d');
    const grad = revCtx.createLinearGradient(0,0,0,240);
    grad.addColorStop(0,'#F5A201'); grad.addColorStop(1,'#FFE3A6');

    const revChart = new Chart(revCtx, {
      type: 'bar',
      data: { labels: months, datasets: [{ label: 'Pendapatan (Rp)', data: revenues, backgroundColor: grad, borderRadius: 8, maxBarThickness: 42 }] },
      options: {
        responsive: true, maintainAspectRatio: false, animation: { duration: 600 },
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => 'Rp ' + new Intl.NumberFormat('id-ID').format(c.raw) } } },
        scales: {
          x: { grid: { display:false }, ticks:{ color:getComputedStyle(document.documentElement).getPropertyValue('--ink') } },
          y: {
            ticks: { callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) },
            grid: { color: 'rgba(2,32,48,.06)' }
          }
        }
      }
    });

    const ratioCtx = document.getElementById('ratioChart').getContext('2d');
    const ratioChart = new Chart(ratioCtx, {
      type: 'doughnut',
      data: { labels: ['Paid','Unpaid'], datasets: [{ data: [{{ (int)$paidOrders }}, {{ (int)$unpaidOrders }}], backgroundColor: ['#22C55E', '#F59E0B'], borderWidth: 0 }] },
      options: { responsive: true, maintainAspectRatio: false, cutout: '65%', animation: { duration: 600 }, plugins: { legend: { display: false } } }
    });

    // ===== Apply chart theme dynamically so labels/grid terlihat di dark
    function applyChartTheme(theme){
      const dark = (theme || document.documentElement.getAttribute('data-theme')) === 'dark';
      const labelColor = dark ? '#d4e3ef' : '#0B2D42';
      const gridColor  = dark ? 'rgba(234,246,255,.12)' : 'rgba(2,32,48,.06)';

      Chart.defaults.color = labelColor;

      // Revenue chart axes
      revChart.options.scales.x.ticks.color = labelColor;
      revChart.options.scales.y.ticks.color = labelColor;
      revChart.options.scales.y.grid.color  = gridColor;
      revChart.update('none');

      // Doughnut has no axes; force tooltip/labels color via defaults above
      ratioChart.update('none');
    }
    // First paint
    applyChartTheme(document.documentElement.getAttribute('data-theme') || 'light');

    // ===== Client-side filters (unchanged logic)
    const chips = document.querySelectorAll('[data-filter-status]');
    const methodFilter = document.getElementById('methodFilter');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    let statusActive = 'all';

    chips.forEach(ch => {
      ch.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('chip--on'));
        ch.classList.add('chip--on');
        statusActive = ch.dataset.filterStatus;
        applyFilters();
      });
    });
    [methodFilter, dateFrom, dateTo].forEach(el => el.addEventListener('change', applyFilters));

    function applyFilters(){
      const rows = document.querySelectorAll('#ordersBody tr');
      const methodVal = (methodFilter.value || '').toLowerCase();
      const from = dateFrom.value ? new Date(dateFrom.value + 'T00:00:00') : null;
      const to   = dateTo.value ? new Date(dateTo.value + 'T23:59:59') : null;

      rows.forEach(r => {
        const st = r.dataset.status;
        const md = (r.dataset.method || '').toLowerCase();
        const dateAttr = r.dataset.date;
        const d  = dateAttr ? new Date(dateAttr + 'T12:00:00') : null;

        let vis = true;
        if(statusActive !== 'all' && st !== statusActive) vis = false;
        if(methodVal && md !== methodVal) vis = false;
        if(from && d && d < from) vis = false;
        if(to && d && d > to) vis = false;

        r.style.display = vis ? '' : 'none';
      });
    }

    // ===== Export CSV
    document.getElementById('exportCsv')?.addEventListener('click', () => {
      const rows = [['Tanggal','User','Email','Layanan','Total','Metode','Status Bayar','Status Pesanan']];
      document.querySelectorAll('#ordersBody tr').forEach(tr => {
        if(tr.style.display === 'none') return;
        const tds = tr.querySelectorAll('td');
        const tanggal = tds[0]?.innerText.trim() || '';
        const user    = tds[1]?.querySelector('div.font-semibold')?.innerText.trim() || '';
        const email   = tds[1]?.querySelector('div.text-xs')?.innerText.trim() || '';
        const layanan = tds[2]?.innerText.trim() || '';
        const total   = (tds[3]?.innerText.trim() || '').replace(/[^\d]/g,'');
        const metode  = tds[4]?.innerText.trim() || '';
        const statusB = tds[5]?.innerText.trim() || '';
        const statusO = tds[6]?.innerText.trim() || '';
        rows.push([tanggal,user,email,layanan,total,metode,statusB,statusO]);
      });

      const csv = rows.map(r => r.map(v => `"${String(v).replace(/"/g,'""')}"`).join(',')).join('\n');
      const blob = new Blob([csv], {type: 'text/csv;charset=utf-8;'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url; a.download = 'laporan-transaksi.csv'; a.click();
      URL.revokeObjectURL(url);
    });

    // ===== Print
    document.getElementById('printTable')?.addEventListener('click', () => {
      const w = window.open('', '', 'width=1024,height=768');
      const html = `
        <html><head>
          <title>Print - Laporan Transaksi</title>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
          <style>table{width:100%} th,td{padding:.5rem .75rem} thead{background:#F3F6FA}</style>
        </head><body class="p-6">
          <h1 class="text-2xl font-bold mb-4">Laporan Transaksi</h1>
          ${document.querySelector('.tbl-wrap').innerHTML}
        </body></html>`;
      w.document.write(html); w.document.close(); w.focus(); w.print(); w.close();
    });
  </script>
</x-app-layout>
