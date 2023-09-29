<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Traits\IsAllowedTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FloorController extends Controller
{
    use IsAllowedTrait;

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
        return view('dashboard', ['floors' => Floor::with('creator')->select(['name', 'id', 'created_by'])->get()]);
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

        return redirect('/' . Auth::guard('web')->user()->getRoleNames()[0] . '/floors')->with('success', 'Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Floor $floor)
    {
        $res = $this->ensureIsAllowed($floor);
        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/floors')->with('fail', 'Action is not allowed');
        }
        return view('hotel.floor.edit', ['floor' => $res['model']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Floor $floor)
    {
        $res = $this->ensureIsAllowed($floor);
        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/floors')->with('fail', 'Action is not allowed');
        }
        $res['model']
            ->update($request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique('floors', 'name')->ignore($floor->id, 'id')],
            ]));
        return redirect('/' . $res['user']->getRoleNames()[0] . '/floors')->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Floor $floor)
    {
        $res = $this->ensureIsAllowed($floor);
        if (!$res['isAllowed']) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/floors')->with('fail', 'Action is not allowed');
        }
        if (count($res['model']->rooms->values()->all()) !== 0) {
            return redirect('/' . $res['user']->getRoleNames()[0] . '/floors')->with('fail', 'Can\'t Delete A Floor has Rooms!');
        }
        $res['model']->delete();
        return redirect('/' . $res['user']->getRoleNames()[0] . '/floors')->with('success', 'Deleted Successfully!');
    }
}
