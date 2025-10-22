<x-guest-layout>
        <!-- Overlay -->
        <div class=" bg-black/50 backdrop-blur-sm"></div>

        <!-- Register Card -->
        <div class="relative w-full max-w-md bg-white/10 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-white/20 z-10 animate-fadeIn">
            <!-- Judul -->
            <h1 class="text-2xl font-extrabold text-center mb-2 bg-clip-text text-transparent bg-gradient-to-r from-purple-500 to-pink-400">
                Qinclong Laundry
            </h1>
            <h2 class="text-lg font-semibold text-center text-white mb-6">Daftar Akun</h2>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-white" />
                    <x-text-input id="name"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-yellow-400 focus:ring-yellow-400"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-yellow-400 focus:ring-yellow-400"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-white" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-yellow-400 focus:ring-yellow-400"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-white" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-yellow-400 focus:ring-yellow-400"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                        class="w-full py-2 px-4 rounded-lg font-bold text-white bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 shadow-md transform hover:-translate-y-0.5 transition">
                        🚀 Daftar Sekarang
                    </button>
                </div>
            </form>

            <!-- Login link -->
            <p class="mt-4 text-center text-white text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-yellow-400 hover:text-yellow-500">Login di sini</a>
            </p>
        </div>
    </div>
</x-guest-layout>
