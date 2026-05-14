<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">Transaksi</p>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">Riwayat Transaksi</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Kelola semua catatan keuangan Anda dengan tatanan yang rapi.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('transactions.create') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-black text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-700 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                    + Transaksi Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
            @if($errors->any())
                <div class="app-panel border-l-4 border-red-500 bg-red-50 px-6 py-4 text-red-700 dark:bg-red-900/10 dark:text-red-400">
                    <p class="font-bold mb-2">Terdapat beberapa masalah:</p>
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Filter Section -->
            <section class="bg-white/50 dark:bg-slate-900/50 sm:backdrop-blur-xl border border-slate-200 dark:border-slate-800 shadow-sm rounded-3xl p-6 sm:p-8 transition-[box-shadow,border-color,background-color] app-page-section" style="--app-enter-delay: 0.1s">
                <div class="mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight">Filter Lanjutan</h3>
                </div>

                <form method="GET" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-12 items-end">
                    <div class="xl:col-span-2 space-y-1.5">
                        <label for="search" class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1">Keterangan</label>
                        <input id="search" type="text" name="search" placeholder="Cari transaksi..." value="{{ request('search') }}" class="app-field" autocapitalize="none" spellcheck="false">
                    </div>
                    <div class="xl:col-span-2 space-y-1.5">
                        <label for="type" class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1">Jenis</label>
                        <select id="type" name="type" class="app-field">
                            <option value="">Semua Jenis</option>
                            <option value="income" {{ request('type')=='income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type')=='expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <div class="xl:col-span-2 space-y-1.5">
                        <label for="payment_method_id" class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1">Metode</label>
                        <select id="payment_method_id" name="payment_method_id" class="app-field">
                            <option value="">Semua Metode</option>
                            @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->paymentMethods as $pm)
                                        <option value="{{ $pm->id }}" {{ request('payment_method_id')==$pm->id ? 'selected' : '' }}>{{ $pm->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="lg:col-span-2 xl:col-span-4 space-y-1.5">
                        <label for="date_range" class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1">Rentang Tanggal</label>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                            <input id="start_date" type="date" name="start_date" value="{{ request('start_date') }}" class="app-field">
                            <span class="text-slate-400 hidden sm:block">&rarr;</span>
                            <input id="end_date" type="date" name="end_date" value="{{ request('end_date') }}" class="app-field">
                        </div>
                    </div>
                    <div class="lg:col-span-2 xl:col-span-2 flex items-center gap-3">
                        <button type="submit" class="flex-1 rounded-xl bg-slate-900 dark:bg-blue-600 px-6 py-3 text-sm font-black text-white shadow-lg shadow-slate-900/10 dark:shadow-blue-900/20 transition-all hover:scale-105 active:scale-95">
                            Terapkan
                        </button>
                        @if(request()->hasAny(['search', 'type', 'payment_method_id', 'start_date', 'end_date']))
                            <a href="{{ route('transactions.index') }}" class="flex items-center justify-center w-12 h-12 rounded-xl border border-slate-200 bg-white text-slate-500 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </section>

            <!-- List Section -->
            <section class="app-page-section" style="--app-enter-delay: 0.2s">
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-[2rem] overflow-hidden transition-colors app-surface">
                    <div class="hidden md:block">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-slate-50/50 dark:bg-slate-800/30">
                                    <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Waktu</th>
                                    <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Keterangan</th>
                                    <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Metode</th>
                                    <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Nominal</th>
                                    <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($transactions as $trx)
                                <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-slate-900 dark:text-slate-100">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d') }}</span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">{{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('M Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <p class="text-sm font-black text-slate-800 dark:text-slate-200 leading-tight">{{ $trx->description }}</p>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        @if($trx->payments->count() > 1)
                                            <div class="flex flex-col gap-1">
                                                @foreach($trx->payments as $payment)
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-[10px] font-black text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded">{{ $payment->paymentMethod?->name }}</span>
                                                        <span class="text-[10px] font-bold text-slate-400">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-sm">
                                                    {{ ['Bank' => '🏦', 'E-Wallet' => '📱', 'Cash' => '💵'][$trx->paymentMethod?->category?->name] ?? '💰' }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-black text-slate-700 dark:text-slate-300">{{ $trx->paymentMethod?->name ?? '---' }}</span>
                                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $trx->paymentMethod?->category?->name ?? '' }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                        <p class="text-base font-black {{ $trx->type == 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </p>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('transactions.edit', $trx) }}" class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-400/10 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('transactions.destroy', $trx) }}" method="POST" data-confirm="Hapus transaksi ini?">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-400/10 transition-colors" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center max-w-xs mx-auto">
                                            <div class="w-20 h-20 rounded-[2rem] bg-slate-50 dark:bg-slate-800 flex items-center justify-center mb-6">
                                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <h4 class="text-lg font-black text-slate-900 dark:text-slate-100 leading-tight">Data Kosong</h4>
                                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Tidak ditemukan transaksi untuk filter yang Anda tentukan.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden p-4 space-y-4">
                        @forelse($transactions as $trx)
                        <div class="trx-card-mobile group">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-xl shadow-inner group-active:scale-95 transition-transform">
                                        {{ ['Bank' => '🏦', 'E-Wallet' => '📱', 'Cash' => '💵'][$trx->paymentMethod?->category?->name] ?? '💰' }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 dark:text-slate-100 leading-tight mb-1">{{ $trx->description }}</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('d M Y') }}</span>
                                            <span class="text-slate-300 dark:text-slate-700">•</span>
                                            <span class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">{{ $trx->paymentMethod?->name ?? '---' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right flex flex-col items-end">
                                    <p class="text-base font-black {{ $trx->type == 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                        {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </p>
                                    @if($trx->payments->count() > 1)
                                        <span class="text-[9px] font-bold text-slate-400 uppercase mt-1">Split Payment</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-50 dark:border-slate-800/50">
                                <a href="{{ route('transactions.edit', $trx) }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                <form action="{{ route('transactions.destroy', $trx) }}" method="POST" data-confirm="Hapus transaksi ini?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="p-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Belum ada transaksi.</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="border-t border-slate-100 px-8 py-5 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
