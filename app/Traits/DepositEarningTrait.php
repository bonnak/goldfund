<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Deposit;
use App\SponsorEarningCommission;

trait DepositEarningTrait
{
	protected function activateDepositAccount($deposit_id)
    {
        $deposit = Deposit::find($deposit_id);
        $deposit->status = 1;
        $deposit->issue_date = Carbon::today();
        $deposit->expire_date = Carbon::today()->addDays($deposit->plan->duration); 
        $deposit->save();

        return $deposit;
    }


    protected function sponsorReceiveCommission($deposit)
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

    protected function sponsorReceiveBinaryPairCommission($deposit)
    {
        // who is direct sponsor?
        $owner = $deposit->owner;
        $sponsor = $owner->sponsor;

        if(is_null($sponsor->deposit)) return;
        if($sponsor->deposit->status != 1) return;

        // does the number of left children equal to right children?
        $deposit_owner_side = $sponsor->children()->where('direction', $owner->direction)->orderBy('placement_id')->get();
        $other_side = $sponsor->children()->where('direction', ($owner->direction == 'L' ? 'R' : 'L'))->orderBy('placement_id')->get();
        
        
        // Current level.
        $current_level = $deposit_owner_side->search(function ($item, $key) use ($owner){
            return $item->id == $owner->id;
        });

        // Not allow to add more commission the same pair.
        if($sponsor->binary_earning_commissions()
                ->where(function ($query) use ($deposit_owner_side, $current_level){
                        $query->where('left_child_id', $deposit_owner_side[$current_level]->id)
                              ->orWhere('right_child_id', $deposit_owner_side[$current_level]->id);
                    })    
                ->count() > 0)
        {
        	return;
        }
        
        // does both right and left children deposited and deposit is active?
        if(($deposit_owner_side[$current_level]->deposit !== null && $deposit_owner_side[$current_level]->deposit->status == 1) &&
           ($other_side[$current_level]->deposit !== null && $other_side[$current_level]->deposit->status == 1 ))
        {
            $deposit_amount = $deposit_owner_side[$current_level]->deposit->amount < $other_side[$current_level]->deposit->amount ?
                            $deposit_owner_side[$current_level]->deposit->amount : $other_side[$current_level]->deposit->amount;

            // Add commission.
            $sponsor->binary_earning_commissions()->create([
                'left_child_id'     => $deposit_owner_side[$current_level]->direction == 'L' ? $deposit_owner_side[$current_level]->id : $other_side[$current_level]->id,
                'right_child_id'    => $deposit_owner_side[$current_level]->direction == 'R' ? $deposit_owner_side[$current_level]->id : $other_side[$current_level]->id,
                'amount'            => $deposit_amount * $deposit->plan->pairing,
            ]);
        }
        
    }
} 