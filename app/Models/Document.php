<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'ref', 'date', 'description', 'type_id', 'paid', 'posted', 'approved', 'enabled', 'company_id', 'year_id'
    ];

    public function documentType()
    {
        return $this->belongsTo('App\Models\DocumentType', 'type_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function year()
    {
        return $this->belongsTo('App\Models\Year', 'year_id');
    }

    public function entries()
    {
        return $this->hasMany('App\Models\Entry', 'document_id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'document_id');
    }
    public function receipts()
    {
        return $this->hasMany('App\Models\Receipt', 'document_id');
    }
}
