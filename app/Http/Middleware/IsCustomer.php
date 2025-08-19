<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;

class IsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        // If not logged in, or logged in as anything but a customer, throws 403 Unauthorized
        if (!auth()->check() || !auth()->user()->isCustomer()) {
            return response()->view('unauthorized', [], 403);
        }

        return $next($request);
    }
}
