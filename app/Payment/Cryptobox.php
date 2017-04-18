<?php

namespace App\Payment;

use App\CryptoPayment;

class Cryptobox {

	// Custom Variables
	
	private $public_key 	= "";		// value from your gourl.io member page - https://gourl.io/info/memberarea	
	private $private_key 	= "";		// value from your gourl.io member page.  Also you setup cryptocoin name on gourl.io member page
	private $webdev_key 	= "";		// optional, web developer affiliate key
	private $amount 		= 0;		// amount of cryptocoins which will be used in the payment box/captcha, precision is 4 (number of digits after the decimal), example: 0.0001, 2.444, 100, 2455, etc.   
										/* we will use this $amount value of cryptocoins in the payment box with a small fraction after the decimal point to uniquely identify each of your users individually
										 * (for example, if you enter 0.5 BTC, one of your user will see 0.500011 BTC, and another will see  0.500046 BTC, etc) */
	private $amountUSD 		= 0;		/* you can specify your price in USD and cryptobox will automatically convert that USD amount to cryptocoin amount using today live cryptocurrency exchange rates.
										 * Using that functionality (price in USD), you don't need to worry if cryptocurrency prices go down or up. 
										 * User will pay you all times the actual price which is linked on current exchange price in USD on the datetime of purchase.      
										 * You can use in cryptobox options one variable only: amount or amountUSD. You cannot place values of those two variables together. */
	private $period 		= "";		// period after which the payment becomes obsolete and new cryptobox will be shown; allow values: NOEXPIRY, 1 MINUTE..90 MINUTE, 1 HOUR..90 HOURS, 1 DAY..90 DAYS, 1 WEEK..90 WEEKS, 1 MONTH..90 MONTHS  
	private $language		= "en";		// cryptobox localisation; en - English, es - Spanish, fr - French, de - German, nl - Dutch, it - Italian, ru - Russian, pl - Polish, pt - Portuguese, fa - Persian, ko - Korean, ja - Japanese, id - Indonesian, tr - Turkish, ar - Arabic, cn - Simplified Chinese, zh - Traditional Chinese, hi - Hindi
	private $iframeID		= "";		// optional, html iframe element id; allow symbols: a..Z0..9_-
	private $orderID 		= "";		// your page name / product name or order name (not unique); allow symbols: a..Z0..9_-@.; max size: 50 symbols
	private $userID 		= "";		// optional, manual setup unique identifier for each of your users; allow symbols: a..Z0..9_-@.; max size: 50 symbols
										/* IMPORTANT - If you use Payment Box/Captcha for registered users on your website, you need to set userID manually with 
										 * an unique value for each of your registered user. It is better than to use cookies by default. Examples: 'user1', 'user2', '3vIh9MjEis' */
	private $userFormat 	= "COOKIE"; // this variable use only if $userID above is empty - it will save random userID in cookies, sessions or use user IP address as userID. Available values: COOKIE, SESSION, IPADDRESS
	  
	/* PLEASE NOTE -
	 * If you use multiple stores/sites online, please create separate GoUrl Payment Box (with unique payment box public/private keys) for each of your stores/websites. 
	 * Do not use the same GoUrl Payment Box with the same public/private keys on your different websites/stores.
	 * if you use the same $public_key, $orderID and $userID in your multiple cryptocoin payment boxes on different website pages and a user has made payment; a successful result for that user will be returned on all those pages (if $period time valid). 
	 * if you change - $public_key or $orderID or $userID - new cryptocoin payment box will be shown for exisiting paid user. (function $this->is_paid() starts to return 'false'). 
	 * */

	
	// Internal Variables
	
