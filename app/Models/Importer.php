<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email' ,'address', 'stn_no', 'phone_no', 'phone_no'
    ];

    public function files()
    {
        return $this->hasMany('App\Models\File','importer_id');
    }

  
}
