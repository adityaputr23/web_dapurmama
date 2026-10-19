<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses panel admin.');
        }

        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
