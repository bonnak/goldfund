<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\QRCode;
use App\CompanyProfile;

class QrController extends Controller
{
    public function adminBitCoinAccountQrImage()
    {
        $bitcoin_address = CompanyProfile::where('field' ,'bitcoin_address')->first()->value;

        return [
        	'qr_code' => (new QRCode($bitcoin_address, new QRImage))->output(),
        	'bitcoin_address'	=> $bitcoin_address,
        ];
    }
}
