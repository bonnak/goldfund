<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';

    protected $fillable = [ 
	  	'cust_id', 'plan_id', 'amount', 'issue_date',  'expire_date',
	];

	public function owner()
	{
		return $this->belongsTo('App\Customer', 'cust_id', 'id');
	}
}
