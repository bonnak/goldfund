<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
  protected $table = 'plans';

	protected $fillable = [ 
	  	'name', 'description', 'min_cost', 'max_cost', 
	  	'sponsor', 'paring', 'daily', 'duration_exp'
	];
}
