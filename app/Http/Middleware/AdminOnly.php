<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    private const ADMIN_EMAIL = 'reach@gmail.com';

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->email !== self::ADMIN_EMAIL) {
            return redirect()
                ->route('user.home')
                ->with('error', 'You are not allowed to access admin pages.');
        }

        return $next($request);
    }
}
