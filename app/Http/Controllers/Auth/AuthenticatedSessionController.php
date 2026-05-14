<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Mengarahkan admin ke panel khusus
        if ($request->user()->is_admin) {
            return redirect()
                ->intended(route('admin.dashboard', absolute: false))
                ->with('success', 'Selamat datang kembali. Panel Anda sudah siap.');
        }

        // Mengarahkan pengguna reguler ke dashboard biasa
        return redirect()
            ->intended(route('dashboard', absolute: false))
            ->with('success', 'Selamat datang kembali. Dashboard Anda sudah siap.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout. Sampai jumpa lagi.');
    }
}
