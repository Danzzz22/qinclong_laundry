<x-app-layout>
  {{-- ===== Scoped styles untuk halaman Order Create ===== --}}
  <style>
    .order-page{--ink:#013C58; --sky:#A8E8F9; --amber:#F5A201; --amber2:#FFBA42}
    .order-page .bg-grad{
      background-image:linear-gradient(135deg, rgba(168,232,249,.35) 0%, #fff 40%, rgba(255,211,91,.22) 100%)
    }
    .order-page .pattern{
      background-image:radial-gradient(circle at 1px 1px, rgba(1,60,88,.11) 1px, transparent 0);
      background-size:40px 40px; opacity:.16; pointer-events:none;
    }

    /* Header */
    .order-page .glow-card{position:relative;border-radius:1.1rem;overflow:hidden}
    .order-page .glow-card::before{
      content:""; position:absolute; inset:-1px; border-radius:1.2rem; z-index:-1;
      background:conic-gradient(from 180deg, #FFD35B, #A8E8F9, #F5A201, #FFD35B);
      filter:blur(14px); opacity:.50;
    }
    .order-page .sheen{position:relative; overflow:hidden}
    .order-page .sheen::after{
      content:""; position:absolute; inset:-40% -60% auto; height:220%;
      background:linear-gradient(120deg, transparent 45%, rgba(255,255,255,.28) 50%, transparent 55%);
      transform:translateX(-120%); transition:transform .9s ease;
    }
    .order-page .sheen:hover::after{transform:translateX(120%)}

    /* Card + form fields */
    .order-page .card{border-radius:1.1rem; box-shadow:0 14px 36px rgba(1,60,88,.10)}
    .order-page .field{position:relative}
    .order-page .field .input{
      width:100%; border-radius:.9rem; border:1px solid #E5E7EB;
      padding:.75rem 1rem .75rem 2.7rem; background:#fff;
      transition: box-shadow .18s ease, border-color .18s ease;
    }
    .order-page .field .input:focus{outline:none; border-color:var(--amber); box-shadow:0 0 0 4px rgba(245,162,1,.18)}
    .order-page .field .icon{position:absolute; left:.9rem; top:50%; transform:translateY(-50%); color:#94a3b8}
    .order-page .field textarea.input{min-height:110px; padding-top:.9rem}
    .order-page select.input{
      appearance:none;
      background-image:url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 24 24' fill='%23013C58' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5'/%3E%3C/svg%3E");
      background-repeat:no-repeat; background-position:right .9rem center; background-size:18px
    }
    .order-page .unit-badge{
      position:absolute; right:.6rem; top:50%; transform:translateY(-50%);
      background:#F1F5F9; color:#0B2D42; border:1px solid #E2E8F0; font-weight:800;
      font-size:.75rem; padding:.22rem .5rem; border-radius:999px;
    }

    .order-page .chip-mini{
      display:inline-flex;align-items:center;gap:.35rem;padding:.35rem .6rem;border-radius:.7rem;
      background:#F7FAFC;border:1px solid #E2E8F0;color:#0B2D42;font-weight:700;font-size:.78rem;
      transition:background .15s ease, transform .15s ease;
    }
    .order-page .chip-mini:hover{ background:#EFF6FF; transform:translateY(-1px) }

    .order-page .summary{border-radius:1rem; border:1px solid rgba(168,232,249,.7); background:rgba(168,232,249,.18)}
    .order-page .divider{border-color:#e5e7eb}

    .order-page .btn-primary{
      background-image:linear-gradient(90deg, var(--amber), var(--amber2));
      color:#102b3a; font-weight:800; border-radius:.9rem; padding:.9rem 1rem;
      box-shadow:0 14px 30px rgba(245,162,1,.25);
      transition:transform .18s ease, box-shadow .18s ease;
    }
    .order-page .btn-primary:hover{transform:translateY(-2px); box-shadow:0 20px 40px rgba(245,162,1,.32)}

    .order-page .alert{border-radius:.9rem}
    .order-page .muted{color:#64748b}

    /* Popular services */
    .order-page .pop-card{
      border:1px solid #e5e7eb; border-radius:1rem; background:#fff;
      padding:1rem; box-shadow:0 10px 28px rgba(1,60,88,.08);
      transition:transform .15s ease, box-shadow .15s ease
    }
    .order-page .pop-card:hover{ transform:translateY(-3px); box-shadow:0 18px 40px rgba(1,60,88,.12) }
    .order-page .pop-badge{
      display:inline-flex; align-items:center; gap:.4rem;
      background:rgba(245,162,1,.12); color:#8a5a00; border:1px dashed rgba(245,162,1,.5);
      padding:.25rem .6rem; border-radius:.6rem; font-size:.8rem; font-weight:700;
    }
    .order-page .quick-btn{
      display:inline-flex; align-items:center; gap:.5rem;
      background-image:linear-gradient(90deg, var(--amber), var(--amber2));
      color:#0f2a3a; font-weight:800; border-radius:.7rem; padding:.55rem .9rem;
      box-shadow:0 12px 26px rgba(245,162,1,.25);
      transition:transform .15s ease, box-shadow .15s ease;
    }
    .order-page .quick-btn:hover{ transform:translateY(-2px); box-shadow:0 18px 36px rgba(245,162,1,.3) }

    /* HOW IT WORKS (pindah ke paling atas kartu) */
    .order-page .how{ border:1px solid rgba(168,232,249,.65); background:rgba(168,232,249,.16); border-radius:1rem; }
    .order-page .how-step{
      background:#fff; border:1px solid #e5e7eb; border-radius:.9rem; padding:1rem;
      box-shadow:0 10px 24px rgba(1,60,88,.08);
    }

    /* Sticky action bar (mobile) */
    .order-page .sticky-bar{ display:none; }
    @media (max-width: 640px){
      .order-page .btn-primary{ width:100% }
      .order-page .sticky-bar{
        display:block; position:fixed; left:16px; right:16px; bottom:14px; z-index:50;
        background:rgba(255,255,255,.95); backdrop-filter:blur(8px);
        border:1px solid #E5E7EB; border-radius:1rem; padding:.6rem .7rem;
        box-shadow:0 12px 30px rgba(1,60,88,.15);
      }
      .order-page .sticky-bar .btn-primary{padding:.7rem 1rem}
    }
  </style>

  <div class="order-page min-h-screen bg-grad py-12 px-6 relative overflow-hidden">
    <div class="pattern absolute inset-0"></div>

    <div class="relative z-10 max-w-5xl mx-auto">
      {{-- Header --}}
      <header class="glow-card sheen bg-[var(--ink)] text-white px-6 md:px-8 py-6 flex items-center justify-between card">
        <div>
          <h1 class="text-2xl md:text-3xl font-extrabold">Buat Pesanan Laundry</h1>
        <p class="text-[var(--sky)] text-sm md:text-base mt-1">Atur layanan laundry sesuai kebutuhan Anda</p>
        </div>
        <div class="text-4xl md:text-5xl text-[var(--amber2)]/90">
          <i class="fa-solid fa-basket-shopping"></i>
        </div>
      </header>

      {{-- Kartu utama --}}
      <div class="bg-white card rounded-t-none rounded-b-2xl p-5 md:p-8 mt-0">

        {{-- ====== Cara Kerja (PINDAH KE PALING ATAS KARTU) ====== --}}
        <section class="how -mt-2 mb-6 p-5">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-xl font-extrabold text-[var(--ink)]">🧭 Cara Kerja</h3>
            <span class="text-xs text-gray-500 hidden sm:block">Pahami langkahnya, lalu isi formulir di bawah</span>
          </div>
          <div class="grid md:grid-cols-4 gap-4">
            <div class="how-step">
              <div class="text-2xl text-[var(--amber)] mb-2"><i class="fa-solid fa-list-check"></i></div>
              <p class="font-semibold text-[var(--ink)]">Pilih layanan</p>
              <p class="text-sm text-gray-600">Tentukan jenis & jumlah.</p>
            </div>
            <div class="how-step">
              <div class="text-2xl text-[var(--amber)] mb-2"><i class="fa-solid fa-truck-pickup"></i></div>
              <p class="font-semibold text-[var(--ink)]">Jadwalkan jemput</p>
              <p class="text-sm text-gray-600">Kurir menjemput di alamatmu.</p>
            </div>
            <div class="how-step">
              <div class="text-2xl text-[var(--amber)] mb-2"><i class="fa-solid fa-soap"></i></div>
              <p class="font-semibold text-[var(--ink)]">Diproses rapi</p>
              <p class="text-sm text-gray-600">Cuci, setrika, quality check.</p>
            </div>
            <div class="how-step">
              <div class="text-2xl text-[var(--amber)] mb-2"><i class="fa-solid fa-truck-fast"></i></div>
              <p class="font-semibold text-[var(--ink)]">Antar balik</p>
              <p class="text-sm text-gray-600">Diantar tepat waktu.</p>
            </div>
          </div>
        </section>

        {{-- Flash --}}
        @if(session('success'))
          <div class="alert bg-green-50 border border-green-200 text-green-700 px-4 py-3 mb-5">
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="alert bg-red-50 border border-red-200 text-red-700 px-4 py-3 mb-5">
            <ul class="list-disc pl-5 text-sm space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- ====== FORM ====== --}}
        <form action="{{ route('user.orders.store') }}" method="POST" id="order-form">
          @csrf

          <div class="grid lg:grid-cols-3 gap-8">
            {{-- LEFT: Fields --}}
            <div class="lg:col-span-2 space-y-6">
              {{-- Service --}}
              <div>
                <label class="block font-semibold text-[var(--ink)]">Jenis Layanan</label>
                <div class="field mt-2">
                  <i class="fa-solid fa-list icon"></i>
                  <select name="service_id" required class="input" aria-label="Pilih layanan" id="serviceSelect">
                    <option value="">Pilih Layanan</option>
                    @foreach($services as $service)
                      @php
                        $isNew = (isset($latestId) && $service->id === $latestId)
                                 || (isset($newCutoff) && $service->created_at && $service->created_at->gt($newCutoff));
                      @endphp
                      <option value="{{ $service->id }}"
                              data-price="{{ $service->price }}"
                              data-unit="{{ $service->unit }}">
                        {{ $service->name }}
                        — Rp {{ number_format($service->price,0,',','.') }}@if(!empty($service->unit))/{{ $service->unit }}@endif
                        @if($isNew) — NEW @endif
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              {{-- Quantity --}}
              <div>
                <div class="flex items-center justify-between">
                  <label class="block font-semibold text-[var(--ink)]">Jumlah</label>
                  <div class="hidden sm:flex items-center gap-2">
                    <button type="button" class="chip-mini" data-inc="0.5">+0.5</button>
                    <button type="button" class="chip-mini" data-inc="1">+1</button>
                    <button type="button" class="chip-mini" data-inc="-1">-1</button>
                  </div>
                </div>
                <div class="field mt-2">
                  <i class="fa-solid fa-scale-balanced icon"></i>
                  <input type="number" step="0.01" name="quantity" value="1" min="0" required class="input" placeholder="Contoh: 2.5" aria-label="Jumlah" id="qtyInput">
                  <span class="unit-badge" id="unitBadge">Unit</span>
                </div>
                <div class="sm:hidden mt-2 flex items-center gap-2">
                  <button type="button" class="chip-mini" data-inc="0.5">+0.5</button>
                  <button type="button" class="chip-mini" data-inc="1">+1</button>
                  <button type="button" class="chip-mini" data-inc="-1">-1</button>
                </div>
                <p class="text-xs muted mt-1">Isi sesuai satuan (Kg / Pcs / Pasang). Contoh: 2.5 Kg</p>
              </div>

              {{-- Address --}}
              <div>
                <label class="block font-semibold text-[var(--ink)]">Alamat</label>
                <div class="field mt-2">
                  <i class="fa-solid fa-location-dot icon"></i>
                  <textarea name="address" rows="3" required class="input" placeholder="Jalan, nomor rumah, kecamatan, kota" aria-label="Alamat lengkap"></textarea>
                </div>
              </div>

              {{-- Dates --}}
              <div class="grid md:grid-cols-2 gap-6">
                <div>
                  <div class="flex items-center justify-between">
                    <label class="block font-semibold text-[var(--ink)]">Tanggal Jemput</label>
                    <div class="flex items-center gap-2">
                      <button type="button" class="chip-mini set-pickup" data-hours="2">Now+2j</button>
                      <button type="button" class="chip-mini set-pickup" data-hours="24">+24j</button>
                    </div>
                  </div>
                  <div class="field mt-2">
                    <i class="fa-solid fa-truck-pickup icon"></i>
                    <input type="datetime-local" name="pickup_date" required class="input" aria-label="Tanggal jemput" id="pickupInput">
                  </div>
                </div>
                <div>
                  <div class="flex items-center justify-between">
                    <label class="block font-semibold text-[var(--ink)]">Tanggal Antar</label>
                    <div class="flex items-center gap-2">
                      <button type="button" class="chip-mini set-delivery" data-hours="24">+24j</button>
                      <button type="button" class="chip-mini set-delivery" data-hours="48">+48j</button>
                    </div>
                  </div>
                  <div class="field mt-2">
                    <i class="fa-solid fa-truck-fast icon"></i>
                    <input type="datetime-local" name="delivery_date" required class="input" aria-label="Tanggal antar" id="deliveryInput">
                  </div>
                </div>
              </div>

              {{-- Notes --}}
              <div>
                <label class="block font-semibold text-[var(--ink)]">Catatan (opsional)</label>
                <div class="field mt-2">
                  <i class="fa-solid fa-note-sticky icon"></i>
                  <textarea name="notes" rows="3" class="input" placeholder="Instruksi khusus (misal: handuk dipisah, gunakan softener hypoallergenic)"></textarea>
                </div>
              </div>
            </div>

            {{-- RIGHT: Summary --}}
            <aside class="lg:col-span-1">
              <div class="summary p-5 lg:sticky lg:top-6" id="summaryBox">
                <h2 class="font-extrabold text-[var(--ink)] mb-3">🧾 Ringkasan Pembayaran</h2>

                <div class="space-y-2 text-sm text-gray-700">
                  <div class="flex justify-between"><span>Subtotal</span><span id="subtotal">Rp0</span></div>
                  <div class="flex justify-between"><span>Biaya Lain</span><span class="text-gray-400">—</span></div>
                </div>

                <hr class="my-3 divider">

                <div class="flex justify-between items-center">
                  <span class="font-bold text-[var(--ink)] text-lg">Total</span>
                  <span id="total" class="font-black text-lg text-[var(--ink)]">Rp0</span>
                </div>
              </div>

              <button type="submit" class="btn-primary w-full mt-6">
                Buat Pesanan 🚀
              </button>
            </aside>
          </div>
        </form>

        {{-- Layanan Populer --}}
        @php
          $popular = (isset($popularServices) && count($popularServices))
                    ? $popularServices
                    : ($services->take(3) ?? []);
        @endphp

        @if(!empty($popular) && count($popular) > 0)
        <section class="mt-10">
          <div class="flex items-center justify-between mb-4 gap-3">
            <h3 class="text-xl font-extrabold text-[var(--ink)]">🔥 Layanan Populer</h3>
            <span class="pop-badge"><i class="fa-solid fa-star"></i> Most picked</span>
          </div>

          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popular as $svc)
              @php $n = strtolower($svc->name ?? ''); @endphp
              <article class="pop-card">
                <div class="flex items-start gap-3">
                  <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white" style="background:#F5A201;">
                    @if(str_contains($n,'express')) <i class="fa-solid fa-bolt"></i>
                    @elseif(str_contains($n,'cuci'))   <i class="fa-solid fa-basket-shopping"></i>
                    @elseif(str_contains($n,'lipat'))  <i class="fa-solid fa-box"></i>
                    @elseif(str_contains($n,'setrika') || str_contains($n,'strika')) <i class="fa-solid fa-wind"></i>
                    @elseif(str_contains($n,'bed') || str_contains($n,'sprei') || str_contains($n,'selimut')) <i class="fa-solid fa-bed"></i>
                    @elseif(str_contains($n,'jas'))    <i class="fa-solid fa-user-tie"></i>
                    @else <i class="fa-solid fa-soap"></i> @endif
                  </div>
                  <div class="flex-1">
                    <h4 class="font-bold text-[var(--ink)] leading-tight">{{ $svc->name }}</h4>
                    <p class="text-sm text-gray-600">Rp {{ number_format($svc->price,0,',','.') }}@if(!empty($svc->unit))/{{ $svc->unit }}@endif</p>
                  </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                  <button type="button"
                          class="quick-btn"
                          data-id="{{ $svc->id }}"
                          data-price="{{ $svc->price }}"
                          data-unit="{{ $svc->unit }}">
                    Pilih cepat <i class="fa-solid fa-arrow-right"></i>
                  </button>
                  <span class="text-xs text-gray-500">~estimasi cepat</span>
                </div>
              </article>
            @endforeach
          </div>
        </section>
        @endif
      </div>
    </div>

    {{-- Sticky mobile checkout bar --}}
    <div class="sticky-bar">
      <div class="flex items-center justify-between gap-3">
        <div>
          <div class="text-xs text-gray-500">Total</div>
          <div id="totalMobile" class="font-extrabold text-[var(--ink)] text-lg">Rp0</div>
        </div>
        <button form="order-form" type="submit" class="btn-primary">Buat Pesanan 🚀</button>
      </div>
    </div>
  </div>

  {{-- Font Awesome --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>

  {{-- Script kalkulasi + helper --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const serviceSelect = document.getElementById('serviceSelect');
      const qtyInput      = document.getElementById('qtyInput');
      const subtotalText  = document.getElementById('subtotal');
      const totalText     = document.getElementById('total');
      const totalMobile   = document.getElementById('totalMobile');
      const unitBadge     = document.getElementById('unitBadge');
      const pickupInput   = document.getElementById('pickupInput');
      const deliveryInput = document.getElementById('deliveryInput');
      const summaryBox    = document.getElementById('summaryBox');

      function formatRupiah(num){ return 'Rp' + (num || 0).toLocaleString('id-ID'); }
      function currentUnit(){ return serviceSelect?.selectedOptions?.[0]?.getAttribute('data-unit') || 'Unit'; }
      function currentPrice(){ return parseFloat(serviceSelect?.selectedOptions?.[0]?.getAttribute('data-price')) || 0; }

      function updateUnit(){ unitBadge.textContent = currentUnit(); }
      function updateTotal(){
        const price = currentPrice();
        const qty   = parseFloat(qtyInput?.value) || 0;
        const subtotal = price * qty;
        subtotalText.textContent = formatRupiah(subtotal);
        totalText.textContent    = formatRupiah(subtotal);
        totalMobile.textContent  = formatRupiah(subtotal);
      }
      function nudgeSummary(){
        if(!summaryBox) return;
        summaryBox.style.boxShadow = "0 0 0 4px rgba(245,162,1,.25)";
        setTimeout(()=> summaryBox.style.boxShadow = "", 450);
      }

      // Init
      updateUnit(); updateTotal();

      // Events
      serviceSelect?.addEventListener('change', () => { updateUnit(); updateTotal(); nudgeSummary(); });
      qtyInput?.addEventListener('input', () => { updateTotal(); });

      // Quantity quick chips
      document.querySelectorAll('.chip-mini[data-inc]').forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const inc = parseFloat(btn.dataset.inc);
          const cur = parseFloat(qtyInput.value || '0') + inc;
          qtyInput.value = Math.max(0, Number(cur.toFixed(2)));
          updateTotal(); nudgeSummary();
        });
      });

      // Set datetime helpers
      function addHoursToNow(h){
        const d = new Date(Date.now() + (h*60*60*1000));
        const pad = n => String(n).padStart(2,'0');
        const v = d.getFullYear() + '-' + pad(d.getMonth()+1) + '-' + pad(d.getDate())
                + 'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
        return v;
      }
      document.querySelectorAll('.set-pickup').forEach(b=>{
        b.addEventListener('click', ()=>{
          const h = parseInt(b.dataset.hours || '0', 10);
          pickupInput.value = addHoursToNow(h);
          pickupInput.dispatchEvent(new Event('input', {bubbles:true}));
        });
      });
      document.querySelectorAll('.set-delivery').forEach(b=>{
        b.addEventListener('click', ()=>{
          const h = parseInt(b.dataset.hours || '0', 10);
          deliveryInput.value = addHoursToNow(h);
          deliveryInput.dispatchEvent(new Event('input', {bubbles:true}));
        });
      });

      // Quick-pick dari kartu Layanan Populer
      document.querySelectorAll('.quick-btn').forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const id    = btn.dataset.id;
          const unit  = btn.dataset.unit || 'Unit';
          const sel   = serviceSelect;
          const qty   = qtyInput;
          if(!sel) return;
          sel.value = id;
          unitBadge.textContent = unit;
          sel.dispatchEvent(new Event('change', {bubbles:true}));
          if(qty && (!qty.value || parseFloat(qty.value) === 0)){ qty.focus(); }
          nudgeSummary();
          if(window.innerWidth < 1024){
            summaryBox?.scrollIntoView({behavior:'smooth', block:'nearest'});
          }
        });
      });
    });
  </script>
</x-app-layout>
