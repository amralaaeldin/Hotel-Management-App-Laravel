<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureYourselfOrCanEdit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ReceptionistController extends Controller
{
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
        return view('dashboard', ['receptionists' => User::role('receptionist')->get(['id', 'name', 'email', 'created_by', 'banned_at'])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $receptionist)
    {
        $res = $this->ensureIsOwner($receptionist);
        if ($res[0]) {
            return view('receptionist.edit', ['receptionist' => $res[2]]);
        }
        return redirect('/' . $res[1]->getRoleNames()[0] . '/receptionists')->with('fail', 'Action is not allowed');
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
        $res = $this->ensureIsOwner($receptionist);
        if ($res[0]) {
            $res[2]
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
                return redirect('/' . $res[1]->getRoleNames()[0] . '/receptionists')->with('success', 'Updated Successfully!');
            } else {
                return redirect()->route('receptionist.dashboard')->with('success', 'Updated Successfully!');
            }
        }
        if (Auth::guard('web')->user()->getRoleNames()[0] !== 'receptionist') {
            return redirect('/' . $res[1]->getRoleNames()[0] . '/receptionists')->with('fail', 'Action is not allowed');
        } else {
            return redirect()->route('receptionist.dashboard')->with('fail', 'Action is not allowed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $receptionist)
    {
        $res = $this->ensureIsOwner($receptionist);
        if ($res[0]) {
            $res[2]->delete();
            return redirect('/' . $res[1]->getRoleNames()[0] . '/receptionists')->with('success', 'Deleted Successfully!');
        }
        return redirect('/' . $res[1]->getRoleNames()[0] . '/receptionists')->with('fail', 'Action is not allowed');
    }

    public function ban(User $receptionist)
    {
        $res = $this->ensureIsOwner($receptionist);
        if ($res[0]) {
            if ($res[2]->isBanned()) {
                $res[2]->unban();
                return redirect('/' . $res[1]->getRoleNames()[0] . '/receptionists')->with('success', 'Unbanned Successfully!');
            } else {
                $res[2]->ban();
                return redirect('/' . $res[1]->getRoleNames()[0] . '/receptionists')->with('success', 'Banned Successfully!');
            }
        }
        return redirect('/' . $res[1]->getRoleNames()[0] . '/receptionists')->with('fail', 'Action is not allowed');
    }

    protected function ensureIsOwner($receptionist)
    {
        $user = Auth::guard('web')->user();
        if ($user->getRoleNames()[0] == 'manager' && $user->id != $receptionist->created_by) {
            return [false, $user];
        }
        return [true, $user, $receptionist];
    }

}
