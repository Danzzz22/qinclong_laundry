<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Qinclong Laundry</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>
<body class="h-screen w-screen bg-gray-900">

    <!-- Background Foto -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/landscape_login_bg.jpg') }}" 
             alt="Laundry Background" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    </div>

    <!-- Container Form -->
    <div class="relative z-10 flex items-center justify-center h-screen">
        <div class="bg-white/20 backdrop-blur-lg border border-white/30 shadow-2xl rounded-2xl w-full max-w-md p-8 text-center">

            <!-- Branding -->
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent mb-6">
                Qinclong Laundry
            </h1>

            <!-- Pesan Error -->
            @if(session('error'))
                <div class="bg-red-500/80 text-white text-sm font-medium px-4 py-2 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Judul -->
            <h2 class="text-xl font-bold text-white mb-6">Login ke Akun Anda</h2>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5 text-left">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 px-4 py-2 bg-white/80 text-gray-900">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-400" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 px-4 py-2 bg-white/80 text-gray-900">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-400" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center text-white">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-400 focus:ring-yellow-400" name="remember">
                    <label for="remember_me" class="ml-2 text-sm">Remember me</label>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-yellow-400 to-orange-400 text-indigo-900 font-bold py-2 px-4 rounded-lg shadow hover:opacity-90 transition">
                    Login
                </button>
            </form>

            <!-- Forgot & Register -->
            <div class="mt-6 flex justify-between items-center text-sm">
                <a href="{{ route('password.request') }}" class="text-gray-200 hover:text-white">Lupa password?</a>
                <a href="{{ route('register') }}" class="font-semibold bg-gradient-to-r from-yellow-300 to-orange-400 bg-clip-text text-transparent hover:underline">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</body>
</html>
