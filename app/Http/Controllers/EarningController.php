<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;

class EarningController extends Controller
{
    public function getData()
    {
    	$deposit = auth()->user()->deposit;

    	$day_left = $deposit !== null ? Carbon::createFromFormat('Y-m-d', $deposit->expire_date)->diffInDays(Carbon::today()) : 0;
    	$earning = Earning::where('cust_id', auth()->user()->id)->sum('amount');
        $sponsor = SponsorEarningCommission::where('sponsor_id', auth()->user()->id)->sum('amount');


    	return [
    		'day_left'  => $day_left,
    		'earning'   => $earning,
            'sponsor'   => $sponsor,
    	];    	
    }
}
