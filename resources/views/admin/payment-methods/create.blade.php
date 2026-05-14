<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">Admin Panel</p>
            <div>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">Tambah Metode Pembayaran</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Tambahkan metode spesifik di bawah kategori utama untuk memudahkan pengguna.</p>
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
                <form method="POST" action="{{ route('admin.payment-methods.store') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="name" value="Nama Metode Pembayaran" />
                        <x-text-input id="name" type="text" name="name" value="{{ old('name') }}" class="mt-1.5 w-full" placeholder="Contoh: BCA, Mandiri, OVO" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="payment_category_id" value="Kategori Induk" />
                        <select id="payment_category_id" name="payment_category_id" class="app-field mt-1.5" required>
                            <option value="" disabled {{ old('payment_category_id') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (string) old('payment_category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">Metode ini akan dikelompokkan di bawah kategori yang dipilih.</p>
                        <x-input-error :messages="$errors->get('payment_category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="sort_order" value="Urutan Tampil (Sort Order)" />
                        <x-text-input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="mt-1.5 w-full" />
                        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:checked:bg-blue-500 dark:focus:ring-blue-500 transition-colors cursor-pointer" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="ml-3 text-sm font-bold text-slate-600 dark:text-slate-300">Aktifkan Metode Ini</span>
                        </label>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 mt-6 dark:border-slate-800 sm:flex-row sm:justify-end">
                        <a href="{{ route('admin.payment-methods.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">Batal</a>
                        <x-primary-button>Simpan Metode</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
