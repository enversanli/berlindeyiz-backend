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

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'role',
        'business_id',
        'organizer_id',
        'city_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'email_verified_at',
        'verification_code',
        'reset_password_code',
        'mobile_phone',
        'office_phone',
        'photo',
        'photo_url',
        'status',
        'approved',
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

    public function business(){
        return $this->hasOne(Business::class, 'id', 'user_id');
    }

    public function services(){
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
