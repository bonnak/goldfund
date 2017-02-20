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
  	'first_name', 'last_name', 'gender', 'country_id',
  	'date_of_birth', 'bitcoin_account', 'sponsor_id', 
    'placement_id', 'direction', 'agree_term_condition',
    'email_verified', 'verified_token', 'trans_password',
    'confirmed',
  ];

  protected $hidden = [
    'password', 'trans_password', 'remember_token',
  ];

  public function sponsor()
  {
  	 return $this->belongsTo('App\Customer');
  }

  public function country()
  {
    return $this->belongsTo(Country::class, 'country_id')->select('id', 'name');
  }

  // public function password_store()
  // {
  //   return $this->hasOne(TempPasswordStore::class, 'cust_id');
  // }

  

  public function setPasswordAttribute($password)
  {
    $this->attributes['password'] = bcrypt($password);
  }

  public function setTransPasswordAttribute($trans_password)
  {
    $this->attributes['trans_password'] = bcrypt($trans_password);
  }



  public function scopeAdmin($query)
  {
    return $query->where('username', 'admin')->first();
  }

  public function scopeQueryPlacements($query, $direction, $sponser_id)
  {
    return $query->where('sponsor_id', $sponser_id)
                  ->Where('direction', $direction)
                  ->orderBy('placement_id', 'desc');
  }

  public function scopeLastPlacement($query, $direction, $sponser_id = 1)
  {
    return $query->queryPlacements($direction, $sponser_id)->first();
  }

}
