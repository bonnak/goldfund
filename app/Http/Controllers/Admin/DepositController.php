<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Deposit;
use App\Traits\DepositEarningTrait;

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
        $this->sponsorReceiveCommission($deposit); 
        $this->sponsorReceiveBinaryPairCommission($deposit);       
        
    	return response()->json($deposit->toArray());
    }
}
