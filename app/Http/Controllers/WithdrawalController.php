<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;
use App\BinaryEarningCommission;
use App\Withdrawal;

class WithdrawalController extends Controller
{
    protected function getBalance()
    {
    	//$earning = Earning::where('cust_id', auth()->user()->id)->sum('amount');
        $sponsor = SponsorEarningCommission::where('sponsor_id', auth()->user()->id)->sum('amount');
        $binary = BinaryEarningCommission::where('cust_id', auth()->user()->id)->sum('amount');
        $withdrawal = Withdrawal::where('cust_id', auth()->user()->id)->sum('amount');


    	return ($sponsor + $binary) - $withdrawal; 
    }

    public function cashOut(Request $request)
    {
    	$balance = $this->getBalance(); 

    	if($request->withdraw_amount > $balance || $request->withdraw_amount <= 0)
    	{
    		return response()->json('Not allow to withdraw this amount', 403);
    	}

    	return Withdrawal::create([
    		'cust_id'	=> auth()->user()->id,
    		'amount'	=> $request->withdraw_amount,
    	]);
    }

    public function getData()
    {
		return [
    		'balance' => $this->getBalance(),
    	];   	   	
    }

    public function history()
    {
    	return Withdrawal::with('owner')
    					->where('cust_id', auth()->user()->id)
    					->orderBy('created_at', 'decs')
    					->get();
    }
}
