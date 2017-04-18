<?php
/**
 *  ... Please MODIFY this file ... 
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */
 define("DB_HOST", 	env('DB_HOST'));				// hostname
 define("DB_USER", 	env('DB_USERNAME'));		// database username
 define("DB_PASSWORD", 	env('DB_PASSWORD'));		// database password
 define("DB_NAME", 	env('DB_DATABASE'));	// database name




/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional), etc...");
 */
 
 $cryptobox_private_keys = [env('GOURL_PRIVATE_KEY')];


 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys); 

?>