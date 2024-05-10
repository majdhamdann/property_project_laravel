<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = ['name_types'];
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
