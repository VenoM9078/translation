<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StorePaginationInSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('limit')) {
            session(['limit' => $request->limit]);
        }

        if ($request->has('page')) {
            session(['page' => $request->page]);
        }
        return $next($request);
    }
}
