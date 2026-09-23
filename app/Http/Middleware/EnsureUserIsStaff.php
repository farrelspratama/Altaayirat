<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ( ! $request->user() || ! in_array($request->user()->role, ['admin', 'penjual'])) { 
            abort(403, 'Akses ditolak: Halaman ini khusus untuk staff.');
        }

        return $next($request);
    }
}
