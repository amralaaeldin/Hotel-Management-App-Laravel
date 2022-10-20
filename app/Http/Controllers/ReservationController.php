<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Rules\FutureDate;
use Carbon\Carbon;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
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
        return view('dashboard', ['reservations' => Reservation::all('id', 'client_id', 'floor_number', 'room_number', 'duration', 'price_paid_per_day', 'accompany_number')]);
    }

    public function getClientReservations()
    {
        return view('client.dashboard', ['reservations' => Auth::guard('client')->user()->reservations]);
    }

    public function getAcceptedClientsReservations()
    {
        return view('dashboard', ['reservations' => Auth::guard('web')->user()->clients->pluck('reservations')[0]]);
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
    public function store(Room $room, Request $request)
    {
        $request->validate([
            'duration' => ['required', 'numeric', 'max:30'],
            'accompany_number' => ['required', 'numeric', 'min:1', 'max:30', "lte:$room->capacity"],
            'st_date' => ['required', 'date', new FutureDate],
            'price_paid_per_day' => ['required', 'numeric', "size:$room->price"],
            "total_price" => ['required', 'numeric', "size:" . $room->price * $request->duration . ""],
            'name_on_card' => ['required', 'string', 'max:255'],
            'stripeToken' => ['required', 'string'],
        ]);

        if ($room->reserved) {
            return redirect('rooms')->with('fail', 'Error! This room is reserved!');
        }

        $content = [
            "accompany_number" => $request->accompany_number,
            "st_date" => $request->st_date,
            "duration" => $request->duration,
            "end_date" => Carbon::createFromFormat('Y-m-d H', $request->st_date . ' 14')->addDays($request->duration)->toDateTimeString(),
            "price_paid_per_day" => $room->price,
        ];

        // Check in happens at 2:00 PM
        $request->st_date = Carbon::createFromFormat('Y-m-d H', $request->st_date . ' 14')->toDateTimeString();

        try {
            $charge = Stripe::charges()->create([
                'amount' => $room->price * $request->duration,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'Reservation',
                'receipt_email' => Auth::guard('client')->user()->email,
                'metadata' => [
                    'name' => "Room no. $room->number in Floor {$room->floor->name}",
                    'name_on_card' => $request->name_on_card,
                    'contents' => json_encode(
                        array_merge($content, ["total_price" => $room->price * $request->duration])),
                ],
            ]);

            $room->update(['reserved' => true]);

            Reservation::create(array_merge(
                $content,
                [
                    'client_id' => Auth::guard('client')->user()->id,
                    'room_number' => $room->number,
                    'floor_number' => $room->floor_number,
                ]
            ));

            return redirect()->route('reservations.confirm')->with('success', 'Thank you! Your payment has been successfully accepted!');
        } catch (CardErrorException $e) {
            $this->addToOrdersTables($request, $e->getMessage());
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }

    public function confirm()
    {
        if (!session('success')) {
            return redirect('rooms');
        }
        return view('reservation.success');
    }
}
