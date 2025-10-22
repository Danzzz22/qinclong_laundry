{{-- resources/views/admin/services/partials/form.blade.php --}}

@php
  /** @var \App\Models\Service $service */
  $service     = $service ?? new \App\Models\Service();
  $submitLabel = $submitLabel ?? 'Simpan';
  $cancelRoute = $cancelRoute ?? route('admin.services.index');

  $valName  = old('name',        $service->name);
  $valPrice = old('price',       (int)($service->price ?? 0));
  $valUnit  = old('unit',        $service->unit);
  $valDesc  = old('description', $service->description);
  $isActive = (int) old('is_active', is_null($service->is_active) ? 1 : (int) $service->is_active);

  $imgUrl = $service->image_url ?? asset('images/service-placeholder.png');

  $storedPath        = $service->image_path ?? ( $service->image_url ? parse_url($service->image_url, PHP_URL_PATH) : null );
  $currentFilePretty = $storedPath ? trim($storedPath, '/') : 'Belum ada file';
@endphp

<style>
  .svc-form{ --ink:#013C58; --amber:#F5A201; --amber2:#FFBA42; --ring:rgba(245,162,1,.18) }
  .svc-form .wrap{display:grid;gap:1.25rem}
  @media (min-width:1024px){ .svc-form .wrap{grid-template-columns:1fr 1fr} }

  .svc-form .card{background:#fff;border:1px solid #edf2f7;border-radius:1rem;box-shadow:0 14px 34px rgba(1,60,88,.08)}
  .svc-form .card-hd{padding:1rem 1rem 0}
  .svc-form .card-bd{padding:1rem}

  .svc-form .input{
    width:100%;border:1px solid #e5e7eb;border-radius:.85rem;padding:.75rem .95rem;background:#fff;
    transition:border-color .15s,box-shadow .15s
  }
  .svc-form .input:focus{outline:none;border-color:var(--amber);box-shadow:0 0 0 4px var(--ring)}
  .svc-form .hint{font-size:.78rem;color:#64748b}

  .svc-form .btn{border-radius:.9rem;padding:.8rem 1rem;font-weight:900;transition:transform .12s,box-shadow .12s}
  .svc-form .btn-ghost{background:#F8FAFC;border:1px solid #E2E8F0;color:#0b2d42}
  .svc-form .btn-prim{background-image:linear-gradient(90deg,var(--amber),var(--amber2));color:#102b3a;box-shadow:0 12px 28px rgba(245,162,1,.25)}
  .svc-form .btn-prim:hover{transform:translateY(-1px);box-shadow:0 16px 36px rgba(245,162,1,.32)}

  .svc-form .toggle{position:relative;width:46px;height:28px}
  .svc-form .toggle input{position:absolute;inset:0;opacity:0;cursor:pointer}
  .svc-form .toggle .track{position:absolute;inset:0;background:#e5e7eb;border:1px solid #e5e7eb;border-radius:999px;transition:.18s}
  .svc-form .toggle .thumb{
    position:absolute;top:3px;left:3px;width:22px;height:22px;background:#fff;border-radius:999px;
    box-shadow:0 2px 6px rgba(0,0,0,.15);transition:left .18s;display:grid;place-items:center;color:#64748b;font-size:.75rem
  }
  .svc-form .toggle input:checked ~ .track{background:#86efac;border-color:#86efac}
  .svc-form .toggle input:checked ~ .thumb{left:calc(100% - 25px);color:#16a34a}

  .svc-form .badge{font-weight:800;font-size:.72rem;padding:.22rem .48rem;border-radius:999px;display:inline-flex;gap:.35rem;align-items:center;border:1px solid #e2e8f0}
  .svc-form .badge.active{background:#dcfce7;color:#166534;border-color:#86efac}
  .svc-form .badge.inactive{background:#f1f5f9;color:#0b2d42;border-color:#e2e8f0}

  .file-row{display:flex;align-items:center;gap:.6rem;flex-wrap:wrap}
  .file-btn{display:inline-flex;align-items:center;gap:.5rem;background:#013C58;color:#fff;border-radius:.65rem;padding:.55rem .9rem;font-weight:800}
  .file-name{font-size:.82rem;background:#F1F5F9;border:1px solid #E2E8F0;border-radius:.5rem;padding:.4rem .6rem;color:#0b2d42}
  .file-link{color:#0b2d42;text-decoration:underline}
</style>

<div class="svc-form">
  <form method="POST" action="{{ $route }}" enctype="multipart/form-data" class="wrap">
    @csrf
    @if(strtoupper($method ?? 'POST') !== 'POST')
      @method($method)
    @endif

    {{-- LEFT --}}
    <section class="card">
      <div class="card-hd">
        <h2 class="font-extrabold text-[var(--ink)]">Detail Layanan</h2>
      </div>
      <div class="card-bd space-y-5">
        <div>
          <label class="block font-semibold text-[var(--ink)] mb-1">Nama Layanan</label>
          <input class="input" name="name" id="svcName" value="{{ $valName }}" required>
        </div>

        <div class="grid sm:grid-cols-3 gap-4">
          <div class="sm:col-span-2">
            <label class="block font-semibold text-[var(--ink)] mb-1">Harga (Rp)</label>
            <input class="input" type="number" min="0" name="price" id="svcPrice" value="{{ $valPrice }}" required>
            <p class="hint mt-1">Ditampilkan sebagai rupiah pada preview.</p>
          </div>
          <div>
            <label class="block font-semibold text-[var(--ink)] mb-1">Satuan</label>
            <input class="input" name="unit" id="svcUnit" placeholder="kg/pcs/set" value="{{ $valUnit }}">
          </div>
        </div>

        <div>
          <label class="block font-semibold text-[var(--ink)] mb-1">Deskripsi (opsional)</label>
          <textarea class="input" rows="4" name="description" id="svcDesc" placeholder="Tulis penjelasan singkat layanan...">{{ $valDesc }}</textarea>
        </div>

        <div class="grid sm:grid-cols-2 gap-4 items-start">
          <div>
            <label class="block font-semibold text-[var(--ink)] mb-1">Gambar (disimpan otomatis sebagai .webp, maks 2MB)</label>

            <div class="file-row">
              <label for="svcImgInput" class="file-btn">
                <i class="fa-solid fa-image"></i> Pilih / Ganti gambar
              </label>
              <input id="svcImgInput" type="file" name="image" accept="image/webp,image/*" class="sr-only">
              <span id="fileNameLabel" class="file-name" title="File sekarang">
                {{ $currentFilePretty }}
              </span>

              @if($service->image_url)
                <a class="file-link" href="{{ $service->image_url }}" target="_blank" rel="noopener">Lihat</a>
              @endif
            </div>

            <p class="hint mt-2">Jika tidak memilih gambar, sistem akan memakai gambar sebelumnya.</p>
          </div>

          <div class="rounded-lg border border-slate-200 overflow-hidden bg-white aspect-[16/10]">
            <img id="svcImgPreview" class="w-full h-full object-cover"
                 src="{{ $imgUrl }}" alt="Preview layanan">
          </div>
        </div>

        <div class="flex items-center gap-3">
          <label class="toggle" aria-label="Aktifkan layanan">
            <input type="checkbox" name="is_active" id="svcActive" value="1" {{ $isActive ? 'checked' : '' }}>
            <span class="track"></span>
            <span class="thumb"><i class="fa-solid fa-power-off"></i></span>
          </label>
          <span id="svcActiveLabel" class="badge {{ $isActive ? 'active' : 'inactive' }}">
            {{ $isActive ? 'Aktif' : 'Nonaktif' }}
          </span>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
          <a href="{{ $cancelRoute }}" class="btn btn-ghost">Batal</a>
          <button class="btn btn-prim">{{ $submitLabel }}</button>
        </div>
      </div>
    </section>

    {{-- RIGHT: PREVIEW --}}
    <aside class="card">
      <div class="card-hd">
        <h2 class="font-extrabold text-[var(--ink)]">Preview Kartu</h2>
      </div>
      <div class="card-bd">
        <div class="rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
          <div class="relative aspect-[16/10] bg-gray-100">
            <img id="pvImg" src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="Gambar layanan">
            <span id="pvBadge" class="absolute top-3 right-3 badge {{ $isActive ? 'active' : 'inactive' }}">
              {{ $isActive ? 'Aktif' : 'Nonaktif' }}
            </span>
          </div>
          <div class="p-4">
            <div id="pvName" class="font-extrabold text-slate-800 text-lg leading-tight">{{ $valName ?: 'Nama layanan' }}</div>
            <div id="pvPrice" class="text-amber-500 font-extrabold mt-1">
              Rp {{ number_format((int)$valPrice, 0, ',', '.') }}@if($valUnit)/{{ $valUnit }}@endif
            </div>
            <p id="pvDesc" class="text-sm mt-2" style="color:{{ $valDesc ? '#475569' : '#94a3b8' }}">
              {{ $valDesc ?: 'Deskripsi singkat layanan akan tampil di sini.' }}
            </p>
            <div class="mt-4 flex items-center gap-2">
              <span class="ml-auto text-xs text-slate-400">Preview ilustratif</span>
            </div>
          </div>
        </div>
      </div>
    </aside>
  </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
<script>
  (function(){
    const nameI  = document.getElementById('svcName');
    const priceI = document.getElementById('svcPrice');
    const unitI  = document.getElementById('svcUnit');
    const descI  = document.getElementById('svcDesc');
    const imgI   = document.getElementById('svcImgInput');
    const activeI= document.getElementById('svcActive');

    const pvName = document.getElementById('pvName');
    const pvPrice= document.getElementById('pvPrice');
    const pvDesc = document.getElementById('pvDesc');
    const pvImg  = document.getElementById('pvImg');

    const imgPrev= document.getElementById('svcImgPreview');
    const badge  = document.getElementById('pvBadge');
    const activeLabel = document.getElementById('svcActiveLabel');

    const fileNameLabel = document.getElementById('fileNameLabel');

    const rupiah = v => 'Rp ' + (Number(v||0)).toLocaleString('id-ID');

    function drawPrice(){
      const p = priceI.value || 0;
      const u = unitI.value ? ('/'+unitI.value) : '';
      pvPrice.textContent = rupiah(p) + u;
    }

    nameI?.addEventListener('input', ()=> pvName.textContent = nameI.value || 'Nama layanan');
    priceI?.addEventListener('input', drawPrice);
    unitI?.addEventListener('input', drawPrice);

    descI?.addEventListener('input', ()=>{
      const t = (descI.value || '').trim();
      pvDesc.textContent = t || 'Deskripsi singkat layanan akan tampil di sini.';
      pvDesc.style.color = t ? '#475569' : '#94a3b8';
    });

    imgI?.addEventListener('change', e=>{
      const [f] = e.target.files || []; if(!f) return;
      const url = URL.createObjectURL(f);
      imgPrev.src = url; pvImg.src = url;
      fileNameLabel.textContent = f.name; // tampilkan nama file baru
    });

    activeI?.addEventListener('change', ()=>{
      const on = activeI.checked;
      const cls = 'badge ' + (on ? 'active' : 'inactive');
      badge.className = 'absolute top-3 right-3 ' + cls;
      badge.textContent = on ? 'Aktif' : 'Nonaktif';
      activeLabel.className = cls;
      activeLabel.textContent = on ? 'Aktif' : 'Nonaktif';
    });

    drawPrice();
  })();
</script>
