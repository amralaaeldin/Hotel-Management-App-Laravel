<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Room;


class Floor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'created_by',
    ];



    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'floor_number', 'number');
    }

}
