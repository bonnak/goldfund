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
		// if(!defined("CRYPTOBOX_WORDPRESS")) define("CRYPTOBOX_WORDPRESS", false);

		// if (!CRYPTOBOX_WORDPRESS) include_once("cryptobox.class.php");
		// elseif (!defined('ABSPATH')) exit; // Exit if accessed directly in wordpress


		// a.
		if ($_POST) foreach ($_POST as $k => $v) if (is_string($v)) $_POST[$k] = trim($v);


		// b. check if private key valid
		$valid_key = false;
		if (isset($_POST["private_key_hash"]) && strlen($_POST["private_key_hash"]) == 128 && preg_replace('/[^A-Za-z0-9]/', '', $_POST["private_key_hash"]) == $_POST["private_key_hash"])
		{
		    $keyshash = array();
		    $arr = explode("^", CRYPTOBOX_PRIVATE_KEYS);
		    foreach ($arr as $v) $keyshash[] = strtolower(hash("sha512", $v));
		    if (in_array(strtolower($_POST["private_key_hash"]), $keyshash)) $valid_key = true;
		}


		// c.
		if (isset($_POST["plugin_ver"]) && !isset($_POST["status"]) && $valid_key)
		{
			echo "cryptoboxver_" . (CRYPTOBOX_WORDPRESS ? "wordpress_" . GOURL_VERSION : "php_" . CRYPTOBOX_VERSION);
			die; 
		}


		// d.
		if (isset($_POST["status"]) && in_array($_POST["status"], array("payment_received", "payment_received_unrecognised")) &&
				$_POST["box"] && is_numeric($_POST["box"]) && $_POST["box"] > 0 && $_POST["amount"] && is_numeric($_POST["amount"]) && $_POST["amount"] > 0 && $valid_key)
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
			$obj 		= run_sql("select paymentID, txConfirmed from crypto_payments where boxID = ".$_POST["box"]." && orderID = '".$_POST["order"]."' && userID = '".$_POST["user"]."' && txID = '".$_POST["tx"]."' && amount = ".$_POST["amount"]." && addr = '".$_POST["addr"]."' limit 1");
			
			
			$paymentID		= ($obj) ? $obj->paymentID : 0;
			$txConfirmed	= ($obj) ? $obj->txConfirmed : 0; 
			
			// Save new payment details in local database
			if (!$paymentID)
			{
				$sql = "INSERT INTO crypto_payments (boxID, boxType, orderID, userID, countryID, coinLabel, amount, amountUSD, unrecognised, addr, txID, txDate, txConfirmed, txCheckDate, recordCreated)
						VALUES (".$_POST["box"].", '".$_POST["boxtype"]."', '".$_POST["order"]."', '".$_POST["user"]."', '".$_POST["usercountry"]."', '".$_POST["coinlabel"]."', ".$_POST["amount"].", ".$_POST["amountusd"].", ".($_POST["status"]=="payment_received_unrecognised"?1:0).", '".$_POST["addr"]."', '".$_POST["tx"]."', '".$_POST["datetime"]."', ".$_POST["confirmed"].", '$dt', '$dt')";

				$paymentID = run_sql($sql);
				
				$box_status = "cryptobox_newrecord";
			}
			// Update transaction status to confirmed
			elseif ($_POST["confirmed"] && !$txConfirmed)
			{
				$sql = "UPDATE crypto_payments SET txConfirmed = 1, txCheckDate = '$dt' WHERE paymentID = $paymentID LIMIT 1";
				run_sql($sql);
				
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

			if (in_array($box_status, array("cryptobox_newrecord", "cryptobox_updated")) && function_exists('cryptobox_new_payment')) cryptobox_new_payment($paymentID, $_POST, $box_status);
		}   

		else
			$box_status = "Only POST Data Allowed";


			echo $box_status; // don't delete it      
       
    }
}
