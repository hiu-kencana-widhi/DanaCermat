<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-extrabold leading-tight text-slate-800 dark:text-slate-100 transition-colors">
                Dashboard Admin
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 transition-colors">
                Ringkasan performa aplikasi, user, dan transaksi.
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Stats -->
        <div class="grid grid-cols-2 gap-4 md:grid-cols-2 xl:grid-cols-4 app-page-section" style="--app-enter-delay: 0.1s">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between transition-colors relative overflow-hidden group hover:shadow-md hover:-translate-y-1">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] sm:text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">User</p>
                    <p class="mt-1 text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-slate-100">{{ number_format($totalUsers) }}</p>
                </div>
                <div class="relative z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center mt-3 sm:mt-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between transition-colors relative overflow-hidden group hover:shadow-md hover:-translate-y-1">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 dark:bg-indigo-900/20 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] sm:text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Transaksi</p>
                    <p class="mt-1 text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-slate-100">{{ number_format($totalTransactions) }}</p>
                </div>
                <div class="relative z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400 flex items-center justify-center mt-3 sm:mt-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between transition-colors relative overflow-hidden group hover:shadow-md hover:-translate-y-1">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 dark:bg-green-900/20 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] sm:text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pemasukan</p>
                    <p class="mt-1 text-lg sm:text-2xl font-extrabold text-green-600 dark:text-green-400 truncate max-w-[120px] sm:max-w-none">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="relative z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400 flex items-center justify-center mt-3 sm:mt-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between transition-colors relative overflow-hidden group hover:shadow-md hover:-translate-y-1">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-50 dark:bg-red-900/20 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] sm:text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengeluaran</p>
                    <p class="mt-1 text-lg sm:text-2xl font-extrabold text-red-600 dark:text-red-400 truncate max-w-[120px] sm:max-w-none">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                <div class="relative z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400 flex items-center justify-center mt-3 sm:mt-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 app-page-section" style="--app-enter-delay: 0.25s">
            <!-- System Overview Chart -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Ringkasan Sistem</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Perbandingan total uang masuk dan keluar dari seluruh pengguna.</p>
                    </div>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="systemOverviewChart"></canvas>
                </div>
            </div>

            <!-- Recent Users -->
            <section class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl overflow-hidden transition-colors flex flex-col app-page-section" style="--app-enter-delay: 0.4s">
                <div class="border-b border-slate-100 dark:border-slate-800 px-6 py-5 bg-white dark:bg-slate-900 transition-colors">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">User Terbaru</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Pendaftar baru di sistem.</p>
                </div>

                <div class="flex-1 overflow-y-auto p-2">
                    <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($recentUsers as $user)
                            <li class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-xl transition-colors flex items-center justify-between group cursor-default">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800 dark:text-slate-200">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-md">{{ optional($user->created_at)->diffForHumans() }}</span>
                            </li>
                        @empty
                            <li class="p-6 text-center text-slate-500 dark:text-slate-400 italic">Belum ada user terbaru.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                    <a href="{{ route('admin.users.index') }}" class="block w-full text-center text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">Kelola Semua User &rarr;</a>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('systemOverviewChart').getContext('2d');
            const isDarkMode = document.documentElement.classList.contains('dark');
            const textColor = isDarkMode ? '#cbd5e1' : '#64748b'; 
            const gridColor = isDarkMode ? '#1e293b' : '#f1f5f9';

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        label: 'Total Nominal (Rp)',
                        data: [{{ $totalIncome ?: 0 }}, {{ $totalExpense ?: 0 }}],
                        backgroundColor: [
                            'rgba(22, 163, 74, 0.8)', // Green for income
                            'rgba(220, 38, 38, 0.8)'  // Red for expense
                        ],
                        borderRadius: 8,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor, drawBorder: false },
                            ticks: { 
                                color: textColor,
                                callback: function(value) {
                                    if(value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                    if(value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { color: textColor, font: { weight: '600' } }
                        }
                    }
                }
            });

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === "class") {
                        const isDark = document.documentElement.classList.contains('dark');
                        chart.options.scales.x.ticks.color = isDark ? '#cbd5e1' : '#64748b';
                        chart.options.scales.y.ticks.color = isDark ? '#cbd5e1' : '#64748b';
                        chart.options.scales.y.grid.color = isDark ? '#1e293b' : '#f1f5f9';
                        chart.update();
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
        });
    </script>
</x-app-layout>
