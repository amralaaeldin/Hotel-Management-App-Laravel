<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function __construct()
{
    $this->middleware('auth:client')->only(['create', 'store', 'getClientReservations']);
    $this->middleware(['role:admin|manager'])->only('index');
    $this->middleware(['role:receptionist'])->only('getAcceptedClientsReservations');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['reservations'=> Reservation::all('id', 'client_id', 'floor_number','room_number', 'duration', 'price_paid_per_day', 'accompany_number')]);
    }

    public function getClientReservations()
    {
        return view('client.dashboard', ['reservations'=> Auth::guard('client')->user()->reservations]);
    }

    public function getAcceptedClientsReservations()
    {
        return view('dashboard', ['reservations'=> Auth::guard('web')->user()->clients->pluck('reservations')[0]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Room $room)
    {
        return view('reservation.create', ['room' => $room]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
}
