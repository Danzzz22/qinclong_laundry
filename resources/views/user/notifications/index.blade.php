<x-app-layout>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 py-6">
    @if(session('success'))
      <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-[#013C58] text-white grid place-items-center">
          <i class="fa-solid fa-bell"></i>
        </div>
        <div>
          <h1 class="text-xl sm:text-2xl font-extrabold text-[#013C58]">Notifikasi</h1>
          <div class="text-sm text-gray-500">
            @if(($unreadCount ?? 0) > 0)
              <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-700 font-semibold">{{ $unreadCount }} belum dibaca</span>
            @else
              Tidak ada yang baru
            @endif
          </div>
        </div>
      </div>

      <div class="flex items-center gap-2">
        <form method="POST" action="{{ route('user.notifications.markAllRead') }}">
          @csrf
          <button class="px-3 py-2 rounded bg-[#013C58] text-white text-sm font-semibold hover:bg-[#00537A]">
            Tandai semua dibaca
          </button>
        </form>
        <form method="POST" action="{{ route('user.notifications.clear') }}"
              onsubmit="return confirm('Bersihkan semua notifikasi?')">
          @csrf @method('DELETE')
          <button class="px-3 py-2 rounded bg-gray-100 text-sm font-semibold hover:bg-gray-200">
            Bersihkan
          </button>
        </form>
      </div>
    </div>

    @if($notifications->isEmpty())
      <div class="text-center py-16 text-gray-500">
        <i class="fa-solid fa-bell-slash text-3xl mb-2"></i>
        <p class="font-semibold">Belum ada notifikasi</p>
      </div>
    @else
      <div class="bg-white border rounded overflow-hidden">
        <ul class="divide-y divide-gray-100">
          @foreach($notifications as $n)
            @php
              $data    = $n->data ?? [];
              $msg     = $data['message'] ?? 'Ada pembaruan pada pesanan/layanan.';
              $type    = $data['type'] ?? null;
              $status  = $data['status'] ?? null;
              $method  = $data['payment_method'] ?? null;
              $isUnread = is_null($n->read_at);

              $icon = 'fa-bell';
              if ($type === 'service_created') $icon = 'fa-plus';
              elseif ($type === 'service_deleted') $icon = 'fa-trash';
              elseif ($type === 'service_price_changed') $icon = 'fa-tags';
              elseif ($type === 'service_toggled') $icon = 'fa-power-off';
              elseif ($status === 'selesai') $icon = 'fa-clipboard-check';
              elseif ($status === 'diproses') $icon = 'fa-rotate';
              elseif ($status === 'diantar') $icon = 'fa-truck-fast';
              elseif ($status === 'pending') $icon = 'fa-hourglass-half';
            @endphp

            <li class="px-4 sm:px-6 py-4 {{ $isUnread ? 'bg-yellow-50/40' : '' }}">
              <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-full grid place-items-center
                    {{ $isUnread ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600' }}">
                  <i class="fa-solid {{ $icon }}"></i>
                </div>

                <div class="flex-1 min-w-0">
                  <div class="text-sm text-gray-800 break-words">{!! nl2br(e($msg)) !!}</div>
                  <div class="mt-1 text-xs text-gray-500 flex flex-wrap items-center gap-2">
                    @if(isset($data['order_id']))
                      <span class="px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 font-mono">#{{ $data['order_id'] }}</span>
                    @endif
                    @if($status)
                      <span>Status: <b>{{ ucfirst($status) }}</b></span>
                    @endif
                    @if($method)
                      <span>Metode: <b>{{ ucfirst($method) }}</b></span>
                    @endif
                    <span class="text-gray-400">• {{ $n->created_at?->diffForHumans() }}</span>
                  </div>
                </div>

                <div class="shrink-0 flex items-center gap-1">
                  @if($isUnread)
                    <form method="POST" action="{{ route('user.notifications.markRead', $n->id) }}">
                      @csrf
                      <button class="px-2 py-1 text-xs rounded bg-blue-600 text-white" title="Tandai dibaca">
                        <i class="fa-solid fa-check"></i>
                      </button>
                    </form>
                  @endif

                  <form method="POST" action="{{ route('user.notifications.destroy', $n->id) }}"
                        onsubmit="return confirm('Hapus notifikasi ini?')">
                    @csrf @method('DELETE')
                    <button class="px-2 py-1 text-xs rounded bg-gray-100" title="Hapus">
                      <i class="fa-solid fa-trash text-gray-700"></i>
                    </button>
                  </form>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>

      <div class="mt-4">
        {{ $notifications->links() }}
      </div>
    @endif
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
</x-app-layout>
