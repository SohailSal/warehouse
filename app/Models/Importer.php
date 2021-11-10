<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'address', 'stn_no', 'phone_no', 'account_id'
    ];

    public function accounts()
    {
        return $this->belongsTo('App\Models\Account', 'account_id');
    }

    public function files()
    {
        return $this->hasMany('App\Models\File', 'importer_id');
    }
}
