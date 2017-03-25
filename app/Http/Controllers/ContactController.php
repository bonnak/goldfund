<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyProfile;

class ContactController extends Controller
{
    public function index(){
        $data = CompanyProfile::get()
            ->mapWithKeys(function ($item) {
                return [$item['field'] => $item['value']];
            });
        return view('contact-us', compact('data'));
    }
}
