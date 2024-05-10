<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
         'direction','purpose','description','price','space'
         ,'Category_id','auth_id','city_id','available'
    ];
   
     public function cities()
     {
       return $this->belongsTo(City::class,'city_id');
     }
     public function customers()
     {
         return $this->hasMany(Customer::class);
     }
     public function propertyCustomers()
      {
        return $this->hasMany(PropertyCustomer::class);
       }
       public function Categories()
       {
           return $this->belongsTo(Category::class);
       }
       public function images()
    {
        return $this->belongsToMany(Image::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
     

   
    
}
