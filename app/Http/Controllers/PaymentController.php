<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
		$orderID	=  'deposit_';
		$userID		= '';
		$orderID = preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $orderID);
		$userID = preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $userID);


		$options = array( 
		"public_key"  => "9812AAVkUmYBitcoin77BTCPUBCa2dR770wNNstdk7hmp8s3ew", 		
		"private_key" => "9812AAVkUmYBitcoin77BTCPRV6pwgOMgxMq81Fn9nMCnWTGrm", 		
		"webdev_key" =>  "", 		
		"orderID"     => $orderID,  									
		"userID" 	  => $userID,
		"userFormat"  => "COOKIE",
		"amount" 	  => 0,
		"amountUSD"   => 1,
		"period"      => "60 DAYS",
		"iframeID"    => "",
		"language" 	  => 'en' 
		);   

		
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
