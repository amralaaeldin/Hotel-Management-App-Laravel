<?php

namespace App\Models;

use App\Models\Floor;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_id',
        'capacity',
        'price',
        'created_by',
        'reserved',
    ];

    protected function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }
}
