<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plan;

class PlanController extends Controller
{
    public function all()
	{
		$plans = Plan::with('sponsor_levels')->get();

		return $plans->toArray();
	}
}
