<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    
    protected $table = 'Messages';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
