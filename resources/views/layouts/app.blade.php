<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#020617">
        <meta name="color-scheme" content="dark light">

        <title>{{ config('app.name', 'DanaCermat') }}</title>

        <!-- Preconnect & DNS-Prefetch -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        
        <link rel="icon" type="image/png" href="{{ asset('image/logo-DanaCermat.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('image/logo-DanaCermat.png') }}">

        <!-- Preload Critical Assets -->
        <link rel="preload" as="style" href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" />
        <link rel="stylesheet" href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" media="print" onload="this.media='all'" />
        
        <style>
            [x-cloak] { display: none !important; }
            html { background-color: #020617; }
            html:not(.dark) { background-color: #f8fafc; }
            .app-no-fouc { opacity: 0; }
            .app-ready { opacity: 1; transition: opacity 0.3s ease-out; }
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

    <body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-blue-500/20 selection:text-blue-900 dark:bg-[#020617] dark:text-slate-100 dark:selection:bg-blue-400/20 dark:selection:text-slate-100 transition-colors duration-200 min-h-[100dvh] overflow-x-hidden flex flex-col app-no-fouc">
        <script>window.addEventListener('DOMContentLoaded', () => document.body.classList.replace('app-no-fouc', 'app-ready'));</script>
        
        <div class="app-page-shell relative min-h-screen flex flex-col z-10">
            @include('layouts.navigation')
            @include('layouts.partials.flash', ['offset' => 'top-[5rem]'])

            @isset($header)
                <header class="bg-white border-b border-slate-200 dark:bg-slate-900 dark:border-slate-800 transition-colors duration-200">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 w-full pb-8 sm:pb-16 pt-8 app-page-section">
                {{ $slot }}
            </main>

            <!-- Footer Watermark -->
            <footer class="w-full py-6 mt-auto border-t border-slate-200 dark:border-slate-800 text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} DanaCermat. Hak Cipta Dilindungi. <span class="watermark-hiu font-extrabold text-blue-600 dark:text-blue-400 ml-1 tracking-wider">ByHiu</span>
            </footer>
        </div>
        @stack('modals')
        @stack('scripts')

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
