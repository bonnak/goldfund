<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Plan;

class Earning extends Model
{
	protected $table = 'earnings';

    protected $fillable = [
    	'cust_id', 'plan_id', 'deposit_id', 'amount',
    ];

    public function plan()
	{
		return $this->belongsTo(Plan::class, 'plan_id', 'id');
	}
}
