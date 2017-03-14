<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Deposit;

class SponsorEarningCommission extends Model
{
    protected $table = 'sponsor_earning_commissions';

    protected $fillable = [ 'sponsor_id', 'deposit_id', 'amount' ];

    public function deposit()
	{
		return $this->belongsTo(Deposit::class, 'deposit_id', 'id');
	}
}
