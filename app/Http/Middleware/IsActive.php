<?php

namespace App\Http\Middleware;

use App\Models\WebIdentity;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $webIdentity = WebIdentity::first();

        if ($webIdentity && !empty($webIdentity->status)) {
            if ($webIdentity->status === 'active') {
                return $next($request);
            } else {
                return redirect('/maintenance');
            }
        }
        return redirect('/maintenance');
    }
}
