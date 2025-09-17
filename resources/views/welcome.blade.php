<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Online</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600">LaundryOnline</a>
                </div>

                <!-- Menu -->
                <div class="hidden md:flex space-x-6 items-center">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                    <a href="#layanan" class="text-gray-700 hover:text-indigo-600">Layanan</a>
                    <a href="{{ route('orders.create') }}" class="text-gray-700 hover:text-indigo-600">Pesan</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-3 py-2 rounded-md hover:bg-indigo-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-indigo-600 text-white py-20 text-center">
        <h1 class="text-4xl font-bold">Laundry Online – Jemput, Cuci, Antar 🚛</h1>
        <p class="mt-4">Pesan laundry tanpa ribet, cukup klik dari rumah!</p>
        <a href="{{ route('orders.create') }}" class="mt-6 inline-block bg-white text-indigo-600 px-6 py-2 rounded-lg shadow hover:bg-gray-100">
            Pesan Sekarang
        </a>
    </section>

    <!-- Layanan Kami -->
    <section id="layanan" class="py-12 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-8">Layanan Kami</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="font-bold text-lg">Laundry Kiloan</h3>
                    <p class="mt-2 text-gray-600">Rp 7.000 / Kg</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="font-bold text-lg">Cuci Sepatu</h3>
                    <p class="mt-2 text-gray-600">Rp 25.000 / Pasang</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="font-bold text-lg">Cuci Jas</h3>
                    <p class="mt-2 text-gray-600">Rp 30.000 / Item</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
