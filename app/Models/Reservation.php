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
