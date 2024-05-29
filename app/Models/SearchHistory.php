<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    protected $table = 'SearchHistory';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function tourist(){
        return $this->hasOne(Tourists::class, 'id', 'touristId'); 
    }

}
