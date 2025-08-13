<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ourImages extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'image', 
        
    ];
    public function ourproduct()
    {
        return $this->belongsTo(ourProducts::class)->withDefault(['image'=>'1427298387.jpg']);
    }
}
