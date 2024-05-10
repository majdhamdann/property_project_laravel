<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'path', 'images','property_id'];
    
    protected $casts = [
        'images' => 'array',
    ];
    public function property()
    {
        return $this->belongsToMany(Property::class,'property_id');
    }
}
