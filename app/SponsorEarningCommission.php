<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Deposit;
use App\Customer;

class SponsorEarningCommission extends Model
{
    protected $table = 'sponsor_earning_commissions';

    protected $fillable = [ 'sponsor_id', 'deposit_id', 'amount', 'status' ];

    public function deposit()
	{
		return $this->belongsTo(Deposit::class, 'deposit_id', 'id');
	}

	public function owner()
	{
		return $this->belongsTo(Customer::class, 'sponsor_id', 'id');
	}
}
