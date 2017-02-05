<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
  protected $table = 'customers';

  protected $fillable = [ 
  	'username', 'email', 'password', 'is_active', 
  	'first_name', 'last_name', 'gender', 
  	'date_of_birth', 'block_chain_code', 'sponsor_id'
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  public function sponsor()
  {
  	 return $this->belongsTo('App\Customer');
  }
}
