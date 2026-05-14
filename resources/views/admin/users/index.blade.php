<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">Admin Panel</p>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">Manajemen User</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Kelola akun pengguna, pantau aktivitas, dan atur hak akses dengan mudah.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                + Tambah User Baru
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
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">User</th>
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Email</th>
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                                <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-slate-900">
                            @forelse($users as $user)
                                <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="font-bold text-slate-900 dark:text-slate-100">{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-300">{{ $user->email }}</td>
                                    <td class="px-6 py-5 text-sm">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" data-confirm="User ini akan dihapus secara permanen. Lanjutkan?" data-confirm-title="Hapus User?" data-confirm-button="Ya, Hapus">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="font-bold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm italic text-slate-500 dark:text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            Belum ada user yang terdaftar.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile view -->
                <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">
                    @forelse($users as $user)
                        <div class="p-5 space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $user->name }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <div class="flex items-center gap-4 text-sm font-bold">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" data-confirm="Hapus user ini?">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-sm italic text-slate-500 dark:text-slate-400">Belum ada user.</div>
                    @endforelse
                </div>

                <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
