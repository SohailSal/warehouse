<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
     
        'name',
    ];


   

    public function files()
    {
        return $this->hasMany('App\Models\File','agent_id');
    }
  

}
