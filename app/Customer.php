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
  	'date_of_birth', 'bitcoin_account', 'sponsor_id', 'placement_id', 'direction'
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  public function sponsor()
  {
  	 return $this->belongsTo('App\Customer');
  }
}
