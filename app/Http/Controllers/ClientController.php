<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;


class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(['role:admin|manager'])->only(['edit','update','destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard', ['clients'=> Client::all(['id', 'name', 'email', 'mobile', 'gender', 'country', 'avatar', 'approved'])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('client.edit', ['client' => Client::where('id',$id)->first(), 'countries' => countries()]);
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
        Client::find($id)
        ->update(
            $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'mobile' => ['required', 'min:11', 'numeric'],
                'country' => ['required', Rule::in(array_keys(countries()))],
                'avatar' => ['image'],
                'gender' => ['required', 'in:M,F'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('clients','email')->ignore($id) ],
            ]
        ));

        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/clients')->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::find($id)->delete();
        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/clients')->with('success', 'Deleted Successfully!');
    }


    public function approve($id)
    {
        Client::find($id)->update([
            'approved' => true,
            'approved_by' => Auth::guard('web')->user()->id
        ]);
        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/clients')->with('success', 'Approved Successfully!');
    }
}
