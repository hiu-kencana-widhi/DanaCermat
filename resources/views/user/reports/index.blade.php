<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">Laporan Keuangan</p>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">Export Data PDF</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Pilih rentang waktu dan jenis transaksi untuk diunduh.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ 
        startDate: '{{ now()->startOfMonth()->format('Y-m-d') }}',
        endDate: '{{ now()->endOfMonth()->format('Y-m-d') }}',
        period: 'this_month',
        type: '',
        typeName: 'Semua Transaksi',
        showPeriodList: false,
        showTypeList: false,
        setToday() {
            const today = '{{ now()->format('Y-m-d') }}';
            this.startDate = today;
            this.endDate = today;
            this.period = 'today';
            this.showPeriodList = false;
        },
        setThisWeek() {
            this.startDate = '{{ now()->startOfWeek()->format('Y-m-d') }}';
            this.endDate = '{{ now()->endOfWeek()->format('Y-m-d') }}';
            this.period = 'this_week';
            this.showPeriodList = false;
        },
        setThisMonth() {
            this.startDate = '{{ now()->startOfMonth()->format('Y-m-d') }}';
            this.endDate = '{{ now()->endOfMonth()->format('Y-m-d') }}';
            this.period = 'this_month';
            this.showPeriodList = false;
        },
        setType(val, name) {
            this.type = val;
            this.typeName = name;
            this.showTypeList = false;
        }
    }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/50 dark:bg-slate-900/50 sm:backdrop-blur-xl border border-slate-200 dark:border-slate-800 shadow-xl rounded-[2.5rem] overflow-hidden transition-[background-color,border-color,box-shadow] duration-300">
                <div class="p-8 sm:p-12">
                    <div class="flex items-center gap-6 mb-10 pb-10 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-16 h-16 rounded-[1.5rem] bg-blue-600 shadow-xl shadow-blue-500/20 flex items-center justify-center text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white leading-tight">Konfigurasi Laporan</h3>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-1">Kustomisasi output sesuai kebutuhan Anda</p>
                        </div>
                    </div>

                    <form action="{{ route('transactions.export') }}" method="GET" class="space-y-10">
                        <!-- Quick Select Dropdown -->
                        <div class="space-y-4">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1">Pilih Cepat Rentang Waktu</label>
                            <div class="relative">
                                <div @click="showPeriodList = !showPeriodList" 
                                     class="app-field !py-4 !rounded-2xl flex items-center justify-between cursor-pointer group transition-all"
                                     :class="showPeriodList ? 'ring-2 ring-blue-500/20 border-blue-500' : ''">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <span class="font-bold text-slate-700 dark:text-slate-200" x-text="period === 'today' ? 'Hari Ini' : (period === 'this_week' ? 'Minggu Ini' : 'Bulan Ini')"></span>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>

                                <!-- Dropdown List -->
                                <div x-show="showPeriodList" 
                                     @click.away="showPeriodList = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl overflow-hidden">
                                    <div class="p-2 space-y-1">
                                        <div @click="setToday()" 
                                             class="px-4 py-3 rounded-xl text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer flex items-center justify-between transition-colors"
                                             :class="period === 'today' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300'">
                                            <span>Hari Ini</span>
                                            <svg x-show="period === 'today'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                        </div>
                                        <div @click="setThisWeek()" 
                                             class="px-4 py-3 rounded-xl text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer flex items-center justify-between transition-colors"
                                             :class="period === 'this_week' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300'">
                                            <span>Minggu Ini</span>
                                            <svg x-show="period === 'this_week'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                        </div>
                                        <div @click="setThisMonth()" 
                                             class="px-4 py-3 rounded-xl text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer flex items-center justify-between transition-colors"
                                             :class="period === 'this_month' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300'">
                                            <span>Bulan Ini</span>
                                            <svg x-show="period === 'this_month'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Dates -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1">Dari Tanggal</label>
                                <div class="relative">
                                    <input type="date" name="start_date" x-model="startDate" class="app-field !py-4 !rounded-2xl">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1">Sampai Tanggal</label>
                                <div class="relative">
                                    <input type="date" name="end_date" x-model="endDate" class="app-field !py-4 !rounded-2xl">
                                </div>
                            </div>
                        </div>

                        <!-- Type Selector Dropdown -->
                        <div class="space-y-4">
                            <label class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1">Jenis Transaksi</label>
                            <div class="relative">
                                <input type="hidden" name="type" :value="type">
                                <div @click="showTypeList = !showTypeList" 
                                     class="app-field !py-4 !rounded-2xl flex items-center justify-between cursor-pointer group transition-all"
                                     :class="showTypeList ? 'ring-2 ring-blue-500/20 border-blue-500' : ''">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-lg"
                                             :class="type === '' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600' : (type === 'income' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600' : 'bg-rose-50 dark:bg-rose-900/30 text-rose-600')">
                                            <span x-text="type === '' ? '📊' : (type === 'income' ? '💰' : '💸')"></span>
                                        </div>
                                        <span class="font-bold text-slate-700 dark:text-slate-200" x-text="typeName"></span>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>

                                <!-- Dropdown List -->
                                <div x-show="showTypeList" 
                                     @click.away="showTypeList = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl overflow-hidden">
                                    <div class="p-2 space-y-1">
                                        <div @click="setType('', 'Semua Transaksi')" 
                                             class="px-4 py-3 rounded-xl text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer flex items-center justify-between transition-colors"
                                             :class="type === '' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300'">
                                            <div class="flex items-center gap-3">
                                                <span>📊</span>
                                                <span>Semua Transaksi</span>
                                            </div>
                                            <svg x-show="type === ''" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                        </div>
                                        <div @click="setType('income', 'Pemasukan Saja')" 
                                             class="px-4 py-3 rounded-xl text-sm hover:bg-emerald-50 dark:hover:bg-emerald-900/20 cursor-pointer flex items-center justify-between transition-colors"
                                             :class="type === 'income' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 font-bold' : 'text-slate-700 dark:text-slate-300'">
                                            <div class="flex items-center gap-3">
                                                <span>💰</span>
                                                <span>Pemasukan Saja</span>
                                            </div>
                                            <svg x-show="type === 'income'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                        </div>
                                        <div @click="setType('expense', 'Pengeluaran Saja')" 
                                             class="px-4 py-3 rounded-xl text-sm hover:bg-rose-50 dark:hover:bg-rose-900/20 cursor-pointer flex items-center justify-between transition-colors"
                                             :class="type === 'expense' ? 'bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 font-bold' : 'text-slate-700 dark:text-slate-300'">
                                            <div class="flex items-center gap-3">
                                                <span>💸</span>
                                                <span>Pengeluaran Saja</span>
                                            </div>
                                            <svg x-show="type === 'expense'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full sm:w-auto px-10 py-5 rounded-[1.5rem] bg-blue-600 text-white text-lg font-black shadow-2xl shadow-blue-900/40 hover:bg-blue-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Download Laporan PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hint Card -->
            <div class="mt-8 p-6 bg-slate-900 dark:bg-blue-600/10 text-white dark:text-blue-100 rounded-[1.5rem] flex items-start gap-4 shadow-xl shadow-slate-900/20 dark:shadow-none border border-transparent dark:border-blue-500/20 app-page-section" style="--app-enter-delay: 0.2s">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 dark:text-blue-300 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold">Tips Laporan</h4>
                    <p class="text-sm text-slate-400 dark:text-blue-200/60 mt-1">Gunakan fitur ini untuk merekap pengeluaran Anda. File PDF yang diunduh akan berisi ringkasan total dan detail per transaksi secara terperinci.</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action*="export"]');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault(); // Stop normal submission
                    
                    // Show global loader (manually trigger because we stopped default)
                    // We need to use dispatch because 'loading' is on the parent div
                    window.dispatchEvent(new CustomEvent('show-loader')); 
                    // Wait, app.blade.php doesn't have show-loader yet, let's just use the fact that submit.window triggers it
                    // But we prevented default!
                    // So we should just set loading = true if we can.
                    
                    // Let's add @show-loader.window="loading = true" to app.blade.php
                    
                    const formData = new FormData(form);
                    const params = new URLSearchParams(formData);
                    const url = `${form.action}?${params.toString()}`;

                    try {
                        const response = await fetch(url);
                        if (!response.ok) throw new Error('Download failed');
                        
                        const blob = await response.blob();
                        const downloadUrl = window.URL.createObjectURL(blob);
                        
                        // Extract filename from header if possible, or use default
                        const contentDisposition = response.headers.get('Content-Disposition');
                        let fileName = 'Laporan_Keuangan.pdf';
                        if (contentDisposition && contentDisposition.indexOf('filename=') !== -1) {
                            fileName = contentDisposition.split('filename=')[1].replaceAll('"', '');
                        }

                        const a = document.createElement('a');
                        a.href = downloadUrl;
                        a.download = fileName;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(downloadUrl);
                    } catch (error) {
                        console.error(error);
                        alert('Gagal mengunduh laporan. Silakan coba lagi.');
                    } finally {
                        // Instant hide
                        window.dispatchEvent(new CustomEvent('hide-loader'));
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
