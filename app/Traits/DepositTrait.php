<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Deposit;
use App\Payment\Cryptobox;
use App\Exceptions\InvalidPasswordException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

trait DepositTrait
{
	public function authorizeTransaction(Request $request)
    {
        if(is_null($request->trans_password))
            throw new InvalidPasswordException('This field is required.');

        if(! \Hash::check($request->trans_password, auth()->user()->trans_password))
        {
            throw new InvalidPasswordException('Invalid transaction password');
        }

        return 1;
    }

    public function depositOnceUntilExpiration()
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

    public function cryptoBox($deposit)
    {
        $orderID    = $deposit->id . '_' . Carbon::now()->timestamp;
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
        
        // Initialise Payment Class
        $box1 = new Cryptobox ($options); 
        $paymentbox = $box1->display_cryptobox(false);
        //$languages_list = display_language_box('en');


        return [
            //'languages_list' => $languages_list,
            'paymentbox' => $paymentbox,
        ];
    }
}