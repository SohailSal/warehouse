<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        
         'file_no', 'file_code', 'gd_no','bond_no', 'date_bond' ,'description', 'vessel', 'gross_wt' ,'net_wt', 'bl_no',
         'vir_no', 'index_no', 'insurance', 'lc_no', 'amount', 's_tax', 'qty',
         'agent_id' ,'importer_id', 'client_id',
  ];

  
  public function agents()
  {
      return $this->belongsTo('App\Models\Agent', 'agent_id');
  }

  public function importers()
  {
      return $this->belongsTo('App\Models\Importer', 'importer_id');
  }

  public function clients()
  {
      return $this->belongsTo('App\Models\Client', 'client_id');
  }


  public function receipts()
  {
    return $this->hasMany('App\Models\Receipt', 'file_id');

  }


  public function deliveries()
  {
    return $this->hasMany('App\Models\Delivery', 'file_id');

  }

  public function invoices()
  {
    return $this->hasMany('App\Models\Invoice', 'file_id');

  }
  

  public function quantities()
  {
    return $this->hasMany('App\Models\Quantity', 'file_id');
  }

  public function items()
  {
    return $this->hasMany('App\Models\Item', 'file_id');

  }
 

}
