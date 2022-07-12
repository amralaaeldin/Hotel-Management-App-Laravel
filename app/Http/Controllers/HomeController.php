<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function redirect () {
        if(Auth::guard('web')->check()) {
            return redirect()->route(Auth()->user()->getRoleNames()[0].'.dashboard');
        }
    }
}
