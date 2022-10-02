<?php

namespace App\Http\Controllers;

use App\Events\ApprovedClient;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(['role:admin|manager'])->only(['edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['clients' => Client::all(['id', 'name', 'email', 'mobile', 'gender', 'country', 'avatar', 'approved'])]);
    }

    public function getNotAcceptedYet()
    {
        return view('dashboard', ['clients' => Client::where('approved', false)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('client.edit', ['client' => Client::where('id', $id)->first(), 'countries' => countries()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        if ($request->hasFile('avatar') && $client->avatar != 'avatars/clients/clients_default_avatar.png') {
            Storage::delete("$client->avatar");
        }
        $client
            ->update(
                [$request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'mobile' => ['required', 'min:11', 'numeric'],
                        'country' => ['required', Rule::in(array_keys(countries()))],
                        'avatar' => ['image'],
                        'gender' => ['required', 'in:M,F'],
                        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('clients', 'email')->ignore($client->id)],
                    ]
                ), 'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars/clients') : $client->avatar,
                ]);

        return redirect('/' . Auth::guard('web')->user()->getRoleNames()[0] . '/clients')->with('success', 'Updated Successfully!');
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
        return redirect('/' . Auth::guard('web')->user()->getRoleNames()[0] . '/clients')->with('success', 'Deleted Successfully!');
    }

    public function approve(Client $client)
    {
        $client->update([
            'approved' => true,
            'approved_by' => Auth::guard('web')->user()->id,
        ]);

        (new ApprovedClient($client))->handle();

        return redirect('/' . Auth::guard('web')->user()->getRoleNames()[0] . '/clients')->with('success', 'Approved Successfully!');
    }
}
