<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Jika user sedang login, jangan cache halamannya.
        // Ini mencegah browser menyimpan snapshot halaman sensitif (seperti dashboard)
        // yang bisa diakses kembali hanya dengan tombol 'Back' setelah logout.
        if (Auth::check() && method_exists($response, 'header')) {
            $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                     ->header('Pragma', 'no-cache')
                     ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }

        return $response;
    }
}
