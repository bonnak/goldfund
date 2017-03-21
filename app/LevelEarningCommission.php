<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Deposit;
use App\Customer;

class LevelEarningCommission extends Model
{
    protected $table = 'level_earning_commissions';

    protected $fillable = [ 'cust_id', 'deposit_id', 'amount', 'level_number' ];

    public function deposit()
	{
		return $this->belongsTo(Deposit::class, 'deposit_id', 'id');
	}

	public function owner()
	{
		return $this->belongsTo(Customer::class, 'cust_id', 'id');
	}
}
