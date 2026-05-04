<?php

namespace FutureX\AppPage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthorizeAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('filament.app-page.auth.login');
        }

        $allowedEmails = config('app-page.allowed_emails', []);

        if (!in_array(auth()->user()->email, $allowedEmails)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
