<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-2xl border border-red-600 bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-600/20 transition duration-200 hover:-translate-y-0.5 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/40 focus:ring-offset-2 focus:ring-offset-white active:translate-y-0 dark:border-red-500 dark:bg-red-500 dark:hover:bg-red-400 dark:focus:ring-offset-slate-950']) }}>
    {{ $slot }}
</button>
