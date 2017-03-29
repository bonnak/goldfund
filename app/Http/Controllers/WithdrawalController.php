<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;
use App\BinaryEarningCommission;
use App\Withdrawal;
use App\LevelEarningCommission;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Traits\WithdrawalTrait;

class WithdrawalController extends Controller
{
    use WithdrawalTrait;

    protected function getBalance()
    {
        $this->allowWithdrawal();

        return $this->currentBalance();    	
    }

    public function cashOut(Request $request)
    {
        $this->validateUserIsActive();
        $this->allowWithdrawal();       
        $this->allowRangeAmount($request);
        $this->modifyAmountEachWithdrawal($request);
    	

    	return Withdrawal::create([
    		'cust_id'	=> auth()->user()->id,
    		'amount'	=> $request->withdraw_amount,
            'status'    => 0,
    	]);
    }

    public function cancel(Request $request)
    {
        $withdrawal = Withdrawal::find($request->id);

        if(is_null($withdrawal)) throw new HttpException(404, 'Withdrawal not found.');

        $withdrawal->status = 2;
        $withdrawal->save();

        return $this->history();
    }

    public function getData()
    {
		return [
    		'balance' => $this->currentBalance(),
    	];   	   	
    }

    public function history()
    {
    	return Withdrawal::with('owner')
    					->where('cust_id', auth()->user()->id)
    					->orderBy('created_at', 'decs')
    					->paginate(10);
    }
}
