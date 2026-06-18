<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login DAN role-nya adalah 'admin', silakan lewat
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tendang kembali ke dashboard pelanggan
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
    }
}