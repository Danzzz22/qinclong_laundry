<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 shadow rounded">
        <h1 class="text-2xl font-bold mb-4">Buat Pesanan Laundry</h1>

        <!-- Notifikasi sukses -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <!-- Jenis Layanan -->
            <div class="mb-4">
                <label for="service" class="block font-medium">Jenis Layanan</label>
                <select name="service" id="service" class="w-full border rounded p-2">
                    <option value="Laundry Kiloan">Laundry Kiloan</option>
                    <option value="Cuci Sepatu">Cuci Sepatu</option>
                    <option value="Cuci Jas">Cuci Jas</option>
                </select>
            </div>

            <!-- Tanggal Jemput -->
            <div class="mb-4">
                <label for="pickup_date" class="block font-medium">Tanggal Jemput</label>
                <input type="datetime-local" name="pickup_date" class="w-full border rounded p-2">
            </div>

            <!-- Tanggal Antar -->
            <div class="mb-4">
                <label for="delivery_date" class="block font-medium">Tanggal Antar</label>
                <input type="datetime-local" name="delivery_date" class="w-full border rounded p-2">
            </div>

            <!-- Catatan -->
            <div class="mb-4">
                <label for="notes" class="block font-medium">Catatan (opsional)</label>
                <textarea name="notes" rows="3" class="w-full border rounded p-2"></textarea>
            </div>

            <!-- Submit -->
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">
                Buat Pesanan
            </button>
        </form>
    </div>
</x-app-layout>
