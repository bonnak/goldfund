<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CompanyProfile;

class CompanyProfileController extends Controller
{
    public function getData()
    {
    	return CompanyProfile::get()
    			->mapWithKeys(function ($item) {
				    return [$item['field'] => $item['value']];
				});
    }

    public function update(Request $request)
    {
    	$this->setAddress($request->address);
    	$this->setEmail($request->email);
    	$this->setPhone($request->phone);
    }

    private function setPhone($phone_number)
    {
    	$record = CompanyProfile::where('field' ,'phone')->first();
    	$record->value = $phone_number;
    	$record->save();
    }

    private function setAddress($address)
    {
    	$record = CompanyProfile::where('field' ,'address')->first();
    	$record->value = $address;
    	$record->save();
    }

    public function setEmail($email)
    {
    	$record = CompanyProfile::where('field' ,'email')->first();
    	$record->value = $email;
    	$record->save();
    }
}
