<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureYourself
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
        // get the affected role from url
        $url = explode('/', $request->getRequestUri());
        $reqRole = rtrim($url[1], "s");
        // get the affected id
        $reqId = $url[2];
        // get the authenticated user role
        $role = Auth::guard('web')->user()?->getRoleNames()[0] ?? (Auth::guard('client')->check() ? 'client' : null);
        // get the authenticated user id
        $id = Auth::guard('web')->user()?->id ?? Auth::guard('client')->user()?->id;

        // check if the role is admin or manager, or if the user will affect himself
        if (in_array($role, ['admin', 'manager']) || ($reqRole === $role && $reqId == $id)) {
            return $next($request);
        }

        abort(403);
    }
}
