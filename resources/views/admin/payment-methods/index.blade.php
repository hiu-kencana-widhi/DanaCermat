<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">Admin Panel</p>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">Metode Pembayaran</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Kelola sub-kategori spesifik untuk membantu pengguna mengkategorikan transaksi mereka.</p>
            </div>
            <a href="{{ route('admin.payment-methods.create') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                + Tambah Metode
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl overflow-hidden transition-colors app-page-section" style="--app-enter-delay: 0.1s">
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/80">
                            <tr>
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Nama Metode</th>
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kategori Induk</th>
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Urutan</th>
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-slate-900">
                            @forelse($paymentMethods as $method)
                                <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50 group">
                                    <td class="px-6 py-5 whitespace-nowrap text-base font-bold text-slate-900 dark:text-slate-100">{{ $method->name }}</td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-slate-600 dark:text-slate-300">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">
                                            {{ $method->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $method->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm font-bold text-slate-500 dark:text-slate-400">{{ $method->sort_order }}</td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('admin.payment-methods.edit', $method) }}" class="font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">Edit</a>
                                            <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="inline" data-confirm="Metode ini akan dihapus secara permanen. Lanjutkan?" data-confirm-title="Hapus Metode?" data-confirm-button="Ya, Hapus">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-bold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm italic text-slate-500 dark:text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            Belum ada metode pembayaran.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">
                    @forelse($paymentMethods as $method)
                        <div class="p-5 space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $method->name }}</p>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $method->category->name ?? 'N/A' }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $method->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                    {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4 text-sm font-bold border-t border-slate-100 dark:border-slate-800 pt-3">
                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 transition-colors">Edit</a>
                                <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="inline" data-confirm="Hapus metode ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-sm italic text-slate-500 dark:text-slate-400">Belum ada metode pembayaran.</div>
                    @endforelse
                </div>

                <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                    {{ $paymentMethods->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
