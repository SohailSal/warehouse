<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
     'name',  'description', 'hscode' , 'unit_id' ,'file_id',
    ];

    public function unitTypes()
    {
        return $this->belongsTo('App\Models\UnitType', 'unit_id');
    }

    public function files()
    {
        return $this->belongsTo('App\Models\File', 'file_id');
    }
   
    public function quantities()
    {
      return $this->hasMany('App\Models\Quantity', 'item_id');
  
    }

}
