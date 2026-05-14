<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">Admin Panel</p>
            <div>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">{{ __('Tambah Kategori Utama') }}</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Buat kategori utama baru untuk mengelompokkan metode pembayaran.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 sm:p-10 transition-colors">
                <form method="POST" action="{{ route('admin.payment-categories.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Kategori Utama')" />
                        <x-text-input id="name" class="block mt-1.5 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Bank, E-Wallet, atau Cash" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="sort_order" :value="__('Urutan Tampil (Sort Order)')" />
                        <x-text-input id="sort_order" class="block mt-1.5 w-full" type="number" name="sort_order" :value="old('sort_order', 0)" required />
                        <p class="mt-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">* Angka lebih kecil akan muncul lebih awal di pilihan dropdown.</p>
                        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <label for="is_active" class="inline-flex items-center cursor-pointer">
                            <input id="is_active" type="checkbox" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:checked:bg-blue-500 dark:focus:ring-blue-500 transition-colors cursor-pointer" name="is_active" value="1" checked>
                            <span class="ml-3 text-sm font-bold text-slate-600 dark:text-slate-300">{{ __('Aktifkan Kategori Ini') }}</span>
                        </label>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 mt-6 dark:border-slate-800 sm:flex-row sm:justify-end">
                        <a href="{{ route('admin.payment-categories.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button>
                            {{ __('Simpan Kategori') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
