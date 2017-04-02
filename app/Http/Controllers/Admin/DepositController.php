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

    public function getData()
    {       
        extract(request()->all());

    	return Deposit::with(['plan', 'owner'])
                    ->whereIn('status', is_array($status) ? $status : [$status])                   
                    ->where(function($inner_query) use ($query){
                        if($query == '') return;

                        $inner_query->whereIn(
                            'cust_id', 
                            Customer::where('username', 'like', $query . '%')
                                    ->orWhere('email', 'like', $query . '%')
                                    ->orWhere('bitcoin_account', 'like', $query . '%')
                                    ->get()
                                    ->pluck('id')
                        );                     
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate($per_page);
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
