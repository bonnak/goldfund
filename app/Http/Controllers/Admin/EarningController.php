<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Earning;
use Carbon\Carbon;

class EarningController extends Controller
{
    public function sendDailyMoney()
    {
    	$earning = Earning::where('cust_id', request()->owner['id'])
    						->where('created_at', '>=', Carbon::today())
                            ->first();


        if( $earning !== null && Carbon::today()->toDateString() == $earning->created_at->toDateString())
        {
            return response()->json([
                'error' => 'This account already received earning for today'
            ], 422);
        }
                        

    	return Earning::create([
    		'cust_id' => request()->owner['id'],
    		'plan_id' => request()->plan['id'],
    		'deposit_id' => request()->id,
    		'amount' => request()->amount * request()->plan['daily'],
    	]);
    }
}
