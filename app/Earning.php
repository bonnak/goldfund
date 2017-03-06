<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
	protected $table = 'earnings';

    protected $fillable = [
    	'cust_id', 'plan_id', 'deposit_id', 'amount',
    ];
}
