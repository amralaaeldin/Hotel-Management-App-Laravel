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
        return view('admin.dashboard', ['floors'=> Floor::all(['name', 'number', 'created_by'])]);
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
        return view('hotel.floor.edit', ['floor' => Floor::where('number',$number)->first()]);
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
        Floor::where('number', $number)
        ->update($request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('floors','name')->ignore($number, 'number')],
            ]));

        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/floors')->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($number)
    {
        if (count(Floor::where('number', $number)->first()->rooms->values()->all()) === 0) {
            Floor::where('number', $number)->delete();
            return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/floors')->with('success', 'Deleted Successfully!');
        } else {
            return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/floors')->with('fail', 'Can\'t Delete A Floor has Rooms!');
        }

    }
}
