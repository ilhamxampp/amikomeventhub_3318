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
        // 1. Cek apakah user sudah login, dan apakah role-nya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Jika benar admin, izinkan akses ke halaman berikutnya
        }

        // 2. Jika bukan admin, tendang/redirect kembali ke halaman login dengan pesan error
        return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki hak akses untuk masuk ke halaman Administrator.');
    }
}