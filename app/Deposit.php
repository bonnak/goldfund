<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\Plan;
use App\SponsorEarningCommission;
use App\LevelEarningCommission;
use App\Earning;
use App\CryptoPayment;

class Deposit extends Model
{
    protected $table = 'deposits';

    protected $fillable = [ 
	  	'cust_id', 'plan_id', 'amount', 
	  	'status', 'issue_date',  'expire_date', 
	  	'bankslip', 'paid',
	];

	public function owner()
	{
		return $this->belongsTo(Customer::class, 'cust_id', 'id');
	}

	public function plan()
	{
		return $this->belongsTo(Plan::class, 'plan_id', 'id');
	}

	public function sponsor_earning_commission()
	{
		return $this->hasOne(SponsorEarningCommission::class, 'deposit_id', 'id');
	}

	public function level_earning_commission()
	{
		return $this->hasMany(LevelEarningCommission::class, 'deposit_id', 'id');
	}

	public function daily_earning()
	{
		return $this->hasMany(Earning::class, 'deposit_id', 'id');
	}

	public function crypto_payment()
	{
		return $this->hasOne(CryptoPayment::class, 'orderID', 'id');
	}
}
