<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        
         'file_no','gd_no','bond_no', 'date_bond' ,'description', 'vessel', 'gross_wt' ,'net_wt', 'bl_no',
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
  

  public function quantities()
  {
    return $this->hasMany('App\Models\Quantity', 'file_id');
  }

}
