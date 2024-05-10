<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps=false;
    protected $fillable = [
        'first_name','middle_name','last_name','phon_num',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
  

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function property()
      {
       return $this->belongsTo(Property::class);
      }
      public function propertyCustomers()
      {
         return $this->hasMany(PropertyCustomer::class);
       }
    /*   public function hasPermissionToDelete(Property $property)
       {
           return $this->id === $this->property->user_id;
       }*/

}
