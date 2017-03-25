<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Deposit;
use App\SponsorEarningCommission;
use App\Earning;
use App\DailyEarningTaskLog;

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

    protected function ownerReceiveDailyEarning($deposit)
    {    
        $deposit->owner->daily_earning_commission()->create([
            'plan_id'       => $deposit->plan->id,
            'deposit_id'    => $deposit->id,
            'amount'        => $deposit->amount * $deposit->plan->daily, 
            'status'        => 0,
        ]);
    }


    protected function sponsorReceiveCommission($deposit)
    {        
        if(is_null($deposit->owner->deposit) || $deposit->owner->deposit->status != 1) return;        

        $deposit->sponsor_earning_commission()->create([
            'sponsor_id' => $deposit->owner->sponsor->id,
            'amount' => $deposit->amount * $deposit->plan->sponsor,
            'status'        => 0,
        ]);        
    }

    protected function levelsReceiveCommission($deposit)
    {
        


        $deposit->owner->levels()->each(function ($upline, $key) use ($deposit){

            $level_number = $key + 1;
            $sponsor_level = $deposit->plan->sponsor_levels()->where('level', $level_number)->first();  

            // if($sponsor_level === null)  
            // {
            //     throw new \Symfony\Component\HttpKernel\Exception\HttpException(
            //         422, 
            //         $upline->username . '   ' . $key
            //     );
            // }

            if($sponsor_level === null) return false;
            if(is_null($upline->deposit) || $upline->deposit->status != 1) return;    

            $deposit->level_earning_commission()->create([
                'cust_id' => $upline->id,
                'amount' => $deposit->amount * $sponsor_level->commission,
                'level_number' => $level_number,
                'status'        => 0,
            ]);
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

        if($deposit_owner_side->isEmpty()) return;
        if($other_side->isEmpty()) return;
        
        
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

        // No another side pair
        if($other_side->count() < $current_level + 1) return;  


        //Pair counted within one month.
        $deposit_owner_created_date = Carbon::createFromFormat('Y-m-d H:i:s', $deposit_owner_side[$current_level]->created_at);
        if($deposit_owner_created_date->diffInMonths(Carbon::today()) > 0) return;
        $other_side_created_date = Carbon::createFromFormat('Y-m-d H:i:s', $other_side[$current_level]->created_at);
        if($other_side_created_date->diffInMonths(Carbon::today()) > 0) return;     
        
        
        // does both right and left children deposited and deposit is active?
        if(!is_null($deposit_owner_side[$current_level]->deposit()->where('status', 1)->first()) &&
           !is_null($other_side[$current_level]->deposit()->where('status', 1)->first()))
        {
            $deposit_amount = $deposit_owner_side[$current_level]->deposit->amount < $other_side[$current_level]->deposit->amount ?
                                                    $deposit_owner_side[$current_level]->deposit->amount : 
                                                    $other_side[$current_level]->deposit->amount;

            // Add commission.
            $sponsor->binary_earning_commissions()->create([
                'left_child_id'     => $deposit_owner_side[$current_level]->direction == 'L' ? $deposit_owner_side[$current_level]->id : $other_side[$current_level]->id,
                'right_child_id'    => $deposit_owner_side[$current_level]->direction == 'R' ? $deposit_owner_side[$current_level]->id : $other_side[$current_level]->id,
                'amount'            => $deposit_amount * $deposit->plan->pairing,
                'status'        => 0,
            ]);
        }
        
    }
} 