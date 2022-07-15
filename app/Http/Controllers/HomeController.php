<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function redirect () {
        if(Auth::guard('web')->check()) {
            $prefix = Auth::guard('web')->user()->getRoleNames()[0];
            if (in_array($prefix, ['manager', 'receptionist'])) {
                $prefix = 'stuff';
            }
            return redirect()->route($prefix.'.dashboard');
        }

        if(Auth::guard('client')->check()) {
            return redirect()->route('client.dashboard');
        }
    }
}
