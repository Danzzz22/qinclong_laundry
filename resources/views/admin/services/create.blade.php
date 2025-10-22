{{-- resources/views/admin/services/create.blade.php --}}
<x-app-layout>
  <div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
    <div class="rounded-2xl p-5 border border-slate-200"
         style="background:
           radial-gradient(600px 220px at 8% -10%, rgba(168,232,249,.35), transparent 60%),
           radial-gradient(520px 200px at 92% -10%, rgba(255,187,66,.25), transparent 55%),
           linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 40%);">
      <div class="flex items-start justify-between gap-4">
        <div>
          <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800">Tambah Layanan</h1>
          <p class="mt-1 text-sm text-slate-600">Lengkapi detail layanan. Preview di kanan akan realtime.</p>
        </div>
        <a href="{{ route('admin.services.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
          <i class="fa-solid fa-arrow-left"></i> Kembali
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

    {{-- Pakai partial form yang sama biar konsisten --}}
    @include('admin.services.partials.form', [
      'route'  => route('admin.services.store'),
      'method' => 'POST',
      'service'=> new \App\Models\Service(),
      'submitLabel' => 'Simpan Layanan',
      'cancelRoute' => route('admin.services.index'),
    ])
  </div>

  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</x-app-layout>
