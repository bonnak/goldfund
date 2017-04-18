<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoPayment extends Model
{
    protected $table = 'crypto_payments';

    protected $fillable = [ 
	  	'paymentID',
        'boxID',
        'boxType',
        'orderID',
        'userID',
        'countryID',
        'coinLabel',
        'amount',
        'amountUSD',
        'unrecognised',
        'addr',
        'txID',
        'txDate',
        'txConfirmed',
        'txCheckDate',
        'processed',
        'processedDate',
        'recordCreated',
	];

	public $timestamps = false;
}
