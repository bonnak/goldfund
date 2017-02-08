<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Deposit;
use App\Plan;
use App\Events\MemberDeposited;
use App\Http\Requests\DepositRequest;

class DepositController extends Controller
{
	public function showForm()
	{
		$plans = Plan::all();

		return view('deposit', compact('plans'));
	}

    public function create(DepositRequest $request)
    {
    	$deposit = Deposit::create([
    		'cust_id' => auth()->user()->id, 
    		'plan_id' => $request->input('plan_id'), 
    		'amount' => $request->input('amount'), 
    		'issue_date' => Carbon::now(),  
    		'expire_date' => Carbon::now()->addDay(30),
    	]);

        $deposit = Deposit::with('owner')
                    ->where('id', $deposit->id)
                    ->first();

    	// Broadcast a memerber just deposit.
        event(new MemberDeposited($deposit));

        return redirect()->back();
    }
}
