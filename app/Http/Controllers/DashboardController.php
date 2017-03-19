<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;
use App\BinaryEarningCommission;
use App\Customer;
use App\Withdrawal;
use App\Deposit;
use App\LevelEarningCommission;

class DashboardController extends Controller
{
    public function getData()
    {
    	$deposit = Deposit::where('cust_id', auth()->user()->id)
                            ->where('status', 1)
                            ->first();

    	$day_left = $deposit !== null ? Carbon::createFromFormat('Y-m-d', $deposit->expire_date)->diffInDays(Carbon::today()) : 0;
    	$earning = Earning::where('cust_id', auth()->user()->id)->sum('amount');
        $sponsor = SponsorEarningCommission::where('sponsor_id', auth()->user()->id)->sum('amount');
        $level = LevelEarningCommission::where('cust_id', auth()->user()->id)->sum('amount');
        $binary = BinaryEarningCommission::where('cust_id', auth()->user()->id)->sum('amount');
        $withdrawal = Withdrawal::where('cust_id', auth()->user()->id)->sum('amount');
        $active_deposit = Deposit::where('cust_id', auth()->user()->id)
                                ->where('status', 1)
                                ->sum('amount');


    	return [
    		'day_left'        => $day_left,
    		'earning'         => $earning,
            'sponsor'         => $sponsor,
            'level'           => $level,
            'binary'          => $binary,
            'active_deposit'  => $active_deposit,
            'withdrawal'      => $withdrawal,
    	];    	
    }
}
