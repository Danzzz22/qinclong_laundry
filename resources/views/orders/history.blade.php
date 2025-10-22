<x-app-layout>
  {{-- ===== History (User) — mobile-first + pro cards, konsisten dengan Dashboard ===== --}}
  <style>
    :root{ --ink:#013C58; --sky:#A8E8F9; --amber:#F5A201; --amber-2:#FFBA42 }
    /* decorative bg seperti dashboard */
    .dash-bg{position:relative;overflow:hidden}
    .dash-bg::before{
      content:""; position:absolute; inset:-50% -20% auto -20%; height:58%;
      background:
        radial-gradient(520px 240px at 15% 18%, rgba(168,232,249,.25), transparent 60%),
        radial-gradient(480px 220px at 85% 8%, rgba(255,211,91,.18), transparent 60%);
      pointer-events:none; z-index:0;
    }

    /* glow edge (subtle) untuk header kartu besar */
    .glow-card{position:relative;overflow:hidden;border-radius:1rem}
    .glow-card::before{
      content:""; position:absolute; inset:-1px; border-radius:1.05rem; z-index:-1;
      background:conic-gradient(from 180deg, #FFD35B, #A8E8F9, #F5A201, #FFD35B);
      filter:blur(10px); opacity:.35;
    }

    /* progress bar (sama seperti dashboard) */
    .bar{height:10px;border-radius:999px;background:#EEF2F7;overflow:hidden}
    .bar>span{display:block;height:100%;background:linear-gradient(90deg, var(--amber), var(--amber-2))}

    /* pills status */
    .pill{display:inline-block;padding:.28rem .6rem;border-radius:999px;font-weight:800;font-size:.78rem}
    .pill--pending{background:#FEF3C7;color:#B45309}
    .pill--diproses{background:#DBEAFE;color:#1D4ED8}
    .pill--selesai{background:#DCFCE7;color:#16A34A}
    .pill--diantar{background:#EDE9FE;color:#6D28D9}
    .pill--default{background:#F3F4F6;color:#374151}

    /* chips pembayaran */
    .chip{display:inline-flex;align-items:center;gap:.35rem;padding:.22rem .55rem;border-radius:9999px;font-size:11px;font-weight:700}
    .chip-pay-ok{background:#E6F9EE;color:#10793E;border:1px solid #B9EDCC}
    .chip-pay-warn{background:#FFF7E6;color:#9A6100;border:1px solid #FDE1A1}
    .chip-method{background:#F1F5F9;color:#334155;border:1px solid #E2E8F0}

    /* CARD: ring gradient + glassy */
    .order-card{
      position:relative; border-radius:1rem; background:rgba(255,255,255,.92);
      backdrop-filter:saturate(140%) blur(8px);
      box-shadow:0 12px 28px rgba(1,60,88,.10), 0 2px 8px rgba(1,60,88,.06);
      transition:transform .2s ease, box-shadow .2s ease;
      isolation:isolate;
    }
    .order-card:hover{ transform:translateY(-2px); box-shadow:0 20px 48px rgba(1,60,88,.16) }
    .order-card::before{
      content:""; position:absolute; inset:-1px; border-radius:1.05rem; z-index:-1;
      background:linear-gradient(120deg, rgba(255,186,66,.7), rgba(168,232,249,.7));
      filter:blur(10px); opacity:.35;
    }

    /* ICON BOX kiri kartu */
    .icon-box{
      width:44px;height:44px;border-radius:12px;
      background:linear-gradient(135deg, var(--amber), var(--amber-2));
      color:#0B2D42; display:grid;place-items:center;font-size:1.15rem; box-shadow:0 6px 18px rgba(245,162,1,.25)
    }

    /* timeline jemput/antar */
    .tl{position:relative;margin:.25rem 0 .25rem .75rem;padding-left:.75rem}
    .tl::before{content:"";position:absolute;left:-.5rem;top:.35rem;bottom:.35rem;width:2px;background:#E5E7EB;border-radius:2px}
    .tl li{position:relative;margin:.2rem 0;padding-left:.4rem}
    .tl li::before{content:"";position:absolute;left:-.58rem;top:.35rem;width:8px;height:8px;border-radius:999px;background:#CBD5E1;box-shadow:0 0 0 2px #fff}

    .wrap{overflow:auto;border:1px solid #e5e7eb;border-radius:1rem;background:#fff}
    .thead{position:sticky;top:0;background:linear-gradient(90deg,#E6F7FD,#FDF6E6);color:var(--ink);z-index:5}

    .sticky-filters{position:sticky; top:4rem; z-index:45; background:rgba(255,255,255,.9); backdrop-filter:blur(6px); border-bottom:1px solid #eef2f7}
    .safe-bottom{padding-bottom: max(env(safe-area-inset-bottom), 0.5rem)}

    @media (prefers-reduced-motion: reduce){
      *{animation-duration:.01ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important}
    }
  </style>

  @php
    // Koleksi orders dari controller (fallback aman)
    $orders = $orders ?? ($orderHistory ?? ($histories ?? collect()));

    // Statistik (tanpa relasi User::orders(); langsung query)
    $uid  = auth()->id();
    $t    = $totalOrders      ?? \App\Models\Order::where('user_id', $uid)->count();
    $c    = $completedOrders  ?? \App\Models\Order::where('user_id', $uid)->where('status','selesai')->count();
    $proc = $processingOrders ?? \App\Models\Order::where('user_id', $uid)->where('status','diproses')->count();
    $pend = $pendingOrders    ?? \App\Models\Order::where('user_id', $uid)->where('status','pending')->count();
    $rate = $t ? round($c*100/$t) : 0;

    $unreadCount = $unreadNotificationsCount ?? (auth()->user()?->unreadNotifications()->count() ?? 0);
    $hasPagination = method_exists($orders,'links'); // biarin aja, tapi nggak dipakai di bawah
  @endphp

  <div class="min-h-screen bg-white dash-bg font-sans relative pb-20 md:pb-0">
    <!-- ===== Header / Greeting ===== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 pt-6 relative z-[1]">
      <div class="glow-card bg-[var(--ink)] text-white rounded-xl p-5 sm:p-6 shadow-xl">
        <div class="flex items-start justify-between gap-4">
          <div>
            <h1 class="text-[clamp(1.25rem,3.5vw,1.75rem)] font-extrabold leading-snug">
              Riwayat Pesanan
            </h1>
            <p class="mt-1 text-[13px] sm:text-sm text-[#A8E8F9]">
              Lihat pesananmu dari semua status. Mobile-friendly & rapi di desktop. ✨
            </p>
          </div>
          <div class="shrink-0 hidden sm:block text-6xl opacity-10">🧺</div>
        </div>

        <!-- quick stats -->
        <div class="mt-4 grid grid-cols-3 gap-2 sm:gap-3 text-center">
          <div class="bg-white/10 rounded-lg px-3 py-2">
            <div class="text-[12px] text-[#A8E8F9]">Total</div>
            <div class="text-xl sm:text-2xl font-extrabold">{{ $t }}</div>
          </div>
          <div class="bg-white/10 rounded-lg px-3 py-2">
            <div class="text-[12px] text-[#A8E8F9]">Selesai</div>
            <div class="text-xl sm:text-2xl font-extrabold text-[#FFBA42]">{{ $c }}</div>
          </div>
          <div class="bg-white/10 rounded-lg px-3 py-2">
            <div class="text-[12px] text-[#A8E8F9]">Completion</div>
            <div class="text-xl sm:text-2xl font-extrabold">{{ $rate }}%</div>
          </div>
        </div>

        <div class="mt-3">
          <div class="flex items-center justify-between">
            <span class="text-xs text-[#A8E8F9]">Progress penyelesaian</span>
            <span class="text-xs text-white font-semibold">{{ $rate }}%</span>
          </div>
          <div class="bar mt-1.5"><span style="width: {{ $rate }}%"></span></div>
        </div>
      </div>
    </section>

    <!-- ===== Sticky Filters ===== -->
    <section class="sticky-filters">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
        @php
          $tabs = [
            null        => 'Semua',
            'pending'   => '⏳ Pending',
            'diproses'  => '🔄 Diproses',
            'selesai'   => '✅ Selesai',
            'diantar'   => '🚚 Diantar',
          ];
        @endphp

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div class="flex gap-2 overflow-x-auto pb-1">
            @foreach($tabs as $status => $label)
              @php $active = request('status') === $status; @endphp
              <a href="{{ route('user.orders.history', $status ? ['status'=>$status] : []) }}"
                 class="shrink-0 whitespace-nowrap px-4 py-2 rounded-full text-[13px] font-bold transition
                        {{ $active
                            ? 'bg-[var(--amber)] text-[#102b3a] shadow'
                            : 'bg-[#F1F5F9] text-[#0B2D42] hover:bg-[#E2E8F0]' }}">
                {{ $label }}
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </section>

    <!-- ===== List (Cards) ===== -->
    <section id="list" class="max-w-7xl mx-auto px-4 sm:px-6 mt-6 pb-24 md:pb-10 relative z-[1]">
      @if($orders->isEmpty())
        <div class="text-center py-12">
          <img src="{{ asset('images/empty-orders.svg') }}" alt="Empty" class="mx-auto mb-4 w-28 opacity-90">
          <p class="font-semibold text-[var(--ink)]">Belum ada riwayat pesanan</p>
          <p class="text-sm text-gray-600">Yuk, buat pesanan pertama kamu 🚀</p>
          <a href="{{ route('user.orders.create') }}"
             class="mt-4 inline-flex items-center justify-center px-4 py-2 rounded-lg font-extrabold
                    bg-gradient-to-r from-[var(--amber)] to-[var(--amber-2)] text-[#102b3a]">
            ➕ Buat Pesanan
          </a>
        </div>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
          @foreach($orders as $order)
            @php
              $status = $order->status;
              $pill = match($status){
                'pending'  => 'pill pill--pending',
                'diproses' => 'pill pill--diproses',
                'selesai'  => 'pill pill--selesai',
                'diantar'  => 'pill pill--diantar',
                default    => 'pill pill--default'
              };
              $pay = $order->payment_status ?? 'belum_bayar';
              $payChip = $pay === 'sudah_bayar' ? 'chip chip-pay-ok' : 'chip chip-pay-warn';
              $payText = $pay === 'sudah_bayar' ? 'Sudah_bayar' : 'Belum_bayar';
              $method = $order->payment_method ? ucfirst($order->payment_method) : '-';
              $qty = rtrim(rtrim(number_format($order->quantity, 2, ',', '.'), '0'), ',');
              $serviceName = optional($order->service)->name ?? 'Layanan';
            @endphp

            <article class="order-card p-4 sm:p-5">
              <span class="absolute top-4 right-4 {{ $pill }} px-3 py-1 text-[11px] md:text-xs">{{ ucfirst($status) }}</span>

              <div class="flex items-start gap-3">
                <div class="icon-box">🧺</div>
                <div class="flex-1">
                  <h3 class="font-bold text-[var(--ink)] text-[15px] sm:text-base">{{ $serviceName }}</h3>
                  <p class="text-[12px] text-gray-500">#{{ $order->id }} • {{ $order->created_at->format('d M Y') }}</p>
                </div>
              </div>

              <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[13px] text-gray-700">
                <p><span class="font-medium">Jumlah:</span> {{ $qty }}</p>
                @if(!empty($order->address))
                  <p class="truncate"><i class="fa-solid fa-location-dot mr-1"></i>{{ $order->address }}</p>
                @endif
              </div>

              @if($order->pickup_date || $order->delivery_date)
                <ul class="tl text-[12px] text-gray-600">
                  @if($order->pickup_date)
                    <li><i class="fa-solid fa-box-open mr-1"></i>Jemput: {{ optional($order->pickup_date)->format('d M Y H:i') }}</li>
                  @endif
                  @if($order->delivery_date)
                    <li><i class="fa-solid fa-truck mr-1"></i>Antar: {{ optional($order->delivery_date)->format('d M Y H:i') }}</li>
                  @endif
                </ul>
              @endif

              <div class="mt-3 flex flex-wrap items-center gap-2">
                <span class="{{ $payChip }}"><i class="fa-solid fa-receipt"></i> {{ $payText }}</span>
                <span class="chip chip-method"><i class="fa-solid fa-credit-card"></i> {{ $method }}</span>
              </div>

              <div class="mt-3 text-[var(--amber)] font-extrabold text-[17px]">
                Rp{{ number_format($order->total_price, 0, ',', '.') }}
              </div>
            </article>
          @endforeach
        </div>

        {{-- Pagination di-nonaktifkan sesuai permintaan --}}
        {{-- @if($hasPagination)
          <div class="mt-4">{{ $orders->onEachSide(1)->fragment('list')->links() }}</div>
        @endif --}}
      @endif
    </section>

    <!-- ===== Bottom Nav ===== -->
    <nav class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur border-t shadow-lg safe-bottom z-50">
      <ul class="grid grid-cols-5 text-[11px] text-[var(--ink)]">
        <li>
          <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center py-2.5 gap-1 font-semibold">
            <i class="fa-solid fa-house text-base"></i><span>Home</span>
          </a>
        </li>
        <li>
          <a href="{{ route('user.orders.create') }}" class="flex flex-col items-center py-2.5 gap-1 font-semibold">
            <i class="fa-solid fa-plus text-base"></i><span>Pesan</span>
          </a>
        </li>
        <li>
          <a href="{{ route('user.notifications.index') }}" class="relative flex flex-col items-center py-2.5 gap-1 font-semibold">
            <i class="fa-solid fa-bell text-base"></i><span>Notif</span>
            @if(($unreadCount ?? 0) > 0)
              <span class="absolute -top-0.5 right-[22%] bg-red-500 text-white text-[10px] leading-4 px-1.5 rounded-full">{{ $unreadCount }}</span>
            @endif
          </a>
        </li>
        <li>
          <a href="{{ route('user.orders.history') }}" class="flex flex-col items-center py-2.5 gap-1 font-semibold text-[var(--amber)]">
            <i class="fa-solid fa-clock-rotate-left text-base"></i><span>Riwayat</span>
          </a>
        </li>
        <li>
          <a href="{{ route('profile.edit') }}" class="flex flex-col items-center py-2.5 gap-1 font-semibold">
            <i class="fa-solid fa-user text-base"></i><span>Profil</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>

  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
</x-app-layout>
