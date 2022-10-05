<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Floor;
use App\Models\Room;
use App\Notifications\AdminResetPassword as AdminResetPasswordNotification;
use App\Notifications\StaffResetPassword as StaffResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'national_id',
        'email',
        'password',
        'avatar',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAt()
    {
        return Carbon::create($this->created_at)->format('l jS \\of F Y h:i:s A');
    }

    public function creator()
    {
        return $this->belongsTo($this, 'created_by', 'id');
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'approved_by', 'id');
    }

    public function floors()
    {
        return $this->hasMany(Floor::class, 'created_by', 'id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'created_by', 'id');
    }

    public function subordinates()
    {
        return $this->hasMany($this, 'created_by', 'id');
    }

    public function sendPasswordResetNotification($token)
    {
        if (explode('/', request()->route()->uri)[0] === 'staff') {
            $this->notify(new StaffResetPasswordNotification($token));
        } else {
            $this->notify(new AdminResetPasswordNotification($token));
        }
    }
}
