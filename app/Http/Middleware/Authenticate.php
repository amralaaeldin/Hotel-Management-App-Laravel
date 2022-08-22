<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $prefix = explode('/', $request->getRequestUri())[1];
            if (in_array($prefix, ['manager', 'receptionist'])) {
                $prefix = 'staff';
            }
            return route($prefix.'.login');
        }
    }
}
