<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Deposit;
use App\Customer;
use App\Plan;
use App\Events\MemberDeposited;
use App\Http\Requests\DepositRequest;
use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\QRCode;
use Illuminate\Support\Facades\Storage;

class DepositController extends Controller
{
	public function showForm()
	{
		$plans = Plan::all();
        $admin_account = Customer::admin()->bitcoin_account;
        $admin_qr_account = (new QRCode($admin_account, new QRImage))->output();

		return view('deposit', compact('plans', 'admin_account', 'admin_qr_account'));
	}

    public function create(DepositRequest $request)
    {
        //return '<img src="' . Storage::url($request->invoice_attachment->store('public/images/invoices')) . '">';

    	$deposit = Deposit::create([
    		'cust_id' => auth()->user()->id, 
    		'plan_id' => $request->input('plan_id'), 
    		'amount' => $request->input('amount'), 
    		'issue_date' => Carbon::now(),  
    		'expire_date' => Carbon::now()->addDay(30),
            'invoice_attachment' => $request->invoice_attachment->store('public/images/invoices')
    	]);

    	// Broadcast a memerber just deposit.
        event(new MemberDeposited(
            Deposit::with('owner')->where('id', $deposit->id)->first()
        ));

        return redirect()->back();
    }
}
