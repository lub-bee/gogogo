<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRank
{
    /**
     * Handle an incoming request.
     *
     * The middleware accepts a variadic list of allowed ranks.
     * If the authenticated user's rank matches any of them, the request proceeds.
     * Otherwise, a 403 is returned.
     *
     * Usage in routes: ->middleware('rank:admin,support')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$ranks): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasRank(...$ranks)) {
            abort(403, 'Insufficient rank.');
        }

        return $next($request);
    }
}
