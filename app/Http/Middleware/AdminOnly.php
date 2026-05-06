<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user login dan role-nya admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika tidak admin, redirect ke homepage dengan error
        if (auth()->check()) {
            // User sudah login tapi bukan admin
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // User belum login, redirect ke Filament login page
        return redirect('/admin/login');
    }
}
