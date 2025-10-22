<x-app-layout>
  <div class="max-w-6xl mx-auto px-6 py-8 space-y-6">
    <div class="rounded-2xl p-5 border border-slate-200"
         style="background:
           radial-gradient(900px 300px at -20% -50%, rgba(168,232,249,.35), transparent 60%),
           radial-gradient(900px 300px at 120% -60%, rgba(255,211,91,.28), transparent 60%),
           linear-gradient(90deg,#FDF7E6,#EAF9FF);">
      <div class="flex items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl lg:text-3xl font-black text-slate-800">Edit Layanan</h1>
          <p class="text-slate-600 text-sm">Perbarui detail layanan. Preview berada di kanan.</p>
        </div>
        <a href="{{ route('admin.services.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
          ← Kembali
        </a>
      </div>
    </div>

    @if ($errors->any())
      <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-700">
        <ul class="list-disc pl-5 space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if (session('success'))
      <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">
        {{ session('success') }}
      </div>
    @endif

    {{-- Pakai partial form modern (sudah ada preview & label nama file) --}}
    @include('admin.services.partials.form', [
      'route'  => route('admin.services.update', $service),
      'method' => 'PUT',
      'service'=> $service,
      'submitLabel' => 'Simpan Perubahan',
      'cancelRoute' => route('admin.services.index'),
    ])

    {{-- Tombol Hapus terpisah --}}
    <form id="svcDeleteForm" method="POST" action="{{ route('admin.services.destroy', $service) }}" class="mt-6">
      @csrf @method('DELETE')
      <button type="submit"
              onclick="return confirm('Hapus layanan ini?')"
              class="px-4 py-2 rounded-xl bg-rose-600 text-white font-semibold hover:bg-rose-700">
        Hapus Layanan
      </button>
    </form>
  </div>
</x-app-layout>
