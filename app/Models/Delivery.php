<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'date','file_id','cash_no','vehicle_no','item_id','qty',
    ];

    public function files()
    {
        return $this->belongsTo('App\Models\File','file_id');
    }

    public function items()
    {
        return $this->belongsTo('App\Models\Item','item_id');
    }

   
}
