<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Floor;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rule;



class RoomController extends Controller
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
        return view('admin.dashboard', ['rooms'=> Room::all(['id', 'number', 'capacity', 'price', 'created_by', 'floor_number'])]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hotel.room.create', ['floors'=> Floor::all(['name', 'number'])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->flash();

        $request->validate([
            'number' => ['required', 'numeric', 'unique:rooms'],
            'floor_number'=> ['required', 'numeric', Rule::in(Floor::pluck('number')->all())],
            'capacity'=> ['required', 'numeric', 'max:30'],
            'price'=> ['required', 'numeric','lt:1000000'],
        ]);

        Room::create([
            'number' => $request->number,
            'floor_number'=> $request->floor_number,
            'capacity'=>$request->capacity,
            'price'=> $request->price,
            'created_by' => Auth::guard('web')->user()->id,
        ]);

        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/rooms')->with('success', 'Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('hotel.room.edit', ['room' => Room::where('id',$id)->first(), 'floors'=> Floor::all(['name', 'number'])]);
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
        Room::find($id)
        ->update($request->validate([
            'number' => ['required', 'numeric', Rule::unique('rooms','number')->ignore($id)],
            'floor_number'=> ['required', 'numeric', Rule::in(Floor::pluck('number')->all())],
            'capacity'=> ['required', 'numeric', 'max:30'],
            'price'=> ['required', 'numeric','lt:1000000'],
            ]));

        return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/rooms')->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Room::find($id)->first()->reserved) {
            Room::find($id)->delete();
            return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/rooms')->with('success', 'Deleted Successfully!');
        } else {
            return redirect('/'.Auth::guard('web')->user()->getRoleNames()[0].'/rooms')->with('fail', 'Can\'t Delete Reserved Room!');
        }
    }
}
