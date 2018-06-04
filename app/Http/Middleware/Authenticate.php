<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = false)
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$role || $user->is($role)) {
            return $next($request);
        }

        return redirect(url($user->is('superadmin') ? 'super-admin' : $user->role));

    }
}
