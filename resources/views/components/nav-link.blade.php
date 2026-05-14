@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center justify-center rounded-full border border-slate-900 bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-slate-900/10 transition duration-200 hover:-translate-y-0.5 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-cyan-500/40 focus:ring-offset-2 focus:ring-offset-white dark:border-white dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100 dark:focus:ring-offset-slate-950'
            : 'inline-flex items-center justify-center rounded-full border border-transparent px-4 py-2.5 text-sm font-medium text-slate-600 transition duration-200 hover:-translate-y-0.5 hover:border-slate-200 hover:bg-white hover:text-slate-900 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/40 focus:ring-offset-2 focus:ring-offset-white dark:text-slate-300 dark:hover:border-slate-800 dark:hover:bg-slate-900 dark:hover:text-white dark:focus:ring-offset-slate-950';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
