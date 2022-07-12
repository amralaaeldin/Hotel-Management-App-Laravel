<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use App\Models\Reservation;

class Client extends Authenticatable
{
    use HasFactory;

    protected $guard = 'client';

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'mobile',
        'country',
        'avatar',
        'approved',
        'approved_by',
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get all of the reservations for the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id', 'id');
    }
}
