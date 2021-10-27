<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email' ,'address', 'ntn_no', 'phone_no',
    ];

    public function files()
    {
        return $this->hasMany('App\Models\File','client_id');
    }
}
