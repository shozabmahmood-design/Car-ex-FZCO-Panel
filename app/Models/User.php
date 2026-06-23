<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const CUSTOMER = 0;
    const DRIVER = 1;
    const ADMIN = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function settings()
    {
        return $this->hasOne(Setting::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function assigedBookings()
    {
        return $this->hasMany(Booking::class, 'assigned_to', 'id');
    }

    public function blog()
    {
        return $this->hasMany(Blog::class);
    }
}
