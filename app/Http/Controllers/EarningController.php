<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;
use App\BinaryEarningCommission;
use App\Customer;

class EarningController extends Controller
{
    public function getData()
    {
    	$deposit = auth()->user()->deposit;

    	$day_left = $deposit !== null ? Carbon::createFromFormat('Y-m-d', $deposit->expire_date)->diffInDays(Carbon::today()) : 0;
    	$earning = Earning::where('cust_id', auth()->user()->id)->sum('amount');
        $sponsor = SponsorEarningCommission::where('sponsor_id', auth()->user()->id)->sum('amount');
        $binary = BinaryEarningCommission::where('cust_id', auth()->user()->id)->sum('amount');


    	return [
    		'day_left'  => $day_left,
    		'earning'   => $earning,
            'sponsor'   => $sponsor,
            'binary'    => $binary,
    	];    	
    }

    public function transactions()
    {
        $binary = BinaryEarningCommission::with(['sponsor', 'left_child', 'right_child'])
                        ->where('cust_id', auth()->user()->id)
                        ->get()
                        ->map(function($item, $key){
                            return 'You receive $' . $item->amount . 
                                    ' from binary pair (' . $item->left_child->username . ' - ' . $item->right_child->username .')' .
                                    ' on ' . $item->created_at;
                        });

        $level = SponsorEarningCommission::where('sponsor_id', auth()->user()->id)->get()
                     ->map(function($item, $key){
                        return 'You receive $' . $item->amount . ' from sponsor level on ' . $item->created_at . '.'; 
                     });

        $earning = Earning::where('cust_id', auth()->user()->id)
                    ->get()
                    ->map(function($item, $key){
                        return 'You receive $' . $item->amount . ' from earning on ' . $item->created_at;
                    });

        
        return collect([$level, $binary, $earning])->flatten();
    }
}
