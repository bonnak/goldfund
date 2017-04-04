<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CompanyProfile;

class CompanyProfileController extends Controller
{
    public function aboutUs()
    {
        return CompanyProfile::where('field', 'about-us')
                                ->first();
                                // ->mapWithKeys(function ($item) {
                                //     return [$item['field'] => $item['value']];
                                // });
    }

    public function updateAboutUs(Request $request)
    {
        $data = CompanyProfile::where('field', 'about-us')->first();

        if(is_null($data)) return response()->json(['error' => 'No data found.'], 422);

        $data->value = $request->value;
        $data->save();

        return response()->json(['msg' => 'Update successfully.'], 200);
    } 

    public function getData()
    {
    	return CompanyProfile::whereIn('field', [ 
                                'phone', 'address', 'email', 'bitcoin_address'
                            ])
                            ->get()
                			->mapWithKeys(function ($item) {
            				    return [$item['field'] => $item['value']];
            				});
    }

    public function update(Request $request)
    {
    	$this->setAddress($request->address);
    	$this->setEmail($request->email);
    	$this->setPhone($request->phone);
        $this->setBitcoinAddress($request->bitcoin_address);
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

    private function setEmail($email)
    {
    	$record = CompanyProfile::where('field' ,'email')->first();
    	$record->value = $email;
    	$record->save();
    }

    private function setBitcoinAddress($bitcoin_address)
    {
        $record = CompanyProfile::where('field' ,'bitcoin_address')->first();
        $record->value = $bitcoin_address;
        $record->save();
    }
}
