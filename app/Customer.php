<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
  use Notifiable;


  protected $table = 'customers';

  protected $fillable = [ 
  	'username', 'email', 'password', 'is_active', 
  	'first_name', 'last_name', 'gender', 
  	'date_of_birth', 'bitcoin_account', 'sponsor_id', 
    'placement_id', 'direction', 'agree_term_condition',
    'email_verified', 'verified_token'
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  public function sponsor()
  {
  	 return $this->belongsTo('App\Customer');
  }

  public function scopeAdmin($query)
  {
    return $query->where('username', 'admin')->first();
  }
}
