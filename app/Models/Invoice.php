<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id', 'date', 'amount', 's_tax', 'invoice_no'
    ];

    public function files()
    {
        return $this->belongsTo('App\Models\File', 'file_id');
    }

    public function quantities()
    {
        return $this->hasMany('App\Models\Quantity', 'invoice_id');
    }
}
