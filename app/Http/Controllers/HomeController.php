<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private function getPrefix()
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user()->getRoleNames()[0];
        }

        if (Auth::guard('client')->check()) {
            return 'client';
        }
    }

    public function redirect()
    {
        return redirect()->route($this->getPrefix() . '.dashboard');
    }

}
