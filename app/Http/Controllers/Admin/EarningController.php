<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Earning;

class EarningController extends Controller
{
    public function sendDailyMoney()
    {
    	return Earning::create([
    		'cust_id' => request()->owner['id'],
    		'plan_id' => request()->plan['id'],
    		'deposit_id' => request()->id,
    		'amount' => request()->amount * request()->plan['daily'],
    	]);
    }
}
