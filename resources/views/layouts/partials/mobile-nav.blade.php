@php
    $user = Auth::user();

    if ($user->is_admin) {
        $navigationLinks = [
            [
                'label' => __('Dashboard'),
                'href' => route('admin.dashboard'),
                'active' => request()->routeIs('admin.dashboard'),
                'icon' => 'dashboard',
            ],
            [
                'label' => __('Kategori'),
                'href' => route('admin.payment-categories.index'),
                'active' => request()->routeIs('admin.payment-categories.*'),
                'icon' => 'layers',
            ],
            [
                'label' => __('Metode'),
                'href' => route('admin.payment-methods.index'),
                'active' => request()->routeIs('admin.payment-methods.*'),
                'icon' => 'wallet',
            ],
            [
                'label' => __('User'),
                'href' => route('admin.users.index'),
                'active' => request()->routeIs('admin.users.*'),
                'icon' => 'users',
            ],
        ];
    } else {
        $navigationLinks = [
            [
                'label' => __('Dashboard'),
                'href' => route('dashboard'),
                'active' => request()->routeIs('dashboard'),
                'icon' => 'dashboard',
            ],
            [
                'label' => __('Transaksi'),
                'href' => route('transactions.index'),
                'active' => request()->routeIs('transactions.*'),
                'icon' => 'transactions',
            ],
            [
                'label' => __('Laporan'),
                'href' => route('reports.index'),
                'active' => request()->routeIs('reports.*'),
                'icon' => 'document-text',
            ],
            [
                'label' => __('Profil'),
                'href' => route('profile.edit'),
                'active' => request()->routeIs('profile.*'),
                'icon' => 'users',
            ],
        ];
    }
@endphp

<!-- Mobile Bottom Navigation -->
<div class="sm:hidden fixed bottom-0 left-0 right-0 z-50 mobile-nav-glass pb-[env(safe-area-inset-bottom)]">
    <div class="flex items-center justify-around h-20 px-2">
        @foreach($navigationLinks as $link)
            <a href="{{ $link['href'] }}" class="mobile-nav-item flex-1 {{ $link['active'] ? 'is-active' : 'text-slate-400 dark:text-slate-500' }}">
                <div class="relative">
                    <x-nav-icon :name="$link['icon']" class="w-6 h-6 {{ $link['active'] ? 'scale-110' : '' }}" />
                    @if($link['active'])
                         <div class="absolute -top-1 -right-1 w-2 h-2 bg-blue-500 rounded-full border-2 border-white dark:border-slate-950"></div>
                    @endif
                </div>
                <span class="text-[10px] font-black uppercase tracking-tighter">{{ $link['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>

<!-- Floating Action Button for User (Quick Add Transaction) -->
@if(!$user->is_admin && !request()->routeIs('transactions.create'))
<a href="{{ route('transactions.create') }}" class="app-fab sm:hidden">
    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
    </svg>
</a>
@endif
