<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">Admin Panel</p>
            <div>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">Edit User</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Perbarui data atau status keaktifan akun pengguna ini.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="app-panel mb-6 border border-red-200 bg-red-50 px-5 py-4 text-red-700 dark:border-red-900/30 dark:bg-red-900/10 dark:text-red-400">
                    <ul class="list-disc pl-5 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 sm:p-10 transition-colors">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                    @csrf @method('PUT')

                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1.5 w-full" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Alamat Email" />
                        <x-text-input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1.5 w-full" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Password Baru (Kosongkan jika tidak diubah)" />
                        <x-text-input id="password" type="password" name="password" class="mt-1.5 w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" class="mt-1.5 w-full" />
                    </div>

                    <div class="pt-2">
                        <label for="is_active" class="inline-flex items-center cursor-pointer">
                            <input id="is_active" type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:checked:bg-blue-500 dark:focus:ring-blue-500 transition-colors cursor-pointer" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <span class="ml-3 text-sm font-bold text-slate-600 dark:text-slate-300">Akun Aktif</span>
                        </label>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 mt-6 dark:border-slate-800 sm:flex-row sm:justify-end">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                            Batal
                        </a>
                        <x-primary-button>Update User</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
