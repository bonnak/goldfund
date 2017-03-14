<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Deposit;
use App\Traits\DepositEarningTrait;
use App\Earning;
use Carbon\Carbon;

class DepositController extends Controller
{
    use DepositEarningTrait;

    public function history()
    {
    	return Deposit::with(['plan', 'owner'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(request()->input('size'));
    }

    public function approve($id)
    {
      	$deposit = $this->activateDepositAccount($id);


        $earning = Earning::where('cust_id', $deposit->owner->id)
                            ->where('created_at', '>=', Carbon::today())
                            ->first();


        if(is_null($earning))
        {
            Earning::create([
                'cust_id'       => $deposit->owner->id,
                'plan_id'       => $deposit->plan->id,
                'deposit_id'    => $deposit->id,
                'amount'        => $deposit->amount * $deposit->plan->daily,
            ]);
        }        

        $this->sponsorReceiveCommission($deposit); 
        $this->sponsorReceiveBinaryPairCommission($deposit);       
        
    	return response()->json($deposit->toArray());
    }
}
