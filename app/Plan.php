<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
  	protected $table = 'plans';

	protected $fillable = [ 
	  	'name', 'description', 'min_deposit', 'max_deposit', 
	  	'sponsor', 'paring', 'daily', 'duration'
	];

	public function sponsor_levels()
	{
		return $this->hasMany(PlanLevelSponsor::class);
	}
}
