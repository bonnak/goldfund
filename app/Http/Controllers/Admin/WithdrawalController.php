<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdrawal;
use App\Customer;

class WithdrawalController extends Controller
{
    public function getData()
    {       
        extract(request()->all());

        return Withdrawal::with('owner')
                    ->whereIn('status', is_array($status) ? $status : [$status])                   
                    ->where(function($inner_query) use ($query){
                        if($query == '') return;

                        $inner_query->whereIn(
                            'cust_id', 
                            Customer::where('username', 'like', $query . '%')
                                    ->orWhere('email', 'like', $query . '%')
                                    ->orWhere('bitcoin_account', 'like', $query . '%')
                                    ->get()
                                    ->pluck('id')
                        );                     
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate($per_page);
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

        $withdrawal->status = 2;
        $withdrawal->cancelled_by = auth()->user()->username;
        $withdrawal->save();

        return $withdrawal;
    }
}
