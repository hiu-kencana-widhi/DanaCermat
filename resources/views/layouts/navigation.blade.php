@php
    $user = Auth::user();

    if ($user->is_admin) {
        $navigationLinks = [
            [
                'label' => __('Dashboard Admin'),
                'short_label' => __('Dashboard'),
                'description' => __('Ringkasan performa aplikasi dan aktivitas terbaru.'),
                'href' => route('admin.dashboard'),
                'active' => request()->routeIs('admin.dashboard'),
                'icon' => 'dashboard',
            ],
            [
                'label' => __('Kategori Utama'),
                'short_label' => __('Kategori'),
                'description' => __('Kelola kategori utama agar struktur pembayaran tetap rapi.'),
                'href' => route('admin.payment-categories.index'),
                'active' => request()->routeIs('admin.payment-categories.*'),
                'icon' => 'layers',
            ],
            [
                'label' => __('Metode Spesifik'),
                'short_label' => __('Metode'),
                'description' => __('Atur metode pembayaran yang tampil untuk setiap kategori.'),
                'href' => route('admin.payment-methods.index'),
                'active' => request()->routeIs('admin.payment-methods.*'),
                'icon' => 'wallet',
            ],
            [
                'label' => __('Kelola User'),
                'short_label' => __('User'),
                'description' => __('Pantau data pengguna dan akses mereka dari panel admin.'),
                'href' => route('admin.users.index'),
                'active' => request()->routeIs('admin.users.*'),
                'icon' => 'users',
            ],
        ];
    } else {
        $navigationLinks = [
            [
                'label' => __('Dashboard'),
                'short_label' => __('Dashboard'),
                'description' => __('Lihat ringkasan keuangan dan progres terbaru Anda.'),
                'href' => route('dashboard'),
                'active' => request()->routeIs('dashboard'),
                'icon' => 'dashboard',
            ],
            [
                'label' => __('Transaksi'),
                'short_label' => __('Transaksi'),
                'description' => __('Kelola catatan pemasukan dan pengeluaran dalam satu tempat.'),
                'href' => route('transactions.index'),
                'active' => request()->routeIs('transactions.*'),
                'icon' => 'transactions',
            ],
            [
                'label' => __('Laporan Keuangan'),
                'short_label' => __('Laporan'),
                'description' => __('Download laporan keuangan dalam format PDF.'),
                'href' => route('reports.index'),
                'active' => request()->routeIs('reports.*'),
                'icon' => 'document-text',
            ],
        ];
    }

    $activeLink = collect($navigationLinks)->firstWhere('active', true) ?? $navigationLinks[0];
    $homeRoute = $user->is_admin ? route('admin.dashboard') : route('dashboard');
    $roleLabel = $user->is_admin ? __('Administrator') : __('Pengguna');
    $navigationCount = count($navigationLinks);
    $nameParts = collect(preg_split('/\s+/', trim($user->name)))->filter();
    $userInitials = $nameParts->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('');
    $userInitials = $userInitials !== '' ? $userInitials : strtoupper(substr($user->name, 0, 1));
@endphp

<nav x-data="{ open: false, isDark: document.documentElement.classList.contains('dark') }" 
     x-effect="if (open) { document.body.style.overflow = 'hidden'; } else { document.body.style.overflow = ''; }"
     class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-lg sm:backdrop-blur-xl border-b border-slate-200 dark:bg-slate-900/80 dark:border-slate-800 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Mobile Menu Button (Left) -->
                <div class="flex items-center sm:hidden mr-4">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 transition-all duration-200 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="shrink-0 flex items-center">
                    <a href="{{ $homeRoute }}" class="flex items-center gap-3 group">
                        <x-application-logo class="h-9 w-auto max-w-[120px] shrink-0 drop-shadow-sm transition-transform group-hover:scale-110 duration-300" />
                        <div class="flex flex-col">
                            <span class="font-black text-base text-slate-900 dark:text-white tracking-tight leading-none">{{ $user->name }}</span>
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent mt-1 leading-none">DanaCermat</span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-12 sm:flex">
                    @foreach($navigationLinks as $link)
                        <a href="{{ $link['href'] }}" 
                           @if(isset($link['trigger'])) @click.prevent="$dispatch('{{ $link['trigger'] }}', '{{ $link['modal_name'] }}')" @endif
                           class="inline-flex items-center px-1 pt-1 border-b-[3px] text-sm font-bold transition duration-200 ease-in-out {{ $link['active'] ? 'border-blue-600 text-slate-900 dark:text-white dark:border-blue-400' : 'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300 dark:text-slate-400 dark:hover:text-white dark:hover:border-slate-700' }}">
                            {{ $link['short_label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center ml-6 gap-2">
                <!-- Theme Toggle Button -->
                <button @click="isDark = !isDark; if(isDark) { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); } else { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); }" class="p-2 rounded-full text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-800 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <!-- Sun Icon -->
                    <svg x-show="isDark" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <!-- Moon Icon -->
                    <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>

                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:border-slate-600 focus:outline-none transition duration-150 ease-in-out gap-2">
                                <div class="hidden md:block">{{ $user->name }}</div>

                                <div class="ml-1 hidden md:block">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-xs text-slate-400 border-b border-slate-100 uppercase tracking-wider font-semibold">
                                {{ $roleLabel }}
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="text-red-600 hover:bg-red-50">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

            </div>

        </div>
    </div>

    <!-- Mobile Sidebar (Off-canvas) -->
    <template x-teleport="body">
        <div>
            <!-- Backdrop -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="open = false"
                 class="fixed inset-0 z-[60] bg-slate-900/40 sm:hidden"
                 x-cloak>
            </div>

            <!-- Sidebar -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 z-[70] w-[280px] bg-white dark:bg-slate-900 shadow-2xl sm:hidden flex flex-col"
                 x-cloak>
                
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-8 w-auto max-w-[100px] drop-shadow-sm shrink-0" />
                        <span class="font-black text-slate-900 dark:text-white tracking-tight uppercase text-xs truncate max-w-[150px]">Halo, {{ explode(' ', $user->name)[0] }}</span>
                    </div>
                    <button @click="open = false" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Sidebar Body (Links) -->
                <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                    @foreach($navigationLinks as $link)
                        <a href="{{ $link['href'] }}" 
                           @if(isset($link['trigger'])) @click.prevent="$dispatch('{{ $link['trigger'] }}', '{{ $link['modal_name'] }}')" @endif
                           class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all {{ $link['active'] ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20 font-black' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 font-bold' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $link['active'] ? 'bg-white/20' : 'bg-slate-100 dark:bg-slate-800' }}">
                                @if($link['short_label'] == 'Dashboard')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                @elseif($link['short_label'] == 'Transaksi')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                @elseif($link['short_label'] == 'Laporan')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>
                            <span class="text-sm">{{ $link['short_label'] }}</span>
                        </a>
                    @endforeach

                </div>

                <!-- Sidebar Footer (User) -->
                <div class="p-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="relative">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-600 dark:text-white font-black text-sm shadow-sm">
                                {{ $userInitials }}
                            </span>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white dark:border-slate-900 rounded-full"></div>
                        </div>
                        <div class="min-w-0">
                            <div class="font-black text-slate-900 dark:text-white leading-none truncate text-sm">{{ $user->name }}</div>
                            <div class="font-bold text-[10px] text-slate-400 dark:text-slate-500 mt-1 truncate">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[13px] font-bold text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800 shadow-sm transition-all border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Profil</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 rounded-xl text-[13px] font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all border border-transparent hover:border-rose-100 dark:hover:border-rose-900/30 text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>
</nav>
