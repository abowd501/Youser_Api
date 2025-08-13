<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'store_name', 
        'email', 
        'phone', 
        'password', 
        'country', 
        'governorate', 
        'city', 
        'image',
        
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
    public function accounts()
    {
        return $this->hasOne(accounts::class);
    }
    public function requests()
    {
        return $this->hasMany(requests::class,'user_id');
    }
    public function products()
    {
        return $this->hasMany(Products::class);
    }
    public function likes()
    {
        return $this->hasMany(likes::class,'user_id');
    }
    public function comment()
    {
        return $this->hasMany(comment::class,'product_id');
    }
    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','followed_id','follower_id');
    }
    public function following()
    {
        return $this->belongsToMany(User::class,'followers','follower_id','followed_id');
    }
}
