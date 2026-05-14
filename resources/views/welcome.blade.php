<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="DanaCermat - Platform cerdas dan elegan untuk mencatat, mengelola, dan menganalisis arus kas keuangan pribadi dan bisnis Anda.">

        <title>{{ config('app.name', 'DanaCermat') }} - Kelola Keuangan Lebih Cerdas</title>
        
        <link rel="icon" type="image/png" href="{{ asset('image/logo-DanaCermat.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('image/logo-DanaCermat.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <style>
            [x-cloak] { display: none !important; }
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: rgba(100, 116, 139, 0.2); border-radius: 9999px; }
            ::-webkit-scrollbar-thumb:hover { background: rgba(100, 116, 139, 0.4); }
            .dark ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); }
            .dark ::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
        </style>

        <script>
            // Mencegah FOUC (Flash of Unstyled Content)
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 dark:text-slate-200 bg-slate-50 dark:bg-[#020617] selection:bg-indigo-500/20 selection:text-indigo-900 dark:selection:bg-indigo-400/20 dark:selection:text-white min-h-screen flex flex-col transition-colors duration-300 overflow-x-hidden" x-data="{ isDark: document.documentElement.classList.contains('dark'), scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        
        <!-- Premium Glassmorphism Navigation -->
        <nav :class="scrolled ? 'bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800/80 shadow-sm' : 'bg-transparent border-transparent'" class="sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Brand Logo -->
                    <a href="/" class="flex items-center gap-3 group">
                        <x-application-logo class="h-10 sm:h-11 w-auto max-w-[140px] shrink-0 drop-shadow transition-transform group-hover:scale-105 duration-300" />
                        <div class="flex flex-col">
                            <span class="font-black text-xl bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-200 bg-clip-text text-transparent tracking-tight leading-none">DanaCermat</span>
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent mt-1 leading-none">Catatan Keuangan</span>
                        </div>
                    </a>

                    <!-- Nav Actions -->
                    <div class="flex items-center gap-3 sm:gap-4">
                        <!-- Theme Toggle Button -->
                        <button @click="isDark = !isDark; if(isDark) { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); } else { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); }" class="p-2.5 rounded-xl border border-slate-200/80 bg-white/50 text-slate-500 hover:text-slate-800 hover:bg-white dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-900 transition-all shadow-sm focus:outline-none" aria-label="Toggle Theme">
                            <svg x-show="isDark" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <svg x-show="!isDark" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </button>

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                                    <span>Dashboard Akun</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                                    Masuk
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                                        Daftar Gratis
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section with Premium Orbs -->
        <header class="relative overflow-hidden pt-12 pb-20 sm:pb-32 lg:pt-20">
            <!-- Background Orbs -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-r from-blue-500/10 to-indigo-500/10 dark:from-blue-600/10 dark:to-indigo-600/10 blur-[120px] rounded-full"></div>
                <div class="absolute top-20 -left-20 w-[400px] h-[400px] bg-emerald-500/5 dark:bg-emerald-500/5 blur-[100px] rounded-full"></div>
                <div class="absolute top-40 -right-20 w-[400px] h-[400px] bg-violet-500/5 dark:bg-violet-500/5 blur-[100px] rounded-full"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-4xl mx-auto">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs sm:text-sm font-bold bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm text-slate-700 dark:text-slate-300 mb-8 animate-pulse duration-1000">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                        <span>Platform Keuangan & Arus Kas Cerdas 2026</span>
                    </div>
                    
                    <!-- Main Heading -->
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-900 dark:text-white leading-[1.1] mb-8">
                        Kelola Keuangan Anda Lebih <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 dark:from-blue-400 dark:via-indigo-400 dark:to-violet-400 bg-clip-text text-transparent">Cerdas, Cermat & Rapi</span>
                    </h1>
                    
                    <!-- Subtitle -->
                    <p class="text-base sm:text-xl text-slate-600 dark:text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                        Tinggalkan cara lama yang memusingkan. Pantau setiap pemasukan, alokasikan anggaran bulanan, dan raih kebebasan finansial dengan antarmuka yang dirancang khusus untuk kenyamanan maksimal.
                    </p>

                    <!-- Call To Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-4 text-base font-bold text-white shadow-xl shadow-indigo-500/25 hover:shadow-2xl hover:shadow-indigo-500/35 hover:-translate-y-1 transition-all group">
                                <span>Buka Dashboard Keuangan</span>
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-4 text-base font-bold text-white shadow-xl shadow-indigo-500/25 hover:shadow-2xl hover:shadow-indigo-500/35 hover:-translate-y-1 transition-all group">
                                <span>Mulai Akun Gratis</span>
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="#fitur" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 px-8 py-4 text-base font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-all">
                                Pelajari Fitur
                            </a>
                        @endauth
                    </div>

                    <!-- Trust Indicators -->
                    <div class="mt-12 flex flex-wrap items-center justify-center gap-6 sm:gap-12 text-slate-400 dark:text-slate-500 text-sm font-bold border-t border-slate-200/60 dark:border-slate-800/60 pt-8">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>100% Enkripsi Aman</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <span>Performa Super Cepat</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Ekspor Laporan PDF Sekali Klik</span>
                        </div>
                    </div>
                </div>

                <!-- Interactive Live Mockup Widget (Demonstrasi Interaktif) -->
                <div class="mt-16 sm:mt-24">
                    <div class="text-center mb-6">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">Coba Klik Tab di Bawah Ini — Simulasi Jurnal Langsung</span>
                    </div>

                    <div x-data="{
                        tab: 'all',
                        balance: 15850000,
                        transactions: [
                            { id: 1, desc: 'Penerimaan Pendapatan Proyek', cat: 'Pemasukan Utama', method: 'Transfer Bank', type: 'in', amount: 12500000, date: 'Hari ini' },
                            { id: 2, desc: 'Pembayaran Lisensi Software', cat: 'Operasional', method: 'Kartu Kredit', type: 'out', amount: 1200000, date: 'Kemarin' },
                            { id: 3, desc: 'Tagihan Internet & Listrik Kantor', cat: 'Utilitas', method: 'e-Wallet', type: 'out', amount: 850000, date: '12 Mei' },
                            { id: 4, desc: 'Pencairan Keuntungan Investasi', cat: 'Pemasukan Ekstra', method: 'Transfer Bank', type: 'in', amount: 5400000, date: '10 Mei' }
                        ],
                        get filtered() {
                            if (this.tab === 'in') return this.transactions.filter(t => t.type === 'in');
                            if (this.tab === 'out') return this.transactions.filter(t => t.type === 'out');
                            return this.transactions;
                        }
                    }" class="w-full max-w-4xl mx-auto rounded-[2.5rem] bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-2xl overflow-hidden transition-all duration-300">
                        
                        <!-- Mockup App Header -->
                        <div class="p-6 sm:p-8 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Saldo Terpantau</span>
                                <div class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                                    Rp <span x-text="balance.toLocaleString('id-ID')">15.850.000</span>
                                </div>
                            </div>

                            <!-- Tabs Selector -->
                            <div class="flex p-1.5 bg-slate-200/60 dark:bg-slate-800 rounded-xl gap-1 w-full sm:w-auto">
                                <button @click="tab = 'all'" :class="tab === 'all' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm font-bold' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white'" class="flex-1 sm:flex-none px-4 py-2 rounded-lg text-xs transition-all">Semua</button>
                                <button @click="tab = 'in'" :class="tab === 'in' ? 'bg-emerald-500 text-white shadow-sm font-bold' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white'" class="flex-1 sm:flex-none px-4 py-2 rounded-lg text-xs transition-all">Pemasukan</button>
                                <button @click="tab = 'out'" :class="tab === 'out' ? 'bg-rose-500 text-white shadow-sm font-bold' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white'" class="flex-1 sm:flex-none px-4 py-2 rounded-lg text-xs transition-all">Pengeluaran</button>
                            </div>
                        </div>

                        <!-- Mockup Transactions List -->
                        <div class="p-2 sm:p-4 divide-y divide-slate-100 dark:divide-slate-800/60">
                            <template x-for="item in filtered" :key="item.id">
                                <div class="p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/80 dark:hover:bg-slate-800/30 rounded-2xl transition-all">
                                    <div class="flex items-center gap-4">
                                        <div :class="item.type === 'in' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400' : 'bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400'" class="h-12 w-12 rounded-xl flex items-center justify-center font-bold text-sm shrink-0">
                                            <svg x-show="item.type === 'in'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                            <svg x-show="item.type === 'out'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 dark:text-white truncate text-sm sm:text-base" x-text="item.desc"></div>
                                            <div class="flex items-center gap-2 mt-1 flex-wrap">
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-text="item.cat"></span>
                                                <span class="text-slate-300 dark:text-slate-700">•</span>
                                                <span class="text-[11px] text-slate-500 dark:text-slate-400" x-text="item.method"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0 ml-4">
                                        <div :class="item.type === 'in' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'" class="font-black text-sm sm:text-base">
                                            <span x-text="item.type === 'in' ? '+' : '-'"></span>Rp <span x-text="item.amount.toLocaleString('id-ID')"></span>
                                        </div>
                                        <div class="text-[11px] text-slate-400 font-medium mt-0.5" x-text="item.date"></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Mockup Footer -->
                        <div class="p-4 bg-slate-50 dark:bg-slate-950 text-center border-t border-slate-100 dark:border-slate-800">
                            <span class="text-xs text-slate-400 dark:text-slate-500 font-bold">✨ Rasakan kecepatan tanpa reload di dashboard asli DanaCermat</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Bento Grid Features Section -->
        <section id="fitur" class="py-20 sm:py-32 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-24">
                    <h2 class="text-xs font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400 mb-3">Keunggulan Eksklusif</h2>
                    <p class="text-3xl sm:text-5xl font-black tracking-tight text-slate-900 dark:text-white">
                        Dirancang untuk Efisiensi & Kejelasan Tingkat Tinggi
                    </p>
                </div>

                <!-- Bento Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <!-- Card 1: Main Feature (Span 2) -->
                    <div class="md:col-span-2 bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 sm:p-12 border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between relative overflow-hidden group">
                        <!-- Decorative Blob -->
                        <div class="absolute -right-20 -bottom-20 w-60 h-60 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        
                        <div>
                            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 mb-8">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight mb-4">Pencatatan Rinci Multi-Metode</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg max-w-xl">
                                Mendukung pembayaran dari berbagai metode dalam satu transaksi. Pisahkan pengeluaran tunai, transfer bank, hingga e-wallet secara akurat tanpa pencatatan berulang.
                            </p>
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center gap-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">Kategori Fleksibel</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">Metode Kustom</span>
                        </div>
                    </div>

                    <!-- Card 2: Analytics -->
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 sm:p-10 border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="h-14 w-14 rounded-2xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-8">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight mb-3">Analisis Arus Kas Real-time</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm sm:text-base">
                                Identifikasi tren belanja Anda dengan representasi data ringkas. Ketahui langsung pos mana yang paling menyedot anggaran setiap bulannya.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Budgets -->
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 sm:p-10 border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="h-14 w-14 rounded-2xl bg-purple-500/10 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-8">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight mb-3">Proteksi Anggaran Bulanan</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm sm:text-base">
                                Pasang pengingat batas anggaran per bulan. DanaCermat membantu Anda mencegah pengeluaran impulsif sebelum melewati ambang batas.
                            </p>
                        </div>
                    </div>

                    <!-- Card 4: Reports Export (Span 2) -->
                    <div class="md:col-span-2 bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 sm:p-10 border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-8">
                        <div>
                            <div class="h-14 w-14 rounded-2xl bg-rose-500/10 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-center mb-6">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight mb-2">Cetak Laporan PDF Siap Saji</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm sm:text-base max-w-lg">
                                Download seluruh rekaman keuangan Anda berdasarkan rentang tanggal yang dikustomisasi. Hasil ekspor diformat rapi standar laporan profesional.
                            </p>
                        </div>
                        <div class="shrink-0 w-full sm:w-auto">
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-100 dark:border-slate-800 text-center">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">Format Output</span>
                                <span class="text-lg font-black text-rose-500">PDF Document</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Live Statistics Panel Banner -->
        <section class="py-12 bg-indigo-600 dark:bg-indigo-950/40 relative overflow-hidden my-12">
            <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">99.9%</div>
                        <div class="text-indigo-100 dark:text-indigo-300 text-xs sm:text-sm font-bold mt-1">Uptime Server</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">&lt; 50ms</div>
                        <div class="text-indigo-100 dark:text-indigo-300 text-xs sm:text-sm font-bold mt-1">Kecepatan Transisi</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">100%</div>
                        <div class="text-indigo-100 dark:text-indigo-300 text-xs sm:text-sm font-bold mt-1">Privasi Enkripsi</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">0 Biaya</div>
                        <div class="text-indigo-100 dark:text-indigo-300 text-xs sm:text-sm font-bold mt-1">Tanpa Langganan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section (Accordion) -->
        <section class="py-20 sm:py-32 relative z-10">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 dark:text-white">Pertanyaan Sering Diajukan</h2>
                    <p class="text-slate-600 dark:text-slate-400 mt-3">Jawaban ringkas untuk keraguan Anda</p>
                </div>

                <div x-data="{ active: null }" class="space-y-4">
                    <!-- FAQ 1 -->
                    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 overflow-hidden transition-all">
                        <button @click="active = (active === 1 ? null : 1)" class="w-full px-6 py-5 text-left font-bold text-slate-900 dark:text-white flex justify-between items-center gap-4 focus:outline-none">
                            <span>Apakah data keuangan saya aman di sistem ini?</span>
                            <svg :class="active === 1 ? 'rotate-180' : ''" class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="active === 1" x-collapse x-cloak>
                            <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 text-sm leading-relaxed border-t border-slate-50 dark:border-slate-800/50 pt-3">
                                Sangat aman. Kami memprioritaskan privasi Anda menggunakan proteksi otentikasi standar industri. Data keuangan sepenuhnya menjadi milik Anda dan tidak dibagikan ke pihak ketiga mana pun.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 overflow-hidden transition-all">
                        <button @click="active = (active === 2 ? null : 2)" class="w-full px-6 py-5 text-left font-bold text-slate-900 dark:text-white flex justify-between items-center gap-4 focus:outline-none">
                            <span>Apakah DanaCermat berbayar?</span>
                            <svg :class="active === 2 ? 'rotate-180' : ''" class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="active === 2" x-collapse x-cloak>
                            <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 text-sm leading-relaxed border-t border-slate-50 dark:border-slate-800/50 pt-3">
                                Tidak. Anda dapat menggunakan seluruh fitur unggulan DanaCermat secara gratis untuk mencatat transaksi harian, mengelola kategori, hingga mencetak laporan PDF.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 overflow-hidden transition-all">
                        <button @click="active = (active === 3 ? null : 3)" class="w-full px-6 py-5 text-left font-bold text-slate-900 dark:text-white flex justify-between items-center gap-4 focus:outline-none">
                            <span>Bagaimana cara mencetak laporan PDF?</span>
                            <svg :class="active === 3 ? 'rotate-180' : ''" class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="active === 3" x-collapse x-cloak>
                            <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 text-sm leading-relaxed border-t border-slate-50 dark:border-slate-800/50 pt-3">
                                Setelah Anda login, masuk ke menu <strong>Laporan Keuangan</strong> di navigasi atas. Tentukan rentang tanggal yang Anda inginkan, lalu klik tombol cetak. Sistem akan otomatis menyusun PDF dengan ringkasan lengkap yang langsung terunduh.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final Call to Action Section -->
        <section class="py-16 sm:py-24 relative z-10">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-[3rem] bg-gradient-to-br from-blue-600 to-indigo-600 p-8 sm:p-16 text-center text-white shadow-2xl shadow-indigo-500/25 relative overflow-hidden">
                    <!-- Orbs inside CTA -->
                    <div class="absolute -top-24 -right-24 w-60 h-60 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                    <div class="absolute -bottom-24 -left-24 w-60 h-60 bg-black/10 rounded-full blur-xl pointer-events-none"></div>

                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight mb-4 relative z-10">
                        Siap Memegang Kendali Penuh?
                    </h2>
                    <p class="text-indigo-100 text-base sm:text-lg mb-10 max-w-xl mx-auto relative z-10">
                        Bergabunglah dan jadikan setiap rupiah Anda terhitung dengan cermat. Proses pendaftaran hanya memakan waktu kurang dari 30 detik.
                    </p>

                    <div class="relative z-10">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-8 py-4 text-base font-black text-indigo-600 shadow-xl hover:bg-slate-50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                                Mulai Pencatatan Cermat Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-8 py-4 text-base font-black text-indigo-600 shadow-xl hover:bg-slate-50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                                Masuk ke Portal
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Beautiful Modern Footer -->
        <footer class="border-t border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 mt-auto py-12 transition-colors duration-300 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
                    <!-- Brand info -->
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-8 w-auto max-w-[100px] drop-shadow-sm shrink-0" />
                        <span class="font-bold text-slate-900 dark:text-white tracking-tight">DanaCermat</span>
                    </div>

                    <!-- Links / Info -->
                    <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                        Didukung oleh arsitektur <span class="text-slate-700 dark:text-slate-300 font-bold">DanaCermat</span>. Dirancang untuk keandalan maksimal.
                    </div>

                    <!-- Copyright -->
                    <div class="text-xs text-slate-400 dark:text-slate-500 font-bold">
                        &copy; {{ date('Y') }} DanaCermat. Hak Cipta Dilindungi. <span class="watermark-hiu font-extrabold text-blue-600 dark:text-blue-400 ml-1 tracking-wider">ByHiu</span>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Tamper-Proof Guardian Watermark -->
        <script>
            (() => {
                const ensureWatermark = () => {
                    document.querySelectorAll('.watermark-hiu').forEach(el => {
                        if (el.textContent.trim() !== 'ByHiu') {
                            el.textContent = 'ByHiu';
                        }
                        const style = window.getComputedStyle(el);
                        if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') {
                            el.style.setProperty('display', 'inline', 'important');
                            el.style.setProperty('visibility', 'visible', 'important');
                            el.style.setProperty('opacity', '1', 'important');
                        }
                    });
                };
                ensureWatermark();
                const observer = new MutationObserver((mutations) => {
                    let shouldRestore = false;
                    mutations.forEach(m => {
                        if (m.type === 'childList') {
                            m.removedNodes.forEach(n => {
                                if (n.classList && n.classList.contains('watermark-hiu')) shouldRestore = true;
                                if (n.querySelector && n.querySelector('.watermark-hiu')) shouldRestore = true;
                            });
                        }
                        if (m.target && m.target.classList && m.target.classList.contains('watermark-hiu')) {
                            shouldRestore = true;
                        }
                    });
                    if (shouldRestore) {
                        observer.disconnect();
                        ensureWatermark();
                        setTimeout(() => observer.observe(document.body, { childList: true, subtree: true, characterData: true, attributes: true, attributeFilter: ['style', 'class'] }), 0);
                    }
                });
                window.addEventListener('DOMContentLoaded', () => {
                    ensureWatermark();
                    observer.observe(document.body, { childList: true, subtree: true, characterData: true, attributes: true, attributeFilter: ['style', 'class'] });
                });
                setInterval(ensureWatermark, 2000);
            })();
        </script>
    </body>
</html>
