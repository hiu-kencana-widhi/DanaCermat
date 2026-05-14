@php
    $flashType = session('success') ? 'success' : (session('error') ? 'error' : null);
    $flashMessage = session('success') ?? session('error');
@endphp

@if ($flashType && $flashMessage)
    <div 
        id="app-flash"
        class="fixed inset-x-0 {{ $offset ?? 'top-6' }} z-[100] flex justify-center px-4 pointer-events-none"
        style="animation: app-flash-in 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;"
    >
        <div class="relative flex w-full max-w-lg items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-2xl pointer-events-auto dark:bg-slate-900 dark:border-slate-800" role="{{ $flashType === 'error' ? 'alert' : 'status' }}">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $flashType === 'success' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400' }}">
                @if ($flashType === 'success')
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                @else
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18A2 2 0 003.53 21h16.94a2 2 0 001.71-3l-8.47-14.14a2 2 0 00-3.42 0z"/></svg>
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $flashMessage }}</p>
            </div>

            <button type="button" onclick="document.getElementById('app-flash').remove()" class="h-8 w-8 text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <script>setTimeout(() => document.getElementById('app-flash')?.remove(), 4000);</script>
    </div>
@endif
