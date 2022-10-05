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

    public function __construct()
    {
        $this->middleware(['auth:web']);
        if (request()->role === 'manager') 
        {
            $this->middleware(['role:admin']);
        }
        if (request()->role === 'receptionist') 
        {
            $this->middleware(['role:admin|manager']);
        }
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create($role)
    {
        return view($role. '.create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'national_id' => ['required', 'digits:14', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'avatar' => ['image'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'national_id' => $request->national_id,
            'email' => $request->email,
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars') : 'avatars/users_default_avatar.png',
            'created_by' => Auth::guard('web')->user()->id,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole(['name' => $role]);

        event(new Registered($user));

        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/'.$role.'s')->with('success', 'Added Successfully!');
    }
}
