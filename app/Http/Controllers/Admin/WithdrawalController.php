<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdrawal;

class WithdrawalController extends Controller
{
    public function getData()
    {
    	return Withdrawal::with('owner')
    				//->where('status', 0)
                    ->orderBy('created_at', 'desc')
    				->paginate(request()->input('size'));
    }

    public function approve(Request $request)
    {
    	$withdrawal = Withdrawal::where('id', $request->id)
                                ->where('cust_id', $request->owner['id'])
                                ->where('status', 0)
                                ->first();

    	if(is_null($withdrawal)) throw new HttpException(422, 'Withdrawal not found');

        $withdrawal->status = 1;
    	$withdrawal->approved_by = auth()->user()->username;
    	$withdrawal->save();

    	 return $withdrawal;
    }

    public function cancel(Request $request)
    {
        $withdrawal = Withdrawal::where('id', $request->id)
                                ->where('cust_id', $request->owner['id'])                                
                                ->where('status', 0)
                                ->first();

        if(is_null($withdrawal)) throw new HttpException(422, 'Withdrawal not found');

        $withdrawal->status = 3;
        $withdrawal->cancelled_by = auth()->user()->username;
        $withdrawal->save();

        return $withdrawal;
    }
}
