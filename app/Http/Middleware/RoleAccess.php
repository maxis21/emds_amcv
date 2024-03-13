<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  ...$roles
     * @return mixed
     */

    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect(route('to.Login'))->with('error', 'You must be logged in to access this page.');
        }

        $userRoles = Auth::user()->role->role->name ?? null;

        if ($userRoles && in_array($userRoles, $roles)){
            return $next($request);
        }

        $message = 'You do not have permission to access this page.';
        return redirect(route('to.Login'))->with('error', $message);
    }
}
