<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Deposit;

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

    	return response()->json($deposit->toArray());
    }
}
