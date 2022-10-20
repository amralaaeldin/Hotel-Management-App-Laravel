<?php

namespace App\Http\Controllers\ClientAuth;

use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.client.register', ['countries' => countries()]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'min:11', 'numeric'],
            'country' => ['required', Rule::in(array_keys(countries()))],
            'avatar' => ['required', 'image'],
            'gender' => ['required', 'in:M,F'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $client = Client::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'country' => $request->country,
            'avatar' => $request->file('avatar')->store('avatars/clients'),
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($client));

        Auth::guard('client')->login($client);

        return redirect(RouteServiceProvider::HOME);
    }
}
