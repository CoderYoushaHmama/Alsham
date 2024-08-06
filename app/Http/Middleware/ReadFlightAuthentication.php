<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadFlightAuthentication
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
        $user = Auth::guard('user')->user();

        foreach ($user->employee->roles as $role) {
            if ($role->name == 'admin' || $role->name == 'manage flight' || $role->name == 'read flight') {
                return $next($request);
            }
        }

        return error('some thing went wrong', 'you dont have authentication', 502);
    }
}