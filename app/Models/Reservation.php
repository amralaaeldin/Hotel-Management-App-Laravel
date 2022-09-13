<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Client;
use  App\Models\Floor;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', // auto get
        'room_number', // auto get
        'floor_number', // auto get
        'duration',
        'price_paid_per_day', // auto get
        'accompany_number',
        'st_date',
        'end_date', // auto cal
        // total price => auto cal, price per day * duration
        // end_date => auto cal, st_date + duration
        // check auth client,  else login // done
        // Field ajax to cal end_date
        // Field ajax to cal total ? and send it to payment gate ?? // backend, not input value

        // room not reserved
        // accompany number is between 0 & room max --- max 30
        // duration to be rational - max 30


        // make reservation in db
        // make room reserved

        // paper of planning
    ];

    /**
     * Get the client that owns the Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_number', 'number');
    }

    public function getStDate() {
        return Carbon::create($this->st_date)->format('l jS \\of F Y h:i:s A');
    }
    public function getEndDate() {
        return Carbon::create($this->end_date)->format('l jS \\of F Y h:i:s A');
    }
}
