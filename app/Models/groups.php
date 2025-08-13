<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class groups extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_group',  
    ];
    public function product()
    {
        return $this->hasOne(Products::class,'group_id');
    }
    public function ourproduct()
    {
        return $this->hasOne(ourProducts::class,'group_id');
    }
}