	private $boxID			= 0; 		// cryptobox id, the same as on gourl.io member page. For each your cryptocoin payment boxes you will have unique public / private keys 
	private $coinLabel		= ""; 		// current cryptocoin label (BTC, DOGE, etc.) 
	private $coinName		= ""; 		// current cryptocoin name (Bitcoin, Dogecoin, etc.) 
	private $paid			= false;	// paid or not
	private $confirmed		= false;	// transaction/payment have 6+ confirmations or not
	private $paymentID		= false;	// current record id in the table crypto_payments (table stores all payments from your users)
	private $paymentDate	= "";		// transaction/payment datetime in GMT format
	private $amountPaid 	= 0;		// exact paid amount; for example, $amount = 0.5 BTC and user paid - $amountPaid = 0.50002 BTC
	private $amountPaidUSD 	= 0;		// approximate paid amount in USD; using cryptocurrency exchange rate on datetime of payment
	private $boxType		= "";		// cryptobox type - 'paymentbox' or 'captchabox'
	private $processed		= false;	// optional - set flag to paid & processed	
	private $cookieName 	= "";		// user cookie/session name (if cookies/sessions use)
	private $localisation 	= "";		// localisation; en - English, es - Spanish, fr - French, de - German, nl - Dutch, it - Italian, ru - Russian, pl - Polish, pt - Portuguese, fa - Persian, ko - Korean, ja - Japanese, id - Indonesian, tr - Turkish, ar - Arabic, cn - Simplified Chinese, zh - Traditional Chinese, hi - Hindi
	
	
	public function __construct($options = array()) 
	{
		
		// Min requirements
		if (!function_exists( 'mb_stripos' ) || !function_exists( 'mb_strripos' ))  die(sprintf("Error. Please enable <a target='_blank' href='%s'>MBSTRING extension</a> in PHP. <a target='_blank' href='%s'>Read here &#187;</a>", "http://php.net/manual/en/book.mbstring.php", "http://www.knowledgebase-script.com/kb/article/how-to-enable-mbstring-in-php-46.html"));
		if (!function_exists( 'curl_init' )) 										die(sprintf("Error. Please enable <a target='_blank' href='%s'>CURL extension</a> in PHP. <a target='_blank' href='%s'>Read here &#187;</a>", "http://php.net/manual/en/book.curl.php", "http://stackoverflow.com/questions/1347146/how-to-enable-curl-in-php-xampp"));
		if (!function_exists( 'mysqli_connect' )) 									die(sprintf("Error. Please enable <a target='_blank' href='%s'>MySQLi extension</a> in PHP. <a target='_blank' href='%s'>Read here &#187;</a>", "http://php.net/manual/en/book.mysqli.php", "http://crybit.com/how-to-enable-mysqli-extension-on-web-server/"));
		if (version_compare(phpversion(), '5.4.0', '<')) 							die(sprintf("Error. You need PHP 5.4.0 (or greater). Current php version: %s", phpversion()));
		
		
		foreach($options as $key => $value) 
			if (in_array($key, array("public_key", "private_key", "webdev_key", "amount", "amountUSD", "period", "language", "iframeID", "orderID", "userID", "userFormat"))) $this->$key = (is_string($value)) ? trim($value) : $value;

		$this->boxID = $this->left($this->public_key, "AA");
		 
		if (preg_replace('/[^A-Za-z0-9]/', '', $this->public_key) != $this->public_key || strlen($this->public_key) != 50 || !strpos($this->public_key, "AA") || !$this->boxID || !is_numeric($this->boxID) || strpos($this->public_key, "77") === false || !strpos($this->public_key, "PUB")) die("Invalid Cryptocoin Payment Box PUBLIC KEY - " . ($this->public_key?$this->public_key:"cannot be empty"));
				
		if (preg_replace('/[^A-Za-z0-9]/', '', $this->private_key) != $this->private_key || strlen($this->private_key) != 50 || !strpos($this->private_key, "AA") || $this->boxID != $this->left($this->private_key, "AA") || !strpos($this->private_key, "PRV") || $this->left($this->private_key, "PRV") != $this->left($this->public_key, "PUB")) die("Invalid Cryptocoin Payment Box PRIVATE KEY".($this->private_key?"":" - cannot be empty"));
		
		//if (!defined("CRYPTOBOX_PRIVATE_KEYS") || !in_array($this->private_key, explode("^", CRYPTOBOX_PRIVATE_KEYS))) die("Error. Please add your Cryptobox Private Key to \$cryptobox_private_keys in file cryptobox.config.php");
		if(!config('cryptobox.CRYPTOBOX_PRIVATE_KEYS') || !in_array($this->private_key, explode("^", config('cryptobox.CRYPTOBOX_PRIVATE_KEYS')))) die("Error. Please add your Cryptobox Private Key to \$cryptobox_private_keys in file cryptobox.config.php");

		if ($this->webdev_key && (preg_replace('/[^A-Za-z0-9]/', '', $this->webdev_key) != $this->webdev_key || strpos($this->webdev_key, "DEV") !== 0 || $this->webdev_key != strtoupper($this->webdev_key) || $this->icrc32($this->left($this->webdev_key, "G", false)) != $this->right($this->webdev_key, "G", false))) $this->webdev_key = "";
		
		$c = substr($this->right($this->left($this->public_key, "PUB"), "AA"), 5);
		$this->coinLabel = $this->right($c, "77");
		$this->coinName = $this->left($c, "77");
		
		if ($this->amount 	 && strpos($this->amount, ".")) 	$this->amount = rtrim(rtrim($this->amount, "0"), ".");
		if ($this->amountUSD && strpos($this->amountUSD, ".")) 	$this->amountUSD = rtrim(rtrim($this->amountUSD, "0"), ".");

		if (!$this->amount || $this->amount <= 0) 		$this->amount 	 = 0;
		if (!$this->amountUSD || $this->amountUSD <= 0) 	$this->amountUSD = 0;
		
		if (($this->amount <= 0 && $this->amountUSD <= 0) || ($this->amount > 0 && $this->amountUSD > 0)) die("You can use in cryptobox options one of variable only: amount or amountUSD. You cannot place values in that two variables together (submitted amount = '".$this->amount."' and amountUSD = '".$this->amountUSD."' )");
		 
		if ($this->amount && (!is_numeric($this->amount) || $this->amount < 0.0001 || $this->amount > 50000000)) die("Invalid Amount - $this->amount $this->coinLabel. Allowed range: 0.0001 .. 50,000,000");
		if ($this->amountUSD && (!is_numeric($this->amountUSD) || $this->amountUSD < 0.01 || $this->amountUSD > 1000000)) die("Invalid amountUSD - $this->amountUSD USD. Allowed range: 0.01 .. 1,000,000");
		
		$this->period = trim(strtoupper(str_replace(" ", "", $this->period)));
		if (substr($this->period, -1) == "S") $this->period = substr($this->period, 0, -1);
		for ($i=1; $i<=90; $i++) { $arr[] = $i."MINUTE"; $arr[] = $i."HOUR"; $arr[] = $i."DAY"; $arr[] = $i."WEEK"; $arr[] = $i."MONTH"; }
		if ($this->period != "NOEXPIRY" && !in_array($this->period, $arr)) die("Invalid Cryptobox Period - $this->period");
		$this->period = str_replace(array("MINUTE", "HOUR", "DAY", "WEEK", "MONTH"), array(" MINUTE", " HOUR", " DAY", " WEEK", " MONTH"), $this->period);
		
		$id = "gourlcryptolang";
		$this->language = strtolower($this->language);
		//$this->localisation = json_decode('CRYPTOBOX_LOCALISATION', true);
		$this->localisation = config('cryptobox.CRYPTOBOX_LOCALISATION');
		if (isset($_GET[$id]) && in_array($_GET[$id], array_keys($this->localisation))) $this->language = $_GET[$id];
		elseif (isset($_COOKIE[$id]) && in_array($_COOKIE[$id], array_keys($this->localisation))) $this->language = $_COOKIE[$id];
		elseif (!in_array($this->language, array_keys($this->localisation))) $this->language = "en";
		$this->localisation = $this->localisation[$this->language];
		unset($id);
		
		if ($this->iframeID && preg_replace('/[^A-Za-z0-9\_\-]/', '', $this->iframeID) != $this->iframeID || $this->iframeID == "cryptobox_live_") die("Invalid iframe ID - $this->iframeID. Allowed symbols: a..Z0..9_-");
		
		$this->userID = trim($this->userID);
		if ($this->userID && preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $this->userID) != $this->userID) die("Invalid User ID - $this->userID. Allowed symbols: a..Z0..9_-@.");
		if (strlen($this->userID) > 50) die("Invalid User ID - $this->userID. Max: 50 symbols");
		
