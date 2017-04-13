<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
    	if(!request()->exists('deposit_amount')) throw new HttpException(403, 'No deposit.');


    	$deposit_amount = request()->input('deposit_amount');
		$orderID	= 'deposit_' . Carbon::now()->timestamp;//is_null(auth()->user()) ? 'deposit_unknown' : 'deposit_' . auth()->user()->deposit->id;
		$userID		= is_null(auth()->user()) ? '' : auth()->user()->username;
		$orderID	= preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $orderID);
		$userID		= preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $userID);


		$options = [
			"public_key"  => env('GOURL_PUBLIC_KEY'), 		
			"private_key" => env('GOURL_PRIVATE_KEY'), 		
			"webdev_key"  =>  "", 		
			"orderID"     => $orderID,  									
			"userID" 	  => $userID,
			"userFormat"  => "COOKIE",
			"amount" 	  => 0,
			"amountUSD"   => 0.5,
			"period"      => "60 DAYS",
			"iframeID"    => "",
			"language" 	  => 'en' 
		];   

		
		// Initialise Payment Class
		$box1 = new \Cryptobox ($options); 
		$paymentbox = $box1->display_cryptobox(false);
		$languages_list = display_language_box('en');
		$message = "";
	

		// A. Process Received Payment
		if ($box1->is_paid()) 
		{ 
			$message .= "A. User will see this message during ".$options["period"]." after payment has been made!";			
			$message .= "<br>".$box1->amount_paid()." ".$box1->coin_label()."  received<br>";	
		}  
		else $message .= "The payment has not been made yet";

		
		// B. One-time Process Received Payment
		if ($box1->is_paid() && !$box1->is_processed()) 
		{
			$message .= "B. User will see this message one time after payment has been made!";
			$box1->set_status_processed(); 
		}

		if(request()->ajax())
		{
			return response()->json([
				'languages_list' => $languages_list,
				'paymentbox' => $paymentbox,
			], 200);
		}

    	return view('payment.crypto', compact('languages_list', 'paymentbox', 'message'));
    }

    public function callBack()
    {   
     	require_once('../crypto_api/cryptobox.callback.php');  
    }
}
