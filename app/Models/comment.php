<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }
}
