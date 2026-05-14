<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#020617">
        <meta name="color-scheme" content="dark light">

        <title>{{ config('app.name', 'DanaCermat') }}</title>
        
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        
        <link rel="icon" type="image/png" href="{{ asset('image/logo-DanaCermat.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('image/logo-DanaCermat.png') }}">

        <link rel="preload" as="style" href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" />
        <link rel="stylesheet" href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" media="print" onload="this.media='all'" />

        <style>
            [x-cloak] { display: none !important; }
            html { background-color: #020617; }
            html:not(.dark) { background-color: #f8fafc; }
            .app-no-fouc { opacity: 0; }
            .app-ready { opacity: 1; transition: opacity 0.5s ease-out; }
        </style>

        <script>
            (function() {
                const theme = localStorage.getItem('color-theme') || 
                             (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                if (theme === 'dark') document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-blue-500/20 selection:text-blue-900 dark:bg-[#020617] dark:text-slate-100 transition-colors duration-200 app-no-fouc">
        <script>window.addEventListener('DOMContentLoaded', () => document.body.classList.replace('app-no-fouc', 'app-ready'));</script>

        <div class="app-page-shell relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-4 py-8 sm:px-6">
            <div class="absolute top-4 right-4 z-50" x-data="{ isDark: document.documentElement.classList.contains('dark') }">
                <button @click="isDark = !isDark; if(isDark) { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); } else { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); }" class="p-2.5 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:text-white transition-all shadow-sm">
                    <svg x-show="isDark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="!isDark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>

            @include('layouts.partials.flash')

            <div class="relative z-10 w-full flex flex-col items-center justify-center">
                <div class="app-page-section mb-8 flex flex-col items-center text-center">
                    <a href="/" class="block transition-transform hover:scale-105 duration-300">
                        <x-application-logo class="w-24 sm:w-28 h-auto max-w-[140px] mx-auto drop-shadow-md" />
                    </a>
                    <p class="mt-6 text-[10px] font-black uppercase tracking-[0.3em] text-blue-600 dark:text-blue-400">
                        DANACERMAT
                    </p>
                </div>

                <div class="app-page-section w-full max-w-md rounded-[2.5rem] app-surface p-10" style="--app-enter-delay: 0.1s">
                    {{ $slot }}
                </div>

                <!-- Footer Watermark -->
                <div class="mt-8 text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                    &copy; {{ date('Y') }} DanaCermat. Hak Cipta Dilindungi. <span class="watermark-hiu font-extrabold text-blue-600 dark:text-blue-400 ml-1 tracking-wider">ByHiu</span>
                </div>
            </div>
        </div>

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
