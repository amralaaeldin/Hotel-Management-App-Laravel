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
        if (!$request->expectsJson()) {
            $prefix = rtrim(explode('/', $request->getRequestUri())[1], "s");
            switch ($prefix) {
                case in_array($prefix, ['manager', 'receptionist']):
                    $prefix = 'staff';
                    break;
                case 'reservation':
                    $prefix = 'client';
                    break;
            }
            return route($prefix . '.login');
        }
    }
}
