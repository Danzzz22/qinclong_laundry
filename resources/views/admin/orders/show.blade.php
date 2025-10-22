<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Header -->
            <div class="relative bg-gradient-to-r from-[#A8E8F9] via-[#FFBA42] to-[#F5A201] rounded-2xl shadow-lg p-6 overflow-hidden">
                <h1 class="text-2xl font-extrabold text-[#013C58] flex items-center gap-2">
                    📄 Detail Pesanan
                </h1>
                <p class="text-[#013C58]/80 mt-1">Detail lengkap pesanan pelanggan</p>
                <div class="absolute right-6 bottom-2 text-6xl opacity-10">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>

            <!-- Data Customer -->
            <div class="bg-white rounded-2xl shadow p-6 space-y-3">
                <h2 class="text-xl font-bold text-[#013C58] mb-4">👤 Data Customer</h2>
                <p><strong>Nama:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Alamat:</strong> {{ $order->address }}</p>
                <p><strong>Tanggal Jemput:</strong> {{ $order->pickup_date }}</p>
                <p><strong>Tanggal Antar:</strong> {{ $order->delivery_date }}</p>
                <p><strong>Status:</strong> {!! $order->status_label !!}</p>
                @if($order->notes)
                    <p><strong>Catatan:</strong> {{ $order->notes }}</p>
                @endif
            </div>

            <!-- Detail Item -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-bold text-[#013C58] mb-4">🧾 Detail Layanan</h2>

                @if($order->details->count() > 0)
                    <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 border">Layanan</th>
                                <th class="px-3 py-2 border">Qty</th>
                                <th class="px-3 py-2 border">Harga</th>
                                <th class="px-3 py-2 border">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                                <tr>
                                    <td class="px-3 py-2 border">{{ $detail->service->name }}</td>
                                    <td class="px-3 py-2 border">{{ $detail->quantity }}</td>
                                    <td class="px-3 py-2 border">{{ $detail->price_formatted }}</td>
                                    <td class="px-3 py-2 border">{{ $detail->subtotal_formatted }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Total -->
                    <div class="flex justify-end mt-4">
                        <div class="bg-[#FFF5E0] border border-[#F5A201]/40 px-4 py-3 rounded-xl shadow-sm">
                            <p class="font-bold text-[#013C58] text-lg">
                                Total: <span class="text-[#F5A201]">{{ $order->total_price_formatted }}</span>
                            </p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada detail layanan untuk pesanan ini.</p>
                @endif
            </div>

            <!-- Tombol Kembali -->
            <div class="text-right">
                <a href="{{ route('admin.orders.index') }}"
                   class="px-5 py-2 rounded-lg bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
</x-app-layout>
