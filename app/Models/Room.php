<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\User;
use  App\Models\Floor;


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


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_number', 'number');
    }
}
