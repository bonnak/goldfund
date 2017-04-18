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
            'bankslip' => $request->bankslip
        ]); 

        //return response()->json(Deposit::with('plan')->find($deposit->id));
        return response()->json($this->paymentBox(Deposit::with('plan')->find($deposit->id)), 200);
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

    private function authorizeTransaction(Request $request)
    {
        if(is_null($request->trans_password))
            throw new InvalidPasswordException('This field is required.');

        if(! \Hash::check($request->trans_password, auth()->user()->trans_password))
        {
            throw new InvalidPasswordException('Invalid transaction password');
        }

        return 1;
    }

    private function depositOnceUntilExpiration()
    {
        $deposit = Deposit::where('cust_id' , auth()->user()->id)
                            ->whereIn('status', [0, 1])
                            ->first();        
            

        if($deposit) 
        {
            if($deposit->status == 0 && $deposit->paid == false)
            {
                throw new HttpException(422, 'Your deposit is not yet paid.'); 
            }
            else
            {
                throw new HttpException(422, 'You have already deposited.'); 
            }                   
        }
    }

    private function paymentBox($deposit)
    {
        $orderID    = 'deposit_' . $deposit->id;
        $userID     = auth()->user()->username;
        $orderID    = preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $orderID);
        $userID     = preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $userID);


        $options = [
            "public_key"  => env('GOURL_PUBLIC_KEY'),       
            "private_key" => env('GOURL_PRIVATE_KEY'),      
            "webdev_key"  =>  "",       
            "orderID"     => $orderID,                                      
            "userID"      => $userID,
            "userFormat"  => "COOKIE",
            "amount"      => 0,
            "amountUSD"   => $deposit->amount,
            "period"      => $deposit->plan->duration . ' DAYS',
            "iframeID"    => "",
            "language"    => 'en' 
        ];   


        payment_unrecognised();

        
        // Initialise Payment Class
        $box1 = new \Cryptobox ($options); 
        $paymentbox = $box1->display_cryptobox(false);
        $languages_list = display_language_box('en');


        return [
            'languages_list' => $languages_list,
            'paymentbox' => $paymentbox,
        ];
    }
}
