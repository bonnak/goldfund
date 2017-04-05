<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CompanyProfile;

class PageController extends Controller
{
	public function aboutUs()
    {
        return CompanyProfile::where('field', 'about-us')
                                ->first();
    }

    public function updateAboutUs(Request $request)
    {
        $data = CompanyProfile::where('field', 'about-us')->first();

        if(is_null($data)) return response()->json(['error' => 'No data found.'], 422);

        $data->value = $request->value;
        $data->save();

        return response()->json(['msg' => 'Update successfully.'], 200);
    } 


    public function whatIsForex()
    {
        return CompanyProfile::where('field', 'what-is-forex')
                                ->first();
    }

    public function updateWhatIsForex(Request $request)
    {
        $data = CompanyProfile::where('field', 'what-is-forex')->first();

        if(is_null($data)) return response()->json(['error' => 'No data found.'], 422);

        $data->value = $request->value;
        $data->save();

        return response()->json(['msg' => 'Update successfully.'], 200);
    } 
}
