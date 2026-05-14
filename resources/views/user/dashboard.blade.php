<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-extrabold leading-tight text-slate-800 dark:text-slate-100 transition-colors">
                Dashboard Keuangan
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 transition-colors">
                Pantau saldo, kelola anggaran, dan analisis pengeluaran bulan ini.
            </p>
        </div>
    </x-slot>

    <div x-data="{}" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Overview Cards -->
        <div class="grid grid-cols-1 gap-4 sm:gap-5 sm:grid-cols-2 lg:grid-cols-4 app-page-section pt-2 pb-2" style="--app-enter-delay: 0.1s">
            <!-- Balance Card -->
            <div x-data="{ showDetail: false }" class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-6 flex flex-col shadow-xl shadow-blue-900/20 text-white relative overflow-hidden group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 lg:col-span-1 min-h-[160px]">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                
                <div class="relative z-10 flex-1">
                    <div class="flex items-center justify-between">
                        <p class="text-blue-100 text-[10px] sm:text-xs font-bold uppercase tracking-wider">Saldo Saat Ini</p>
                        <button @click="showDetail = !showDetail" class="p-1.5 hover:bg-white/10 rounded-lg transition-colors">
                            <svg :class="showDetail ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>
                    <p class="mt-2 text-3xl sm:text-3xl font-black tracking-tight">
                        Rp {{ number_format($balance, 0, ',', '.') }}
                    </p>

                    <!-- Breakdown Detail (Transition) -->
                    <div x-show="showDetail" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="mt-4 pt-4 border-t border-white/10 space-y-3">
                        @foreach($balanceBreakdown as $detail)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-sm">{{ $detail['icon'] }}</span>
                                <span class="text-xs font-bold text-blue-100">{{ $detail['name'] }}</span>
                            </div>
                            <span class="text-xs font-black">Rp {{ number_format($detail['balance'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="relative z-10 mt-4 flex items-center justify-between text-[10px] font-bold text-blue-200 uppercase tracking-widest">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></div>
                        Status: Aman
                    </div>
                    <span x-show="!showDetail" @click="showDetail = true" class="cursor-pointer hover:text-white transition-colors">Detail &rarr;</span>
                </div>
            </div>

            <!-- Income & Expense Mobile Grid -->
            <div class="grid grid-cols-2 gap-4 sm:hidden">
                <!-- Income Card Mobile -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-[2rem] p-5 flex flex-col transition-all active:scale-95">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Masuk</p>
                    <p class="text-sm font-black text-emerald-600 dark:text-emerald-400 truncate">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                </div>
                <!-- Expense Card Mobile -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-[2rem] p-5 flex flex-col transition-all active:scale-95">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Keluar</p>
                    <p class="text-sm font-black text-rose-600 dark:text-rose-400 truncate">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Desktop Only Cards (Hidden on mobile) -->
            <!-- Income Card -->
            <div class="hidden sm:flex bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-3xl p-6 flex flex-col justify-between transition-all hover:shadow-md hover:-translate-y-1">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pemasukan (Bulan Ini)</p>
                    <p class="mt-2 text-2xl font-black text-emerald-600 dark:text-emerald-400">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Total akumulasi bulan ini
                </div>
            </div>

            <!-- Monthly Expense Card -->
            <div class="hidden sm:flex bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-3xl p-6 flex flex-col justify-between transition-all hover:shadow-md hover:-translate-y-1">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pengeluaran (Bulan Ini)</p>
                    <p class="mt-2 text-2xl font-black text-rose-600 dark:text-rose-400">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    Batas aman: Rp {{ number_format($budgetSummary['total_amount'], 0, ',', '.') }}
                </div>
            </div>

            <!-- Weekly & Daily Expense Card -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-[2rem] sm:rounded-3xl p-5 flex flex-col justify-between transition-all hover:shadow-md hover:-translate-y-1 relative overflow-hidden">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Minggu Ini</p>
                                <p class="text-sm font-black text-slate-800 dark:text-slate-100">Rp {{ number_format($totalWeeklyExpense, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-px bg-slate-100 dark:bg-slate-800 w-full"></div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Hari Ini</p>
                                <p class="text-sm font-black text-slate-800 dark:text-slate-100">Rp {{ number_format($totalDailyExpense, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 app-page-section" style="--app-enter-delay: 0.25s">
            <!-- Budgets -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 transition-colors flex flex-col relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 dark:bg-blue-500/10 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-blue-500/10 transition-colors"></div>
                
                <div class="flex flex-col mb-8 gap-4 relative z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Anggaran
                        </h3>
                        <button @click="$dispatch('open-modal', 'set-budget')" class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-blue-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                @if($budgets->isNotEmpty())
                <div class="grid grid-cols-1 gap-3 mb-8 relative z-10">
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-3 border border-slate-100 dark:border-slate-800 transition-colors flex justify-between items-center">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Limit</p>
                        <p class="text-sm font-black text-slate-800 dark:text-slate-100">Rp {{ number_format($budgetSummary['total_amount'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-3 border border-slate-100 dark:border-slate-800 transition-colors flex justify-between items-center">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Pakai</p>
                        <p class="text-sm font-black {{ $budgetSummary['overall_percentage'] > 90 ? 'text-red-500' : 'text-blue-600 dark:text-blue-400' }}">Rp {{ number_format($budgetSummary['total_used'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @endif

                <div class="space-y-6 flex-1 relative z-10">
                    @forelse($budgets as $budget)
                        <div class="group/item p-4 sm:p-5 rounded-[1.5rem] border border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center shadow-sm group-hover/item:border-blue-500/30 transition-colors">
                                        <span class="text-lg">{{ $budget->category?->icon ?? '💰' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 dark:text-slate-100 block text-sm sm:text-base">{{ $budget->category?->name ?? 'Kategori dihapus' }}</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider {{ $budget->percentage > 90 ? 'text-rose-500' : ($budget->percentage > 75 ? 'text-amber-500' : 'text-emerald-500') }}">
                                            {{ $budget->percentage > 100 ? 'Melebihi Batas' : ($budget->percentage > 80 ? 'Hampir Habis' : 'Kondisi Aman') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between sm:justify-end gap-3 sm:gap-4">
                                    <div class="text-left sm:text-right">
                                        <p class="text-sm font-black text-slate-800 dark:text-slate-100">Rp {{ number_format($budget->used, 0, ',', '.') }}</p>
                                        <p class="text-[10px] sm:text-xs font-medium text-slate-400">dari Rp {{ number_format($budget->amount, 0, ',', '.') }}</p>
                                    </div>
                                    <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Hapus anggaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all opacity-100 sm:opacity-0 group-hover/item:opacity-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="relative pt-1">
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                        <span class="text-[10px] font-black inline-block py-1 px-2.5 uppercase rounded-lg {{ $budget->percentage > 90 ? 'text-rose-600 bg-rose-100 dark:bg-rose-900/30' : ($budget->percentage > 75 ? 'text-amber-600 bg-amber-100 dark:bg-amber-900/30' : 'text-blue-600 bg-blue-100 dark:bg-blue-900/30') }}">
                                            {{ number_format($budget->percentage, 0) }}%
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 italic">
                                            Sisa: Rp {{ number_format($budget->remaining, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-slate-100 dark:bg-slate-800 shadow-inner">
                                    <div style="width:{{ min($budget->percentage, 100) }}%" 
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center transition-all duration-1000 ease-out {{ $budget->percentage > 90 ? 'bg-gradient-to-r from-rose-500 to-pink-500' : ($budget->percentage > 75 ? 'bg-gradient-to-r from-amber-400 to-orange-500' : 'bg-gradient-to-r from-blue-500 to-indigo-600') }}"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 rounded-3xl flex items-center justify-center mb-6 shadow-inner">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">Belum Ada Anggaran</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400 max-w-[280px] mb-8">Tetapkan batas pengeluaran bulan ini agar keuangan Anda tetap terkontrol dengan baik.</p>
                            <button @click="$dispatch('open-modal', 'set-budget')" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition hover:scale-105 active:scale-95">
                                Mulai Atur Sekarang
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Bills / Planning -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 transition-colors flex flex-col relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 dark:bg-amber-500/10 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-amber-500/10 transition-colors"></div>
                
                <div class="flex flex-col mb-8 gap-4 relative z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Rencana Pembayaran
                        </h3>
                        <button @click="$dispatch('open-modal', 'add-bill')" class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-amber-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                @if($totalUnpaidBills > 0)
                <div class="mb-6 relative z-10">
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-100 dark:border-amber-900/30 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest">Belum Dibayar</p>
                            <p class="text-lg font-black text-amber-700 dark:text-amber-300">Rp {{ number_format($totalUnpaidBills, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-amber-500 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
                @endif

                <div class="space-y-4 flex-1 relative z-10 overflow-y-auto max-h-[350px] pr-1 custom-scrollbar">
                    @forelse($bills as $bill)
                        <div class="flex items-center gap-3 p-3 rounded-xl border {{ $bill->is_paid ? 'bg-slate-50/50 dark:bg-slate-800/20 border-transparent opacity-60' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 shadow-sm' }} group/bill transition-all">
                            <form action="{{ route('bills.toggle', $bill) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-6 h-6 rounded-lg border-2 flex items-center justify-center transition-all {{ $bill->is_paid ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-200 dark:border-slate-600 hover:border-emerald-500' }}">
                                    @if($bill->is_paid)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </button>
                            </form>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold truncate {{ $bill->is_paid ? 'text-slate-400 line-through' : 'text-slate-800 dark:text-slate-100' }}">{{ $bill->name }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <p class="text-[10px] font-black {{ $bill->is_paid ? 'text-slate-300' : 'text-slate-500 dark:text-slate-400' }}">Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
                                    @if($bill->due_date)
                                        <span class="text-[10px] text-slate-400">•</span>
                                        <p class="text-[10px] font-medium text-slate-400">{{ $bill->due_date->format('d M') }}</p>
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('bills.destroy', $bill) }}" method="POST" onsubmit="return confirm('Hapus rencana ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-300 hover:text-rose-500 transition-colors opacity-0 group-hover/bill:opacity-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800/50 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-xs font-bold text-slate-400">Belum ada rencana pengeluaran bulan ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 transition-colors flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Arus Kas</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Rasio pemasukan & pengeluaran</p>
                </div>
                
                @if($totalIncome > 0 || $totalExpense > 0)
                    <div class="relative flex-1 flex items-center justify-center" style="min-height: 250px;">
                        <canvas id="cashflowChart"></canvas>
                        <!-- Center text in doughnut -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none pb-12">
                            <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest">Sisa Dana</span>
                            <span class="text-lg sm:text-xl font-black {{ $balance >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-red-600 dark:text-red-400' }}">Rp {{ number_format(abs($balance), 0, ',', '.') }}</span>
                        </div>
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center py-10">
                        <p class="text-sm text-slate-500 dark:text-slate-400 italic text-center">Belum ada data untuk grafik bulan ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="overflow-hidden app-surface app-page-section" style="--app-enter-delay: 0.4s">
            <div class="px-5 sm:px-8 py-5 sm:py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-base sm:text-lg font-black text-slate-800 dark:text-slate-100 leading-tight">Transaksi Terakhir</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Aktivitas keuangan terbaru</p>
                </div>
                <a href="{{ route('transactions.index') }}" class="text-[10px] sm:text-xs font-black text-blue-600 hover:text-blue-700 dark:text-blue-400 uppercase tracking-widest transition-colors">Lihat Semua &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full hidden sm:table">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-800/30">
                            <th class="px-5 sm:px-8 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Deskripsi</th>
                            <th class="px-5 sm:px-8 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Metode</th>
                            <th class="px-5 sm:px-8 py-4 text-right text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($recentTransactions as $trx)
                        <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-5 sm:px-8 py-4 sm:py-5">
                                <p class="text-sm font-black text-slate-800 dark:text-slate-200 leading-tight">{{ $trx->description }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">{{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('d M Y') }}</p>
                            </td>
                            <td class="px-5 sm:px-8 py-4 sm:py-5 whitespace-nowrap">
                                <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-400">
                                    @if($trx->payments->count() > 1)
                                        <span class="text-blue-500">Combo ({{ $trx->payments->count() }})</span>
                                    @else
                                        {{ $trx->paymentMethod?->name ?? '---' }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-5 sm:px-8 py-4 sm:py-5 whitespace-nowrap text-right text-sm font-black {{ $trx->type == 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-xs mx-auto">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-slate-400">Belum ada transaksi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile List Recent -->
                <div class="sm:hidden divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recentTransactions as $trx)
                    <div class="p-5 flex items-center justify-between group active:bg-slate-50 dark:active:bg-slate-800/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg">
                                {{ ['Bank' => '🏦', 'E-Wallet' => '📱', 'Cash' => '💵'][$trx->paymentMethod?->category?->name] ?? '💰' }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800 dark:text-slate-200 leading-tight">{{ Str::limit($trx->description, 20) }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">{{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('d M') }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-black {{ $trx->type == 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </p>
                    </div>
                    @empty
                        <div class="p-12 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">Kosong</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @if($totalIncome > 0 || $totalExpense > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initChart = () => {
                const canvas = document.getElementById('cashflowChart');
                if (!canvas) return;
                
                const ctx = canvas.getContext('2d');
                const isDarkMode = document.documentElement.classList.contains('dark');
                
                const chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pemasukan', 'Pengeluaran'],
                        datasets: [{
                            data: [{{ $totalIncome ?: 0 }}, {{ $totalExpense ?: 0 }}],
                            backgroundColor: [
                                'rgba(37, 99, 235, 0.9)',
                                'rgba(220, 38, 38, 0.9)'
                            ],
                            borderWidth: 4,
                            borderColor: isDarkMode ? '#0f172a' : '#ffffff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 750,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    color: isDarkMode ? '#cbd5e1' : '#64748b',
                                    font: {
                                        family: "'Inter', sans-serif",
                                        size: 13,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: isDarkMode ? '#1e293b' : '#ffffff',
                                titleColor: isDarkMode ? '#ffffff' : '#0f172a',
                                bodyColor: isDarkMode ? '#cbd5e1' : '#475569',
                                borderColor: isDarkMode ? '#334155' : '#e2e8f0',
                                borderWidth: 1,
                                padding: 12,
                                boxPadding: 6,
                                callbacks: {
                                    label: function(context) {
                                        return ' Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    }
                                }
                            }
                        },
                        cutout: '70%',
                        layout: {
                            padding: 10
                        }
                    }
                });

                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === "class") {
                            const isDark = document.documentElement.classList.contains('dark');
                            chart.options.plugins.legend.labels.color = isDark ? '#cbd5e1' : '#64748b';
                            chart.data.datasets[0].borderColor = isDark ? '#0f172a' : '#ffffff';
                            chart.options.plugins.tooltip.backgroundColor = isDark ? '#1e293b' : '#ffffff';
                            chart.options.plugins.tooltip.titleColor = isDark ? '#ffffff' : '#0f172a';
                            chart.options.plugins.tooltip.bodyColor = isDark ? '#cbd5e1' : '#475569';
                            chart.options.plugins.tooltip.borderColor = isDark ? '#334155' : '#e2e8f0';
                            chart.update('none'); // Update without animation for theme toggle
                        }
                    });
                });
                observer.observe(document.documentElement, { attributes: true });
            };

            // Wait for Chart.js to load if it hasn't yet
            if (typeof Chart === 'undefined') {
                const script = document.querySelector('script[src*="chart.js"]');
                script.addEventListener('load', initChart);
            } else {
                initChart();
            }
        }, { once: true });
    </script>
    @endif

    @push('modals')
    <!-- Modal Atur Anggaran -->
    <x-modal name="set-budget" focusable>
        <form method="POST" action="{{ route('budgets.store') }}" data-no-animate="true" class="bg-white dark:bg-slate-900 p-8 rounded-3xl transition-colors relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
            @csrf
            <div class="mb-8">
                <h2 class="text-2xl font-black text-slate-800 dark:text-slate-100">Atur Anggaran</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Tentukan batas pengeluaran bulan ini.</p>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <x-input-label for="budget_payment_category_id" value="Pilih Kategori" class="font-bold text-slate-700 dark:text-slate-300" />
                    <select name="payment_category_id" id="budget_payment_category_id" class="app-field w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl font-bold text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <x-input-label for="budget_amount_field" value="Limit Anggaran" class="font-bold text-slate-700 dark:text-slate-300" />
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 font-bold sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="amount" id="budget_amount_field" class="app-field w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl font-bold text-lg text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" placeholder="0" required />
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row sm:justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center items-center rounded-xl px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                    Batal
                </button>
                <button type="submit" class="inline-flex justify-center items-center rounded-xl bg-blue-600 px-8 py-3 text-sm font-black text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                    Simpan Anggaran
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Tambah Tagihan -->
    <x-modal name="add-bill" focusable>
        <form method="POST" action="{{ route('bills.store') }}" data-no-animate="true" class="bg-white dark:bg-slate-900 p-8 rounded-3xl transition-colors relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-500 to-orange-600"></div>
            @csrf
            <div class="mb-8">
                <h2 class="text-2xl font-black text-slate-800 dark:text-slate-100">Tambah Rencana</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Buat pengingat pembayaran atau rencana belanja.</p>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <x-input-label for="bill_name" value="Nama Tagihan / Rencana" class="font-bold text-slate-700 dark:text-slate-300" />
                    <input type="text" name="name" id="bill_name" class="app-field w-full pl-4 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl font-bold text-slate-800 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" placeholder="Contoh: Bayar Kos, Internet, dll" required />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <x-input-label for="bill_amount" value="Nominal" class="font-bold text-slate-700 dark:text-slate-300" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-400 font-bold sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="amount" id="bill_amount" class="app-field w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl font-bold text-lg text-slate-800 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" placeholder="0" required />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="bill_due_date" value="Tanggal Jatuh Tempo" class="font-bold text-slate-700 dark:text-slate-300" />
                        <input type="date" name="due_date" id="bill_due_date" class="app-field w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl font-bold text-slate-800 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all" />
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row sm:justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center items-center rounded-xl px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                    Batal
                </button>
                <button type="submit" class="inline-flex justify-center items-center rounded-xl bg-amber-600 px-8 py-3 text-sm font-black text-white shadow-lg shadow-amber-900/20 transition hover:bg-amber-700 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-amber-500/50">
                    Simpan Rencana
                </button>
            </div>
        </form>
    </x-modal>
    @endpush
</x-app-layout>
