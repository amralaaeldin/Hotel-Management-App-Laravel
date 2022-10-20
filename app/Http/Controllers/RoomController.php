<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web')->except('getUnreservedRooms');
        $this->middleware(['role:admin|manager'])->except('getUnreservedRooms');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['rooms' => Room::all(['id', 'number', 'capacity', 'price', 'created_by', 'floor_number'])]);
    }

    public function getUnreservedRooms()
    {
        return view('client.dashboard', ['rooms' => Room::where('reserved', false)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hotel.room.create', ['floors' => Floor::all(['name', 'number'])]);
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
            'floor_number' => ['required', 'numeric', Rule::in(Floor::pluck('number')->all())],
            'capacity' => ['required', 'numeric', 'max:30'],
            'price' => ['required', 'numeric', 'lt:1000000'],
        ]);

        Room::create([
            'number' => $request->number,
            'floor_number' => $request->floor_number,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'created_by' => Auth::guard('web')->user()->id,
        ]);

        return redirect('/' . Auth::guard('web')->user()->getRoleNames()[0] . '/rooms')->with('success', 'Created Successfully!');
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
            return view('hotel.room.edit', ['room' => $res[2], 'floors' => Floor::all(['name', 'number'])]);
        }
        return redirect('/' . $res[1]->getRoleNames()[0] . '/rooms')->with('fail', 'Action is not allowed');
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
                ->update($request->validate([
                    'number' => ['required', 'numeric', Rule::unique('rooms', 'number')->ignore($id)],
                    'floor_number' => ['required', 'numeric', Rule::in(Floor::pluck('number')->all())],
                    'capacity' => ['required', 'numeric', 'max:30'],
                    'price' => ['required', 'numeric', 'lt:1000000'],
                ]));

            return redirect('/' . $res[1]->getRoleNames()[0] . '/rooms')->with('success', 'Updated Successfully!');
        }
        return redirect('/' . $res[1]->getRoleNames()[0] . '/rooms')->with('fail', 'Action is not allowed');
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
            if (!$res[1]->reserved) {
                $res[1]->delete();
                return redirect('/' . $res[1]->getRoleNames()[0] . '/rooms')->with('success', 'Deleted Successfully!');
            } else {
                return redirect('/' . $res[1]->getRoleNames()[0] . '/rooms')->with('fail', 'Can\'t Delete Reserved Room!');
            }
        }
        return redirect('/' . $res[1]->getRoleNames()[0] . '/rooms')->with('fail', 'Action is not allowed');
    }

    protected function ensureIsOwner($id)
    {
        $user = Auth::guard('web')->user();
        $room = Room::where('id', $id)->first();
        if ($user->getRoleNames()[0] == 'manager' && $user->id != $room->created_by) {
            return [false, $user];
        }
        return [true, $user, $room];
    }
}