		$this->orderID = trim($this->orderID);
		if ($this->orderID && preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $this->orderID) != $this->orderID) die("Invalid Order ID - $this->orderID. Allowed symbols: a..Z0..9_-@.");
		if (!$this->orderID || strlen($this->orderID) > 50) die("Invalid Order ID - $this->orderID. Max: 50 symbols");
		
		if ($this->userID) 
			$this->userFormat = "MANUAL";
		else 
		{
			switch ($this->userFormat) 
			{
				case "COOKIE":
					$this->cookieName = 'cryptoUsr'.$this->icrc32($this->boxID."*&*".$this->coinLabel."*&*".$this->orderID."*&*".$this->private_key);
					if (isset($_COOKIE[$this->cookieName]) && trim($_COOKIE[$this->cookieName]) && strpos($_COOKIE[$this->cookieName], "__")) $this->userID = trim($_COOKIE[$this->cookieName]);
					else
					{	 
						$s = trim(strtolower($_SERVER['SERVER_NAME']), " /");
						if (stripos($s, "www.") === 0) $s = substr($s, 4);
						$d = time(); if ($d > 1410000000) $d -= 1410000000;
						$v = trim($d."__".substr(md5(uniqid(mt_rand().mt_rand().mt_rand())), 0, 10));
						setcookie($this->cookieName, $v, time()+(10*365*24*60*60), '/', $s);
						$this->userID = $v;
					}	
				break;
					
				case "SESSION":
					
					if (session_status() == PHP_SESSION_NONE) session_start();
					$this->cookieName = 'cryptoUser'.$this->icrc32($this->private_key."*&*".$this->boxID."*&*".$this->coinLabel."*&*".$this->orderID);
					if (isset($_SESSION[$this->cookieName]) && trim($_SESSION[$this->cookieName]) && strpos($_SESSION[$this->cookieName], "--")) $this->userID = trim($_SESSION[$this->cookieName]);
					else
					{	 
						$d = time(); if ($d > 1410000000) $d -= 1410000000;
						$v = trim($d."--".substr(md5(uniqid(mt_rand().mt_rand().mt_rand())), 0, 10));
						$this->userID = $_SESSION[$this->cookieName] = $v; 
					}	
				break;
				
				case "IPADDRESS":
					
					if (session_status() == PHP_SESSION_NONE) session_start();
					if (isset($_SESSION['cryptoUserIP']) && filter_var($_SESSION['cryptoUserIP'], FILTER_VALIDATE_IP))
						 $ip = $_SESSION['cryptoUserIP'];
					else $ip = $_SESSION['cryptoUserIP'] = $this->ip_address();
					$this->userID = trim(md5($ip."*&*".$this->boxID."*&*".$this->coinLabel."*&*".$this->orderID));
					
				break;
				
				default:
					die("Invalid userFormat value - $this->userFormat");
				break;
			}
		}

		if (!$this->iframeID) $this->iframeID = $this->iframe_id();
		
		$this->check_payment();
		
		return true;
	}
	
	
	
	

	/* 1. Function display_cryptobox() -
	 * 
	 * Display Cryptocoin Payment Box; the cryptobox will automatically displays successful message if payment has been received
	 * 
	 * Usually user will see on bottom of payment box button 'Click Here if you have already sent coins' (when $submit_btn = true) 
	 * and when they click on that button, script will connect to our remote cryptocoin payment box server
	 * and check user payment.
	 *  
	 * As backup, our server will also inform your server automatically through IPN every time a payment is received
	 * (file cryptobox.callback.php). I.e. if the user does not click on the button or you have not displayed the button, 
	 * your website will receive a notification about a given user anyway and save it to your database. 
	 * Next time your user goes to your website/reloads page they will automatically see the message 
	 * that their payment has been received successfully.
	*/
	public function display_cryptobox($submit_btn = true, $width = "540", $height = "230", $box_style = "", $message_style = "", $anchor = "")
	{
		if (!$box_style) 	 $box_style = "border-radius:15px;box-shadow:0 0 12px #aaa;-moz-box-shadow:0 0 12px #aaa;-webkit-box-shadow:0 0 12px #aaa;padding:3px 6px;margin:10px"; 
		if (!$message_style) $message_style = "display:inline-block;max-width:580px;padding:15px 20px;box-shadow:0 0 10px #aaa;-moz-box-shadow: 0 0 10px #aaa;margin:7px;font-size:13px;font-weight:normal;line-height:21px;font-family: Verdana, Arial, Helvetica, sans-serif;";
		
		$width = intval($width);
		$height = intval($height);
		
		$cryptobox_html = "";
		$val 			= md5($this->iframeID.$this->private_key.$this->userID);
	
		if ($submit_btn && isset($_POST["cryptobox_live_"]) && $_POST["cryptobox_live_"] == $val)
		{
			$id = "id".md5(mt_rand()); 
			if (!$this->paid) $cryptobox_html .= "<a id='c".$this->iframeID."' name='c".$this->iframeID."'></a>";
			$cryptobox_html .= "<br><div id='$id' align='center'>";
			$cryptobox_html .= '<div'.(in_array($this->language, array("ar", "fa"))?' dir="rtl"':'').' style="'.htmlspecialchars($message_style, ENT_COMPAT).'">';
	

			if ($this->paid) $cryptobox_html .= "<span style='color:#339e2e;white-space:nowrap;'>".str_replace(array("%coinName%", "%coinLabel%", "%amountPaid%"), array($this->coinName, $this->coinLabel, $this->amountPaid), $this->localisation[($this->boxType=="paymentbox"?"msg_received":"msg_received2")])."</span>";
			else $cryptobox_html .= "<span style='color:#eb4847'>".str_replace(array("%coinName%", "%coinNames%", "%coinLabel%"), array($this->coinName, ($this->coinLabel=='DASH'?$this->coinName:$this->coinName.'s'), $this->coinLabel), $this->localisation["msg_not_received"])."</span><script type='text/javascript'>cryptobox_msghide('$id')</script>";
			
			$cryptobox_html .= "</div></div><br>";
		}
	
		$hash_str = $this->boxID.$this->coinName.$this->public_key.$this->private_key.$this->webdev_key.$this->amount.$this->period.$this->amountUSD.$this->language.$this->amount.$this->iframeID.$this->amountUSD.$this->userID.$this->userFormat.$this->orderID.$width.$height;
		$hash = md5($hash_str);
		$cryptobox_html .= "<div align='center' style='min-width:".$width."px'><iframe id='$this->iframeID' ".($box_style?'style="'.htmlspecialchars($box_style, ENT_COMPAT).'"':'')." scrolling='no' marginheight='0' marginwidth='0' frameborder='0' width='$width' height='$height'></iframe></div>";
		$cryptobox_html .= "<div><script type='text/javascript'>";
		$cryptobox_html .= "cryptobox_show($this->boxID, '$this->coinName', '$this->public_key', $this->amount, $this->amountUSD, '$this->period', '$this->language', '$this->iframeID', '$this->userID', '$this->userFormat', '$this->orderID', '$this->cookieName', '$this->webdev_key', '$hash', $width, $height);";
		$cryptobox_html .= "</script></div>";
	
		if ($submit_btn && !$this->paid)
		{
			$cryptobox_html .= "<form action='".$_SERVER["REQUEST_URI"]."#".($anchor?$anchor:"c".$this->iframeID)."' method='post'>";
			$cryptobox_html .= "<input type='hidden' id='cryptobox_live_' name='cryptobox_live_' value='$val'>";
			$cryptobox_html .= "<div align='center'>";
			$cryptobox_html .= "<button".(in_array($this->language, array("ar", "fa"))?' dir="rtl"':'')." style='color:#555;border-color:#ccc;background:#f7f7f7;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top;display:inline-block;text-decoration:none;font-size:13px;line-height:26px;min-height:28px;margin:20px 0 25px 0;padding:0 10px 1px;cursor:pointer;border-width:1px;border-style:solid;-webkit-appearance:none;-webkit-border-radius:3px;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;font-family:\"Open Sans\",sans-serif;font-size: 13px;font-weight: normal;text-transform: none;'>&#160; ".str_replace(array("%coinName%", "%coinNames%", "%coinLabel%"), array($this->coinName, ($this->coinLabel=='DASH'?$this->coinName:$this->coinName.'s'), $this->coinLabel), $this->localisation["button"]).($this->language!="ar"?" &#187;":"")." &#160;</button>";
			$cryptobox_html .= "</div>";
			$cryptobox_html .= "</form>";
		}
	
		$cryptobox_html .= "<br>";
	
		return $cryptobox_html;
	}
	
	
		
	
	
	/* 2. Function is_paid($remotedb = false) -
	 * 
	 * This Checks your local database whether payment has been received and is stored on your local database. 
	 * 
	 * If use $remotedb = true, it will check also on the remote cryptocoin payment server (gourl.io),
	 * and if payment is received, it saves it in your local database. Usually user will see on bottom
	 * of payment box button 'Click Here if you have already sent coins' and when they click on that button,
	 * script it will connect to our remote cryptocoin payment box server. Therefore you don't need to use
	 * $remotedb = true, it will make your webpage load slowly if payment on gourl.io is checked during
	 * each of your page loadings.
	 * 
	 * Please note that our server will also inform your server automatically every time when payment is 
	 * received through callback url: cryptobox.callback.php. I.e. if the user does not click on button, 
	 * your website anyway will receive notification about a given user and save it in your database. 
	 * And when your user next time comes on your website/reload page he will automatically will see 
	 * message that his payment has been received successfully.
	 */
	public function is_paid($remotedb = false)
	{
		if (!$this->paymentID && $remotedb) $this->check_payment($remotedb);
		if ($this->paid) return true;
		else return false;
	}
	
	
	


	/* 3. Function is_confirmed() -
	*
	* Function return is true if transaction/payment has 6+ confirmations. 
	* It connects with our payment server and gets the current transaction status (confirmed/unconfirmed). 
	* Some merchants wait until this transaction has been confirmed.  
	* Average transaction confirmation time - 10-20min for 6+ confirmations (altcoins)
	*/
	public function is_confirmed()
	{
		if ($this->confirmed) return true;
		else return false;
	}

	
	
	
	
	/* 4. Function amount_paid()
	 * 
	 * Returns the amount of coins received from the user
	 */
	public function amount_paid()
	{
		if ($this->paid) return $this->amountPaid; 
		else return 0;
	}

	
	
	
	
	/* 5. Function amount_paid_usd()
	 * 
	 * Returns the approximate amount in USD received from the user
	 * using live cryptocurrency exchange rates on the datetime of payment.
	 * Live Exchange Rates obtained from sites poloniex.com and bitstamp.net 
	 * and are updated every 30 minutes!
	 * 
	 * Or you can directly specify your price in USD and submit it in cryptobox using 
	 * variable 'amountUSD'. Cryptobox will automatically convert that USD amount 
	 * to cryptocoin amount using today current live cryptocurrency exchange rates. 
	 * 
	 * Using that functionality, you don't need to worry if cryptocurrency prices go down or up.
	 * User will pay you all times the actual price which is linked on current exchange 
	 * price in USD on the datetime of purchase. 
	 * 
	 * You can accepting cryptocoins on your website with cryptobox variable 'amountUSD'. 
	 * It increase your online sales and also use Poloniex.com AutoSell feature 
	 * (to trade your cryptocoins to USD/BTC during next 30 minutes after payment received).
	 */
	public function amount_paid_usd()
	{
		if ($this->paid) return $this->amountPaidUSD;
		else return 0;
	}
	
	
	
	
	
	/* 6. Functions set_status_processed() and is_processed() 
	 * 
	 * You can use this function when user payment has been received
	 * (function is_paid() returns true) and want to make one time action,
	 * for example  display 'thank you' message to user, etc.
	 * These functions helps you to exclude duplicate processing.
	 * 
	 * Please note that the user will continue to see a successful payment result in 
	 * their crypto Payment box during the period/timeframe you specify in cryptobox option $period
	 */	 
	public function set_status_processed()
	{
		if ($this->paymentID && $this->paid)
		{
			if (!$this->processed)
			{
				$sql = "UPDATE crypto_payments SET processed = 1, processedDate = '".gmdate("Y-m-d H:i:s")."' WHERE paymentID = $this->paymentID LIMIT 1";
				//run_sql($sql);
				\DB::update($sql);
				$this->processed = true;
			}
			return true;
		}
		else return false;
	}
	
	
	
	
	
	/* 7. Function is_processed() 
	 * 
	 * If payment status in database is 'processed' - return true, 
	 * otherwise return false. You need to use it with 
	 * function set_status_processed() together 
	*/
	public function is_processed()
	{
		if ($this->paid && $this->processed) return true;
		else return false;
	}


	
	
	
	/* 8. Function cryptobox_type() 
	 * 
	 * Returns 'paymentbox' or 'captchabox'
	 * 
	 * The Cryptocoin Payment Box and Crypto Captcha are 
	 * absolutely identical technically except for their visual effect.
	 *
	 * It uses the same code to get your user payment, to process that  
	 * payment and to forward received coins to you. They have only two 
	 * visual differences - users will see different logos and different 
	 * text on successful result page.
	 * For example, for dogecoin it will be - 'Dogecoin Payment' or 
	 * 'Dogecoin Captcha' logos and when payment is received we will publish 
	 * 'Payment received successfully' or 'Captcha Passed successfully'.
	 *  
	 * We have made it easier for you to adapt our payment system to your website. 
	 * On signup page you can use 'Bitcoin Captcha' and on sell products page - 'Bitcoin Payment'. 
	*/
	public function cryptobox_type()
	{
		return $this->boxType;
	}
	
	
	
	
	
	/* 9. Function payment_id() 
	 * 
	 * Returns current record id in the table crypto_payments.
	 * Crypto_payments table stores all payments from your users
	*/
	public function payment_id()
	{
		return $this->paymentID;
	}
	
	
	
	
	/* 10. Function payment_date() 
	 * 
	 * Returns payment/transaction datetime in GMT format
	 * Example - 2014-09-26 17:31:58 (is 26 September 2014, 5:31pm GMT) 
	*/
	public function payment_date()
	{
		return $this->paymentDate;
	}
	
	
	
	/* 11. Function payment_info()
	 * 
	 * Returns object with current user payment details -
	 * coinLabel 	 	- cryptocurrency label
	 * countryID 	 	- user location country, 3 letter ISO country code
	 * countryName 	 	- user location country
	 * amount 			- paid cryptocurrency amount
	 * amountUSD 	 	- approximate paid amount in USD with exchange rate on datetime of payment made
	 * addr				- your internal wallet address on gourl.io which received this payment
	 * txID 			- transaction id
	 * txDate 			- transaction date (GMT time)
	 * txConfirmed		- 0 - unconfirmed transaction/payment or 1 - confirmed transaction/payment 
	 * processed		- true/false. True if you called function set_status_processed() for that payment before  
	 * processedDate	- GMT time when you called function set_status_processed()  
	 * recordCreated	- GMT time a payment record was created in your database  
	 * etc.
	*/
	public function payment_info()
	{
		// $obj = ($this->paymentID) ? run_sql("SELECT * FROM crypto_payments WHERE paymentID = $this->paymentID LIMIT 1") : false;
		$obj = ($this->paymentID) ? \DB::selectOne("SELECT * FROM crypto_payments WHERE paymentID = $this->paymentID LIMIT 1") : false;
		if ($obj) $obj->countryName = get_country_name($obj->countryID);
		return $obj;
	}
	
	
	
	
	
	/* 12. Function cryptobox_reset()
	 *
	 * Optional, It will delete cookies/sessions with userID and new cryptobox with new payment amount
	 * will be displayed after page reload. Cryptobox will recognize user as a new one with new generated userID.
	 * For example, after you have successfully received the cryptocoin payment and had processed it, you can call
	 * one-time cryptobox_reset() in end of your script. Use this function only if you have not set userID manually.
	*/
	public function cryptobox_reset()
	{
		if (in_array($this->userFormat, array("COOKIE", "SESSION")))
		{
			$iframeID = $this->iframe_id();
			
			switch ($this->userFormat)
			{
				case "COOKIE":
					$s = trim(strtolower($_SERVER['SERVER_NAME']), " /");
					if (stripos($s, "www.") === 0) $s = substr($s, 4);
					$d = time(); if ($d > 1410000000) $d -= 1410000000;
					$v = trim($d."__".substr(md5(uniqid(mt_rand().mt_rand().mt_rand())), 0, 10));
					setcookie($this->cookieName, $v, time()+(10*365*24*60*60), '/', $s);
					$this->userID = $v;
					break;
						
				case "SESSION":
					$d = time(); if ($d > 1410000000) $d -= 1410000000;
					$v = trim($d."--".substr(md5(uniqid(mt_rand().mt_rand().mt_rand())), 0, 10));
					$this->userID = $_SESSION[$this->cookieName] = $v;
					break;
			}
			
			if ($this->iframeID == $iframeID) $this->iframeID = $this->iframe_id();
						
			return true;
		}
		else return false;
	}
		
	
	
	
	/* 13. Function coin_name()
	 *
	 * Returns coin name (bitcoin, dogecoin, litecoin, etc)   
	*/
	public function coin_name()
	{
		return $this->coinName;
	}
	
	
	
	
	/* 14. Function coin_label()
	 *
	 * Returns coin label (DOGE, BTC, LTC, etc)   
	*/
	public function coin_label()
	{
		return $this->coinLabel;
	}

	
	
	/* 15. Function iframe_id()
	 *
	 * Returns payment box frame id   
	*/
	public function iframe_id()
	{
		return "box".$this->icrc32($this->boxID."__".$this->orderID."__".$this->userID."__".$this->private_key);
	}
	

	
	
	/*
	 * Other Internal functions   
	*/
	private function check_payment($remotedb = false)
	{
		$this->paymentID = $diff = 0;
		
		//$obj = run_sql("SELECT paymentID, amount, amountUSD, txConfirmed, txCheckDate, txDate, processed, boxType FROM crypto_payments WHERE boxID = $this->boxID && orderID = '$this->orderID' && userID = '$this->userID' ".($this->period=="NOEXPIRY"?"":"&& txDate >= DATE_SUB('".gmdate("Y-m-d H:i:s")."', INTERVAL ".$this->period.")")." ORDER BY txDate DESC LIMIT 1");
		$obj = \DB::selectOne("SELECT paymentID, amount, amountUSD, txConfirmed, txCheckDate, txDate, processed, boxType FROM crypto_payments WHERE boxID = $this->boxID && orderID = '$this->orderID' && userID = '$this->userID' ".($this->period=="NOEXPIRY"?"":"&& txDate >= DATE_SUB('".gmdate("Y-m-d H:i:s")."', INTERVAL ".$this->period.")")." ORDER BY txDate DESC LIMIT 1");

		if ($obj)
		{
			$this->paymentID 		= $obj->paymentID;
			$this->paymentDate 		= $obj->txDate;
			$this->amountPaid 		= $obj->amount;
			$this->amountPaidUSD 	= $obj->amountUSD;
			$this->paid 			= true;
			$this->confirmed 		= $obj->txConfirmed;
			$this->boxType 	= $obj->boxType;
			$this->processed 		= ($obj->processed) ? true : false;
			$diff					=  strtotime(gmdate('Y-m-d H:i:s')) - strtotime($obj->txCheckDate);
		}
		
		if (!$obj && isset($_POST["cryptobox_live_"]) && $_POST["cryptobox_live_"] == md5($this->iframeID.$this->private_key.$this->userID)) $remotedb = true;
		
		if ((!$obj && $remotedb) || ($obj && !$this->confirmed && ($diff > (($this->coinLabel=='BTC'?35:12)*60) || $diff < 0))) // if $diff < 0 - user have incorrect time on local computer
		{
			$this->check_payment_live();
		}
	
		return true;
	}
	private function check_payment_live()
	{
		$ip		= $this->ip_address();
		$hash 	= md5($this->boxID.$this->private_key.$this->userID.$this->orderID.$this->language.$this->period.$ip);
		$box_status = "";
		
		$data = array(
				"r" 	=> $this->private_key,
				"b" 	=> $this->boxID,
				"o"		=> $this->orderID,
				"u"		=> $this->userID,
				"l"		=> $this->language,
				"e"		=> $this->period,
				"i"		=> $ip,
				"h"		=> $hash
		);
	
		$ch = curl_init( "https://coins.gourl.io/result.php" );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt( $ch, CURLOPT_TIMEOUT, 20);
			
		$res = curl_exec( $ch );
	
		if ($res) $res = json_decode($res, true);
		
		if ($res) foreach ($res as $k => $v) if (is_string($v)) $res[$k] = trim($v);

		if (isset($res["status"]) && in_array($res["status"], array("payment_received")) &&
				$res["box"] && is_numeric($res["box"]) && $res["box"] > 0 && $res["amount"] && is_numeric($res["amount"]) && $res["amount"] > 0 &&
				$res["private_key"] && preg_replace('/[^A-Za-z0-9]/', '', $res["private_key"]) == $res["private_key"] && $res["private_key"] == $this->private_key)
		{
			
			foreach ($res as $k => $v)
			{
				if ($k == "datetime") 							$mask = '/[^0-9\ \-\:]/';
				elseif (in_array($k, array("err", "date")))		$mask = '/[^A-Za-z0-9\.\_\-\@\ ]/';
				else											$mask = '/[^A-Za-z0-9\.\_\-\@]/';
				if ($v && preg_replace($mask, '', $v) != $v) 	$res[$k] = "";
			}
			
			if (!$res["amountusd"] || !is_numeric($res["amountusd"]))	$res["amountusd"] = 0;
			if (!$res["confirmed"] || !is_numeric($res["confirmed"]))	$res["confirmed"] = 0;
				

			
			$dt  = gmdate('Y-m-d H:i:s');
			//$obj = run_sql("select paymentID, processed, txConfirmed from crypto_payments where boxID = ".$res["box"]." && orderID = '".$res["order"]."' && userID = '".$res["user"]."' && txID = '".$res["tx"]."' && amount = ".$res["amount"]." && addr = '".$res["addr"]."' limit 1"); 
			$obj = \DB::selectOne("select paymentID, processed, txConfirmed from crypto_payments where boxID = ".$res["box"]." && orderID = '".$res["order"]."' && userID = '".$res["user"]."' && txID = '".$res["tx"]."' && amount = ".$res["amount"]." && addr = '".$res["addr"]."' limit 1"); 

			if ($obj)
			{ 
				$this->paymentID 	= $obj->paymentID; 
				$this->processed 	= ($obj->processed) ? true : false;
				$this->confirmed 	= $obj->txConfirmed;
				
				// refresh
				$sql = "UPDATE 		crypto_payments 
						SET 		boxType 			= '".$res["boxtype"]."',
									amount 				= ".$res["amount"].",
									amountUSD			= ".$res["amountusd"].",
									coinLabel			= '".$res["coinlabel"]."',
						 			unrecognised		= 0,
						 			addr				= '".$res["addr"]."',
						 			txDate				= '".$res["datetime"]."',
						 			txConfirmed			= ".$res["confirmed"].",
						 			txCheckDate			= '".$dt."'
						WHERE 		paymentID 			= $this->paymentID 
						LIMIT 		1";
				
				//run_sql($sql);
				\DB::update($sql);
				
				if ($res["confirmed"] && !$this->confirmed) $box_status = "cryptobox_updated";
			}
			else 
			{	
				// Save new payment details in local database
				$sql = "INSERT INTO crypto_payments (boxID, boxType, orderID, userID, countryID, coinLabel, amount, amountUSD, unrecognised, addr, txID, txDate, txConfirmed, txCheckDate, recordCreated)
						VALUES (".$res["box"].", '".$res["boxtype"]."', '".$res["order"]."', '".$res["user"]."', '".$res["usercountry"]."', '".$res["coinlabel"]."', ".$res["amount"].", ".$res["amountusd"].", 0, '".$res["addr"]."', '".$res["tx"]."', '".$res["datetime"]."', ".$res["confirmed"].", '$dt', '$dt')";
	
				//$this->paymentID = run_sql($sql);
				$this->paymentID = \DB::insert($sql);
				
				$box_status = "cryptobox_newrecord"; 
			}

			
			$this->paymentDate 		= $res["datetime"];
			$this->amountPaid 		= $res["amount"];
			$this->amountPaidUSD 	= $res["amountusd"];
			$this->paid 			= true;
			$this->boxType 			= $res["boxtype"];
			$this->confirmed 		= $res["confirmed"];
			
			
			/**
			 *  User-defined function for new payment - cryptobox_new_payment(...)
			 *  For example, send confirmation email, update database, update user membership, etc.
			 *  You need to modify file - cryptobox.newpayment.php
			 *  Read more - https://gourl.io/api-php.html#ipn
			 */

			if (in_array($box_status, array("cryptobox_newrecord", "cryptobox_updated")) && function_exists('cryptobox_new_payment')) cryptobox_new_payment($this->paymentID, $res, $box_status);
				
			
			return true;
		}
		return false;
	}
	public function left($str, $findme, $firstpos = true)
	{
		$pos = ($firstpos)? stripos($str, $findme) : strripos($str, $findme);
	
		if ($pos === false) return $str;
		else return substr($str, 0, $pos);
	}
	public function right($str, $findme, $firstpos = true)
	{
		$pos = ($firstpos)? stripos($str, $findme) : strripos($str, $findme);
	
		if ($pos === false) return $str;
		else return substr($str, $pos + strlen($findme));
	}
	public function icrc32($str)
	{
		$in = crc32($str);
		$int_max = pow(2, 31)-1;
		if ($in > $int_max) $out = $in - $int_max * 2 - 2;
		else $out = $in;
		$out = abs($out);
		 
		return $out;
	}
	
	
	public function ip_address()
	{
		static $ip_address;
	
		if ($ip_address) return $ip_address;
	
		$ip_address         = "";
		$proxy_ips          = (defined("PROXY_IPS")) ? unserialize(PROXY_IPS) : array();  // your server internal proxy ip
		$internal_ips       = array('127.0.0.0', '127.0.0.1', '127.0.0.2', '192.0.0.0', '192.0.0.1', '192.168.0.0', '192.168.0.1', '192.168.0.253', '192.168.0.254', '192.168.0.255', '192.168.1.0', '192.168.1.1', '192.168.1.253', '192.168.1.254', '192.168.1.255', '192.168.2.0', '192.168.2.1', '192.168.2.253', '192.168.2.254', '192.168.2.255', '10.0.0.0', '10.0.0.1', '11.0.0.0', '11.0.0.1', '1.0.0.0', '1.0.1.0', '1.1.1.1', '255.0.0.0', '255.0.0.1', '255.255.255.0', '255.255.255.254', '255.255.255.255', '0.0.0.0', '::', '0::', '0:0:0:0:0:0:0:0');
	
		for ($i = 1; $i <= 2; $i++)
			if (!$ip_address)
			{
				foreach (array('HTTP_CLIENT_IP', 'HTTP_X_CLIENT_IP', 'HTTP_X_CLUSTER_CLIENT_IP', 'X-Forwarded-For', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_X_REAL_IP', 'REMOTE_ADDR') as $header)
					if (!$ip_address && isset($_SERVER[$header]) && $_SERVER[$header])
					{
						$ip  = trim($_SERVER[$header]);
						$ip2 = "";
						if (strpos($ip, ',') !== FALSE)
						{
							list($ip, $ip2) = explode(',', $ip, 2);
							$ip = trim($ip);
							$ip2 = trim($ip2);
						}
							
						if ($ip && filter_var($ip, FILTER_VALIDATE_IP) && !in_array($ip, $proxy_ips) && ($i==2 || !in_array($ip, $internal_ips))) 				$ip_address = $ip;
						elseif ($ip2 && filter_var($ip2, FILTER_VALIDATE_IP) && !in_array($ip2, $proxy_ips) && ($i==2 || !in_array($ip2, $internal_ips))) 		$ip_address = $ip2;
					}
			}
	
			if (!$ip_address || !filter_var($ip_address, FILTER_VALIDATE_IP)) $ip_address = '0.0.0.0';
	
			return $ip_address;
	}

}