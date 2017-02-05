<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
  protected $table = 'customers';

  protected $fillable = [ 
  	'last_name', 'first_name', 'gender', 'username', 'password',
  	'date_of_birth', 'block_chain_code', 'sponsor_id',
    'email', 'is_active',
  ];

  public function sponsor()
  {
  	 return $this->belongsTo('App\Customer');
  }
}
