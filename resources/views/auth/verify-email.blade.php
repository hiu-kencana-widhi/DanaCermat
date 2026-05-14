<x-guest-layout>
    <div class="mb-4 text-sm text-slate-500 dark:text-slate-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-200">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}" data-submit-intent="logout" data-submit-label="Keluar dari akun" data-submit-subtitle="Sesi Anda sedang ditutup dengan aman.">
            @csrf

            <button type="submit" class="rounded-md text-sm text-cyan-600 underline transition hover:text-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500/40 focus:ring-offset-2 focus:ring-offset-white dark:text-cyan-400 dark:hover:text-cyan-300 dark:focus:ring-offset-slate-950">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
