<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.stuff.register', ['roles' => Role::all()->whereNotIn('name', ['admin'])->pluck('name')]);
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
            'national_id' => ['required', 'digits:14'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'avatar' => ['image'],
            'role' => ['required', Rule::in(Role::all()->whereNotIn('name', ['admin'])->pluck('name'))],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // if($request->hasFile('avatar'))
        // {
        //     $path = $request->file('avatar')->store('avatars');
        // }

        $user = User::create([
            'name' => $request->name,
            'national_id' => $request->national_id,
            'email' => $request->email,
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars') : 'avatars/users_default_avatar.png',
            'created_by' => Auth::guard('web')->user()->id,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole(['name' => $request->role]);

        event(new Registered($user));

        Auth::guard('web')->login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
