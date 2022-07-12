<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Client;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'room_number',
        'floor_number',
        'duration',
        'price_paid_per_day',
        'accompany_number',
        'st_date',
        'end_date',
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
}
