<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureYourselfOrCanEdit;
use App\Models\User;
use App\Traits\IsAllowedTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ReceptionistController extends Controller
{
    use IsAllowedTrait;

    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(['role:admin|manager'])->except(['edit', 'update']);
        $this->middleware(EnsureYourselfOrCanEdit::class)->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['receptionists' => User::with('creator')->role('receptionist')->get(['id', 'name', 'email', 'created_by', 'banned_at'])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $receptionist)
    {
        $res = $this->ensureIsAllowed($receptionist);
        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/receptionists')->with('fail', 'Action is not allowed');
        }
        return view('receptionist.edit', ['receptionist' => $res['model']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $receptionist)
    {
        if ($request->hasFile('avatar') && $receptionist->avatar != 'avatars/users_default_avatar.png') {
            Storage::delete("$receptionist->avatar");
        }
        $res = $this->ensureIsAllowed($receptionist);
        if (!$res['isAllowed']) {
            if (Auth::guard('web')->user()->getRoleNames()[0] !== 'receptionist') {
                return redirect('/' . $res['user']->getRoleNames()[0] . '/receptionists')->with('fail', 'Action is not allowed');
            }
            return redirect()->route('receptionist.dashboard')->with('fail', 'Action is not allowed');
        }
        $res['model']
            ->update(
                array_merge($request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'national_id' => ['required', 'digits:14', Rule::unique('users', 'national_id')->ignore($receptionist->id)],
                        'avatar' => ['image'],
                        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($receptionist->id)],
                    ]), ['avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars') : $receptionist->avatar]
                ));
        if (Auth::guard('web')->user()->getRoleNames()[0] !== 'receptionist') {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/receptionists')->with('success', 'Updated Successfully!');
        }
        return redirect()->route('receptionist.dashboard')->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $receptionist)
    {
        $res = $this->ensureIsAllowed($receptionist);
        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/receptionists')->with('fail', 'Action is not allowed');
        }
        $res['model']->delete();
        return redirect('/' . $res['user']->getRoleNames()[0] . '/receptionists')->with('success', 'Deleted Successfully!');
    }

    public function ban(User $receptionist)
    {
        $res = $this->ensureIsAllowed($receptionist);
        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/receptionists')->with('fail', 'Action is not allowed');
        }
        if ($res['model']->isBanned()) {
            $res['model']->unban();
            return redirect('/' . $res['user']->getRoleNames()[0] . '/receptionists')->with('success', 'Unbanned Successfully!');
        }
        $res['model']->ban();
        return redirect('/' . $res['user']->getRoleNames()[0] . '/receptionists')->with('success', 'Banned Successfully!');
    }
}
