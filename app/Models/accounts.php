<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accounts extends Model
{

    public function users(){
        return $this->hasMany(User::class);
    }
    use HasFactory;
    protected $fillable = [
        'user_id',
        'balance',
        'curent_balance',
        'currency',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
