<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
      'client_id', 'date' , 'amount' ,'i_tax' , 's_tax' , 'com' ,
    ];

    public function clients()
  {
      return $this->belongsTo('App\Models\Client', 'client_id');
  }
  
  
  
}
