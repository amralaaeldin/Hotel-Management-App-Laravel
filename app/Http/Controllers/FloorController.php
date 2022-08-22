<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rule;



class FloorController extends Controller
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
        return view('dashboard', ['floors'=> Floor::all(['name', 'number', 'created_by'])]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hotel.floor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:floors'],
        ]);

        Floor::create([
            'name' => $request->name,
            'created_by' => Auth::guard('web')->user()->id,
        ]);

        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/floors')->with('success', 'Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($number)
    {
        $res = $this->ensureIsOwner($number);
        if ($res[0]) {
            return view('hotel.floor.edit', ['floor' => $res[2]]);
        }
        return redirect('/'.$res[1]->getRoleNames()[0].'/floors')->with('fail', 'Action is not allowed');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $number)
    {
        $res = $this->ensureIsOwner($number);
        if ($res[0]) {
            $res[2]
            ->update($request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('floors','name')->ignore($number, 'number')],
            ]));

            return redirect('/'.$res[1]->getRoleNames()[0].'/floors')->with('success', 'Updated Successfully!');
        }
        return redirect('/'.$res[1]->getRoleNames()[0].'/floors')->with('fail', 'Action is not allowed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($number)
    {
        $res = $this->ensureIsOwner($number);
        if ($res[0]) {
            if (count($res[2]->rooms->values()->all()) === 0) {
                $res[2]->delete();
                return redirect('/'.$res[1]->getRoleNames()[0].'/floors')->with('success', 'Deleted Successfully!');
            } else {
                return redirect('/'.$res[1]->getRoleNames()[0].'/floors')->with('fail', 'Can\'t Delete A Floor has Rooms!');
            }
        }
        return redirect('/'.$res[1]->getRoleNames()[0].'/floors')->with('fail', 'Action is not allowed');
    }

    protected function ensureIsOwner($number) {
        $user = Auth::guard('web')->user();
        $floor = Floor::where('number',$number)->first();
        if ($user->getRoleNames()[0] == 'manager' && $user->id != $floor->created_by) {
            return [false, $user];
        }
        return [true, $user, $floor];
    }
}