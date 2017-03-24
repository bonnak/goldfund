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
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $deposit = Deposit::create([
    		'cust_id' => auth()->user()->id, 
    		'plan_id' => $request->input('plan_id'), 
    		'amount' => $request->input('amount'), 
            'status' => 0,
            'issue_date' => null,
            'expire_date' => null,
            'bankslip' => $request->bankslip
    	]);

    	// Broadcast a memerber just deposit.
        // event(new MemberDeposited(
        //     Deposit::with('owner')->where('id', $deposit->id)->first()
        // ));

        return response()->json($deposit->toArray());
    }

    public function history()
    {
        return Deposit::with('plan')
                        ->where('cust_id', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    public function upload(Request $request)
    {
        $photo = $request->file('file');

        if( is_null($photo) || !$photo->isValid()) 
        {
            throw new HttpException(403, 'uploaded file is corrupted.');
        }

        //$photo->store('images/deposit/bankslip');

        //return  'data:image/jpeg;base64,' . base64_encode(\Storage::get($photo->store('images/deposit/bankslip')));
        
        return $photo->store('images/deposit/bankslip');
    }
}
