<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class followers extends Model
{
    use HasApiTokens, HasFactory ,Notifiable;
    protected $fillable = [
        'follower_id',
        'followed_id', 
    
    ];
    
    public function user(){
        return $this->belongsToMany(User::class,'followers','followed_id','follower_id');

    }
}
