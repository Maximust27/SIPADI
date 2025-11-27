<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Ambil role user saat ini dari database
        $userRole = Auth::user()->role;

        // 3. Logika Pengecekan:
        // Jika role user SAMA dengan yang diminta di route, silakan lewat.
        if ($userRole == $role) {
            return $next($request);
        }

        // PENGECUALIAN KHUSUS (Superuser Logic): 
        // Jika halaman 'kader' diakses oleh 'admin', perbolehkan.
        // (Admin bisa melihat apa yang dilihat Kader)
        if ($role == 'kader' && $userRole == 'admin') {
            return $next($request);
        }

        // 4. Jika role tidak cocok, tolak akses (Error 403 Forbidden)
        abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
    }
}