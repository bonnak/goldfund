<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;
use App\Payment\Cryptobox;
use App\Deposit;
use App\Customer;
use App\Traits\DepositEarningTrait;

class PaymentController extends Controller
{
	use DepositEarningTrait;

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
			"amountUSD"   => $deposit_amount,
			"period"      => "60 DAYS",
			"iframeID"    => "",
			"language" 	  => 'en' 
		];   

		
		// Initialise Payment Class
		$box1 = new Cryptobox ($options); 
		$paymentbox = $box1->display_cryptobox(false);
		$languages_list = [];//display_language_box('en');
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

		// if(request()->ajax())
		// {
		// 	return response()->json([
		// 		'languages_list' => $languages_list,
		// 		'paymentbox' => $paymentbox,
		// 	], 200);
		// }

    	return view('payment.crypto', compact('languages_list', 'paymentbox', 'message'));
    }

    public function callBack()
    {        	
     	// a.
		if ($_POST) foreach ($_POST as $k => $v) if (is_string($v)) $_POST[$k] = trim($v);


		// b. check if private key valid
		$valid_key = false;
		if (isset($_POST["private_key_hash"]) && strlen($_POST["private_key_hash"]) == 128 && preg_replace('/[^A-Za-z0-9]/', '', $_POST["private_key_hash"]) == $_POST["private_key_hash"])
		{
		    $keyshash = array();
		    $arr = explode("^", config('cryptobox.CRYPTOBOX_PRIVATE_KEYS'));
		    foreach ($arr as $v) $keyshash[] = strtolower(hash("sha512", $v));
		    if (in_array(strtolower($_POST["private_key_hash"]), $keyshash)) $valid_key = true;
		}

		// c.
		if (isset($_POST["plugin_ver"]) && !isset($_POST["status"]) && $valid_key)
		{
			echo "cryptoboxver_php_" . config('cryptobox.CRYPTOBOX_VERSION');
			die; 
		}


		// d.
		if (isset($_POST["status"]) && in_array($_POST["status"], array("payment_received", "payment_received_unrecognised")) &&
				$_POST["box"] && is_numeric($_POST["box"]) && $_POST["box"] > 0 && $_POST["amount"] && is_numeric($_POST["amount"]) && $_POST["amount"] > 0 )
		{
			
			foreach ($_POST as $k => $v)
			{
				if ($k == "datetime") 							$mask = '/[^0-9\ \-\:]/';
				elseif (in_array($k, array("err", "date")))		$mask = '/[^A-Za-z0-9\.\_\-\@\ ]/';
				else											$mask = '/[^A-Za-z0-9\.\_\-\@]/';
				if ($v && preg_replace($mask, '', $v) != $v) 	$_POST[$k] = "";
			}
			
			if (!$_POST["amountusd"] || !is_numeric($_POST["amountusd"]))	$_POST["amountusd"] = 0;
			if (!$_POST["confirmed"] || !is_numeric($_POST["confirmed"]))	$_POST["confirmed"] = 0;
			
			
			$dt			= gmdate('Y-m-d H:i:s');
			// $obj 		= run_sql("select paymentID, txConfirmed from crypto_payments where boxID = ".$_POST["box"]." && orderID = '".$_POST["order"]."' && userID = '".$_POST["user"]."' && txID = '".$_POST["tx"]."' && amount = ".$_POST["amount"]." && addr = '".$_POST["addr"]."' limit 1");
			$obj 		= \DB::selectOne("select paymentID, txConfirmed from crypto_payments where boxID = ".$_POST["box"]." && orderID = '".$_POST["order"]."' && userID = '".$_POST["user"]."' && txID = '".$_POST["tx"]."' && amount = ".$_POST["amount"]." && addr = '".$_POST["addr"]."' limit 1");
			
			$paymentID		= ($obj) ? $obj->paymentID : 0;
			$txConfirmed	= ($obj) ? $obj->txConfirmed : 0; 
			
			// Save new payment details in local database
			if (!$paymentID)
			{
				$sql = "INSERT INTO crypto_payments (boxID, boxType, orderID, userID, countryID, coinLabel, amount, amountUSD, unrecognised, addr, txID, txDate, txConfirmed, txCheckDate, recordCreated, deposit_id)
						VALUES (".$_POST["box"].", '".$_POST["boxtype"]."', '".$_POST["order"]."', '".$_POST["user"]."', '".$_POST["usercountry"]."', '".$_POST["coinlabel"]."', ".$_POST["amount"].", ".$_POST["amountusd"].", ".($_POST["status"]=="payment_received_unrecognised"?1:0).", '".$_POST["addr"]."', '".$_POST["tx"]."', '".$_POST["datetime"]."', ".$_POST["confirmed"].", '$dt', '$dt', " . explode('_', $_POST['order'])[0] .")";

				// $paymentID = run_sql($sql);
				$paymentID = \DB::insert($sql);
				
				$box_status = "cryptobox_newrecord";
			}
			// Update transaction status to confirmed
			elseif ($_POST["confirmed"] && !$txConfirmed)
			{
				$sql = "UPDATE crypto_payments SET txConfirmed = 1, txCheckDate = '$dt' WHERE paymentID = $paymentID LIMIT 1";
				// run_sql($sql);
				\DB::update($sql);
				
				$box_status = "cryptobox_updated";
			}
			else 
			{
				$box_status = "cryptobox_nochanges";
			}
			
			
			/**
			 *  User-defined function for new payment - cryptobox_new_payment(...)
			 *  For example, send confirmation email, update database, update user membership, etc.
			 *  You need to modify file - cryptobox.newpayment.php
			 *  Read more - https://gourl.io/api-php.html#ipn
		         */

			// if (in_array($box_status, array("cryptobox_newrecord", "cryptobox_updated")) && function_exists('cryptobox_new_payment')) cryptobox_new_payment($paymentID, $_POST, $box_status);
			if (in_array($box_status, array("cryptobox_newrecord", "cryptobox_updated"))) 
			{
				$this->cryptobox_new_payment($paymentID, $_POST, $box_status);
			}
		}   

		else
			$box_status = "Only POST Data Allowed";


		echo $box_status; // don't delete it     
	}

    function cryptobox_new_payment($paymentID = 0, $payment_details = array(), $box_status = "")
    {
    	if($payment_details['status'] != 'payment_received') return;

    	$deposit = Deposit::where('cust_id', Customer::where('username', $payment_details['user'])->first()->id)
                        ->where('id', $payment_details['order'])
                        ->where('status', 0)
                        ->where('paid', false)
                        ->first();

        if(!is_null($deposit))
        {        
        	$this->activateDepositAccount($deposit);
        	$this->sponsorReceiveCommission($deposit); 
	        $this->levelsReceiveCommission($deposit); 
	        $this->sponsorReceiveBinaryPairCommission($deposit);  
        }
    }
}
