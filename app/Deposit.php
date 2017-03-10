<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\Plan;
use App\SponsorEarningCommission;

class Deposit extends Model
{
    protected $table = 'deposits';

    protected $fillable = [ 
	  	'cust_id', 'plan_id', 'amount', 'status', 'issue_date',  'expire_date',
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
}
