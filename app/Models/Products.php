<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'group',
        'name',
        'currency',
        'price',
        'country',
        'isshow',
        'description', 
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function image()
    {
        return $this->hasMany(Images::class,'product_id');
    }
    public function likes()
    {
        return $this->hasMany(likes::class,'product_id');
    }    
    public function conment()
    {
        return $this->hasMany(comment::class,'product_id');
    }
    public function group()
    {
        return $this->belongsTo(groups::class);
    }
}
