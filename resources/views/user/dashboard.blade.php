<x-app-layout>
  {{-- ===== Mobile-first CSS (light, no-JS) ===== --}}
  <style>
    :root{ --ink:#013C58; --sky:#A8E8F9; --amber:#F5A201; --amber-2:#FFBA42 }
    .dash-bg{position:relative;overflow:hidden}
    .dash-bg::before{
      content:""; position:absolute; inset:-50% -20% auto -20%; height:58%;
      background:
        radial-gradient(520px 240px at 15% 18%, rgba(168,232,249,.25), transparent 60%),
        radial-gradient(480px 220px at 85% 8%, rgba(255,211,91,.18), transparent 60%);
      pointer-events:none; z-index:0;
    }
    /* glow edge (subtle on mobile) */
    .glow-card{position:relative;overflow:hidden;border-radius:1rem}
    .glow-card::before{
      content:""; position:absolute; inset:-1px; border-radius:1.05rem; z-index:-1;
      background:conic-gradient(from 180deg, #FFD35B, #A8E8F9, #F5A201, #FFD35B);
      filter:blur(10px); opacity:.35;
    }
    /* progress bar */
    .bar{height:10px;border-radius:999px;background:#EEF2F7;overflow:hidden}
    .bar>span{display:block;height:100%;background:linear-gradient(90deg, var(--amber), var(--amber-2))}
    /* pills */
    .pill{display:inline-block;padding:.28rem .6rem;border-radius:999px;font-weight:800;font-size:.78rem}
    .pill--pending{background:#FEF3C7;color:#B45309}
    .pill--diproses{background:#DBEAFE;color:#1D4ED8}
    .pill--selesai{background:#DCFCE7;color:#16A34A}
    .pill--diantar{background:#EDE9FE;color:#6D28D9}
    .pill--default{background:#F3F4F6;color:#374151}
    /* table wrapper */
    .wrap{overflow:auto;border:1px solid #e5e7eb;border-radius:1rem;background:#fff}
    .thead{position:sticky;top:0;background:linear-gradient(90deg,#E6F7FD,#FDF6E6);color:var(--ink);z-index:5}
    /* iOS safe-area for bottom nav */
    .safe-bottom{padding-bottom: max(env(safe-area-inset-bottom), 0.5rem)}
    /* reduce motion preference */
    @media (prefers-reduced-motion: reduce){
      *{animation-duration:.01ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important}
    }
  </style>

  @php
    $t = $totalOrders ?? 0;
    $c = $completedOrders ?? 0;
    $proc = $processingOrders ?? 0;
    $pend = $pendingOrders ?? 0;
    $rate = $t ? round($c*100/$t) : 0;
    $unreadCount = $unreadNotificationsCount ?? 0;
  @endphp

  <div class="min-h-screen bg-white dash-bg font-sans relative pb-20 md:pb-0">
    <!-- ===== Greeting (mobile-first) ===== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 pt-6 relative z-[1]">
      <div class="glow-card bg-[var(--ink)] text-white rounded-xl p-5 sm:p-6 shadow-xl">
        <div class="flex items-start justify-between gap-4">
          <div>
            <h1 class="text-[clamp(1.25rem,3.5vw,1.75rem)] font-extrabold leading-snug">
              Halo, {{ Auth::user()->name }} 👋
            </h1>
            <p class="mt-1 text-[13px] sm:text-sm text-[#A8E8F9]">
              Selamat datang di <span class="text-[#FFBA42] font-semibold">Qinclong Laundry</span>.<br class="sm:hidden">
              <span class="text-white/80">Kelola pesananmu di sini.</span>
            </p>
          </div>
          <div class="shrink-0 hidden sm:block text-6xl opacity-10">
            <i class="fa-solid fa-shirt"></i>
          </div>
        </div>

        <!-- quick stats (compact for mobile) -->
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

    <!-- ===== Quick Actions (big buttons) ===== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 relative z-[1]">
      <a href="{{ route('user.orders.create') }}"
         class="w-full rounded-xl py-4 sm:py-5 text-base sm:text-lg font-extrabold
                bg-gradient-to-r from-[var(--amber)] to-[var(--amber-2)] text-[#102b3a]
                shadow-[0_10px_24px_rgba(0,0,0,.12)] active:translate-y-[1px] text-center">
        🚀 Buat Pesanan Baru
      </a>
      <a href="{{ route('user.orders.history') }}"
         class="w-full rounded-xl py-4 sm:py-5 text-base sm:text-lg font-extrabold
                bg-gradient-to-r from-[#DFF6FF] to-[var(--sky)] text-[var(--ink)]
                shadow-[0_10px_24px_rgba(0,0,0,.12)] active:translate-y-[1px] text-center hover:bg-[var(--ink)] hover:text-white">
        📜 Lihat Riwayat
      </a>
    </section>

    <!-- ===== Success flash ===== -->
    @if(session('success'))
      <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow">
          <div class="flex items-center gap-2 text-sm">
            <i class="fa-solid fa-circle-check text-green-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
          </div>
        </div>
      </div>
    @endif

    <!-- ===== Notifications (mobile compact) ===== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-6 relative z-[1]">
      <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="px-4 py-3 sm:px-6 sm:py-4 bg-gradient-to-r from-[#E6F7FD] to-[#FFF7E6] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-[var(--ink)] text-white grid place-items-center">
              <i class="fa-solid fa-bell text-sm"></i>
            </div>
            <div>
              <h2 class="text-[15px] sm:text-lg font-extrabold text-[var(--ink)]">Notifikasi</h2>
              <p class="text-xs sm:text-sm text-[var(--ink)]/70">Status pesanan & pembayaran terbaru.</p>
            </div>
          </div>
          <div class="flex items-center gap-2">
            @if($unreadCount > 0)
              <span class="px-2 py-1 text-[10px] sm:text-xs font-bold rounded-full bg-red-100 text-red-700">{{ $unreadCount }} belum dibaca</span>
            @else
              <span class="px-2 py-1 text-[10px] sm:text-xs font-bold rounded-full bg-gray-100 text-gray-600">Tidak ada yang baru</span>
            @endif

            <form action="{{ route('user.notifications.markAllRead') }}" method="POST" class="hidden sm:block">
              @csrf
              <button class="px-3 py-1.5 text-xs font-semibold rounded-md bg-[var(--ink)] text-white hover:bg-[#00537A] transition">
                Tandai dibaca
              </button>
            </form>

            <form action="{{ route('user.notifications.clear') }}" method="POST" onsubmit="return confirm('Bersihkan semua notifikasi?')" class="hidden sm:block">
              @csrf @method('DELETE')
              <button class="px-3 py-1.5 text-xs font-semibold rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                Bersihkan
              </button>
            </form>
          </div>
        </div>

        @php
          $notifList = collect($notifications ?? (Auth::user()->notifications()->latest()->take(5)->get()));
        @endphp

        @if($notifList->isEmpty())
          <div class="px-4 py-8 text-center text-gray-500">
            <i class="fa-solid fa-bell-slash text-2xl mb-1.5"></i>
            <p class="font-semibold text-sm">Belum ada notifikasi</p>
          </div>
        @else
          <ul class="divide-y divide-gray-100">
            @foreach($notifList as $n)
              @php
                $isUnread = is_null($n->read_at);
                $data = $n->data ?? [];
                $message = $data['message'] ?? 'Ada pembaruan pada pesanan kamu.';
                $orderId = $data['order_id'] ?? null;
                $ts = optional($n->created_at)->diffForHumans();
                $status = $data['status'] ?? null;
                $method = $data['payment_method'] ?? null;
                $iconClass = 'fa-solid fa-bell';
                if ($status) {
                  $iconClass = match($status){
                    'sudah_bayar' => 'fa-solid fa-circle-check',
                    'belum_bayar' => 'fa-solid fa-wallet',
                    'selesai'     => 'fa-solid fa-clipboard-check',
                    'diproses'    => 'fa-solid fa-rotate',
                    'diantar'     => 'fa-solid fa-truck-fast',
                    default       => 'fa-solid fa-bell'
                  };
                }
              @endphp
              <li class="px-4 sm:px-6 py-3 flex items-start gap-3 {{ $isUnread ? 'bg-yellow-50/40' : '' }}">
                <div class="w-8 h-8 rounded-full grid place-items-center {{ $isUnread ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600' }}">
                  <i class="{{ $iconClass }} text-[13px]"></i>
                </div>
                <div class="flex-1">
                  <p class="text-[13px] sm:text-sm text-gray-800 leading-snug">{!! nl2br(e($message)) !!}</p>
                  <div class="mt-1 text-[11px] sm:text-xs text-gray-500 flex flex-wrap items-center gap-2">
                    @if($orderId)
                      <span class="px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 font-mono">#{{ $orderId }}</span>
                    @endif
                    @if($status)
                      <span>Status: <b>{{ ucfirst($status) }}</b></span>
                    @endif
                    @if($method)
                      <span>Metode: <b>{{ ucfirst($method) }}</b></span>
                    @endif
                    <span class="text-gray-400">• {{ $ts }}</span>
                  </div>
                </div>
                @if($isUnread)
                  <span class="w-2 h-2 mt-1 rounded-full bg-yellow-500"></span>
                @endif
              </li>
            @endforeach
          </ul>
        @endif

        <!-- mobile: actions inline -->
        <div class="px-4 py-3 border-t bg-gray-50 sm:hidden">
          <form action="{{ route('user.notifications.markAllRead') }}" method="POST" class="inline">
            @csrf
            <button class="px-3 py-2 text-xs font-semibold rounded-md bg-[var(--ink)] text-white">Tandai dibaca</button>
          </form>
          <form action="{{ route('user.notifications.clear') }}" method="POST" onsubmit="return confirm('Bersihkan semua notifikasi?')" class="inline ml-2">
            @csrf @method('DELETE')
            <button class="px-3 py-2 text-xs font-semibold rounded-md bg-white border text-gray-700">Bersihkan</button>
          </form>
        </div>
      </div>
    </section>

    <!-- ===== Recent Orders (cards on mobile, table on md+) ===== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-8 pb-24 md:pb-10 relative z-[1]">
      <div class="flex items-baseline justify-between mb-2">
        <h2 class="text-xl sm:text-2xl font-extrabold text-[var(--ink)]">Riwayat Terbaru</h2>
        <a href="{{ route('user.orders.history') }}" class="text-xs sm:text-sm font-bold text-[var(--ink)]/70 hover:text-[var(--ink)]">Lihat semua →</a>
      </div>

      @if(!empty($recentOrders) && count($recentOrders) > 0)
        <!-- Mobile cards -->
        <div class="grid gap-3 md:hidden">
          @foreach($recentOrders as $order)
            @php
              $status = $order->status;
              $pill = match($status){
                'pending'  => 'pill pill--pending',
                'diproses' => 'pill pill--diproses',
                'selesai'  => 'pill pill--selesai',
                'diantar'  => 'pill pill--diantar',
                default    => 'pill pill--default'
              };
            @endphp
            <div class="bg-white rounded-xl border shadow-sm p-4">
              <div class="flex items-center justify-between">
                <div class="font-semibold text-[var(--ink)] text-[15px]">{{ $order->service->name }}</div>
                <span class="{{ $pill }}">{{ ucfirst($status) }}</span>
              </div>
              <div class="mt-2 text-[13px] text-gray-600">
                Jumlah: <b>{{ $order->quantity }}</b>
              </div>
              <div class="mt-1 text-[13px] text-gray-600">
                Tanggal: <b>{{ $order->created_at->format('d M Y') }}</b>
              </div>
              <div class="mt-2 text-[15px] font-extrabold text-[var(--amber)]">
                Rp{{ number_format($order->total_price, 0, ',', '.') }}
              </div>
            </div>
          @endforeach
        </div>

        <!-- Desktop table -->
        <div class="wrap hidden md:block mt-3">
          <table class="w-full text-left min-w-[780px]">
            <thead class="thead">
              <tr>
                <th class="px-6 py-3">Layanan</th>
                <th class="px-6 py-3">Jumlah</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentOrders as $order)
                @php
                  $status = $order->status;
                  $pill = match($status){
                    'pending'  => 'pill pill--pending',
                    'diproses' => 'pill pill--diproses',
                    'selesai'  => 'pill pill--selesai',
                    'diantar'  => 'pill pill--diantar',
                    default    => 'pill pill--default'
                  };
                @endphp
                <tr class="border-t hover:bg-[#FFF7E6]">
                  <td class="px-6 py-3 font-semibold text-[var(--ink)]">{{ $order->service->name }}</td>
                  <td class="px-6 py-3">{{ $order->quantity }}</td>
                  <td class="px-6 py-3 text-[var(--amber)] font-extrabold">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                  <td class="px-6 py-3"><span class="{{ $pill }}">{{ ucfirst($status) }}</span></td>
                  <td class="px-6 py-3">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="text-center py-10 text-gray-500">
          <img src="{{ asset('images/empty-orders.svg') }}" alt="Empty" class="mx-auto mb-3 w-28 opacity-90">
          <p class="text-[15px] font-semibold">Belum ada pesanan</p>
          <p class="text-xs">Yuk, coba buat pesanan pertama kamu 🚀</p>
        </div>
      @endif
    </section>

    <!-- ===== Bottom Nav (mobile only) ===== -->
    <nav class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur border-t shadow-lg safe-bottom z-50">
      <ul class="grid grid-cols-5 text-[11px] text-[var(--ink)]">
        <li>
          <a href="{{ route('user.dashboard') }}"
             class="flex flex-col items-center py-2.5 gap-1 font-semibold @if(request()->routeIs('dashboard')) text-[var(--amber)] @endif">
            <i class="fa-solid fa-house text-base"></i><span>Home</span>
          </a>
        </li>
        <li>
          <a href="{{ route('user.orders.create') }}"
             class="flex flex-col items-center py-2.5 gap-1 font-semibold">
            <i class="fa-solid fa-plus text-base"></i><span>Pesan</span>
          </a>
        </li>
        <li>
          <a href="{{ route('user.notifications.index') }}"
             class="relative flex flex-col items-center py-2.5 gap-1 font-semibold">
            <i class="fa-solid fa-bell text-base"></i><span>Notif</span>
            @if(($unreadCount ?? 0) > 0)
              <span class="absolute -top-0.5 right-[22%] bg-red-500 text-white text-[10px] leading-4 px-1.5 rounded-full">{{ $unreadCount }}</span>
            @endif
          </a>
        </li>
        <li>
          <a href="{{ route('user.orders.history') }}"
             class="flex flex-col items-center py-2.5 gap-1 font-semibold">
            <i class="fa-solid fa-clock-rotate-left text-base"></i><span>Riwayat</span>
          </a>
        </li>
        <li>
          <a href="{{ route('profile.edit') }}"
             class="flex flex-col items-center py-2.5 gap-1 font-semibold">
            <i class="fa-solid fa-user text-base"></i><span>Profil</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>

  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
</x-app-layout>
