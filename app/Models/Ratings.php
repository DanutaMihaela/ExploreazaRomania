<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $table = 'Ratings';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function tourist(){
        return $this->hasOne(Tourists::class, 'id', 'touristId'); 
    }

    public function property(){
        return $this->hasOne(Properties::class, 'id', 'propertyId'); 
    }

    public function host(){
        return $this->hasOne(Properties::class, 'id', 'hostId'); 
    }
}
