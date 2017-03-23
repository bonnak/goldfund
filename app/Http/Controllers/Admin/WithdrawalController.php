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
    				->where('status', 0)
    				->paginate(request()->input('size'));
    }

    public function approve(Request $request)
    {
    	$withdrawal = Withdrawal::find($request->id);

    	if(is_null($withdrawal)) throw new HttpException(422, 'Withdrawal not found');

    	$withdrawal->status = 1;
    	$withdrawal->save();

    	return $withdrawal;
    }
}
