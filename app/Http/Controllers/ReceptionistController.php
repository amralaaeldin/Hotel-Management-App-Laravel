<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class ReceptionistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(['role:admin|manager']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['receptionists'=> User::role('receptionist')->get(['id', 'name', 'email','created_by'])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res = $this->ensureIsOwner($id);
        if ($res[0]) {
            return view('receptionist.edit', ['receptionist' => $res[2]]);
        }
        return redirect('/'.$res[1]->getRoleNames()[0].'/receptionists')->with('fail', 'Action is not allowed');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $res = $this->ensureIsOwner($id);
        if ($res[0]) {
            $res[2]
            ->update(
            $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'national_id' => ['required', 'digits:14', Rule::unique('users','national_id')->ignore($id)],
                'avatar' => ['image'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($id)],
            ]
            ));

            return redirect('/'.$res[1]->getRoleNames()[0].'/receptionists')->with('success', 'Updated Successfully!');
        }
        return redirect('/'.$res[1]->getRoleNames()[0].'/receptionists')->with('fail', 'Action is not allowed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->ensureIsOwner($id);
        if ($res[0]) {
            $res[2]->delete();
            return redirect('/'.$res[1]->getRoleNames()[0].'/receptionists')->with('success', 'Deleted Successfully!');
        }
        return redirect('/'.$res[1]->getRoleNames()[0].'/receptionists')->with('fail', 'Action is not allowed');
    }

    protected function ensureIsOwner($id) {
        $user = Auth::guard('web')->user();
        $receptionist = User::where('id',$id)->first();
        if ($user->getRoleNames()[0] == 'manager' && $user->id != $receptionist->created_by) {
            return [false, $user];
        }
        return [true, $user, $receptionist];
    }

}
