<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [
        'date', 'account_id', 'description', 'payee', 'cheque', 'amount', 'enabled'
    ];

    public function accounts()
    {
        return $this->belongsTo('App\Models\Account', 'account_id');
    }
}
