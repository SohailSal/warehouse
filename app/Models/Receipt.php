<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id', 'date', 'document_id', 'tax_status', 's_tax_status', 'amount', 'i_tax', 's_tax', 'com', 'receipt_no'
    ];

    public function files()
    {
        return $this->belongsTo('App\Models\File', 'file_id');
    }

    public function documents()
    {
        return $this->belongsTo('App\Models\Document', 'document_id');
    }
}
