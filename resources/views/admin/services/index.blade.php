{{-- resources/views/admin/services/index.blade.php --}}
<x-app-layout>
  @php
    $total   = $services->count();
    $active  = $services->where('is_active', true)->count();
    $inactive= $total - $active;
    $avg     = (int) round($services->avg('price') ?? 0);
    $rupiah  = fn($n) => 'Rp '.number_format((int)$n,0,',','.');
  @endphp

  <div
    x-data="{
      view: (new URLSearchParams(location.search)).get('view') === 'list' ? 'list' : 'grid',
      status:'all',               // all | active | inactive
      sort:'newest',              // newest | price_asc | price_desc
      applyFilters(){
        // filter status (grid + list)
        document.querySelectorAll('[data-service]').forEach(el=>{
          const act = el.dataset.active === '1';
          el.style.display =
            this.status==='all' || (this.status==='active'&&act) || (this.status==='inactive'&&!act) ? '' : 'none';
        });

        // sort grid
        const wrap = document.getElementById('gridWrap');
        if(!wrap) return;
        const cards = Array.from(wrap.children);
        const get = (el,k)=>+el.querySelector('[data-meta]')?.dataset[k] || 0;
        let sorted = cards;
        if(this.sort==='newest')      sorted = cards.sort((a,b)=>get(b,'created')-get(a,'created'));
        if(this.sort==='price_asc')   sorted = cards.sort((a,b)=>get(a,'price')-get(b,'price'));
        if(this.sort==='price_desc')  sorted = cards.sort((a,b)=>get(b,'price')-get(a,'price'));
        sorted.forEach(el=>wrap.appendChild(el));
      }
    }"
    x-init="$nextTick(()=>applyFilters())"
    class="min-h-screen"
  >
    {{-- ===== HERO + KPI ===== --}}
    <section class="relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-sky-50 via-amber-50 to-white"></div>
      <div class="relative max-w-7xl mx-auto px-6 pt-8 pb-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
          <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800">Kelola Layanan</h1>
            <p class="mt-1 text-slate-600">Tambah, ubah, hapus, dan atur layanan yang tampil untuk pelanggan.</p>
          </div>

          {{-- Search + CTA (desktop) --}}
          <div class="flex items-center gap-2">
            <form action="{{ route('admin.services.index') }}" method="GET" class="hidden md:flex items-center gap-2">
              <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input name="q" value="{{ $q ?? '' }}" placeholder="Cari layanan…"
                       class="pl-9 pr-3 py-2 rounded-xl bg-white/80 border border-slate-200 text-sm focus:outline-none focus:ring-4 focus:ring-amber-200">
              </div>
              <button class="px-3 py-2 rounded-xl bg-amber-500 text-slate-900 font-bold text-sm hover:bg-amber-400">
                Cari
              </button>
            </form>

            <a href="{{ route('admin.services.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-sky-600 text-white font-bold px-4 py-2 hover:bg-sky-700 shadow">
              <i class="fa-solid fa-plus"></i> Tambah Layanan
            </a>
          </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mt-6">
          <div class="rounded-xl bg-white/80 border border-slate-200 p-4 shadow-sm">
            <div class="text-xs uppercase tracking-wide text-slate-500">Total</div>
            <div class="text-2xl font-extrabold text-slate-800">{{ $total }}</div>
          </div>
          <div class="rounded-xl bg-white/80 border border-slate-200 p-4 shadow-sm">
            <div class="text-xs uppercase tracking-wide text-slate-500">Aktif</div>
            <div class="text-2xl font-extrabold text-emerald-600">{{ $active }}</div>
          </div>
          <div class="rounded-xl bg-white/80 border border-slate-200 p-4 shadow-sm">
            <div class="text-xs uppercase tracking-wide text-slate-500">Nonaktif</div>
            <div class="text-2xl font-extrabold text-rose-600">{{ $inactive }}</div>
          </div>
          <div class="rounded-xl bg-white/80 border border-slate-200 p-4 shadow-sm">
            <div class="text-xs uppercase tracking-wide text-slate-500">Rata-rata Harga</div>
            <div class="text-2xl font-extrabold text-amber-600">{{ $rupiah($avg) }}</div>
          </div>
        </div>
      </div>
    </section>

    {{-- ===== TOOLBAR ===== --}}
    <div class="max-w-7xl mx-auto px-6 mt-4">
      {{-- Search (mobile) --}}
      <form action="{{ route('admin.services.index') }}" method="GET" class="md:hidden mb-3">
        <div class="flex items-center gap-2">
          <div class="relative flex-1">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input name="q" value="{{ $q ?? '' }}" placeholder="Cari layanan…"
                   class="w-full pl-9 pr-3 py-2 rounded-xl bg-white border border-slate-200 text-sm focus:outline-none focus:ring-4 focus:ring-amber-200">
          </div>
          <button class="px-3 py-2 rounded-xl bg-amber-500 text-slate-900 font-bold text-sm">Cari</button>
        </div>
      </form>

      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        {{-- segmented status --}}
        <div class="inline-flex bg-white border border-slate-200 rounded-xl p-1 shadow-sm w-full md:w-auto">
          <button type="button" @click="status='all';applyFilters()"
                  :class="status==='all' ? 'px-3 py-1.5 rounded-lg text-sm font-semibold bg-slate-900 text-white shadow' :
                                            'px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-600 hover:text-slate-900'">
            Semua
          </button>
          <button type="button" @click="status='active';applyFilters()"
                  :class="status==='active' ? 'px-3 py-1.5 rounded-lg text-sm font-semibold bg-slate-900 text-white shadow' :
                                              'px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-600 hover:text-slate-900'">
            Aktif
          </button>
          <button type="button" @click="status='inactive';applyFilters()"
                  :class="status==='inactive' ? 'px-3 py-1.5 rounded-lg text-sm font-semibold bg-slate-900 text-white shadow' :
                                               'px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-600 hover:text-slate-900'">
            Nonaktif
          </button>
        </div>

        <div class="flex items-center gap-2">
          {{-- view switch --}}
          <div class="hidden md:flex bg-white border border-slate-200 rounded-xl p-1 shadow-sm">
            <button type="button" @click="view='grid'"
                    :class="view==='grid' ? 'px-3 py-2 rounded-lg bg-slate-900 text-white shadow' :
                                            'px-3 py-2 rounded-lg text-slate-600 hover:text-slate-900'">
              <i class="fa-solid fa-border-all"></i>
            </button>
            <button type="button" @click="view='list'"
                    :class="view==='list' ? 'px-3 py-2 rounded-lg bg-slate-900 text-white shadow' :
                                            'px-3 py-2 rounded-lg text-slate-600 hover:text-slate-900'">
              <i class="fa-solid fa-list"></i>
            </button>
          </div>

          {{-- sort --}}
          <div class="relative">
            <select x-model="sort" @change="applyFilters()"
                    class="appearance-none pl-3 pr-9 py-2 rounded-xl bg-white border border-slate-200 text-sm shadow-sm focus:outline-none">
              <option value="newest">Terbaru</option>
              <option value="price_asc">Harga termurah</option>
              <option value="price_desc">Harga termahal</option>
            </select>
            <i class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
          </div>
        </div>
      </div>

      {{-- flash --}}
      @if(session('success'))
        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-emerald-700 shadow-sm">
          {{ session('success') }}
        </div>
      @endif
    </div>

    {{-- ===== GRID VIEW ===== --}}
    <section class="max-w-7xl mx-auto px-6 mt-5" x-show="view==='grid'">
      <div id="gridWrap" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($services as $s)
          <article data-service data-active="{{ $s->is_active ? '1':'0' }}"
                   class="group rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            {{-- image --}}
            <div class="relative aspect-[16/10] bg-slate-100">
              <img src="{{ $s->image_url }}" alt="{{ $s->name }}" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 md:group-hover:opacity-100 transition"></div>

              {{-- badges --}}
              @if($loop->first)
                <span class="absolute left-3 top-3 inline-flex items-center px-2 py-1 rounded text-[11px] font-extrabold bg-amber-500 text-amber-950 shadow">NEWEST</span>
              @elseif($s->created_at && $s->created_at->gt(now()->subDays(7)))
                <span class="absolute left-3 top-3 inline-flex items-center px-2 py-1 rounded text-[11px] font-extrabold bg-amber-400 text-amber-900 shadow">New Service</span>
              @endif
              @if(!$s->is_active)
                <span class="absolute right-3 top-3 inline-flex items-center px-2 py-1 rounded text-[11px] font-extrabold bg-slate-900 text-white shadow">Nonaktif</span>
              @endif

              {{-- hover actions (desktop) --}}
              <div class="hidden md:block absolute inset-x-3 bottom-3 opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition">
                <div class="grid grid-cols-3 gap-2">
                  <a href="{{ route('admin.services.edit', $s) }}"
                     class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-white/95 text-slate-800 border border-slate-200 shadow hover:bg-white">
                    <i class="fa-solid fa-pen"></i> Edit
                  </a>
                  <form action="{{ route('admin.services.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                    @csrf @method('DELETE')
                    <button class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-white/95 text-rose-600 border border-slate-200 shadow hover:bg-white">
                      <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                  </form>
                  @if(Route::has('admin.services.toggle'))
                    <form action="{{ route('admin.services.toggle', $s) }}" method="POST">
                      @csrf @method('PATCH')
                      <button class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-white/95 text-slate-700 border border-slate-200 shadow hover:bg-white">
                        <i class="fa-solid fa-power-off"></i> {{ $s->is_active ? 'Nonaktif' : 'Aktifkan' }}
                      </button>
                    </form>
                  @endif
                </div>
              </div>
            </div>

            {{-- body --}}
            <div class="p-4">
              <div class="flex items-start justify-between gap-3">
                <h3 class="font-extrabold text-slate-800 leading-tight">{{ $s->name }}</h3>
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 text-sm font-extrabold">
                  {{ $rupiah($s->price) }}{{ $s->unit ? '/'.$s->unit : '' }}
                </span>
              </div>
              @if(!empty($s->description))
                <p class="mt-1 text-sm text-slate-600 truncate">{{ $s->description }}</p>
              @endif

              {{-- meta for sort --}}
              <div data-meta class="hidden" data-price="{{ (int)$s->price }}" data-created="{{ optional($s->created_at)->timestamp ?? 0 }}"></div>

              {{-- mobile actions --}}
              <div class="mt-3 grid grid-cols-3 gap-2 md:hidden">
                <a href="{{ route('admin.services.edit', $s) }}"
                   class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-700">
                  <i class="fa-solid fa-pen"></i> Edit
                </a>
                <form action="{{ route('admin.services.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                  @csrf @method('DELETE')
                  <button class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg border border-slate-200 bg-white text-rose-600 w-full">
                    <i class="fa-solid fa-trash"></i> Hapus
                  </button>
                </form>
                @if(Route::has('admin.services.toggle'))
                  <form action="{{ route('admin.services.toggle', $s) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-700 w-full">
                      <i class="fa-solid fa-power-off"></i> {{ $s->is_active ? 'Nonaktif' : 'Aktifkan' }}
                    </button>
                  </form>
                @endif
              </div>
            </div>
          </article>
        @empty
          <div class="col-span-full">
            <div class="grid place-items-center text-center p-8 rounded-2xl border border-slate-200 bg-white">
              <img src="{{ asset('images/empty-orders.svg') }}" class="w-28 opacity-90" alt="">
              <p class="mt-2 font-semibold text-slate-700">Belum ada layanan</p>
              <p class="text-sm text-slate-500">Tambahkan layanan baru untuk mulai menjual.</p>
              <a href="{{ route('admin.services.create') }}"
                 class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-600 text-white font-bold shadow hover:bg-sky-700">
                + Tambah Layanan
              </a>
            </div>
          </div>
        @endforelse
      </div>

      <p class="text-sm text-slate-400 mt-6">
        Menampilkan {{ $services->count() }} hasil
        @if(!empty($q)) untuk pencarian <span class="font-semibold text-slate-600">“{{ $q }}”</span>@endif
      </p>
    </section>

    {{-- ===== LIST VIEW ===== --}}
    <section class="max-w-7xl mx-auto px-6 mt-5" x-show="view==='list'">
      <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm">
        <table class="w-full text-left">
          <thead class="bg-slate-50 text-slate-700">
            <tr>
              <th class="px-5 py-3">Layanan</th>
              <th class="px-5 py-3">Harga</th>
              <th class="px-5 py-3">Status</th>
              <th class="px-5 py-3">Dibuat</th>
              <th class="px-5 py-3 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @foreach($services as $s)
              <tr data-service data-active="{{ $s->is_active ? '1':'0' }}">
                <td class="px-5 py-3">
                  <div class="flex items-center gap-3">
                    <img src="{{ $s->image_url }}" class="w-14 h-14 rounded-lg object-cover border border-slate-200" alt="">
                    <div>
                      <div class="font-semibold text-slate-800">{{ $s->name }}</div>
                      <div class="text-xs text-slate-500 truncate max-w-[36ch]">{{ $s->description }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-3 font-extrabold text-amber-600">
                  {{ $rupiah($s->price) }}{{ $s->unit ? '/'.$s->unit : '' }}
                </td>
                <td class="px-5 py-3">
                  @if($s->is_active)
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                  @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">Nonaktif</span>
                  @endif
                </td>
                <td class="px-5 py-3 text-slate-600">{{ optional($s->created_at)->format('d M Y') }}</td>
                <td class="px-5 py-3">
                  <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.services.edit', $s) }}"
                       class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-slate-50">
                      <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form action="{{ route('admin.services.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                      @csrf @method('DELETE')
                      <button class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 bg-white text-rose-600 hover:bg-slate-50">
                        <i class="fa-solid fa-trash"></i> Hapus
                      </button>
                    </form>
                    @if(Route::has('admin.services.toggle'))
                      <form action="{{ route('admin.services.toggle', $s) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-slate-50">
                          <i class="fa-solid fa-power-off"></i> {{ $s->is_active ? 'Nonaktif' : 'Aktifkan' }}
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <p class="text-sm text-slate-400 mt-4">
        Menampilkan {{ $services->count() }} hasil
        @if(!empty($q)) untuk pencarian <span class="font-semibold text-slate-600">“{{ $q }}”</span>@endif
      </p>
    </section>
  </div>

  {{-- Font Awesome + Alpine (jaga-jaga bila belum ada di layout) --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-app-layout>
