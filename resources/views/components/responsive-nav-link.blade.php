@props(['active'])

@php
    $isActive = $active ?? false;
    $classes = $isActive
                ? 'group flex w-full items-center justify-between gap-4 rounded-[1.75rem] border border-slate-900 bg-slate-900 px-5 py-4 text-start shadow-lg shadow-slate-900/15 transition duration-200 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-cyan-500/40 dark:border-white dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100'
                : 'group flex w-full items-center justify-between gap-4 rounded-[1.75rem] border border-slate-200/70 bg-slate-50/85 px-5 py-4 text-start transition duration-200 hover:border-slate-300 hover:bg-white hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/40 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-100 dark:hover:border-slate-700 dark:hover:bg-slate-900';

    $titleClasses = $isActive
                ? 'text-base font-bold text-white dark:text-slate-900'
                : 'text-base font-semibold text-slate-800 dark:text-slate-100';

    $description = $isActive ? __('Halaman yang sedang dibuka') : __('Ketuk untuk membuka menu ini');
    $descriptionClasses = $isActive
                ? 'mt-1 block text-xs font-medium text-white/70 dark:text-slate-500'
                : 'mt-1 block text-xs font-medium text-slate-500 dark:text-slate-400';

    $iconClasses = $isActive
                ? 'inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-white dark:bg-slate-900/10 dark:text-slate-900'
                : 'inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-slate-500 shadow-sm ring-1 ring-slate-200/70 dark:bg-slate-950 dark:text-slate-300 dark:ring-slate-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="min-w-0">
        <span class="block truncate {{ $titleClasses }}">{{ $slot }}</span>
        <span class="{{ $descriptionClasses }}">{{ $description }}</span>
    </span>

    <span class="{{ $iconClasses }}">
        <svg class="h-5 w-5 transition duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </span>
</a>
