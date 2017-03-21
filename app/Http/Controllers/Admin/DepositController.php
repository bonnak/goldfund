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
                            if(!is_null($customer = Customer::where('username', 'like', $query_string . '%')->first()))
                            {
                                $query->where('cust_id', $customer->id);
                            }   
                        }                     
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(request()->input('size'));
    }

    public function approve($id)
    {
      	$deposit = $this->activateDepositAccount($id);
              
        $this->ownerReceiveDailyEarning($deposit);
        $this->sponsorReceiveCommission($deposit); 
        $this->levelsReceiveCommission($deposit); 
        $this->sponsorReceiveBinaryPairCommission($deposit);       
        
    	return response()->json($deposit->toArray());
    }
}
