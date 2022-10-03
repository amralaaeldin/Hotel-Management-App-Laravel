<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureYourselfOrCanEdit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(['role:admin'])->except(['edit', 'update']);
        $this->middleware(EnsureYourselfOrCanEdit::class)->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['managers' => User::role('manager')->get(['id', 'name', 'national_id', 'email', 'avatar', 'created_by'])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('manager.edit', ['manager' => User::where('id', $id)->first()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $manager)
    {
        if ($request->hasFile('avatar') && $manager->avatar != 'avatars/users_default_avatar.png') {
            Storage::delete("$manager->avatar");
        }
        $manager
            ->update(array_merge(
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'national_id' => ['required', 'digits:14', Rule::unique('users', 'national_id')->ignore($manager->id)],
                        'avatar' => ['image'],
                        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($manager->id)],
                    ]
                ), ['avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars') : $manager->avatar]
            ));

        if (Auth::guard('web')->user()->getRoleNames()[0] !== 'manager') {
            return redirect('/' . Auth::guard('web')->user()->getRoleNames()[0] . '/managers')->with('success', 'Updated Successfully!');
        } else {
            return redirect()->route('manager.dashboard')->with('success', 'Updated Successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('/' . Auth::guard('web')->user()->getRoleNames()[0] . '/managers')->with('success', 'Deleted Successfully!');
    }
}
