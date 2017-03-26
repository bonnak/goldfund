<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Deposit;
use App\Traits\DepositEarningTrait;
use App\Earning;
use Carbon\Carbon;
use App\Customer;

class DepositController extends Controller
{
    use DepositEarningTrait;

    public function history()
    {
        $query_string = request()->exists('query') ? request()->input('query') : '';

    	return Deposit::with(['plan', 'owner'])
                    ->where(function($query) use ($query_string){
                        if($query_string != ''){
                            $customer = Customer::where('username', 'like', $query_string . '%')
                                                ->orWhere('email', 'like', $query_string . '%')
                                                ->orWhere('bitcoin_account', 'like', $query_string . '%')
                                                ->get();

                            $query->whereIn('cust_id', is_null($customer) ? '' : $customer->pluck('id'));
                        }                     
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(request()->input('size'));
    }

    public function approve(Request $request)
    {
      	$deposit = $this->activateDepositAccount($request->id); 
        $this->sponsorReceiveCommission($deposit); 
        $this->levelsReceiveCommission($deposit); 
        $this->sponsorReceiveBinaryPairCommission($deposit);       
        
    	return response()->json($deposit->toArray());
    }
}
