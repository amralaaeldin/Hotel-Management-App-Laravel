<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->client()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->client()->sendEmailVerificationNotification();

        return back()->with('success', 'verification-link-sent');
    }

    public function fire()
    {
        if (!Auth::guard('client')->user()->hasVerifiedEmail()) {
            Auth::guard('client')->user()->sendEmailVerificationNotification();
            return back()->with('success', 'verification-link-sent');
        } else {
            return back()->with('success', 'You did verify your email');
        }
    }

    public function notice()
    {
        return redirect('rooms')->with('fail', 'Your email must be verified before making a reservation');
    }

}
