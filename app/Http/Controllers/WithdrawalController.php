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

class WithdrawalController extends Controller
{
    protected function getBalance()
    {
        $this->allowWithdrawal();


    	$earning = Earning::where('cust_id', auth()->user()->id)
                            ->where('status', 1)
                            ->sum('amount');
        $sponsor = SponsorEarningCommission::where('sponsor_id', auth()->user()->id)
                            ->where('status', 1)
                            ->sum('amount');
        $level = LevelEarningCommission::where('cust_id', auth()->user()->id)
                            ->where('status', 1)
                            ->sum('amount');
        $binary = BinaryEarningCommission::where('cust_id', auth()->user()->id)
                            ->where('status', 1)
                            ->sum('amount');
        $withdrawal = Withdrawal::where('cust_id', auth()->user()->id)
                            ->where('status', 1)
                            ->sum('amount');


    	return ($earning + $sponsor + $binary + $level) - $withdrawal; 
    }

    public function cashOut(Request $request)
    {
        if(auth()->user()->is_active != 1) 
        {
            throw new HttpException(403, 'Your account is inactive or expiry.');
        }

        $this->allowWithdrawal();

    	$balance = $this->getBalance(); 
    	if($request->withdraw_amount > $balance)            
    	{
    		throw new HttpException(403, 'Not allow to withdraw more than your balance.');
    	}

        if($request->withdraw_amount < 10 || $request->withdraw_amount > 500)
        {
            throw new HttpException(403, 'Withdrawal between 10 to 500 per day.');
        }

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

    private function allowWithdrawal()
    {
        if(! auth()->user()->withdrawals
                    ->where('created_at', '>=', Carbon::today())
                    ->isEmpty())
        {
            throw new HttpException(403, 'You can only withdraw once per day.');
        }
    }
}
