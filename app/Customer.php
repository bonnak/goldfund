<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Deposit;
use App\BinaryEarningCommission;
use App\SponsorEarningCommission;
use App\Earning;

class Customer extends Authenticatable
{
  use HasApiTokens, Notifiable;


  protected $table = 'customers';

  protected $fillable = [ 
  	'username', 'email', 'password', 'is_active', 
  	'first_name', 'last_name', 'gender', 'country_id',
  	'date_of_birth', 'bitcoin_account', 'sponsor_id', 
    'placement_id', 'direction', 'agree_term_condition',
    'email_verified', 'verified_token', 'trans_password',
    'confirmed', 'image',
  ];

  protected $hidden = [
    'password', 'trans_password', 'remember_token',
  ];

  public function sponsor()
  {
  	 return $this->belongsTo('App\Customer', 'sponsor_id', 'id');
  }

  public function country()
  {
    return $this->belongsTo(Country::class, 'country_id')->select('id', 'name');
  }

  // public function password_store()
  // {
  //   return $this->hasOne(TempPasswordStore::class, 'cust_id');
  // }
   
  public function children()
  {
    return $this->hasMany(Customer::class, 'sponsor_id', 'id');
  }

  public function deposits()
  {
    return $this->hasMany(Deposit::class, 'cust_id', 'id');
  }

  public function deposit()
  {
    return $this->hasOne(Deposit::class, 'cust_id', 'id')->where('status', 1);
  }

  public function binary_earning_commissions()
  {
    return $this->hasMany(BinaryEarningCommission::class, 'cust_id', 'id');
  }

  public function sponsor_earning_commission()
  {
    return $this->hasMany(SponsorEarningCommission::class, 'sponsor_id', 'id');
  }

  public function daily_earning_commission()
  {
    return $this->hasMany(Earning::class, 'cust_id', 'id');
  }

  

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

  public function scopeLastPlacement($query, $direction, $sponsor_id = 1)
  {
    $result = $this->queryPlacements($direction, $sponsor_id)->first();

    if($result === null){
      $result = $this->where('id', $sponsor_id)->first();

      if($result === null)
      {
        $result = $this->whereNull('sponsor_id')->first();
      }
    }

    return  $result;
  }

  /**
   * Whether customer allow to deposit (0: pending, 1: approved, 2: expired)
   * 
   * @return Boolean
   */
  public function allowDeposit()
  {
    if($this->deposit()->where('status', '!=', 1)->first() !== null)
    {
      return false;
    }

    return true;
  }

  public function levels()
  {        
    $collection = collect([]);
    $up_line = $this->sponsor->sponsor;

    while(!is_null($up_line))
    {      
      $collection->push($up_line);
      $up_line = $up_line->sponsor;
    }

    return $collection; 
  }

}
