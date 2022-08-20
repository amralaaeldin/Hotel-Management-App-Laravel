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
        return view('admin.dashboard', ['receptionists'=> User::role('receptionist')->get(['id', 'name', 'email','created_by'])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('receptionist.edit', ['receptionist' => User::where('id',$id)->first()]);
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
        User::find($id)
        ->update(
            $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'national_id' => ['required', 'digits:14', Rule::unique('users','national_id')->ignore($id)],
                'avatar' => ['image'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($id)],
            ]
        ));

        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/receptionists')->with('success', 'Updated Successfully!');
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
        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/receptionists')->with('success', 'Deleted Successfully!');
    }
}
