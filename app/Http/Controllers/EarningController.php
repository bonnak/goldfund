<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;

class EarningController extends Controller
{
    public function getData()
    {
    	$day_left = Carbon::createFromFormat('Y-m-d', auth()->user()->deposit->expire_date)->diffInDays(Carbon::today());
    	$earning = Earning::where('cust_id', auth()->user()->id)->sum('amount');

    	return [
    		'day_left' => $day_left,
    		'earning' => $earning,
    	];    	
    }
}
