<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Floor;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'room_id',
        'floor_id',
        'duration',
        'price_paid_per_day',
        'accompany_id',
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
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function getStDate()
    {
        return Carbon::create($this->st_date)->format('l jS \\of F Y h:i:s A');
    }

    public function getEndDate()
    {
        return Carbon::create($this->end_date)->format('l jS \\of F Y h:i:s A');
    }

    protected function pricePaidPerDay(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }
}
