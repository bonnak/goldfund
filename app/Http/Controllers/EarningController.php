<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;
use App\BinaryEarningCommission;
use App\Customer;
use App\LevelEarningCommission;

class EarningController extends Controller
{   
    public function transactions()
    {
        $binary = BinaryEarningCommission::with(['sponsor', 'left_child', 'right_child'])
                        ->where('cust_id', auth()->user()->id)
                        ->get()
                        ->map(function($item, $key){
                            return 'You receive $' . $item->amount . 
                                    ' from binary pair (' . $item->left_child->username . ' - ' . $item->right_child->username .')' .
                                    ' on ' . $item->created_at;
                        });

        $sponsor = SponsorEarningCommission::where('sponsor_id', auth()->user()->id)->get()
                     ->map(function($item, $key){
                        return 'You receive $' . $item->amount . ' from sponsor level on ' . $item->created_at . '.'; 
                     });

        $earning = Earning::where('cust_id', auth()->user()->id)
                    ->get()
                    ->map(function($item, $key){
                        return 'You receive $' . $item->amount . ' from earning on ' . $item->created_at;
                    });

        
        return collect([$sponsor, $binary, $earning])->flatten();
    }

    public function dailyEarning()
    {
        return Earning::with('plan')
                    ->where('cust_id', auth()->user()->id)
                    //->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }


    public function levelEarning()
    {
        return LevelEarningCommission::with('deposit.owner')
                                        ->where('cust_id', auth()->user()->id)
                                        //->where('status', 1)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
    }

    public function filterLevelEarning($level_number)
    {
        return LevelEarningCommission::with('deposit.owner')
                                        ->where('cust_id', auth()->user()->id)
                                        ->where('level_number', $level_number)
                                        //->where('status', 1)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
    }

    public function binaryEarning()
    {
        return BinaryEarningCommission::with(['left_child', 'right_child'])
                        ->where('cust_id', auth()->user()->id)
                        //->where('status', 1)
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    public function directEarning()
    {
        return SponsorEarningCommission::with('deposit.owner')
                                        ->where('sponsor_id', auth()->user()->id)
                                        //->where('status', 1)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
    }
}
