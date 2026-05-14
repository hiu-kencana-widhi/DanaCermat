<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex w-full sm:w-auto items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
