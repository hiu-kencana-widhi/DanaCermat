<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Selamat Datang Kembali</h2>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Silakan masuk ke akun Anda untuk melanjutkan pengelolaan keuangan.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6" data-no-animate="true">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <x-input-label for="password" :value="__('Kata Sandi')" class="mb-0" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:checked:bg-blue-500 dark:focus:ring-blue-500 transition-colors cursor-pointer" name="remember">
                <span class="ml-3 text-sm font-medium text-slate-600 dark:text-slate-300">Ingat saya di perangkat ini</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Masuk Sekarang') }}
            </x-primary-button>
        </div>
        
        <div class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                Daftar Gratis
            </a>
        </div>
    </form>
</x-guest-layout>
