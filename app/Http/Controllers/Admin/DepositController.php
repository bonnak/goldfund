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
    	$deposit = Deposit::find($id);
    	$deposit->status = 1;
        $deposit->issue_date = Carbon::today();
        $deposit->expire_date = Carbon::today()->addDays($deposit->plan->duration); 
    	$deposit->save();

        $deposit->sponsor_earning_commission()->create([
            'sponsor_id' => $deposit->owner->sponsor_id,
            'amount' => 4,
        ]);

    	return response()->json($deposit->toArray());
    }
}
