<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pengecekan 1: Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Pengecekan 2: Pastikan user adalah admin
        if (Auth::user()->is_admin) {
            return $next($request); // Izinkan masuk
        }

        // Jika user biasa mencoba masuk rute admin, lempar kembali ke dashboard-nya
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman administrator.');
    }
}