<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\ClientResetPassword as ResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use App\Models\Reservation;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'last_login_at'
    ];

    public function getCountry() {
        return countries()["$this->country"]['name'];
    }
    public function getGender() {
        return $this->gender === 'M' ? 'Male' : 'Female';
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
