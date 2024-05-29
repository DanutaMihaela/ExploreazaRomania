<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'Bookings';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function property(){
        return $this->hasOne(Properties::class, 'id', 'propertyId'); 
    }
    public function tourists(){
        return $this->hasMany(BookingsTourists::class, 'bookingId', 'id');
    }
    public function messages(){
        return $this->hasMany(Messages::class, 'bookingId', 'id')->orderBy('added', 'asc');
    }
    public function ratings(){
        return $this->hasOne(Ratings::class, 'bookingId', 'id');
    }

}
