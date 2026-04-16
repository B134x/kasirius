<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Masukkan nama lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- NIM -->
        <div class="mt-4">
            <x-input-label for="nim" value="NIM" />
            <x-text-input id="nim" class="block mt-1 w-full" type="text"
                name="nim" :value="old('nim')" required autocomplete="off"
                placeholder="Masukkan NIM (angka)" inputmode="numeric" />
            <x-input-error :messages="$errors->get('nim')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required autocomplete="username"
                placeholder="Masukkan email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required autocomplete="new-password"
                placeholder="Buat password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-5">
            <x-primary-button class="w-full justify-center py-2.5">
                📝 Daftar
            </x-primary-button>
        </div>

        <p class="mt-4 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">
                Login di sini
            </a>
        </p>
    </form>
</x-guest-layout>
