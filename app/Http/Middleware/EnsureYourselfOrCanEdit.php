<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureYourselfOrCanEdit
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
        $url = explode('/', $request->getRequestUri());
        $reqRole = rtrim($url[1], "s");
        $role = Auth::guard('web')->user()?->getRoleNames()[0] ?? (Auth::guard('client')->check() ? 'client' : null);
        $id = Auth::guard('web')->user()?->id ?? Auth::guard('client')->user()?->id;
        $reqId = $url[2];

        if (in_array($role, ['admin']) && $reqRole === 'manager') {
            return $next($request);
        }

        if (in_array($role, ['admin', 'manager']) && $reqRole === 'receptionist') {
            return $next($request);
        }

        if (($reqRole === $role && $reqId == $id)) {
            return $next($request);
        }

        abort(403);
    }
}
