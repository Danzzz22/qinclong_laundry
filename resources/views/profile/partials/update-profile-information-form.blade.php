<section>
    <header>
        <h2 class="text-lg font-semibold text-[#013C58]">
            {{ __('Informasi Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui nama, email, dan usia akunmu. Jika email belum terverifikasi, kamu bisa minta kirim ulang tautan verifikasi.") }}
        </p>
    </header>

    {{-- Form untuk kirim ulang verifikasi email --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Update profile --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                placeholder="Contoh: Budi Santoso"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                placeholder="nama@email.com"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        {{ __('Alamat email kamu belum terverifikasi.') }}

                        <button
                            form="send-verification"
                            class="underline text-sm text-[#013C58] hover:text-[#0b2d42] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F5A201]"
                        >
                            {{ __('Kirim ulang tautan verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke email kamu.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Usia --}}
        <div>
            <x-input-label for="age" :value="__('Usia (opsional)')" />
            <x-text-input
                id="age"
                name="age"
                type="number"
                class="mt-1 block w-full"
                :value="old('age', $user->age ?? '')"
                min="1"
                max="120"
                inputmode="numeric"
                placeholder="Contoh: 25"
            />
            <p class="mt-1 text-xs text-gray-500">
                {{ __('Isi jika ingin menampilkan usia pada profil. Boleh dikosongkan.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Simpan') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
