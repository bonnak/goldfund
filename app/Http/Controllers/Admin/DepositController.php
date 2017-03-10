<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Deposit;
use App\SponsorEarningCommission;

class DepositController extends Controller
{
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
        
    	return response()->json($deposit->toArray());
    }


    private function activateDepositAccount($deposit_id)
    {
        $deposit = Deposit::find($deposit_id);
        $deposit->status = 1;
        $deposit->issue_date = Carbon::today();
        $deposit->expire_date = Carbon::today()->addDays($deposit->plan->duration); 
        $deposit->save();

        return $deposit;
    }


    private function sponsorReceiveCommission($deposit)
    {
        if(($level = $deposit
                        ->owner->sponsor->children
                        ->where('direction', $deposit->owner->direction)
                        ->sortBy('placement_id')
                        ->pluck('id')
                        ->search($deposit->owner->id)) !== false)
        {
            $sponsor_level = $deposit
                ->plan
                ->sponsor_levels()
                ->where('level', $level + 1)
                ->first();
        

            $deposit->sponsor_earning_commission()->create([
                'sponsor_id' => $deposit->owner->sponsor_id,
                'amount' => $deposit->amount * $sponsor_level->commission,
            ]);
        }
    }
}
