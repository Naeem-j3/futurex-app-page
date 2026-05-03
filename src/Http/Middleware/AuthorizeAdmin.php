<?php

namespace FutureX\AppPage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthorizeAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        $allowedEmails = config('app-page.allowed_emails', []);

        if (!in_array($user->email, $allowedEmails)) {
            abort(403);
        }

        return $next($request);
    }
}
