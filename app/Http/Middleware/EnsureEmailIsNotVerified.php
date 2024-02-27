<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsNotVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null): Response
    {
        if ($request->user()
            && ($request->user()->hasVerifiedEmail() || !is_null($request->user()->email_verified_at))
        ) {
            return $request->expectsJson()
                ? abort(403, 'Your email address is verified.')
                : Redirect::guest(URL::route($redirectToRoute ?: 'home'));
        }

        return $next($request);
    }
}
