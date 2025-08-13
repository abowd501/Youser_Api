<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ourProducts extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'group_id',
        'name',
        'currency',
        'price',
        'show',
        'description', 
        
    ];
    public function group()
    {
        return $this->belongsTo(groups::class);
    }
    public function image()
    {
        return $this->hasMany(ourImages::class,'product_id');
    }
}
