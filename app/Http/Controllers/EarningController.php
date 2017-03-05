<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EarningController extends Controller
{
    public function getData()
    {
    	return [
    		'day_left' => Carbon::createFromFormat('Y-m-d', auth()->user()->deposit->expire_date)->diffInDays(Carbon::today()),
    	];    	
    }
}
