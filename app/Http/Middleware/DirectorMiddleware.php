<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DirectorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role !== "director") {
            if (auth()->user()->role !== 'director') {
                abort(403);
            }

            return redirect('director/dashboard');
        }

        return $next($request);
    }
}
