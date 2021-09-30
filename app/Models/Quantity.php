<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    use HasFactory;

    protected $fillable = [
      'number',
    ];

    public function items()
    {
        return $this->belongsTo('App\Models\Item','item_id');
    }
    
  

    public function files()
    {
        return $this->belongsTo('App\Models\File','file_id');
    }
}
