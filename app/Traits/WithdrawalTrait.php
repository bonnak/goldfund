<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;
use App\BinaryEarningCommission;
use App\Withdrawal;
use App\LevelEarningCommission;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait WithdrawalTrait
{
    protected function allowWithdrawal()
    {
        if(! auth()->user()->withdrawals
                    ->where('status', 0)
                    ->isEmpty())
        {
            throw new HttpException(403, 'You still have a withdrawal pending.');
        }
    }

    protected function validateUserIsActive()
    {
    	if(auth()->user()->is_active != 1) 
        {
            throw new HttpException(403, 'Your account is inactive or expiry.');
        }
    }

    protected function modifyAmountEachWithdrawal(Request $request)
    {
    	if($request->withdraw_amount % 10 !== 0)
        {
            throw new HttpException(403, 'Please withdraw eg. $10, $20, $30, ... $100.');
        }

        $balance = $this->getBalance(); 
    	if($request->withdraw_amount > $balance)            
    	{
    		throw new HttpException(403, 'Not allow to withdraw more than your balance.');
    	}
        
    }

    protected function allowRangeAmount(Request $request)
    {
    	if($request->withdraw_amount < 10 || $request->withdraw_amount > 500)
        {
            throw new HttpException(403, 'Withdrawal between 10 to 500 per day.');
        }
    }


    protected function currentBalance()
    {
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
} 