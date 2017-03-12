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
        $this->sponsorReceiveBinaryPairCommission($deposit);       
        
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
        $deposit->owner->hierachy()->each(function ($upline, $key) use ($deposit){

            $sponsor_level = $deposit->plan->sponsor_levels()->where('level', $key + 1)->first();

            if($sponsor_level === null) return false;

            if($upline->deposit !== null && $upline->deposit->status == 1)
            {
                $deposit->sponsor_earning_commission()->create([
                    'sponsor_id' => $upline->id,
                    'amount' => $deposit->amount * $sponsor_level->commission,
                ]);
            }
        });
    }

    private function sponsorReceiveBinaryPairCommission($deposit)
    {
        // who is direct sponsor?
        $owner = $deposit->owner;
        $sponsor = $owner->sponsor;

        // does the number of left children equal to right children?
        $deposit_owner_side = $sponsor->children()->where('direction', $owner->direction)->orderBy('placement_id')->get();
        $other_side = $sponsor->children()->where('direction', ($owner->direction == 'L' ? 'R' : 'L'))->orderBy('placement_id')->get();
        

        if($deposit_owner_side->count() === $other_side->count())
        {
            // Current level.
            $current_level = $deposit_owner_side->search(function ($item, $key) use ($owner){
                return $item->id == $owner->id;
            });
            
            // does both right and left children deposited and deposit is active?
            if(($deposit_owner_side[$current_level]->deposit !== null && $deposit_owner_side[$current_level]->deposit->status == 1) &&
               ($other_side[$current_level]->deposit !== null && $other_side[$current_level]->deposit->status == 1 ))
            {
                $deposit_amount = $deposit_owner_side[$current_level]->deposit->amount < $other_side[$current_level]->deposit->amount ?
                                $deposit_owner_side[$current_level]->deposit->amount : $other_side[$current_level]->deposit->amount;

                $sponsor->binary_earning_commissions()->create([
                    'left_child_id'     => $deposit_owner_side[$current_level]->direction == 'L' ? $deposit_owner_side[$current_level]->id : $other_side[$current_level]->id,
                    'right_child_id'    => $deposit_owner_side[$current_level]->direction == 'R' ? $deposit_owner_side[$current_level]->id : $other_side[$current_level]->id,
                    'amount'            => $deposit_amount * $deposit->plan->pairing,
                ]);
            }
        }
        
    }
}
