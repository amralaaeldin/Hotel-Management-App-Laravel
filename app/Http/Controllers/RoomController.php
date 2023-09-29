<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Room;
use App\Traits\IsAllowedTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    use IsAllowedTrait;

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
        return view('dashboard', ['rooms' => Room::with('creator', 'floor')->select(['id', 'id', 'capacity', 'price', 'created_by', 'floor_id'])->get()]);
    }

    public function getUnreservedRooms()
    {
        return view('client.dashboard', ['rooms' => Room::where('reserved', false)->select(['id', 'id', 'capacity', 'price', 'floor_id', 'reserved'])->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hotel.room.create', ['floors' => Floor::all(['name', 'id'])]);
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
            'id' => ['required', 'numeric', 'unique:rooms'],
            'floor_id' => ['required', 'numeric', Rule::in(Floor::pluck('id')->all())],
            'capacity' => ['required', 'numeric', 'max:30'],
            'price' => ['required', 'numeric', 'lt:1000000'],
        ]);

        Room::create([
            'id' => $request->id,
            'floor_id' => $request->floor_id,
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
    public function edit(Room $room)
    {
        $res = $this->ensureIsAllowed($room);
        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/rooms')->with('fail', 'Action is not allowed');
        }
        return view('hotel.room.edit', ['room' => $res['model'], 'floors' => Floor::all(['name', 'id'])]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $res = $this->ensureIsAllowed($room);

        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/rooms')->with('fail', 'Action is not allowed');
        }
        $res['model']
            ->update($request->validate([
                'id' => ['required', 'numeric', Rule::unique('rooms', 'id')->ignore($room->id)],
                'floor_id' => ['required', 'numeric', Rule::in(Floor::pluck('id')->all())],
                'capacity' => ['required', 'numeric', 'max:30'],
                'price' => ['required', 'numeric', 'lt:1000000'],
            ]));

        return redirect('/' . $res['user']->getRoleNames()[0] . '/rooms')->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $res = $this->ensureIsAllowed($room);
        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/rooms')->with('fail', 'Action is not allowed');
        }
        if ($res['model']->reserved) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/rooms')->with('fail', 'Can\'t Delete Reserved Room!');
        }
        $res['model']->delete();
        return redirect('/' . $res['user']->getRoleNames()[0] . '/rooms')->with('success', 'Deleted Successfully!');
    }
}
