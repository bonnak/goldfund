<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Earning;
use App\SponsorEarningCommission;
use App\BinaryEarningCommission;
use App\Customer;

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

        $level = SponsorEarningCommission::where('sponsor_id', auth()->user()->id)->get()
                     ->map(function($item, $key){
                        return 'You receive $' . $item->amount . ' from sponsor level on ' . $item->created_at . '.'; 
                     });

        $earning = Earning::where('cust_id', auth()->user()->id)
                    ->get()
                    ->map(function($item, $key){
                        return 'You receive $' . $item->amount . ' from earning on ' . $item->created_at;
                    });

        
        return collect([$level, $binary, $earning])->flatten();
    }

    public function daily_earning()
    {
        return Earning::with('plan')
                    ->where('cust_id', auth()->user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }


    public function level_earning()
    {
        return SponsorEarningCommission::with('deposit.owner')
                                        ->where('sponsor_id', auth()->user()->id)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
    }

    public function binary_earning()
    {
        return BinaryEarningCommission::with(['left_child', 'right_child'])
                        ->where('cust_id', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
    }
}
