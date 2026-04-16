<x-guest-layout>
    <!-- Session Status (e.g. after register redirect) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- NIM -->
        <div>
            <x-input-label for="nim" value="NIM" />
            <x-text-input id="nim" class="block mt-1 w-full" type="text"
                name="nim" :value="old('nim')" required autofocus autocomplete="username"
                placeholder="Masukkan NIM Anda" />
            <x-input-error :messages="$errors->get('nim')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required autocomplete="current-password"
                placeholder="Masukkan password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="mt-5">
            <x-primary-button class="w-full justify-center py-2.5">
                🔐 Login
            </x-primary-button>
        </div>

        <p class="mt-4 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">
                Daftar sekarang
            </a>
        </p>
    </form>
</x-guest-layout>
