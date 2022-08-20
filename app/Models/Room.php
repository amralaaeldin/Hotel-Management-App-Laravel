<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\User;
use  App\Models\Floor;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'floor_number',
        'capacity',
        'price',
        'created_by',
        'reserved',
    ];

    protected function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value/100,
            set: fn ($value) => $value*100,
        );
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_number', 'number');
    }
}
