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
use App\Exceptions\InvalidPasswordException;
use App\Payment\Cryptobox;
use App\Traits\DepositTrait;

class DepositController extends Controller
{
    use DepositTrait;

	public function showForm()
	{
		$plans = Plan::all();
        $admin_account = Customer::admin()->bitcoin_account;
        $admin_qr_account = (new QRCode($admin_account, new QRImage))->output();

		return view('deposit', compact('plans', 'admin_account', 'admin_qr_account'));
	}

    public function create(DepositRequest $request)
    {
        $this->authorizeTransaction($request);
        $this->depositOnceUntilExpiration();

        $deposit = Deposit::create([
            'cust_id' => auth()->user()->id, 
            'plan_id' => $request->input('plan_id'), 
            'amount' => $request->input('amount'), 
            'status' => 0,
            'paid'  => false,
            'issue_date' => null,
            'expire_date' => null,
            //'bankslip' => $request->bankslip
        ]); 

        //return response()->json(Deposit::with('plan')->find($deposit->id));
        return response()->json($this->cryptoBox(Deposit::with('plan')->find($deposit->id)), 200);
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
        $validator = \Validator::make($request->all(),[
            'file' => 'mimes:jpeg,bmp,png|max:2048'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'error' => $validator->getMessageBag()->first()
            ], 403);
        }

        $photo = $request->file('file');

        if( is_null($photo) || !$photo->isValid()) 
        {
            throw new HttpException(403, 'File is corrupted.');
        }

        //$photo->store('images/deposit/bankslip');

        //return  'data:image/jpeg;base64,' . base64_encode(\Storage::get($photo->store('images/deposit/bankslip')));
        
        return 'storage/' . $photo->store('images/deposit/bankslip');
    }

    public function current()
    {
        $deposit = Deposit::with('plan')
                        ->where('cust_id', auth()->user()->id)
                        ->whereIn('status', [0, 1])
                        ->first();

        return response()->json([
            'deposit' => $deposit,
            'paymentbox' => !is_null($deposit) && $deposit->status == 0 && $deposit->paid == 0 ? $this->cryptoBox($deposit)['paymentbox'] : '',
        ], 200);
    }
}
