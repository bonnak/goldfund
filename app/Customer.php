<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $table = 'customers';

  protected $fillable = [ 
  	'user_id', 'surname', 'given_name', 'gender', 
  	'date_of_birth', 'ssid', 'block_chain_code', 'sponsor_id'
  ];

  public function sponsor()
  {
  	 return $this->belongsTo('App\Customer');
  }
}
