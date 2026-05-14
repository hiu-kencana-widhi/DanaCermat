<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">{{ __('Profile') }}</p>
            <div>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">{{ __('Pengaturan Akun') }}</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Perbarui informasi akun, kata sandi, dan pengaturan keamanan Anda.') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 sm:p-10 transition-colors">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 sm:p-10 transition-colors">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-red-100 dark:border-red-900/30 shadow-sm rounded-2xl p-6 sm:p-10 transition-colors">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
