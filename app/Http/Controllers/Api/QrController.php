<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\QRCode;

class QrController extends Controller
{
    public function adminBitCoinAccountQrImage()
    {
        // return ['a', 'b'];
        $data = '1MXeRULNu6L3En4AKQ5iDgJkBnCLYTC8Nu';

        return (new QRCode($data, new QRImage))->output();
    }
}
